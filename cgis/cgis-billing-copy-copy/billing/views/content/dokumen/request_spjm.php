<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <!--<li style="width:100%;"> <a data-toggle="" style="text-align:right">
          <button type="button" class="btn btn-primary btn-icon" onclick="save_post('form_data'); return false;">Save <i class="icon-check"></i></button>
          </a> </li>
          <div class="tab-pane" id="tab2">
		<div class="col-md-6">
				<div class="form-group">
				  <label class="col-sm-3 control-label-left">NO. KONTAINER</label>
				  <div class="col-sm-8">
					<pre><?php //echo $arrdata[0]->NO_CONT; ?></pre>
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-3 control-label-left">UKURAN KONTAINER <?//= strtoupper($kddok); ?></label>
				  <div class="col-sm-8">
					<pre><?php //echo $arrdata[0]->UKURAN; ?></pre>
				  </div>
				</div>
			</div>
        </div>
      </ul>
      <div class="tab-content">
        
		
      </div>
    </div>-->
    <table class="table">
    	<tr>
    		<td>No</td>
    		<td>Nama Kontainer</td>
    		<td>Ukuran Kontainer</td>
    	</tr>
    	<?php $no = 0; foreach ($arrdata as $key => $value) {
    		$no++;
    	//} ?>
    	<tr>
    		<td><?php echo $no; ?></td>
    		<td><?php echo $value->NO_CONT ?></td>
    		<td><?php echo $value->UKR_CONT ?></td>
    	</tr>
    	<?php } ?>
    </table>
  </div>
</div>
