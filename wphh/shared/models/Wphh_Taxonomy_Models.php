<?php

/**
 * This file is part of the WordPress WP Hidro Hub plugin.
 * @author Jayron Castro <eu@jayroncastro.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 * @link https://www.wphidrohub.com
 * @version 1.0.0
 * @since 1.0.0
 */
namespace wphh\shared\models;

use wpdb;

/**
 * This class manages all taxonomy interactions of the WpHidroHub plugin that will occur with the database.
 * @package wphh
 * @subpackage shared/models
 * @since 1.0.0
 */
class Wphh_Taxonomy_Models {

	/**
	 * Stores the WORDPRESS global variable `$wpdb`
	 * @var wpdb
	 * @access private
	 * @since 1.0.0
	 * @see https://developer.wordpress.org/reference/classes/wpdb/
	 */
	private wpdb $_db;

	/**
	 * This method initializes an instance of the class.
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct() {
		$this->_db = $GLOBALS['wpdb'];
	}

	public function create_taxonomy_term(): void {}

}