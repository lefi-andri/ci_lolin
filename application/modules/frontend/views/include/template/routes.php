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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] 	= 'frontend/home/index';
$route['404_override'] 			= 'frontend/notfound/index';
$route['translate_uri_dashes'] 	= FALSE;

/*
| -------------------------------------------------------------------------
| URI AUTHENTICATION
| -------------------------------------------------------------------------
*/

$route['login'] 					= 'login/auth/index';
#$route['logout'] 							= 'authentication/auth/logout';

/*
| -------------------------------------------------------------------------
| URI FRONTEND
| -------------------------------------------------------------------------
*/
$route['home'] 								= 'frontend/home/index';
$route['home/search/resultSearch'] 			= 'frontend/home/hasil_pencarian';

$route['profile'] 							= 'frontend/profile/index';
$route['product'] 							= 'frontend/product/index';
$route['product/looks'] 					= 'frontend/product/looks';
$route['product/preview'] 					= 'frontend/product/preview';
$route['product/(:any)'] 					= 'frontend/product/showProduk/$1';
$route['product/page/(:any)'] 				= 'frontend/product/index/$1';

$route['product/category/(:any)'] 			= 'frontend/kategori_produk/index/$1';

$route['testimonials'] 						= 'frontend/testimoni/index';

$route['faq'] 								= 'frontend/faq/index';
$route['faq/(:any)'] 						= 'frontend/faq/tampil_kategori_faq/$1';

$route['contact'] 							= 'frontend/contact/index';

$route['blog'] 								= 'frontend/blog/index';
$route['blog/(:any)'] 						= 'frontend/blog/baca_blog/$1';
$route['blog/(:any)/(:any)'] 				= 'frontend/blog/baca_blog_halaman/$1/$2';
$route['blogs/page/(:any)'] 				= 'frontend/blog/index/$1';
$route['blog/search/resultSearch'] 			= 'frontend/blog/hasil_pencarian';

$route['registration-successful'] 			= 'frontend/landing_page/index';

$route['event'] 							= 'frontend/event/index';
$route['event/(:any)'] 						= 'frontend/event/detail/$1';

$route['contact/saran'] 					= 'frontend/contact/add';
$route['pesan-sekarang'] 					= 'frontend/order/index';

$route['subscribe'] 						= 'frontend/subscribe/index';


$route['reseller'] 							= 'frontend/reseller/index';
$route['reseller/register'] 				= 'frontend/reseller/create_user';
$route['reseller/pribadi/register'] 		= 'frontend/reseller/create_reseller_pribadi';
$route['reseller/organisasi/register'] 		= 'frontend/reseller/create_reseller_organisasi';
$route['reseller/dashboard'] 				= 'frontend/reseller_area/index';

$route['reseller/order'] 					= 'frontend/reseller_order/index';

$route['reseller/order/rekaman'] 			= 'frontend/rekaman_order/index';
$route['reseller/order/rekaman/detail'] 	= 'frontend/rekaman_order/rekaman';
$route['reseller/order/pending'] 			= 'frontend/rekaman_order/rekaman_belum_dikonfirmasi';

$route['reseller/penukaran_poin'] 			= 'frontend/penukaran_poin/index';

$route['reseller/penukaran_poin/rekaman'] 	= 'frontend/rekaman_penukaran_poin/index';

$route['reseller/logout'] 					= 'frontend/reseller/logout';

$route['reseller/activation/(:any)'] 		= 'frontend/reseller/aktivasi_akun/$1';


$route['reseller/profile'] 					= 'frontend/profile_reseller/index';

$route['reseller/photo_profile'] 			= 'frontend/foto_profile/index';
$route['reseller/photo_profile/delete'] 	= 'frontend/foto_profile/delete';

$route['career'] 							= 'frontend/karir/index';


/*
| -------------------------------------------------------------------------
| URI BACKEND
| -------------------------------------------------------------------------
*/


$route['admin'] 									= 'backend/adm_dashboard/index';
$route['admin/dashboard'] 							= 'backend/adm_dashboard/index';


$route['admin/product/kategori'] 					= 'backend/kategori_produk/list_kategori_product';
$route['admin/product/kategori/add'] 				= 'backend/kategori_produk/add_kategori';
$route['admin/product/kategori/edit/(:any)'] 		= 'backend/kategori_produk/edit_kategori/$1';
$route['admin/product/kategori/delete/(:any)'] 		= 'backend/kategori_produk/delete_kategori/$1';
$route['admin/product/kategori/remove/(:any)'] 		= 'backend/kategori_produk/remove_image/$1';


$route['admin/product'] 							= 'backend/produk/index';
$route['admin/product/add'] 						= 'backend/produk/add_product';
$route['admin/product/edit/(:any)'] 				= 'backend/produk/edit_product/$1';
$route['admin/product/delete/(:any)'] 				= 'backend/produk/delete_product/$1';
$route['admin/product/directions/edit/(:any)'] 		= 'backend/produk/edit_directions/$1';
$route['admin/product/ingredients/edit/(:any)'] 	= 'backend/produk/edit_ingredients/$1';


$route['admin/faq/kategori'] 						= 'backend/kategori_faq/index';
$route['admin/faq/kategori/add'] 					= 'backend/kategori_faq/add_kategori';
$route['admin/faq/kategori/edit/(:any)'] 			= 'backend/kategori_faq/edit_kategori/$1';
$route['admin/faq/kategori/delete/(:any)'] 			= 'backend/kategori_faq/delete_kategori/$1';

$route['admin/faqs/(:any)'] 						= 'backend/faq/index/$1';
$route['admin/faqs/add/(:any)'] 					= 'backend/faq/add_faq/$1';
$route['admin/faqs/edit/(:any)'] 					= 'backend/faq/edit_faq/$1';
$route['admin/faqs/delete/(:any)'] 					= 'backend/faq/delete_faq/$1';

$route['admin/socialmedia'] 						= 'backend/adm_socialmedia/index';
$route['admin/socialmedia/edit/(:any)'] 			= 'backend/adm_socialmedia/edit_socialmedia/$1';

$route['admin/contact'] 							= 'backend/adm_contact/index';
$route['admin/contact/looks'] 						= 'backend/adm_contact/looks';
$route['admin/contact/delete/(:any)'] 				= 'backend/adm_contact/delete_contact/$1';

$route['admin/testimoni'] 							= 'backend/adm_testimonial/index';
$route['admin/testimoni/add'] 						= 'backend/adm_testimonial/add_testimonial';
$route['admin/testimoni/edit/(:any)'] 				= 'backend/adm_testimonial/edit_testimonial/$1';
$route['admin/testimoni/delete/(:any)'] 			= 'backend/adm_testimonial/delete_testimonial/$1';

$route['admin/event'] 								= 'backend/adm_events/index';
$route['admin/event/add'] 							= 'backend/adm_events/add_events';
$route['admin/event/edit/(:any)'] 					= 'backend/adm_events/edit_events/$1';
$route['admin/event/delete/(:any)'] 				= 'backend/adm_events/delete_events/$1';
$route['admin/event/picture/add/(:any)'] 			= 'backend/adm_events/add_picture/$1';
$route['admin/event/picture/add/files/(:any)'] 		= 'backend/adm_events/add_event_picture/$1';
$route['admin/event/picture/edit/files/(:any)'] 	= 'backend/adm_events/edit_picture/$1';
$route['admin/event/picture/delete/files/(:any)'] 	= 'backend/adm_events/delete_picture/$1';

$route['admin/tag_line'] 							= 'backend/adm_tag_line/index';
$route['admin/tag_line/add'] 						= 'backend/adm_tag_line/add_tag_line';
$route['admin/tag_line/edit/(:any)'] 				= 'backend/adm_tag_line/edit_tag_line/$1';
$route['admin/tag_line/delete/(:any)'] 				= 'backend/adm_tag_line/delete_tag_line/$1';

$route['admin/member_area'] 						= 'backend/adm_member_area/index';
$route['admin/member_area/grab_data_member'] 		= 'backend/adm_member_area/grab_data_member';
$route['admin/member_area/add'] 					= 'backend/adm_member_area/add_member_area';

$route['admin/pengaturan'] 							= 'backend/pengaturan/index';
$route['adm_infoupdate'] 							= 'backend/adm_infoupdate/index';

