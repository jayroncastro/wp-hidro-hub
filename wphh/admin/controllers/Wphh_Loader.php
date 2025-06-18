<?php

/**
 * This file is part of the WordPress WP Hidro Hub plugin.
 * @author Jayron Castro <eu@jayroncastro.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 * @link https://www.wphidrohub.com
 * @version 1.0.0
 * @since 1.0.0
 */
namespace wphh\admin\controllers;

use Exception;
use wphh\admin\models\Wphh_Options_Manager;
use wphh\shared\enums\Wphh_Taxonomy_Name;
use wphh\shared\Wphh_Menu_Manager;
use wphh\shared\Wphh_View_Validator;
use wphh\admin\models\Wphh_Database;

/**
 * This class is the main controller of the plugin, it triggers all other methods
 * @package wphh
 * @subpackage admin/controllers
 * @since 1.0.0
 */
class Wphh_Loader {

	/**
	 * This argument stores an object of the type `Wphh_Custom_Post_Types`
	 * @var Wphh_Custom_Post_Types
	 * @access private
	 * @since 1.0.0
	 */
	private Wphh_Custom_Post_Types $_custom_post_types;

	/**
	 * This argument stores an object of the type `Wphh_Menu_Manager`
	 * @var Wphh_Menu_Manager
	 * @access private
	 * @since 1.0.0
	 */
	private Wphh_Menu_Manager $_menu_manager;

	/**
	 * This method initializes an instance of the class.
	 * @access public
	 * @return void
	 * @since 1.0.0
	 */
	public function __construct() {
		new Wphh_Options_Manager();
		$this->registerPlugin();
		$this->_custom_post_types = new Wphh_Custom_Post_Types();
		$this->_menu_manager = new Wphh_Menu_Manager();
		$this->_custom_post_types->create_all();
		add_action( 'admin_menu', [ $this->_menu_manager, 'add_master_menu' ] );
		add_action( 'admin_enqueue_scripts', function () {
			Wphh_View_Validator::enqueue_assets();
		});
	}

	/**
	 * This method registers the plugin in WORDPRESS
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function registerPlugin(): void {
		register_activation_hook( WPHH_FILE, [$this, 'activate'] );
		register_deactivation_hook( WPHH_FILE, [$this, 'deactivate'] );
		register_uninstall_hook( WPHH_FILE, [ __CLASS__, 'uninstall' ] );
	}

	/**
	 * This method activates the plugin in WORDPRESS
	 * @access public
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function activate(): void {
		#before continuing, you must test the php version
		#update_option( 'rewrite_rules', '' );
		flush_rewrite_rules();
		new Wphh_Database()->initialize_database();
	}

	/**
	 * This method disables the plugin in WORDPRESS
	 * @access public
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function deactivate(): void {
		flush_rewrite_rules();
		#$this->_custom_post_types->destroy_all();
	}

	/**
	 * This method removes the plugin in WORDPRESS
	 * @access public
	 * @since 1.0.0
	 * @static
	 * @return void
	 */
	public static function uninstall(): void {

	}

}