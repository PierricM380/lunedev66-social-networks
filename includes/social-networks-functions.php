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

/*  */
