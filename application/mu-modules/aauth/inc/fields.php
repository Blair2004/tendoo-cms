<?php
class aauth_fields extends CI_model
{
    public function __construct()
    {
        $this->events->add_filter('installation_fields', array( $this, 'installation_fields' ), 10, 1);
        // add action to display login fields
        $this->events->add_action('display_login_fields', array( $this, 'create_login_fields' ));
        $this->events->add_action('load_users_custom_fields', array( $this, 'user_custom_fields' ));
        $this->events->add_filter('displays_registration_fields', array( $this, 'registration_fields' ));
        $this->events->add_action('displays_public_errors', array( $this, 'public_errors' ));
        $this->events->add_action('displays_dashboard_errors', array( $this, 'displays_dashboard_errors' ));
        $this->events->add_filter('custom_user_meta', array( $this, 'custom_user_meta' ), 10, 1);
        $this->events->add_filter('recovery_fields', array( $this, 'recovery_fields' ));
    }
    public function recovery_fields()
    {
        ob_start();
        ?>
      <?php echo tendoo_info(__('Please provide your user email in order to get recovery email', 'aauth'));
        ?>
      <div class="input-group">
        <span class="input-group-addon" id="basic-addon1"><?php _e('User email or Pseudo', 'aauth');
        ?></span>
        <input type="text" class="form-control" placeholder="<?php _e('User email or Pseudo', 'aauth');
        ?>" aria-describedby="basic-addon1" name="user_email">
        <span class="input-group-btn">
          <button class="btn btn-default" type="submit"><?php _e('Get recovery Email', 'aauth');
        ?></button>
        </span>
      </div>
      <?php
        return ob_get_clean();
    }
    public function installation_fields($fields)
    {
        ob_start();
        ?>
      <div class="form-group has-feedback">
         <input type="text" class="form-control" placeholder="<?php _e('User Name', 'aauth');
        ?>" name="username" value="<?php echo set_value('username');
        ?>">
         <span class="glyphicon glyphicon-user form-control-feedback"></span>
       </div>
       <div class="form-group has-feedback">
         <input type="email" class="form-control" placeholder="<?php _e('Email', 'aauth');
        ?>" name="email" value="<?php echo set_value('email');
        ?>">
         <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
       </div>
       <div class="form-group has-feedback">
         <input type="password" class="form-control" placeholder="<?php _e('Password', 'aauth');
        ?>" name="password" value="<?php echo set_value('password');
        ?>">
         <span class="glyphicon glyphicon-lock form-control-feedback"></span>
       </div>
       <div class="form-group has-feedback">
         <input type="password" class="form-control" placeholder="<?php _e('Password confirm', 'aauth');
        ?>" name="confirm" value="<?php echo set_value('confirm');
        ?>">
         <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
       </div>
      <?php
        return $fields    .=    ob_get_clean();
    }
    public function create_login_fields()
    {
        // default login fields
        $this->config->set_item('signin_fields', array(
            'pseudo'    =>
            '<div class="form-group has-feedback">
				<input type="text" class="form-control" placeholder="' . __('Email or User Name', 'aauth') .'" name="username_or_email">
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>',
            'password'    =>
            '<div class="form-group has-feedback">
				<input type="password" class="form-control" placeholder="' . __('Password', 'aauth') .'" name="password">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>',
            'submit'    =>
            '<div class="row">
				<div class="col-xs-7">
				  <div class="checkbox icheck">
					<label>
					  <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false"><input type="checkbox" name="keep_connected"><ins class="iCheck-helper"></ins></div> ' . __('Remember me', 'aauth') . '
					</label>
				  </div>
				</div><!-- /.col -->
				<div class="col-xs-5">
				  <button type="submit" class="btn btn-primary btn-block btn-flat">' . __('Sign In', 'aauth') .'</button>
				</div><!-- /.col -->
			</div>'
        ));
    }
    public function public_errors()
    {
        $errors    =    $this->users->auth->get_errors_array();
        if ($errors) {
            foreach ($errors as $error) {
                echo tendoo_error($error);
            }
        }
    }
    public function registration_fields($fields)
    {
        ob_start();
        ?>
      <div class="form-group has-feedback">
         <input type="text" class="form-control" placeholder="<?php _e('User Name', 'aauth');
        ?>" name="username" value="<?php echo set_value('username');
        ?>">
         <span class="glyphicon glyphicon-user form-control-feedback"></span>
       </div>
       <div class="form-group has-feedback">
         <input type="email" class="form-control" placeholder="<?php _e('Email', 'aauth');
        ?>" name="email" value="<?php echo set_value('email');
        ?>">
         <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
       </div>
       <div class="form-group has-feedback">
         <input type="password" class="form-control" placeholder="<?php _e('Password', 'aauth');
        ?>" name="password">
         <span class="glyphicon glyphicon-lock form-control-feedback"></span>
       </div>
       <div class="form-group has-feedback">
         <input type="password" class="form-control" placeholder="<?php _e('Confirm', 'aauth');
        ?>" name="confirm">
         <span class="glyphicon glyphicon-lock  form-control-feedback"></span>
       </div>
       <div class="row">
         <div class="col-xs-8">
           <div class="checkbox icheck">
           </div>
         </div><!-- /.col -->
         <div class="col-xs-4">
           <button type="submit" class="btn btn-primary btn-block btn-flat"><?php _e('Sign Up', 'aauth');
        ?></button>
         </div><!-- /.col -->
       </div>
      <?php
        return $fields .= ob_get_clean();
    }

    /**
     * Adds custom fields for user creation and edit
     *
     * @access : public
     * @param : Array
     * @return : Array
    **/

    public function user_custom_fields($config)
    {
        $this->Gui->add_item(array(
            'type'        =>        'text',
            'name'        =>        'first-name',
            'label'        =>        __('First Name', 'aauth'),
            'value'        =>        riake('user_id', $config) ? $this->options->get('first-name', riake('user_id', $config)) : false
        ), $config[ 'meta_namespace' ], $config[ 'col_id' ]);

        $this->Gui->add_item(array(
            'type'        =>        'text',
            'name'        =>        'last-name',
            'label'        =>        __('Last Name', 'aauth'),
            'value'        =>        riake('user_id', $config) ? $this->options->get('last-name', riake('user_id', $config)) : false
        ), $config[ 'meta_namespace' ], $config[ 'col_id' ]);

        ob_start();
        $skin    =    riake('user_id', $config) ? $this->options->get('theme-skin', riake('user_id', $config)) : '';
        ?>
        <h3><?php _e('Select a theme', 'aauth');
        ?></h3>
        <ul class="list-unstyled clearfix theme-selector">
            <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-blue" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover <?php echo $skin == 'skin-blue' ? 'active' : '';
        ?>">
                <div><span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9;"></span><span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                <div><span style="display:block; width: 20%; float: left; height: 50px; background: #222d32;"></span><span style="display:block; width: 80%; float: left; height: 50px; background: #f4f5f7;"></span></div>
                </a>
                <p class="text-center no-margin"><?php _e('Blue', 'aauth');
        ?></p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-black" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover <?php echo $skin == 'skin-black' ? 'active' : '';
        ?>">
                <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix"><span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe;"></span><span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe;"></span></div>
                <div><span style="display:block; width: 20%; float: left; height: 50px; background: #222;"></span><span style="display:block; width: 80%; float: left; height: 50px; background: #f4f5f7;"></span></div>
                </a>
                <p class="text-center no-margin"><?php _e('Black', 'aauth');
        ?></p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-purple" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover <?php echo $skin == 'skin-purple' ? 'active' : '';
        ?>">
                <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span><span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                <div><span style="display:block; width: 20%; float: left; height: 50px; background: #222d32;"></span><span style="display:block; width: 80%; float: left; height: 50px; background: #f4f5f7;"></span></div>
                </a>
                <p class="text-center no-margin"><?php _e('Purple', 'aauth');
        ?></p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-green" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover <?php echo $skin == 'skin-green' ? 'active' : '';
        ?>">
                <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span><span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                <div><span style="display:block; width: 20%; float: left; height: 50px; background: #222d32;"></span><span style="display:block; width: 80%; float: left; height: 50px; background: #f4f5f7;"></span></div>
                </a>
                <p class="text-center no-margin"><?php _e('Green', 'aauth');
        ?></p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-red" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover <?php echo $skin == 'skin-red' ? 'active' : '';
        ?>">
                <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span><span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                <div><span style="display:block; width: 20%; float: left; height: 50px; background: #222d32;"></span><span style="display:block; width: 80%; float: left; height: 50px; background: #f4f5f7;"></span></div>
                </a>
                <p class="text-center no-margin"><?php _e('Red', 'aauth');
        ?></p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-yellow" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover <?php echo $skin == 'skin-yellow' ? 'active' : '';
        ?>">
                <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span><span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                <div><span style="display:block; width: 20%; float: left; height: 50px; background: #222d32;"></span><span style="display:block; width: 80%; float: left; height: 50px; background: #f4f5f7;"></span></div>
                </a>
                <p class="text-center no-margin"><?php _e('Yellow', 'aauth');
        ?></p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-blue-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover <?php echo $skin == 'skin-blue-light' ? 'active' : '';
        ?>">
                <div><span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9;"></span><span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                <div><span style="display:block; width: 20%; float: left; height: 50px; background: #f9fafc;"></span><span style="display:block; width: 80%; float: left; height: 50px; background: #f4f5f7;"></span></div>
                </a>
                <p class="text-center no-margin" style="font-size: 12px"><?php _e('Blue Light', 'aauth');
        ?></p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-black-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover <?php echo $skin == 'skin-black-light' ? 'active' : '';
        ?>">
                <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix"><span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe;"></span><span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe;"></span></div>
                <div><span style="display:block; width: 20%; float: left; height: 50px; background: #f9fafc;"></span><span style="display:block; width: 80%; float: left; height: 50px; background: #f4f5f7;"></span></div>
                </a>
                <p class="text-center no-margin" style="font-size: 12px"><?php _e('Black Light', 'aauth');
        ?></p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-purple-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover <?php echo $skin == 'skin-purple-light' ? 'active' : '';
        ?>">
                <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span><span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                <div><span style="display:block; width: 20%; float: left; height: 50px; background: #f9fafc;"></span><span style="display:block; width: 80%; float: left; height: 50px; background: #f4f5f7;"></span></div>
                </a>
                <p class="text-center no-margin" style="font-size: 12px"><?php _e('Purple Light', 'aauth');
        ?></p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-green-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover <?php echo $skin == 'skin-green-light' ? 'active' : '';
        ?>">
                <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span><span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                <div><span style="display:block; width: 20%; float: left; height: 50px; background: #f9fafc;"></span><span style="display:block; width: 80%; float: left; height: 50px; background: #f4f5f7;"></span></div>
                </a>
                <p class="text-center no-margin" style="font-size: 12px"><?php _e('Green Light', 'aauth');
        ?></p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-red-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover <?php echo $skin == 'skin-red-light' ? 'active' : '';
        ?>">
                <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span><span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                <div><span style="display:block; width: 20%; float: left; height: 50px; background: #f9fafc;"></span><span style="display:block; width: 80%; float: left; height: 50px; background: #f4f5f7;"></span></div>
                </a>
                <p class="text-center no-margin" style="font-size: 12px"><?php _e('Red Light', 'aauth');
        ?></p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-yellow-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover <?php echo $skin == 'skin-yellow-light' ? 'active' : '';
        ?>">
                <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span><span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                <div><span style="display:block; width: 20%; float: left; height: 50px; background: #f9fafc;"></span><span style="display:block; width: 80%; float: left; height: 50px; background: #f4f5f7;"></span></div>
                </a>
                <p class="text-center no-margin" style="font-size: 12px;"><?php _e('Yellow Light', 'aauth');
        ?></p>
            </li>
        </ul>
        <input type="hidden" name="theme-skin" value="<?php echo $skin;
        ?>" />
		<style>
        .theme-selector li a.active
        {
            opacity:1 !important;
            box-shadow:0px 0px 5px 2px #666 !important;
        }
        </style>
        <script>
        $( '.theme-selector li a' ).each(function(){
            $(this).bind( 'click' , function(){
                // remove active status
                $( '.theme-selector li a' ).each( function(){
                    $(this).removeClass( 'active' );
                });

                $(this).toggleClass( 'active' );
                $('input[name="theme-skin"]').val( $(this).data( 'skin' ) );
                // console.log( $(this).data( 'skin' ) );
            });
        })
        </script>
		<?php
        $dom    =    ob_get_clean();
        riake('gui', $config)->add_item(array(
            'type'        =>    'dom',
            'content'    =>    $dom
        ), $config[ 'meta_namespace' ], $config[ 'col_id' ]);
        // Clean
        unset($skin, $config, $dom);
    }

    /**
     * Displays Error on Dashboard Page
    **/

    public function displays_dashboard_errors()
    {
        $errors    =    $this->users->auth->get_errors_array();
        if ($errors) {
            foreach ($errors as $error) {
                echo tendoo_error($error);
            }
        }
    }

    /**
     * Adds custom meta for user
     *
     * @access : public
     * @param : Array
     * @return : Array
    **/

    public function custom_user_meta($fields)
    {
        $fields[ 'first-name' ]        =    ($fname = $this->input->post('first-name')) ? $fname : '';
        $fields[ 'last-name' ]        =    ($lname = $this->input->post('last-name')) ? $lname : '';
        $fields[ 'theme-skin' ]        =    ($skin    =    $this->input->post('theme-skin')) ? $skin : 'skin-blue';
        return $fields;
    }
}
new aauth_fields;
