<div class="page animsition vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">
    <div class="page-content vertical-align-middle" style="background:#000;opacity:0.7">
      <div class="avatar avatar-lg">
        <img src="<?php echo ($this->session->userdata('PATH')!="")?base_url().$this->session->userdata('PATH'):base_url().'assets/images/user.png'; ?>" alt="...">
      </div>
      <p class="locked-user"><?php echo $this->session->userdata('NM_LENGKAP'); ?></p>
      <form name="form_data" id="form_data" role="form" action="<?php echo site_url('home/execute/update/password'); ?>" method="post" autocomplete="off" onsubmit="signin('form_data'); return false;">
      	<div class="form-group form-material floating">
          <input type="password" class="form-control" name="DATA[PASS_OLD]" id="PASS_OLD" mandatory="yes" placeholder="PASSWORD LAMA" style="text-transform:none">
        </div>
        <div class="form-group form-material floating">
          <input type="password" class="form-control" name="DATA[PASS_NEW]" id="PASS_NEW" mandatory="yes" placeholder="PASSWORD BARU" style="text-transform:none">
        </div>
        <div class="form-group form-material floating">
          <input type="password" class="form-control" name="DATA[PASS_CONFIRM]" id="PASS_CONFIRM" mandatory="yes" placeholder="KONFIRMASI PASSWORD BARU" style="text-transform:none">
        </div>
        <button type="submit" class="btn btn-primary btn-block">SIGN IN</button>
      </form>
      <footer class="page-copyright page-copyright-inverse">
      	<p>&copy; 2016. All RIGHT RESERVED.</p>
    </footer>
    </div>
  </div>