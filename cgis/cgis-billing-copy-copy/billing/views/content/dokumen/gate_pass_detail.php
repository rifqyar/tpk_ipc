<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
	<div>
		<h2><?php print_r($arrdata[0]->CONSIGNEE); ?></h2>
        <?php
            $data = $id."~".$arrdata[0]->KD_DOK;
        ?>
	</div>
    <table class="table">
    	<tr>
    		<td>NO</td>
    		<td>NOMOR KONTAINER</td>
    		<td>UKURAN KONTAINER</td>
    		<td>ISO CODE</td>
    		<td>STATUS</td>
            <td>REMARK</td>
			<td>REF NUMBER</td>
            <td>KETERANGAN</td>
			<td></td>
    	</tr>
    	<?php $no = 0; foreach ($arrdata as $key => $value) {
    		$no++;
    	?>
    	<tr>
    		<td><?php echo $no; ?></td>
    		<td><?php echo $value->NO_CONT ?></td>
    		<td><?php echo $value->UKR_CONT ?></td>
			<td><?php echo $value->ISO_CODE ?></td>
			<td><?php echo $value->NAMA ?></td>
			<td align="center"><?php echo $value->REMARK ?></td>
			<td><?php echo $value->REF_NUMBER ?></td>
			<td align="center">
                <?php 
                    if ($value->FLAG_FINISH_PRINT == 'Y') {
                        echo "SUDAH DICETAK";
                    } else {

                    }
                ?>
            </td>
			<td align="center">
				<?php
					if($value->KD_STATUS == 'INQUIRY'){
				?>
					<a href="<?php echo site_url('/RequestGatePass/cetak/');echo "?id=".base64_encode($value->ID)."&nocont=".base64_encode($value->NO_CONT);?>" target="_blank"><button class="btn btn-primary btn-sm">CETAK</button></a>
				<?php				
					} else {
						$false = "<span class='label label-danger' style='text-align:center'>$value->KD_STATUS</span>";
						echo $false;
					}
				?>
			</td>
    	</tr>
    	<?php } ?>
    </table>
    <div align="center">
        <a href="<?php echo site_url('/requestGatePass/gatepass/add_keterangan').'/'.$data; ?>" class="btn btn-primary">
            DOKUMEN SELESAI
        </a>
    </div> 
  </div>
</div>
