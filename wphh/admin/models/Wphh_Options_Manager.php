<?php

/**
 * This file is part of the WordPress WP Hidro Hub plugin.
 * @author Jayron Castro <eu@jayroncastro.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 * @link https://www.wphidrohub.com
 * @version 1.0.0
 * @since 1.0.0
 */
namespace wphh\admin\models;

use wphh\shared\enums\Wphh_Data_Types_Options;
use wphh\shared\helpers\Wphh_Conditional_Debug_Logger;

/**
 * This class manages all operations of the WPHidroHub plugin along with the wp_options table.
 * @package wphh
 * @subpackage admin/models
 * @since 1.0.0
 */
class Wphh_Options_Manager {

	/**
	 * This argument stores the contents of the option_value column belonging to the `wphh_settings` key stored in option_name, in the wp_options table.
	 * @access private
	 * @since 1.0.0
	 * @var array $_option_value
	 */
	private array $_option_value;

	/**
	 * This argument stores an object of the type Wphh_Conditional_Debug_Logger.
	 * @access private
	 * @since 1.0.0
	 * @var Wphh_Conditional_Debug_Logger $_debug_logger
	 */
	private Wphh_Conditional_Debug_Logger $_debug_logger;

	/**
	 * This method initializes an instance of the class.
	 * @access public
	 * @return void
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->_debug_logger = new Wphh_Conditional_Debug_Logger( __NAMESPACE__ );
		if ( ! $this->_option_exists() ) {
			add_option( WPHH_CONFIGURATION_KEY, [] );
		}
	}

	/**
	 * This method creates or updates a key and its value in `wphh_settings` that is stored in `wp_options`.
	 * @access public
	 * @since 1.0.0
	 * @param string $key This parameter receives the name of a key to be created or updated in `wphh_settings`.
	 * @param string|int|bool|float $value This parameter receives the value of the key to be created or updated in `wphh_settings`.
	 * @param Wphh_Data_Types_Options $data_types_options
	 * @return void
	 */
	public function set_value(
		string $key,
		string|int|bool|float $value,
		Wphh_Data_Types_Options $data_types_options = Wphh_Data_Types_Options::STRING
	): void {
		$this->_pull_option();
		$this->_debug_logger->log_debug_message( 'set_value: ' . $key . ' -> ' . $value );
		$cast_value = $this->_cast_value( $value, $data_types_options );
		$this->_option_value = array_replace( $this->_option_value, [ strtolower( $key ) => $cast_value ] );
		$this->_debug_logger->log_debug_message( 'array: ' . serialize( $this->_option_value ) );
		$this->_push_option();
	}

	/**
	 * This method performs a `cast` of the value, according to the type provided.
	 * @access private
	 * @since 1.0.0
	 * @param string $value This parameter receives the value of the key to be created or updated in `wphh_settings`.
	 * @param Wphh_Data_Types_Options $data_types_options
	 * @return string|int|bool|float
	 */
	private function _cast_value( string $value, Wphh_Data_Types_Options $data_types_options ): string|int|bool|float {
		return match ( strtolower( $data_types_options->name ) ) {
			'int' => intval( $value ),
			'float' => floatval( $value ),
			'bool' => boolval( $value ),
			default => $value,
		};
	}

	/**
	 * This argument receives the value of a key belonging to `wphh_settings` that is stored in `wp_options`.
	 * @access public
	 * @since 1.0.0
	 * @param string $key This parameter receives the name of a key to be returned from `wphh_settings`.
	 * @return string|int|bool|float
	 */
	public function get_value( string $key ): string|int|bool|float {
		$value = "";
		if ( $this->_option_exists() ) {
			$this->_pull_option();
			if ( $this->_key_exists( strtolower( $key ) ) ) {
				$value = $this->_option_value[ strtolower( $key ) ];
			}
		}
		return $value;
	}

	/**
	 * This method returns true if a key exists in `wphh_settings` that is stored in `wp_options`
	 * @access private
	 * @since 1.0.0
	 * @param string $key This parameter receives the name of a key to be created or updated in `wphh_settings`.
	 * @return bool
	 */
	private function _key_exists( string $key ): bool {
		return array_key_exists( strtolower( $key ), $this->_option_value );
	}

	/**
	 * This method returns true if the `wphh_settings` key exists in `wp_options`.
	 * @access private
	 * @since 1.0.0
	 * @return bool
	 */
	private function _option_exists(): bool {
		return ! empty( get_option( WPHH_CONFIGURATION_KEY ) );
	}

	/**
	 * This method returns the contents of the `wphh_settings` key, which is stored in `wp_options` and saved in the `$this->_option_value` argument.
	 * @access private
	 * @since 1.0.0
	 * @return void
	 */
	private function _pull_option(): void {
		$this->_option_value = get_option( WPHH_CONFIGURATION_KEY );
	}

	/**
	 * This method writes the contents of the `$this->_option_value` argument to the `wp_options` table.
	 * @access private
	 * @since 1.0.0
	 * @return void
	 */
	private function _push_option(): void {
		update_option( WPHH_CONFIGURATION_KEY, $this->_option_value );
	}
}