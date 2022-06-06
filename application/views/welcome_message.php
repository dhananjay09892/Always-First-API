<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Welcome to Always First API</title>
	<style type="text/css">
		::selection {
			background-color: #E13300;
			color: white;
		}

		::-moz-selection {
			background-color: #E13300;
			color: white;
		}

		body {
			background-color: #fff;
			margin: 40px;
			font: 13px/20px normal Helvetica, Arial, sans-serif;
			color: #4F5155;
		}

		a {
			color: #003399;
			background-color: transparent;
			font-weight: normal;
		}

		h1 {
			color: #444;
			background-color: transparent;
			border-bottom: 1px solid #D0D0D0;
			font-size: 19px;
			font-weight: normal;
			margin: 0 0 14px 0;
			padding: 14px 15px 10px 15px;
		}

		code {
			font-family: Consolas, Monaco, Courier New, Courier, monospace;
			font-size: 12px;
			background-color: #f9f9f9;
			border: 1px solid #D0D0D0;
			color: #002166;
			display: block;
			margin: 14px 0 14px 0;
			padding: 12px 10px 12px 10px;
		}

		#body {
			margin: 0 15px 0 15px;
		}

		p.footer {
			text-align: right;
			font-size: 11px;
			border-top: 1px solid #D0D0D0;
			line-height: 32px;
			padding: 0 10px 0 10px;
			margin: 20px 0 0 0;
		}

		#container {
			margin: 10px;
			border: 1px solid #D0D0D0;
			box-shadow: 0 0 8px #D0D0D0;
		}
	</style>
</head>

<body>
	<div id="container">
		<h1>Always First API</h1>
		<div id="body">
			<h1>Posts API[POST] : </h1>
			<p>
				<a target="_blank" href="<?php echo base_url(''); ?>allPosts" rel="noopener noreferrer"><?php echo base_url(''); ?>allPosts</a>
			</p>
			<p>method : POST</p>
			<p>param = page</p>
			_____________
			<h1>Category Posts API[POST] : </h1>
			<p>
				<a target="_blank" href="<?php echo base_url(''); ?>allPosts/category" rel="noopener noreferrer"><?php echo base_url(''); ?>allPosts/category</a>
			</p>
			<p>method : POST</p>
			<p>param = id, page</p>
			_____________
			<h1>Tag Posts API[POST] : </h1>
			<p>
				<a target="_blank" href="<?php echo base_url(''); ?>allPosts/tag" rel="noopener noreferrer"><?php echo base_url(''); ?>allPosts/tag</a>
			</p>
			<p>method : POST</p>
			<p>param = id, page</p>
			_____________
			<h1>Search Posts API[POST] : </h1>
			<p>
				<a target="_blank" href="<?php echo base_url(''); ?>allPosts/search" rel="noopener noreferrer"><?php echo base_url(''); ?>allPosts/search</a>
			</p>
			<p>method : POST</p>
			<p>param = s, page</p>
			_____________
			<h1>Author Posts API[POST] : </h1>
			<p>
				<a target="_blank" href="<?php echo base_url(''); ?>allPosts/author" rel="noopener noreferrer"><?php echo base_url(''); ?>allPosts/author</a>
			</p>
			<p>method : POST</p>
			<p>param = id, page</p>
			_____________
			<p></p>
			<h1>Category List API[GET] : </h1>
			<p>
				<a href="<?php echo base_url(''); ?>getCategory" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>getCategory</a>
			</p>
			_____________
			<h1>Menu Category List API[GET] : </h1>
			<p>
				<a href="<?php echo base_url(''); ?>getMenuCategory" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>getMenuCategory</a>
			</p>
			_____________
			<h1>Social Links API[GET] :</h1>
			<p>
				<a href="<?php echo base_url(''); ?>socialLinks" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>socialLinks</a>
			</p>
			_____________
			<h1>Home Page Ads API[GET] : </h1>
			<p>
				<a href="<?php echo base_url(''); ?>getAds" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>getAds</a>
			</p>
			_____________
			<h1>Article Page Ads API[GET] :</h1>
			<p>
				<a href="<?php echo base_url(''); ?>getAdsArticle" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>getAdsArticle</a>
			</p>
			_____________
			<h1>Script Ads API[GET] : </h1>
			<p>
				<a href="<?php echo base_url(''); ?>getScriptAds" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>getScriptAds</a>
			</p>
			_____________
			<h1>Feedback API[POST] :</h1>
			<p>
				<a href="<?php echo base_url(''); ?>feedback" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>feedback</a>
			</p>
			<p>param = name, email, message and phone</p>
			_____________
			<h1>privacyPolicy API[POST] :</h1>
			<p>
				<a href="<?php echo base_url(''); ?>privacyPolicy" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>privacyPolicy</a>
			</p>
			<p>Privacy Policy & Terms and Conditions & Disclaimer</p>
			_____________
			<p></p>
		</div>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo (ENVIRONMENT === 'development') ? 'Web Strataegic Solutions <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</body>

</html>