<?php //echo $dash[0]->SIZE ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Dashboard</title>
	<meta http-equiv="refresh" content="18000" />
	<!-- <script type="text/javascript" src="'.base_url().'assets/js/jquery.js"></script>
	<script type="text/javascript" src="'.base_url().'assets/js/jquery.dataTables.js"></script>
	<link rel="stylesheet" type="text/css" href="'.base_url().'assets/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="'.base_url().'assets/css/dataTables.bootstrap.css"> -->
		
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
	
	<script>
		$(document).ready(function(){
			$('input[name="all"]').bind('click', function(){
				var status = $(this).is(':checked');
				$('input[type="checkbox"]').attr('checked', status);
			});
		});
	</script>
	<script type="text/javascript">
		function checkAll() {
			var checked = $("#checkAll").is(':checked');
			$(".check_row").prop("checked", checked);
		}
	</script>
</head>
<body>
	<div class="panel">	
	<div id='loadingmessage' style='display:none' class='se-pre-con' align="center">
	</div>
	  <header class="panel-heading">
		<?php if($title!=""): ?>
		<h2 class="page-title"><?php echo $title; ?></h2>
		<?php endif; ?>
	  </header>
	  <div class="panel-body">
	  	<?php
			date_default_timezone_set("Asia/Jakarta");

			function datediff($tgl1, $tgl2){
				$tgl1 = strtotime($tgl1);
				$tgl2 = strtotime($tgl2);
				$diff_secs = abs($tgl1 - $tgl2);
				$base_year = min(date("Y", $tgl1), date("Y", $tgl2));
				$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
				return array( "years" => date("Y", $diff) - $base_year, "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1, "months" => date("n", $diff) - 1, "days_total" => floor($diff_secs / (3600 * 24)), "days" => date("j", $diff) - 1, "hours_total" => floor($diff_secs / 3600), "hours" => date("G", $diff), "minutes_total" => floor($diff_secs / 60), "minutes" => (int) date("i", $diff), "seconds_total" => $diff_secs, "seconds" => (int) date("s", $diff) );
			}
			/*$tgl1 = '2017-05-29 14:39:03';
			$tgl2 = date("Y-m-d H:i:s");
			$a = datediff($tgl1, $tgl2);
			echo 'tanggal 1 = '.$tgl1; echo '<br>';
			echo 'tanggal 2 = '.$tgl2; echo '<br>';
			echo 'Selisih = '.$a['years'].' tahun '.$a['months'].' bulan '.$a['days'].' hari '.$a['hours'].' jam '.$a['minutes'].' menit '.$a['seconds'].' detik';
			$result = $a['hours'].' jam '.$a['minutes'].' menit '.$a['seconds'].' detik';*/
		?>
		<br><br>
		<!-- <div>
			<button class="btn btn-primary btn-sm">Refresh</button>
		</div> -->
		<div>
			<!-- <input type="checkbox" value="ALL">&nbsp;ALL&nbsp;&nbsp;&nbsp;
			<input type="checkbox" value="PU">&nbsp;PU&nbsp;&nbsp;&nbsp;
			<input type="checkbox" value="GIT">&nbsp;GIT&nbsp;&nbsp;&nbsp;
			<input type="checkbox" value="GOT">&nbsp;GOT&nbsp;&nbsp;&nbsp;
			<input type="checkbox" value="MB1">&nbsp;MB1&nbsp;&nbsp;&nbsp;
			<input type="checkbox" value="MB2">&nbsp;MB2&nbsp;&nbsp;&nbsp;
			<input type="checkbox" value="MEB1">&nbsp;MEB1&nbsp;&nbsp;&nbsp;
			<input type="checkbox" value="MEB2">&nbsp;MEB2&nbsp;&nbsp;&nbsp;
			<input type="checkbox" value="INS">&nbsp;INS&nbsp;&nbsp;&nbsp;
			<input type="checkbox" value="TI">&nbsp;TI&nbsp;&nbsp;&nbsp;
			<input type="checkbox" value="TO">&nbsp;TO&nbsp;&nbsp;&nbsp;
			<button type="submit" class="btn btn-primary btn-sm">Search</button> -->
			<form action="<?php //echo site_url('/dashboard/dashMonitoring'); ?>" method="post">
				<div id="wrapper" align="center">
					<span class="checkbox-custom checkbox-primary">
						
					</span>
					<input type="checkbox" name="all" id="all" /> <label for='all'>All</label>
					<input type="checkbox" name="selected" id="000" class="job" <?php //echo if(isset($this->input->post('selected')) echo "checked ='checked'"); ?>  value="000" /> <label for="box_1">SPK</label>
					<input type="checkbox" name="selected" id="200" class="job" value="200" /> <label for="box_1">PU</label>
					<input type="checkbox" name="selected" id="GIT" class="job" value="GIT" /> <label for="box_2">GIT</label>
					<input type="checkbox" name="selected" id="box_3" class="job" value="GOT" /> <label for="box_3">GOT</label>
					<input type="checkbox" name="selected" id="box_4" class="job" value="510" /> <label for="box_4">MB1</label>
					<input type="checkbox" name="selected" id="box_5" class="job" value="530" /> <label for="box_1">MB2</label>
					<input type="checkbox" name="selected" id="box_6" class="job" value="520" /> <label for="box_2">MEB1</label>
					<input type="checkbox" name="selected" id="box_7" class="job" value="540" /> <label for="box_3">MEB2</label>
					<input type="checkbox" name="selected" id="box_8" class="job" value="460" /> <label for="box_4">INS</label>
					<input type="checkbox" name="selected" id="box_9" class="job" value="800" /> <label for="box_4">TI</label>
					<input type="checkbox" name="selected" id="box_10" class="job" value="850" /> <label for="box_2">TO</label>
					<!-- <input type="button" name="cek" id="cek" onclick="getCheckedCheckboxesFor('selected');" value="Search">
					<input type="button" name="cek" onclick="getCheckedCheckboxesFor('selected');" id="cek" value="Search">  
					<button type="button" onClick="refreshPage()">Refresh</button>-->
					<!-- <button type="submit" class="btn btn-primary btn-sm">Search</button> -->
				</div>
				<br>
				<div class="form-group">
					<div class="col-sm-12" align="center">
						<button type="button" class="btn btn-sm btn-primary waves-effect waves-light waves-effect waves-light" onclick="getCheckedCheckboxesFor('selected');">
						<span class="icon md-search"></span>
						 SEARCH
						</button>
						
						<button type="button" class="btn btn-sm btn-danger waves-effect waves-light waves-effect waves-light" onclick="refreshPage()">
						<span class="icon md-refresh-alt"></span>
						 REFRESH
						</button>
					</div>
				</div>
			</form>
		</div>
		<br><br>
		<div id="responsecontainer" align="center"></div>
		<table class="" cellspacing="1" width="100%" id="dashhide" style="border:2px;" style='display:none;'>
			<tr style="text-align:center;">
				<th style="text-align:center;">NO</th>
				<th style="text-align:center;">KONTAINER</th>
				<th style="text-align:center;">SPK</th>
				<th style="text-align:center;">CLS</th>
				<th style="text-align:center;">VESSEL</th>
				<th style="text-align:center;">VOY</th>
				<th style="text-align:center;">STAT</th>
				<th style="text-align:center;">SIZE</th>
				<th style="text-align:center;">DOKUMEN</th>
				<th style="text-align:center;">JOB</th>
				<th style="text-align:center;">TID</th>
				<th style="text-align:center;">LOKASI AWAL</th>
				<th style="text-align:center;">LOKASI AKHIR</th>
				<th style="text-align:center;">WAKTU INSP</th>
				<th style="text-align:center;">DURASI</th>
				<th style="text-align:center;">CUSTOMER</th>
				<th style="text-align:center;">REMARK</th>
			</tr>
			<?php 
			$cekRows = count($dash);
			if ($cekRows > 0) {
				$no = 0;
				foreach($dash as $value){ 
					$no++;
					if($no%2==1){
						$class="contentGanjil";
					}else{
						$class="contentGenap";
					}
			?>
			<tr class="<?php echo $class; ?>">
				<td style="font-size: 10px;text-align:center;"><?php echo $no; ?></td>
				<td style="font-size: 10px;text-align:center;"><?php echo $value->NO_KONTAINER; ?></td>
				<td style="font-size: 10px;text-align:center;"><?php echo $value->NO_SPK; ?></td>
				<td style="font-size: 10px;text-align:center;"><?php echo "I"; ?></td>
				<td style="font-size: 10px;text-align:center;"><?php echo $value->VESSEL_NAME; ?></td>
				<td style="font-size: 10px;text-align:center;"><?php echo $value->VOYAGE; ?></td>
				<td style="font-size: 10px;text-align:center;"><?php echo $value->JNS_CONT; ?></td>
				<td style="font-size: 10px;text-align:center;"><?php echo $value->SIZE; ?></td>
				<td style="font-size: 10px;text-align:center;"><?php echo $value->DOKUMEN; ?></td>
				<td style="font-size: 10px;text-align:center;"><?php echo $value->JOB; ?></td>
				<td style="font-size: 10px;text-align:center;"><?php echo $value->TID; ?></td>
				<td style="font-size: 10px;text-align:center;"><?php echo $value->LOKASI_AWAL; ?></td>
				<td style="font-size: 10px;text-align:center;"><?php echo $value->LOKASI_AKHIR; ?></td>
				<td style="font-size: 10px;text-align:center;"><?php echo date('d-m-Y H:i',strtotime($value->START_INSP)); ?></td>
				<td style="font-size: 10px;text-align:center;">
					<?php 
						if ($value->START_INSP != '') {
							$tgl1 = $value->START_INSP;//'2017-05-29 14:39:03';
							$tgl2 = date("Y-m-d H:i:s");
							$a = datediff($tgl1, $tgl2);
							
							if(strlen($a['days']) == 1){
								$day = "0".$a['days'];
							}else{
								$day = $a['days'];
							}
							
							if(strlen($a['hours']) == 1){
								$hours = "0".$a['hours'];
							}else{
								$hours = $a['hours'];
							}
							
							if(strlen($a['minutes']) == 1){
								$minutes = "0".$a['minutes'];
							}else{
								$minutes = $a['minutes'];
							}
								

							//$result = $a['days'].':'.$a['hours'].':'.$a['minutes'].'';//.$a['seconds'].' detik';
							$result = $day.':'.$hours.':'.$minutes;
							echo $result;
						}
					?>
				</td>
				<td style="font-size: 10px;text-align:center;"><?php echo $value->CONSIGNEE; ?></td>
				<td style="font-size: 10px;text-align:center;"><?php echo $value->REMARK; ?></td>
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
	function refreshPage(){
		window.location.reload();
	}
</script>
<script>
	function getCheckedCheckboxesFor(checkboxName) {
	    var checkboxes = document.querySelectorAll('input[name="' + checkboxName + '"]:checked'), values = [];
	    Array.prototype.forEach.call(checkboxes, function(el) {
	        values.push(el.value);
	    });
		$('#loadingmessage').show(); 
	    $.ajax({
            url: '<?php echo site_url('/dashboard/filter'); ?>',
            type: "POST",
            data: {vals: values},
            cache: true,
            success: function(response){
				$("#dashhide").hide();           
               $("#responsecontainer").html(response);
			   $('#loadingmessage').hide(); 
            }
          });
	}
</script>