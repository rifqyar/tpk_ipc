<?php 
	//print_r($arrdata); die();
?>
<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
    <span class="ribbon-inner">
    <i class="icon margin-0" aria-hidden="true"></i> <?php echo $title; ?>
    </span>
  </div>
  <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_post('form_data','divdaftarpemeriksa'); return false;">
    <i class="icon md-badge-check"></i> SAVE
  </button>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('respon/daftar_pemeriksa_simpan/'.$action.'/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divdaftarpemeriksa'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">GROUP</label>
                <div class="col-sm-9">
                <select name="DATA[USE_AKSES]" id="USE_AKSES" class="form-control">
                  <?php if($group == 'BC'){
                    ?>
                      <option value="BC" <?php echo $detail["USE_AKSES"]=="BC"?"selected" : ""?> >BC</option>
                    <?php
                  }else if($group == 'ADM_KAR'){
                    ?>
                      <option value="KARANTINA"  <?php echo $detail["USE_AKSES"]=="KARANTINA"?"selected" : ""?> >KARANTINA</option>
                    <?php
                  }else{
                    ?>
                      <option value="BC" <?php echo $detail["USE_AKSES"]=="BC"?"selected" : ""?> >BC</option>
                      <option value="KARANTINA"  <?php echo $detail["USE_AKSES"]=="KARANTINA"?"selected" : ""?> >KARANTINA</option>
                    <?php
                  }?>
              
            </select>
                  <div class="hint">GROUP</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NIPP</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NIPP]" id="NIPP" mandatory="yes" class="form-control" placeholder="NOMOR NIPP" value="<?php echo $detail['NIPP']; ?>">
                  <div class="hint">NIPP</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NAMA LENGKAP</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NAMA]" id="NAMA" mandatory="yes" class="form-control" placeholder="NAMA LENGKAP" value="<?php echo $detail['NAMA']; ?>" >
                  <div class="hint">NAMA LENGKAP</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NOMOR TELEPHONE</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_TELP]" id="NO_TELP" mandatory="yes" class="form-control" placeholder="NOMOR TELEPHONE" value="<?php echo $detail['NO_TELP']; ?>">
                  <div class="hint">NOMOR TELEPHONE</div>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('respon/daftar_pemeriksa/post'); ?>"/>
        </form>
      </div>
    </div>
  </div>
</div>

