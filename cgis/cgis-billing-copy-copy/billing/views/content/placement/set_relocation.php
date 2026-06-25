<?php //print_r($arrdata);die(); ?>
<!--<link rel="stylesheet" href="<?php //echo base_url() ?>assets/css/style.css">-->
<script src="<?php echo base_url() ?>assets/js/denah.js"></script>
<style>
.btn-circle{
    border-radius: 71%;
    width: 100px;
    height: 100px;
    border: 5px solid #000;
    margin: 30px;
}
</style>
<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
  	<span class="ribbon-inner">
		<i class="icon md-boat margin-0" aria-hidden="true"></i> <?php echo "Set Relocation"; ?>
    </span>
  </div>
  <div class="panel-body container-fluid">
  <div class="panel-body">
		<!----><div align="center">
			<h1>&nbsp;</h1>
		</div>
  	<div class="row">
		<div class="col-md-6">
          <!-- Example Panel Fullscreen -->
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">DATA</h3>
            </div>
            <div class="panel-body">
              <div class="col-sm-6 col-lg-6">
              <!-- Example User -->
              <div class="example-wrap margin-lg-0">
                <ul class="list-group list-group-full">
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-body">
                        <h4 class="media-heading">NP. KONTAINER</h4>
                        <small><?php echo $arrdata['NO_CONT']; ?></small>
                      </div>
                      <div class="media-right">
                        <span class="status status-lg status-online"></span>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-body">
                        <h4 class="media-heading">UKURAN</h4>
                        <small><?php echo $arrdata['UKR_CONT']; ?></small>
                      </div>
                      <div class="media-right">
                        <span class="status status-lg status-busy"></span>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-body">
                        <h4 class="media-heading">LOKASI AWAL</h4>
                        <small><?php echo "<h4><span class='label label-success'>".$arrdata['LOKASI_AWAL']."<h4></span>"; ?></small>
                      </div>
                      <div class="media-right">
                        <span class="status status-lg status-busy"></span>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-body">
                        <h4 class="media-heading">LOKASI AKHIR</h4>
                        <small><?php echo "<h4><span class='label label-success'>".$arrdata['LOKASI_AKHIR']."<h4></span>"; ?></small>
                        <input type="hidden" name="NO_SPK" id="NO_SPK" value="<?php echo $arrdata['NO_SPK']; ?>">
                      </div>
                      <div class="media-right">
                        <span class="status status-lg status-busy"></span>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
              <!-- End Example User -->
            </div>
            </div>
          </div>
          <!-- End Example Panel Fullscreen -->
        </div>
		<div class="col-md-6">
          <!-- Example Panel Refresh -->
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">KETERANGAN</h3>
            </div>
            <div class="panel-body">
              <div class="col-sm-6 col-lg-6">
              <!-- Example User -->
              <div class="example-wrap margin-lg-0">
                <ul class="list-group list-group-full">
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-body">
                        <div class="list-text">
                            <span class="list-text-name"><span class="label label-success">&nbsp; &nbsp;</span></span>
                            <div class="list-text-info">
                            	<i class="icon-info-sign"></i>
                                	KAPASITAS KURANG DARI SAMA DENGAN 25%
                            </div>
                        </div>
                      </div>
                      <div class="media-right">
                        <span class="status status-lg status-online"></span>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-body">
                        <div class="list-text-info">
                        	<span class="list-text-name"><span class="label label-info">&nbsp; &nbsp;</span></span>
                        	<i class="icon-info-sign"></i>
                           		KAPASITAS LEBIH DARI SAMA DENGAN 25% &amp; KURANG DARI SAMA DENGAN 50%
                        </div>
                      </div>
                      <div class="media-right">
                        <span class="status status-lg status-busy"></span>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-body">
                        	<span class="list-text-name"><span class="label label-warning">&nbsp; &nbsp;</span></span>
                            <div class="list-text-info">
                            	<i class="icon-info-sign"></i>
                                	KAPASITAS LEBIH DARI SAMA DENGAN 50% &amp; KURANG DARI SAMA DENGAN 99%
							</div>
                      </div>
                      <div class="media-right">
                        <span class="status status-lg status-busy"></span>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-body">
                        	<span class="list-text-name"><span class="label label-danger">&nbsp; &nbsp;</span></span>
                            <div class="list-text-info">
                            	<i class="icon-info-sign"></i>
                                	KAPASITAS SAMA DENGAN 100%
							</div>
                      </div>
                      <div class="media-right">
                        <span class="status status-lg status-busy"></span>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
              <!-- End Example User -->
            </div>
            </div>
          </div>
          <!-- End Example Panel Refresh -->
        </div>
	</div>
    	<div class="panel-body">
		  	<div class="row">
        <div id="panel_gudang" align="center"> 
          <?php
            //$arrdata['LOKASI_AKHIR'] = 'test';
            $aksi = "onClick=\"setDenah(this.id)\"";
            /*if($arrdata['LOKASI_AKHIR'] != ''){
              $aksi = '';
            }*/

            foreach ($arrdata_denah as $value) {
              $dt[] = $value;
            }
            for ($i=0; $i < count($dt); $i++) { 
              $arrExp = explode(",", $dt[$i]['KD_GUDANG_DTL']); 
              echo "<input type=\"button\" class=\"btn-circle button_contact\" value=\"$arrExp[0]\" id=$arrExp[0] $aksi>";
            }
          ?>
        </div>
        <div id="panel_denah" style="display:none;">
          <!-- <div id="restDenah"></div> -->
        </div>
		  	</div>
    	</div>
    </div>
   <div id="restDenah" align="center"></div>
      
  </div>
</div>

<!-- Modal -->
  <div class="modal fade ModalDetail" id="" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <button type="button" class="close"
             data-dismiss="modal">
               <span aria-hidden="true">&times;</span>
               <span class="sr-only">Close</span>
          </button>
          <h4 class="modal-title" id="myModalLabel">
             UPDATE LOKASI
          </h4>
        </div>

        <!-- Modal Body -->
        <div class="modal-body">

        <form class="form-horizontal" id="modalPopup" action="" method="post" role="form">
          <div class="form-group">
            <label  class="col-sm-2 control-label"
                  for="KODE">KODE</label>
            <div class="col-sm-10">
              <input type="text" class="form-control"
              id="KODE_GDG" value="<?php //echo $arrdata[0]['KD_GUDANG_DTL']; ?>" name="KODE_GDG" readonly  placeholder="KODE"/>
            </div>
            </div>
            <div class="form-group">
              <label  class="col-sm-2 control-label"
                    for="inputEmail3">BLOK</label>
              <div class="col-sm-10">
                <input type="text" name="blok_gdg" class="form-control"
                id="blok_gdg" value="<?php //echo $arrdata[0]['KD_GUDANG_DTL']; ?>" readonly placeholder="BLOK"/>
              </div>
              <input type="hidden" name="kd_gdg" id="kd_gdg" value="<?php echo $arrdata[0]['KD_GUDANG_DTL']; ?>">
			  <input type="hidden" name="id_job" id="id_job" value="<?php echo $arrdata['ID_JOB_SLIP']; ?>">
			  <input type="hidden" name="LOK_AKHIR_LOCATION" id="LOK_AKHIR_LOCATION" value="<?php echo $arrdata['LOKASI_AKHIR']; ?>">
			  <input type="hidden" name="TIER_AKHIR_LOCATION" id="TIER_AKHIR_LOCATION" value="<?php echo $arrdata['TIER_AKHIR']; ?>">
              <input type="hidden" name="X" id="X" value="<?php //echo $arrdata[0]['KD_GUDANG_DTL']; ?>">
              <input type="hidden" name="Y" id="Y" value="<?php //echo $arrdata[0]['KD_GUDANG_DTL']; ?>">
            </div>
            <div class="form-group">
              <label  class="col-sm-2 control-label"
                    for="KODE">NO. KONTAINER</label>
              <div class="col-sm-10">
                <input type="text" class="form-control"
                id="NO_CONT" value="<?php echo $arrdata['NO_CONT']; ?>" name="NO_CONT" readonly/>
              </div>
            </div>
            <div class="form-group">
              <label  class="col-sm-2 control-label"
                    for="KODE">LOKASI AKHIR</label>
              <div class="col-sm-10">
                <input type="text" class="form-control"
                id="LOK_AKHIR" value="<?php //echo $arrdata[0]['KD_GUDANG_DTL']; ?>" name="LOK_AKHIR" readonly/>
              </div>
            </div>
            <div class="form-group">
            <label class="col-sm-2 control-label"
                for="inputPassword3" >TIER</label>
            <div class="col-sm-10">
             
              <div id="selectOpt"></div>
             <div id="PENUMPUKAN"></div>
             <!--  <input type="text" class="form-control"
               id="callTier" value="<?php //echo $arrdata[0]['KD_GUDANG_DTL']; ?>" name="callTier" readonly/> 
                
              <select class="form-control focus" id="PENUMPUKAN">-->
              <!-- <option id="selectOpt" value=""></option> -->
              <!-- <div id="selectOpt"></div> -->
               <!--  <option value="<?php //echo $arrdata['KD_TIPE_GUDANG'] ?>"><?php //echo $arrdata['KD_TIPE_GUDANG'] ?></option> -->
                <!-- <option id="callTier2" value=""></option> -->
                <?php 
                 /* $tier = "<div id=\"callTier2\"></div>";
                  $n = 4;

                  for ($i=1; $i <= $n ; $i++) { 
                      echo "<option value=$i>$i</option>";
                  }*/
                 // echo "<br>";
                ?> <!-- 
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option> 
              </select>-->
            </div>
            </div>
            <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="checkbox">
              <label>
                <!--<input type="checkbox"/> Remember me-->
              </label>
              </div>
            </div>
            </div>
            <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <!--<button type="submit" class="btn btn-default">Sign in</button>-->
            </div>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-default"
                  data-dismiss="modal">
                    Close
              </button>
              <button type="button" id="addContPlanRelocation" class="btn btn-primary">
                Save changes
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div><!-- tutup modal -->
<script>
	function setDenah(id){
		//alert(id);return false;
   /* if($('#panel_gudang').css('display')!='none'){
      $('#panel_denah').html('Here is my dynamic content').show().siblings('div').hide();
      $.ajax({
        type : 'post',
        url: site_url+'/setting/getGudang',
        data: {id:id},
        success:function(data){
          //$.('#restDenah').html(data);
          document.getElementById("restDenah").innerHTML = data;
          //console.log(data);
        }
      });
    }else if($('#panel_denah').css('display')!='none'){
        $('#panel_denah').show().siblings('div').hide();
    }*/

    /*return false;*/

    $.ajax({
      type : 'post',
      url: site_url+'/setting/getGudang',
      data: {id:id},
      success:function(data){
        //$.('#restDenah').html(data);
        document.getElementById("restDenah").innerHTML = data;
        //console.log(data);
      }
    });
	}

	$(function(){
		date('date');
	});
</script>