<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
    <span class="ribbon-inner">
    <i class="icon md-view-list margin-0" aria-hidden="true"></i> <?php echo $title; ?>
    </span>
  </div>
  <div>&nbsp;</div>
  <div>&nbsp;</div>

  <div class="panel-group panel-group-continuous" id="exampleAccordionContinuous" aria-multiselectable="true" role="tablist">
      <div class="panel">
        <div class="panel-heading" id="exampleHeadingContinuousOne" role="tab">
          <a class="panel-title" data-parent="#exampleAccordionContinuous" data-toggle="collapse" href="#exampleCollapseContinuousOne" aria-controls="exampleCollapseContinuousOne" aria-expanded="false">
          	<i class="icon md-mail-send margin-0" aria-hidden="true"></i> KAPAL
          </a>
        </div>
        <div class="panel-collapse collapse" id="exampleCollapseContinuousOne" aria-labelledby="exampleHeadingContinuousOne" role="tabpanel">
          <div class="panel-body">



            <div class="card">
              <div class="card-block p-a-0">
                <div class="box-tab m-b-0" id="rootwizard">
                  <ul class="wizard-tabs">
                    <!--<li style="width:100%;"> <a data-toggle="" style="text-align:right">
                      <button type="button" class="btn btn-primary btn-icon" onclick="save_post('form_data'); return false;">Save <i class="icon-check"></i></button>
                      </a> </li>-->
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane p-x-lg active" id="tab1">
                  <div class="row">
                      <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?//= $act; ?>" method="post" autocomplete="off" onsubmit="save_post('form_data'); return false;">
                        <!-- kiri -->
                  <div class="col-md-6">
                    <div class="form-group form-material">
                      <label class="col-sm-3 control-label">NAMA KAPAL</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control focus" value="<?php echo $arrdata[0]->NM_KAPAL; ?>" readonly="readonly">
                        <div class="hint">NAMA KAPAL</div>
                      </div>
                    </div>

                    <div class="form-group form-material">
                      <label class="col-sm-3 control-label">NO. VOYAGE <?//= strtoupper($kddok); ?></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control focus" value="<?php echo $arrdata[0]->NO_VOYAGE; ?>" readonly="readonly">
                        <div class="hint">NO. VOYAGE</div>
                      </div>
                    </div>

                    <div class="form-group form-material">
                      <label class="col-sm-3 control-label">ETA <?//= strtoupper($kddok); ?></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control focus" value="<?php echo $arrdata[0]->ETA; ?>" readonly="readonly">
                        <div class="hint">ETA</div>
                      </div>
                    </div>

                    <div class="form-group form-material">
                      <label class="col-sm-3 control-label">ETD</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control focus" value="<?php echo $arrdata[0]->ETD; ?>" readonly="readonly">
                        <div class="hint">ETD</div>
                      </div>
                    </div>

                    <div class="form-group form-material">
                      <label class="col-sm-3 control-label">OPEN STACK</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control focus" value="<?php echo $arrdata[0]->OPN_STACK; ?>" readonly="readonly">
                        <div class="hint">OPEN STACK</div>
                      </div>
                    </div>
                  </div>
                  </div>
                  <input type="hidden" name="JNS_DOK" value="<?//= $kddok; ?>" readonly="readonly"/>
                  <input type="hidden" name="ID" value="<?//= $id; ?>" readonly="readonly"/>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="panel">
        <div class="panel-heading" id="exampleHeadingContinuousTwo" role="tab">
          <a class="panel-title collapsed" data-parent="#exampleAccordionContinuous" data-toggle="collapse" href="#exampleCollapseContinuousTwo" aria-controls="exampleCollapseContinuousTwo" aria-expanded="true">
          <i class="icon md-email-open margin-0" aria-hidden="true"></i> REALISASI</a>
        </a>
        </div>
        <div class="panel-collapse collapse in" id="exampleCollapseContinuousTwo" aria-labelledby="exampleHeadingContinuousTwo" role="tabpanel">
          <div class="panel-body container-fluid">
            <div class="tab-pane" id="tab2">
            <div class="row">
                <div class="form-group form-material">
                  <label class="col-sm-3 control-label">ATA</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control focus" value="<?php echo $arrdata[0]->ATA; ?>" readonly="readonly">
                    <div class="hint">ATA</div>
                  </div>
                </div>

                <div class="form-group form-material">
                  <label class="col-sm-3 control-label">ATD</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control focus" value="<?php echo $arrdata[0]->ATD; ?>" readonly="readonly">
                    <div class="hint">ATD</div>
                  </div>
                </div>
                <div class="form-group form-material">
                  <label class="col-sm-3 control-label">NO. PPKB</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control focus" value="<?php echo $arrdata[0]->NO_PPKB; ?>" readonly="readonly">
                    <div class="hint">NO. PPKB</div>
                  </div>
                </div>
				<div class="form-group form-material">
                  <label class="col-sm-3 control-label">WAKTU DISCHARGE</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control focus" value="<?php echo $arrdata[0]->WK_DISCH; ?>" readonly="readonly">
                    <div class="hint">WAKTU DISCHARGE</div>
                  </div>
                </div>
				<div class="form-group form-material">
                  <label class="col-sm-3 control-label">JUMLAH MUATAN</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control focus" value="<?php echo $arrdata[0]->JMLH_MUAT; ?>" readonly="readonly">
                    <div class="hint">JUMLAH MUATAN</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
