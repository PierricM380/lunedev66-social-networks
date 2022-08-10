<?php

/* Addition the style file on administrator space.  */

// Saves adding custom code to WordPress 
add_action('admin_enqueue_scripts', 'my_admin_theme_style');
add_action('login_enqueue_scripts', 'my_admin_theme_style');

function my_admin_theme_style()
{
    // adds a style sheet when loading site pages
    wp_enqueue_style('my-admin-theme', plugins_url('social-networks.css', __FILE__));
}

/* Creation of the sidebar */

add_action("admin_menu", "social_media_sidebar");

function social_media_sidebar()
{
    add_menu_page("My First Page", "PierricM Social Networks", "manage_options", "social-media", "social_media_page", "dashicons-share");
}

/* Creation of the topbar */

add_action('admin_bar_menu', 'social_media_topbar', 999);

// function who add associative array into topbar with a node
function social_media_topbar($wp_admin_bar)
{
    $admin_topbar = array(
        'id' => 'reseaux-sociaux',
        'title' => 'PierricM Social Networks',
        'href' => admin_url('admin.php?page=social-media'),
    );

    $wp_admin_bar->add_node($admin_topbar);
}

/*  Creation of the admin page  - function */

add_action("admin_init", "social_media_section_settings");

function social_media_section_settings()
{
    // Section creation
    add_settings_section("social_media_section", "", null, "social-media");

    // Fields creation
    add_settings_field("social-media-facebook", "Partager sur Facebook", "social_media_facebook_switch", "social-media", "social_media_section");
    add_settings_field("social-media-linkedin", "Partager sur Linkedin", "social_media_linkedin_switch", "social-media", "social_media_section");
    add_settings_field("social-media-twitter", "Partager sur Twitter", "social_media_twitter_switch", "social-media", "social_media_section");

    // Saving fields
    register_setting("social_media_section", "social-media-facebook");
    register_setting("social_media_section", "social-media-linkedin");
    register_setting("social_media_section", "social-media-twitter");
}

/*  Creaation of admin page - html  */

// Function that create html Facebook
function social_media_facebook_switch()
{ ?>
    <label class="switch">
        <input type="checkbox" name="social-media-facebook" value="activate" <?php checked('activate', get_option('social-media-facebook'), true); ?>>
        <span class="slider round"></span>
    </label>
<?php }

// Function that create html LinkedIn option
function social_media_linkedin_switch()
{ ?>
    <label class="switch">
        <input type="checkbox" name="social-media-linkedin" value="activate" <?php checked('activate', get_option('social-media-linkedin'), true); ?>>
        <span class="slider round"></span>
    </label>
<?php }

// Function that create html Twitter option
function social_media_twitter_switch()
{ ?>
    <label class="switch">
        <input type="checkbox" name="social-media-twitter" value="activate" <?php checked('activate', get_option('social-media-twitter'), true); ?>>
        <span class="slider round"></span>
    </label>
<?php }

/* Creation of the admin page - form */

function social_media_page()
{ ?>
    <div class="container">
        <h1>Réseaux sociaux</h1>
        <p>Veuillez sélectionner les réseaux sociaux que vous souhaitez faire apparaître dans vos articles : </p>

        <form method="post" action="options.php">
            <?php
            settings_fields("social_media_section");
            do_settings_sections("social-media");
            submit_button();
            ?>
        </form>
    </div>
<?php }

/*  Creation of social networks section - html  */

// Function that which will allow me to retrieve the status of each of the social networks, and display or not them
function social_media_icons_front($social_media_icons)
{
    // Creation and retrieval of variables
    global $post;

    $link = get_permalink($post->ID);
    $link = esc_url($link);

    // Creation of the HTML structure
    $html = "<div class='container row'><div class='h3'>Partager sur : </div>";

    // Shake if social Facebook is activate and render html code
    if (get_option("social-media-facebook") == 'activate') {
        $html = $html . "
        <div class='col-1' style='margin-left: 5px; margin-right: 5px'>
            <a target='_blank' href='https://www.facebook.com/sharer/sharer.php?u=" . $link . "'>
                <i class='fab fa-facebook-square fa-2x'></i>
            </a>
        </div>";
    }

    // Shake if social Twitter is activate
    if (get_option("social-media-twitter") == 'activate') {
        $html = $html . "
        <div class='col-1' style='margin-left: 5px; margin-right: 5px'>
            <a target='_blank' href='https://twitter.com/share?url=" . $link . "'>
                <i class='fab fa-twitter-square fa-2x'></i>
            </a>
        </div>";
    }

    // // Shake if social LinkedIn is activate
    if (get_option("social-media-linkedin") == 'activate') {
        $html = $html . "
        <div class='col-1' style='margin-left: 5px; margin-right: 5px'>
            <a target='_blank' href='http://www.linkedin.com/shareArticle?url=" . $link . "'>
                <i class='fab fa-linkedin fa-2x'></i>
            </a>
        </div>";
    }

    $social_media_icons = $social_media_icons . $html;
    return $social_media_icons;
}

// Add function in callback into hook content by filtering Wordpress function
add_filter("the_content", "social_media_icons_front");
