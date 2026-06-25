<?php //print_r($getCont);die(); ?>
<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
  	<span class="ribbon-inner">
		<i class="icon md-boat margin-0" aria-hidden="true"></i> <?php echo "ADD PAID THROUGHT"; ?>
    </span>
  </div>
  <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_post('form_data','tblkapallist'); return false;">
  	<i class="icon md-badge-check"></i> SAVE
  </button>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('/requestGatePass/gatepass/paidthrought/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divtblkapal'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[ID]" id="ID" mandatory="no" class="form-control" value="<?php echo $id; ?>">
                  <div class="hint">ID</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">RENCANA KELUAR</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[paidthrought]" id="CLS_TIME" mandatory="yes" class="form-control datetime" placeholder="RENCANA KELUAR" value="<?php //echo trim($arrdata['CLS_TIME']); ?>">
                  <div class="hint">RENCANA KELUAR</div>
                </div>
              </div>
              <div>
              	<label class="col-sm-3 control-label">LIST KONTAINER</label>
              	<table class="table">
              		<tr>
              			<td>
              				<!-- <input type="checkbox" name="ceklis">&nbsp;&nbsp;&nbsp;All -->
              			</td>
              			<td>No. Kontainer</td>
              			<td>Ukuran</td>
              		</tr>
              		<?php 
					  	foreach ($getCont as $value) {
					?>
              		<tr>
              			<td><input type="checkbox" name="ceklis[]" value="<?php echo $value['NO_CONT']; ?>"></td>
              			<td><?php echo $value['NO_CONT']; ?></td>
              			<td><?php echo $value['UKR_CONT']; ?></td>
              		</tr>
					<?php
					  	} 
					?>
              	</table>
				
              </div>
            </div>
          </div>
          <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('requestGatePass/gatepass/post'); ?>"/>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
	datetime('datetime');
</script>
<script>
	$( document ).ready( function(){
	    var checkboxes = $( ':checkbox' );
	    
	    checkboxes.prop( 'checked', true );
	   
	    if ( checkboxes.filter( ':checked' ).length == checkboxes.length )
	        console.log( 'All Checked' );
	    else
	        alert( 'Not All Checked' );
	});
</script>
