<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="bootstrap material admin template">
  <meta name="author" content="">
  <script>
	var base_url = '<?php echo base_url(); ?>';
	var site_url = '<?php echo site_url(); ?>';
  </script>
  <title>{_title_}</title>
  {_headers_}
  </head>
  <body class="page-login layout-full page-dark">
  {_content_}
  {_footers_}
  <script>
	(function(document, window, $){
		'use strict';
		var Site = window.Site;
		$(document).ready(function(){
			Site.run();
		});
	})(document, window, jQuery);
  </script>
  </body>
</html>