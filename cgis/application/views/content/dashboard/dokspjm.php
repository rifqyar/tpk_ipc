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
                            <div class="page-inner py-5"></div>
                        </div>

                        <div class="page-inner mt--5">
                            <div class="row row-card-no-pd mt--2">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Basic</h4>
                                        </div>
                                        <div class="card-body">
                                            <form
                                                action="<?php echo base_url();?>application.php/PortalDashboard/request_dokumen_spjm"
                                                method="POST">
                                                <input type="hidden" name="type" value="spjmnew">
                                                <div class="form-group form-inline">
                                                    <label for="inlineinput" class="col-md-2 col-form-label">*No Dokumen</label>
                                                    <div class="col-md-10 p-0">
                                                        <input
                                                            type="text"
                                                            class="form-control input-full"
                                                            id="inlineinput"
                                                            name="nodok"
                                                            placeholder="Isi Lengkap"
                                                            required="required">
                                                    </div>
                                                </div>
                                                <div class="form-group form-inline">
                                                    <label for="inlineinput" class="col-md-2 col-form-label">*Tgl Dokumen</label>
                                                    <div class="col-md-10 p-0">
                                                        <input
                                                            type="text"
                                                            class="form-control input-full"
                                                            id="inlineinput"
                                                            name="tgldok"
                                                            placeholder="Isi Tanpa Simbol"
                                                            required="required">
                                                    </div>
                                                </div>
                                                <div class="form-group form-inline">
                                                    <label for="inlineinput" class="col-md-2 col-form-label">NPWP</label>
                                                    <div class="col-md-10 p-0">
                                                        <input
                                                            type="text"
                                                            class="form-control input-full"
                                                            id="inlineinput"
                                                            name="npwp"
                                                            placeholder="Isi Tanpa Simbol">
                                                    </div>
                                                </div>
                                                <div class="card-action">
                                                    <button class="btn btn-success">Submit</button>
                                                </div>
                                            </form>
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
                                            <h4 class="card-title">Log</h4>
                                            <table class="table table-head-bg-primary mt-4">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Req</th>
                                                        <th scope="col">Dokumen</th>
                                                        <th scope="col">Tanggal</th>
                                                        <th scope="col">NPWP</th>
                                                        <th scope="col">Respon</th>
                                                        <th scope="col">Timestamp</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                foreach ($log_data as $key => $value) {
                                                    echo "<tr>
                                                    <td><button class='btn btn-primary' title='$value->url'>info</button></td>
                                                    <td>$value->no_dok</td>
                                                    <td>$value->tgl_dok</td>
                                                    <td>$value->npwp</td>
                                                    <td>$value->data_respons</td>
                                                    <td>$value->tgl</td>
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