<?php

/**
 * This file is part of the WordPress WP Hidro Hub plugin.
 * @author Jayron Castro <eu@jayroncastro.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 * @link https://www.wphidrohub.com
 * @version 1.0.0
 * @since 1.0.0
 */
namespace wphh\shared\enums;

/**
 * This Enum handles all page identifiers used in this plugin.
 * @package wphh
 * @subpackage shared/enum
 * @access public
 * @since 1.0.0
 */
enum Wphh_Plugin_Identifiers: string {

	/**
	 * This constant stores the name of the main menu page.
	 * @var string
	 * @access public
	 * @since 1.0.0
	 */
	case MAIN = 'toplevel_page_wphh_settings';

	/**
	 * This constant stores the name of the CPT used for customers.
	 * @var string
	 * @access public
	 * @since 1.0.0
	 */
	case CUSTOMER = 'customer';

	/**
	 * This constant stores the name of the CPT used for the product.
	 * @var string
	 * @access public
	 * @since 1.0.0
	 */
	case PRODUCT = 'product';
}