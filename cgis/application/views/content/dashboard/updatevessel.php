<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Dashboard Rekon</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

    <!-- Fonts and icons -->
    <script src="<?php echo base_url();?>assets/assets_dashboard/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": [
                    "Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ['<?php echo base_url();?>assets/assets_dashboard/css/fonts.min.css']
            },
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/assets_dashboard/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/assets_dashboard/css/atlantis.min.css">

</head>

<body>
    <div class="wrapper static-sidebar">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="blue">

                <a href="<?php echo base_url();?>application.php/PortalDashboard" class="logo">
                    <!-- <img src="../assets/img/logo.svg" alt="navbar brand" class="navbar-brand">
                        -->
                    <h2 class="navbar-brand" style="color: aliceblue;">BOS</h2>
                </a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
                    data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>
                <button class="topbar-toggler more">
                    <i class="icon-options-vertical"></i>
                </button>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="icon-menu"></i>
                    </button>
                </div>
            </div>
            <!-- End Logo Header -->

            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2"></nav>
            <!-- End Navbar -->
        </div>

        <div class="classic-grid">
            <!-- Sidebar -->
            <?php include 'sidebar.php';?>
            <!-- End Sidebar -->

            <div class="main-panel">
                <div class="content">
                    <div class="panel-header bg-primary-gradient">
                        <div class="page-inner py-5"></div>
                    </div>

                    <div class="page-inner mt--5">
                        <div class="row row-card-no-pd mt--2">
                            <div class="col-md-12">
                                <?php
                                $msg = $this->session->flashdata('msg');
                                if ($msg['stat'] == '1') {
                                    echo '<div class="alert alert-success">
                                    <strong>Success!</strong> '.$msg['msg'].'
                                </div>';
                                }else if ($msg['stat'] == '2') {
                                    echo '<div class="alert alert-danger">
                                    <strong>Error!</strong> Error '.$msg['msg'].'
                                </div>';
                                }
                            ?>
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Update Vessel</h4>
                                    </div>
                                    <div class="card-body">
                                        <p>Menu ini digunakan untuk mengupdate vessel dengan keperluan memperbaiki tanggal stacking yang gagal saat user melakukan pengajuan</p>
                                        <p>Dokumen yang digunakan adalah dokumen pemeriksaan (SPJM / SPPMP atau dokumen yang lainnya sesuai request customer)</p>
                                        <p>Sesuaikan data vessel dengan data yang ada di ajuan user misal :</p>
                                        <p>user mengajukan dengan kapal BANTENG 01S, maka update data kontainer dibawah dengan BANTENG 01S</p>
                                        <p>Setelah diupdate, lakukan sinkronisasi discharge di menu stacking pada data kapal</p>
                                        <form action="" method="get">
                                            <div class="col-md-12">
                                                <div class="col-xs-3" style="margin-bottom: 10px;">
                                                    No Dokumen Ajuan <input type="text" name="dok" value=""
                                                        class="form-control" placeholder="NO SPJM/SPPMP" style="margin-bottom: 10px;;">
                                                </div>
                                                <div class="col-xs-3" style="margin-bottom: 10px;">
                                                    Tanggal <input type="text" name="tgl" value=""
                                                        class="form-control" placeholder="Isi dengan Tahun - Bulan Tanggal. misal=(2022-08-01)" style="margin-bottom: 10px;;">
                                                </div>
                                                <div class="col-xs-3" style="margin-bottom: 10px;">
                                                    <button type="submit" class="btn btn-primary">Search</button>
                                                </div>
                                            </div>
                                        </form>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>No DOK</th>
                                                    <th>TGL</th>
                                                    <th>No CONT</th>
                                                    <th>DISCHARGE</th>
                                                    <th>VESSEL</th>
                                                    <th>CALL SIGN</th>
                                                    <th>VOYAGE IN</th>
                                                    <th>VOYAGE OUT</th>
                                                    <th>Option</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <?php
                                                    // var_dump($search);die();
                                                    $datdok = $datser['nod'];
                                                    $dattgl = $datser['tgl'];
                                                    // var_dump($dattgl);die();
                                                    if ($search != NULL) {
                                                        foreach ($search as $key) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $key->ID?></td>
                                                            <td><?php echo $key->NO_DOK?></td>
                                                            <td><?php echo $key->TGL_DOK?></td>
                                                            <td><?php echo $key->NO_CONT?></td>
                                                            <td><?php echo $key->DISCHARGE?></td>
                                                            <td><?php echo $key->VESSEL?></td>
                                                            <td><?php echo $key->CALL_SIGN?></td>
                                                            <td><?php echo $key->VOY_IN?></td>
                                                            <td><?php echo $key->VOY_OUT?></td>
                       
                                                            <td><button class='btn btn-warning' id='modalPlug' onclick="plug_update('<?php echo $key->ID?>','<?php echo $key->NO_CONT?>','<?php echo $key->DISCHARGE?>','<?php echo $key->VESSEL?>','<?php echo $key->CALL_SIGN?>','<?php echo $key->VOY_IN?>','<?php echo $key->VOY_OUT?>')">Proses</button></td>
                                                        </tr>
                                                    <?php
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Tanggal Plug in Terminal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" id="foo">
            <div class="modal-body">
            <input class="form-control" type="text" id="id" name="id" placeholder="" style="margin: 10px;" readonly>
            <label>Container</label>
            <input class="form-control" type="text" id="cont" name="cont" placeholder="" style="margin: 10px;" readonly>
            <label>Discharge</label>
            <input class="form-control" type="text" id="discharge" name="discharge" placeholder="" style="margin: 10px;">
            <label>Vessel</label>
            <input class="form-control" type="text" id="vessel" name="vessel" placeholder="" style="margin: 10px;">
            <label>Call Sign</label>
            <input class="form-control" type="text" id="callsign" name="callsign" placeholder="" style="margin: 10px;">
            <label>Voy In</label>
            <input class="form-control" type="text" id="voyin" name="voyin" placeholder="" style="margin: 10px;">
            <label>Voy Out</label>
            <input class="form-control" type="text" id="voyout" name="voyout" placeholder="" style="margin: 10px;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="btn_upt_plug" onclick="submit_plug()" class="btn btn-primary">Update</button>
            </div>
        </form>
      </div>      
    </div>
  </div>
</div>
    </div>
    <!-- Core JS Files -->
    <script src="<?php echo base_url();?>assets/assets_dashboard/js/core/jquery.3.2.1.min.js"></script>
    <script src="<?php echo base_url();?>assets/assets_dashboard/js/core/popper.min.js"></script>
    <script src="<?php echo base_url();?>assets/assets_dashboard/js/core/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/assets_dashboard/js/plugin/datatables/datatables.min.js"></script>
    <script>       
            function plug_update(id, no_cont, discharge, vessel, callsign, voyin, voyout) {                    
                $('#exampleModal').modal();
                    $('#id').val(id);
                    $('#cont').val(no_cont);                  
                    $('#discharge').val(discharge);                  
                    $('#vessel').val(vessel);                  
                    $('#callsign').val(callsign);                  
                    $('#voyin').val(voyin);                  
                    $('#voyout').val(voyout);                  
                }
            function submit_plug(){

                var id = $('#id').val();
                var no_cont = $('#cont').val(); 
                var discharge = $('#discharge').val(); 
                var vessel = $('#vessel').val(); 
                var callsign = $('#callsign').val(); 
                var voyin = $('#voyin').val(); 
                var voyout = $('#voyout').val(); 

                $.ajax({
		            url: "commitupdatevessel",
		            method: "POST",
		            data: {
		              id: id,
                      no_cont: no_cont,
                      discharge: discharge,
                      vessel: vessel,
                      call_sign: callsign,
                      voy_in: voyin,
		              voy_out: voyout,
		            },
		            success: function(data) {		
                        location.reload();	              
		            }
		          });
            }    
    </script>
</body>

</html>