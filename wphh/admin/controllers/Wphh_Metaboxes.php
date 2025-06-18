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

use wphh\shared\helpers\Wphh_Helpers;

/**
 * This class manages all metabox fields used by the plugin.
 * @package wphh
 * @subpackage admin/controllers
 */
class Wphh_Metaboxes {

	/**
	 * This method initializes an instance of the class.
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct() {}

	/**
	 * This method registers a metabox for a custom post-type.
	 * @access public
	 * @since 1.0.0
	 * @param string $cpt This parameter is named after a custom post-type.
	 * @return void
	 */
	public function register_metaboxes( string $cpt ): void {
		$name_method = Wphh_Helpers::get_metabox_method_name( $cpt );
		if ( method_exists( $this, $name_method ) ) {
			call_user_func_array( [ $this, $name_method ], [ $cpt ] );
		}
	}

	/**
	 * This method adds metabox fields to the customer's custom post-type.
	 * @access private
	 * @since 1.0.0
	 * @param string $cpt This parameter is named after a custom post-type.
	 * @return void
	 */
	private function _add_customer_metaboxes( string $cpt ): void {
		add_meta_box(
			Wphh_Helpers::get_id_metabox( $cpt ),
			'Customer Data',
			[ $this, Wphh_Helpers::get_template_loader( $cpt ) ],
			$cpt,
			'normal',
			'high'
		);
	}

	/**
	 * This method adds metabox fields to the product custom post-type.
	 * @access private
	 * @since 1.0.0
	 * @param string $cpt This parameter is named after a custom post-type.
	 * @return void
	 */
	private function _add_product_metaboxes( string $cpt ): void {
		add_meta_box(
			Wphh_Helpers::get_id_metabox( $cpt ),
			'Product Data',
			[ $this, Wphh_Helpers::get_template_loader( $cpt ) ],
			$cpt,
			'normal',
			'high'
		);
	}

	/**
	 * This method adds the template in the custom post type of customers.
	 * @return void
	 * @access public
	 * @since 1.0.0
	 */
	public function add_inner_customer_metabox(): void {
		require_once WPHH_DIR . '/wphh/admin/views/wphh_customer_metabox_template.php';
	}

	/**
	 * This method adds the template in the custom post type of products.
	 * @return void
	 * @access public
	 * @since 1.0.0
	 */
	public function add_inner_product_metabox(): void {
		require_once WPHH_DIR . '/wphh/admin/views/wphh_product_metabox_template.php';
	}

}