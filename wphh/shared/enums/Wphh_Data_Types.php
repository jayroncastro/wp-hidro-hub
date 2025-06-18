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
 * This Enum handles the data types of the Wphh_Request_Params class that can be returned by Wphh_Request
 * @package wphh
 * @subpackage shared/enum
 * @access public
 * @since 1.0.0
 */
enum Wphh_Data_Types: string {

	/**
	 * This constant is used to set that the data type to be returned will be of the string type.
	 * @access public
	 * @since 1.0.0
	 */
	case STRING = 'string';

	/**
	 * This constant is used to set that the data type to be returned will be of the int type.
	 * @access public
	 * @since 1.0.0
	 */
	case INT = 'int';

	/**
	 * This constant is used to set that the data type to be returned will be of the float type.
	 * @access public
	 * @since 1.0.0
	 */
	case FLOAT = 'float';

	/**
	 * This constant is used to set that the data type to be returned will be of the boolean type.
	 * @access public
	 * @since 1.0.0
	 */
	case BOOL = 'bool';

	/**
	 * This constant is used to set that the data type to be returned will be of the text area type.
	 * @access public
	 * @since 1.0.0
	 */
	case TEXTAREA = 'textarea';

	/**
	 * This constant is used to set that the data type to be returned will be of the email type.
	 * @access public
	 * @since 1.0.0
	 */
	case EMAIL = 'email';

	/**
	 * This constant is used to set that the type of data to be returned will be a url.
	 * @access public
	 * @since 1.0.0
	 */
	case URL = 'url';

	/**
	 * This constant is used to set that the type of data to be returned will be an HTML code.
	 * @access public
	 * @since 1.0.0
	 */
	case HTML = 'html';

	/**
	 * This constant is used to set that the type of data to be returned will be an array.
	 * @access public
	 * @since 1.0.0
	 */
	case ARRAY = 'array';

	/**
	 * This constant is used to define that the data type to be returned will be raw data, without any sanitization.
	 * @access public
	 * @since 1.0.0
	 */
	case RAW = 'raw';
}
