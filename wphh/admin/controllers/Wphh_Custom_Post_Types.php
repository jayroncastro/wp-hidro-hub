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
use wphh\admin\controllers\models\Wphh_Cpt_Taxonomy_Info;
use wphh\shared\enums\Wphh_Data_Types;
use wphh\shared\enums\Wphh_Meta_Object_Type;
use wphh\shared\enums\Wphh_Plugin_Identifiers;
use wphh\shared\helpers\Wphh_Conditional_Debug_Logger;
use wphh\shared\helpers\Wphh_Helpers;
use wphh\shared\Wphh_Meta_Field;
use wphh\shared\Wphh_Request;
use wphh\shared\Wphh_Request_Params;

/**
 * This class manages all Custom Post Types used by the plugin.
 * @package wphh
 * @subpackage admin/controllers
 */
class Wphh_Custom_Post_Types {

	/**
	 * This argument stores an object of type Wphh_Metaboxes
	 * @var Wphh_Metaboxes $_metaboxes
	 * @access private
	 * @since 1.0.0
	 */
	private Wphh_Metaboxes $_metaboxes;

	/**
	 * This argument stores an object of type Wphh_Taxonomy
	 * @var Wphh_Taxonomy $_taxonomy
	 * @access private
	 * @since 1.0.0
	 */
	private Wphh_Taxonomy $_taxonomy;

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
		$this->_debug_logger = new Wphh_Conditional_Debug_Logger( __NAMESPACE__ );
		$this->_metaboxes = new Wphh_Metaboxes();
		$this->_taxonomy = new Wphh_Taxonomy();
	}

	/**
	 * This method registers the custom post-type of customers.
	 * @return void
	 * @access public
	 * @since 1.0.0
	 */
	public function create_customer_cpt(): void {
		$cpt = WPHH_PREFIX_PLUGIN . Wphh_Plugin_Identifiers::CUSTOMER->value;
		$this->_debug_logger->log_debug_message( 'create_customer_cpt: ' . $cpt );
		register_post_type(
			$cpt,
			[
				'label' => 'Customers',
				'description' => 'Stores customer registration information.',
				'labels' => [
					'name' => 'Customers',
					'singular_name' => 'Customer'
				],
				'public' => true,
				'supports' => [
					'title',
					#'editor',
					'thumbnail'
				],
				'rewrite' => [
					'slug' => 'customer'
				],
				'hierarchical' => false,
				'show_ui' => true,
				'show_in_menu' => true,
				'menu_position' => 5,
				'show_in_admin_bar' => true,
				'show_in_nav_menus' => false,
				'can_export' => true,
				'exclude_from_search' => false,
				'publicly_queryable' => false,
				'show_in_rest' => false,
				'menu_icon' => 'dashicons-groups',
				'register_meta_box_cb' => function () use ( $cpt ) {
					$this->_metaboxes->register_metaboxes( $cpt );
				}
			]);
	}

	/**
	 * This method registers the custom post-type of the product.
	 * @return void
	 * @access public
	 * @since 1.0.0
	 */
	public function create_product_cpt(): void {
		$cpt = WPHH_PREFIX_PLUGIN . Wphh_Plugin_Identifiers::PRODUCT->value;
		$this->_debug_logger->log_debug_message( 'create_product_cpt: ' . $cpt );
		register_post_type(
			$cpt,
			[
				'label' => 'Products',
				'description' => 'Stores product information.',
				'labels' => [
					'name' => 'Products',
					'singular_name' => 'Product',
					'add_new' => 'Add New Product',
					'add_new_item' => 'Add New Product',
				],
				'public' => true,
				'supports' => [
					'title',
					'thumbnail'
				],
				'rewrite' => [
					'slug' => 'product'
				],
				'hierarchical' => false,
				'show_ui' => true,
				'show_in_menu' => true,
				'menu_position' => 5,
				'show_in_admin_bar' => true,
				'show_in_nav_menus' => false,
				'can_export' => true,
				'exclude_from_search' => false,
				'publicly_queryable' => false,
				'show_in_rest' => false,
				'menu_icon' => 'dashicons-groups',
				'register_meta_box_cb' => function () use ( $cpt ) {
					$this->_metaboxes->register_metaboxes( $cpt );
				}
			]);
		add_action(
			'save_post',
			[ $this, 'save_cpt_product' ],
			10,
			2
		);
	}

	/**
	 * This method updates the Custom Post Type of Product in the database.
	 * @access public
	 * @since 1.0.0
	 * @param int $post_id This argument receives the `ID` of the Custom Post Type.
	 * @return void
	 */
	public function save_cpt_product( int $post_id ): void {
		$this->_debug_logger->log_debug_message( 'save_post_product > [post_id]: ' . $post_id );
		$request = new Wphh_Request( new Wphh_Request_Params( 'action' ) );
		if ( $request->hasKey() && $request->get_param()->get_value() === 'editpost' ){
			$production_cost_mft = new Wphh_Meta_Field(
				Wphh_Meta_Object_Type::POST,
				new Wphh_Request_Params(
					'production_cost',
					Wphh_Data_Types::FLOAT
				),
				$post_id,
			);
			$production_cost_mft->update_value();
		}
	}

	/**
	 * This method destroys all custom post-types.
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function destroy_all(): void {
		foreach ( $this->_get_managed_cpt_names() as $cpt ) {
			unregister_post_type( $cpt );
		}
	}


	/**
	 * This method creates all custom post-types.
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function create_all(): void {
		foreach ( $this->_get_managed_cpt_names() as $cpt ) {
			$this->_debug_logger->log_debug_message( 'Wphh_Custom_Post_Types - create_all - [CPT]: ' . $cpt );
			$name_method = Wphh_Helpers::get_method_name_register_cpt( $cpt );
			$this->_debug_logger->log_debug_message( 'Wphh_Custom_Post_Types - create_all - [name_method]: ' . $name_method );
			if ( method_exists( $this, $name_method ) ) {
				$this->_debug_logger->log_debug_message( 'Wphh_Custom_Post_Types - create_all - [method_exists]: True' );
				add_action( 'init', [ $this, $name_method ] );
				if ( $this->_taxonomy->has_taxonomy( $cpt ) ) {
					$this->_debug_logger->log_debug_message( 'Wphh_Custom_Post_Types - create_all - [has_taxonomy]: True' );
					add_action( 'registered_post_type_' . $cpt, function () use ( $cpt ) {
						$this->_taxonomy->register_taxonomies( $cpt );
					});
				}
			}
		}
	}

	/**
	 * This method returns the names of the custom post-types managed by this class.
	 * @access private
	 * @since 1.0.0
	 * @return array
	 */
	private function _get_managed_cpt_names(): array {
		return [
			WPHH_PREFIX_PLUGIN . Wphh_Plugin_Identifiers::CUSTOMER->value,
			WPHH_PREFIX_PLUGIN . Wphh_Plugin_Identifiers::PRODUCT->value
		];
	}

	/**
	 * This method returns an array with all custom post-types that need to have custom stylesheets.
	 * @access public
	 * @since 1.0.0
	 * @return array[]
	 */
	public function get_views_with_custom_css(): array {
		$array_cpts = [
			Wphh_Plugin_Identifiers::MAIN->value,
			WPHH_PREFIX_PLUGIN . Wphh_Plugin_Identifiers::CUSTOMER->value,
			'edit-' . WPHH_PREFIX_PLUGIN . Wphh_Plugin_Identifiers::CUSTOMER->value,
			WPHH_PREFIX_PLUGIN . Wphh_Plugin_Identifiers::PRODUCT->value,
			'edit-' . WPHH_PREFIX_PLUGIN . Wphh_Plugin_Identifiers::PRODUCT->value
		];
		$array_taxonomies = $this->_get_only_taxonomies_views_by_cpts( $array_cpts );
		if ( count( $array_taxonomies ) > 0 ) {
			$array_cpts = array_merge( $array_cpts, $array_taxonomies );
		}
		return $array_cpts;
	}

	/**
	 * This method returns an array with only the taxonomies registered by custom post-type
	 * @access private
	 * @since 1.0.0
	 * @param array $cpts This argument receives an array with custom post-type names.
	 * @return array
	 */
	private function _get_only_taxonomies_views_by_cpts( array $cpts ): array {
		$array_taxonomies = [];
		foreach ( $cpts as $cpt ) {
			$array_temp = $this->_taxonomy->get_taxonomies_for_cpt( $cpt );
			if ( count( $array_temp ) > 0 ) {
				$array_temp = array_map( function ( $item ) {
					return 'edit-' . $item;
				}, $array_temp );
				$array_taxonomies = array_merge( $array_taxonomies, $array_temp );
			}
		}
		return ( count( $array_taxonomies ) > 0 ) ? $array_taxonomies : [];
	}

	/**
	 * This method returns an array with all custom post-types that need to have custom JavaScripts.
	 * @access public
	 * @since 1.0.0
	 * @return string[]
	 */
	public function get_views_with_custom_js(): array {
		return [
			WPHH_PREFIX_PLUGIN . Wphh_Plugin_Identifiers::PRODUCT->value,
			'edit-' . WPHH_PREFIX_PLUGIN . Wphh_Plugin_Identifiers::PRODUCT->value
		];
	}

}