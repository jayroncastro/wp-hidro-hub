<?php

/**
 * This file is part of the WordPress WP Hidro Hub plugin.
 * @author Jayron Castro <eu@jayroncastro.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 * @link https://www.wphidrohub.com
 * @version 1.0.0
 * @since 1.0.0
 */
namespace wphh\shared\helpers;

/**
 * This class is responsible for writing log messages.
 * @package wphh
 * @subpackage shared/helpers
 */
class Wphh_Conditional_Debug_Logger {

	/**
	 * This argument stores the custom file for the application logs.
	 * @var ?string $_log_file
	 * @access private
	 * @since 1.0.0
	 */
	private ?string $_log_file;

	/**
	 * This argument stores the namespace of the class you are instantiating.
	 * @var string
	 * @access private
	 * @since 1.0.0
	 */
	private string $_namespace;

	/**
	 * This method initializes an instance of the class.
	 * @access public
	 * @since 1.0.0
	 * @param string $namespace
	 * @param ?string $log_file
	 */
	public function __construct( string $namespace, ?string $log_file = NULL ) {
		$this->_namespace = $namespace;
		$this->_log_file = $log_file;
	}

	/**
	 * This method writes a log message.
	 * @access public
	 * @since 1.0.0
	 * @param string $message
	 * @return void
	 */
	public function log_debug_message( string $message ): void {
		if ( $this->_write_log() ) {
			if ( empty( $this->_log_file ) ) {
				error_log( $message );
			} else {
				error_log( $message, 3, $this->_log_file );
			}
		}
	}

	/**
	 * This method returns the namespace of the class that triggered this method.
	 * @access private
	 * @since 1.0.0
	 * @return string
	 */
	private function _get_calling_class_namespace(): string {
		$array = explode( '\\', $this->_namespace );
		return $array[ count( $array ) - 1 ];
	}

	/**
	 * This method returns true if there is a need to write the log.
	 * @access private
	 * @since 1.0.0
	 * @return bool
	 */
	private function _write_log(): bool {
		$write = false;
		if ( WPHH_ERROR_LOG ) {
			$namespace = $this->_get_calling_class_namespace();
			if ( ( $namespace === 'models' ) && ( in_array( ERROR_LEVEL, [1,3] ) ) ) {
				$write = true;
			} elseif ( ( $namespace === 'controllers' ) && ( in_array( ERROR_LEVEL, [2,3] ) ) ) {
				$write = true;
			} elseif ( ( ! in_array( $namespace, [ 'models', 'controllers' ] ) ) && ( ERROR_LEVEL == 3 ) ) {
				$write = true;
			}
		}
		return $write;
	}
}