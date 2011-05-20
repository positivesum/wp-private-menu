<?php
/**
 * Private Menu
 *
 * @author Valera Satsura <mail@satsura.com>
 */

class PrivateMenu {
    public function __construct() {}
}

/**
 * Store private menus
 *
 * @param array $menus
 * @param null $login_template
 * @return void
 */
function private_menu_init($menus) {
    // Save private menu items
    $menus = serialize($menus);
    update_option('private_menu_items', $menus);
}

/**
 * Page renderer
 * @param  $template
 * @return mixed|void
 */
function private_menu_page($template) {
    global $post;
    
    // Get menus
    $menus = get_option('private_menu_items', array());
    
    // Default Login Template
    $login_template =  dirname(__FILE__).'/view.php';

    // Menu format
    $menus = is_string($menus) ? unserialize($menus) : $menus;

    // Check page - In menu or not?
    $in_menu = false; // Checker
    foreach ((array)$menus as $menu => $tpl) {
        // If not assign template
        if (is_int($menu)) {
            $menu = $tpl;
            $tpl = $login_template;
        }

        // Get menu object
        $menu = wp_get_nav_menu_object($menu);
        // Get menu items
        $menu_items = wp_get_nav_menu_items($menu->term_id);
        // Check menu items
        foreach ((array)$menu_items as $item) {
            if ($item->object_id == $post->ID) {
                $in_menu = true;
                $login_template = $tpl;
                break;
            }
        }
    }
    
    // If not in menu show default template
    if (!$in_menu) {
        return $template;
    }
    
    // If user not logined show login template
    if (!is_user_logged_in()) {
        return $login_template;
    }
    
    // If user logined show content
    return $template;
}