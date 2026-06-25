<?php //print_r($action);die();  
if($act != "update"){
	$act = "save";
}
?>

<script type="text/javascript">
   function addText(){
      //  var x = document.getElementById("ukuran");
      //  var y = document.getElementById("t_ukuran");
      // //  getNama = x.value;
      // //  res = getNama.split("~");
      //  y.value = x.value;
   }
</script>
<div class="panel">
  <button type="submit"  class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_post('form_da','divtblmnl'); return false;">
  <i class="icon md-badge-check"></i> SAVE
  </button>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_da" id="form_da" class="form-horizontal" role="form" action="<?php echo site_url('execute/process/save/manual_karantina/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divtblmnl'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[ID_REQ]" id="ID_REQ" mandatory="no" class="form-control" value="<?php echo trim($arrdata[0]->ID_REQ); ?>">
                  <div class="hint">ID_REQ</div>
                </div>
              </div>
			  <!--
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO REQUEST</label>
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[NO_REQ]" id="NO_REQ" mandatory="no" class="form-control" placeholder="NO_REQ" value="DEL/24-11-2016/001<?php //echo $arrdata['NO_REQ']; ?>" maxlength="10">
                  <div class="hint">NO REQUEST</div>
                </div>
              </div>
			  -->
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NAMA KAPAL/VOYAGE</label>
                <div class="col-sm-5">
                  <input type="text" name="DATA[NM_KAPAL]" id="NM_KAPAL" mandatory="yes" class="form-control" placeholder="NAMA KAPAL" value="<?php echo $arrdata[0]->NM_KAPAL; ?>" maxlength="">
                  <div class="hint">NAMA KAPAL</div>
                </div>
                <div class="col-sm-4">
                  <input type="text" name="DATA[VOYAGE]" id="VOYAGE" mandatory="yes" class="form-control" placeholder="NO. VOYAGE" value="<?php echo $arrdata[0]->VOYAGE; ?>" maxlength="">
                  <div class="hint">NO. VOYAGE</div>
                </div>
              </div>
			  
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">TANGGAL TIBA</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control date" name="DATA[TGL_TIBA]" id="TGL_TIBA" mandatory="yes"  placeholder="TANGGAL TIBA" value="<?php echo $arrdata['TGL_TIBA']; ?>" maxlength="">
                  <div class="hint">TANGGAL TIBA</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO/TANGGAL IJIN</label>
                <div class="col-sm-5">
                  <input type="text" name="DATA[NO_IJIN]" id="NO_IJIN" mandatory="yes" class="form-control" placeholder="NO. IJIN" value="<?php //echo $arrdata['CUSTOMER']; ?>" maxlength="">
                  <div class="hint">NO. IJIN</div>
                </div>
                <div class="col-sm-4">
                  <input type="text" name="DATA[TGL_IJIN]" id="TGL_IJIN" mandatory="yes" class="form-control date" placeholder="TANGGAL IJIN" value="<?php //echo $arrdata[0]->ALAMAT_CONSIGNEE; ?>" maxlength="">
                  <div class="hint">TANGGAL IJIN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NPWP / CONSIGNEE</label>
                <div class="col-sm-5">
                  <input type="text" name="DATA[NPWP]" id="NPWP" mandatory="yes" class="form-control" placeholder="NPWP" value="<?php //echo $arrdata[0]->NPWP_PPJK; ?>" >
                  <div class="hint">NPWP</div>
                </div>
                <div class="col-sm-3">
                  <input type="text" name="DATA[CONSIGNEE]" id="NAMA_CUST" mandatory="yes" class="form-control" placeholder="CONSIGNEE" value="<?php //echo $arrdata['CONTACT_PERSON']; ?>" maxlength="">
                  <div class="hint">CONSIGNEE</div>
                </div>
				<div class="col-sm-1">
                  <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/mt_customer/NPWP|NAMA_CUST|ALAMAT/2');"><span class="icon md-search"></span></button>
                </div>
              </div>

              <div class="form-group form-material">
                <label class="col-sm-3 control-label">ALAMAT</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[ALAMAT]" id="ALAMAT" mandatory="yes" class="form-control" placeholder="ALAMAT" value="<?php echo $arrdata[0]->KD_DOK_INOUT; ?>" maxlength="">
                  <div class="hint">ALAMAT</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NO. BL</label>
                <div class="col-sm-5">
                  <input type="text" name="DATA[NO_BL]" id="BL" mandatory="no" class="form-control" placeholder="NO. BL" value="<?php echo $arrdata[0]->NO_DAFTAR_PABEAN; ?>" maxlength="">
                  <div class="hint">NO. BL</div>
                </div>
                <div class="col-sm-4">
                  <input type="text" name="DATA[TGL_BL]" id="ATD" mandatory="yes" class="form-control date" placeholder="TANGGAL BL" value="<?php //echo $arrdata['ATD']; ?>" maxlength="">
                  <div class="hint">TANGGAL BL</div>
                </div>
              </div>
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
                         <input type="text" name="KONTAINER" id="KONTAINER" mandatory="yes" class="form-control" maxlength="11">
                    </div>
                    <div class="col-sm-3 control-label">UKURAN</div>
                    <div class="col-sm-9">
						        <?php echo form_dropdown('UKURAN', array('' => '','20' => '20', '40' => '40', '45' => '45'),$arrdata['ADD_DATA'], 'id="UKURAN" mandatory="yes" class="form-control"'); ?>
                    </div>
                </div>
                <div class="form-group form-material">
                    <div class="col-sm-3 control-label">ISO CODE</div>
                    <div class="col-sm-9">
                         <input type="text" name="ISO" id="ISO" mandatory="yes" class="form-control">
                    </div>
                </div>
                <div class="form-group form-material">
                    <div class="col-sm-3 control-label">TIPE</div>
                    <div class="col-sm-9">
						<?php echo form_dropdown('TIPE', array('' => '', 'DRY' => 'DRY', 'RFR' => 'RFR'),$arrdata['ADD_DATA'], 'id="TIPE" mandatory="yes"  class="form-control"'); ?>

                    </div>
                </div>
                <div class="form-group form-material">
                    <div class="col-sm-3 control-label">NO TPFT</div>
                    <div class="col-sm-9">
                         <input type="text" name="NO_TPFT" id="NO_TPFT" mandatory="yes" class="form-control">
                    </div>
                </div>
                <div class="form-group form-material">
                  <div class="col-sm-3 control-label">TANGGAL TPFT</div>
                  <div class="col-sm-9">
                    <input type="text" name="DATA[TGL_TPFT]" id="TGL_TPFT" mandatory="no" class="form-control date" placeholder="" value="<?php //echo $arrdata[0]->ALAMAT_CONSIGNEE; ?>" maxlength="10">
                </div>
              </div>

            <div class="col-md-12">
            	<div>&nbsp;</div>
            	<input type="hidden" name="indexkon" id="indexkon" readonly="readonly"/>
            	<center><button class="btn btn-sm btn-primary" onclick="addcont2()" type="button"><i class="icon-plus"></i> ADD</button></center>
            </div>
            <div class="col-md-12">
            	<div>&nbsp;</div>
            	<table class="tabelajax" id="tablekon">
                	<thead>
                        <tr class="headcontent">
                            <th width="100px;" align="center">&nbsp;</th>
                            <th>NO. CONTAINER</th>
                            <th>UKURAN</th>
                            <th>ISO CODE</th>
                            <th>TIPE</th>
                            <th>NO. TPFT</th>
							              <th>TANGGAL TPFT</th>
                        </tr>
                    </thead>
					<?php if($array_cont!=""): ?>
					<tbody>
                    	<?php $tmpindexkon = 1 ;
						if(count($array_cont)==0) { ?>
                        <tr id="cont_null">
                            <td colspan="13" class="alt"><center>Tidak Terdapat Data</center></td>
                        </tr>
                        <?php } else {
						foreach($array_cont as $cont){
							$indexkon .= ",".$tmpindexkon; ?>
                        	<tr id="cont_<?php echo $tmpindexkon; ?>">
                            	<td width="100px;" align="center">
                                	<button class="btn" type="button" title="Hapus Data" onclick="hapuscont('<?php echo $tmpindexkon; ?>')">
                                    	<i class="icon-trash"> Hapus</i>
                                    </button>
                                </td>
                                <td class="alt">
									<?php echo $cont['KONTAINER']; ?>
                                    <input type="hidden" readonly="readonly" name="CONT<?php echo $tmpindexkon; ?>[KONTAINER]" id="KONTAINER" value="<?php echo $cont['KONTAINER']; ?>" duplicate="no"/>
                                </td>
                                <td class="alt">
									<?php echo $cont['UKURAN']; ?>
                                    <input type="hidden" readonly="readonly" name="CONT<?php echo $tmpindexkon; ?>[UKURAN]" id="UKURAN" value="<?php echo $cont['UKURAN']; ?>"/>
                                </td>
                                <td class="alt">
									<?php echo $cont['ISO']; ?>
                                    <input type="hidden" readonly="readonly" name="CONT<?php echo $tmpindexkon; ?>[ISO]" id="ISO" value="<?php echo $cont['ISO']; ?>"/>
                                </td>
                                <td class="alt">
									<?php echo $cont['TIPE']; ?>
                                    <input type="hidden" readonly="readonly" name="CONT<?php echo $tmpindexkon; ?>[TIPE]" id="TIPE" value="<?php echo $cont['TIPE']; ?>"/>
                                </td>
                                <td class="alt">
									<?php echo $cont['NO_TPFT']; ?>
                                    <input type="hidden" readonly="readonly" name="CONT<?php echo $tmpindexkon; ?>[NO_TPFT]" id="NO_TPFT" value="<?php echo $cont['NO_TPFT']; ?>"/>
                                </td>
                                <td class="alt">
									<?php echo $cont['TGL_TPFT']; ?>
                                    <input type="hidden" readonly="readonly" name="CONT<?php echo $tmpindexkon; ?>[TGL_TPFT]" id="TGL_TPFT" value="<?php echo $cont['TGL_TPFT']; ?>"/>
                                </td>


                            </tr>
                        <?php $tmpindexkon++; } } ?>
                    </tbody>
					<?php else : ?>
                    <tbody>
                        <tr id="cont_null">
                            <td colspan="13" class="alt"><center>Tidak Terdapat Data</center></td>
                        </tr>
                    </tbody>
					<?php endif; ?>
                </table>
            </div>
        </div>

			</div>
          <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('planning/manual/post'); ?>"/>
        </form>
      </div>
    </div>
  </div>
  <?php
	//echo $jadwal;
  ?>
</div>
<script>
$(function(){
	date('date');
	autocomplete('NM_KAPAL','/popup/autocomplete/mst_kapal',function(event, ui){
    $('#NM_KAPAL').val(ui.item.label);
		$('#VOYAGE').val(ui.item.NO_VOY);
		$('#TGL_TIBA').val(ui.item.TGL_TIBA);
		
	});
	/*autocomplete('KD_PEL_MUAT','/popup/autocomplete/mst_port/kode',function(event, ui){
		$('#PELABUHAN_MUAT').val(ui.item.NAMA);
	});
	autocomplete('PELABUHAN_MUAT','/popup/autocomplete/mst_port/nama',function(event, ui){
		$('#KD_PEL_MUAT').val(ui.item.KODE);
	});
	autocomplete('KD_PEL_TRANSIT','/popup/autocomplete/mst_port/kode',function(event, ui){
		$('#PELABUHAN_TRANSIT').val(ui.item.NAMA);
	});
	autocomplete('PELABUHAN_TRANSIT','/popup/autocomplete/mst_port/nama',function(event, ui){
		$('#KD_PEL_TRANSIT').val(ui.item.KODE);
	});
	autocomplete('KD_PEL_BONGKAR','/popup/autocomplete/mst_port/kode',function(event, ui){
		$('#PELABUHAN_BONGKAR').val(ui.item.NAMA);
	});
	autocomplete('PELABUHAN_BONGKAR','/popup/autocomplete/mst_port/nama',function(event, ui){
		$('#KD_PEL_BONGKAR').val(ui.item.KODE);
	});*/
});
</script>
