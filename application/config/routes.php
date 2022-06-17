<?php
defined('BASEPATH') or exit('No direct script access allowed');

// default

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Always First New Api Routes
$route['allPosts'] = 'test/getTest';
$route['allPosts/category'] = 'test/getTestCategory';
$route['allPosts/tag'] = 'test/getTestTag';
$route['allPosts/search'] = 'test/getTestSearch';
$route['allPosts/author'] = 'test/getTestAuthor';

// Always Last Old Api Routes
$route['getCategory'] = 'test/getCategory';
$route['getMenuCategory'] = 'test/getMenuCategory';

// Getting JSON data from Live Server
$route['getCats'] = 'test/getCats';
$route['getMenuCats'] = 'test/getMenuCats';

// Social Links 
$route['socialLinks'] = 'test/socialLinks';

// advertisement API
$route['getAds'] = 'test/getAds';
$route['getAdsCategory'] = 'test/getAdsCategory';
// $route['getAdsArticle'] = 'test/getAdsArticle';
// $route['getScriptAds'] = 'test/getScriptAds';

$route['feedback'] = 'test/feedback';
$route['privacyPolicy'] = 'test/privacyPolicy';
$route['termsAndConditions'] = 'test/termsAndConditions';
$route['videos']= 'test/videos';
$route['marketAPI']= 'test/marketAPI';

// login API

$route['login'] = 'login/login'; // Done
// post Data = array('email'=>'','password'=>'');
$route['register'] = 'login/register'; // Done 
// post Data = array('name'=>,'email'=>'','password'=>'','device_id'=>'','device_token'=>'');
$route['socialLogin'] = 'login/socialLogin'; // Done
// post Data = array('name'=>,'email'=>'','device_id'=>'','device_token'=>'','login_type'=>'');
$route['getUserCategory'] = 'login/getUserCategory'; // Done
// post Data = array('user_id'=>'');
$route['postUserCategory'] = 'login/postUserCategory'; // Done
// post Data = array('user_id'=>'','category'=>'');
$route['forgotPassword'] = 'login/forgotPassword'; // Done 
// post Data = array('email'=>'');
$route['verifyOTP'] = 'login/verifyOTP'; // Done
// post Data = array('user_id'=>'','otp'=>'');
$route['resetPassword'] = 'login/resetPassword'; // Done
// post Data = array('user_id'=>'','password'=>'');
$route['getUserCategoryNew'] = 'login/getUserCategoryNew'; // Done
// post Data = array('user_id'=>'');
$route['getOTP'] = 'login/getOTP'; // Done
// post Data = array('user_id'=>'');