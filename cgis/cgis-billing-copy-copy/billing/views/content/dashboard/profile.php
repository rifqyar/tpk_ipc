<?php //print_r($action);die(); ?>
<div class="panel">
	<div class="ribbon ribbon-clip ribbon-primary">
		<span class="ribbon-inner">
		<i class="icon md-lock-open" aria-hidden="true"></i> <?php echo "UBAH PASSWORD"; ?>
		</span>
	</div>
	<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
	<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
	<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
	
    <div align="center">
    	<div class="avatar avatar-lg">
	        <img src="<?php echo ($this->session->userdata('PATH')!="")?base_url().$this->session->userdata('PATH'):base_url().'assets/images/user.png'; ?>" alt="...">
	        <br>
	    </div>
	    <div>
	    	<p class="locked-user"><?php echo $this->session->userdata('NM_LENGKAP'); ?></p>	
	    </div>
    </div>
	<div class="panel-body container-fluid">
		<div class="row">
			<div class="col-sm-12">
			<p class="locked-user"><?php //echo $this->session->userdata('USERLOGIN'); ?></p>
      <form name="form_data" id="form_data" role="form" action="<?php echo site_url('dashboard/execute/update/password'); ?>" method="post" autocomplete="off" onsubmit="signin('form_data'); return false;">
      	<div class="form-group form-material floating">
          <input type="password" class="form-control" name="DATA[PASS_OLD]" id="PASS_OLD" mandatory="yes" placeholder="PASSWORD LAMA" style="text-transform:none">
        </div>
        <div class="form-group form-material floating">
          <input type="password" class="form-control" name="DATA[PASS_NEW]" id="PASS_NEW" mandatory="yes" placeholder="PASSWORD BARU" style="text-transform:none">
        </div>
        <div class="form-group form-material floating">
          <input type="password" class="form-control" name="DATA[PASS_CONFIRM]" id="PASS_CONFIRM" mandatory="yes" placeholder="KONFIRMASI PASSWORD BARU" style="text-transform:none">
        </div>
        <button type="submit" class="btn btn-primary btn-block">SAVE</button>
      </form>
			</div>
		</div>
	</div>
</div>
