<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
	  <div align="center">
		<?php 
			foreach ($data as $key => $value) {
				if ($value->KD_STATUS == 'APPROVED') {
					$confirm = "Data ditemukan. Silahkan melakukan cetak gatepass";
					echo $confirm;
				} else {
					$pending = "Data belum tersedia. Silahkan coba beberapa saat lagi";
					echo $pending;
				}
			}
		?> 
	</div>
  </div>
</div>
