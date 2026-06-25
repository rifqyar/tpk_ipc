<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Monitoring Customs</title>
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
		.posisi7{
			background-color:#e8e8e8;
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
				<button class="btn" style="color:#000; background-color: #76ff03">SIAP PERIKSA <?php echo $datacount[0]->{"SIAP_PERIKSA"} ?> </button>
				<button class="btn" style="color:#000; background-color: red">PPK <?php echo $datacount[0]->{"ANTRIAN_PERIKSA"} ?> </button>
				<button class="btn" style="color:#000; background-color: #9aa58c">BELUM RESPON <?php echo $datacount[0]->{"BELUM_PPK"} ?> </button>
				<button class="btn" style="color:#000; background-color: #33bfff">SEDANG PERIKSA <?php echo $datacount[0]->{"SEDANG_PERIKSA"} ?> </button>
				<button class="btn" style="color:#000; background-color: #ffee33">WAITING <?php echo $datacount[0]->{"WAITING"} ?> </button>
				<button class="btn" style="color:#000; background-color: #2a3eb1">SELESAI PERIKSA <?php echo $datacount[0]->{"SELESAI_PERIKSA"} ?> </butt>
				<button class="btn" style="color:#000; background-color: #e8e8e8">BELUM SPK <?php echo $datacount[0]->{"BELUM_SPK"} ?> </butt>
			</div>
		</div>
	  </div>
	  <br>
	  <table class="body" cellspacing="1" style="border:2px" style='display:none;'>
	  	<tr class="title">
				<th style="text-align:center;width: 3%;">NO</th>
				<th style="text-align:center;width: 5%;">NO URUT</th>
				<th style="text-align:center;">KONTAINER</th>
				<th style="text-align:center;width: 7%; ">SIZE</th>
				<th style="text-align:center;width: 3%;">TIPE</th>
				<th style="text-align:center;">TANGGAL</th>
				<th style="text-align:center;">JENIS DOKUMEN</th>
				<th style="text-align:center;">NO DOKUMEN</th>
				<th style="text-align:center;">LOKASI</th>
				<th style="text-align:center;">KETERANGAN</th>
				<th style="text-align:center;">NOTE</th>
				<!-- <th style="text-align:center;">CUSTOMER</th> -->
				<th style="text-align:center;">STATUS</th>
				<th style="text-align:center;">RESPON</th>
				<th style="text-align:center;">TGL PPK</th>
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
						case 7:
							$status2 = "<span style='color:000;font-weight:bold'>BELUM SPK</span>";
							$posisi = "posisi7";
							break;
					}
			?>
			<tr class="<?php echo $posisi; ?>">
				<td style="text-align:center;font-size:13px;width: 3%;"><?php echo $no; ?></td>
				<td style="text-align:center;font-size:13px;width: 5%;">
				<?php
					if ($value->no_antrian) {
						echo "<button class='btn btn-primary' style='font-size:15px; padding:6px 10px;'>".$value->no_antrian."</button>";
					}
				?></td>
				<td style="text-align:center;font-size:22px;"><?php echo $value->NO_CONT; ?></td>
				<td style="text-align:center;font-size:13px;width: 7%;"><?php echo $value->UKR_CONT; ?></td>
				<td style="text-align:center;font-size: 13px;width: 3%;"><?php echo $value->tipe_cont; ?></td>
				<td style="text-align:center;font-size: 13px;"><?php echo $value->TGL_DOK; ?></td>
				<td style="text-align:center;font-size: 13px;"><?php echo $value->JNS_DOK; ?></td>
				<td style="text-align:center;font-size: 13px;"><?php echo $value->NO_DOK; ?></td>
				<td style="text-align:center;font-size: 13px;"><?php echo $value->LOKASI; ?></td>
				<td style="text-align:center;font-size: 13px;"><?php echo "BEHANDLE ".$value->JNS_KEGIATAN; ?></td>
				<td style="text-align:center;font-size: 13px;"><?php echo $value->NOTE; ?></td>
				<!-- <td style="text-align:center;font-size: 13px;"><?php //echo $value->NAMA_CUST; ?></td> -->
				<td style="text-align:center;font-size: 15px;"><?php echo $status2; ?></td>
				<td style="text-align:center;font-size: 13px;"><?php echo $responbc; ?></td>
				<td style="text-align:center;font-size: 13px;"><?php echo $value->WK_RESPON; ?></td>
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
	var scrtop = -1;
	var autoscr = true;
	var waktu = 25;
$(document).ready(function() {
	let winsize = $(window).height() - 200;
	$('#responseScroll').css('height',winsize);
  pageScroll();
  $("#responseScroll").mouseover(function() {
    clearTimeout(my_time);
  }).mouseout(function() {
    pageScroll();
  });
});

function pageScroll() {  
	
	var objDiv = document.getElementById("responseScroll");
	
	if (autoscr) {
		objDiv.scrollTop = objDiv.scrollTop + 1;  
		$('p:nth-of-type(1)').html('scrollTop : '+ objDiv.scrollTop);
		$('p:nth-of-type(2)').html('scrollHeight : ' + objDiv.scrollHeight);
		if (objDiv.scrollTop == (objDiv.scrollHeight - 100)) {
			objDiv.scrollTop = 0;
		}
		//console.log('objDiv.scrollTop : '+ objDiv.scrollTop);
		//console.log('objDiv.scrollHeight : '+ objDiv.scrollHeight);
	}else{
		objDiv.scrollTop = objDiv.scrollTop - 1;  
		$('p:nth-of-type(1)').html('scrollTop : '- objDiv.scrollTop);
		$('p:nth-of-type(2)').html('scrollHeight : ' - objDiv.scrollHeight);
		if (objDiv.scrollTop == (objDiv.scrollHeight - 100)) {
			objDiv.scrollTop = 0;
		}
		//console.log('objDiv.scrollTop : '+ objDiv.scrollTop);
		//console.log('objDiv.scrollHeight : '+ objDiv.scrollHeight);
	}
	my_time = setTimeout('pageScroll()', waktu);

	if (objDiv.scrollTop == scrtop) {
		autoscr = false;
		waktu = 1;
	}
	if (objDiv.scrollTop == 0) {
		autoscr = true;
		waktu = 25;
	}
	scrtop = objDiv.scrollTop;
}
</script>