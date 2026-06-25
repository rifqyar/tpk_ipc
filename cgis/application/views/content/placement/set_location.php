<script src="<?php echo base_url() ?>assets/js/denah.js"></script>
<style>
.btn-circle{
    border-radius: 71%;
    width: 100px;
    height: 100px;
    border: 5px solid #000;
    margin: 30px;
}
.se-pre-con {
  position: fixed;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background: url("<?php echo base_url(); ?>assets/images/loading.gif") center no-repeat #fff;
}
</style>
<div class="panel">
  <div id='loadingmessage' style='display:none' class='se-pre-con' align="center"></div>
  <div class="ribbon ribbon-clip ribbon-primary">
    <span class="ribbon-inner">
    <i class="icon md-boat margin-0" aria-hidden="true"></i> <?php echo "SET REALISASI"; ?>
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
                        <h4 class="media-heading">NO. KONTAINER</h4>
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
                        <small>
                        <?php if ($arrdata['LOKASI_AWAL'] == "") {
                          echo "<h4><span class='label label-success'>BELUM ADA LOKASI<h4></span>" ;
                        }else{
                          echo "<h4><span class='label label-success'>".$arrdata['LOKASI_AWAL']."<h4></span>";
                        }
                        ?>
                        </small>
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
                        <small>
                        <?php if ($arrdata['LOKASI_AKHIR'] == "") {
                          echo "<h4><span class='label label-success'>BELUM ADA LOKASI<h4></span>" ;
                        }else{
                          echo "<h4><span class='label label-success'>".$arrdata['LOKASI_AKHIR']."<h4></span>";
                        }
                        ?>
                        </small>
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
            $aksi = "onClick=\"setDenah(this.id)\"";
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
               <span class="sr-only">CLOSE</span>
          </button>
          <h4 class="modal-title" id="myModalLabel">
             TAMBAH
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
              id="KODE_GDG" value="" name="KODE_GDG" readonly  placeholder="KODE"/>
            </div>
            </div>x
            <div class="form-group">
              <label  class="col-sm-2 control-label"
                    for="inputEmail3">BLOK</label>
              <div class="col-sm-10">
                <input type="text" name="blok_gdg" class="form-control"
                id="blok_gdg" value="<?php //echo $arrdata[0]['KD_GUDANG_DTL']; ?>" readonly placeholder="BLOK"/>
              </div>
              <input type="hidden" name="ID_JOB" id="ID_JOB" value="<?php echo $arrdata['ID_JOB_SLIP']; ?>">
              <input type="hidden" name="KD_GDG" id="KD_GDG" value="<?php echo $arrdata[0]['KD_GUDANG_DTL']; ?>">
              <input type="hidden" name="JNS_KEGIATAN" id="JNS_KEGIATAN" value="<?php echo $arrdata['JNS_KEGIATAN']; ?>">
              <input type="hidden" name="LOKASI_AWAL" id="LOKASI_AWAL" value="<?php echo $arrdata['LOKASI_AWAL']; ?>">
              <input type="hidden" name="NO_DOK" id="NO_DOK" value="<?php echo $arrdata['NO_DOK']; ?>">
              <input type="hidden" name="X" id="X" value="">
              <input type="hidden" name="Y" id="Y" value="">
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
                id="LOK_AKHIR" value="" name="LOK_AKHIR" readonly/>
              </div>
            </div>
            <div class="form-group">
            <label class="col-sm-2 control-label"
                for="inputPassword3" >TIER</label>
            <div class="col-sm-10">
             
              <div id="selectOpt"></div>
             <div id="PENUMPUKAN"></div>
             </div>
            </div>
            <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="checkbox">
              <label>
              </label>
              </div>
            </div>
            </div>
            <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
            </div>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-default"
                  data-dismiss="modal">
                    CLOSE
              </button>
              <button type="button" id="addContPlanJob" class="btn btn-primary">
                SAVE CHANGE
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div><!-- tutup modal -->
<script>

  $("#addContPlanJob").click(function(){
    //alert("sini");return false;
    var NO_SPK       = document.getElementById('NO_SPK').value;
    var KODE_GDG     = document.getElementById('KODE_GDG').value;
    var ID_JOB       = document.getElementById('ID_JOB').value;
    var BLOK_GDG     = document.getElementById('blok_gdg').value;
    var LOK_AKHIR    = document.getElementById('LOK_AKHIR').value;
    var NO_CONT      = document.getElementById('NO_CONT').value;
    var PENUMPUKAN   = document.getElementById('PENUMPUKAN').value;
    var NO_DOK       = document.getElementById('NO_DOK').value;
    var JNS_KEGIATAN = document.getElementById('JNS_KEGIATAN').value;
    var LOKASI_AWAL  = document.getElementById('LOKASI_AWAL').value;
    var X            = document.getElementById('X').value;
    var Y            = document.getElementById('Y').value;

    $.ajax({
      type: 'POST',
      url: site_url+'/planning/placement/insertGudang',
      data: { KODE_GDG:KODE_GDG, BLOK_GDG:BLOK_GDG, LOK_AKHIR:LOK_AKHIR, NO_CONT:NO_CONT, PENUMPUKAN:PENUMPUKAN, X:X, Y:Y, NO_SPK:NO_SPK, NO_DOK:NO_DOK, JNS_KEGIATAN:JNS_KEGIATAN, LOKASI_AWAL:LOKASI_AWAL,ID_JOB:ID_JOB },
      success:function(data){
        console.log(data);
        toastr.success("Data Behasil Ditambahkan", "SUCCESS", { "timeOut": "4000"});
      }
    });
    
    $('.ModalDetail').modal('hide');
    setTimeout(function () {
      window.location.href = '<?php echo site_url();?>/planning/placement/plan_placement';
    }, 700);
  });
  
  function setDenah(id){
    $('#loadingmessage').show(); 
    $.ajax({
      type : 'post',
      url: site_url+'/planning/placement/getGudang',
      data: {id:id},
      success:function(data){
    $('#loadingmessage').hide(); 
        document.getElementById("restDenah").innerHTML = data;
      }
    });
  }

  $(function(){
    date('date');
  });
</script>