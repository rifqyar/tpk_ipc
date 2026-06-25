<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Dashboard Rekon</title>
    <meta
        content='width=device-width, initial-scale=1.0, shrink-to-fit=no'
        name='viewport' />

    <!-- Fonts and icons -->
    <script
        src="<?php echo base_url(); ?>assets/assets_dashboard/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": [
                    "Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"
                ],
                urls: ['<?php echo base_url(); ?>assets/assets_dashboard/css/fonts.min.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link
        rel="stylesheet"
        href="<?php echo base_url(); ?>assets/assets_dashboard/css/bootstrap.min.css">
    <link
        rel="stylesheet"
        href="<?php echo base_url(); ?>assets/assets_dashboard/css/atlantis.min.css">

</head>

<body>
    <div class="wrapper static-sidebar">
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="blue">

                <a href="<?php echo base_url(); ?>application.php/PortalDashboard" class="logo">
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
            <?php include 'sidebar.php'; ?>
            <!-- End Sidebar -->

            <div class="main-panel">
                <div class="content">
                    <div class="panel-header bg-primary-gradient">
                        <div class="page-inner py-5"></div>
                    </div>

                    <div class="panel-header bg-primary-gradient"></div>

                    <div class="page-inner mt--5">

                        <div class="row">

                            <div class="col-md-12">

                                <div class="card">

                                    <div class="card-header">
                                        <h4 class="card-title">Cek Tarif Delivery</h4>
                                    </div>

                                    <div class="card-body">

                                        <form id="formcek">

                                            <div class="form-group form-inline">

                                                <label class="col-md-2 col-form-label">ID Request</label>

                                                <div class="col-md-6 p-0">

                                                    <input type="text"
                                                        class="form-control input-full"
                                                        name="idreq"
                                                        id="idreq"
                                                        placeholder="Contoh: DEL204110"
                                                        required>

                                                </div>

                                                <div class="col-md-2">

                                                    <button class="btn btn-success">Cek</button>

                                                </div>

                                            </div>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-12">

                                <div class="card">

                                    <div class="card-header">
                                        <h4 class="card-title">Preview Perhitungan</h4>
                                    </div>

                                    <div class="card-body">

                                        <table class="table table-bordered" id="resultTable">

                                            <thead>

                                                <tr>

                                                    <th>Container</th>
                                                    <th>Tier</th>
                                                    <th>Start</th>
                                                    <th>End</th>
                                                    <th>Hari</th>
                                                    <th>Tarif</th>
                                                    <th>Total</th>
                                                    <th>Hari Diskon</th>
                                                    <th>Diskon</th>

                                                </tr>

                                            </thead>

                                            <tbody>

                                            </tbody>

                                        </table>

                                        <hr>

                                        <div id="container_summary"></div>
                                        <hr>
                                        <div id="summary"></div>

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
        src="<?php echo base_url(); ?>assets/assets_dashboard/js/core/jquery.3.2.1.min.js"></script>
    <script
        src="<?php echo base_url(); ?>assets/assets_dashboard/js/core/popper.min.js"></script>
    <script
        src="<?php echo base_url(); ?>assets/assets_dashboard/js/core/bootstrap.min.js"></script>
    <script
        src="<?php echo base_url(); ?>assets/assets_dashboard/js/plugin/datatables/datatables.min.js"></script>
    <script>
        $('#basic-datatables').DataTable({});
    </script>
    <script>
        $("#formcek").submit(function(e) {

            e.preventDefault();

            var idreq = $("#idreq").val();

            $.ajax({

                url: "<?php echo base_url(); ?>application.php/ServiceSAP/preview_delivery",
                type: "POST",
                data: {
                    idreq: idreq
                },
                dataType: "json",

                success: function(res) {

                    var tbody = "";
                    var container_summary = "";

                    res.CONTAINER_PREVIEW.forEach(function(cont) {

                        cont.PENUMPUKAN_DETAIL.forEach(function(d) {

                            tbody += "<tr>";

                            tbody += "<td>" + cont.NO_CONT + "</td>";
                            tbody += "<td>" + d.TIER + "</td>";
                            tbody += "<td>" + d.START + "</td>";
                            tbody += "<td>" + d.END + "</td>";
                            tbody += "<td>" + d.HARI + "</td>";
                            tbody += "<td>" + d.TARIF + "</td>";
                            tbody += "<td>" + d.TOTAL + "</td>";
                            tbody += "<td>" + d.HARI_DISKON + "</td>";
                            tbody += "<td>" + d.DISKON + "</td>";

                            tbody += "</tr>";

                        });

                        container_summary += "<br>";
                        container_summary += "<b>Container : " + cont.NO_CONT + "</b><br>";
                        container_summary += "Penumpukan sebelum diskon : " + cont.PENUMPUKAN_SEBELUM_DISKON + "<br>";
                        container_summary += "Diskon : -" + cont.TOTAL_DISKON + "<br>";
                        container_summary += "Penumpukan setelah diskon : <b>" + cont.PENUMPUKAN_SETELAH_DISKON + "</b><br>";
                        container_summary += "<hr>";

                    });

                    $("#resultTable tbody").html(tbody);
                    $("#container_summary").html(container_summary);

                    $("#summary").html(
                        "<b>DPP:</b> " + res.DPP +
                        "<br><b>PPN:</b> " + res.PPN +
                        "<br><b>TOTAL:</b> " + res.TOTAL
                    );

                }

            });

        });
    </script>
</body>

</html>