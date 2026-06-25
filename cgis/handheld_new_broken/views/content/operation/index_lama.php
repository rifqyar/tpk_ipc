<div align="center" class="container">
<H4 style="color:white;" >MENU HANDHELD</H4>
  <a href="<?php echo site_url('operation/pickup'); ?>">
    <br><button style="height:35px; width:200px;" type="button" class="btn btn-primary">PICK UP</button>
  </a>
  <a href="<?php echo site_url('operation/inspection'); ?>">
    <br><br><button style="height:35px; width:200px;" type="button" class="btn btn-primary">BEHANDLE IN</button>
  </a>
  <a href="<?php echo site_url('operation/hold'); ?>">
    <br><br><button style="height:35px; width:200px;" type="button" class="btn btn-primary">HOLD</button>
  </a>
  <a href="<?php echo site_url('operation/marshalling'); ?>">
    <br><br><button style="height:35px; width:200px;" type="button" class="btn btn-primary">MARSHALLING <b style='color:orange;'>(<?php echo count($jumlahmarsh); ?>)<b/></button>
  </a>
<!--   <a href="<?php echo site_url('operation/marshallingyard'); ?>">
    <br><br><button style="height:35px; width:200px;" type="button" class="btn btn-primary">MARSHALLING YARD <b style='color:orange;'>(<?php echo count($jumlahmarshyard); ?>)<b/></button>
  </a> -->
  <a href="<?php echo site_url('operation/realisasibi'); ?>">
    <br><br><button style="height:35px; width:200px;" type="button" class="btn btn-primary">PEMERIKSAAN BEHANDLE</button>
  </a>
 <a href="<?php echo site_url('operation/delive'); ?>">
    <br><br><button style="height:35px; width:200px;" type="button" class="btn btn-primary">DELIVERY</button>
  </a>
  <a href="<?php echo site_url('operation/inspect');?>">
    <br><br><button style="height:35px; width:200px;" type="button" class="btn btn-primary">INSPECTION OUT</button>
  </a>
  <a href="<?php echo site_url('operation/chases'); ?>">
    <br><br><button style="height:35px; width:200px;" type="button" class="btn btn-primary">ON CHASSIS <b style='color:orange;'>(<?php echo count($jumlah); ?>)<b/> </button>
  </a> 
  	<?php
		if ($usernya == 'SPA' || $usernya == 'PLN' || $usernya == 'OPR')
		{
	?>
		<a href="<?php echo site_url('operation/copy'); ?>">
			<br><br><button style="height:35px; width:200px;" type="button" class="btn btn-primary">COPYYARD</button>
		</a>
	<?php
	}?>
   <a href="<?php echo site_url('home/signout'); ?>">
    <br><br><button style="height:35px; width:200px;" type="button" class="btn btn-danger">SIGNOUT</button>
  </a>
</div>
