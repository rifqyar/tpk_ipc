<?php //print_r($arrdata);//die(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Dashboard</title>
	<meta http-equiv="refresh" content="18000" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css?v2.1.0">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-extend.min.css?v2.1.0">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/site.min.css?v2.1.0">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/jquery-ui/jquery-ui.min.css?v2.1.0">

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/filament-tablesaw/tablesaw.min.css?v2.1.0">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/uikit/modals.min.css?v2.1.0">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css?v2.1.0">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/jquery-wizard/jquery-wizard.min.css?v2.1.0">

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/animsition/animsition.min.css?v2.1.0">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/asscrollable/asScrollable.min.css?v2.1.0">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/switchery/switchery.min.css?v2.1.0">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/intro-js/introjs.min.css?v2.1.0">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/slidepanel/slidePanel.min.css?v2.1.0">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/waves/waves.min.css?v2.1.0">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/sweetalert/sweetalert.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/themes/twitter.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/newtable.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/toastr/toastr.min.css">

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/material-design/material-design.min.css?v2.1.0">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/brand-icons/brand-icons.min.css?v2.1.0">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/font.css?v2.1.0">
	
	<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/alerts.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/modernizr/modernizr.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/breakpoints/breakpoints.min.js"></script>
	<script>Breakpoints();</script>

	<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/jquery-ui/jquery-ui.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/bootstrap.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/animsition/animsition.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/asscroll/jquery-asScroll.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/mousewheel/jquery.mousewheel.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/asscrollable/jquery.asScrollable.all.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/ashoverscroll/jquery-asHoverScroll.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/waves/waves.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/switchery/switchery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/intro-js/intro.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/screenfull/screenfull.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/slidepanel/jquery-slidePanel.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/formatter-js/jquery.formatter.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/jquery-wizard/jquery-wizard.min.js"></script>

	<script src="<?php echo base_url(); ?>assets/js/core.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/site.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/sections/menu.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/sections/menubar.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/sections/gridmenu.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/sections/sidebar.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/configs/config-colors.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/components/asscrollable.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/components/animsition.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/components/slidepanel.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/components/switchery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/newtable.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/main.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/sweetalert/sweetalert.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/filament-tablesaw/tablesaw.js"></script>
	<script src="<?php echo base_url(); ?>assets/vendor/toastr/toastr.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/components/input-group-file.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/components/formatter-js.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/components/jquery-wizard.min.js"></script>
	<style>
		.th{
			background: green;
			color: #fff;
		}
	</style>
</head>
<body>
	<div class="panel">
	  <header class="panel-heading">
		<?php //if($title!=""): ?>
		<h2 class="page-title"><?php echo "MONITORING PENARIKAN"; ?></h2>
		<?php //endif; ?>
	  </header>
	  <div class="panel-body">
		<div></div><br>
		<form method="post" action="<?php echo site_url('/monitoring/filter'); ?>">
			<div class="form-group form-material">
				<label class="col-sm-3 control-label">STATUS PENARIKAN</label>
				<div class="col-sm-9">
				  <select class="form-control focus" id="status_penarikan" name="status_penarikan">
					<option value=""></option>
					<option value="200">ON TERMINAL</option>
					<option value="450">ON COMMON AREA</option>
				  </select> 
				</div>
			</div>
			<div class="form-group form-material">
				<label class="col-sm-3 control-label">TANGGAL</label>
				<div class="col-sm-9">
				  <input type="text" name="tgl" id="tgl" mandatory="no" class="form-control date" placeholder="TANGGAL" value="" maxlength="10">
				  <div class="hint">TANGGAL</div>
				</div>
			</div>
			<div>
				<button type="submit" class="btn btn-primary btn-block">SEARCH</button>
			</div>
		</form>
		<br><br>
		<table class="" cellspacing="0" width="100%" id="myTable">
			<tr>
				<th>NO.</th>
				<th>NO. SPK</th>
				<th>N0. KONTAINER</th>
				<th>SIZE</th>
				<th>TERBIT SPK</th>
				<th>JENIS DOKUMEN</th>
				<th>LAMA PENARIKAN</th>
				<th>TID</th>
				<th>WAKTU PICKUP</th>
				<th>NAMA CUSTOMER</th>
				<th>STATUS PENARIKAN</th>
			</tr>
			<?php 
			$cekRows = count($arrdata);
			if ($cekRows > 0) {
				$no = 0;
				foreach($arrdata as $value){ 
					$no++;
			?>
			<tr>
				<td><?php echo $no; ?></td>
				<td><?php echo $value->NO_SPK; ?></td>
				<td><?php echo $value->NO_CONTAINER; ?></td>
				<td><?php echo $value->SIZE; ?></td>
				<td><?php echo $value->TERBIT_SPK; ?></td>
				<td><?php echo $value->JENIS_DOKUMEN; ?></td>
				<td><?php echo $value->LAMA_PENARIKAN; ?></td>
				<td><?php echo $value->TID; ?></td>
				<td><?php echo $value->WAKTU_PICK_UP; ?></td>
				<td><?php echo $value->CUSTOMER_NAME; ?></td>
				<td><?php echo $value->STATUS_PENARIKAN; ?></td>
			</tr>
			<?php 
				} //else for
			} else { //else if
				echo "<td colspan='16' align='center'><span><h3 class='text-danger'><b>DATA TIDAK DITEMUKAN</b></h3></span></td>";
			}
			?>
		</table>
	  </div>
	</div>
</body>
</html>
<script>
	date('date');
	$(document).ready(function(){
		$('input[name="all"],input[name="title"]').bind('click', function(){
			var status = $(this).is(':checked');
			$('input[type="checkbox"]').attr('checked', status);
		});
	});
	
	/*$(document).ready(function(){
		$('#myTable').dataTable();
	});*/
	
</script>