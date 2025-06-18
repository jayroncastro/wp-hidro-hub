<?php

/**
 * WP Hidro Hub
 *
 * @package             WP Hidro Hub
 * @author              Jayron Castro
 * @copyright           2025 Jayron Castro
 * @license             GPL-3.0-or-later
 *
 * Plugin Name:         WP Hidro Hub
 * Plugin URI:          https://wphidrohub.com
 * Description:         The central management hub for water factories and distributors. Manage customers, products (disposable and refillable), price lists, orders, inventory, zone routing, driver arrangements and commissions in one place on WordPress.
 * Version:             1.0.0
 * Requires at least:   6.2
 * Requires PHP:        8.4
 * Author:              Jayron Castro <eu@jayroncastro.com>
 * Author URI:          https://jayroncastro.com
 * License:             GPLv3 or later
 * License URI:         https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:         wp-hidro-hub
 * Domain Path:         /languages
 */

/**
 *  This file is part of the WordPress WP Hidro Hub plugin.
 *
 * WP Hidro Hub is an open source software distributed under the GPLv3 license
 * or higher, granting the end user the right to use, study, modify and
 * redistribute this plugin. For any questions, the link below that deals with
 * the license should be viewed for more details,
 * see: https://www.gnu.org/licenses/gpl-3.0.html
 */

use wphh\admin\controllers\Wphh_Loader;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if ( ! defined( 'WPHH_FILE' ) ) {
	define( 'WPHH_FILE', __FILE__ );
}

require_once __DIR__ . '/vendor/autoload.php';

new Wphh_Loader();