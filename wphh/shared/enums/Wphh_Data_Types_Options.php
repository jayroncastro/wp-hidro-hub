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
 * This Enum represents the data types stored in the wphh_settings key located in wp_options.
 * @package wphh
 * @subpackage shared/enum
 * @access public
 * @since 1.0.0
 */
enum Wphh_Data_Types_Options {

	/**
	 * This value represents what data types will be returned in the form of a string.
	 * @access public
	 * @since 1.0.0
	 */
	case STRING;

	/**
	 * This value represents that data types will be returned in the format of an integer.
	 * @access public
	 * @since 1.0.0
	 */
	case INT;

	/**
	 * This value represents that the data types will be returned in the format of a floating point number.
	 * @access public
	 * @since 1.0.0
	 */
	case FLOAT;

	/**
	 * This value represents that the data types will be returned in the form of a boolean.
	 * @access public
	 * @since 1.0.0
	 */
	case BOOL;
}