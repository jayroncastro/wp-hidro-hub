<?php

namespace wphh\admin\controllers;

class Wphh_Roles_Capabilities_Manager {

    private array $_roles = [
                            'wphh_seller' => 'Seller',
                            'wphh_driver' => 'Driver',
                            'wphh_logist-man' => 'Logistics Manager',
                            'wphh_logist-ass' => 'Logistics Assistant',
                            'wphh_quality-man' => 'Quality Manager',
                            'wphh_quality-ass' => 'Quality Assistant',
                            'wphh_financial-man' => 'Financial Manager',
                            'wphh_financial-ass' => 'Financial Assistant',
                            'wphh_admin' => 'WPHH Administrator',
                            ];

    private array $_capabilities = [
		'wphh_seller' =>    [
	                        'read',
	                        'publish_wphh_customers',
	                        'edit_own_wphh_customers',
	                        'read_own_wphh_customers',
	                        'read_wphh_products',
	                        'read_wphh_stock',
	                        'read_wphh_prices',
	                        'publish_wphh_orders',
	                        'create_wphh_orders',
	                        'read_own_wphh_orders',
	                        'read_own_wphh_commissions'
	                        ],
		'wphh_driver' =>    [
	                        'read'
	                        ],
		'wphh_logist-man' =>    [
	                            'read',
	                            'access_wphh_backend',
	                            'view_wphh_audit_log',
	                            'publish_wphh_customers',
	                            'edit_others_wphh_customers',
	                            'delete_wphh_customers',
	                            'read_wphh_customers',
	                            'assign_wphh_customer_meta',
	                            'edit_wphh_products',
	                            'read_wphh_products',
	                            'read_wphh_prices',
	                            'read_wphh_lots',
	                            'enter_wphh_production_qty',
	                            'read_wphh_production_data',
	                            'manage_wphh_inventory_adjustments',
	                            'read_wphh_stock',
	                            'publish_wphh_orders',
	                            'create_wphh_orders',
	                            'edit_others_wphh_orders',
	                            'delete_wphh_orders',
	                            'read_wphh_orders',
	                            'manage_wphh_order_status',
	                            'publish_wphh_romaneios',
	                            'edit_wphh_romaneios',
	                            'delete_wphh_romaneios',
	                            'assign_wphh_orders_routes',
	                            'dispatch_wphh_routes',
	                            'reconcile_wphh_routes',
	                            'read_wphh_routes'
	                            ],
		'wphh_logist-ass' =>    [
	                            'read',
	                            'access_wphh_backend',
	                            'edit_others_wphh_customers',
	                            'read_wphh_customers',
	                            'read_wphh_products',
	                            'read_wphh_prices',
	                            'read_wphh_lots',
	                            'enter_wphh_production_qty',
	                            'read_wphh_production_data',
	                            'manage_wphh_inventory_adjustments',
	                            'read_wphh_stock',
	                            'publish_wphh_orders',
	                            'create_wphh_orders',
	                            'edit_others_wphh_orders',
	                            'read_wphh_orders',
	                            'manage_wphh_order_status',
	                            'publish_wphh_romaneios',
	                            'edit_wphh_romaneios',
	                            'assign_wphh_orders_routes',
	                            'dispatch_wphh_routes',
	                            'reconcile_wphh_routes',
	                            'read_wphh_routes'
	                            ],
		'wphh_quality-man' =>   [
	                            'read',
	                            'access_wphh_backend',
	                            'view_wphh_audit_log',
	                            'read_wphh_customers',
	                            'read_wphh_products',
	                            'publish_wphh_lots',
	                            'edit_wphh_lots',
	                            'delete_wphh_lots',
	                            'enter_wphh_qc_data',
	                            'approve_wphh_lot',
	                            'read_wphh_lots',
	                            'read_wphh_production_data',
	                            'read_wphh_stock',
	                            'read_wphh_orders',
	                            'read_wphh_routes'
	                            ],
		'wphh_quality-ass' =>   [
	                            'read',
	                            'access_wphh_backend',
	                            'read_wphh_customers',
	                            'read_wphh_products',
	                            'publish_wphh_lots',
	                            'edit_wphh_lots',
	                            'enter_wphh_qc_data',
	                            'read_wphh_lots',
	                            'read_wphh_production_data',
	                            'read_wphh_stock',
	                            'read_wphh_orders',
	                            'read_wphh_routes'
	                            ],
		'wphh_financial-man' => [
                                'read',
								'access_wphh_backend',
								'view_wphh_audit_log',
								'publish_wphh_customers',
								'edit_others_wphh_customers',
								'delete_wphh_customers',
								'read_wphh_customers',
								'assign_wphh_customer_meta',
								'read_wphh_products',
								'manage_wphh_prices',
								'read_wphh_prices',
								'read_wphh_lots',
								'read_wphh_production_data',
								'read_wphh_stock',
								'create_wphh_orders',
								'edit_others_wphh_orders',
								'delete_wphh_orders',
								'read_wphh_orders',
								'manage_wphh_order_status',
								'confirm_wphh_payment',
								'reconcile_wphh_route',
								'read_wphh_routes',
								'manage_wphh_commissions',
								'read_all_wphh_commissions'
								],
		'wphh_financial-ass' => [
								'read',
								'access_wphh_backend',
								'edit_others_wphh_customers',
								'read_wphh_customers',
								'read_wphh_products',
								'manage_wphh_prices',
								'read_wphh_prices',
								'read_wphh_lots',
								'read_wphh_production_data',
								'read_wphh_stock',
								'create_wphh_orders',
								'edit_others_wphh_orders',
								'read_wphh_orders',
								'manage_wphh_order_status',
								'confirm_wphh_payment',
								'reconcile_wphh_route',
								'read_wphh_routes',
								'manage_wphh_commissions',
								'read_all_wphh_commissions'
								],
		'wphh_admin' => [
						'read',
						'manage_options',
						'admin_wphh_plugin',
						'access_wphh_backend',
						'manage_wphh_settings',
						'view_wphh_audit_log',
						'publish_wphh_customers',
						'edit_own_wphh_customers',
						'edit_others_wphh_customers',
						'delete_wphh_customers',
						'read_wphh_customers',
						'read_own_wphh_customers',
						'assign_wphh_customer_meta',
						'publish_wphh_products',
						'edit_wphh_products',
						'delete_wphh_products',
						'manage_wphh_product_categories',
						'read_wphh_products',
						'manage_wphh_prices',
						'read_wphh_prices',
						'publish_wphh_lots',
						'edit_wphh_lots',
						'delete_wphh_lots',
						'enter_wphh_qc_data',
						'approve_wphh_lot',
						'read_wphh_lots',
						'enter_wphh_production_qty',
						'read_wphh_production_data',
						'manage_wphh_inventory_adjustments',
						'read_wphh_stock',
						'publish_wphh_orders',
						'create_wphh_orders',
						'edit_others_wphh_orders',
						'delete_wphh_orders',
						'read_wphh_orders',
						'read_own_wphh_orders',
						'manage_wphh_order_status',
						'confirm_wphh_payment',
						'publish_wphh_romaneios',
						'edit_wphh_romaneios',
						'delete_wphh_romaneios',
						'assign_wphh_orders_routes',
						'dispatch_wphh_routes',
						'reconcile_wphh_routes',
						'read_wphh_routes',
						'manage_wphh_commissions',
						'read_all_wphh_commissions',
						'read_own_wphh_commissions',
	                    ]
      
    ];

    public function __construct() {
        $this->_create_roles();
    }

    private function _create_roles(): void {
		foreach ( $this->_roles as $role => $name ){
			$caps = $this->_get_capabilities( $role );
			add_role( $role, $name, $caps );
		}
    }

	private function _get_capabilities( string $role ): array {
		$args = [];
		foreach ( $this->_capabilities as $key => $capabilities ) {
			if ( $key === $role ) {
				$args = $capabilities;
			}
		}
		return $args;
	}

}