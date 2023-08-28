<?php 


//STYLES

function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_stylesheet_directory_uri() . '/style.css', array(), '1.0' );
      // Enqueue your custom JavaScript file
      wp_enqueue_script('jquery');
      wp_enqueue_script( 'custom-scripts', get_stylesheet_directory_uri() . '/script.js', array('jquery'), '1.0', true );
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

function montheme_supports() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
}
add_action('after_setup_theme', 'montheme_supports');

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

//PHOTOS //

function load_photos() {
    $type = $_GET['type'];
    $category = $_GET['categorie'];
    $format = $_GET['format'];
    $sort = $_GET['sort'];
    $page = $_GET['page'];

    $args = array(
        'post_type' => 'photo', // Remplacez par le nom de votre type de contenu personnalisé
        'posts_per_page' => 12,
        'paged' => $page, // Numéro de page pour la pagination
        // Ajoutez d'autres
    );
    if ($category) {
        $args['taxonomie_name'] = $category;
    }
    // Ajoutez la partie de requête pour le champ personnalisé 'format'
    if ($format) {
        $args['meta_query'] = array(
            array(
                'key' => 'format', // Remplacez par le nom du champ personnalisé ACF
                'value' => $format,
                'compare' => '=',
            ),
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            echo '<div id="photo">';
            the_title();
            the_content();
            the_post_thumbnail('thumbnail');
            // Affichage du champ ACF "Type d'événement"
            $photo_format= get_field('format'); // Remplacez par le nom de votre champ ACF
            if ($photo_format) {
                echo '<p>Type d\'événement : ' . esc_html($photo_format) . '</p>';
            }
            echo '</div>';
        }
        wp_reset_postdata();
    } else {
        echo 'Aucune photo trouvée.';
    }

    die(); // Assurez-vous de terminer l'exécution
}

add_action('wp_ajax_load_photos', 'load_photos');
add_action('wp_ajax_nopriv_load_photos', 'load_photos');

