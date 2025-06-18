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

use wphh\shared\enums\Wphh_Data_Types;
use wphh\shared\enums\Wphh_Request_Type;

/**
 * This class is used to encapsulate the parameters used in the Wphh_Request class.
 * @package wphh
 * @subpackage shared
 * @since 1.0.0
 */
class Wphh_Request_Params {

	/**
	 * This argument stores the name of the parameter that will be returned.
	 * @access public
	 * @since 1.0.0
	 * @var string
	 */
	public string $meta_key;

	/**
	 * This argument stores the type of request that the class will handle.
	 * @access public
	 * @since 1.0.0
	 * @var Wphh_Request_Type
	 */
	public Wphh_Request_Type $request_type;

	/**
	 * This argument stores the type of request that the class will handle.
	 * @access public
	 * @since 1.0.0
	 * @var Wphh_Data_Types
	 */
	public Wphh_Data_Types $data_type;

	/**
	 * Stores the default value to be used if the parameter is not found in the request.
	 * @access public
	 * @since 1.0.0
	 * @var mixed
	 */
	public mixed $default_value;

	/**
	 * This method initializes an instance of the class.
	 * @param string $meta_key This argument receives the name of the parameter to be returned.
	 * @param Wphh_Data_Types $data_type
	 * @param Wphh_Request_Type $request_type
	 * @param mixed|null $default_value This argument receives the default value to be returned if the parameter is not found.
	 */
	public function __construct(
		string $meta_key,
		Wphh_Data_Types $data_type = Wphh_Data_Types::STRING,
		Wphh_Request_Type $request_type = Wphh_Request_Type::POST,
		mixed $default_value = null
	) {
		$this->meta_key = $meta_key;
		$this->request_type = $request_type;
		$this->data_type = $data_type;
		$this->default_value = $default_value;
	}
}