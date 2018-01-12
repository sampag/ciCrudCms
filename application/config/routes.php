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
$route['default_controller'] = 'auth/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;





//======================
// Authentication using ion_auth 
//======================
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';


//======================
// Cross Site Rquest Forgery
//======================
$route['csrf'] = 'csrf/index';


//======================
// User Admin
//======================
$route['admin'] = 'admin/index';


//======================
// Errors
//======================
$route['admin/post-category'] = 'errors/index';
$route['admin/post-edit'] = 'errors/index';
$route['admin/post-tag'] = 'errors/index';
$route['admin/category-edit'] = 'errors/index';
$route['admin/tag-edit'] = 'errors/index';


//======================
// Post
//======================
$route['admin/post']                      = 'post/index';
$route['add-post']                        = 'post/post_add';
$route['admin/post-edit/:any']            = 'post/post_edit/$random_id';
$route['admin/post-update/(:any)']        = 'post/post_update/$random_id';
$route['admin/post-list']                 = 'post/post_list'; 
$route['admin/post-list/(:num)']          = 'post/post_list_pagination/$page';
$route['admin/post-delete/(:num)/(:any)'] = 'post/post_delete/$id/$file_name'; // with featured image
$route['admin/post-delete/(:num)']        = 'post/post_delete/$id'; // without featured image
$route['admin/post-category/(:any)']      = 'post/post_filter_categorized/$categorized_slug';
$route['admin/post-tag/:any']             = 'post/post_filter_tag/$slug';
$route['admin/post/:any']                 = 'post/post_filter_uncategorized/$uncategorized_slug';
$route['admin/post-author/(:num)']        = 'post/post_filter_author/$id';
$route['search-posts']                    = 'post/post_search';


//======================
// Category
//======================
$route['admin/category'] = 'category/index';
$route['admin/category-edit/(:num)'] = 'category/category_edit/$id';
$route['add-category'] = 'category/category_add';
$route['get-category'] = 'category/category_get';
$route['data-category'] = 'category/category_data';
$route['delete-category'] = 'category/category_delete';
$route['update-category/(:num)'] = 'category/category_update/$id';
$route['search-categories'] = 'category/category_search';
$route['search-categories-result/(:any)'] = 'category/category_search_result/$match';


//======================
// Tag
//======================
$route['admin/tag'] = 'tag/index';
$route['admin/tag-edit/(:num)'] = 'tag/tag_edit/$id';
$route['add-tag'] = 'tag/tag_add';
$route['get-tag'] = 'tag/tag_get';
$route['data-tag'] = 'tag/tag_data';
$route['delete-tag'] = 'tag/tag_delete';
$route['update-tag/(:num)'] = 'tag/tag_update/$id';
$route['search-tags'] = 'tag/tag_search';
$route['search-tag-result/(:any)'] = 'tag/tag_search_result/$match';


//======================
// Comment
//======================
$route['admin/comment'] = 'comment/index';
$route['admin/comment-approved/(:num)'] = 'comment/comment_approved/$id';
$route['admin/comment-delete/(:num)'] = 'comment/comment_delete/$id';

//======================
// Settings
//======================
$route['admin/settings'] = 'settings/index';
$route['save-settings'] = 'settings/settings_save_changes';
//======================
// System
//======================
$route['admin/system'] = 'system/index';

//======================
// Member
//======================
$route['member/post'] = 'member/post_create';
$route['member/post-list'] = 'member/post_list';
$route['member/add-post'] = 'member/post_add';
$route['member/post-update/(:any)'] = 'member/post_update/$random_slug';
$route['member/post-delete/(:num)'] = 'member/post_delete/$id';
$route['member/post-edit/(:any)'] ='member/post_edit/$random_id';
$route['member/post-category/(:any)'] = 'member/post_filter_categorized/$slug';
$route['member/post-category'] = 'member/error_page';
$route['member/post-tag/(:any)'] = 'member/post_filter_tag/$slug';
$route['member/post/(:any)'] = 'member/post_filter_uncategorized/$slug';
$route['member/comment'] = 'member/post_comment';
$route['member/comment-delete/(:num)'] = 'member/delete_comment/$id';
$route['member/profile'] = 'member/author_profile';
$route['member/profile-update'] = 'member/author_profile_update';