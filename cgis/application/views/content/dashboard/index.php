<div class="col-md-9">
  <div>
    <h1>
      Welcome to Berak Operating System Common Area PT. Multi Terminal Indonesia
    </h1>
  </div>
  <!-- <div class="panel">
    <div class="panel-body nav-tabs-animate">
      <ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">
        <li class="active" role="presentation"><a data-toggle="tab" href="#activities" aria-controls="activities" role="tab">HOME</a></li>
        <li role="presentation"><a data-toggle="tab" href="#profile" aria-controls="profile" role="tab">ACTIVITIES</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active animation-slide-left" id="activities" role="tabpanel">
          
        </div>
        <div class="tab-pane animation-slide-left" id="profile" role="tabpanel">
          <ul class="list-group">
            <?php //foreach($arr_hist as $hist): ?>
            <li class="list-group-item">
              <div class="media media-lg">
                <div class="media-left">
                  <a class="avatar" href="javascript:void(0)">
                    <img class="img-responsive" src="<?php //echo ($this->session->userdata('PATH')!="")?base_url().$this->session->userdata('PATH'):base_url().'assets/images/user.png'; ?>" alt="...">
                  </a>
                </div>
                <div class="media-body">
                  <h4 class="media-heading"><?php //echo $hist['NM_LENGKAP']; ?></h4>
                  <small><?php //echo $hist['WK_REKAM']; ?></small>
                  <div class="profile-brief">
                    <div class="media">
                      <div class="media-body">
                        <h4 class="media-heading">DESKRIPSI</h4>
                        <p><?php //echo $hist['DESKRIPSI']; ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <?php //endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div> -->
</div>
<div class="col-md-3">
  <!-- <div class="widget widget-shadow text-center page-profile">
    <div class="widget-header">
      <div class="widget-header-content">
        <a class="avatar avatar-100" href="javascript:void(0)">
          <img src="<?php //echo ($this->session->userdata('PATH')!="")?base_url().$this->session->userdata('PATH'):base_url().'assets/images/user.png'; ?>" alt="...">
        </a>
        <h4 class="profile-user"><?php //echo $this->session->userdata('NM_LENGKAP'); ?></h4>
        <p class="profile-job"><?php //echo strtoupper($this->session->userdata('USERLOGIN')); ?></p>
        <p><?php //echo strtoupper($this->session->userdata('KETERANGAN')); ?></p>
        <button type="button" class="btn btn-primary">DETAIL</button>
      </div>
    </div>
    <div class="widget-footer">
      <div class="row no-space">
        <div class="col-xs-6">
          <strong class="profile-stat-count"><?php //echo $this->session->userdata('KD_TPS'); ?></strong>
          <span>KODE TPS</span>
        </div>
        <div class="col-xs-6">
          <strong class="profile-stat-count"><?php //echo $this->session->userdata('KD_GUDANG'); ?></strong>
          <span>KODE GUDANG</span>
        </div>
      </div>
      <div class="row no-space">
        <div class="col-xs-12">
          <strong class="profile-stat-count"><?php //echo validate($this->session->userdata('LAST_LOGIN'),'DATETIME'); ?></strong>
          <span>LAST LOGIN</span>
        </div>
      </div>
    </div>
  </div> -->
</div>   
<script>
$(document).ready(function() {
	Site.run();
});
</script>