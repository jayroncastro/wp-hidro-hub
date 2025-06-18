<?php

/**
 * This file is part of the WordPress WP Hidro Hub plugin.
 * @author Jayron Castro <eu@jayroncastro.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 * @link https://www.wphidrohub.com
 * @version 1.0.0
 * @since 1.0.0
 */
namespace wphh\shared;

/**
 * This interface ensures that the data type returned by the get_param method of the Wphh_Request class is always known and consistent.
 * @package wphh
 * @subpackage shared
 * @since 1.0.0
 */
interface Wphh_Request_Result {

	/**
	 * Returns the field value.
	 * @access public
	 * @since 1.0.0
	 * @return mixed
	 */
	public function get_value(): mixed;
}
