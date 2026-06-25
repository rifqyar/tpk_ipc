<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Monitoring Penarikan</title>
	<meta http-equiv="refresh" content="18000" />
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
			/* font-size: 14px; */
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
			background: blue;
			border-radius: 10px;
			padding: 1em;
		}
		
		.header-title{
			color: #fff;
			font-weight: bold;
		}
		
	</style>
</head>
<script>
    function realtime(){
        setTimeout(function(){ 
           window.location.reload();
           // alert("Hello"); 
        }, 60000);
    }
</script>
<body onload="realtime()">
	<div class="">
	<div id='loadingmessage' style='display:none' class='se-pre-con' align="center">
	</div>
	  <div class="panel-body">
		
	  <div class="header" align="center">
		<?php //if($title!=""): ?>
		<h2 class="header-title"><?php echo "MONITORING PENARIKAN"; ?></h2>
		<?php// endif; ?>
	  </div><br>
		<div id="responselongroom" align="center"></div>
		<table class="body" cellspacing="1" width="100%" id="tablehide" style="border:2px" class="tablehide" style='display:none;'>
			<tr style="text-align:center;">
				<th style="text-align:center;">NO</th>
				<th style="text-align:center;">NO SPK</th>
				<th style="text-align:center;">NO KONTAINER</th>
				<th style="text-align:center;">SIZE</th>
				<th style="text-align:center;">TERBIT SPK</th>
				<th style="text-align:center;width: 10px">JENIS DOKUMEN</th>
				<th style="text-align:center;">LAMA PENARIKAN</th>
				<th style="text-align:center;">TID</th>
				<th style="text-align:center;">WAKTU PICKUP</th>
				<th style="text-align:center;">NAMA CUSTOMER</th>
				<th style="text-align:center;">STATUS PENARIKAN</th>
			</tr>
			<?php 
			$cekRows = count($dataPenarikan);
			if ($cekRows > 0) {
				$no = 0;
				foreach($dataPenarikan as $value){ 
					$no++;
					if($no%2==1){
						$class="contentGanjil";
					}else{
						$class="contentGenap";
					}
					
					/*if($value->KETERANGAN2 == 'SEDANG PERIKSA'){
						$status = "<span class='label label-primary'>SEDANG PERIKSA</span>";
					} elseif($value->KETERANGAN3 == 'WAITING LONGROOM'){
						if($value->KETERANGAN != 'STACKING CIC'){
							$status = $value->KETERANGAN;//"<span class='label label-danger'>$value->KETERANGAN</span>";//
						}elseif($value->KETERANGAN == 'STACKING CIC'){
							$status = $value->KETERANGAN;//"<span class='label label-danger'>$value->KETERANGAN</span>";//$value->KETERANGAN;
						}else {
							$status = "<span class='label label-danger'>WAITING LONGROOM</span>";
						}
						
					}else{
						$status = $value->KETERANGAN;//"<span class='label label-danger'>$value->KETERANGAN</span>";//$value->KETERANGAN;
					}*/
			?>
			<tr class="<?php echo $class; ?>">
				<td style="text-align:center;"><?php echo $no; ?></td>
				<td style="text-align:center;"><?php echo $value->NO_SPK; ?></td>
				<td style="text-align:center;"><?php echo $value->NO_CONT; ?></td>
				<td style="text-align:center;"><?php echo $value->SIZE; ?></td>
				<td style="text-align:center;"><?php echo $value->TERBIT_SPK; ?></td>
				<td style="text-align:center;"><?php echo $value->JENIS_DOKUMEN; ?></td>
				<td style="text-align:center;"><?php echo $value->LAMA_PENARIKAN; ?></td>
				<td style="text-align:center;"><?php echo $value->TID; ?></td>
				<td style="text-align:center;"><?php echo $value->W_PICKUP; ?></td>
				<td style="text-align:center;"><?php echo $value->CONSIGNEE; ?></td>
				<td style="text-align:center;font-size:18px"><?php echo $value->STATUS_PENARIKAN; ?></td>
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