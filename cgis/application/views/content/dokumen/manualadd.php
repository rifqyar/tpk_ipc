<?php //print_r ($arrdata);
if ($act != "update") {
  $act = "save";
}
?>
<div class="panel">
  <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light"
    onclick="save_ajax('form_data','tblmnl'); return false;">
    <i class="icon md-badge-check"></i> SAVE
  </button>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_data" id="form_data" class="form-horizontal" role="form"
          action="<?php echo 'planning/execute/' . $act . '/manual/' . $id; ?>" method="post" autocomplete="off" popup="1"
          enctype="multipart/form-data" onsubmit="save_post('form_data','tblmnl')">
          <input type="hidden" name="action" id="action" readonly="readonly"
            value="<?php echo site_url('planning/manual'); ?>" />
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">JENIS DOKUMEN</label>
                <div class="col-sm-8">
                  <input type="hidden" class="form-control" name="DATA[ID]" id="ID"
                    value="<?php echo $arrdata['ID']; ?>" readonly="readonly">
                  <input type="hidden" class="form-control" name="DATA[KD_DOK_INOUT]" id="KD_DOK_INOUT"
                    value="<?php echo $arrdata['KD_DOK_INOUT']; ?>" readonly="readonly">
                  <input type="text" name="NM_DOK_INOUT" id="NM_DOK_INOUT" mandatory="yes" class="form-control"
                    placeholder="NAMA DOKUMEN" value="<?php echo $arrdata['NM_DOK_INOUT']; ?>" readonly="readonly">
                  <div class="hint">JENIS DOKUMEN</div>
                </div>
                <div class="col-sm-1">
                  <button type="button" class="btn btn-primary btn-sm"
                    onclick="popup_searchtwo('popup/popup_search/mst_kddok/KD_DOK_INOUT|NM_DOK_INOUT/2');"><span
                      class="icon md-search"></span></button>
                </div>
              </div>

              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO/TGL DOKUMEN</label>
                <div class="col-sm-4">
                  <input class="form-control" type="text" placeholder="NO DOKUMEN" name="DATA[NO_DOK_INOUT]"
                    id="NO_DOK_INOUT" mandatory="yes" value="<?php echo $arrdata['NO_DOK_INOUT']; ?>">
                  <div class="hint">NO DOKUMEN</div>
                </div>
                <div class="col-sm-4">
                  <input type="text" name="DATA[TGL_DOK_INOUT]" id="TGL_DOK_INOUT" mandatory="yes"
                    class="date form-control" placeholder="TGL DOKUMEN"
                    value="<?php echo validate($arrdata['TGL_DOK_INOUT'], 'DATE'); ?>">
                  <div class="hint">TGL DOKUMEN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO PIB</label>
                <div class="col-sm-4">
                  <input class="form-control" type="text" placeholder="NOMOR PIB" name="DATA[NO_DAFTAR_PABEAN]" id="NO_DAFTAR_PABEAN"
                    mandatory="yes" value="<?php echo $arrdata['NO_DAFTAR_PABEAN']; ?>">
                  <div class="hint">NOMOR PIB</div>
                </div>

                <div class="col-sm-4">
                  <input type="text" name="DATA[TGL_DAFTAR_PABEAN]" id="TGL_DAFTAR_PABEAN" mandatory="yes"
                    class="date form-control" placeholder="TGL PIB"
                    value="<?php echo validate($arrdata['TGL_DAFTAR_PABEAN'], 'DATE'); ?>">
                  <div class="hint">TGL PIB</div>
                </div>
              </div>

              <div class="form-group form-material">
                <label class="col-sm-3 control-label">INFO KAPAL</label>
                <div class="col-sm-4">
                  <input class="form-control" type="text" placeholder="NAMA KAPAL" name="DATA[NM_ANGKUT]" id="NM_ANGKUT"
                    mandatory="yes" value="<?php echo $arrdata['NM_ANGKUT']; ?>">
                  <div class="hint">NAMA KAPAL</div>
                </div>

                <div class="col-sm-4">
                  <input class="form-control" type="text" placeholder="NO VOYAGE" name="DATA[NO_VOY_FLIGHT]"
                    id="NO_VOY_FLIGHT" mandatory="yes" value="<?php echo $arrdata['NO_VOY_FLIGHT']; ?>">
                  <div class="hint">NO VOYAGE</div>
                </div>
              </div>

              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NPWP/NAMA IMPORTIR</label>
                <div class="col-sm-4">
                  <input class="form-control" type="text" placeholder="NPWP IMPORTIR" name="DATA[ID_CONSIGNEE]"
                    id="ID_CONSIGNEE" mandatory="yes" value="<?php echo $arrdata['ID_CONSIGNEE']; ?>">
                  <div class="hint">NPWP IMPORTIR</div>
                </div>
                <div class="col-sm-4">
                  <input type="text" name="DATA[CONSIGNEE]" id="CONSIGNEE" mandatory="yes" class="form-control"
                    placeholder="NAMA IMPORTIR" value="<?php echo $arrdata['CONSIGNEE']; ?>">
                  <div class="hint">NAMA IMPORTIR</div>
                </div>
                <div class="col-sm-1">
                  <button type="button" class="btn btn-primary btn-sm"
                    onclick="popup_searchtwo('popup/popup_search/mt_customer/ID_CONSIGNEE|CONSIGNEE/2');"><span
                      class="icon md-search"></span></button>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO/TGL BLAWB</label>
                <div class="col-sm-4">
                  <input name="DATA[NO_BL_AWB]" id="NO_BL_AWB" class="form-control" placeholder="NO BLAWB"
                    value="<?php echo $arrdata['NO_BL_AWB']; ?>">
                  <div class="hint">NO BLAWB</div>
                </div>
                <div class="col-sm-4">
                  <input type="text" name="DATA[TGL_BL_AWB]" id="TGL_BL_AWB" class="date form-control"
                    placeholder="TGL BLAWB" value="<?php echo validate($arrdata['TGL_BL_AWB'], 'DATE'); ?>">
                  <div class="hint">TGL BLAWB</div>
                </div>
              </div>

              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO/TGL BC11</label>
                <div class="col-sm-4">
                  <input name="DATA[NO_BC11]" id="NO_BC11" class="form-control" placeholder="NO BC11"
                    value="<?php echo $arrdata['NO_BC11']; ?>">
                  <div class="hint">NO BC11</div>
                </div>
                <div class="col-sm-4">
                  <input type="text" name="DATA[TGL_BC11]" id="TGL_BC11" class="date form-control"
                    placeholder="TGL BC11" value="<?php echo validate($arrdata['TGL_BC11'], 'DATE'); ?>">
                  <div class="hint">TGL BC11</div>
                </div>
              </div>

              <?php if ($arrdata['PATH'] != ""): ?>
                <div class="form-group form-material">
                  <label class="col-sm-3 control-label">FOTO</label>
                  <div class="col-sm-7">
                    <div class="input-group input-group-file">
                      <input type="text" class="form-control" readonly="readonly" mandatory="yes" placeholder="BROWSE">
                      <span class="input-group-btn">
                        <span class="btn btn-primary btn-file"><i class="icon md-upload" aria-hidden="true"></i>
                          <input type="file" name="FOTO" id="FOTO">
                        </span>
                      </span>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <a href="<?php echo base_url($arrdata['PATH']); ?>" target="_blank"
                      class="btn btn-primary btn-sm btn-file">
                      <i class="icon md-account-box" aria-hidden="true"></i> FOTO
                    </a>
                  </div>
                </div>
              <?php else: ?>
                <div class="form-group form-material">
                  <label class="col-sm-3 control-label">LAMPIRAN</label>
                  <div class="col-sm-9">
                    <div class="input-group input-group-file">
                      <input type="text" class="form-control" readonly="readonly" placeholder="BROWSE">
                      <span class="input-group-btn">
                        <span class="btn btn-primary btn-file"><i class="icon md-upload" aria-hidden="true"></i>
                          <input type="file" name="FOTO" id="FOTO">
                        </span>
                      </span>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="ribbon ribbon-clip ribbon-primary">
                <span class="ribbon-inner">
                  <i class="icon md-account margin-0" aria-hidden="true"></i> CONTAINNER
                </span>
              </div>
              </br></br>
              <div class="form-group form-material">
                <div class="col-sm-3 control-label">NO. CONTAINER</div>
                <div class="col-sm-9">
                  <input type="text" name="NO_CONT" id="NO_CONT" mandatory="yes" class="form-control" maxlength="11">
                </div>
              </div>

              <div class="form-group form-material">
                <div class="col-sm-3 control-label">UKURAN</div>
                <div class="col-sm-9">
                  <?php echo form_dropdown('KD_CONT_UKURAN', array('' => '', '20' => '20', '40' => '40', '45' => '45'), $arrdata['KD_GROUP'], 'id="KD_CONT_UKURAN" mandatory="yes" class="form-control"'); ?>

                </div>
              </div>

              <div class="form-group form-material">
                <div class="col-sm-3 control-label">TYPE</div>
                <div class="col-sm-9">
                  <?php echo form_dropdown('TIPE_CONT', array('' => '', 'DRY' => 'DRY', 'RFR' => 'RFR'), $arrdata['KD_GROUP'], 'id="TIPE_CONT" mandatory="yes"  class="form-control"'); ?>

                </div>
              </div>
              <div class="form-group form-material">
                <div class="col-sm-3 control-label">JENIS</div>
                <div class="col-sm-9">
                  <?php echo form_dropdown('KD_CONT_JENIS', array('' => '', 'F' => 'FULL', 'NULL' => 'EMPTY'), $arrdata['KD_GROUP'], 'id="KD_CONT_JENIS" mandatory="yes" class="form-control"'); ?>

                </div>
              </div>
              <div class="col-md-12">
                <div>&nbsp;</div>
                <input type="hidden" name="indexcont" id="indexcont" readonly="readonly" />
                <center><button class="btn btn-sm btn-primary" onclick="addcont()" type="button"><i
                      class="icon-plus"></i> ADD</button></center>
              </div>
              <div class="col-md-12">
                <div>&nbsp;</div>
                <table class="tabelajax" id="tablecont">
                  <thead>
                    <tr class="headcontent">
                      <th width="100px;" align="center">&nbsp;</th>
                      <th>NO. CONTAINER</th>
                      <th>UKURAN</th>
                      <th>TIPE</th>
                      <th>JENIS</th>
                    </tr>
                  </thead>
                  <?php if ($array_cont != ""): ?>
                    <tbody>
                      <?php $tmpindexcont = 1;
                      if (count($array_cont) == 0) { ?>
                        <tr id="cont_null">
                          <td colspan="13" class="alt">
                            <center>Tidak Terdapat Data</center>
                          </td>
                        </tr>
                      <?php } else {
                        foreach ($array_cont as $cont) {
                          $indexcont .= "," . $tmpindexcont; ?>
                          <tr id="cont_<?php echo $tmpindexcont; ?>">
                            <td width="100px;" align="center">
                              <button class="btn" type="button" title="Hapus Data"
                                onclick="hapuscont('<?php echo $tmpindexcont; ?>')">
                                <i class="icon-trash"> Hapus</i>
                              </button>
                            </td>
                            <td class="alt">
                              <?php echo $cont['NO_CONT']; ?>
                              <input type="hidden" readonly="readonly" name="CONT<?php echo $tmpindexcont; ?>[NO_CONT]"
                                id="NO_CONT" value="<?php echo $cont['NO_CONT']; ?>" duplicate="no" />
                            </td>
                            <td class="alt">
                              <?php echo $cont['KD_CONT_UKURAN']; ?>
                              <input type="hidden" readonly="readonly" name="CONT<?php echo $tmpindexcont; ?>[KD_CONT_UKURAN]"
                                id="KD_CONT_UKURAN" value="<?php echo $cont['KD_CONT_UKURAN']; ?>" />
                            </td>
                            <td class="alt">
                              <?php echo $cont['TIPE_CONT']; ?>
                              <input type="hidden" readonly="readonly" name="CONT<?php echo $tmpindexcont; ?>[TIPE_CONT]"
                                id="TIPE_CONT" value="<?php echo $cont['TIPE_CONT']; ?>" />
                            </td>
                            <td class="alt">
                              <?php echo $cont['KD_CONT_JENIS']; ?>
                              <input type="hidden" readonly="readonly" name="CONT<?php echo $tmpindexcont; ?>[KD_CONT_JENIS]"
                                id="KD_CONT_JENIS" value="<?php echo $cont['KD_CONT_JENIS']; ?>" />
                            </td>

                          </tr>
                          <?php $tmpindexcont++;
                        }
                      } ?>
                    </tbody>
                  <?php else: ?>
                    <tbody>
                      <tr id="cont_null">
                        <td colspan="13" class="alt">
                          <center>Tidak Terdapat Data</center>
                        </td>
                      </tr>
                    </tbody>
                  <?php endif; ?>
                </table>
              </div>
            </div>

          </div>
      </div>

      </form>
    </div>
  </div>
</div>
<script>
  $(function () {
    date('date');
    autocomplete('ORGANISASI', '/popup/autocomplete/mst_organisasi', function (event, ui) {
      $('#KD_ORGANISASI').val(ui.item.KODE);
    });
    autocomplete('NM_ANGKUT', '/popup/autocomplete/mst_kapal', function (event, ui) {
      $('#NM_ANGKUT').val(ui.item.label);
      $('#NO_VOY_FLIGHT').val(ui.item.NO_VOY);
    });

  });

</script>