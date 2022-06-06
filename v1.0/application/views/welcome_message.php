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
			<p>Posts API[GET] : </p>
			<p>
				<a target="_blank" href="<?php echo base_url(''); ?>posts" rel="noopener noreferrer"><?php echo base_url(''); ?>posts</a>
			</p>
			_____________
			<p>Pages Posts API[GET] : </p>
			<p>
				<a target="_blank" href="<?php echo base_url(''); ?>posts/page/2" rel="noopener noreferrer"><?php echo base_url(''); ?>posts/page/(:page)</a>
			</p>
			_____________
			<p>Category Posts API[GET] : </p>
			<p>
				<a href="<?php echo base_url(''); ?>posts/category/129" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>posts/category/(:CategoryID)</a>
			</p>
			<p>Category :- 12859,129,2639 (for testing)</p>
			_____________
			<p>Category Posts Pages API[GET] : </p>
			<p>
				<a href="<?php echo base_url(''); ?>posts/category/129/page/2" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>posts/category/(:CategoryID)/page/(:page)</a>
			</p>
			_____________
			<p>Tags Posts API[GET] : </p>
			<p>
				<a href="<?php echo base_url(''); ?>posts/tag/5018" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>posts/tag/(:TagID)</a>
			</p>
			<p>Tages :- 5018, 11555, 11740 (for testing)</p>
			_____________
			<p>Tags Posts Pages API[GET] : </p>
			<p>
				<a href="<?php echo base_url(''); ?>posts/tag/5018/page/2" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>posts/tag/(:TagID)/page/(:page)</a>
			</p>
			_____________
			<p>Search Posts API[GET] : </p>
			<p>
				<a href="<?php echo base_url(''); ?>search/india" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>search/(:string)</a>
			</p>
			_____________
			<p>Search Posts Pages API[GET] : </p>
			<p>
				<a href="<?php echo base_url(''); ?>search/inida/page/2" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>search/(:string)/page/(:page)</a>
			</p>
			_____________
			<p>Author Posts API[GET] : </p>
			<p>
				<a href="<?php echo base_url(''); ?>posts/author/11" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>posts/author/(:authorID)</a>
			</p>
			<p>Author Ids :- 1,2,3,11</p>
			_____________
			<p>Author Posts Pages API[GET] : </p>
			<p>
				<a href="<?php echo base_url(''); ?>posts/author/11/page/2" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>posts/author/(:authorID)/page/(:page)</a>
			</p>
			_____________
			<p>Category List API[GET] : </p>
			<p>
				<a href="<?php echo base_url(''); ?>getCategory" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>getCategory</a>
			</p>
			_____________
			<p>Menu Category List API[GET] : </p>
			<p>
				<a href="<?php echo base_url(''); ?>getMenuCategory" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>getMenuCategory</a>
			</p>
			_____________
			<p>Social Links API[GET] : </p>
			<p>
				<a href="<?php echo base_url(''); ?>socialLinks" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>socialLinks</a>
			</p>
			_____________
			<p>Home Page Ads API[GET] : </p>
			<p>
				<a href="<?php echo base_url(''); ?>getAds" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>getAds</a>
			</p>
			_____________
			<p>Article Page Ads API[GET] : </p>
			<p>
				<a href="<?php echo base_url(''); ?>getAdsArticle" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>getAdsArticle</a>
			</p>
			_____________
			<p>Script Ads API[GET] : </p>
			<p>
				<a href="<?php echo base_url(''); ?>getScriptAds" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>getScriptAds</a>
			</p>
			_____________
			<p></p>
		</div>
	</div>
	<div id="container">
		<h1>Suryyas Kiran API</h1>
		<div id="body">
			<p>Posts API[GET] : </p>
			<p>
				<a target="_blank" href="<?php echo base_url(''); ?>postsSK" rel="noopener noreferrer"><?php echo base_url(''); ?>postsSK</a>
			</p>
			_____________
			<p>Pages Posts API[GET] : </p>
			<p>
				<a target="_blank" href="<?php echo base_url(''); ?>postsSK/page/2" rel="noopener noreferrer"><?php echo base_url(''); ?>postsSK/page/(:page)</a>
			</p>
			_____________
			<p>Category Posts API[GET] : </p>
			<p>
				<a href="<?php echo base_url(''); ?>postsSK/category/129" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>postsSK/category/(:CategoryID)</a>
			</p>
			<p>Category :- 12859,129,2639 (for testing)</p>
			_____________
			<p>Category Posts Pages API[GET] : </p>
			<p>
				<a href="<?php echo base_url(''); ?>postsSK/category/129/page/2" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>postsSK/category/(:CategoryID)/page/(:page)</a>
			</p>
			_____________
			<p>Tags Posts API[GET] : </p>
			<p>
				<a href="<?php echo base_url(''); ?>postsSK/tag/5018" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>postsSK/tag/(:TagID)</a>
			</p>
			<p>Tages :- 5018, 11555, 11740 (for testing)</p>
			_____________
			<p>Tags Posts Pages API[GET] : </p>
			<p>
				<a href="<?php echo base_url(''); ?>postsSK/tag/5018/page/2" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>postsSK/tag/(:TagID)/page/(:page)</a>
			</p>
			_____________
			<p>Search Posts API[GET] : </p>
			<p>
				<a href="<?php echo base_url(''); ?>searchSK/india" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>searchSK/(:string)</a>
			</p>
			_____________
			<p>Search Posts Pages API[GET] : </p>
			<p>
				<a href="<?php echo base_url(''); ?>searchSK/inida/page/2" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>searchSK/(:string)/page/(:page)</a>
			</p>
			_____________
			<p>Author Posts API[GET] : </p>
			<p>
				<a href="<?php echo base_url(''); ?>postsSK/author/11" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>postsSK/author/(:authorID)</a>
			</p>
			<p>Author Ids :- 1,2,3,11</p>
			_____________
			<p>Author Posts Pages API[GET] : </p>
			<p>
				<a href="<?php echo base_url(''); ?>postsSK/author/11/page/2" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>postsSK/author/(:authorID)/page/(:page)</a>
			</p>
			_____________
			<p>Category List API[GET] : </p>
			<p>
				<a href="<?php echo base_url(''); ?>getCategorySK" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>getCategorySK</a>
			</p>
			_____________
			<p>Menu Category List API[GET] : </p>
			<p>
				<a href="<?php echo base_url(''); ?>getMenuCategorySK" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>getMenuCategorySK</a>
			</p>
			_____________
			<p>Social Links API[GET] : </p>
			<p>
				<a href="<?php echo base_url(''); ?>socialLinksSK" target="_blank" rel="noopener noreferrer"><?php echo base_url(''); ?>socialLinksSK</a>
			</p>
			_____________
			<p></p>
		</div>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo (ENVIRONMENT === 'development') ? 'Web Strataegic Solutions <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</body>

</html>