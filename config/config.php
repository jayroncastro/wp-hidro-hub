<?php

/**
 * This file is part of the WordPress WP Hidro Hub plugin.
 * @package config
 * @author Jayron Castro <eu@jayroncastro.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 * @link https://www.wphidrohub.com
 * @version 1.0.0
 * @since 1.0.0
 */

/**
 * This constant stores the path to the plugin's main directory.
 * @var string
 * @since 1.0.0
 */
const WPHH_DIR = __DIR__ . '/../';

/**
 * This constantly stores a plugin version.
 * @var string
 * @since 1.0.0
 */
const WPHH_PLUGIN_VERSION = '1.0.0';

/**
 * If this constant is true, WORDPRESS will generate an error log in the `debug.log` file.
 * @var bool
 * @since 1.0.0
 */
const WPHH_ERROR_LOG = true;

/**
 * This constant stores the log level. <br>
 * Example. <br>
 * `1` - displays errors from the model layer. <br>
 * `2` - displays errors from the control layer. <br>
 * `3` - displays errors in all layers.
 * $var int
 * @since 1.0.0
 */
const ERROR_LEVEL = 3;

/**
 * This constant stores the name of the plugin's main menu.
 * @var string
 * @since 1.0.0
 */
const WPHH_MAIN_MENU = 'WP Hidro Hub';

/**
 * This constant stores the icon that will be used in the plugin's main menu.
 * @var string
 * @since 1.0.0
 * @see https://developer.wordpress.org/resource/dashicons/
 */
const WPHH_MAIN_ICON = 'dashicons-fullscreen-exit-alt';

/**
 * This constant stores the plugin prefix to be used throughout the project.
 * @var string
 * @since 1.0.0
 */
const WPHH_PREFIX_PLUGIN = 'wphh_';

/**
 * This constant stores the prefix to be used in the name of custom tables.
 * @var string
 * @since 1.0.0
 */
const WPHH_PREFIX_DATABASE = 'hh_';

/**
 * This constant stores the name of the key recorded in the wp_options table that stores the wphidrohub control variables.
 * @var string
 * @since 1.0.0
 */
const WPHH_CONFIGURATION_KEY = 'wphh_settings';

/**
 * This constant stores the version number corresponding to the current version of the plugin database.
 * @var int
 * @since 1.0.0
 */
const WPHH_DB_VERSION = 1;