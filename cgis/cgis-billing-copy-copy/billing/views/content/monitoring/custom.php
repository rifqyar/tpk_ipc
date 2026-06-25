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
			background: #FFEB3B;
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
	  <div class="panel-body">
		
	  <div class="header" align="center">
		<?php //if($title!=""): ?>
		<h2 class="header-title"><?php echo "MONITORING CUSTOMS"; ?></h2>
		<?php// endif; ?>
	  </div><br>
		<div id="responselongroom" align="center"></div><div id="responseScroll">
		<table class="body" cellspacing="1" width="100%" id="table_scroll" style="border:2px" class="table_scroll" style='display:none;'>
			<tr style="text-align:center;">
				<th style="text-align:center;">NO</th>
				<th style="text-align:center;">NO SPK</th>
				<th style="text-align:center;">KONTAINER</th>
				<th style="text-align:center;">TANGGAL</th>
				<th style="text-align:center;">JENIS DOKUMEN</th>
				<th style="text-align:center;">NO DOKUMEN</th>
				<th style="text-align:center;">LOKASI</th>
				<th style="text-align:center;">KETERANGAN</th>
				<th style="text-align:center;">CUSTOMER NAME</th>
				<th style="text-align:center;">STATUS</th>
				<th style="text-align:center;">RESPON</th>
				<th style="text-align:center;">TGL RESPON</th>
			</tr>
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
					
					if ($value->WSTATUS == 'ANTRIAN PERIKSA') {
						$waktu	= $value->WK_ACTIVE;
						$status = "<span class='label label-danger'>ANTRIAN PERIKSA</span>";
					}else if ($value->WSTATUS == 'SIAP PERIKSA') {
						$waktu	= $value->WK_STATUS;
						$status = "<span class='label label-warning'>SIAP PERIKSA</span>";
					}else if ($value->WSTATUS == 'SEDANG PERIKSA') {
						$waktu	= $value->START_INSP;
						$status = "<span class='label label-primary'>SEDANG PERIKSA</span>";
					}else if ($value->WSTATUS == 'SELESAI PERIKSA') {
						$waktu	= $value->FINISH_INSP;
						$status = "<span class='label label-success'>SELESAI PERIKSA</span>";
					}
					if ($value->RESPON == '' || $value->RESPON == 'NULL' && $value->WK_RESPON == '' || $value->WK_RESPON == 'NULL'){
						$responbc = "<span style='color:red;font-weight:bold'>NO RESPON</span>";
						$wk_responbc = "--";
					}else if($value->RESPON == 'PKB LR'){
						$responbc = "<span style='color:green;font-weight:bold'>PKB LONGROOM</span>";
						$wk_responbc = $value->WK_RESPON;
					}else if($value->RESPON == 'PKB YARD'){
						$responbc = "<span style='color:green;font-weight:bold'>PKB YARD</span>";
						$wk_responbc = $value->WK_RESPON;
					}else if($value->RESPON == 'PKB YARD N'){
						$responbc = "<span style='color:green;font-weight:bold'>PKB YARD N</span>";
						$wk_responbc = $value->WK_RESPON;
					}else{
						$responbc = "<span style='color:green;font-weight:bold'>PKB PRIORITAS</span>";
						$wk_responbc = $value->WK_RESPON;
					}
			?>
			<tr class="<?php echo $class; ?>">
				<td style="text-align:center;font-size: 13px;"><?php echo $no; ?></td>
				<td style="text-align:center;font-size: 13px;"><?php echo $value->NO_SPK; ?></td>
				<td style="text-align:center;font-size:18px;"><?php echo $value->KONTAINER; ?></td>
				<td style="text-align:center;font-size: 13px;"><?php echo $value->WK_ACTIVE; ?></td>
				<td style="text-align:center;font-size: 13px;"><?php echo $value->NAMA; ?></td>
				<td style="text-align:center;font-size: 13px;"><?php echo $value->NO_DOK; ?></td>
				<td style="text-align:center;font-size: 13px;"><?php echo $value->LOKASI; ?></td>
				<td style="text-align:center;font-size: 13px;"><?php echo "BEHANDLE ".$value->JNS_KEGIATAN; ?></td>
				<td style="text-align:center;font-size: 13px;"><?php echo $value->NAMA_CUSTOMER; ?></td>
				<td style="text-align:center;font-size: 15px;"><?php echo $status; ?></td>
				<td style="text-align:center;font-size: 13px;"><?php echo $responbc; ?></td>
				<td style="text-align:center;font-size: 13px;"><?php echo $wk_responbc; ?></td>
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

function pageScroll() {  
	var objDiv = document.getElementById("responseScroll");
  objDiv.scrollTop = objDiv.scrollTop + 1;  
  $('p:nth-of-type(1)').html('scrollTop : '+ objDiv.scrollTop);
  $('p:nth-of-type(2)').html('scrollHeight : ' + objDiv.scrollHeight);
  if (objDiv.scrollTop == (objDiv.scrollHeight - 100)) {
    objDiv.scrollTop = 0;
  }
  my_time = setTimeout('pageScroll()', 25);
}
</script>