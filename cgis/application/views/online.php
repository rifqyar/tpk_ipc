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
  <div align="right" >This page will reload in <span id="cnt" style="color:red;">500</span> Seconds</div>
  <!-- <div class="insideNotif" id="insideNotif"> -->



  </body>
  <script>
    var counter = 500;

    // The countdown method.
    window.setInterval(function () {
        counter--;
        if (counter >= 0) {
            var span;
            span = document.getElementById("cnt");
            span.innerHTML = counter;
        }
        if (counter === 0) {
            clearInterval(counter);
        }

    }, 1000);

    window.setInterval('refresh()', 500000);
    // function refresh() {
    //     window.location.reload();
    // }

</script>

<!-- <script>

$.ajax({
     type: "GET",
            url:'https://bos.ipclogistic.co.id/tpk_ipc/cgis/application.php/online/getAlerts',
     dataType:'json', // add json datatype to get json
     data: ({sattus: 'success'}),
     success: function(data){
         console.log(data);
     }
}); 
</script> -->

<!-- <script>
$(document).ready(function(){
 
    setInterval(function(){
    load_last_notification();
    }, 5000);
 
    function load_last_notification(){
        $.ajax({
        url:"https://bos.ipclogistic.co.id/tpk_ipc/cgis/application.php/online/getAlerts",
        method:"POST",
        success:function(data){
        $('.content').html(data);
        }
    })
    }
  });
  </script> -->
</html>
