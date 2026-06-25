<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Monitoring</title>
	<meta http-equiv="refresh" content="18000" />
		
	<style>
		th{
			background: green;
			color: #fff;
		}
	
		.contentGenap{
			background-color:#f1f1ff;
			line-height: 20px;
		}
		.contentGanjil{
			background-color:#FFFFFF;
			line-height: 20px;
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
		
	</style>
</head>
<body>
	<div class="panel">
	<div id='loadingmessage' style='display:none' class='se-pre-con' align="center">
	</div>
	  <header class="panel-heading">
		<?php //if($title!=""): ?>
		<h2 class="page-title"><?php echo "MONITORING LONGROOM"; ?></h2>
		<?php// endif; ?>
	  </header>
	  <div class="panel-body">
		<div class="panel-body container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php //echo site_url('monitoring/process/'); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divtblkapal'); return false;" popup="1">
						<div class="panel-body container-fluid">
							<div class="row">
								<div class="form-group form-material">
									<label class="col-sm-3 control-label">DOKUMEN</label>
									<div class="col-sm-9">
										<select class="form-control" name="jenis_dokumen" id="jenis_dokumen">
											<option value="">-PILIH-</option>
											<option value="bc">CUSTOM</option>
											<option value="karantin">KARANTINA</option>
											<!--
											<option value="19">SPJM</option>
											<option value="81">NHI</option>
											<option value="82">NOTA DINAS</option>
											<option value="83">SPPMP</option>
											-->
										</select>
									</div>
								</div>
								<div class="form-group form-material">
									<label class="col-sm-3 control-label">STATUS</label>
									<div class="col-sm-9">
										<select class="form-control" name="statuslongroom" id="statuslongroom">
											<option value="">-PILIH-</option>
											<option value="100L">ANTRIAN PERIKSA</option>
											<option value="200L">SEDANG PERIKSA</option>
											<option value="460">SIAP PERIKSA</option>
											<option value="500">SELESAI PERIKSA</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12" align="center">
								<button type="button" class="btn btn-sm btn-primary waves-effect waves-light waves-effect waves-light" onclick="search()">
								<span class="icon md-search"></span>
								 SEARCH
								</button>
								
								<button type="button" class="btn btn-sm btn-danger waves-effect waves-light waves-effect waves-light" onclick="refresh()">
								<span class="icon md-refresh-alt"></span>
								 REFRESH
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div id="responselongroom" align="center"></div>
		<table class="" cellspacing="1" width="100%" id="tablehide" style="border:2px" class="tablehide" style='display:none;'>
			<tr style="text-align:center;">
				<th style="text-align:center;">NO</th>
				<th style="text-align:center;">NO SPK</th>
				<th style="text-align:center;">NO KONTAINER</th>
				<th style="text-align:center;">SIZE</th>
				<th style="text-align:center;">REQUEST LONGROOM</th>
				<th style="text-align:center;">JENIS DOKUMEN</th>
				<th style="text-align:center;">NO DOKUMEN</th>
				<th style="text-align:center;">LOKASI</th>
				<th style="text-align:center;">KETERANGAN</th>
				<th style="text-align:center;">CUSTOMER NAME</th>
				<th style="text-align:center;">STATUS</th>
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
					
					if ($value->KETERANGAN == 'ANTRIAN PERIKSA') {
						$waktu	= $value->WK_ACTIVE;
						$status = "<span class='label label-danger'>ANTRIAN PERIKSA</span>";
					}else if ($value->KETERANGAN == 'SIAP PERIKSA') {
						$waktu	= $value->WK_STATUS;
						$status = "<span class='label label-warning'>SIAP PERIKSA</span>";
					}else if ($value->KETERANGAN == 'SEDANG PERIKSA') {
						$waktu	= $value->START_INSP;
						$status = "<span class='label label-primary'>SEDANG PERIKSA</span>";
					}else if ($value->KETERANGAN == 'SELESAI PERIKSA') {
						$waktu	= $value->FINISH_INSP;
						$status = "<span class='label label-success'>SELESAI PERIKSA</span>";
					}

					// if($value->KETERANGAN2 == 'SEDANG PERIKSA'){
					// 	// $waktu = $value->START_INSP;
					// 	$status = "<span class='label label-primary'>SEDANG PERIKSA</span>";
					// } elseif($value->KETERANGAN3 == 'ANTRIAN PERIKSA'){
					// 	if($value->KETERANGAN != 'SIAP PERIKSA'){
					// 		$status = $value->KETERANGAN;//"<span class='label label-danger'>$value->KETERANGAN</span>";//
					// 	}elseif($value->KETERANGAN == 'SIAP PERIKSA'){
					// 		$status = $value->KETERANGAN;//"<span class='label label-danger'>$value->KETERANGAN</span>";//$value->KETERANGAN;
					// 	}else {
					// 		$status = "<span class='label label-danger'>ANTRIAN PERIKSA</span>";
					// 	}
						
					// }else{
					// 	$status = $value->KETERANGAN;//"<span class='label label-danger'>$value->KETERANGAN</span>";//$value->KETERANGAN;
					// 	// $waktu = $value->WK_ACTIVE;
					// }
			?>
			<tr class="<?php echo $class; ?>">
				<td style="text-align:center;"><?php echo $no; ?></td>
				<td style="text-align:center;"><?php echo $value->NO_SPK; ?></td>
				<td style="text-align:center;"><?php echo $value->NO_CONT; ?></td>
				<td style="text-align:center;"><?php echo $value->UKR_CONT; ?></td>
				<td style="text-align:center;"><?php echo $waktu; ?></td>
				<td style="text-align:center;"><?php echo $value->NAMA; ?></td>
				<td style="text-align:center;"><?php echo $value->NO_DOK; ?></td>
				<td style="text-align:center;"><?php echo $value->LOKASI."0".$value->TIER; ?></td>
				<td style="text-align:center;"><?php echo "BEHANDLE ".$value->JNS_KEGIATAN; ?></td>
				<td style="text-align:center;"><?php echo $value->CONSIGNEE; ?></td>
				<td style="text-align:center;"><?php echo $status; ?></td>
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