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
 * This class manages all menus used by the plugin.
 * @package wphh
 * @subpackage shared
 * @since 1.0.0
 * @final
 */
final class Wphh_Menu_Manager {

	private string $_menu_slug;

	public function __construct() {
		$this->_menu_slug = 'wphh_dashboard';
	}

	private function _add_all_submenus(): void {
		$this->_add_submenu_customers();
	}

	public function add_master_menu(): void {
		add_menu_page(
			'WP Hidro Hub Dashboard',
			WPHH_MAIN_MENU,
			'manage_options',
			$this->_menu_slug,
			[$this, 'render_menu'],
			WPHH_MAIN_ICON,
			81
		);
		$this->_add_all_submenus();
	}

	private function _add_submenu_customers(): void {
		add_submenu_page(
			$this->_menu_slug,
			'Customers',
			'Manage Customers',
			'manage_options',
			'edit.php?post_type=wphh_customer',
			null,
			null
		);
	}

	public function render_menu(): void {
		#error_log(get_current_screen());
		echo "var_dump: " . "<pre>" . var_dump(get_current_screen()) . "</pre>" . "<br>";
		echo "RenderMenu - WP Hidro Hub Settings<br>";
		echo 'ABSPATH: ' . ABSPATH . "<br>";
		echo 'WP_HIDRO_HUB_DIR: ' . WPHH_DIR . "<br>";
		echo 'WP_HIDRO_HUB_FILE: ' . WPHH_FILE . "<br>";
		echo 'DB_CHARSET: ' . DB_CHARSET . "<br>";
		echo 'DB_COLLATE: ' . DB_COLLATE . "<br>";
	}
}