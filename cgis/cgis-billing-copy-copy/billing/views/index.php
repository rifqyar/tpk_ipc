<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="">
  <meta name="author" content="">
  <script>
	var base_url = '<?php echo base_url(); ?>';
	var site_url = '<?php echo site_url(); ?>';
  </script>
  <title>{_title_}</title>
  {_headers_}
  <script>
  	$(window).load(function(){$('#page-loading').fadeOut();});
  </script>
  </head>
  <body class="site-menubar-fold site-menubar-keep">
  <div id="page-loading"></div>
  {_header_}
  {_menus_}
  <div class="page animsition">
  	{_breadcrumbs_}
    <div class="page-content container-fluid">
    	<div class="row">
  			{_content_}
    	</div>
    </div>
  </div>
  {_footer_}
  {_footers_}
  </body>
</html>
