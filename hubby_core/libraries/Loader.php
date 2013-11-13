<?php
class Loader
{
	private $loadedLibrary;
	private $loadedHelper;
	private $loadedFile;
	private $instance;
	private $viewpath;
	private $_vars_caches;
	private $_hubby_ob_level;
	public 	$module;
	public function __construct()
	{
		$this->loadedLibrary		=	array();
		$this->loadedHelper			=	array();
		$this->library_path			=	array();
		$this->hubby_vue_dir		=	array(VIEWS_DIR => TRUE);
		$this->hubby_mod_vue_dir	=	array(MODULES_DIR => TRUE);
		$this->hubby_main_dir		=	array('' => TRUE);
		$this->hubby_vars_caches	=	array();
		$this->core					=	Controller::instance();
	}
	public function view($path,$array = NULL,$return = false, $load_from_main_dir = FALSE)
	{
		if($load_from_main_dir == FALSE)
		{
			return $this->load_ext(array('_hubby_view' => $path, '_hubby_vars' => $this->object_to_array($array), '_hubby_return' => $return),FALSE);
		}
		else
		{
			return $this->load_ext(array('_hubby_view' => $path, '_hubby_vars' => $this->object_to_array($array), '_hubby_return' => $return),TRUE);
		}
	}
	protected function object_to_array($object)
	{
		return (is_object($object)) ? get_object_vars($object) : $object;
	}
	private function load_ext($data,$lfmd)
	{
		// Set the default data variables
		foreach (array('_hubby_view', '_hubby_vars', '_hubby_path', '_hubby_return') as $_values)
		{
			$$_values = ( ! isset($data[$_values])) ? FALSE : $data[$_values];
		}
		$file_exists = FALSE;
		// Set the path to the requested file
		if ($_hubby_path != '')
		{
			$_hubby_x = explode('/', $_hubby_path);
			$_hubby_file = end($_hubby_x);
		}
		else
		{
			$_hubby_ext = pathinfo($_hubby_view, PATHINFO_EXTENSION);
			$_hubby_file = ($_hubby_ext == '') ? $_hubby_view.'.php' : $_hubby_view;
			if($lfmd == TRUE)
			{
				foreach ($this->hubby_main_dir as $view_file => $cascade)
				{
					if (file_exists($_hubby_file))
					{
						$_hubby_path = $_hubby_file;
						$file_exists = TRUE;
						break;
					}
	
					if ( ! $cascade)
					{
						break;
					}
				}
			}
			else
			{
				foreach ($this->hubby_vue_dir as $view_file => $cascade)
				{
					if (file_exists($view_file.$_hubby_file))
					{
						$_hubby_path = $view_file.$_hubby_file;
						$file_exists = TRUE;
						break;
					}
	
					if ( ! $cascade)
					{
						break;
					}
				}
			}
		}

		if ( ! $file_exists && ! file_exists($_hubby_path))
		{
			show_error('Unable to load the requested file: '.$_hubby_file);
		}

		// This allows anything loaded using $this->load (views, files, etc.)
		// to become accessible from within the Controller and Model functions.
		foreach (get_object_vars($this->core) as $_hubby_key => $_hubby_var)
		{
			if ( ! isset($this->$_hubby_key))
			{
				$this->$_hubby_key =& $_hubby_hubby->$_hubby_key;
			}
		}

		/*
		 * Extract and cache variables
		 *
		 * You can either set variables using the dedicated $this->load_vars()
		 * function or via the second parameter of this function. We'll merge
		 * the two types and cache them so that views that are embedded within
		 * other views can have access to these variables.
		 */
		if (is_array($_hubby_vars))
		{
			$this->hubby_vars_caches = array_merge($this->hubby_vars_caches, $_hubby_vars);
		}
		extract($this->hubby_vars_caches);

		/*
		 * Buffer the output
		 *
		 * We buffer the output for two reasons:
		 * 1. Speed. You get a significant speed boost.
		 * 2. So that the final rendered template can be
		 * post-processed by the output class.  Why do we
		 * need post processing?  For one thing, in order to
		 * show the elapsed page load time.  Unless we
		 * can intercept the content right before it's sent to
		 * the browser and then stop the timer it won't be accurate.
		 */
		ob_start();

		// If the PHP installation does not support short tags we'll
		// do a little string replacement, changing the short tags
		// to standard PHP echo statements.

		if ((bool) @ini_get('short_open_tag') === FALSE)
		{
			echo eval('?>'.preg_replace("/;*\s*\?>/", "; ?>", str_replace('<?=', '<?php echo ', file_get_contents($_hubby_path))));
		}
		else
		{
			include($_hubby_path); // include() vs include_once() allows for multiple views with the same name
		}

		log_message('debug', 'File loaded: '.$_hubby_path);

		// Return the file data if requested
		if ($_hubby_return === TRUE)
		{
			$buffer = ob_get_contents();
			@ob_end_clean();
			return $buffer;
		}

		/*
		 * Flush the buffer... or buff the flusher?
		 *
		 * In order to permit views to be nested within
		 * other views, we need to flush the content back out whenever
		 * we are beyond the first level of output buffering so that
		 * it can be seen and included properly by the first included
		 * template and any subsequent ones. Oy!
		 *
		 */
		if (ob_get_level() > $this->_hubby_ob_level + 1)
		{
			ob_end_flush();
		}
		else
		{
			$_hubby_hubby->output->append_output(ob_get_contents());
			@ob_end_clean();
		}
	}
	public function library($library = '', $params = NULL, $object_name = NULL)
	{
		if (is_array($library))
		{
			foreach ($library as $class)
			{
				$this->library($class, $params);
			}

			return;
		}

		if ($library == '' OR isset($this->_base_classes[$library]))
		{
			return FALSE;
		}

		if ( ! is_null($params) && ! is_array($params))
		{
			$params = NULL;
		}

		$this->_load_class($library, $params, $object_name);
	}
	protected function _load_class($class, $params = NULL, $object_name = NULL)
	{
		// Get the class name, and while we're at it trim any slashes.
		// The directory path can be included as part of the class name,
		// but we don't want a leading slash
		$class = str_replace('.php', '', trim($class, '/'));
		// Was the path included with the class name?
		// We look for a slash to determine this
		$subdir = '';
		if (($last_slash = strrpos($class, '/')) !== FALSE)
		{
			// Extract the path
			$subdir = substr($class, 0, $last_slash + 1);

			// Get the filename from the path
			$class = substr($class, $last_slash + 1);
		}
		// We'll test for both lowercase and capitalized versions of the file name
		foreach (array(ucfirst($class), strtolower($class)) as $class)
		{
			$subclass = LIBRARIES_DIR.$subdir.$class.'.php';
			// Is this a class extension request?
			if (file_exists($subclass))
			{
				// Safety:  Was the class already loaded by a previous call?
				if (in_array($subclass, $this->loadedLibrary))
				{
					// Before we deem this to be a duplicate request, let's see
					// if a custom object name is being supplied.  If so, we'll
					// return a new instance of the object
					if ( ! is_null($object_name))
					{
						if ( ! isset($this->core->$object_name))
						{
							return $this->init_class($class, $params, $object_name);
						}
					}

					$is_duplicate = TRUE;
					log_message('debug', $class." class already loaded. Second attempt ignored.");
					return;
				}
				include_once($subclass);
				$this->loadedLibrary[] = $class;
				$this->loadedFile[] = $subclass;

				return $this->init_class($class, $params, $object_name);
			}
			else
			{
			// Lets search for the requested library file and load it.
			$is_duplicate = FALSE;
			
				$filepath = LIBRARIES_DIR.$subdir.$class.'.php';
				// Does the file exist?  No?  Bummer...
				if ( ! file_exists($filepath))
				{
					continue;
				}

				// Safety:  Was the class already loaded by a previous call?
				if (in_array($filepath, $this->loadedFile))
				{
					// Before we deem this to be a duplicate request, let's see
					// if a custom object name is being supplied.  If so, we'll
					// return a new instance of the object
					if ( ! is_null($object_name))
					{
						if ( ! isset($this->core->$object_name))
						{
							return $this->init_class($class, $params, $object_name);
						}
					}

					$is_duplicate = TRUE;
					log_message('debug', $class." class already loaded. Second attempt ignored.");
					return;
				}

				include_once($filepath);
				$this->loadedFile[] = $filepath;
				return $this->init_class($class, $params, $object_name);
			}

		} // END FOREACH
	}
	protected function init_class($class, $params, $object_name = NULL)
	{
		// Is there an associated config file for this class?  Note: these should always be lowercase
		$name = $class;

		// Is the class name valid?
		if ( ! class_exists($name))
		{
			log_message('error', "Non-existent class: ".$name);
			show_error("Non-existent class: ".$class);
		}
		// Set the variable name we will assign the class to
		// Was a custom class name supplied?  If so we'll use it
		$class = strtolower($class);

		if (is_null($object_name))
		{
			$classvar = ( ! isset($this->_ci_varmap[$class])) ? $class : $this->_ci_varmap[$class];
		}
		else
		{
			$classvar = $object_name;
		}
		// Save the class name and object name
		$this->_ci_classes[$class] = $classvar; // ? seems to be unused

		// Instantiate the class
		if (is_array($params))
		{
			$this->core->$classvar = new $name($params);
		}
		else
		{
			$this->core->$classvar 	= new $name;
		}
	}
	public function helper($helper	= array())
	{
		if(is_array($helper))
		{
			foreach ($helper as $h)
			{
				$this->helper_includer($h);
			}
		}
		else
		{
			$this->helper_includer($helper);
		}
	}
	public function helper_includer($h)
	{
		if(file_exists(HELPERS_DIR.$h.'.php'))
		{
			include_once(HELPERS_DIR.$h.'.php');
			array_push($this->loadedHelper,$h);
		}
	}
	public function is_loaded($mixed_values)
	{
		if(in_array(ucwords($mixed_values),$this->loadedLibrary))
		{
			return $mixed_values;
		}
		return false;
	}
}
