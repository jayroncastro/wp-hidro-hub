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
 * This Enum handles the types of HTTP requests that can occur in the plugin.
 * @package wphh
 * @subpackage shared/enum
 * @access public
 * @since 1.0.0
 */
enum Wphh_Request_Type {

	/**
	 * This constant is used to set in the class that all methods will handle GET type requests.
	 * @access public
	 * @since 1.0.0
	 */
	case GET;

	/**
	 * This constant is used to set in the class that all methods will handle POST type requests.
	 * @access public
	 * @since 1.0.0
	 */
	case POST;
}