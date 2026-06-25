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
                                        <?php
                                       if ($_GET['err']== 'dokada') {
                                           echo '<div class="alert alert-warning" role="alert" style="background-color: yellow;">
                                           Dokumen yang anda request sudah ada di BOS !!!
                                           </div>';
                                       }
                                       ?>
                                            <form action="<?php echo base_url();?>application.php/PortalDashboard/jionrequest" method="POST">
                                            <input type="hidden" name="type" value="join">
                                            <div class="form-group form-inline">
                                                <label for="inlineinput" class="col-md-2 col-form-label">No AJU</label>
                                                <div class="col-md-10 p-0">
                                                    <input
                                                        type="text"
                                                        class="form-control input-full"
                                                        id="id1"
                                                        name="noaju"
                                                        placeholder="cth: S-I-006741-20201119-000034">
                                                </div>
                                            </div>
                                            <div class="form-group form-inline">
                                                <label for="inlineinput" class="col-md-2 col-form-label">Tanggal AJU</label>
                                                <div class="col-md-10 p-0">
                                                    <input
                                                        type="text"
                                                        class="form-control input-full"
                                                        id="id2"
                                                        name="tglaju"
                                                        placeholder="cth: 2020-11-19">
                                                </div>
                                            </div>
                                            <div class="form-group form-inline">
                                                <label for="inlineinput" class="col-md-2 col-form-label">No Dokumen (BC/Karantina)</label>
                                                <div class="col-md-10 p-0">
                                                    <input
                                                        type="text"
                                                        class="form-control input-full"
                                                        id="id3"
                                                        name="nodok"
                                                        placeholder="cth: 2020.1.0300.0.K05.I.015606" required>
                                                </div>
                                            </div>
                                            <div class="form-group form-inline">
                                                <label for="inlineinput" class="col-md-2 col-form-label">TGL Dokumen (BC/Karantina)</label>
                                                <div class="col-md-10 p-0">
                                                    <input
                                                        type="text"
                                                        class="form-control input-full"
                                                        id="id4"
                                                        name="tgldok"
                                                        placeholder="cth: 2020-11-21" required>
                                                </div>
                                            </div>
                                            <div class="form-group form-inline">
                                                <label for="inlineinput" class="col-md-2 col-form-label">Jenis Dokumen</label>
                                                <div class="col-md-10 p-0">
                                                <select class="form-control input-full" name="jnsdok" id="jnsdokid">
                                                <option value="02102">02102 - Surat Persetujuan Pemindahan Media Pembawa (SP2MP karantina Ikan)</option>
                                                <option value="02103">02103 - Surat Persetujuan Pemindahan Media Pembawa (SP2MP karantina Ikan) – Low Risk </option>
                                                <option value="02104">02104 - Surat Persetujuan Pemindahan Media Pembawa (SP2MP karantina Ikan) – Medium Risk</option>
                                                <option value="02105">02105 - Surat Persetujuan Pemindahan Media Pembawa (SP2MP karantina Ikan) – High Risk</option>
                                                <option value="03102">03102 - Surat Persetujuan Pemindahan Media Pembawa (SP2MP karantina hewan)</option>
                                                <option value="03103">03103 - Surat Persetujuan Pemindahan Media Pembawa (SP2MP karantina hewan) – Low Risk</option>
                                                <option value="03104">03104 - Surat Persetujuan Pemindahan Media Pembawa (SP2MP karantina hewan) – Medium Risk</option>
                                                <option value="03105">03105 - Surat Persetujuan Pemindahan Media Pembawa (SP2MP karantina hewan) – High Risk</option>
                                                <option value="04102">04102 - Surat Persetujuan Pemindahan Media Pembawa (SP2MP karantina tumbuhan)</option>
                                                <option value="04103">04103 - Surat Persetujuan Pemindahan Media Pembawa (SP2MP karantina tumbuhan) – Low Risk</option>
                                                <option value="04104">04104 - Surat Persetujuan Pemindahan Media Pembawa (SP2MP karantina tumbuhan) – Medium Risk</option>
                                                <option value="04105">04105 - Surat Persetujuan Pemindahan Media Pembawa (SP2MP karantina tumbuhan) – High Risk</option>
                                                </select>
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
                                                        <th scope="col">NO AJU</th>
                                                        <th scope="col">TGL AJU</th>
                                                        <th scope="col">Respon</th>
                                                        <th scope="col">Timestamp</th>
                                                        <th scope="col">BOS</th>
                                                        <th>-</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                foreach ($log_data as $key => $value) {
                                                    $tambahan = explode('#',$value->tambahan);
                                                    echo "<tr>
                                                    <td><button class='btn btn-primary' title='$value->url'>info</button></td>
                                                    <td>$value->no_dok</td>
                                                    <td>$value->tgl_dok</td>
                                                    <td>$value->data_respons</td>
                                                    <td>$value->tgl</td>";
                                                    if ($value->LNSW_NOAJU != "") {
                                                        echo "<td><button class='btn btn-success'>+</button></td>";
                                                    }else{
                                                        echo "<td><button class='btn btn-warning'>-</button></td>";
                                                    }
                                                    echo '<td><button class="btn btn-error" onClick="masuk(\''.$value->no_dok.'\',\''.$value->tgl_dok.'\',\''. $tambahan[0].'\',\''. $tambahan[1].'\',\''. $tambahan[2].'\')">E</button></td></td>';
                                                echo "</tr>";
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
        <script>
            function masuk(a,b,c,d,e){
                $('#id1').val(a);
                $('#id2').val(b);
                $('#id3').val(c);
                $('#id4').val(d);
                $('#id5').val(e);
                $('#jnsdokid option[value='+e+']').attr('selected','selected');
                console.log(e);
            }
        </script>
    </body>
</html>