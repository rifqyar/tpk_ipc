<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
  	<span class="ribbon-inner">
		<i class="icon md-accounts-list-alt margin-0" aria-hidden="true"></i> <?php echo $title; ?>
    </span>
  </div>
  <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_popup('form_data','divtbldata'); return false;">
  	<i class="icon md-badge-check"></i> SAVE
  </button>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('management/execute/'.$action.'/privilege/'.$id); ?>" method="post" autocomplete="off" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <label class="col-sm-2 control-label">USER</label>
                <div class="col-sm-9">
                  <input type="hidden" class="form-control" name="KD_USER" id="KD_USER" placeholder="KODE" value="<?php echo $arrdata['ID']; ?>" readonly="readonly">
                  <input type="text" name="USER" id="USER" mandatory="yes" class="form-control" placeholder="USER" value="<?php echo $arrdata['USERLOGIN']; ?>" readonly="readonly">
                  <div class="hint">USER</div>
                </div>
                <div class="col-sm-1">
                	<button type="button" class="btn btn-sm btn-primary" onclick="popup_searchtwo('popup/popup_search/app_user/KD_USER|USER/2');" <?php echo ($action!='save')?"disabled":""; ?>>
                  	<i class="icon md-search"></i>
                    </button>
                </div>
              </div>
              <div class="form-group form-material input-group-sm">
                <label class="col-sm-2 control-label">MENU</label>
                <div class="col-sm-10">
                  <?php echo $menus;  ?>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div> 