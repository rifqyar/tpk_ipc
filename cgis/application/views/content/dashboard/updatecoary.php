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
                                        <h4 class="card-title">Basic</h4>
                                    </div>
                                    <div class="card-body">
                                        <p>Update coari adalah sinkronisasi data NPCT1 ke CG, jadi mohon di perhatikan no dokumen dan tanggal dokumen hanya untuk yang masih stay di CG, kalau ada 2 kontainer yang sama dengan id yang berbeda mohon untuk update yang paling besar id nya. Terima Kasih</p>
                                        <p>-Update Plug in Terminal NPCT1</p>
                                        <p>-Update Full / Empty</p>
                                        <p>-Update Kapal</p>
                                        <form action="" method="get">
                                            <div class="col-md-12">
                                                <div class="col-xs-3" style="margin-bottom: 10px;">
                                                    Masukan Data Pencarian <input type="text" name="nodok" value=""
                                                        class="form-control" placeholder="No Dokumen LENGKAP ini contoh SPJM: 111123" style="margin-bottom: 10px;;">
                                                        
                                                </div>
                                                <div class="col-xs-3" style="margin-bottom: 10px;">
                                                    Masukan Data Pencarian <input type="text" name="tgldok" value=""
                                                        class="form-control" placeholder="Tgl Dok diisi tanpa simbol diawali tahun bulan tanggal" style="margin-bottom: 10px;;">
                                                        
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
                                                    <th>KD</th>
                                                    <th>Vesel</th>
                                                    <th>Voy in</th>
                                                    <th>Stacking</th>
                                                    <th>Plug In</th>
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
                                                        foreach ($search as $key => $value) {
                                                            echo "<tr>";
                                                            echo "<td>$value->ID</td>";
                                                            echo "<td>$value->NO_CONT</td>";
                                                            echo "<td>$value->UKR_CONT</td>";
                                                            echo "<td>$value->TIPE_CONT</td>";
                                                            echo "<td>$value->KD_CONT_JENIS</td>";
                                                            echo "<td>$value->VESSEL</td>";
                                                            echo "<td>$value->VOY_IN</td>";
                                                            echo "<td>$value->DISCHARGE</td>";
                                                            echo "<td>$value->PLUG_TERMINAL</td>";
                    
                                                            echo "<td><a class='btn btn-warning' href='".site_url()."/PortalDashboard/upcoari?cont=$value->NO_CONT&id=$value->ID&nodok=$datdok&tgldok=$dattgl'>U</button></td>";
                                                            echo "</tr>";
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
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
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
</body>

</html>