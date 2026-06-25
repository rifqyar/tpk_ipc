
<div class="container">
    <div class="row">
		<div class="col-md-4 col-md-offset-4">
    		<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">Please sign in </h3>
			 	</div>
				</br>
			  	<div class="panel-body">
			    	<form name="form_login" id="form_login" method="post" autocomplete="off" action="<?php echo site_url(); ?>/home/signin">
                    <fieldset>
			    	  	<div class="form-group">
			    		    <input class="form-control" type="text" mandatory="yes" id="username" name="username" value=""
          placeholder="username" >
			    		</div>
			    		<div class="form-group">
			    			<input class="form-control" type="password" name="password" mandatory="yes" id="password" name="password" value=""
          placeholder="password">
			    		</div>
			    		
			    		<input class="btn btn-lg btn-primary btn-block" type="submit" value="Login">
						</br>
						<p>© 2016<a href="<?php echo site_url('home/homelogin'); ?>"> BEHANDLE OPERATING SYSTEM </a></p>
			    	</fieldset>
			      	</form>
			    </div>
			</div>
		</div>
	</div>
</div>

<!--<div class="page animsition vertical-align text-center" data-animsition-in="fade-in"
  data-animsition-out="fade-out">
    <div class="page-content vertical-align-middle">
      <h2 class="brand-text">C G I S</h2>
      <form name="form_login" id="form_login" method="post" autocomplete="off" onSubmit="signin('form_login'); return false;" action="<?php //echo site_url(); ?>/home/signin">
        <div class="input-group">
          <input type="text" class="form-control last" mandatory="yes" id="username" name="username" value=""
          placeholder="username">
          <span class="input-group-btn">
            <button type="submit" class="btn btn-primary"><i class="icon md-assignment-account" aria-hidden="true"></i>
              <span class="sr-only">username</span>
            </button>
          </span>
        </div>
		<div class="input-group">
          <input type="password" class="form-control last" mandatory="yes" id="password" name="password" value=""
          placeholder="password">
          <span class="input-group-btn">
            <button type="submit" class="btn btn-primary"><i class="icon md-lock-open" aria-hidden="true"></i>
              <span class="sr-only">password</span>
            </button>
          </span>
        </div>
		<button type="submit" class="btn btn-primary btn-block">SIGN IN</button>
      </form>
      
      <footer class="page-copyright page-copyright-inverse">
        <p>© 2016<a href="<?php //echo site_url('home/homelogin'); ?>"> BEHANDLE OPERATING SYSTEM </a></p>
        
      </footer>
    </div>
  </div>-->