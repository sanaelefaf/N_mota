<?php 


//STYLES

function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_stylesheet_directory_uri() . '/style.css', array(), '1.0' );
      // Enqueue your custom JavaScript file
      wp_enqueue_script('jquery');
      wp_enqueue_script( 'custom-scripts', get_stylesheet_directory_uri() . '/script.js', array('jquery'), '1.0', true );
      wp_enqueue_script('lightbox-script', get_template_directory_uri() . '/custom.js/lightbox.js', array('jquery'), '1.0', true);
      wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
  


//MENUS

function theme_custom_menus() {
    register_nav_menus( array(
        'header' => esc_html__('Menu Principal','nmota'),
        'footer'  => esc_html__( 'Secondary menu', 'nmota' ),
    ) );
}
add_action( 'after_setup_theme', 'theme_custom_menus' );




//ADMIN

function nmota_add_admin_pages() {
    add_menu_page(__('Paramètres du thème Nmota', 'nmota'), __('nmota', 'nmota'), 'manage_options', 'nmota-settings', 'nmota_theme_settings', 'dashicons-admin-settings', 60);
}
add_action('admin_menu', 'nmota_add_admin_pages', 10);


// Configuration des fonctionnalités du thème
function montheme_supports() {
     // Activation de la prise en charge des titres
    add_theme_support('title-tag');
    // Activation de la prise en charge des images à la une
    add_theme_support('post-thumbnails');
      // Activation de la prise en charge des menus
    add_theme_support('menus');

    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
}
add_action('after_setup_theme', 'montheme_supports');

//PARAMETRES THEME
function nmota_settings_register() {
    register_setting('nmota_settings_fields', 'nmota_settings_fields', 'nmota_settings_fields_validate');
    add_settings_section('nmota_settings_section', __('Paramètres', 'nmota'), 'nmota_settings_section_introduction', 'nmota_settings_section');
    add_settings_field('nmota_settings_field_introduction', __('Introduction', 'nmota'), 'nmota_settings_field_introduction_output', 'nmota_settings_section', 'nmota_settings_section');
}
add_action('admin_init', 'nmota_settings_register');

function nmota_settings_section_introduction() {
    echo __('Paramètrez les différentes options de votre thème nmota.', 'nmota');
}

function nmota_settings_field_introduction_output() {
    $value = get_option('nmota_settings_field_introduction');
    echo '<input name="nmota_settings_field_introduction" type="text" value="'.$value.'" />';
}

//RÉGLAGE GÉNÉRAUX//
function nmota_theme_settings() {
    echo '<h1>'.esc_html(get_admin_page_title()).'</h1>';
    echo '<form action="options.php" method="post" name="nmota_settings">';
    echo '<div>';
    settings_fields('nmota_settings_fields');
    do_settings_sections('nmota_settings_section');
    submit_button();
    echo '</div>';
    echo '</form>';
}


add_theme_support('post-thumbnails'); // Activation des images à la une
add_post_type_support('page', 'excerpt'); // Activation des extraits pour les pages
add_post_type_support('page', 'page-attributes'); // Activation des attributs de page


// Inclusion du fichier des fonctions AJAX
require get_template_directory() . '/custom/function-ajax.php'; 

wp_localize_script('your-script-handle', 'ajaxurl', admin_url('admin-ajax.php'));
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');

function my_enqueue_scripts() {
    wp_localize_script('jquery', 'ajaxurl', admin_url('admin-ajax.php'));
}
