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
                                        <?php if ($this->session->flashdata('msg')) { ?>
                                            <div class="alert alert-danger"> <?php echo $this->session->flashdata('msg'); ?> </div>
                                        <?php } ?>
                                            <button class="btn btn-primary" onclick="kirim('bhd')">Biling Behandle</button>
                                            <button class="btn btn-primary" onclick="kirim('del')">Biling Delivery</button>
                                            <button class="btn btn-primary" onclick="kirim('ext')">Biling Ext Delivery</button>
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
                                                        <th scope="col">code</th>
                                                        <th scope="col">jenis</th>
                                                        <th scope="col">update</th>
                                                        <th scope="col">user</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                  <?php 
                                                    foreach ($code as $key => $value) {
                                                        if ($value->jenis == 'bhd') {
                                                            $jenis = 'Billing Behandle';
                                                        }elseif ($value->jenis == 'del') {
                                                            $jenis = 'Billing Delivery';
                                                        }elseif ($value->jenis == 'ext') {
                                                            $jenis = 'Billing Ext Delivery';
                                                        }
                                                        echo "<tr>
                                                        <td>$value->kode</td>
                                                        <td>$jenis</td>
                                                        <td>$value->update_at</td>
                                                        <td>$value->user_update</td>
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
        <div
            class="modal fade"
            id="exampleModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       <form action="<?php echo base_url();?>application.php/PortalDashboard/ubahcode" method="POST">
                           <input class="form-control" type="text" name="password" placeholder="Password" required>
                           <input type="hidden" id="jenis" name="jenis" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Ubah</button>
                    </div>
                    </form>
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

            function kirim(params) {
                $('#jenis').val(params);
                $('#exampleModal').modal();
            }
        </script>
    </body>
</html>