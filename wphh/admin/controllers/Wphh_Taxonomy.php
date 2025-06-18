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

use wphh\admin\controllers\models\Wphh_Cpt_Taxonomy_Info;
use wphh\admin\models\dtos\Wphh_Taxonomy_Dto;
use wphh\admin\models\Wphh_Options_Manager;
use wphh\shared\enums\Wphh_Data_Types_Options;
use wphh\shared\enums\Wphh_Option_Key;
use wphh\shared\enums\Wphh_Plugin_Identifiers;
use wphh\shared\enums\Wphh_Taxonomy_Name;
use wphh\shared\helpers\Wphh_Conditional_Debug_Logger;
use wphh\shared\helpers\Wphh_Helpers;

/**
 * This class manages all Taxonomy used by the plugin.
 * @package wphh
 * @subpackage admin/controllers
 */
class Wphh_Taxonomy {

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
		$this->_options_manager = new Wphh_Options_Manager();
		$this->_debug_logger = new Wphh_Conditional_Debug_Logger( __NAMESPACE__ );
		$this->_load_initial_taxonomy_data();
	}

	/**
	 * This method registers all taxonomies for a given Custom Post-Type.
	 * @access public
	 * @since 1.0.0
	 * @param string $cpt This argument receives the name of a Custom Post-Type
	 * @return void
	 */
	public function register_taxonomies( string $cpt ): void {
		$taxonomies = $this->get_taxonomies_for_cpt( $cpt );
		$this->_debug_logger->log_debug_message( 'register_taxonomies - [taxonomies]: ' . serialize( $taxonomies ) );
		foreach ( $taxonomies as $taxonomy ) {
			$name_method = Wphh_Helpers::get_taxonomy_method_name( $taxonomy );
			if ( method_exists( $this, $name_method ) ) {
				call_user_func( [ $this, $name_method ],
					new Wphh_Cpt_Taxonomy_Info( $cpt, $taxonomy )
				);
			}
		}
	}

	/**
	 * This method registers a taxonomy for the given custom post-type product type.
	 * @access public
	 * @since 1.0.0
	 * @param Wphh_Cpt_Taxonomy_Info $param
	 * @return void
	 */
	public function create_product_category_taxonomy( Wphh_Cpt_Taxonomy_Info $param ): void {
		$taxonomy_id = $param->taxonomy;
		$this->_debug_logger->log_debug_message( 'create_product_category_taxonomy -> $taxonomy_id: ' . $taxonomy_id );
		register_taxonomy(
			$taxonomy_id,
			$param->cpt,
			[
				'labels' => [
					'name' => 'Products Categories',
					'singular_name' => 'Product Category',
				],
				'hierarchical' => true,
				'show_in_rest' => false,
				'public' => true,
				'show_admin_column' => true
			]
		);
	}

	/**
	 * This method registers a taxonomy for the given custom post-type product status.
	 * @access public
	 * @since 1.0.0
	 * @param Wphh_Cpt_Taxonomy_Info $param
	 * @return void
	 */
	public function create_product_status_taxonomy( Wphh_Cpt_Taxonomy_Info $param ): void {
		$taxonomy_id = $param->taxonomy;
		$this->_debug_logger->log_debug_message( 'create_product_status_taxonomy -> $taxonomy_id: ' . $taxonomy_id );
		register_taxonomy(
			$taxonomy_id,
			$param->cpt,
			[
				'labels' => [
					'name' => 'Products Status',
					'singular_name' => 'Product Status',
				],
				'hierarchical' => false,
				'show_in_rest' => false,
				'public' => true,
				'show_admin_column' => true
			]
		);
	}

	private function _create_hook_load_product_status_taxonomy(): void {
		$hook_name = 'registered_taxonomy_' . Wphh_Helpers::get_id_taxonomy(
						 Wphh_Taxonomy_Name::PRODUCT_STATUS->name
		             );
		$this->_debug_logger->log_debug_message( '_create_hook_load_product_status_taxonomy -> hook_name: ' . $hook_name );
		add_action(
			$hook_name,
			[$this, 'initially_populate_product_status_taxonomy' ],
			10,
			3
		);
	}

	private function _create_hook_load_product_category_taxonomy(): void {
		$hook_name = 'registered_taxonomy_' . Wphh_Helpers::get_id_taxonomy(
				Wphh_Taxonomy_Name::PRODUCT_CATEGORY->name
			);
		$this->_debug_logger->log_debug_message( '_create_hook_load_product_category_taxonomy -> hook_name: ' . $hook_name );
		add_action(
			$hook_name,
			[$this, 'initially_populate_product_category_taxonomy' ],
			10,
			3
		);
	}

	public function initially_populate_product_status_taxonomy(): void {
		$this->_debug_logger->log_debug_message( 'initially_populate_product_status_taxonomy: ' );
		$value = $this->_options_manager->get_value( Wphh_Option_Key::TAXONOMY_PRODUCT_STATUS->name );
		if ( ! $value ) {
			$taxonomy_id = Wphh_Helpers::get_id_taxonomy( Wphh_Taxonomy_Name::PRODUCT_STATUS->name );
			$term_1 = new Wphh_Taxonomy_Dto(
				'Active',
				$taxonomy_id,
				'This taxonomy indicates that the product is active'
			);
			$term_2 = new Wphh_Taxonomy_Dto(
				'Inactive',
				$taxonomy_id,
				'This taxonomy indicates that the product is inactive'
			);

			$terms = get_terms( [
					'taxonomy' => $taxonomy_id,
					'hide_empty' => false ]
			);
			if ( empty( $terms ) ) {
				foreach ( [ $term_1, $term_2 ] as $term) {
					wp_insert_term(
						$term->term_id,
						$term->taxonomy_id,
						[
							'description' => $term->description,
						]
					);
				}
			}

			$this->_options_manager->set_value(
				Wphh_Option_Key::TAXONOMY_PRODUCT_STATUS->name,
				true,
				Wphh_Data_Types_Options::BOOL
			);
		}
	}

	public function initially_populate_product_category_taxonomy(): void {
		$value = $this->_options_manager->get_value(
			Wphh_Option_Key::TAXONOMY_PRODUCT_CATEGORY->name
		);
		if ( ! $value ) {
			$taxonomy_id         = Wphh_Helpers::get_id_taxonomy( Wphh_Taxonomy_Name::PRODUCT_CATEGORY->name );
			$term_1              = new Wphh_Taxonomy_Dto(
				'Disposable Packaging',
				$taxonomy_id,
				'This is the parent category for disposable packaging.'
			);
			$term_2              = new Wphh_Taxonomy_Dto(
				'Services',
				$taxonomy_id,
				'This is the parent category for disposable packaging.'
			);

			$terms = get_terms( [
					'taxonomy' => $taxonomy_id,
					'hide_empty' => false ]
			);
			if ( empty( $terms ) ) {
				foreach ( [ $term_1, $term_2 ] as $term) {
					wp_insert_term(
						$term->term_id,
						$term->taxonomy_id,
						[
							'description' => $term->description,
						]
					);
				}
				$this->_register_child_product_category_taxonomies( [ $term_1, $term_2 ] );
			}

			$this->_options_manager->set_value(
				Wphh_Option_Key::TAXONOMY_PRODUCT_CATEGORY->name,
				true,
				Wphh_Data_Types_Options::BOOL
			);
		}
	}

	/**
	 * This method registers child taxonomies for the given product category.
	 * @access private
	 * @since 1.0.0
	 * @param array $terms This argument receives an array of `Wphh_Taxonomy_Dto objects`.
	 * @return void
	 */
	private function _register_child_product_category_taxonomies( array $terms ): void {
		$control = 0;
		foreach ( $terms as $term ) {
			if ( $term instanceof Wphh_Taxonomy_Dto ){
				$control++;
				$parent = get_term_by( 'name', $term->term_id, $term->taxonomy_id );
				$this->_debug_logger->log_debug_message( '_register_child_product_category_taxonomies -> (parent): ' . serialize($parent) );
				if ( $parent ){
					$child_term = new Wphh_Taxonomy_Dto(
						$this->_get_term_id_by_control( $control ),
						$term->taxonomy_id,
						$this->_get_term_description_by_control( $control ),
						$parent->term_id
					);
					$this->_debug_logger->log_debug_message( '_register_child_product_category_taxonomies -> (child_term): ' . serialize($child_term) );
					wp_insert_term(
						$child_term->term_id,
						$child_term->taxonomy_id,
						[
							'description' => $child_term->description,
							'parent' => $child_term->parent,
						]
					);
				}
			}
		}
	}

	/**
	 * This method will return the `term_id` field according to the value of the control variable provided.
	 * @access private
	 * @since 1.0.0
	 * @param int $control This argument receives a control variable, as the return will be according to the value of this variable.
	 * @return string
	 */
	private function _get_term_id_by_control( int $control ): string {
		return match ( $control ) {
			1 => 'PET Bottles (Package)',
			2 => '20L Bottle Refill'
		};
	}

	/**
	 * This method will return the `term_description` field according to the value of the control variable provided.
	 * @access private
	 * @since 1.0.0
	 * @param int $control This argument receives a control variable, as the return will be according to the value of this variable.
	 * @return string
	 */
	private function _get_term_description_by_control( int $control ): string {
		return match ( $control ) {
			1 => 'This taxonomy represents all products that can be classified as PET bottles and stored in packaged form.',
			2 => 'This taxonomy represents the service of filling 20L bottles.'
		};
	}

	/**
	 * This method returns a database with the taxonomies used in this plugin.
	 * @access private
	 * @since 1.0.0
	 * @return array[]
	 */
	private function _get_taxonomies_base(): array {
		return [
			strtolower( WPHH_PREFIX_PLUGIN .
			            Wphh_Plugin_Identifiers::PRODUCT->value ) => [
				strtolower( WPHH_PREFIX_PLUGIN .
				            Wphh_Taxonomy_Name::PRODUCT_CATEGORY->name ),
				strtolower( WPHH_PREFIX_PLUGIN .
				            Wphh_Taxonomy_Name::PRODUCT_STATUS->name )
			]
		];
	}

	/**
	 * This method returns all taxonomies belonging to a given Custom Post-Type.
	 * @access public
	 * @since 1.0.0
	 * @return string[]
	 */
	public function get_taxonomies_for_cpt( string $cpt ): array {
		$out = [];
		$array = $this->_get_taxonomies_base();
		foreach ( $array as $key => $value ) {
			if ( $key == $cpt ) {
				$out = $value;
			}
		}
		return $out;
	}

	/**
	 * This method returns an array with all taxonomies that need initial loading.
	 * @access private
	 * @since 1.0.0
	 * @return array
	 */
	private function _get_taxonomies_needing_initial_load(): array {
		return [
			strtolower( WPHH_PREFIX_PLUGIN .
			            Wphh_Taxonomy_Name::PRODUCT_CATEGORY->name ),
			strtolower( WPHH_PREFIX_PLUGIN .
			            Wphh_Taxonomy_Name::PRODUCT_STATUS->name )
		];
	}

	/**
	 * This method returns true if the given Custom Post-Type has a taxonomy to be loaded when it is registered.
	 * @access public
	 * @since 1.0.0
	 * @param string $cpt This argument receives the name of a Custom Post-Type.
	 * @return bool
	 */
	public function has_taxonomy( string $cpt ): bool {
		$taxonomies = $this->get_taxonomies_for_cpt( $cpt );
		return count( $taxonomies ) > 0;
	}

	/**
	 * This method is used to automatically load all the initial data for taxonomies that require previously loaded data.
	 * @access private
	 * @since 1.0.0
	 * @return void
	 */
	private function _load_initial_taxonomy_data(): void {
		$this->_debug_logger->log_debug_message( 'load_initial_taxonomy_data ' );
		$taxonomies = $this->_get_taxonomies_needing_initial_load();
		$this->_debug_logger->log_debug_message( 'load_initial_taxonomy_data > taxonomies: ' . serialize( $taxonomies ) );
		foreach ( $taxonomies as $taxonomy ) {
			$this->_debug_logger->log_debug_message( 'load_initial_taxonomy_data > taxonomy_exists: True ' );
			switch ( $taxonomy ) {
				case Wphh_Helpers::get_id_taxonomy( Wphh_Taxonomy_Name::PRODUCT_STATUS->name ):
					$this->_create_hook_load_product_status_taxonomy();
					break;
				case Wphh_Helpers::get_id_taxonomy( Wphh_Taxonomy_Name::PRODUCT_CATEGORY->name ):
					$this->_create_hook_load_product_category_taxonomy();
					break;
			}
		}
	}

}