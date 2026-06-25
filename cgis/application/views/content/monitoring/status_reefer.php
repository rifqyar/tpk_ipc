<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Monitoring Status Behandle Reefer</title>
	<meta http-equiv="refresh" content="35000" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css?v2.1.0">

    <!-- jQuery library -->
    <script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
	<style>
		th{
			background: #ffffff;;
			color: #000; 
		}
		
		.body{
			font-size: 14px;
		}
	
		.contentGenap{
			background-color:#f1f1ff;
			line-height: 38px;
			color: #000;
			font-weight: bold;
		}
		.contentGanjil{
			background-color:#FFFFFF;
			line-height: 38px;
			color: #000;
			font-weight: bold;
		}
		.posisi1{
			background-color:#76ff03;
			line-height: 38px;
			color: #000;
			font-weight: bold;
			border: 1px solid #000;
		}
		.posisi2{
			background-color:red;
			line-height: 38px;
			color: #000;
			font-weight: bold;
			border: 1px solid #000
		}
		.posisi3{
			background-color:#9aa58c;
			line-height: 38px;
			color: #000;
			font-weight: bold;
			border: 1px solid #000
		}
		.posisi4{
			background-color:#33bfff;
			line-height: 38px;
			color: #000;
			font-weight: bold;
			border: 1px solid #000
		}
		.posisi5{
			background-color:#ffee33;
			line-height: 38px;
			color: #000;
			font-weight: bold;
			border: 1px solid #000
		}
		.posisi6{
			background-color:#2a3eb1;
			line-height: 38px;
			color: #000;
			font-weight: bold;
			border: 1px solid #000
		}

		
		.se-pre-con {
			position: fixed;
			left: 0px;
			top: 0px;
			width: 100%;
			height: 100%;
			z-index: 9999;
			background: url("<?php echo base_url(); ?>assets/images/loading.gif") center no-repeat #fff;
		}
		
		.header{
			background: red;
			border-radius: 10px;
			padding: 1em;
		}
		
		.header-title{
			color: #fff;
			font-weight: bold;
		}
		/*=========================================================*/
		#responseScroll {
		  height: 900px;
		  overflow-y: scroll;
		}
		#table_scroll {
		  width: 100%;
		  margin-top: 0px;
		  margin-bottom: 0px;
		  font-family: sans-serif;
	    color: #444;
	    border-collapse: collapse;
	    border: 1px solid #f2f5f7;
		}
		.table_scroll tr th{
		    background: #35A9DB;
		    color: #fff;
		    
		}
		 
		.table_scroll, th, td {
		    /*padding: 8px 20px;*/
		    text-align: center;
		}
		 
		.table_scroll tr:hover {
		    background-color: #f5f5f5;
		}
		 
		.table_scroll tr:nth-child(even) {
		    background-color: #f2f2f2;
		}

		table {
			width: 100%;
			table-layout: fixed;
		}

		table tr td {
			padding:0;
			margin:0 5px;
		}
		/*#table_scroll thead th {
		  padding: 10px;
		  background-color: #ea922c;
		  color: black;
		}
		#table_scroll tbody td {
		  padding: 10px;
		  background-color: white;
		  color: black;
		}*/
	</style>
</head>
<script>
    function realtime(){
        setTimeout(function(){ 
           window.location.reload();
           // alert("Hello"); 
        }, 150000);
    }
</script>
<body onload="realtime()">
	<div class="">
	<div id='loadingmessage' style='display:none' class='se-pre-con' align="center">
	</div>
	  <div class="panel-body" style="padding: 5px 0;">
	  <div class="header" align="center">
		<?php //if($title!=""): ?>
		<h2 class="header-title"><?php echo "MONITORING STATUS BEHANDLE REEFER"; ?></h2>
		<?php// endif; ?>
		
	  </div>
	  <div class="panel-body" style="margin-top: 20px;">
	  <div class="col-md-12">
			<div class="col-md-6">
				<form action="" method="GET">
				<div class="col-md-6"><input type="text" name="search" class="form-control" placeholder="No Container Or No SPK"></div>
				<div class="col-md-6"><button class="btn btn-primary">SEARCH</button></div>
				</form>
			</div>
			<div class="col-md-6">
				<button class="btn bp" style="color:#000; background-color: red">BELUM PERIKSA</button>
				<button class="btn sp" style="color:#000; background-color: #9aa58c">SEDANG PERIKSA</button>
				<button class="btn sep" style="color:#000; background-color: #76ff03">SELESAI PERIKSA</button>
			</div>
		</div>
	  </div>
	  <br>
	  <table class="body" cellspacing="1" style="border:2px" style='display:none;'>
	  	<tr class="title">
				<th style="text-align:center;width: 5%;">NO</th>
				<th style="text-align:center;">NO SPK</th>
				<th style="text-align:center;">KONTAINER</th>
				<th style="text-align:center;width: 5%;">SIZE</th>
				<th style="text-align:center;">STATUS BEHANDLE</th>
				<th style="text-align:center;">WAKTU SELESAI BEHANDLE</th>
			</tr>
	  </table>
		<div id="responselongroom" align="center"></div><div id="responseScroll">
		<table class="body" cellspacing="1" id="table_scroll" style="border:2px" class="table_scroll" style='display:none;'>
			<?php 
			$cekRows = count($list);
			if ($cekRows > 0) {
				$no = 0;
				foreach($list as $value){ 
					$no++;
					if($no%2==1){
						$class="contentGanjil";
					}else{
						$class="contentGenap";
					}
					
					if ($value->STATUS == 'BELUM PERIKSA') {
						$status = "<span class='label label-danger'>BELUM PERIKSA</span>";
						$posisi = "posisi2";
					} else if ($value->STATUS == 'SEDANG PERIKSA') {
						$status = "<span class='label label-primary'>SEDANG PERIKSA</span>";
						$posisi = "posisi3";
					} else if ($value->STATUS == 'SELESAI PERIKSA') {
						$status = "<span class='label label-success'>SELESAI PERIKSA</span>";
						$posisi = "posisi1";
					}


			?>
			<tr class="<?php echo $posisi; ?>">
				<td style="text-align:center;font-size:13px;width: 5%;"><?php echo $no; ?></td>
				<td style="text-align:center;font-size:13px;"><?php echo $value->NO_SPK; ?></td>
				<td style="text-align:center;font-size:13px;"><?php echo $value->KONTAINER; ?></td>
				<td style="text-align:center;font-size:13px;width: 5%;"><?php echo $value->SIZE; ?></td>
				<td style="text-align:center;font-size: 13px;"><?php echo $value->STATUS; ?></td>
				<td style="text-align:center;font-size: 13px;"><?php echo $value->WAKTU_SELESAI; ?></td>
				</div>
			</tr>
			<?php 
				} //else for
			} else { //else if
				echo "<td colspan='16' align='center'><span><h3 class='text-danger'><b>DATA TIDAK DITEMUKAN</b></h3></span></td>";
			}
			?>
		</table>
		<br/>
		<?php 
			//echo $this->pagination->create_links();
		?>
	  </div>
	</div>
</body>
</html>
<script>
	// function search(){
	// 	value = document.getElementById('jenis_dokumen').value;
	// 	statuslongroom = document.getElementById('statuslongroom').value;
	// 	$('#loadingmessage').show(); 
	// 	$.ajax({
 //            url: '<?php echo site_url('/monitoring/filterLongroom'); ?>',
 //            type: "POST",
 //            data: {vals: value, statuslongroom:statuslongroom},
 //            cache: true,
 //            success: function(response){     
	// 		   $("#tablehide").hide();
 //               $("#responselongroom").html(response);
	// 		   $('#loadingmessage').hide();
 //            }
 //        });
	// }
	
	// function refresh(){
	// 	window.location.reload();
	// }
// 	$(".bp").click(function() {
//     $('html,body').animate({
//         scrollTop: $(".posisi2").offset().top},
//         'slow');
// });
// 	$(".sp").click(function() {
//     $('html,body').animate({
//         scrollTop: $(".posisi3").offset().top},
//         'slow');
// });
// 	$(".sep").click(function() {
//     $('html,body').animate({
//         scrollTop: $(".posisi1").offset().top},
//         'slow');
// });
setTimeout(function() {
  location.reload();
}, 180000);
</script>
<script>
	var my_time;
$(document).ready(function() {
  pageScroll();
  $("#responseScroll").mouseover(function() {
    clearTimeout(my_time);
  }).mouseout(function() {
    pageScroll();
  });
});

// function pageScroll() {  
// 	var objDiv = document.getElementById("responseScroll");
//   objDiv.scrollTop = objDiv.scrollTop + 1;  
//   $('p:nth-of-type(1)').html('scrollTop : '+ objDiv.scrollTop);
//   $('p:nth-of-type(2)').html('scrollHeight : ' + objDiv.scrollHeight);
//   if (objDiv.scrollTop == (objDiv.scrollHeight - 100)) {
//     objDiv.scrollTop = 0;
//   }
//   my_time = setTimeout('pageScroll()', 25);
// }
</script>