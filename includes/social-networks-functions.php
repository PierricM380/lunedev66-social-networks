<?php

/* Addition the style file on administrator space.  */

function my_admin_theme_style()
{
    // adds a style sheet when loading site pages
    wp_enqueue_style('my-admin-theme', plugins_url('social-networks.css', __FILE__));
}

// Saves adding custom code to WordPress 
add_action('admin_enqueue_scripts', 'my_admin_theme_style');
add_action('login_enqueue_scripts', 'my_admin_theme_style');

/* Creation of the sidebar */

add_action("admin_menu", "social_media_sidebar");

function social_media_sidebar()
{
    add_menu_page("My First Page", "Reseaux sociaux", "manage_options", "social-media", "social_media_page", "dashicons-share");
}

/* Creation of the topbar */

add_action('admin_bar_menu', 'social_media_topbar', 999);

// function who add associative array into topbar with a node
function social_media_topbar($wp_admin_bar)
{
    $admin_topbar = array(
        'id' => 'reseaux-sociaux',
        'title' => 'Reseaux sociaux',
        'href' => admin_url('admin.php?page=social-media') ,
    );

    $wp_admin_bar->add_node($admin_topbar);
}
