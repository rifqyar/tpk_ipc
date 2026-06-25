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
                                        <h4 class="card-title">PLUG ERROR</h4>
                                    </div>
                                    <div class="card-body">
                                        <p>Menu ini digunakan untuk melengkapi data kontainer RFR yang kurang akibat sinkronisasi data dari terminal yang kurang lengkap</p>
                                        <p>pastikan data kontainer yang akan dilengkap bertipe RFR</p>
                                        <form action="" method="get">
                                            <div class="col-md-12">
                                                <div class="col-xs-3" style="margin-bottom: 10px;">
                                                    Masukan Data Pencarian <input type="text" name="cont" value=""
                                                        class="form-control" placeholder="NO CONTAINER" style="margin-bottom: 10px;;">
                                                        
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
                                                    <th>No Cont</th>
                                                    <th>Ukr</th>
                                                    <th>Tipe</th>
                                                    <th>TEMP TERMINAL</th>
                                                    <th>TEMP CUST</th>
                                                    <th>PLUG</th>
                                                    <th>Plug In Terminal</th>
                                                    <th>Unplug Terminal</th>
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
                                                            <td><?php echo $key->NO_CONT?></td>
                                                            <td><?php echo $key->UKR_CONT?></td>
                                                            <td><?php echo $key->TIPE_CONT?></td>
                                                            <td><?php echo $key->TEMP_TERMINAL?></td>
                                                            <td><?php echo $key->TEMP_CUST?></td>
                                                            <td><?php echo $key->FL_REEFER?></td>
                                                            <td><?php echo $key->PLUG_TERMINAL?></td>
                                                            <td><?php echo $key->UNPLUG_TERMINAL?></td>                    
                                                            <td><button class='btn btn-warning' id='modalPlug' onclick="plug_update('<?php echo $key->ID?>','<?php echo $key->NO_CONT?>')">Proses</button></td>
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
            <label>Temperatur</label>
            <input class="form-control" type="text" id="temper" name="temper" placeholder="" style="margin: 10px;">
            <label>Tanggal Plug Terminal</label>
            <input class="form-control" type="datetime-local" id="tgl_plug" name="tgl_plug" placeholder="Tanggal Plug Terminal" style="margin: 10px;" required>
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
            function plug_update(id, no_cont) {                    
                $('#exampleModal').modal();
                    $('#id').val(id);
                    $('#cont').val(no_cont);                  
                }
            function submit_plug(){

                var id = $('#id').val();
                var no_cont = $('#cont').val(); 
                var tgl_plug = $('#tgl_plug').val();  
                var temper = $('#temper').val();  

                $.ajax({
		            url: "fixplugerror",
		            method: "POST",
		            data: {
		              id: id,
		              no_cont: no_cont,
                      tgl_plug: tgl_plug,
                      temper: temper,
		            },
		            success: function(data) {		
                        location.reload();	              
		            }
		          });
            }    
    </script>
</body>

</html>