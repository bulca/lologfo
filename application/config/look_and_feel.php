<?php

	/*
	 * BREADCRUMBS
	 */

	$config['breadcrumbs'] = array(
		'shop' => array(
			'title' => 'Browse Shop',
			'href' => '/shop'
		),
		'shop_view' => array(
			'title' => 'Viewing Accounts',
			'href' => '#'
		),
		'admin' => array(
			'title' => 'Admin',
			'href' => '/admin'
		),
		'admin_newsfeed' => array(
			'title' => 'News & Updates',
			'href' => '/admin/newsFeed'
		),
		'admin_newsfeed_create' => array(
			'title' => 'Create New Post',
			'href' => '#'
		),
		'admin_accounts' => array(
			'title' => 'Accounts',
			'href' => '#'
		),
		'admin_account_types' => array(
			'title' => 'Account Types',
			'href' => '/admin/accountTypes'
		),
		'admin_account_types_edit' => array(
			'title' => 'Editing Account Type',
			'href' => '#'
		),
		'admin_users' => array(
			'title' => 'Users',
			'href' => '/admin/users'
		),
		'add_funds' => array(
			'title' => 'Deposit Funds',
			'href' => '/add-funds'
		),
		'seller_panel' => array(
			'title' => 'Seller Panel',
			'href' => '/seller'
		),
		'seller_inventory' => array(
			'title' => 'Inventory',
			'href' => '/inventory'
		),
		'seller_add_accounts' => array(
			'title' => 'Add Accounts',
			'href' => '#'
		),
		'my_stuff' => array(
			'title' => 'My Accounts',
			'href' => '/mystuff'
		),
		'customer_support' => array(
			'title' => 'Customer Support',
			'href' => '/support'
		),
		'customer_support_read' => array(
			'title' => 'Reading Ticket',
			'href' => '#'
		),
		'ticket_manager' => array(
			'title' => 'Ticket Manager',
			'href' => '/ticket-manager'
		),
		'ticket_manager_read' => array(
			'title' => 'Reading Ticket',
			'href' => '#'
		),
		'user_settings' => array(
			'title' => 'Account Settings',
			'href' => '/settings'
		),
		'admin_user_payouts' => array(
			'title' => 'User Payouts',
			'href' => '/admin/userPayouts'
		),
		'seller_settings' => array(
			'title' => 'Settings',
			'href' => '/seller/settings'
		),
		'seller_checker_cc' => array(
			'title' => 'CC Checker',
			'href' => '/seller/checker/cc'
		)
	);

	/*
	 * MENUS
	 */

	// default menu
	
	$config['menu']['default'] = array(
		'home' => array(
			'icon' => 'entypo-home',
			'title' => 'Home',
			'href' => '/home'
		),
		'my_stuff' => array(
			'icon' => 'fa fa-briefcase',
			'title' => 'My Accounts',
			'href' => '/my-stuff',
			'func' => function($ci, &$arr) {
				$count = $ci->usermodel->get_accounts_total();

				if($count > 0)
					$arr['badge'] = $count;
			}
		),
		'shop' => array(
			'icon' => 'fa fa-shopping-cart',
			'title' => 'Buy Accounts',
			'href' => '/shop'
		),
		'add_funds' => array(
			'icon' => 'fa fa-credit-card',
			'title' => 'Add Funds',
			'href' => '/add-funds'
		),
		
		'seller' => array(
			'icon' => 'fa fa-bar-chart-o',
			'title' => 'Seller Panel',
			'href' => '/seller',
			'perm' => 'seller',
		),
		'customer_support' => array(
			'icon' => 'fa fa-comments',
			'title' => 'Support',
			'href' => '/support',
			'func' => function($ci, &$arr) {
				$unread = $ci->usermodel->get_unread_tickets();

				if($unread > 0)
					$arr['badge'] = $unread;
			}
		)
	);

	// admin menu

	$config['menu']['admin'] = array(
		'admin' => array(
			'icon' => 'entypo-home',
			'title' => 'Dashboard',
			'href' => '/admin'
		),
		'users' => array(
			'icon' => 'users',
			'title' => 'Users',
			'href' => '/admin/users',
			'children' => array(
				/*array(
					'title' => 'View All',
					'href' => '/admin/accounts'
				),*/
				array(
					'title' => 'Payouts',
					'href' => '/admin/userPayouts'
				)
			)
		),
		'accounts' => array(
			'icon' => 'fa fa-child',
			'title' => 'Accounts',
			'href' => '/admin/accounts',
			'children' => array(
				/*array(
					'title' => 'View All',
					'href' => '/admin/accounts'
				),*/
				array(
					'title' => 'Types',
					'href' => '/admin/accountTypes'
				)
			)
		),
		'news_feed' => array(
			'icon' => 'glyphicon glyphicon-comment',
			'title' => 'News Feed',
			'href' => '/admin/newsFeed'
		),
		'go_back' => array(
			'icon' => 'glyphicon glyphicon-arrow-left',
			'title' => 'Return to website',
			'href' => '/home'
		)
	);

	// seller menu

	$config['menu']['seller'] = array(
		'dashboard' => array(
			'icon' => 'fa fa-home',
			'title' => 'Dashboard',
			'href' => 'seller'
		),
		'inventory' => array(
			'icon' => 'fa fa-briefcase',
			'title' => 'Inventory',
			'href' => 'seller/inventory'
		),
		'add_accounts' => array(
			'icon' => 'fa fa-child',
			'title' => 'Insert Accounts',
			'href' => 'seller/addAccounts'
		),
		#'checker' => array(
		#	'icon' => 'fa fa-rocket',
		#	'title' => 'Checker',
		#	'href' => '#',
		#	'children' => array(
		#		array(
		#			'title' => 'Coming Soon',
		#			'href' => 'checker/cc'
		#		)
		#	)
		#),
		'settings' => array(
			'icon' => 'fa fa-cogs',
			'title' => 'Settings',
			'href' => 'seller/settings'
		),
		'go_back' => array(
			'icon' => 'glyphicon glyphicon-arrow-left',
			'title' => 'Return to website',
			'href' => '/home'
		)
	);
?>
