
<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
  	<span class="ribbon-inner">
		<i class="icon md-boat margin-0" aria-hidden="true"></i> <?php echo $title; ?>
    </span>
  </div>
  <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_post('form_data','divrelokasi1'); return false;">
  	<i class="icon md-badge-check"></i> SAVE
  </button>
  <div class="panel-body container-fluid">
      <div class="col-sm-12">
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('execute/process/'.$action.'/lokasi2/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divrelokasi1'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
				<table class="table">
				  <tr>
					<td></td>
					<td><label class="col-sm-9 control-label">NO CONTAINER</label></td>
					<!--<td><label class="col-sm-6 control-label">ROOM AWAL</label></td>-->
					<!--<td><label class="col-sm-6 control-label">LOKASI AWAL</label></td>-->
					<td><label class="col-sm-6 control-label">ROOM AKHIR</label></td>
					<td><label class="col-sm-8 control-label">LOKASI AKHIR</label></td>
				  </tr>
				  <?php //$no = 0; foreach ($arrdata as $key => $value) {
					//$no++;
				  //} ?>
				  <tr>
					<td><?php //echo $no; ?>
					  <div class="form-group form-material">
						<div class="col-sm-9">
						  <input type="hidden" name="DATA[ID_JOB_SLIP]" id="ID_JOB_SLIP" mandatory="no" class="form-control" value="<?php echo trim($arrdata['ID_JOB_SLIP']); ?>">
						  <div class="hint">ID_JOB_SLIP</div>
						</div>
					  </div><?php //echo $no; ?>
					  <div class="form-group form-material">
						<div class="col-sm-9">
						  <input type="hidden" name="DATA[NO_GATEPASS]" id="NO_GATEPASS" mandatory="no" class="form-control" value="<?php echo trim($arrdata['NO_GATEPASS']); ?>">
						  <div class="hint">NO_GATEPASS</div>
						</div>
					  </div>
					</td>
					<td><?php //echo $value->NO_CONT ?>
						<div class="form-group form-material">
							<div class="col-sm-9">
							  <input type="text" name="DATA[NO_CONT]" id="NO_CONT" class="form-control" placeholder="NO_CONT" value="<?php echo $arrdata['NO_CONT']; ?>" maxlength="10">
							  <div class="hint">CONTAINER</div>
							</div>
						  </div>
					</td>
					<!--
					<td><?php //echo $value->ISO_CODE ?>
						<div class="form-group form-material">
							<div class="col-sm-9">
							  <input type="text" name="DATA[ROOM_AWAL]" id="ROOM_AWAL" readonly="readonly" class="form-control" placeholder="ROOM AWAL" value="<?php echo $arrdata['ROOM_AWAL']; ?>" maxlength="20">
							  <div class="hint">ROOM  AWAL</div>
							</div>
						</div>
					</td>
					-->
					<td><?php //echo $value->UKURAN ?>
						<!--<div class="form-group form-material">
							<div">
							  <label class="radio-inline">
								<input type="radio" value="CIC<?php //echo $arrdata['LOKASI']; ?>" name="DATA[ROOM]">CIC
							  </label>
							  <label class="radio-inline">
								<input type="radio" value="YA,YB<?php //echo $arrdata['LOKASI']; ?>" name="DATA[ROOM]">(YA,YB)
							  </label>
							</div>
						</div>
						-->
						<div class="form-group form-material">
							<div class="col-sm-9">
							  <input type="text" name="DATA[LOKASI_AWAL]" id="LOKASI" class="form-control" readonly="readonly" placeholder="LOKASI AWAL" value="<?php echo $arrdata['LOKASI_AWAL']; ?>" maxlength="20">
							  <div class="hint">LOKASI_AWAL</div>
							</div>
						</div>
					</td>
					<!--
					<td><?php //echo $value->ISO_CODE ?>
						<div class="form-group form-material">
							<div class="col-sm-9">
							  <input type="text" name="DATA[ROOM_AKHIR]" id="LOKASI" class="form-control" readonly="readonly" placeholder="ROOM AKHIR" value="<?php echo $arrdata['ROOM_AKHIR']; ?>" maxlength="20">
							  <div class="hint">ROOM AKHIR</div>
							</div>
						</div>
					</td>
					-->
					<td><?php //echo $value->ISO_CODE ?>
						<div class="form-group form-material">
							<div class="col-sm-9">
							  <input type="text" name="DATA[LOKASI_AKHIR]" id="LOKASI" class="form-control" placeholder="LOKASI_AKHIR" value="<?php echo $arrdata['LOKASI_AKHIR']; ?>" maxlength="20">
							  <div class="hint">LOKASI_AKHIR</div>
							</div>
						</div>
					</td>
				  </tr>
				  <?php //} ?>
				</table>
            </div>
          </div>
          <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('planning/relokasi1/post'); ?>"/>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
$(function(){
	date('date');
});
</script>
