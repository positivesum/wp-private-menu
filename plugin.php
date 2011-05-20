<?php
/*
Plugin Name: WP Private Menu
Plugin URI: http://positivesum.org
Description: Hook to set private menus. Pages under these menus will be required login/password.
Version: 1.0

Author: Valera Satsura
Author URI: https://www.odesk.com/users/~~8995d17603281447
*/

// Load file with core
require_once(dirname(__FILE__).'/private-menu.php');

// Add filter to render page template
add_filter('page_template', 'private_menu_page', 999);

 
