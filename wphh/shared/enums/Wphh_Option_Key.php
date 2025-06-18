<?php

/**
 * This file is part of the WordPress WP Hidro Hub plugin.
 * @author Jayron Castro <eu@jayroncastro.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 * @link https://www.wphidrohub.com
 * @version 1.0.0
 * @since 1.0.0
 */
namespace wphh\shared\enums;

/**
 * This Enum manipulates the configuration record data types contained in the Wp_Options table.
 * @package wphh
 * @subpackage shared/enum
 * @access public
 * @since 1.0.0
 */
enum Wphh_Option_Key {

	/**
	 * This constant is used to set the 'db_version' configuration key.
	 * @access public
	 * @since 1.0.0
	 */
	case DB_VERSION;

	/**
	 * This constant is used to set the 'created_tables' configuration key.
	 * @access public
	 * @since 1.0.0
	 */
	case CREATED_TABLES;

	/**
	 * This constant is used to set the 'taxonomy_product_status' configuration key.
	 * @access public
	 * @since 1.0.0
	 */
	case TAXONOMY_PRODUCT_STATUS;

	/**
	 * This constant is used to set the 'taxonomy_product_category' configuration key.
	 * @access public
	 * @since 1.0.0
	 */
	case TAXONOMY_PRODUCT_CATEGORY;
}