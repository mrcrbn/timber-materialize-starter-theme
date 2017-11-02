<?php
if (!class_exists('Timber')) {
    add_action('admin_notices', function() {
        echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url(admin_url('plugins.php#timber')) . '">' . esc_url(admin_url('plugins.php')) . '</a></p></div>';
    });

    add_filter('template_include', function($template) {
        return get_stylesheet_directory() . '/static/no-timber.html';
    });

    return;
}

Timber::$dirname = array('materialize-templates');


class MaterializeSite extends TimberSite {

    function __construct() {
        add_theme_support('post-formats');
        add_theme_support('post-thumbnails');
        add_theme_support('menus');
        add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));
        add_filter('timber_context', array($this, 'add_to_context'));
        add_filter('get_twig', array($this, 'add_to_twig'));
        add_action('wp_enqueue_scripts', array($this, 'add_scripts'));
        parent::__construct();
    }

    function add_scripts() {
        $dir_root = get_template_directory_uri() . "/static";

        if (!is_admin()) {
            //don't use wordpress default jquery lib
            wp_deregister_script('jquery');

            wp_enqueue_style('materialize_css', $dir_root . '/css/materialize.css', false, '0.0.58', 'screen');
            wp_enqueue_style('style_css', $dir_root . '/css/style.css', false, '0.0.58', 'screen');
            wp_enqueue_style('material_icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', false, '', 'screen');
            wp_enqueue_script('jquery', $dir_root . '/js/jquery.min.js', false, '3.2.1', true);
            wp_enqueue_script('materialize-js', $dir_root . '/js/materialize.min.js', false, '0.98.1', true);
            wp_enqueue_script('site_local', $dir_root . '/js/site.js', false, '0.0.58', true);
        }
    }
    function register_post_types() {
        //this is where you can register custom post types
    }

    function register_taxonomies() {
        //this is where you can register custom taxonomies
    }

    function add_to_context($context) {
        $context['menu'] = new TimberMenu();
        $context['site'] = $this;
        return $context;
    }

    function add_to_twig($twig) {
        /* this is where you can add your own functions to twig */
        $twig->addExtension(new Twig_Extension_StringLoader());

        return $twig;
    }
}
new MaterializeSite();
