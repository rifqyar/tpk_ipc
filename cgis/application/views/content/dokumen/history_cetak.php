
<?php //print_r($arrdata);die();?>
<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <!--<li style="width:100%;"> <a data-toggle="" style="text-align:right">
          <button type="button" class="btn btn-primary btn-icon" onclick="save_post('form_data'); return false;">Save <i class="icon-check"></i></button>
          </a> </li>
          <div class="tab-pane" id="tab2">
    <div class="col-md-6">
        <div class="form-group">
          <label class="col-sm-3 control-label-left">NO. KONTAINER</label>
          <div class="col-sm-8">
          <pre><?php //echo $arrdata[0]->NO_CONT; ?></pre>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label-left">UKURAN KONTAINER <?//= strtoupper($kddok); ?></label>
          <div class="col-sm-8">
          <pre><?php //echo $arrdata[0]->UKURAN; ?></pre>
          </div>
        </div>
      </div>
        </div>
      </ul>
      <div class="tab-content">
        
    
      </div>
    </div>-->
    <table class="table">
      <tr>
        <td>NO</td>
        <td>NAMA</td>
        <td>JUMLAH</td>
        <td>TANGGAL CETAK TERAKHIR</td>
      </tr>
      <?php $no = 0; foreach ($arrdata as $key => $value) {
        $no++;
		$date = $this->db->query("SELECT DATE_PRINTS FROM hist_print where ID_HANDLE = '".$value['ID_HANDLE']."' AND USER_PRINTS = '".$value['USER_PRINTS']."' AND TYPE_RPT = '".$value['TYPE_RPT']."' ORDER BY DATE_PRINTS DESC LIMIT 1")->result_array();
      //} ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo $value['NAMA']; ?></td>
        <td><?php echo $value['JML']; ?></td>
        <td><?php echo $date[0]['DATE_PRINTS']; ?></td>
      </tr>
      <?php } ?>
    </table>
  </div>
</div>
