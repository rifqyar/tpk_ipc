<div align="center" class="container">
<H4 style="color:white;" >MENU HANDHELD</H4>
  <a href="<?php echo site_url('operation/pickup_new'); ?>">
    <br><button style="height:35px; width:230px;" type="button" class="btn btn-primary">PICK UP</button>
  </a>
  <a href="<?php echo site_url('operation/behandlein_new'); ?>">
    <br><br><button style="height:35px; width:230px;" type="button" class="btn btn-primary">BEHANDLE IN</button>
  </a>
  <a href="<?php echo site_url('operation/hold_new'); ?>">
    <br><br><button style="height:35px; width:230px;" type="button" class="btn btn-primary">HOLD</button>
  </a>
  <a href="<?php echo site_url('operation/marshallingcic'); ?>">
    <br><br><button style="height:35px; width:230px;" type="button" class="btn btn-primary">MARSHALLING CIC <b style='color:orange;'>(<?php echo count($jumlahmarshcic); ?>)<b/></button>
  </a> 
 <a href="<?php echo site_url('operation/marshallingyard'); ?>">
    <br><br><button style="height:35px; width:230px;" type="button" class="btn btn-primary">MARSHALLING YARD <b style='color:orange;'>(<?php echo count($jumlahmarshyard); ?>)<b/></button>
  </a>
  <a href="<?php echo site_url('operation/realisasi'); ?>">
    <br><br><button style="height:35px; width:230px;" type="button" class="btn btn-primary">PEMERIKSAAN BEHANDLE</button>
  </a>
  <a href="<?php echo site_url('operation/reefer'); ?>">
    <br><br><button style="height:35px; width:230px;" type="button" class="btn btn-primary">PLUG REEFER</button>
  </a>
  <a href="<?php echo site_url('operation/monitor_reefer'); ?>">
    <br><br><button style="height:35px; width:230px;" type="button" class="btn btn-primary">MONITORING REEFER</button>
  </a>
 <a href="<?php echo site_url('operation/delivery'); ?>">
    <br><br><button style="height:35px; width:230px;" type="button" class="btn btn-primary">DELIVERY</button>
  </a>
  <a href="<?php echo site_url('operation/inspectout');?>">
    <br><br><button style="height:35px; width:230px;" type="button" class="btn btn-primary">INSPECTION OUT</button>
  </a>
  <a href="<?php echo site_url('operation/chases'); ?>">
    <br><br><button style="height:35px; width:230px;" type="button" class="btn btn-primary">ON CHASSIS <b style='color:orange;'>(<?php echo count($jumlah); ?>)<b/> </button>
  </a> 
		<a href="<?php echo site_url('operation/copyard'); ?>">
			<br><br><button style="height:35px; width:230px;" type="button" class="btn btn-primary">COPYYARD</button>
		</a>
   <a href="<?php echo site_url('home/signout'); ?>">
    <br><br><button style="height:35px; width:230px;" type="button" class="btn btn-danger">SIGNOUT</button>
  </a>
</div>
