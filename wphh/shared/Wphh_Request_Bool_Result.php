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

use wphh\shared\Wphh_Request_Result;

/**
 * This class implements the Wphh_Request_Result interface and handles the return of Wphh_Request->get_param() as a boolean.
 * @package wphh
 * @subpackage shared
 * @since 1.0.0
 * @implements
 */
class Wphh_Request_Bool_Result implements Wphh_Request_Result {

	private bool $_value;

	/**
	 * This method initializes an instance of the class.
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct( bool $value ) {
		$this->_value = $value;
	}

	/**
	 * @inheritDoc
	 */
	public function get_value(): bool {
		return $this->_value;
	}
}