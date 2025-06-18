<?php

/**
 * This file is part of the WordPress WP Hidro Hub plugin.
 * @author Jayron Castro <eu@jayroncastro.com>
 * @license https://www.gnu.org/licenses/gpl-3.0.html
 * @link https://www.wphidrohub.com
 * @version 1.0.0
 * @since 1.0.0
 */
namespace wphh\admin\models\dtos;

class Wphh_Taxonomy_Dto {

	public string $term_id;

	public string $taxonomy_id;

	public string $alias_of;

	public string $description;

	public int $parent;

	public string $slug;

	public function __construct(
		string $term_id,
		string $taxonomy_id,
		string $description = "",
		int $parent = 0,
		string $alias_of = "",
		string $slug = ""
	) {
		$this->term_id = $term_id;
		$this->taxonomy_id = $taxonomy_id;
		$this->alias_of = $alias_of;
		$this->description = $description;
		$this->parent = $parent;
		$this->slug = $slug;
	}

}