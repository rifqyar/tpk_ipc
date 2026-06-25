<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <title>Dashboard Rekon</title>
        <meta
            content='width=device-width, initial-scale=1.0, shrink-to-fit=no'
            name='viewport'/>

        <!-- Fonts and icons -->
        <script
            src="<?php echo base_url();?>assets/assets_dashboard/js/plugin/webfont/webfont.min.js"></script>
        <script>
            WebFont.load({
                google: {
                    "families": ["Lato:300,400,700,900"]
                },
                custom: {
                    "families": [
                        "Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"
                    ],
                    urls: ['<?php echo base_url();?>assets/assets_dashboard/css/fonts.min.css']
                },
                active: function () {
                    sessionStorage.fonts = true;
                }
            });
        </script>

        <!-- CSS Files -->
        <link
            rel="stylesheet"
            href="<?php echo base_url();?>assets/assets_dashboard/css/bootstrap.min.css">
        <link
            rel="stylesheet"
            href="<?php echo base_url();?>assets/assets_dashboard/css/atlantis.min.css">

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
                    <button
                        class="navbar-toggler sidenav-toggler ml-auto"
                        type="button"
                        data-toggle="collapse"
                        data-target="collapse"
                        aria-expanded="false"
                        aria-label="Toggle navigation">
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
                <nav
                    class="navbar navbar-header navbar-expand-lg"
                    data-background-color="blue2"></nav>
                <!-- End Navbar -->
            </div>

            <div class="classic-grid">
                <!-- Sidebar -->
                <?php include 'sidebar.php';?>
                <!-- End Sidebar -->

                <div class="main-panel">
                    <div class="content">
                        <div class="panel-header bg-primary-gradient">
                            <div class="page-inner py-5">
                                <div
                                    class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                                    <div>
                                        <h5 class="text-white op-7 mb-2">Dashboard Rekon MTI x NPCT1 (Semua data ini di
                                            rekon dari minus 10 hari (-10 day))</h5>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="page-inner mt--5">
                            <div class="row row-card-no-pd mt--2">
                                <div class="col-sm-6 col-md-3">
                                    <div class="card card-stats card-round">
                                        <div class="card-body ">
                                            <div class="row">
                                                <div class="col-5">
                                                    <div class="icon-big text-center">
                                                        <i class="flaticon-chart-pie text-warning"></i>
                                                    </div>
                                                </div>
                                                <div class="col-7 col-stats">
                                                    <a href="?tab=1">
                                                        <div class="numbers">
                                                            <p class="card-category">DRAFF (N)</p>
                                                            <h4 class="card-title"><?php echo $chart[0];?></h4>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="card card-stats card-round">
                                        <div class="card-body ">
                                            <div class="row">
                                                <div class="col-5">
                                                    <div class="icon-big text-center">
                                                        <i class="flaticon-chart-pie text-warning"></i>
                                                    </div>
                                                </div>
                                                <div class="col-7 col-stats">
                                                    <a href="?tab=2">
                                                        <div class="numbers">
                                                            <p class="card-category">DRAFT (Y)</p>
                                                            <h4 class="card-title"><?php echo $chart[1];?></h4>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="card card-stats card-round">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-5">
                                                    <div class="icon-big text-center">
                                                        <i class="flaticon-chart-pie text-warning"></i>
                                                    </div>
                                                </div>
                                                <div class="col-7 col-stats">
                                                    <a href="?tab=3">
                                                        <div class="numbers">
                                                            <p class="card-category">UNPLUG NULL</p>
                                                            <h4 class="card-title"><?php echo $chart[2];?></h4>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="card card-stats card-round">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-5">
                                                    <div class="icon-big text-center">
                                                        <i class="flaticon-chart-pie text-warning"></i>
                                                    </div>
                                                </div>
                                                <div class="col-7 col-stats">
                                                    <a href="?tab=4">
                                                        <div class="numbers">
                                                            <p class="card-category">Belum Request</p>
                                                            <h4 class="card-title"><?php echo $chart[3];?></h4>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="page-inner mt--5">
                            <div class="row row-card-no-pd mt--2">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Basic</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="basic-datatables" class="display table table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Kontainer</th>
                                                            <th>Ukuran</th>
                                                            <th>Tipe</th>
                                                            <th>Isi</th>
                                                            <th>Vessel</th>
                                                            <th>Disscharge</th>
                                                            <th>Plug</th>
                                                            <th>Unplug</th>
                                                            <th>DG</th>
                                                            <th>Oog</th>
                                                            <th>Stat</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                    foreach ($query as $key => $value) {
                                                        echo "<tr>
                                                        <td>$value->NO_CONT</td>
                                                        <td>$value->UKR_CONT</td>
                                                        <td>$value->TIPE_CONT</td>
                                                        <td>$value->KD_CONT_JENIS</td>
                                                        <td>$value->VESSEL</td>
                                                        <td>$value->DISCHARGE</td>
                                                        <td>$value->PLUG_TERMINAL</td>
                                                        <td>$value->UNPLUG_TERMINAL</td>
                                                        <td>$value->FL_DG</td>
                                                        <td>$value->FL_OOG</td>
                                                        <td>$value->KD_STATUS</td>
                                                        </tr>";
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
            </div>

        </div>
        <!-- Core JS Files -->
        <script
            src="<?php echo base_url();?>assets/assets_dashboard/js/core/jquery.3.2.1.min.js"></script>
        <script
            src="<?php echo base_url();?>assets/assets_dashboard/js/core/popper.min.js"></script>
        <script
            src="<?php echo base_url();?>assets/assets_dashboard/js/core/bootstrap.min.js"></script>
        <script
            src="<?php echo base_url();?>assets/assets_dashboard/js/plugin/datatables/datatables.min.js"></script>
        <script>
            $('#basic-datatables').DataTable({});
        </script>
    </body>
</html>