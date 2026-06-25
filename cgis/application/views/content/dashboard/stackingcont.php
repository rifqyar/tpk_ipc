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
                                        <h5 class="text-white op-7 mb-2">Data Cocoscont</h5>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="page-inner mt--5">
 <!--                            <div class="row row-card-no-pd mt--2">
                                <button class="btn btn-primary" style="margin: 10px;" onclick="sinkron()">Sincronisasi</button>
                            </div> -->

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
                                                            <th>ID</th>
                                                            <th>CALL_SIGN</th>
                                                            <th>VESEL</th>
                                                            <th>VOY</th>
                                                            <th>TGL_TIBA</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($cocos as $key => $value) {
                                                            echo "<tr>
                                                            <td>$value->ID</td>
                                                            <td>$value->CALL_SIGN</td>
                                                            <td>$value->NM_ANGKUT</td>
                                                            <td>$value->NO_VOY_FLIGHT</td>
                                                            <td>$value->TGL_TIBA</td>
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
                        <h5 class="modal-title" id="exampleModalLabel">sinkronisasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="pindahcocos" method="POST" id="foo">
                    <div class="modal-body">
                    <input class="form-control" type="text" id="id" name="id" placeholder="id" style="margin: 10px;" required>
                    <input class="form-control" type="text" id="vesel" name="vesel" placeholder="vesel" style="margin: 10px;" required>
                    <input class="form-control" type="text" id="voy" name="voy" placeholder="voy" style="margin: 10px;" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Sinkron</button>
                    </div>
                    </form>

                    <div id="log" style="margin: 20px;">
                        
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
            $(document).on("submit", "form", function(event)
            {
                let vesel = $('#vesel').val();
                let voy = $('#voy').val();
                let id = $('#id').val();
                event.preventDefault();
                $.ajax({
                    type: "POST",
                    url: 'pindahcocos',
                    data: {vesel:vesel,voy:voy,id:id},
                    success: function(data){
                        $('#log').html(data);
                    }
                });
            });

            

            $(document).ready(function() {
                var table = $('#basic-datatables').DataTable({});
                $('.display').on('click', 'tbody tr', function() {
                    var data = table.row(this).data();
                    console.log(data[0]);
                    $('#vesel').val(data[2]);
                    $('#voy').val(data[3]);
                    $('#id').val(data[0]);
                    $('#exampleModal').modal();
                })
            
            } );

        </script>
    </body>
</html>