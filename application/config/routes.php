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
$route['default_controller'] = 'public_view/post_all'; // Change this
$route['404_override'] = 'public_view/page_not_found';
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
$route['admin/post-list'] = 'errors/index';

/**
* Admin Routes Only
*/
$route['admin/post']                      = 'post/index';
$route['add-post']                        = 'post/post_add';
$route['admin/post-edit/:any']            = 'post/post_edit/$random_id';
$route['admin/post-update/(:any)']        = 'post/post_update/$random_id';
$route['admin/post-category/(:any)']             = 'post/post_filter_categorized/$categorized_slug';
$route['admin/post-category/(:any)/(:num)']      = 'post/post_filter_categorized_paginated/$categorized_slug';
$route['admin/post-tag/:any']             = 'post/post_filter_tag/$slug';
$route['admin/post-tag/(:any)/(:num)']    = 'post/post_filter_tag_paginated/$slug/$page';
$route['admin/post/:any']                 = 'post/post_filter_uncategorized/$uncategorized_slug';
$route['admin/post/:any/:num']            = 'post/post_filter_uncategorized_paginated/$uncategorized_slug/$per_page';
$route['admin/post-author/(:num)']        = 'post/post_filter_author/$id'; // Non Paginated
$route['admin/post-author/(:num)/(:num)'] = 'post/post_filter_author_paginated/$id/$per_page';
$route['search-posts']                    = 'post/post_search';

// Filter Group for admin
$route['admin/post-list/all']        = 'post_group_admin/all';
$route['admin/post-list/all/(:num)']        = 'post_group_admin/all/$per_page';
$route['admin/post-list/mine']              = 'post_group_admin/mine';
$route['admin/post-list/mine/(:num)']	    = 'post_group_admin/mine/$per_page';
$route['admin/post-list/published']         = 'post_group_admin/published';
$route['admin/post-list/published/(:num)']	= 'post_group_admin/published/$per_page';
$route['admin/post-list/trash']  = 'post_group_admin/trash';
$route['admin/post-list/trash/(:num)']  = 'post_group_admin/trash';
// Trash
$route['admin/post-list/(:any)/trash/(:any)'] = 'post/post_trash/$random_id'; // for non paginated
$route['admin/post-list/(:any)/(:num)/trash/(:any)'] = 'post/post_trash_paginated/$random_id'; // for paginated
// Restore
$route['admin/post-list/trash/restore/(:any)'] = 'post/post_restore/$random_id';// for non paginated
$route['admin/post-list/trash/(:num)/restore/(:any)'] = 'post/post_restore_paginated/$random_id';// for paginated
// Delete Permanently
$route['admin/post-list/trash/(:any)/delete-permanently/(:any)'] = 'post/post_delete_permanently_paginated/$random_id'; 
$route['admin/post-list/trash/delete-permanently/(:any)'] = 'post/post_delete_permanently/$random_id'; 


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

/**
* Member Contributors
*/
$route['member/post'] = 'member/post_create';
$route['member/add-post'] = 'member/post_add';
$route['member/post-update/(:any)'] = 'member/post_update/$random_slug';
$route['member/post-list/(:any)/(:num)/delete/(:num)/(:any)'] = 'member/post_delete_paginated/$list/$pagination/$group/$id/$file_name'; 
$route['member/post-list/(:any)/delete/(:num)/(:any)'] = 'member/post_delete_none_paginated/$list/$pagination/$group/$id/$file_name'; 
$route['member/post-edit/(:any)'] ='member/post_edit/$random_id';
$route['member/post-category/(:any)'] = 'member/post_filter_categorized/$slug';
$route['member/post-category/(:any)/(:num)']  = 'member/post_filter_categorized_paginated/$slug/$page';
$route['member/post-tag/(:any)'] = 'member/post_filter_tag/$slug';
$route['member/post-tag/(:any)/(:num)'] = 'member/post_filter_tag/$slug/$page';
$route['member/post/(:any)'] = 'member/post_filter_uncategorized/$slug';
$route['member/post/(:any)/(:num)'] = 'member/post_filter_uncategorized/$slug/$page';
$route['member/comment'] = 'member/post_comment';
$route['member/comment-delete/(:num)'] = 'member/delete_comment/$id';
$route['member/profile'] = 'member/author_profile';
$route['member/profile-update'] = 'member/author_profile_update';
$route['member/post-list/all/(:num)']       = 'post_group_contributor/all/$per_page';
$route['member/post-list/mine/(:num)']      = 'post_group_contributor/mine/$per_page';
$route['member/post-list/published/(:num)'] = 'post_group_contributor/published/$per_page';
$route['member/post-list/all']              = 'post_group_contributor/all';
$route['member/post-list/mine']             = 'post_group_contributor/mine';
$route['member/post-list/published']        = 'post_group_contributor/published';
$route['member/post-category'] = 'member/error_page';
$route['member/post-tag'] = 'member/error_page';
$route['member/post-list'] = 'member/error_page';
$route['member/search-posts'] = 'member/post_search';
/**
*Public
*/

$route['post'] = 'public_view/post_all';