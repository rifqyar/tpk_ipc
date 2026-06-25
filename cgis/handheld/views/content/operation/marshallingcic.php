<?php
echo form_open('operation/search_cic');
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets2/style.css?v13">
<div class="container">
    <a href="<?php echo site_url('operation/opr'); ?>"><H4 style="color:white;"><< MENU HANDHELD</H4></a>
    <br>
    <H5 style="color:white;">MARSHALLING CIC</H5>
    <br>
    <div class="form_group form_material">
        <div class="col-sm-4" >
            <input style="border: 1px solid #a1a1a1;"  class="form-control" type="text" name="search_js" placeholder=" SEARCH NO CONTAINER" ><!-- autofocus required> -->
        </div>
        <div class="col-sm-3" >
            <button type="submit" class="btn btn-primary" style=" border: 1px solid #a1a1a1;">SEARCH</button>
            <a href="<?php echo site_url('operation/marshallingcic') ?>" class="btn btn-danger" style="border: 1px solid #a1a1a1;">REFRESH</a>
        </div>
    </div>
</div>

<br><br>
<?php
echo form_close();
if(isset($status)){ 
    if ($status==1) { ?>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div class="panel">
                    <div class="panel-heading" style="">
                    </div>
                    <div class="form-group form-material">
                        <div class="panel-body table-responsive">
                            <table class="table" class="table table-bordered table-hover">
                                <thead>
                                  <tr>
                                      <th style="width:50px;"><H6 style="color:white;">NO</H6></th>
                                      <th style="width:100px"><H6 style="color:white;">ID JOB</H6></th>
                                      <th style="width:200px"><H6 style="color:white;">NO KONTAINER</H6></th>
                                      <th style="width:50px"><H6 style="color:white;">UKURAN</H6></th>
                                      <th style="width:200px;"><H6 style="color:white;">LOKASI AWAL</H6></th>
                                      <th style="width:200px"><H6 style="color:white;">LOKASI AKHIR</H6></th>
                                      <th style="width:200px"><H6 style="color:white;">JOB</H6></th>
                                      <th style="width:200px"><H6 style="color:white;">RESPON</H6></th>
                                      <th style="width:50px"><H6 style="color:white;">PROSES</H6></th>
                                  </tr>
                              </thead>
                              <?php
                              $no=0;
                              foreach ($nilai as $nilai2): 
                                echo form_open('operation/marshallingcic');
                                if(substr($nilai2['LOKASI_AWAL'],0,3)=='CIC'){
                                    $lok=$nilai2['LOKASI_AWAL']."0".$nilai2['TIER_AWAL']; 
                                }else{
                                    $lok=$nilai2['LOKASI_AWAL']."0".$nilai2['TIER_AWAL']; 
                                }
                                if(substr($nilai2['LOKASI_AKHIR'],0,3)=='CIC'){
                                    $lok2=$nilai2['LOKASI_AKHIR']."0".$nilai2['TIER_AKHIR']; 
                                }else{
                                    $lok2=$nilai2['LOKASI_AKHIR']."0".$nilai2['TIER_AKHIR']; 
                                }
                                if($nilai2['RESPON']=='NULL' || $nilai2['RESPON']==''){
                                    $RESPON = "NO RESPON";
                                }else{
                                    $RESPON = $nilai2['RESPON'];
                                }
                                $no++;
                                ?>
                                <tr>
                                    <td><H6 style="font-color:white;"><input type="text" class="form-control" id="no" name="no" value="<?php echo $no; ?>" readonly ></H6></td>
                                    <td><H6 style="color:white;"><input type="text" class="form-control" id="jobs" name="jobs" value="<?php echo $nilai2['ID_JOB_SLIP']; ?>" readonly ></H6></td>
                                    <td><H6 style="color:white;"><input type="text" class="form-control" id="nocont" name="nocont" value="<?php echo $nilai2['NO_CONT']; ?>" readonly ></H6></td>
                                    <td><H6 style="color:white;"><input type="text" class="form-control" id="ukrcont" name="ukrcont" value="<?php echo $nilai2['UKR_CONT']; ?>" readonly ></H6></td>
                                    <td><H6 style="color:white;"><input type="text" class="form-control" id="lokaw" name="lokaw" value="<?php echo $lok; ?>" readonly ></H6></td>
                                    <td><H6 style="color:white;"><input type="text" class="form-control" id="lokak" name="lokak" value="<?php echo $lok2; ?>" ></H6></td>
                                    <td><H6 style="color:white;"><input type="text" class="form-control" id="job" name="job" value="<?php echo $nilai2['JENIS']; ?>" readonly ></H6></td>
                                    <td><H6 style="color:white;"><input type="text" class="form-control" id="respon" name="respon" value="<?php echo $RESPON; ?>" readonly ></H6></td>
                                    <td><H6 style="color:white;"> 
                                         <a href="<?php echo site_url('operation/detailmarshallingscic/'.$nilai2['ID_JOB_SLIP'].'') ?>"  style="text-decoration: none;" type="button" class="btn btn-primary">MARSHALLING</a>
                                    </H6></td>
                                </tr>
                                <?php 
                                echo form_close();
                            endforeach; 
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }
}else { ?>
    <br>
    <div class="container-fluid">
        <?php if (isset($kode)): ?>
            <?php switch ($kode) {
                case 1:
                echo "<br>
                <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
                WARNING ! NO JOB SLIP : $jobs NOT FOUND
                </div>";
                break;
                default:
                echo "";
                break;
            } ?>
        <?php endif ?>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div class="panel">
                    <div class="panel-heading" style="">
                    </div>
                    <div class="form-group form-material">
                        <div class="panel-body table-responsive">
                            <table class="table" class="table table-bordered table-hover">
                                <thead>
                                  <tr>
                                      <th style="width:50px;"><H6 style="color:white;">NO</H6></th>
                                      <th style="width:100px"><H6 style="color:white;">ID JOB</H6></th>
                                      <th style="width:200px"><H6 style="color:white;">NO KONTAINER</H6></th>
                                      <th style="width:50px"><H6 style="color:white;">UKURAN</H6></th>
                                      <th style="width:200px;"><H6 style="color:white;">LOKASI AWAL</H6></th>
                                      <th style="width:200px"><H6 style="color:white;">LOKASI AKHIR</H6></th>
                                      <th style="width:200px"><H6 style="color:white;">JOB</H6></th>
                                      <th style="width:200px"><H6 style="color:white;">RESPON</H6></th>
                                      <th style="width:50px"><H6 style="color:white;">PROSES</H6></th>
                                  </tr>
                              </thead>
                              <?php
                              $no=0;
                              foreach ($nilai as $nilai2): 
                                echo form_open('operation/marshallingcic');
                                if(substr($nilai2['LOKASI_AWAL'],0,3)=='CIC'){
                                    $lok=$nilai2['LOKASI_AWAL']."0".$nilai2['TIER_AWAL']; 
                                }else{
                                    $lok=$nilai2['LOKASI_AWAL']."0".$nilai2['TIER_AWAL']; 
                                }
                                if(substr($nilai2['LOKASI_AKHIR'],0,3)=='CIC'){
                                    $lok2=$nilai2['LOKASI_AKHIR']."0".$nilai2['TIER_AKHIR']; 
                                }else{
                                    $lok2=$nilai2['LOKASI_AKHIR']."0".$nilai2['TIER_AKHIR']; 
                                }
                                if($nilai2['RESPON']=='NULL' || $nilai2['RESPON']==''){
                                    $RESPON = "NO RESPON";
                                }else{
                                    $RESPON = $nilai2['RESPON'];
                                }
                                $no++;
                                ?>
                                <tr>
                                    <td><H6 style="font-color:white;"><input type="text" class="form-control" id="no" name="no" value="<?php echo $no; ?>" readonly ></H6></td>
                                    <td><H6 style="color:white;"><input type="text" class="form-control" id="jobs" name="jobs" value="<?php echo $nilai2['ID_JOB_SLIP']; ?>" readonly ></H6></td>
                                    <td><H6 style="color:white;"><input type="text" class="form-control" id="nocont" name="nocont" value="<?php echo $nilai2['NO_CONT']; ?>" readonly ></H6></td>
                                    <td><H6 style="color:white;"><input type="text" class="form-control" id="ukrcont" name="ukrcont" value="<?php echo $nilai2['UKR_CONT']; ?>" readonly ></H6></td>
                                    <td><H6 style="color:white;"><input type="text" class="form-control" id="lokaw" name="lokaw" value="<?php echo $lok; ?>" readonly ></H6></td>
                                    <td><H6 style="color:white;"><input type="text" class="form-control" id="lokak" name="lokak" value="<?php echo $lok2; ?>" ></H6></td>
                                    <td><H6 style="color:white;"><input type="text" class="form-control" id="job" name="job" value="<?php echo $nilai2['JENIS']; ?>" readonly ></H6></td>
                                    <td><H6 style="color:white;"><input type="text" class="form-control" id="respon" name="respon" value="<?php echo $RESPON; ?>" readonly ></H6></td>
                                    <td><H6 style="color:white;"> 
                                       <a href="<?php echo site_url('operation/detailmarshallingscic/'.$nilai2['ID_JOB_SLIP'].'') ?>"  style="text-decoration: none;" type="button" class="btn btn-primary">MARSHALLING</a>

                                       <!-- <button type="submit"  class="btn btn-primary">MARSHALLING</button> -->
                                   </H6></td>
                               </tr>
                               <?php 
                               echo form_close();
                           endforeach; 
                           ?>
                       </table>
                   </div>
               </div>
           </div>
       </div>
   </div>
<?php }

?>



