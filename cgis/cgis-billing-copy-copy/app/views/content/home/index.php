<div class="page animsition vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">
  <div class="page-content vertical-align-middle" style="background:#000;opacity:0.7">
    <div class="brand">
      <img class="brand-img" src="" alt="">
      <h2 class="brand-text">B O S</h2>
    </div>
    <p>LOGIN BILLING APLIKASI</p>
    <form name="form_login" id="form_login" method="post" autocomplete="off" onSubmit="signin('form_login'); return false;" action="<?php echo site_url(); ?>/home/signin">
      <div class="form-group form-material floating">
        <input type="text" class="form-control focus empty" mandatory="yes" id="username" name="username" value="" required="required">
        <label class="floating-label" for="username">USERNAME</label>
      </div>
      <div class="form-group form-material floating">
        <input type="password" class="form-control focus empty" mandatory="yes" id="password" name="password" value="" required="required">
        <label class="floating-label" for="password">PASSWORD</label>
		<!--<div id="slider">
          <div id="slider_bg"></div>
          <span id="label">
            <img src="<?php //echo base_url() ?>assets/images/cont2.png" alt="" width="80">
			>>>>>
          </span>
		  <input type="hidden" id="unlock" name="unlock" value="0">
          <span id="labelTip" style="color:#2e4688">Slide To Unlock</span>
		</div>-->

      </div>
	  <div class="form-group form-material floating">
		  <h3 style="color:#FFF;">Captcha</h3>
			<span style="color:#3fb5b5" class="captche"><?php echo $chaptca ?></span>
			<!--<p>*samakan Captcha dengan di atas</p>-->
			<div class="field">
				<input type="text" class="form-control focus empty" name="txt_chaptca_real" value="<?php //echo $chaptca ?>">
				<input type="hidden" class="form-control focus empty" name="txt_chaptca" value="<?php echo $chaptca ?>">
			</div>
        </div>
      <button type="submit" class="btn btn-info btn-block">SIGN IN</button>
    </form>
    <div>
	<!-- <a href="#" class="" data-toggle="modal" data-target="#myModal">CARA MENJADI CUSTOMER</a> -->
    </div>
    <!-- <div>
         <a style="color:#3fb5b5;" href="<?php echo site_url('home/usehandheld'); ?>"><p>USE HANDHELD</p></a>
    </div> -->
    <footer class="page-copyright page-copyright-inverse">
      <p><font size="1">&copy; 2016<a style="color:#3fb5b5;" href="javascript:void(0)"> BEHANDLE OPERATING SYSTEM </a></font></p>
    </footer>
  </div>

	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog" style="margin: 70px auto !important;">

		<!-- Modal content-->
		<div class="modal-content" style="background: rgba(0,0,0,0.4);">
		  <div class="modal-header" style="background: #3F51B5;">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title" style="color:#fff">B O S<!--Header--></h4>
		  </div>
		  <div class="modal-body">
			<img src="<?php echo base_url('assets/images/reg_customer.png'); ?>" alt="" width="820">
		  </div>
		  <div class="modal-footer">
			<!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
		  </div>
		</div>

	  </div>
	</div>

</div>
<!--<footer class="site-footer">
  <div class="site-footer-legal">© 2016<a href="javascript:void(0)"> COMMON GATE INSPECTION SYSTEM / </a><a href="<?php echo site_url('home/usehandheld'); ?>">USE HANDHELD</a></div>
  <div class="site-footer-right">
  	 CREATED BY <a href="javascript:void(0)">PT. ELECTRONIC DATA INTERCHANGE INDONESIA</a>
  </div>
</footer>-->
<script src="http://code.jquery.com/jquery-1.12.1.min.js"></script>
<script>
    $(function () {
        var slider = new SliderUnlock("#slider", {}, function () {
          //alert('unlocked');
           var a = document.getElementById('unlock');
                a.value = '1';
        });

        slider.init();
    })
</script>
