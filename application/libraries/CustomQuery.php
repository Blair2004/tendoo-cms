<?php

/**
 * Class CustomQuery
 */
class CustomQuery
{
    /**
     * @type array
     */
    private $custom_queries = array(); // where every defined query are saved.

    /**
     * @type array
     */
    private $saved_meta = array();

    /**
     * @type array
     */
    private static $reserved_meta = array('TITLE',
                                          'CONTENT',
                                          'DATE',
                                          'AUTHOR',
                                          'NAMESPAACE',
                                          'ID',
                                          'PARENT_REF_ID',
                                          'POST_SLUG'
    );

    /**
     * @type
     */
    private $query_namespace;

    /**
     * @type bool
     */
    private $is_hierarchical = false;

    /**
     * @type bool|string
     */
    private $datetime;

    /**
     * @type
     */
    private $user_id;

    /**
     * @param $config
     */
    public function __construct($config)
    {
        $this->db              = get_instance()->db;
        $this->query_namespace = riake('namespace', $config, 'default'); // Default with title and content only.
        // meta should be given as array. Only new type of meta are accepted
        $given_meta            = riake('meta', $config, array());
        $this->is_hierarchical = riake('is_hierarchical', $config, false);

        foreach (force_array($given_meta) as $_given_meta) {
            $this->saved_meta[] = $_given_meta;
        }
        $this->datetime = date('Y-m-d'); // get_instance()->date->datetime();
        $this->user_id  = User::id();
    }

    /**
     *    Title Checker, from Blogster
     *    Checks whether a post already exist. Avoids title confusion by adding prefix to it.
     *
     * @accesss       :    Private
     *
     * @param        :    String (Title)
     **/

    private function title_checker($title, $exclude_post = 0)
    {
        // Fill Empty Title
        $title                    =    empty($title) ? __('Unamed Custom Post') : $title;
        // To avoid multiple post with the same title
        $i = 0;
        $query_data                =    array();
        while ($matching_post    =    $this->get(array(
            array( 'where'        =>    array( 'title'        =>        $title, 'id !='        =>        $exclude_post ) )
        ))) {
            $i++;
            if ($matching_post) {
                if (preg_match('#^(.+)\((\d{1,})\)+$#', $title)) {
                    $title = preg_replace_callback('/^(.+)\((\d{1,})\)*$/', function ($matches) {
                        $count = $matches[2] + 1;

                        return "$matches[1]" . '(' . "$count" . ')';
                    }, $title);
                } else {
                    $nbr = count($matching_post) + 1;
                    $title .= '(' . $nbr . ')';
                }
            } else {
                break;
            }
        }
        return $title;
    }

    /**
     *    Set (Create/Update) Custom Query
     *
     * @access        :    Public
     *
     * @param        :    String (Title), String (Content) , String/Int (ID/Custom Filter) , String (Filter Type)
     *
     * @param        $title
     * @param        $content
     * @param        $meta
     * @param        $taxonomies
     * @param        $status
     * @param int    $parent
     * @param string $mode
     * @param int    $identifier
     * @param string $filter
     *
     * @return array
     */

    public function set($title, $content, $meta, $taxonomies, $status, $parent = 0, $mode = 'set', $identifier = 0, $filter = 'as_id')
    {
        if (in_array($title, array(false,
                                  ''
        ), true)) {
            $title = __('Untitled');
        }
        if (in_array($content, array(false,
                                    ''
        ), true)) {
            $content = '';
        }
        // Don't allow post to be himself a parent
        if ($parent === $identifier && $this->is_hierarchical && $mode != 'set') {
            return array('msg' => 'incorrect-query-parent');
        }

        // Meta are given as array
        if (!is_array($meta)) {
            return array('msg' => 'incorrect-given-meta');
        }

        // Meta key is not white listed
        /**
         * foreach( array_keys( force_array( $meta ) ) as $meta_key )
         * {
         * if( ! in_array( $meta_key , $this->saved_meta ) )
         * {
         * return array( 'msg'        =>    'incorrect-key-given' );
         * }
         * }
         **/

        $safe_taxonomies = array();

        foreach (force_array($taxonomies) as $tax_namespace => $taxs) {
            foreach ($taxs as $tax_id) {
                if (!$this->taxonomy_exists($tax_id)) {
                    return array('msg' => 'unknown-taxonomy-given');
                }
                $safe_taxonomies[] = $tax_id;
            }
        }
        // BeWare : This only accepts that identifier is an int.
        $title = $this->title_checker($title, $identifier);
        
        if (!$title) {
            return array('msg' => 'error-occured-while-checking-query-title');
        }
        // Saving Custom Query Only

        $CQ_data = array('TITLE'         => $title,
                         'POST_SLUG'    =>    url_slug($title),
                         'CONTENT'       => $content,
                         'AUTHOR'        => $this->user_id,
                         'PARENT_REF_ID' => $parent,
                         'STATUS'        => $status
        );

        if ($mode === 'set') {
            $CQ_data['DATE']      = $this->datetime;
            $CQ_data['NAMESPACE'] = $this->query_namespace;
            $this->db->insert('query', $CQ_data);

            $query  = $this->db->order_by('ID', 'desc')->get('query');
            $result = farray($query->result_array());
        } else {
            if ($filter === 'as_id') {
                $this->db->where('query.ID', $identifier);
            } elseif ($filter === 'as_taxonomy') {
            } elseif ($filter === 'as_date_before') {
            } elseif ($filter === 'as_date_after') {
            }
            $query  = $this->db->get('query');
            $result = farray($query->result_array());

            if (!$query) {
                return array('msg' => 'unknown-custom-query'
                );
            }

            $CQ_data['EDITED'] = $this->datetime;

            $this->db->where($this->db->dbprefix('query') . '.ID', riake('ID', $result));
            $this->db->where($this->db->dbprefix('query') . '.NAMESPACE', $this->query_namespace);
            $this->db->update($this->db->dbprefix('query'), $CQ_data);

            // Delete Saved Taxonomies

            // $this->db->join($this->db->dbprefix('query_taxonomies'), $this->db->dbprefix('query_taxonomies') . '.ID = ' . $this->db->dbprefix('query_taxonomies_relationships') . '.TAXONOMY_REF_ID' );
            // $this->db->join( this->db->dbprefix('query') , this->db->dbprefix('query') . '.ID = ' . $this->db->dbprefix('query_taxonomies_relationships') . '.QUERY_REF_ID' );
            $this->db->where($this->db->dbprefix('query_taxonomies_relationships') . '.QUERY_REF_ID', riake('ID', $result));
            $this->db->delete($this->db->dbprefix('query_taxonomies_relationships'));

            // Delete previous meta
            $this->db->where('QUERY_REF_ID', riake('ID', $result))->delete($this->db->dbprefix('query_meta'));
        }

        // Saving Custom Query Taxonomies
        // Restoring Taxonomies
        // Getting Custom Query in order to use ID instead of filter given

        foreach (force_array($safe_taxonomies) as $tax_id) {
            $taxonomy = farray($this->__get_taxonomies($tax_id));

            $this->db->insert($this->db->dbprefix('query_taxonomies_relationships'), array(    'TAXONOMY_REF_ID' => riake('ID', $taxonomy),
                                                                                            'QUERY_REF_ID'    => riake('ID', $result)
            ));
        }
        // Saving Meta
        // Save new ones
        foreach (force_array($meta) as $key => $value) {
            $this->db->insert($this->db->dbprefix('query_meta'), array(    'QUERY_REF_ID' => riake('ID', $result),
                                                                        'KEY'          => $key,
                                                                        'VALUE'        => $value
            ));
        }

        return array('msg' => 'custom-query-saved',
                     'id'  => riake('ID', $result)
        );
    }

    /**
     *    Returns an array of each sub-post id, for each specified post_id
     *
     * @access        :    Public
     *
     * @param        :    Int( post id )
     *
     * @param $post_id
     *
     * @return array :    array (array of post id)
     */
    public function get_post_legacy($post_id)
    {
        $post_array    =    array();
        
        $post_child    =    $this->get(array(
            array( 'where' =>    array( 'parent_id' => $post_id ) )
        ));
                
        $child_array        =    array();
        
        foreach (force_array($post_child) as $_childs) {
            $post_array[]    =    riake('QUERY_ID', $_childs);
            $post_array        =    array_merge($post_array, $this->get_post_legacy(riake('QUERY_ID', $_childs)));
        }

        return $post_array;
    }

    /**
     *    Get data from custom query
     * @access        :    public
     *
     * @param        :    Array/String
     *
     * @return        :    Array/Boolean
     **/
    private $get_errors_code = array('unknown-key-for-custom-query'
    );

    /**
     * @type array
     */
    private $custom_filter = array('taxonomy_id',
                                   'parent_id'
    );

    /**
     * @param array $arg
     *
     * @return bool|string
     */
    public function get($arg = array())
    {
        // To avoid MySQL Query crash
        $return = false;
        // Filter Namespace
        $this->db->select('
		*,
		' .$this->db->dbprefix . 'query.ID as QUERY_ID
		');
        $this->db->from($this->db->dbprefix('query'));
        $this->db->join($this->db->dbprefix('query_meta'), $this->db->dbprefix('query') . '.ID = ' . $this->db->dbprefix('query_meta') . '.QUERY_REF_ID', 'left');
        $this->db->join($this->db->dbprefix('query_taxonomies_relationships'), $this->db->dbprefix('query_taxonomies_relationships') . '.QUERY_REF_ID = ' . $this->db->dbprefix('query') . '.ID', 'left');
        // $this->db->join( 'tendoo_query_taxonomies' , 'tendoo_query_taxonomies.ID = tendoo_query_taxonomies_relationships.TAXONOMY_REF_ID' , 'right' );
        $this->db->where($this->db->dbprefix('query') . '.NAMESPACE', $this->query_namespace);
        $this->db->group_by($this->db->dbprefix('query') . '.ID'); // For unique Lignes
        //
        foreach ($arg as $_arg) {
            foreach (force_array($_arg) as $filter => $value) {
                if (in_array($filter, array('limit',
                                            'LIMIT'
                ), true)) {
                    $this->db->limit(riake('end', $value), riake('start', $value));
                } else {
                    foreach (array_keys($value) as $array_key) {
                        $array_key_complete = $array_key;
                        $array_key          = explode(' ', $array_key);
                        // Avoid tu use comparison sign for meta comparison
                        if (count($array_key) > 0) {
                            $array_key = $array_key[0];
                        }
                        if (!in_array(strtolower($array_key), $this->saved_meta) && !in_array(strtoupper($array_key), self::$reserved_meta) && !in_array($array_key, $this->custom_filter)) {
                            $return = 'unknown-key-for-custom-query';
                        }
                    }
    
                    if (in_array($filter, array('where',
                                                'WHERE'
                    ), true)) {
    
                        // Value must be an array of key value
                        /**
                         * CUSTOMQUERY::get( array(
                         * 'where'    =>    array( 'id'    =>    10 ),
                         * 'where'    =>    array( 'id'    =>    20 ),
                         * 'where'    =>    array( 'id >'    =>    20 )
                         * ) );
                         **/
                        foreach ($value as $__key => $__value) {
                            $key            = explode(' ', $__key);
                            $__key_complete = $__key;
                            // Avoid to use comparison sign on key for meta comparison
                            if (count($key) > 0) {
                                $__key = $key[0];
                            }
                            // For reserved Meta
                            if (in_array(strtoupper($__key), self::$reserved_meta)) {
                                if (is_array($__value)) {
                                    /**
                                     * array_walk( function( $array ){
                                     * var_dump( $array );
                                     * die;
                                     * } , $__value );
                                     **/
                                }
                                // For reserved Meta
                                if (in_array(strtoupper($__key), self::$reserved_meta)) {
                                    $this->db->where('query.' . strtoupper($__key_complete), $__value);
                                }
                            } elseif (in_array(strtolower($__key), $this->custom_filter)) {
                                if ($__key === 'taxonomy_id') {
                                    $this->db->where('query_taxonomies_relationships.TAXONOMY_REF_ID', $__value);
                                } elseif ($__key === 'parent_id') {
                                    $this->db->where('query.PARENT_REF_ID', $__value);
                                }
                            } else {
                                $this->db->where('query_meta.KEY', $__key_complete)->where('query_meta.VALUE', $__value);
                            }
                        }
                    } elseif (in_array($filter, array('or_where',
                                                    'OR_WHERE'
                    ), true)) {
                        // Value must be an array of key value
                        foreach ($value as $__key => $__value) {
                            $key            = explode(' ', $__key);
                            $__key_complete = $__key;
                            // Avoid tu use comparison sign for meta comparison
                            if (count($key) > 0) {
                                $__key = $key[0];
                            }
                            // For reserved Meta
                            if (in_array(strtoupper($__key), self::$reserved_meta)) {
                                $this->db->or_where('query.' . strtoupper($__key_complete), $__value);
                            } elseif (in_array(strtolower($__key), $this->custom_filter)) {
                                if ($__key === 'taxonomy_id') {
                                    $this->db->where('query_taxonomies_relationships.TAXONOMY_REF_ID', $__value);
                                } elseif ($__key === 'parent_id') {
                                    $this->db->where('query.PARENT_REF_ID', $__value);
                                }
                            }
                            if (is_array($__value) && count($__value) == 2) {
                                $this->db->or_where('query_meta.KEY', $__key_complete)->where('query_meta.VALUE', $__value);
                            }
                        }
                    }
                }
            }
        }

        $CQ_query_1 = $this->db->get();
        $CQ_result  = $CQ_query_1->result_array();

        // Before Proceed, check if $return has an error

        if ($return !== false): return $return;
        endif;

        // Fetching All Meta
        foreach ($CQ_result as $CQ_key => &$__CQ_result) {
            $CQ_meta_query  = $this->db->where('QUERY_REF_ID', riake('QUERY_ID', $__CQ_result))->get('query_meta');
            $CQ_meta_result = $CQ_meta_query->result_array();

            foreach ($CQ_meta_result as $__CQ_meta_result) {
                $CQ_result[$CQ_key][riake('KEY', $__CQ_meta_result)] = riake('VALUE', $__CQ_meta_result);
            }
            unset($CQ_result[$CQ_key]['KEY'], $CQ_result[$CQ_key]['VALUE']); // No more necessary

            // Getting Taxonomy
            $this->db->select('query_taxonomies.ID as TAXONOMY_ID');
            $this->db->from('query_taxonomies');
            $this->db->join('query_taxonomies_relationships', 'query_taxonomies_relationships.TAXONOMY_REF_ID = ' . $this->db->dbprefix . 'query_taxonomies.ID', 'left');
            $CQ_taxonomy_query  = $this->db->where('query_taxonomies_relationships.QUERY_REF_ID', riake('QUERY_REF_ID', $__CQ_result))->get();
            $CQ_taxonomy_result = $CQ_taxonomy_query->result_array();

            foreach ($CQ_taxonomy_result as $__CQ_taxonomy_result) {
                $CQ_result[$CQ_key]['TAXONOMIES'][] = riake('TAXONOMY_ID', $__CQ_taxonomy_result);
            }
            unset($CQ_result[$CQ_key]['TAXONOMY_REF_ID']); // No more necessary
        }

        return $CQ_result;
    }

    /**
     *    Delete Custom Query
     *
     *
     **/
    public function delete($id)
    {
        $custom        =    $this->get(array(
            array( 'where'    =>    array( 'id' => $id ) )
        ));
        
        if ($custom) {
            $query_id = $custom[0]['ID'];
            // Removing Query
            $this->db->where('query.ID', $query_id);
            $this->db->delete('query');

            // Removing Taxonomies
            $this->db->where('query_taxonomy_relationship.QUERY_REF_ID', $query_id);
            $this->db->delete('query_taxonomy_relationship');

            return 'custom-query-deleted';
        }

        return 'unknown-custom-query';
    }

    /**
     *    Custom Query Exist
     *
     **/

    public function custom_query_exists($identifier, $filter = 'as_title')
    {
        $_filter = 'id';
        if ($filter == 'as_title') {
            $_filter = 'title';
        }
        return $this->get(array(
            array( 'where' =>    array( $_filter, $identifier ) )
        ));
    }

    /**
     *    Define Taxonomy for custom query
     * @access        :    Public
     *
     * @param        :    String (Namespace)
     * @param        :    String (Title)
     * @param        :    Array    (Config)
     *
     * @return        :    null
     **/
    private $default_taxonomy_config = array('is_hierarchical' => false
    );

    /**
     * @type array
     */
    private $taxonomies_config = array();

    /**
     * @param       $namespace
     * @param       $title
     * @param array $config
     */
    public function define_taxonomy($namespace, $title, $config = array())
    {
        $config                              = !$config ? $this->default_taxonomy_config : $config;
        $this->taxonomies_config[$namespace] = array('title'               => $title,
                                                     'namespace'           => $namespace,
                                                     'is-hierarchical'     => riake('is-hierarchical', $config, true),
                                                     'new-taxonomy-label'  => riake('new-taxonomy-label', $config, sprintf(__('New %s'), $namespace)),
                                                     'edit-taxonomy-label' => riake('edit-taxonomy-label', $config, sprintf(__('Edit %s'), $namespace)),
                                                     'taxonomy-list-label' => riake('taxonomy-list-label', $config, sprintf(__('%s list'), $namespace)),
        );
    }

    /**
     *    Set Taxonomy for cutom Query
     *
     * @access        :    Public
     *
     * @param        :    String (Namespace)
     * @param        :    String (Title)
     * @param        :    String    (Description)
     * @param        :    Int (Parent Id)
     *
     * @return        :    String (result code)
     **/

    public function set_taxonomy($namespace, $title, $content, $parent_id = null)
    {
        $taxonomy_data = array('NAMESPACE'       => $namespace,
                               'QUERY_NAMESPACE' => $this->query_namespace,
                               'TITLE'           => $title,
                               'CONTENT'         => $content,
                               'DATE'            => $this->datetime,
                               'AUTHOR'          => $this->user_id
        );

        // If hierarchy is supported

        if (riake('is_hierarchical', $this->taxonomies_config[$namespace]) && $parent_id != null) {
            $taxonomy_data['PARENT_REF_ID'] = $parent_id;
        }

        // Only checks taxonomy parent existence if that one is provided
        if (!$this->taxonomy_exists($parent_id) && $parent_id != null) {
            return 'unknown-taxonomy-to-set-as-parent';
        }

        if (!$this->has_taxonomy($namespace, $title)) {
            $this->db->insert('query_taxonomies', $taxonomy_data);

            return 'taxonomy-set';
        }

        return 'taxonomy-already-exists';
    }

    /**
     * Get defined taxonomy for post type
     *
     **/

    public function get_defined_taxonomies()
    {
        return $this->taxonomies_config;
    }

    /**
     *    Checks if specific taxonomy exist, uses title as filter
     *
     * @access        :    public
     *
     * @param        :    String (Title)
     *
     * @return        :    Bool
     **/

    public function has_taxonomy($namespace, $title)
    {
        $query = $this->db->where('TITLE', $title)->where('NAMESPACE', $namespace)->where('QUERY_NAMESPACE', $this->query_namespace)->get('query_taxonomies');

        return $query->result_array();
    }

    /**
     *    Checks if a taxonomy exists, uses id as filter
     *
     * @access        :    Public
     *
     * @param        :    Int (ID)
     *
     * @return        :    Array
     **/

    public function taxonomy_exists($id)
    {
        $query = $this->db->where('ID', $id)// ->where( 'NAMESPACE' , $namespace )
                          ->where('QUERY_NAMESPACE', $this->query_namespace)->get('query_taxonomies');

        return $query->result_array();
    }

    /**
     *    Checks if taxonomy is defined
     *
     * @access        :    Public
     *
     * @param        :    String (Namespace)
     **/

    public function taxonomy_is_defined($taxonomy_namespace)
    {
        if (riake($taxonomy_namespace, $this->taxonomies_config)) {
            return true;
        }

        return false;
    }

    /**
     *    Update Tax
     *
     * @access        :    Public
     *
     * @param        :    String (Title)
     * @param        :    String (Content)
     * @param        :    String (Namespace)
     * @param        :    String/Int (Identifier)
     * @param        :    String (Filter)
     *
     * @return        :    Bool
     **/

    public function update_taxonomy($namespace, $title, $content, $identifier, $parent_id = null, $filter = 'as_id')
    {
        $taxonomy_data = array('NAMESPACE'       => $namespace,
                               'QUERY_NAMESPACE' => $this->query_namespace,
                               'TITLE'           => $title,
                               'CONTENT'         => $content,
                               'DATE'            => $this->datetime,
                               'AUTHOR'          => $this->user_id
        );

        // If hierarchy is supported

        if (riake('is_hierarchical', $this->taxonomies_config[$namespace]) && $parent_id != null) {
            if (!$this->taxonomy_exists($parent_id)) {
                return 'unknown-taxonomy';
            }
            $taxonomy_data['PARENT_REF_ID'] = $parent_id;
        }

        if ($filter == 'as_id') {
            if ($parent_id == $identifier) {
                return 'taxonomy-cant-be-his-own-parent';
            }
            $this->db->where('ID', $identifier);
        }

        return $query = $this->db->where('NAMESPACE', $namespace)->where('QUERY_NAMESPACE', $this->query_namespace)->update('query_taxonomies', $taxonomy_data);
    }

    /**
     *    Get taxonomy
     *
     * @access        :    Public
     *
     * @param        :    String (Namespace)
     * @param        :    String/Int (Start offset/Title)
     * @param        :    String/Int (End Offset/filter)
     *
     * @return        :    Array
     **/

    public function get_taxonomies($namespace, $start = null, $end = null)
    {
        if (is_numeric($start) && is_numeric($end)) {
            $this->db->limit($end, $start);
        } elseif ($end === 'as_id') {
            $this->db->where('ID', $start);
        } elseif ($end === 'as_excluded_id') {
            $this->db->where('ID !=', $start);
        } elseif ($end === 'as_query_id') {
            $this->db->join('query_taxonomies_relationships', $this->db->dbprefix . 'query_taxonomies.ID = ' . $this->db->dbprefix . 'query_taxonomies_relationships.TAXONOMY_REF_ID', 'left');
            $this->db->where('query_taxonomies_relationships.QUERY_REF_ID', $start);
        }

        $query = $this->db->where('NAMESPACE', $namespace)->where('QUERY_NAMESPACE', $this->query_namespace)->get('query_taxonomies');

        return $query->result_array();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    private function __get_taxonomies($id)
    {
        $query = $this->db->where('ID', $id)->where('QUERY_NAMESPACE', $this->query_namespace)->get('query_taxonomies');

        return $query->result_array();
    }

    /**
     *    Delete Taxonomy
     *
     * @access        :    Public
     *
     * @param        :    Int (ID)
     *
     * @return        :    String/Array
     **/

    public function delete_taxonomies($id)
    {
        if (is_array($id)) {
            $notice = array();
            foreach ($id as $_id) {
                $notices[] = $this->delete_taxonomies($_id);
            }

            return $notices;
        } else {
            if (($taxonomy = farray($this->taxonomy_exists($id))) == true and !$this->taxonomy_is_bound($id)) {
                if (count($this->get_taxonomies(riake('NAMESPACE', $taxonomy))) > 1) {
                    $this->db->where('ID', $id)// ->where( 'NAMESPACE' , $namespace ) Not necessary
                             ->where('QUERY_NAMESPACE', $this->query_namespace)->delete('query_taxonomies');

                    return 'taxonomy-deleted';
                }

                return 'cant-delete-the-latest-taxonomy';
            }

            return 'taxonomy-not-found-or-bound';
        }
    }

    /**
     *    Checks if a specific taxonomy is bound
     *
     * @access        :    Public
     *
     * @param        :    Int (ID)
     *
     * @return        :    Bool
     **/

    public function taxonomy_is_bound($id)
    {
        $query    =    $this->get(array(
            array( 'where'    =>    array( 'taxonomy_id'    => $id ) )
        ));
        return $query ? true : false;
    }

    /**
     *    Count custom queries bound to taxonomy
     *
     * @access        :    Public
     *
     * @param        :    Int (ID)
     *
     * @return        :    Int
     **/

    public function count_queries_bound($namespace)
    {
        $this->db->where('query_taxonomies', $namespace);
        $this->db->join('query', $this->db->dbprefix . 'query_taxonomies_relationships.QUERY_REF_ID = ' . $this->db->dbprefix . 'query.ID', 'inner');
        $this->db->join('taxonomies', $this->db->dbprefix . 'query_taxonomies_relationships.TAXONOMY_REF_ID = ' . $this->db->dbprefix . 'taxonomies.ID', 'inner');
        $this->db->group_by('query_taxonomies.ID');
        $query = $this->db->get('taxonomies_relationships');

        return $query->resulat_array();
    }

    /**
     * Get bound comment to a specific post
     *
     * @acess         :    Public
     *
     * @param        :    String(Post Namespace), Array(Config)
     *
     * @return        :    Array
     **/

    public function get_comments($config = array())
    {
        $this->db->where('QUERY_NAMESPACE', $this->query_namespace);
        if (is_array($config)) {
            foreach ($config as $tag => $values) {
                if (strtolower($tag) == 'where') {
                    if (is_array($values)) {
                        foreach ($values as $_key => $_value) {
                            if ($_key == 'post_id') {
                                // Custom Search

                                $this->db->where('post_id', $_value);
                            } else {
                                $this->db->where(strtoupper($_key), $_value); // to allow upper case for normal filter
                            }
                        }
                    }
                }
            }
            if (riake('limit', array_keys($config))) {
                $this->db->limit(riake('end', $config['limit']), riake('start', $config['limit']));
            }
        }
        $query = $this->db->get('query_comments');

        return $query->result_array();
    }

    /**
     *    Create a comment for a specifc post and post type
     *
     * @access        :    public
     *
     * @param        :    string (post namespace), int( post id ), int ( author id if is connected ), string (comment content), int (comment parent id), string (author name), string (author email)
     *
     * @return        :    string (response of the operation)
     **/

    public function post_comment($post_id, $content, $author = false, $mode = 'create', $comment_id = null, $author_name = '', $author_email = '', $reply_to = false)
    {
        // check if post exists

        $post    =    $this->get(array(
            array( 'where'    =>    array( 'id' =>    $post_id ) )
        ));
        
        if ($post) {
            // if it doesn't return an empty array

            $comment_array    =    array(
                'QUERY_NAMESPACE'    =>    $this->query_namespace,
                'COMMENTS'            =>    $content,
                'DATE'                =>    $this->datetime,
            );

            // if reply_to == false, skipt

            if ($reply_to !== false) {
                if ($comment = $this->get_comments($this->query_namespace, array('id' => $reply_to
                ))
                ) : // if parent comment exists

                    $comment_array['REPLY_TO'] = $reply_to;

                endif; // end of if parent comment exists
            }

            // use default name and email provided

            $comment_array['AUTHOR_NAME']  = $author_name;
            $comment_array['AUTHOR_EMAIL'] = $author_email;

            // getting user if set

            if ($author !== false) {
                if (($user = get_user('as_id', $author)) == false) {
                    return 'unknown-user';
                }

                // overwrite author email and name

                $comment_array['AUTHOR']       = $author;
                $comment_array['AUTHOR_NAME']  = riake('NAME', $user, __('Not Set'));
                $comment_array['AUTHOR_EMAIL'] = riake('EMAIL', $user, __('Not Set'));
            }

            // Checkfs if auto publish is allowed (for registered user) to edit comment status

            if ($mode == 'create') {
                $this->db->insert('query_comments', $comment_array);
            } elseif ($mode == 'edit') {
                $this->db->where('ID', $comment_id)->update('query_comments', $comment_array);
            }

            return 'comment-submitted';
        }

        return 'unknown-post';
    }

    /**
     *  Delete a comment
     *
     * @access    :    Public
     *
     * @param    :    int (comment id)
     *
     * @return    :    string (response of the operation)
     **/

    public function delete_comment($id, $filter = 'as_id')
    {
        if ($filter == 'as_id') {
            $comment = $this->get_comments(array('where' => array('id' => $id)
                                           ));
            if ($comment) {
                $this->db->where('ID', $id)->delete('query_comments');
            }

            return 'comment-deleted';
        }
    }

    /**
     *    Edit comment status
     *
     * @access        :    Public
     *
     * @param        :    int (comment id), int (status 0:draft, 1:publish, 2:trash, 3:trash)
     **/

    public function comment_status($id, $status = 0)
    {
        if (!between(0, 4, $status)):
            return 'unknown-status';
        endif;

        $comments = $this->get_comments(array('where' => array('id' => $id)
                                        ));

        // check if use can edit comment status

        if ($comments) {
            $this->db->where('ID', $id)->update('query_comments', array('STATUS' => $status));

            return 'comment-edited';
        }

        return 'unknown-comment';
    }

    /**
     *  Set custom Status
     *
     * @access    :    Public
     *
     * @param    :    int( Status tu convert to string )
     **/

    public function get_status($int)
    {
        switch (( int ) $int) {
            case 0 :
                return __('Draft');
                break;
            case 1 :
                return __('Published');
                break;
            case 2 :
                return __('Pending');
                break;
            case 3 :
                return __('Trash');
                break;
            case 4 :
                return __('Disapproved');
                break;
        }

        return __('Unknow status');
    }
}
