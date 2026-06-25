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
          	<i class="icon md-mail-send margin-0" aria-hidden="true"></i> HEADER
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
                      <label class="col-sm-3 control-label">CAR</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control focus" value="<?php echo substr($arrdata[0]->CAR,20); ?>" readonly="readonly">
                        <div class="hint">CAR</div>
                      </div>
                    </div>

                    <div class="form-group form-material">
                      <label class="col-sm-3 control-label">KODE KANTOR <?//= strtoupper($kddok); ?></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control focus" value="<?php echo $arrdata[0]->KD_KANTOR; ?>" readonly="readonly">
                        <div class="hint">KODE KANTOR</div>
                      </div>
                    </div>

                    <div class="form-group form-material">
                      <label class="col-sm-3 control-label">NO. PIB <?//= strtoupper($kddok); ?></label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control focus" value="<?php echo $arrdata[0]->NO_DAFTAR_PABEAN; ?>" readonly="readonly">
                        <div class="hint">NO. PIB</div>
                      </div>
                    </div>

                    <div class="form-group form-material">
                      <label class="col-sm-3 control-label">TGL. PIB</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control focus" value="<?php echo $arrdata[0]->TGL_PIB; ?>" readonly="readonly">
                        <div class="hint">TGL. PIB</div>
                      </div>
                    </div>

                    <div class="form-group form-material">
                      <label class="col-sm-3 control-label">NPWP IMPORTIR</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control focus" value="<?php echo $arrdata[0]->ID_CONSIGNEE; ?>" readonly="readonly">
                        <div class="hint">NPWP IMPORTIR</div>
                      </div>
                    </div>

                    <div class="form-group form-material">
                      <label class="col-sm-3 control-label">NAMA IMPORTIR</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control focus" value="<?php echo $arrdata[0]->CONSIGNEE; ?>" readonly="readonly">
                        <div class="hint">NAMA IMPORTIR</div>
                      </div>
                    </div>

                    <div class="form-group form-material">
                      <label class="col-sm-3 control-label">NPWP PPJK</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control focus" value="<?php echo $arrdata[0]->NPWP_PPJK; ?>" readonly="readonly">
                        <div class="hint">NPWP PPJK</div>
                      </div>
                    </div>

                    <div class="form-group form-material">
                      <label class="col-sm-3 control-label">NAMA PPJK</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control focus" value="<?php echo $arrdata[0]->NAMA_PPJK; ?>" readonly="readonly">
                        <div class="hint">NAMA PPJK</div>
                      </div>
                    </div>

                    <div class="form-group form-material">
                      <label class="col-sm-3 control-label">GUDANG</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control focus" value="<?php echo $arrdata[0]->KD_GUDANG; ?>" readonly="readonly">
                        <div class="hint">GUDANG</div>
                      </div>
                    </div>

                    <div class="form-group form-material">
                      <label class="col-sm-3 control-label">JUMLAH KONTAINER</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control focus" value="<?php echo $arrdata[0]->JML_CONT; ?>" readonly="readonly">
                        <div class="hint">JUMLAH KONTAINER</div>
                      </div>
                    </div>
                  </div>
                  <!--kanan -->
                  <div class="col-md-6">
                    <?php //if($kddok=='manual') { ?>
                    <div class="form-group form-material">
                              <label class="col-sm-3 control-label">NO. BC 11</label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control focus" value="<?php echo $arrdata[0]->NO_BC11; ?>" readonly="readonly">
                                <div class="hint">NO. BC 11</div>
                              </div>
                            </div>
                    <?php //} ?>
                    <div class="form-group form-material">
                      <label class="col-sm-3 control-label">TGL. BC 11</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control focus" value="<?php echo $arrdata[0]->TGL_BC_11; ?>" readonly="readonly">
                        <div class="hint">TGL. BC 11</div>
                      </div>

                    </div>
                    <div class="form-group form-material">
                      <label class="col-sm-3 control-label">NO. POS BC11</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control focus" value="<?php echo $arrdata[0]->NO_POS_BC11; ?>" readonly="readonly">
                        <div class="hint">NO. POS BC 11</div>
                      </div>
                    </div>

                    <div class="form-group form-material">
                      <label class="col-sm-3 control-label">FLAG KARANTINA</label>
                      <div class="col-sm-9">
                        <textarea class="form-control focus"  readonly="readonly"><?php echo $arrdata[0]->FL_KARANTINA; ?></textarea>
                        <div class="hint">FLAG KARANTINA</div>
                      </div>
                    </div>
                    <div class="form-group form-material">
                      <label class="col-sm-3 control-label">NAMA ANGKUT</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control focus" value="<?php echo $arrdata[0]->NM_ANGKUT; ?>" readonly="readonly">
                        <div class="hint">NAMA ANGKUT</div>
                      </div>
                    </div>
                    <div class="form-group form-material">
                      <label class="col-sm-3 control-label">N0. VOYOGE</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control focus" value="<?php echo $arrdata[0]->NO_VOY_FLIGHT; ?>" readonly="readonly">
                        <div class="hint">N0. VOYOGE</div>
                      </div>
                    </div>
                    <div class="form-group form-material">
                      <label class="col-sm-3 control-label">N0. SPPB</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control focus" value="<?php echo $arrdata[0]->NO_DOK_INOUT; ?>" readonly="readonly">
                        <div class="hint">N0. SPPB</div>
                      </div>
                    </div>
                    <div class="form-group form-material">
                      <label class="col-sm-3 control-label">TGL. SPPB</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control focus" value="<?php echo $arrdata[0]->TGL_SPPB; ?>" readonly="readonly">
                        <div class="hint">TGL. SPPB</div>
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
          <i class="icon md-email-open margin-0" aria-hidden="true"></i> DETAIL</a>
        </a>
        </div>
        <div class="panel-collapse collapse in" id="exampleCollapseContinuousTwo" aria-labelledby="exampleHeadingContinuousTwo" role="tabpanel">
          <div class="panel-body container-fluid">
            <div class="tab-pane" id="tab2">
            <div class="row">
			<table class="table">
			  <tr>
				<td>No</td>
				<td>Nomor Kontainer</td>
				<td>Ukuran Kontainer</td>
				<td>Jenis Kontainer</td>
			  </tr>
			  <?php $no = 0; foreach ($arrdata as $key => $value) {
				$no++;
			  //} ?>
			  <tr>
				<td><?php echo $no; ?></td>
				<td><?php echo $value->NO_CONT ?></td>
				<td><?php echo $value->KD_CONT_UKURAN ?></td>
				<td><?php //echo $value->ISO_CODE ?></td>
			  </tr>
			  <?php } ?>
			</table>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>

<script>
$(function(){
	autocomplete('NAMA_KAPAL','/responbc/autocomplete/mst_kapal',function(event, ui){
		$('#KD_KAPAL').val(ui.item.KD_KAPAL);
	});
	autocomplete('CONSIGNEE','/responbc/autocomplete/mst_organisasi/CONS',function(event, ui){
		$('#ID_CONSIGNEE').val(ui.item.ID_CONSIGNEE);
	});
	autocomplete('NAMA_PPJK','/responbc/autocomplete/mst_organisasi/CONS',function(event, ui){
		$('#NPWP_PPJK').val(ui.item.NPWP_PPJK);
	});
});
</script>
