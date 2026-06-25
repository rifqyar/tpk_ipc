<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Monitoring Customs</title>
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css?v2.1.0">
	<style>
		[data-notify="container"][class*="alert-pastel-"] {
			background-color: rgb(255, 255, 238);
			border-width: 0px;
			border-left: 15px solid rgb(255, 240, 106);
			border-radius: 0px;
			box-shadow: 0px 0px 5px rgba(51, 51, 51, 0.3);
			font-family: 'Old Standard TT', serif;
			letter-spacing: 1px;
			font-size: medium;
		}
		[data-notify="container"].alert-pastel-info {
			border-left-color: #76ff03;
		}
		[data-notify="container"].alert-pastel-danger {
			border-left-color: #76ff03;
		}
		[data-notify="container"][class*="alert-pastel-"] > [data-notify="title"] {
			color: rgb(80, 80, 57);
			display: block;
			font-weight: 700;
			margin-bottom: 5px;
		}
		[data-notify="container"][class*="alert-pastel-"] > [data-notify="message"] {
			font-weight: 800;
			font-size: 40px;
		}
	</style>
    <!-- jQuery library -->
    <script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/bootstrap-notify.min.js"></script>
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
        }, 100000);
    }
</script>
<body onload="realtime()">
	<div class="">
	<div id='loadingmessage' style='display:none' class='se-pre-con' align="center">
	</div>
	  <div class="panel-body" style="padding: 5px 0;">
	  <div class="header" align="center">
		<?php //if($title!=""): ?>
		<h2 class="header-title"><?php echo "MONITORING CUSTOMS"; ?></h2>
		<?php// endif; ?>
		
	  </div>
	  <div class="panel-body" style="margin-top: 20px;">
	  <div class="col-md-12">
			<div class="col-md-6">
				<form action="" method="GET">
				<div class="col-md-6"><input type="text" name="search" class="form-control" placeholder="No Container Or No Document"></div>
				<div class="col-md-6"><button class="btn btn-primary">SEARCH</button></div>
				</form>
			</div>
			<div class="col-md-6">
				<button class="btn" style="color:#000; background-color: #76ff03">SIAP PERIKSA</button>
				<button class="btn" style="color:#000; background-color: red">PPK</button>
				<button class="btn" style="color:#000; background-color: #9aa58c">BELUM RESPON</button>
				<button class="btn" style="color:#000; background-color: #33bfff">SEDANG PERIKSA</button>
				<button class="btn" style="color:#000; background-color: #ffee33">WAITING</button>
				<button class="btn" style="color:#000; background-color: #2a3eb1">SELESAI PERIKSA</butt>
			</div>
		</div>
	  </div>
	  <br>
	  <table class="body" cellspacing="1" style="border:2px" style='display:none;'>
	  	<tr class="title">
				<th style="text-align:center;width: 5%;">NO</th>
				<th style="text-align:center;">KONTAINER</th>
				<th style="text-align:center;width: 5%;">SIZE</th>
				<th style="text-align:center;">TANGGAL</th>
				<th style="text-align:center;">JENIS DOKUMEN</th>
				<th style="text-align:center;">NO DOKUMEN</th>
				<th style="text-align:center;">LOKASI</th>
				<th style="text-align:center;">KETERANGAN</th>
				<!-- <th style="text-align:center;">CUSTOMER</th> -->
				<th style="text-align:center;">STATUS</th>
				<th style="text-align:center;">RESPON</th>
				<th style="text-align:center;">TGL PPK</th>
				<th style="text-align:center;">OPTION</th>
			</tr>
	  </table>
		<div id="responselongroom" align="center"></div><div id="responseScroll">
		<table class="body" cellspacing="1" id="table_scroll" style="border:2px" class="table_scroll" style='display:none;'>
			<?php 
			$cekRows = count($datalongroom);
			if ($cekRows > 0) {
				$no = 0;
				foreach($datalongroom as $value){ 
					$no++;
					if($no%2==1){
						$class="contentGanjil";
					}else{
						$class="contentGenap";
					}
					
					if ($value->STATUS == 'SIAP PERIKSA') {
						$waktu = $value->WK_ACTIVE;
						$status = "<span class='label label-warning'>SIAP PERIKSA</span>";
					} else if ($value->STATUS == 'PKB') {
						$waktu = $value->WK_ACTIVE;
						$status = "<span class='label label-danger'>PPK</span>";
					} else if ($value->STATUS == 'BELUM PKB') {
						$waktu = $value->WK_ACTIVE;
						$status = "<span class='label label-danger'>BELUM PPK</span>";
					} else if ($value->STATUS == 'SEDANG PERIKSA') {
						$waktu = $value->WK_ACTIVE;
						$status = "<span class='label label-primary'>SEDANG PERIKSA</span>";
					} else if ($value->STATUS == 'SELESAI PERIKSA') {
						$waktu = $value->WK_ACTIVE;
						$status = "<span class='label label-success'>SELESAI PERIKSA</span>";
					}

					if ($value->RESPON == 'PPK LONGROOM') {
						$responbc = "<span class='label label-danger'>PPK LONGROOM</span>";
						$wk_responbc = $value->WK_RESPON;
					} else if ($value->RESPON == 'PPK YARD') {
						$responbc = "<span class='label label-success'>PPK YARD</span>";
						$wk_responbc = $value->WK_RESPON;
					} else if ($value->RESPON == 'NO PPK') {
						$responbc = "<span class='label label-success'>NO PPK</span>";
						$wk_responbc = $value->WK_RESPON;
					} else if ($value->RESPON == 'PERIKSA ULANG') {
						$responbc = "<span class='label label-success'>PERIKSA ULANG</span>";
						$wk_responbc = $value->WK_RESPON;
					} else if ($value->RESPON == 'PERIKSA TAMBAHAN') {
						$responbc = "<span class='label label-success'>PERIKSA TAMBAHAN</span>";
						$wk_responbc = $value->WK_RESPON;
					} else if ($value->RESPON == 'NHI') {
						$responbc = "<span class='label label-success'>NHI</span>";
						$wk_responbc = $value->WK_RESPON;
					} else if ($value->RESPON == 'RETURNABLE PACKAGE(RP)') {
						$responbc = "<span class='label label-success'>RETURNABLE PACKAGE(RP)</span>";
						$wk_responbc = $value->WK_RESPON;
					} else if ($value->RESPON == 'PIBK') {
						$responbc = "<span class='label label-success'>PIBK</span>";
						$wk_responbc = $value->WK_RESPON;
					} else {
						$responbc = "<span style='color:red;font-weight:bold'>NO RESPON</span>";
						$wk_responbc = "-";
					}
					switch ($value->STATUS2) {
						case 1:
							$status2 = "<span style='color:#000;font-weight:bold'>SIAP PERIKSA</span>";
							$posisi = "posisi1";
							break;
						case 2:
							$status2 = "<span style='color:#000;font-weight:bold'>PPK</span>";
							$posisi = "posisi2";
							break;
						case 3:
							$status2 = "<span style='color:#000;font-weight:bold'>BELUM PPK</span>";
							$posisi = "posisi3";
							break;
						case 4:
							$status2 = "<span style='color:#000;font-weight:bold'>SEDANG PERIKSA</span>";
							$posisi = "posisi4";
							break;
						case 5:
							$status2 = "<span style='color:#000;font-weight:bold'>WAITING</span>";
							$posisi = "posisi5";
							break;
						case 6:
							$status2 = "<span style='color:000;font-weight:bold'>SELESAI PERIKSA</span>";
							$posisi = "posisi6";
							break;
					}
			?>
			<tr class="<?php echo $posisi; ?>">
				<td style="text-align:center;font-size:13px;width: 5%;"><?php echo $no; ?></td>
				<td style="text-align:center;font-size:22px;"><?php echo $value->NO_CONT; ?></td>
				<td style="text-align:center;font-size:13px;width: 5%;"><?php echo $value->UKR_CONT; ?></td>
				<td style="text-align:center;font-size: 13px;"><?php echo $value->TGL_DOK; ?></td>
				<td style="text-align:center;font-size: 13px;"><?php echo $value->JNS_DOK; ?></td>
				<td style="text-align:center;font-size: 13px;"><?php echo $value->NO_DOK; ?></td>
				<td style="text-align:center;font-size: 13px;"><?php echo $value->LOKASI; ?></td>
				<td style="text-align:center;font-size: 13px;"><?php echo "BEHANDLE ".$value->JNS_KEGIATAN; ?></td>
				<!-- <td style="text-align:center;font-size: 13px;"><?php //echo $value->NAMA_CUST; ?></td> -->
				<td style="text-align:center;font-size: 15px;"><?php echo $status2; ?></td>
				<td style="text-align:center;font-size: 13px;"><?php echo $responbc; ?></td>
				<td style="text-align:center;font-size: 13px;"><?php echo $value->WK_RESPON; ?></td>
				<td style="text-align:center;font-size: 13px;">
					<?php
						if ($value->STATUS2 == 1) {
							//echo '<a href="'.base_url().'application.php/display/set_pemeriksaan?no_cont='.$value->NO_CONT.'" class="btn btn-primary">SP</button>';
							echo '<button id="notificlick" data-cont="'.$value->NO_CONT.'" class="btn btn-primary notif">click</button>';
						}
					?>
				</td>
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
	function search(){
		value = document.getElementById('jenis_dokumen').value;
		statuslongroom = document.getElementById('statuslongroom').value;
		$('#loadingmessage').show(); 
		$.ajax({
            url: '<?php echo site_url('/monitoring/filterLongroom'); ?>',
            type: "POST",
            data: {vals: value, statuslongroom:statuslongroom},
            cache: true,
            success: function(response){     
			   $("#tablehide").hide();
               $("#responselongroom").html(response);
			   $('#loadingmessage').hide();
            }
        });
	}
	
	function refresh(){
		window.location.reload();
	}
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

$('.notif').click(function() {
	let datacon = $(this).data("cont");
	$.post("set_pemeriksaan",
    {
		no_cont: datacon
    },
    function(data,status){
		console.log(data);
		$.notify({
			title: 'INFORMATION',
			message: data
		},{
			type: 'pastel-warning',
			delay: 5000,
			template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
				'<span data-notify="title"><b>{1}<b></span>' +
				'<span data-notify="message">{2}</span><br>' +
				'<span>Page Ini Akan Di reload Otomatis waktu 10 detik</span>' +
			'</div>'
		});
		setTimeout(function() {
			window.location.reload();
		}, 5000);
	});
});

function pageScroll() {  
	var objDiv = document.getElementById("responseScroll");
  objDiv.scrollTop = objDiv.scrollTop + 1;  
  $('p:nth-of-type(1)').html('scrollTop : '+ objDiv.scrollTop);
  $('p:nth-of-type(2)').html('scrollHeight : ' + objDiv.scrollHeight);
  if (objDiv.scrollTop == (objDiv.scrollHeight - 100)) {
    objDiv.scrollTop = 0;
  }
  my_time = setTimeout('pageScroll()', 1);
}
</script>