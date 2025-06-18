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
 * This enum is used to identify the type of object to be handled by the `Wphh_Meta_Field` class.
 * @package wphh
 * @subpackage shared/enum
 * @access public
 * @since 1.0.0
 */
enum Wphh_Meta_Object_Type: string {

	/**
	 * This constant informs that the object to be treated will be a `post`.
	 * @access public
	 * @since 1.0.0
	 */
	case POST = 'post';

	/**
	 * This constant informs that the object to be treated will be a `user`.
	 * @access public
	 * @since 1.0.0
	 */
	case USER = 'user';

}