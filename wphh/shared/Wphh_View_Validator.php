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

use wphh\admin\controllers\Wphh_Custom_Post_Types;

/**
 * This class is used to handle only simple validations related to the back-end.
 *
 * @package wphh
 * @subpackage shared
 * @since 1.0.0
 * @final
 */
final class Wphh_View_Validator {

	/**
	 * This method returns true if the page loaded on the front-end requires an additional stylesheet for the plugin.
	 * @return bool
	 * @access private
	 * @since 1.0.0
	 */
	private static function _needs_css(): bool {
		if ( ! function_exists( 'get_current_screen' ) ) {
			return false;
		}
		$screen = get_current_screen();
		if ( ! $screen ) {
			return false;
		}
		#if( WPHH_ERROR_LOG ){error_log ( 'WpHH Debug (CSS Screen ID): ' . $screen->id );}
		return in_array( $screen->id, new Wphh_Custom_Post_Types()->get_views_with_custom_css() );
	}

	/**
	 * This method returns true if the page loaded on the front-end requires an additional JavaScript file.
	 * @return bool
	 * @access private
	 * @since 1.0.0
	 */
	private static function _needs_js(): bool {
		if ( ! function_exists( 'get_current_screen' ) ) {
			return false;
		}
		$screen = get_current_screen();
		if ( ! $screen ) {
			return false;
		}
		#if( WPHH_ERROR_LOG ){error_log ( 'WpHH Debug (JS Screen ID): ' . $screen->id );}
		return in_array( $screen->id, new Wphh_Custom_Post_Types()->get_views_with_custom_js() );
	}

	/**
	 * This method inserts all the necessary style sheets and JavaScript files into the web page.
	 * @return void
	 * @access public
	 * @since 1.0.0
	 */
	public static function enqueue_assets(): void {
		if ( self::_needs_css() ) {
			wp_enqueue_style(
				'wphh-bootstrap',
				'https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css',
				[],
				'5.3.5'
			);
			wp_enqueue_style(
				'wphh-bootstrap-icons',
				'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
				['wphh-bootstrap'],
				'1.11.3'
			);
			wp_enqueue_style(
				'wphh-fonts-montserrat',
				'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap',
				[],
				null
			);
			wp_enqueue_style(
				'wphh-style',
				plugins_url( 'assets/css/wphh-style.css', WPHH_FILE ),
				['wphh-bootstrap', 'wphh-bootstrap-icons'],
				WPHH_PLUGIN_VERSION
			);
		}
		if ( self::_needs_js() ) {
			wp_enqueue_script(
				'wphh-bootstrap',
				'https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js',
				[],
				'5.3.5',
				[ 'strategy' => 'defer' ]
			);
			wp_enqueue_script(
				'wphh-wphh-script',
				plugins_url( 'assets/js/wphh-script.js', WPHH_FILE ),
				['wphh-bootstrap'],
				WPHH_PLUGIN_VERSION,
				[ 'strategy' => 'defer' ]
			);
		}
	}
}