<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets2/style.css?v13">
<div class="container">
  <a href="<?php echo site_url('operation/opr'); ?>"><H4 style="color:white;"><< MENU HANDHELD</H4></a>
  <br>
    <H5 style="color:white;">JOB ACTIVITY</H5>
    <br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 
    <button class="btn btn-danger" data-toggle="modal" data-target="#tambahjobactivity">TAMBAH</button>
  <br>
  <br>
  <div class="row">
        <div class="col-md-offset-1 col-md-8">
            <div class="panel">
                <div class="panel-heading" style="">
                </div>
                <div class="form-group form-material">
                <div class="panel-body table-responsive">
                    <table class="table" class="table table-bordered table-hover">
                        <thead>
                          <tr>
              <th style="width:50px;"><H6 style="color:white;">NO</H6></th>
              <th style="width:300px"><H6 style="color:white;">Jenis Pekerjaan</H6></th>
              <th style="width:100px"><H6 style="color:white;">Created Date</H6></th>
              <th style="width:100px"><H6 style="color:white;">Created By</H6></th>
              <th style="width:100px"><H6 style="color:white;">Updated By</H6></th>
              <th style="width:100px"><H6 style="color:white;">Updated Date</H6></th>
              <th><H6 style="color:white;"> 
          </tr>
                    </thead>
             <!-- untuk foreach -->
                  <?php
                  $no = 0;
                  foreach ($data->result_array() as $pkrj) :
                    $no++;
                    $jenispekerja = $pkrj['JENIS_PEKERJAAN'];
                    $createddate = $pkrj['CREATED_DATE'];
                    $createdby = $pkrj['CREATED_BY'];
                    $updatedby = $pkrj['UPDATED_BY'];
                    $updateddate = $pkrj['UPDATED_DATE'];
                    ?>
                   <tr>
            <td><H6 style="font-color:white;"><input type="text" class="form-control" id="no" name="no" value="<?php echo $no; ?>" readonly ></H6></td>
            <td><H6 style="color:white;"><input type="text" class="form-control" id="jenispekerja" name="jenispekerja" value="<?php echo $jenispekerja; ?>" readonly ></H6></td>
            <td><H6 style="color:white;"><input type="text" class="form-control" id="createddate" name="createddate" value="<?php echo $createddate; ?>" readonly ></H6></td>
            <td><H6 style="color:white;"><input type="text" class="form-control" id="createdby" name="createdby" value="<?php echo $createdby; ?>" readonly ></H6></td>
            <td><H6 style="color:white;"><input type="text" class="form-control" id="updatedby" name="updatedby" value="<?php echo $updatedby; ?>" readonly ></H6></td>
            <td><H6 style="color:white;"><input type="text" class="form-control" id="updateddate" name="updateddate" value="<?php echo $updateddate; ?>" readonly ></H6></td>
            <td><H6 style="color:white;"> 
              <button type="submit2"  class="btn btn-primary">EDIT</button>
            </H6></td>
              </tr>
              <!-- tutup foreach -->
               <?php 
                        endforeach; 
                    ?>
                     </table>
                </div>
            </div>
           </div>
</div>
<!-- Modal Baru</!-->
<div class="modal fade" id="tambahjobactivity" tabindex="-1" role="dialog" aria-labelledby="newJenisModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newJenisModalLabel">Tambah Kategori</h5>
            </div>
            <form action="<?php echo site_url('operation/tambahjobactivity'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Jenis Kategori</label>
                        <input type="text" class="form-control" id="jenispekerja" name="jenispekerja" placeholder="Jenis Pekerjaan" required="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>