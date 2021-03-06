<?php

/*Load components*/
class Social_Articles_Component extends BP_Component {

    function __construct()
    {
        global $bp;
        parent::start(
            'social_articles',
            __( 'Social Articles', 'articles' ),
            SA_BASE_PATH
        );
        $this->includes();
        $bp->active_components[$this->id] = '1';

    }

    function includes($includes = Array())
    {
        $includes = array(
            'includes/social-articles-screens.php',
            'includes/social-articles-functions.php',
            'includes/social-articles-manage-functions.php',
            'includes/social-articles-notifications.php',
        );
        parent::includes( $includes );
    }

    function setup_globals($args = array())
    {
        global $bp;
        if ( !defined( 'SA_SLUG' ) )
            define( 'SA_SLUG', $this->id );
        $globals = array(
            'slug'                  => SA_SLUG,
            'root_slug'             => isset( $bp->pages->{$this->id}->slug ) ? $bp->pages->{$this->id}->slug : SA_SLUG,
            'has_directory'         => false,
            'notification_callback' => 'social_articles_format_notifications',
            'search_string'         => __( 'Search articles...', 'social-articles' )
        );
        //if($this->check_visibility()){
            parent::setup_globals( $globals );
        //}
    }

    function setup_nav($main_nav = Array(), $sub_nav = Array())
    {
	
        $directWorkflow = isDirectWorkflow();
        $options = get_option('social_articles_options');

        if(isset($options['published_post_counter']) && $options['published_post_counter'] == 'true'){
            $name =  sprintf( __("Articles", "social-articles").'<span class="sa-global-counter">%s</span>', '');
        }else{
            $name = __( 'Articles', 'social-articles' );
        }

        $main_nav = array(
            'name'                => $name,
            'slug'                => SA_SLUG,
            'position'            => 80,
            'screen_function'     => 'social_articles_screen',
            'default_subnav_slug' => 'articles'
        );

        $user_domain = bp_is_user() ? bp_displayed_user_domain() : bp_loggedin_user_domain();
        
        $social_articles_link = trailingslashit( $user_domain . SA_SLUG );
       
        $user_id = bp_is_user() ? bp_displayed_user_id() : bp_loggedin_user_id();
        $publishCount = '';
        $pendingCount = '';
        $draftCount = '';

        if(bp_displayed_user_id()==bp_loggedin_user_id()){
            $sub_nav[] = array(
                'name'            =>  sprintf( __("Published", "social-articles").'<span>%s</span>', $publishCount),
                'slug'            => 'articles',
                'parent_url'      => $social_articles_link,
                'parent_slug'     => SA_SLUG,
                'screen_function' => 'my_articles_screen',
                'position'        => 10
            );
            if(!$directWorkflow){
                $sub_nav[] = array(
                    'name'            =>  sprintf( __("Under Review", "social-articles").'<span>%s</span>', $pendingCount),
                    'slug'            => 'under-review',
                    'parent_url'      => $social_articles_link,
                    'parent_slug'     => SA_SLUG,
                    'screen_function' => 'pending_articles_screen',
                    'position'        => 20
                );
            }

            $sub_nav[] = array(
                'name'            =>  sprintf( __("Draft", "social-articles").'<span>%s</span>', $draftCount),
                'slug'            => 'draft',
                'parent_url'      => $social_articles_link,
                'parent_slug'     => SA_SLUG,
                'screen_function' => 'draft_articles_screen',
                'position'        => 30
            );

            $sub_nav[] = array(
                'name'            =>  __( 'New article' , 'social-articles' ),
                'slug'            => 'new',
                'parent_url'      => $social_articles_link,
                'parent_slug'     => SA_SLUG,
                'screen_function' => 'new_article_screen',
                'position'        => 40
            );
        }else {
            if ($options['show_to_logged_out_users'] == 'true'){
                $sub_nav[] = array(
                    'name' => '',
                    'slug' => 'articles',
                    'parent_url' => $social_articles_link,
                    'parent_slug' => SA_SLUG,
                    'screen_function' => 'my_articles_screen',
                    'position' => 10
                );
            }
        }
        if($this->check_visibility()){
            parent::setup_nav( $main_nav, $sub_nav );
        }else{
            if ($options['show_to_logged_out_users'] == 'true' && is_user_logged_in() == false) {
                parent::setup_nav($main_nav, $sub_nav);
            }
        }
    }

    function setup_admin_bar($wp_admin_nav = Array())
    {
        global $bp;
        $directWorkflow = isDirectWorkflow();

        if ( is_user_logged_in() ) {

            if($directWorkflow){
                $postCount = custom_get_user_posts_count(array("publish", "draft"));
            }else{
                $postCount =  custom_get_user_posts_count(array("publish", "pending", "draft"));
            }

            $user_domain =  bp_loggedin_user_domain();

            $wp_admin_nav[] = array(
                'parent' => 'my-account-buddypress',
                'id'     => 'my-account-social-articles',
                'title'  => __( 'Social Articles', 'social-articles' ),
                'href'   => trailingslashit( $user_domain.'articles' )
            );

            $wp_admin_nav[] = array(
                'parent' => 'my-account-social-articles',
                'id'=>'article-list-item',
                'title'  => sprintf( __( 'Articles <span class="count">%s</span>', 'social-articles' ), $postCount ),
                'href'   => trailingslashit( $user_domain.'articles' )
            );

            $wp_admin_nav[] = array(
                'parent' => 'my-account-social-articles',
                'id'=>'article-new-item',
                'title'  => sprintf( __( 'New Article', 'social-articles' )),
                'href'   => trailingslashit( $user_domain.'articles/new' )
            );
        }
        if($this->check_visibility()){
            parent::setup_admin_bar( $wp_admin_nav );
        }
    }

    function check_visibility()
    {
        $visibility = current_user_can('edit_posts') || !is_user_logged_in() || user_can(bp_displayed_user_id(), 'edit_posts');
        return apply_filters('sa_extra_settings_visibility',$visibility);
    }

}

function social_articles_load_core_component() {
    global $bp;
    $bp->social_articles = new Social_Articles_Component;
    do_action('social_articles_load_core_component');
}
add_action( 'bp_loaded', 'social_articles_load_core_component' );

?>