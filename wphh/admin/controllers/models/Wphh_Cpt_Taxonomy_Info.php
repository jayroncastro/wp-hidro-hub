<?php

/**
 * This file is part of the WordPress WP Hidro Hub plugin.
 * @author Jayron Castro <eu@jayroncastro.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 * @link https://www.wphidrohub.com
 * @version 1.0.0
 * @since 1.0.0
 */
namespace wphh\admin\controllers\models;

/**
 * This class manages all the information that will be used by the Wphh_Custom_Post_Types class.
 * @package wphh
 * @subpackage admin/controllers/models
 */
class Wphh_Cpt_Taxonomy_Info {

	public string $cpt;
	public string|array $taxonomy;

	public function __construct( string $cpt, string|array $taxonomy ) {
		$this->cpt = $cpt;
		$this->taxonomy = $taxonomy;
	}

}