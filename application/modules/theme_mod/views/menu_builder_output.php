<form method="post">
<div class="row">
  <div class="col-lg-6">
    <div class="input-group">
      <span class="input-group-btn">
        <button class="btn btn-default" id="create_menu" type="submit"><?php _e ( 'Create a menu' );?></button>
      </span>
      <input type="text" id="menu_name" class="form-control" placeholder="<?php _e( 'Menu Name, with no space nor special character' );?>">
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
  <div class="col-lg-6">
    <div class="input-group">
    	<span class="input-group-btn">
        <button id="delete_menu" class="btn btn-default" type="submit"><?php _e( 'Delete Selected Menu' );?></button>
      </span>
      <select id="menu_list" type="text" class="form-control" placeholder="Search for...">
			
      </select>
      <span class="input-group-btn">
        <button class="btn btn-default load_menu" type="submit"><?php _e( 'Load menu' );?></button>
      </span>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</div><!-- /.row -->
</form>
		
	<br />
    <div class="row">
        <div class="col-lg-6">
            <div class="dd" id="nestable">
                
            </div>
        </div>
        <div class="col-lg-6">
          <div class="box-group" id="accordion">
            <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
            <div class="panel box box-primary">
              <div class="box-header with-border">
                <h4 class="box-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    <?php _e( 'Create simple link' );?>
                  </a>
                </h4>
              </div>
              <div id="collapseOne" class="panel-collapse collapse in">
                <div class="box-body">
                    <form method="post">
                    <div class="input-group">
                      <span class="input-group-addon" id="basic-addon1"><?php _e( 'Link Label' );?></span>
                      <input type="text" name="link_label" class="form-control" placeholder="<?php _e( 'Link Label' );?>" aria-describedby="basic-addon1">
                    </div>
                    <br />
                    <div class="input-group">
                      <span class="input-group-addon" id="basic-addon1"><?php _e( 'Link URL' );?></span>
                      <input type="text" name="link_url" class="form-control" placeholder="<?php _e( 'Link URL' );?>" aria-describedby="basic-addon1">
                    </div>
                    <br />
                    <input type="submit" class="create_link btn btn-primary" value="<?php _e( 'Create Link' );?>" />
                    </form>
                    
                </div>
              </div>
            </div>
            <div class="panel box box-primary">
              <div class="box-header with-border">
                <h4 class="box-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#menulocations">
                    <?php _e( 'Menu Locations' );?>
                  </a>
                </h4>
              </div>
              <div id="menulocations" class="panel-collapse collapse">
              	<div class="box-body">
                	<?php if( $menu_locations	=	Theme::Get_Registered_Nav_Locations() ):?>
						<?php foreach( $menu_locations as $namespace => $name ):?>
                            <div class="checkbox"> <label> <input type="checkbox" name="<?php xss_clean( $namespace );?>"> <?php echo xss_clean( $name );?></label> </div>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
                
              </div>
            </div>
          </div>
        <div id="nestable-menu">
            <button type="button" class="btn btn-default" data-action="expand-all">Expand All</button>
            <button type="button" class="btn btn-primary" data-action="collapse-all">Collapse All</button>
        </div>

        </div>
    </div>
<?php include_once( dirname( __FILE__ ) . '/mainscript.php' );?>