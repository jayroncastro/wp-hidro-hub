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
 * This class is used to return all values of variables sent via HTTP methods. (example: $_POST and $_GET)
 * @package wphh
 * @subpackage shared
 * @since 1.0.0
 */
class Wphh_Request {

	/**
	 * This argument stores all the parameters of a request.
	 * @var Wphh_Request_params
	 * @access private
	 * @since 1.0.0
	 */
	private Wphh_Request_params $_params;

	/**
	 * This argument stores an HTTP verb for retrieving variables. (example: POST, GET)
	 * @var array
	 * @access private
	 * @since 1.0.0
	 */
	private array $_source;

	/**
	 * This argument stores the value retrieved from the variable in raw form.
	 * @var mixed
	 * @access private
	 * @since 1.0.0
	 */
	private mixed $_raw_value;

	/**
	 * This method initializes an instance of the class.
	 * @access public
	 * @since 1.0.0
	 * @param Wphh_Request_Params $params
	 */
	public function __construct( Wphh_Request_Params $params ) {
		$this->_params = $params;
	}

	/**
	 * This method returns true if the variable specified in the constructor exists.
	 * @access public
	 * @since 1.0.0
	 * @return bool
	 */
	public function hasKey(): bool {
		return isset( $this->_source[ $this->_params->param_name ] );
	}

	/**
	 * Retrieves and sanitizes a parameter from the request based on the provided parameters.
	 * @access public
	 * @since 1.0.0
	 * @return Wphh_Request_Result
	 */
	public function get_param(): Wphh_Request_Result {
		$this->_set_source();
		$this->_get_raw_value();
		return match ( $this->_params->data_type ) {
			Wphh_Data_Types::EMAIL     => new Wphh_Request_Email_Result( sanitize_email( (string) $this->_raw_value ) ),
			Wphh_Data_Types::INT       => new Wphh_Request_Int_Result( intval( $this->_raw_value ) ),
			Wphh_Data_Types::FLOAT     => new Wphh_Request_Float_Result( floatval( $this->_raw_value ) ),
			Wphh_Data_Types::BOOL      => new Wphh_Request_Bool_Result( filter_var( $this->_raw_value, FILTER_VALIDATE_BOOLEAN ) ),
			Wphh_Data_Types::URL       => new Wphh_Request_Url_Result( esc_url_raw( (string) $this->_raw_value ) ),
			Wphh_Data_Types::TEXTAREA  => new Wphh_Request_Textarea_Result( sanitize_textarea_field( (string) $this->_raw_value ) ),
			Wphh_Data_Types::HTML      => new Wphh_Request_Html_Result( wp_kses_post( (string) $this->_raw_value ) ),
			Wphh_Data_Types::ARRAY     => new Wphh_Request_Array_Result( $this->_sanitize_array( $this->_raw_value ) ),
			Wphh_Data_Types::RAW       => new Wphh_Request_Raw_Result( $this->_raw_value ),
			default                    => new Wphh_Request_String_Result( sanitize_text_field( (string) $this->_raw_value ) ),
		};
	}

	/**
	 * Sets the source array ($_GET or $_POST) based on the request type.
	 * @access private
	 * @since 1.0.0
	 * @return void
	 */
	private function _set_source(): void {
		$this->_source = match ( $this->_params->request_type ) {
			Wphh_Request_Type::GET => $_GET,
			default                => $_POST,
		};
	}

	/**
	 * Retrieves the raw value from the source array, if the parameter is not set, it uses the default_value from Wphh_Request_Params.
	 * @access private
	 * @since 1.0.0
	 * @return void
	 */
	private function _get_raw_value(): void {
		if ( isset( $this->_source[ $this->_params->param_name ] ) ) {
			$this->_raw_value = $this->_source[ $this->_params->param_name ];
		} else {
			$this->_raw_value = $this->_params->default_value;
		}
	}

	/**
	 * Sanitizes an array recursively.
	 * @param mixed $array_data
	 * @access private
	 * @since 1.0.0
	 * @return array
	 */
	private function _sanitize_array( mixed $array_data ): array {
		$sanitized_array = [];
		if ( ! is_array( $array_data ) ) {
			$sanitized_array = is_null( $array_data ) ? [] : [sanitize_text_field( (string) $array_data )];
		} else {
			foreach ( $array_data as $key => $value ) {
				$sanitized_key = sanitize_key( (string) $key );
				if ( is_array( $value ) ) {
					$sanitized_array[ $sanitized_key ] = $this->_sanitize_array( $value );
				} elseif ( is_object( $value ) ) {
					$sanitized_array[ $sanitized_key ] = sanitize_text_field( (string) $value );
				}
				else {
					$sanitized_array[ $sanitized_key ] = sanitize_text_field( (string) $value );
				}
			}
		}
		return $sanitized_array;
	}

}