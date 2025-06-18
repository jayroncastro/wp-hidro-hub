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

use wphh\shared\enums\Wphh_Meta_Object_Type;

/**
 * This class encapsulates the previous and new values of a data field, used in a form.
 * @package wphh
 * @subpackage shared
 * @since 1.0.0
 */
class Wphh_Meta_Field {

	/**
	 * This argument receives an object of type `Wphh_Meta_Object_Type`
	 * @access private
	 * @since 1.0.0
	 * @var Wphh_Meta_Object_Type
	 */
	private Wphh_Meta_Object_Type $_object_type;

	/**
	 * This argument receives an object of type `Wphh_Request_Params`
	 * @access private
	 * @since 1.0.0
	 * @var Wphh_Request_Params
	 */
	private Wphh_Request_Params $_object_params;

	/**
	 * This argument receives the `ID` that identifies the object in the database.
	 * @access private
	 * @since 1.0.0
	 * @var int
	 */
	private int $_object_id;

	/**
	 * This argument receives the old value of the field, referenced in the `_field_name` argument.
	 * @access private
	 * @since 1.0.0
	 * @var mixed
	 */
	private mixed $_prev_value {
		get {
			return $this->_prev_value;
		}
	}

	/**
	 * This method initializes an instance of the class.
	 * @access public
	 * @since 1.0.0
	 * @param Wphh_Meta_Object_Type $object_type This argument receives an object of the type `Wphh_Meta_Object_Type` and aims to set the field type.
	 * @param Wphh_Request_Params $object_params This argument receives an object of the type `Wp_Request_Params`, which encapsulates the name of the `Key` according to the database.
	 * @param int $object_id This argument stores the `ID` of the field, according to the database.
	 */
	public function __construct( Wphh_Meta_Object_Type $object_type, Wphh_Request_Params $object_params, int $object_id ) {
		$this->_object_type = $object_type;
		$this->_object_params = $object_params;
		$this->_object_id = $object_id;
		$this->_prev_value = $this->_get_meta_value();
	}

	/**
	 * This method returns the value of the field that is stored in the database.
	 * @access private
	 * @since 1.0.0
	 * @return mixed
	 */
	private function _get_meta_value(): mixed {
		return match ( $this->_object_type ) {
			Wphh_Meta_Object_Type::POST => get_post_meta(
				$this->_object_id,
				$this->_object_params->meta_key,
				true
			),
			Wphh_Meta_Object_Type::USER => get_user_meta(
				$this->_object_id,
				$this->_object_params->meta_key,
				true
			),
		};
	}

	/**
	 * @access public
	 * @since 1.0.0
	 * @return bool
	 */
	public function update_value(): bool {
		return match ( $this->_object_type ) {
			Wphh_Meta_Object_Type::POST => update_post_meta(
				$this->_object_id,
				$this->_meta_key,
				$meta_value,
				$this->_prev_value
			),
			Wphh_Meta_Object_Type::USER => update_user_meta(
				$this->_object_id,
				$this->_meta_key,
				$meta_value,
				$this->_prev_value
			),
		};
	}

}