<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login-auth'] = 'Login/Validate';
$route['dashboard'] = 'Dashboard/index';
$route['change-status']        = 'Dashboard/change_status';

$route['manage-category'] = 'Master/category';
$route['manage-category/(:any)'] = 'Master/category/$1';
$route['manage-category/(:any)/(:num)'] = 'Master/category/$1/$2';
$route['manage-category/(:any)/(:any)/(:num)'] = 'Master/category/$1/$2/$3';

$route['manage-product'] = 'Master/products';
$route['manage-product/(:any)'] 						= 'Master/products/$1';
$route['manage-product/(:any)/(:num)'] 				= 'Master/products/$1/$2';
$route['manage-product/(:any)/(:any)/(:num)'] 			= 'Master/products/$1/$2/$3';
$route['manage-product/(:any)/(:any)/(:any)'] 			= 'Master/products/$1/$2/$3';
$route['manage-product/(:any)/(:any)/(:any)/(:num)'] 	= 'Master/products/$1/$2/$3/$4';
$route['manage-product/(:any)/(:any)/(:any)/(:any)'] 	= 'Master/products/$1/$2/$3/$4';
$route['manage-product/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'Master/products/$1/$2/$3/$4/$5';
$route['manage-product/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'Master/products/$1/$2/$3/$4/$5';
$route['manage-product/(:any)/(:any)/(:any)/(:any)/(:any)/(:num)'] 	= 'Master/products/$1/$2/$3/$4/$5/$6';
$route['manage-product/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] 	= 'Master/products/$1/$2/$3/$4/$5/$6';

$route['manage-customers'] = 'Master/Customers';
$route['manage-customers/(:any)'] = 'Master/Customers/$1';
$route['manage-customers/(:any)/(:any)'] = 'Master/Customers/$1/$2';

$route['home-header'] 				= 'Master/home_header';
$route['add-home-header'] 				= 'Master/add_home_header';
$route['edit-home-header/(:num)'] 		= 'Master/edit_home_header';
$route['delete-home-header/(:num)'] 	= 'Master/delete_home_header';

$route['add_cat_mapping'] 	= 'Master/add_cat_mapping';
$route['available_category'] ='Master/available_category';
$route['fetch_sub_categories']  ='Master/fetch_sub_categories';
$route['cat-headers-mapping/(:num)'] 	= 'Master/cat_headers_mapping';
$route['delete-cat-header-mapping/(:num)'] 	= 'Master/delete_cat_header_mapping';
$route['map_category']           ='Master/map_category';
$route['remove_map_category']   ='Master/remove_map_category';

$route['product-headers-mapping/(:num)'] 	= 'Master/product_headers_mapping';
$route['add_mapping']   ='Master/add_mapping';
$route['fetch_products']  = 'Master/fetch_products';
$route['map_product']   = 'Master/map_product';
$route['remove_map_product']  ='Master/remove_map_product';
$route['delete-header-mapping/(:num)'] 	= 'Master/delete_header_mapping';

$route['manage-pincode'] = 'Master/Pincode';
$route['manage-pincode/(:any)'] = 'Master/Pincode/$1';
$route['manage-pincode/(:any)/(:num)'] = 'Master/Pincode/$1/$2';
$route['manage-pincode/(:any)/(:any)/(:num)'] = 'Master/Pincode/$1/$2/$3';

$route['offers'] 								= 'offers_coupons_admin/offers';
$route['offers/(:any)'] 						= 'offers_coupons_admin/offers/$1';
$route['offers/(:any)/(:any)'] 				= 'offers_coupons_admin/offers/$1/$2';
$route['offers/(:any)/(:any)/(:any)'] 		= 'offers_coupons_admin/offers/$1/$2/$3';
$route['offers/(:any)/(:any)/(:any)/(:any)'] 	= 'offers_coupons_admin/offers/$1/$2/$3/$4';

$route['offers_coupons_remote/(:any)'] 						= 'offers_coupons_admin/offers_coupons_remote/$1';
$route['offers_coupons_remote/(:any)/(:any)'] 				= 'offers_coupons_admin/offers_coupons_remote/$1/$2';
$route['offers_coupons_remote/(:any)/(:any)/(:any)'] 		= 'offers_coupons_admin/offers_coupons_remote/$1/$2/$3';

$route['apply-offer'] = 'offers_coupons_admin/apply_offer';

$route['offers-coupons'] = 'offers_coupons_admin';
$route['offers-coupons/(:any)'] = 'offers_coupons_admin/$1';
$route['offers-coupons/(:any)/(:any)'] = 'offers_coupons_admin/$1/$2';
$route['offers-coupons/(:any)/(:any)/(:any)'] = 'offers_coupons_admin/$1/$2/$3';
$route['offers-coupons/(:any)/(:any)/(:any)/(:any)'] = 'offers_coupons_admin/$1/$2/$3/$4';

$route['orders'] 					= 'orders/index';
$route['orders/(:any)'] 			= 'orders/index/$1';
$route['orders/(:any)/(:any)'] 		= 'orders/index/$1/$2';


$route['manage-banner'] = 'Master/banner';
$route['manage-banner/(:any)'] = 'Master/banner/$1';
$route['manage-banner/(:any)/(:num)'] = 'Master/banner/$1/$2';
$route['manage-banner/(:any)/(:any)/(:num)'] = 'Master/banner/$1/$2/$3';

$route['manage-super-offer'] = 'Master/SuperOffer';
$route['manage-super-offer/(:any)'] = 'Master/SuperOffer/$1';
$route['manage-super-offer/(:any)/(:num)'] = 'Master/SuperOffer/$1/$2';
$route['manage-super-offer/(:any)/(:any)/(:num)'] = 'Master/SuperOffer/$1/$2/$3';