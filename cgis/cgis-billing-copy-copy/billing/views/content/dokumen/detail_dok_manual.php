<?php //print_r($arrdata);die(); ?>
<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
    <table class="table">
      <tr>
        <td>No</td>
        <td>Nomor Kontainer</td>
		<td>No Dokumen</td>	
        <td>Ukuran Kontainer</td>
      </tr>
      <?php $no = 0; foreach ($arrdata as $key => $value) {
        $no++;
      //} ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $value->NO_CONT ?></td>
    		<td><?php echo $value->NO_DOK_INOUT ?></td>
        <td><?php echo $value->KD_CONT_UKURAN ?></td>
      </tr>
      <?php } ?>
    </table>
  </div>
</div>
