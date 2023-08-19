<?php 


//STYLES

function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_stylesheet_directory_uri() . '/style.css', array(), '1.0' );
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

function nmota_theme_settings() {
echo '<h1>'.get_admin_page_title().'</h1>';
}

add_action('admin_menu', 'nmota_add_admin_pages', 10);


function montheme_supports()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));}
add_action('after_setup_theme', 'montheme_supports');
