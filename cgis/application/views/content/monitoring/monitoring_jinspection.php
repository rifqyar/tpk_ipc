<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Monitoring Join Inspection</title>
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
		#responseScrollHead {
		  height: 46px;
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

		#table_scroll_head {
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
		<h2 class="header-title"><?php echo "MONITORING JOIN INSPECTION"; ?></h2>
		<?php// endif; ?>
		
	  </div>
	  <div class="panel-body" style="margin-top: 20px;">
	  <div class="col-md-12">
			<div class="col-md-6">
				<form action="" method="GET">
				<div class="col-md-6"><input type="text" name="search" class="form-control" placeholder="No Container Or No Aju"></div>
				<div class="col-md-6"><button class="btn btn-primary">SEARCH</button></div>
				</form>
			</div>
			<div class="col-md-6">
				<button class="btn" style="color:#000; background-color: #76ff03">SIAP PERIKSA</button>
				<button class="btn" style="color:#000; background-color: red">IPK</button>
				<button class="btn" style="color:#000; background-color: #9aa58c">BELUM RESPON</button>
				<button class="btn" style="color:#000; background-color: #33bfff">SEDANG PERIKSA</button>
				<button class="btn" style="color:#000; background-color: #ffee33">WAITING</button>
				<button class="btn" style="color:white; background-color: #2a3eb1">SELESAI PERIKSA</butt>
			</div>
		</div>
	  </div>
	  <br>
	  <div id="responseScrollHead">
	  <table class="body" cellspacing="1" id="table_scroll_head" style="width: 99%;"class="table_scroll">
	  	<tr class="title">
				<th rowspan="2" style="text-align:center;width: 3%;border:1px solid">NO</th>
				<th rowspan="2" style="text-align:center;width: 7%;border:1px solid">NO URUT</th>
				<th rowspan="2" style="text-align:center;width: 14%;border:1px solid">KONTAINER</th>
				<th rowspan="2" style="text-align:center;width: 3%;border:1px solid ">SIZE</th>
				<th rowspan="2" style="text-align:center;width: 4%;border:1px solid">TIPE</th>
				<th rowspan="2" style="text-align:center;width: 20%;border:1px solid">DOKUMEN JOIN INSPECTION</th>
				<th rowspan="2" style="text-align:center;width: 20%;border:1px solid">DOKUMEN KARANTINA DAN BEA CUKAI</th>
				<th rowspan="2" style="text-align:center;width: 6%;border:1px solid">LOKASI</th>
				<th rowspan="2" style="text-align:center;width: 7%;border:1px solid">STATUS</th>
				<th colspan="2" style="text-align:center;width: 8%;border:1px solid">RESPON PKB</th>
				<th rowspan="2" style="text-align:center;width: 7%;border:1px solid">WAKTU RESPON</th>
				<th rowspan="2" style="text-align:center;width: 7%;border:1px solid">JADWAL PERIKSA</th>
			</tr>
	  </table>
	</div>

		<div id="responselongroom" align="center"></div><div id="responseScroll">
		<table class="body" cellspacing="1" id="table_scroll" style="width: 99%;"class="table_scroll">
			<?php 
			$cekRows = count($jinspection);
			if ($cekRows > 0) {
				$no = 0;
				foreach($jinspection as $value){ 
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

					if ($value->respon_karantina == 'PPK LONGROOM') {
						$responkaranina = "<span class='label label-danger'>PPK LONGROOM</span>";
						$wk_responbc = $value->respon_karantina;
					} else if ($value->respon_karantina == 'PPK YARD') {
						$responkaranina = "<span class='label label-success'>PPK YARD</span>";
						$wk_responbc = $value->respon_karantina;
					} else if ($value->respon_karantina == 'NO PPK') {
						$responkaranina = "<span class='label label-success'>NO PPK</span>";
						$wk_responbc = $value->respon_karantina;
					} else if ($value->respon_karantina == 'PERIKSA ULANG') {
						$responkaranina = "<span class='label label-success'>PERIKSA ULANG</span>";
						$wk_responbc = $value->respon_karantina;
					} else if ($value->respon_karantina == 'PERIKSA TAMBAHAN') {
						$responkaranina = "<span class='label label-success'>PERIKSA TAMBAHAN</span>";
						$wk_responbc = $value->respon_karantina;
					} else if ($value->respon_karantina == 'NHI') {
						$responkaranina = "<span class='label label-success'>NHI</span>";
						$wk_responbc = $value->respon_karantina;
					} else if ($value->respon_karantina == 'RETURNABLE PACKAGE(RP)') {
						$responkaranina = "<span class='label label-success'>RETURNABLE PACKAGE(RP)</span>";
						$wk_responbc = $value->respon_karantina;
					} else if ($value->respon_karantina == 'PIBK') {
						$responkaranina = "<span class='label label-success'>PIBK</span>";
						$wk_responbc = $value->respon_karantina;
					} else {
						$responkaranina = "<span style='color:red;font-weight:bold'>NO RESPON</span>";
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
			<tr class="<?php echo $posisi; ?>" style="width: 99%;">
				<td style="text-align:center;font-size:13px;width: 3%;border:1px solid"><?php echo $no; ?></td>
				<td style="text-align:center;font-size:13px;width: 7%;border:1px solid">
				<?php
					if ($value->no_antrian) {
						echo "<button class='btn btn-primary' style='font-size:15px; padding:6px 10px;'>".$value->no_antrian."</button>";
					}
				?></td>
				<td style="text-align:center;font-size:22px;width: 14%;border:1px solid"><?php echo $value->NO_CONT; ?></td>
				<td style="text-align:center;font-size:13px;width: 3%;border:1px solid"><?php echo $value->UKR_CONT; ?></td>
				<td style="text-align:center;font-size: 13px;width: 4%;border:1px solid"><?php echo $value->tipe_cont; ?></td>
				<td style="text-align:center;font-size: 13px; width: 20%;border:1px solid"> 
					Jenis: Join Inspection <br>
					No: <?php echo $value->LNSW_NOAJU; ?> <br>
					Tanggal: <?php echo $value->LNSW_TGLAJU; ?></td>
				<td style="text-align:center;font-size: 13px;width: 20%;border:1px solid"> 
					Jenis: Karantina <br>
					No: <?php echo $value->NO_RESPON; ?> <br>
					Tanggal: <?php echo $value->TG_RESPON; ?> <br>
					Jenis: Bea Cukai <br>
					No: <?php echo $value->NO_DAFTAR_PABEAN; ?> <br>
					Tanggal: <?php echo $value->TGL_DAFTAR_PABEAN; ?>

				</td>
				<td style="text-align:center;font-size: 13px;width: 6%;border:1px solid"><?php echo $value->LOKASI; ?></td>
				<td style="text-align:center;font-size: 15px;width: 7%;border:1px solid"><?php echo $status2; ?></td>
				<td style="text-align:center;font-size: 13px;width: 8%;border:1px solid"><?php echo $responkaranina; ?></td>
				<td style="text-align:center;font-size: 13px;width: 7%;border:1px solid"><?php echo $value->waktu_respon_kr; ?></td>
				<td style="text-align:center;font-size: 13px;width: 7%;border:1px solid"><?php echo $value->jadwal; ?></td>
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
// $(document).ready(function() {
//   pageScroll();
//   $("#responseScroll").mouseover(function() {
//     clearTimeout(my_time);
//   }).mouseout(function() {
//     pageScroll();
//   });
// });

var $el = $("#responseScroll");
function anim() {
  var st = $el.scrollTop();
  var sb = $el.prop("scrollHeight")-$el.innerHeight();
  $el.animate({scrollTop: st<sb/2 ? sb : 0}, 25000, anim);
}
function stop(){
  $el.stop();
}
anim();
$el.hover(stop, anim);

// function pageScroll() {  
// 	var objDiv = document.getElementById("responseScroll");
//   objDiv.scrollTop = objDiv.scrollTop + 1;  
//   console.log(objDiv.scrollTop);
//   console.log(objDiv.scrollHeight); 
//   $('p:nth-of-type(1)').html('scrollTop : '+ objDiv.scrollTop);
//   $('p:nth-of-type(2)').html('scrollHeight : ' + objDiv.scrollHeight);
//   if (objDiv.scrollTop == (objDiv.scrollHeight - 100)) {
//     objDiv.scrollTop = 0;
//   }
//   my_time = setTimeout('pageScroll()', 25);
// }
</script>