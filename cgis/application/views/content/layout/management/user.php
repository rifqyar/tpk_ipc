<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
  	<span class="ribbon-inner">
		<i class="icon md-account margin-0" aria-hidden="true"></i> <?php echo $title; ?>
    </span>
  </div>
  <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_ajax('form_data','divtbldata'); return false;">
  	<i class="icon md-badge-check"></i> SAVE
  </button>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo 'management/execute/'.$act.'/user/'.$id; ?>" method="post" autocomplete="off" popup="1" enctype="multipart/form-data">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">ORGANISASI</label>
                <div class="col-sm-8">
                  <input type="hidden" class="form-control" name="DATA[KD_ORGANISASI]" id="KD_ORGANISASI" value="<?php echo $arrdata['KD_ORGANISASI']; ?>" readonly="readonly">
                  <input type="text" name="ORGANISASI" id="ORGANISASI" mandatory="yes" class="form-control" placeholder="ORGANISASI" value="<?php echo $arrdata['NAMA_ORGANISASI']; ?>">
                  <div class="hint">ORGANISASI</div>
                </div>
                <div class="col-sm-1">
                  <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/mst_organisasi/KD_ORGANISASI|ORGANISASI/2');"><span class="icon md-search"></span></button>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">USERLOGIN</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[USERLOGIN]" id="USERLOGIN" mandatory="yes" class="form-control" placeholder="USERLOGIN" value="<?php echo $arrdata['USERLOGIN']; ?>" <?php echo ($act!="save")?'disabled':''; ?>>
                  <div class="hint">USERLOGIN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">PASSWORD</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[PASSWORD]" id="PASSWORD" <?php echo ($act=="save")?'mandatory="yes"':""; ?> class="form-control" placeholder="PASSWORD">
                  <div class="hint">PASSWORD</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NAMA LENGKAP</label>
                <div class="col-sm-9">
                  <input class="form-control" type="text" placeholder="NAMA LENGKAP" name="DATA[NM_LENGKAP]" id="NM_LENGKAP" mandatory="yes" value="<?php echo $arrdata['NM_LENGKAP']; ?>">
                  <div class="hint">NAMA LENGKAP</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">HANDPHONE</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[HANDPHONE]" id="HANDPHONE" mandatory="yes" class="form-control" placeholder="HANDPHONE" value="<?php echo $arrdata['HANDPHONE']; ?>">
                  <div class="hint">HANDPHONE</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">EMAIL</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[EMAIL]" id="EMAIL" mandatory="yes" class="form-control" placeholder="EMAIL" value="<?php echo $arrdata['EMAIL']; ?>">
                  <div class="hint">EMAIL</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">TPS/GUDANG</label>
                <div class="col-sm-4">
                  <input type="text" name="DATA[KD_TPS]" id="KD_TPS" mandatory="yes" class="form-control" placeholder="KODE TPS" value="<?php echo $arrdata['KD_TPS']; ?>" readonly="readonly">
                  <div class="hint">KODE TPS</div>
                </div>
                <div class="col-sm-4">
                  <input type="text" name="DATA[KD_GUDANG]" id="KD_GUDANG" mandatory="yes" class="form-control" placeholder="KODE GUDANG" value="<?php echo $arrdata['KD_GUDANG']; ?>" readonly="readonly">
                  <div class="hint">KODE GUDANG</div>
                </div>
                <div class="col-sm-1">
                  <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/mst_gudang/KD_TPS|KD_GUDANG/2');"><span class="icon md-search"></span>
                  </button>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">GROUP</label>
                <div class="col-sm-9">
                  <?php echo form_dropdown('DATA[KD_GROUP]', $arr_group, $arrdata['KD_GROUP'], 'id="KD_GROUP" mandatory="yes" class="form-control"'); ?>
                  <div class="hint">GROUP</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">STATUS</label>
                <div class="col-sm-9">
                  <?php echo form_dropdown('DATA[KD_STATUS]', array('ACTIVE' => 'ACTIVE', 'INACTIVE' => 'INACTIVE'), $arrdata['KD_STATUS'], 'id="KD_STATUS" mandatory="yes" class="form-control"'); ?>
                  <div class="hint">STATUS</div>
                </div>
              </div>
              <?php if($arrdata['PATH']!=""): ?>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">FOTO</label>
                <div class="col-sm-7">
                  <div class="input-group input-group-file">
                      <input type="text" class="form-control" readonly="readonly" placeholder="BROWSE">
                      <span class="input-group-btn">
                      	<span class="btn btn-primary btn-file"><i class="icon md-upload" aria-hidden="true"></i>
                      		<input type="file" name="FOTO" id="FOTO">
                      	</span>
                      </span>
                  </div>
                </div>
                <div class="col-sm-2">
                	<a href="<?php echo base_url($arrdata['PATH']); ?>" target="_blank" class="btn btn-primary btn-sm btn-file">
                    	<i class="icon md-account-box" aria-hidden="true"></i> FOTO
                    </a>
                </div>
              </div>
              <?php else : ?>
              	<div class="form-group form-material">
                <label class="col-sm-3 control-label">FOTO</label>
                <div class="col-sm-9">
                  <div class="input-group input-group-file">
                      <input type="text" class="form-control" readonly="readonly" placeholder="BROWSE">
                      <span class="input-group-btn">
                      	<span class="btn btn-primary btn-file"><i class="icon md-upload" aria-hidden="true"></i>
                      		<input type="file" name="FOTO" id="FOTO">
                      	</span>
                      </span>
                 </div>
                </div>
              </div>
              <?php endif; ?>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">KETERANGAN</label>
                <div class="col-sm-9">
                	<textarea name="DATA[KETERANGAN]" id="KETERANGAN" mandatory="yes" class="form-control" placeholder="KETERANGAN"><?php echo $arrdata['KETERANGAN']; ?></textarea>
                  <div class="hint">KETERANGAN</div>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" name="PATH" id="PATH" readonly="readonly" value="<?php echo $arrdata['PATH']; ?>"/>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
$(function(){
	autocomplete('ORGANISASI','/popup/autocomplete/mst_organisasi',function(event, ui){
		$('#KD_ORGANISASI').val(ui.item.KODE);
	});
});
</script>