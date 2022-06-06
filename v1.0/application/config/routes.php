<?php
defined('BASEPATH') or exit('No direct script access allowed');

// default

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

######################### -: Always First API :- #########################

$route['posts'] = 'afposts/getPosts';
$route['posts/page/(:any)'] = 'afposts/getPostsPage/$1';
$route['posts/category/(:any)'] = 'afposts/getPostsCategory/$1';
$route['posts/category/(:any)/page/(:any)'] = 'afposts/getPostsCategoryPage/$1/$2';
$route['posts/tag/(:any)'] = 'afposts/getPostsTag/$1';
$route['posts/tag/(:any)/page/(:any)'] = 'afposts/getPostsTagPage/$1/$2';
$route['search/(:any)'] = 'afposts/getPostsSearch/$1';
$route['search/(:any)/page/(:any)'] = 'afposts/getPostsSearchPage/$1/$2';
$route['posts/author/(:any)'] = 'afposts/getPostsAuthor/$1';
$route['posts/author/(:any)/page/(:any)'] = 'afposts/getPostsAuthorPage/$1/$2';
$route['getCategory'] = 'afposts/getCategory';
$route['getMenuCategory'] = 'afposts/getMenuCategory';
$route['getCats'] = 'afposts/getCats';
$route['getMenuCats'] = 'afposts/getMenuCats';
$route['socialLinks'] = 'afposts/socialLinks';

######################### -: Suryyas Kiran API :- #########################

$route['postsSK'] = 'afposts/getPostsSK';
$route['postsSK/page/(:any)'] = 'afposts/getPostsPageSK/$1';
$route['postsSK/category/(:any)'] = 'afposts/getPostsCategorySK/$1';
$route['postsSK/category/(:any)/page/(:any)'] = 'afposts/getPostsCategoryPageSK/$1/$2';
$route['postsSK/tag/(:any)'] = 'afposts/getPostsTagSK/$1';
$route['postsSK/tag/(:any)/page/(:any)'] = 'afposts/getPostsTagPageSK/$1/$2';
$route['searchSK/(:any)'] = 'afposts/getPostsSearchSK/$1';
$route['searchSK/(:any)/page/(:any)'] = 'afposts/getPostsSearchPageSK/$1/$2';
$route['postsSK/author/(:any)'] = 'afposts/getPostsAuthorSK/$1';
$route['postsSK/author/(:any)/page/(:any)'] = 'afposts/getPostsAuthorPageSK/$1/$2';
$route['getCategorySK'] = 'afposts/getCategorySK';
$route['getMenuCategorySK'] = 'afposts/getMenuCategorySK';
$route['getCatsSK'] = 'afposts/getCatsSK';
$route['getMenuCatsSK'] = 'afposts/getMenuCatsSK';
$route['socialLinksSK'] = 'afposts/socialLinksSK';


######################### -: END :- #########################
// advertisement API
$route['getAds'] = 'afposts/getAds';
$route['getAdsArticle'] = 'afposts/getAdsArticle';
$route['getScriptAds'] = 'afposts/getScriptAds';