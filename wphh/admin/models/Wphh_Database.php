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

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

use wpdb;
use wphh\shared\enums\Wphh_Data_Types_Options;
use wphh\shared\enums\Wphh_Option_Key;
use wphh\shared\helpers\Wphh_Conditional_Debug_Logger;

/**
 * This class is used to create the database tables needed by the plugin.
 * @package wphh
 * @subpackage admin/models
 * @since 1.0.0
 */
class Wphh_Database {

	/**
	 * Stores the WORDPRESS global variable `$wpdb`
	 * @var wpdb
	 * @access private
	 * @since 1.0.0
	 * @see https://developer.wordpress.org/reference/classes/wpdb/
	 */
    private wpdb $_db;

	/**
	 * Stores the prefix of the tables to be used in the plugin.
	 * @var string
	 * @access private
	 * @since 1.0.0
	 */
    private string $_prefix_plugin;

	/**
	 * Stores true only if an error occurred in the DML statement
	 * @var bool
	 * @access private
	 * @since 1.0.0
	 * @see https://www.php.net/manual/en/language.types.boolean.php
	 */
    private bool $_error_db;

	/**
	 * This argument receives an object of the type Wphh_Options_Manager.
	 * @var Wphh_Options_Manager $_options_manager
	 * @access private
	 * @since 1.0.0
	 */
	private Wphh_Options_Manager $_options_manager;

	/**
	 * This argument receives an object of the type Wphh_Conditional_Debug_Logger.
	 * @var Wphh_Conditional_Debug_Logger $_debug_logger
	 * @access private
	 * @since 1.0.0
	 */
	private Wphh_Conditional_Debug_Logger $_debug_logger;

	/**
	 * This method initializes an instance of the class.
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
    public function __construct() {
        global $wpdb;
		$this->_options_manager = new Wphh_Options_Manager();
		$this->_debug_logger = new Wphh_Conditional_Debug_Logger( __NAMESPACE__ );
        $this->_db = $wpdb;
        $this->_prefix_plugin = $this->_db->prefix . WPHH_PREFIX_DATABASE;
        $this->_error_db = false;
    }

	/**
	 * This method returns the character set and collation to be used in the database.
	 * @access private
	 * @return string
	 */
    private function _get_char_set(): string {
        return ! empty ( DB_CHARSET ) ? DB_CHARSET : 'utf8mb4';
    }

	/**
	 * This method returns the collation to be used in the database.
	 * @access private
	 * @return string
	 */
    private function _get_collate(): string {
        $collate = '';
        if ( defined('DB_COLLATE') && DB_COLLATE != '' ) {
            $collate = ' COLLATE=' . DB_COLLATE;
        }
        return $collate;
    }

	/**
	 * This method returns true if the database tables need to be updated.
	 * @access private
	 * @return bool
	 */
    private function _needs_database_tables_update(): bool {
		$db_version = empty(
			$this->_options_manager->get_value( Wphh_Option_Key::DB_VERSION->name ) )
			? 0
			: $this->_options_manager->get_value( Wphh_Option_Key::DB_VERSION->name );
		$this->_debug_logger->log_debug_message( 'db_version: ' . $db_version );
		return ( $db_version < WPHH_DB_VERSION );
    }

	/**
	 * This method updates the database version in WORDPRESS.
	 * @access private
	 * @return void
	 */
    private function _update_version_db(): void {
        if ( ! $this->_error_db ){
	        $this->_debug_logger->log_debug_message( 'updateVersionDb: True' );
	        $this->_options_manager->set_value(
				Wphh_Option_Key::DB_VERSION->name,
				WPHH_DB_VERSION,
				Wphh_Data_Types_Options::INT
	        );
        }
    }

	/**
	 * This method returns true if the table name provided was created in the database.
	 * @param string $table_name
	 * @access private
	 * @return bool
	 */
    private function _is_database_table_created( string $table_name ): bool {
        $sql = "SHOW TABLES LIKE '" . $table_name . "'";
        $result = $this->_db->get_var( $sql );
        return ! empty ( $result );
    }

	/**
	 * This method receives the name of a table and sets an error in the creation process.
	 * @param string $table_name
	 * @access private
	 * @return void
	 */
    private function _set_error_db( string $table_name ): void {
        if ( ! $this->_error_db ){
            if ( ! $this->_is_database_table_created( $table_name ) ) {
                $this->_error_db = true;
            }
        }
    }

	/**
	 * This method is used to record specific product prices for different price lists (identified by the `price_list_key`). It allows the system to quickly find the correct price for a product for a customer, based on the price list associated with it.
	 * @access private
	 * @since 1.0.0
	 * @param bool $create If this argument is true, the table will be created, and otherwise it will be updated.
	 * @return void
	 */
    private function _create_product_prices_table( bool $create = true ): void {
        $table_name = $this->_prefix_plugin . 'product_prices';
	    $sql = "";
		if ( $create ) {
			$sql = "
            CREATE TABLE IF NOT EXISTS $table_name (
                price_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                product_id BIGINT UNSIGNED NOT NULL,
                price_list_key VARCHAR(50) NOT NULL,
                price DECIMAL( 10,2 ) NOT NULL,
                PRIMARY KEY  ( price_id ),
                UNIQUE KEY idx_product_pricelist ( product_id, price_list_key ),
                KEY idx_product_id_prices ( product_id )
            ) ENGINE=InnoDB DEFAULT CHARSET=" . $this->_get_char_set() . $this->_get_collate() . ";";
		} else {
			#Here you must insert the code to update the table
		}
        dbDelta( $sql );
        $this->_set_error_db( $table_name );
    }

	/**
	 * This method is used to store the individual items (products/services) that make up each sales order (`order`). It stores essential details such as the product, the quantity (ordered, delivered, returned, damaged), the unit price charged for the sale and the original batch (`batch_id`) of the delivered product, ensuring traceability and allowing accurate order and reconciliation calculations.
	 * @access private
	 * @since 1.0.0
	 * @param bool $create If this argument is true, the table will be created, and otherwise it will be updated.
	 * @return void
	 */
    private function _create_order_items_table( bool $create = true ): void {
        $table_name = $this->_prefix_plugin . 'order_items';
	    $sql = "";
	    if ( $create ) {
		    $sql = "
            CREATE TABLE IF NOT EXISTS $table_name (
                order_item_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                order_id BIGINT UNSIGNED NOT NULL,
                product_id BIGINT UNSIGNED NOT NULL,
                lot_id BIGINT UNSIGNED NULL,
                quantity_ordered INT UNSIGNED NOT NULL,
                quantity_delivered INT UNSIGNED NULL,
                quantity_returned INT UNSIGNED NULL,
                quantity_damaged INT UNSIGNED NULL,
                unit_price DECIMAL( 10,2 ) NOT NULL,
                subtotal DECIMAL( 12,2 ) NOT NULL,
                PRIMARY KEY  ( order_item_id ),
                KEY idx_order_id ( order_id ),
                KEY idx_product_id ( product_id ),
                KEY idx_lot_id ( lot_id )
            ) ENGINE=InnoDB DEFAULT CHARSET=" . $this->_get_char_set() . $this->_get_collate() . ";";
	    } else {
		    #Here you must insert the code to update the table
	    }
        dbDelta( $sql );
        $this->_set_error_db( $table_name );
    }

	/**
	 * This method is used to maintain the updated inventory balance for each specific combination of product and production batch (`batch_id`). It is the core of batch-based inventory control, recording the available quantity (`quantity`) that has been released by quality and allowing specific batch write-off during shipping to ensure traceability. Essential for availability queries and for allocation logic (FIFO or simplified).
	 * @access private
	 * @since 1.0.0
	 * @param bool $create If this argument is true, the table will be created, and otherwise it will be updated.
	 * @return void
	 */
    private function _create_stock_levels_table( bool $create = true ): void {
        $table_name = $this->_prefix_plugin . 'stock_levels';
		$sql = "";
	    if ( $create ) {
		    $sql = "
            CREATE TABLE IF NOT EXISTS $table_name (
                stock_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                product_id BIGINT UNSIGNED NOT NULL,
                lot_id BIGINT UNSIGNED NOT NULL,
                quantity INT UNSIGNED NOT NULL DEFAULT 0,
                last_updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY  ( stock_id ),
                UNIQUE KEY idx_product_lote ( product_id, lot_id ),
                KEY idx_product_id_stock ( product_id ),
                KEY idx_lote_id_stock ( lot_id )
            ) ENGINE=InnoDB DEFAULT CHARSET=" . $this->_get_char_set() . $this->_get_collate() . ";";
		    dbDelta( $sql );
	    } else {
		    #Here you must insert the code to update the table
	    }

        $this->_set_error_db( $table_name );
    }

	/**
	 * This method serves to store a detailed record for each commission generated from an order. It stores the calculated value, the rate used, the seller, the originating order, the event that triggered the calculation (configurable trigger) and the status of the commission (pending, earned/released, paid).
	 * @access private
	 * @since 1.0.0
	 * @param bool $create If this argument is true, the table will be created, and otherwise it will be updated.
	 * @return void
	 */
    private function _create_commission_records_table( bool $create = true ): void {
        $table_name = $this->_prefix_plugin . 'commission_records';
	    $sql = "";
	    if ( $create ) {
		    $sql = "
            CREATE TABLE IF NOT EXISTS $table_name (
                commission_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                order_id BIGINT UNSIGNED NOT NULL,
                salesperson_id BIGINT UNSIGNED NOT NULL,
                commission_rate DECIMAL( 5,2 ) NOT NULL,
                base_amount DECIMAL( 10,2 ) NOT NULL,
                commission_amount DECIMAL( 10,2 ) NOT NULL,
                trigger_event VARCHAR(50) NOT NULL,
                status VARCHAR( 20 ) NOT NULL DEFAULT 'pending',
                earned_date DATETIME NULL,
                paid_date DATETIME NULL,
                PRIMARY KEY  ( commission_id ),
                KEY idx_order_id_comm ( order_id ),
                KEY idx_salesperson_id_comm ( salesperson_id ),
                KEY idx_status_comm ( status )
            ) ENGINE=InnoDB DEFAULT CHARSET=" . $this->_get_char_set() . $this->_get_collate() . ";";
	    } else {
		    #Here you must insert the code to update the table
	    }
        dbDelta( $sql );
        $this->_set_error_db( $table_name );
    }

	/**
	 * This method will serve as a centralized audit trail, recording important events and actions performed within the plugin (order creation, status change, batch release, inventory adjustment, configuration change, etc.). It stores who (`user_id`) did what (`action`), when (`log_timestamp`), on which object (`object_type`, `object_id`) and additional details. Essential for security, action traceability, and compliance.
	 * @access private
	 * @since 1.0.0
	 * @param bool $create If this argument is true, the table will be created, and otherwise it will be updated.
	 * @return void
	 */
    private function _create_audit_log_table( bool $create = true ): void {
        $table_name = $this->_prefix_plugin . 'audit_log';
	    $sql = "";
	    if ( $create ) {
		    $sql = "
            CREATE TABLE IF NOT EXISTS $table_name (
                log_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                user_id BIGINT UNSIGNED NOT NULL,
                log_timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                action VARCHAR( 100 ) NOT NULL,
                object_type VARCHAR( 50 ) NOT NULL,
                object_id BIGINT UNSIGNED NOT NULL,
                details TEXT NULL,
                PRIMARY KEY  ( log_id ),
                KEY idx_user_time ( user_id, log_timestamp ),
                KEY idx_object ( object_type, object_id ),
                KEY idx_action ( action )
            ) ENGINE=InnoDB DEFAULT CHARSET=" . $this->_get_char_set() . $this->_get_collate() . ";";
	    } else {
		    #Here you must insert the code to update the table
	    }
        dbDelta( $sql );
        $this->_set_error_db( $table_name );
    }

	/**
	 * This method initializes the table structure needed by the plugin, directly in the WordPress database.
	 * @access public
	 * @return void
	 */
    public function initialize_database(): void {
		$initialize = $this->_needs_database_tables_update();
		$this->_debug_logger->log_debug_message( 'initializeDatabase: ' . $initialize );
        if ( $initialize ){
	        $this->_create_product_prices_table();
			$this->_create_order_items_table();
			$this->_create_stock_levels_table();
			$this->_create_commission_records_table();
			$this->_create_audit_log_table();
            $this->_update_version_db();
        }
    }

}