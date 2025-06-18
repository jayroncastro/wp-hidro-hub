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
 * This class is a help point for the entire plugin, basically, it is a repository of functions.
 * @package wphh
 * @subpackage shared/helpers
 */
final class Wphh_Helpers {

	/**
	 *This method removes the CPT prefix and returns only the primary name.
	 * @param string $cpt Gets the name of a custom post-type defined by the Wphh_Custom_Post_Type class.
	 * @access private
	 * @since 1.0.0
	 * @static
	 * @return string
	 */
	private static function _strip_cpt_prefix( string $cpt ): string {
		return substr( strtolower( $cpt ), 5 );
	}

	/**
	 * Returns the name of the method in the Wphh Metaboxes class responsible for adding a metabox to the informed custom post-type.
	 * @access public
	 * @since 1.0.0
	 * @static
	 * @param string $cpt Gets the name of a custom post-type defined by the Wphh_Custom_Post_Type class.
	 * @return string
	 */
	public static function get_metabox_method_name( string $cpt ): string {
		return '_add_' . self::_strip_cpt_prefix( $cpt ) . '_metaboxes';
	}

	/**
	 * Returns the name of the method in the Wphh_Taxonomy class responsible for adding a taxonomy to the informed custom post-type.
	 * @access public
	 * @since 1.0.0
	 * @static
	 * @param string $taxonomy Gets the name of a taxonomy defined by the custom post-type.
	 * @return string
	 */
	public static function get_taxonomy_method_name( string $taxonomy ): string {
		return 'create_' . strtolower( substr( $taxonomy, 5) ) . '_taxonomy';
	}

	/**
	 * This method returns the name of a method that will register a custom post-type.
	 * @access public
	 * @since 1.0.0
	 * @static
	 * @param string $cpt Gets the name of a custom post-type defined by the Wphh_Custom_Post_Type class.
	 * @return string
	 */
	public static function get_method_name_register_cpt( string $cpt ): string {
		return 'create_' . self::_strip_cpt_prefix( $cpt ) . '_cpt';
	}

	/**
	 * This method is used to dynamically return the name of a method in the Wphh_Taxonomy class to initially populate a taxonomy.
	 * @access public
	 * @since 1.0.0
	 * @param string $taxonomy
	 * @return string
	 */
	public static function get_method_name_populate_taxonomy( string $taxonomy ): string {
		return 'initially_populate_' . strtolower( $taxonomy ) . '_taxonomy';
	}

	/**
	 * This method returns the id of a metabox for a given custom post-type.
	 * @access public
	 * @since 1.0.0
	 * @static
	 * @param string $cpt Gets the name of a custom post-type defined by the Wphh_Custom_Post_Type class.
	 * @return string
	 */
	public static function get_id_metabox( string $cpt ): string {
		return self::_strip_cpt_prefix( strtolower( $cpt ) ) . '_metabox';
	}

	/**
	 * This method returns the id of a taxonomy for a given custom post-type.
	 * @access public
	 * @since 1.0.0
	 * @static
	 * @param string $taxonomy Gets the name of a taxonomy defined by the custom post-type.
	 * @return string
	 */
	public static function get_id_taxonomy( string $taxonomy ): string {
		return strtolower( WPHH_PREFIX_PLUGIN . $taxonomy );
	}

	/**
	 * This method returns the name of the metabox template that will be loaded into the custom post-type.
	 * @access public
	 * @since 1.0.0
	 * @static
	 * @param string $cpt
	 * @return string
	 */
	public static function get_template_loader( string $cpt ): string {
		return 'add_inner_' . self::_strip_cpt_prefix( $cpt ) . '_metabox';
	}

}