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
 * This Enum handles all Taxonomies names used in this plugin.
 * @package wphh
 * @subpackage shared/enum
 * @access public
 * @since 1.0.0
 */
enum Wphh_Taxonomy_Name {

	/**
	 * This constant represents the taxonomy related to the product category and is used in the product CPT.
	 * @access public
	 * @since 1.0.0
	 */
	case PRODUCT_CATEGORY;

	/**
	 * This constant represents the taxonomy related to the status of products being used in the CPT of products.
	 * @access public
	 * @since 1.0.0
	 */
	case PRODUCT_STATUS;
}