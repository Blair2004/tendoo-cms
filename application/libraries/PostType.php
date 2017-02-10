<?php
class PostType
{
    /**
     * 	Its create post type interface quickly. Callable from "init.php" module and theme file.
    **/
    public function __construct($config)
    {
        $this->events               =    get_instance()->events;
        $this->namespace            =    $this->config[ 'namespace' ]       =    riake( 'namespace', $config);
        $this->meta                 =    $this->config[ 'meta' ]            =    riake( 'meta', $config);
        $this->label                =    $this->config[ 'label' ]           =    riake( 'label', $config, $this->namespace);
        $this->new_post_label       =    $this->config[ 'new-post-label' ]  =    riake( 'new-post-label', $config, sprintf(__('Create a new %s'), $this->namespace));

        $this->edit_post_label      =    $this->config[ 'edit-post-label' ] =    riake('edit-post-label', $config, sprintf(__('Edit %s'), $this->namespace));

        $this->posts_list_label     =    $this->config[ 'posts-list-label' ]=    riake('posts-list-label', $config, sprintf(__('%s list'), $this->namespace));

        $this->delete_post_label    =    $this->config[ 'delete-post-label' ]=    riake('delete-post-label', $config, sprintf(__('delete %s'), $this->namespace));

        $this->menu_position        =    $this->config[ 'menu-position' ]   =    riake('menu-position', $config, array( 'after', 'dashboard' ));

        $this->menu_icon            =    $this->config[ 'menu-icon' ]       =    riake('menu-icon', $config, 'fa fa-star');
        $this->privilege            =    $this->config[ 'privilege' ]       =    riake('privilege', $config, 'manage_core');

        $this->displays             =    $this->config[ 'displays' ]        =    riake('displays', $config, array( 'title', 'editor', 'publish' ));

        $this->comment_enabled      =    $this->config[ 'comment-enabled' ] =    riake('comment-enabled', $config, true);
        $this->post_comment_label   =    $this->config[ 'post-comment-label' ]=    riake('post-comment-label', $config, __('Comments'));

        $this->comments_list_label  =    $this->config[ 'comments-list-label' ]    =    riake('comments-list-label', $config, sprintf(__('%s comments'), $this->namespace));

        $this->is_hierarchical        =    $this->config[ 'is-hierarchical' ]        =    riake('is-hierarchical', $config, true);

        if ( ! $this->namespace ) {
            return false;
        }

        $this->query                =       new CustomQuery(array(
            'namespace'             =>    $this->namespace,
            'is_hierarchical'       =>    $this->is_hierarchical,
            'meta'                  =>    $this->meta
        ) );

        $posttypes                        =    force_array(get_instance()->config->item('posttypes'));
        $posttypes[ $this->namespace ]    =    $this;
        get_instance()->config->set_item('posttypes', $posttypes);
    }

    /**
     * Get config
     *
    **/

    public function get_config()
    {
        return $this->config;
    }

    /**
     * Run Post Type Menus
     *
    **/

    public function run()
    {
        $this->events->add_filter('admin_menus', function ($menus) {

            if ( User::can( $this->privilege ) ) {
                $menus[ $this->namespace ]    =    array(
                    array(
                        'title'            =>    $this->label,
                        'href'            =>    '#',
                        'disable'        =>    true,
                        'icon'            =>    $this->menu_icon
                    ),
                    array(
                        'title'            =>    $this->posts_list_label,
                        'href'            =>    site_url(array( 'dashboard', 'posttype', $this->namespace, 'list' )),
                    ),
                    array(
                        'title'            =>    $this->new_post_label,
                        'href'            =>    site_url(array( 'dashboard', 'posttype', $this->namespace, 'new' )),
                    )
                );

                if ($this->comment_enabled === true) {
                    $menus[ $this->namespace ][] = array(
                        'title'            =>    $this->post_comment_label,
                        'href'            =>    site_url(array( 'dashboard', 'posttype', $this->namespace, 'comments' )),
                    );
                }

                foreach (force_array($this->query->get_defined_taxonomies()) as $taxonomy) {
                    $menus[ $this->namespace ][] =  array(
                        'title'            =>    riake('taxonomy-list-label', $taxonomy, sprintf(__('%s list'), riake('namespace', $taxonomy))),
                        'href'            =>    site_url(array( 'dashboard', 'posttype', $this->namespace, 'taxonomy', riake('namespace', $taxonomy), 'list' )),
                    );

                    $menus[ $this->namespace ][] = array(
                        'title'            =>    riake('new-taxonomy-label', $taxonomy, sprintf(__('New %s'), riake('namespace', $taxonomy))),
                        'href'            =>    site_url(array( 'dashboard', 'posttype', $this->namespace, 'taxonomy', riake('namespace', $taxonomy), 'new' )),
                    );
                }
            }
            return $menus;
        });
    }

    /**
     * Define taxonomy for post type
    **/

    public function define_taxonomy($namespace, $title, $config = array())
    {
        return $this->query->define_taxonomy($namespace, $title, $config);
    }

    /**
     * Set Taxonomy for post type.
     * Use before run.
     *
    **/

    public function set_taxonomy($namespace,    $title, $content, $parent_id = null)
    {
        return $this->query->set_taxonomy($namespace,    $title, $content, $parent_id);
    }

    /**
     * Save Post type to database
     *
     * @access	:	Public
     * @param	:	String (title) , String (Content) , String (Status)
     * @return	:	String (Post status)
    **/

    public function set($title, $content, $meta, $taxonomies, $status = 1, $parent = 0, $mode = 'set')
    {
        return $this->query->set($title, $content, $meta, $taxonomies, $status, $parent, $mode);
    }

    /**
     * Update Post type to database
     *
     * @access	:	Public
     * @param	:	String (title) , String (Content) , String (Status)
     * @return	:	String (Post status)
    **/

    public function update($title, $content, $meta, $taxonomies, $status = 1, $parent = 0, $mode = 'edit', $id = 0)
    {
        return $this->query->set($title, $content, $meta, $taxonomies, $status, $parent, $mode, $id);
    }

    /**
     * get post from database. is CustomQuery::get alias
     *
     * @access	:	Public
     * @param	:	Array
     * @return	:	Multiform
    **/

    public function get($config = array())
    {
        return $this->query->get($config);
    }
}
