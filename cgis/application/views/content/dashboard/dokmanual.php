<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Dashboard Rekon</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

    <!-- Fonts and icons -->
    <script src="<?php echo base_url(); ?>assets/assets_dashboard/js/plugin/webfont/webfont.min.js"></script>
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
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets_dashboard/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets_dashboard/css/atlantis.min.css">

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
            <?php include 'sidebar.php'; ?>
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
                                            action="<?php echo base_url(); ?>application.php/PortalDashboard/requestdokumen"
                                            method="POST">
                                            <input type="hidden" name="type" value="manual">
                                            <div class="form-group form-inline">
                                                <label for="inlineinput" class="col-md-2 col-form-label">*Kode
                                                    Manual</label>
                                                <div class="col-md-10 p-0">
                                                    <!-- <input
                                                        type="text"
                                                        class="form-control input-full"
                                                        id="inlineinput"
                                                        name="noman"
                                                        placeholder="Isi Lengkap" required> -->
                                                        <select name="noman" id="" class="form-control input-full">
                                                        <?php
                                                    foreach ($dok_release as $key => $value1) {
                                                        echo "<option value='" . $value1->ID . "'>" . $value1->ID . " - " . $value1->NAMA . "</option>";
                                                    }
                                                    ?>

    <!-- <option value="10">10 - EMPTY KONTAINER (IMPOR)</option>
    <option value="11">11 - SPPBE (BATAL EKSPOR KONTAINER SUDAH MASUK TPS)</option>
    <option value="12">12 - SPPBE (PINDAH MUAT BARANG EKSPOR)</option>
    <option value="13">13 - PIBK</option>
    <option value="14">14 - RETURNABLE PACKAGE (RP)</option>
    <option value="15">15 - PENIMBUNAN DILUAR KAWASAN PABEAN</option>
    <option value="16">16 - PERSETUJUAN SHORT SHIP</option>
    <option value="17">17 - PERSETUJUAN PART OF (IMPORTIR MITA)</option>
    <option value="18">18 - PERSETUJUAN PART OF (IMPORTIR NON MITA)</option>
    <option value="19">19 - SPJM</option>
    <option value="2">2 - SPPB PIB BC 2.3</option>
    <option value="20">20 - DOKUMEN BC 1.1A / SP3B IMPOR</option>
    <option value="21">21 - PENGELUARAN DENGAN PIB MANUAL (CUKAI)</option>
    <option value="22">22 - PAKET POS</option>
    <option value="23">23 - PENGELUARAN BARANG UNTUK DIMUSNAHKAN</option>
    <option value="24">24 - PENGELUARAN BARANG UNTUK BARANG BUKTI KE PENGADILAN </option>
    <option value="25">25 - PENGELUARAN BARANG HIBAH</option>
    <option value="26">26 - PENGELUARAN BARANG MILIK NEGARA DAN BARANG TIDAK DIKUASAI YANG DILELANG</option>
    <option value="27">27 - PENGELUARAN BARANG PERS RELEASE</option>
    <option value="28">28 - RE-EKSPOR (BC 1.2) BELUM AJU PIB</option>
    <option value="29">29 - PENGELUARAN BARANG EKS PERGANTIAN KONTAINER</option>
    <option value="3">3 - PERSETUJUAN PLP</option>
    <option value="30">30 - PENGELUARAN BARANG PENEGAHAN (SEBAGIAN)</option>
    <option value="31">31 - NHI / PENGELUARAN BARANG PENEGAHAN (SELURUHNYA)</option>
    <option value="32">32 - EMPTY KONTAINER (EKSPOR)</option>
    <option value="33">33 - Dokumen BC. 1.1 B/ SP3B Ekspor</option>
    <option value="34">34 - SPPB BC.12 KPPT</option>
    <option value="35">35 - ATA CARNET Impor</option>
    <option value="36">36 - CPD CARNET Impor</option>
    <option value="37">37 - ATA CARNET Ekspor</option>
    <option value="38">38 - CPD CARNET Ekspor</option>
    <option value="39">39 - Dokumen Pemeriksaan Karantina</option>
    <option value="4">4 - SPPB BC 1.2</option>
    <option value="40">40 - PENGELUARAN KONTAINER EKS STRIPPING</option>
    <option value="41">41 - BC 1.6</option>
    <option value="42">42 - Persetujuan Keluar Barang Kiriman</option>
    <option value="43">43 - SPPBMC</option>
    <option value="44">44 - Dokumen Pengeluaran Barang Impor dengan BC 1.1 Outward Manifes</option>
    <option value="45">45 - NP P3BET</option>
    <option value="5">5 - BCF 2.6A (PEMERIKSAAN DILOKASI IMPORTIR / SPPF)</option>
    <option value="7">7 - PKBE</option>
    <option value="8">8 - PPB</option>
    <option value="80">80 - SPPF[OLD]</option>
    <option value="81">81 - NHI</option>
    <option value="82">82 - NOTA DINAS</option>
    <option value="83">83 - SPPMP</option>
    <option value="84">84 - SPJK</option>
    <option value="85">85 - KT9 / KH12 / KID 5</option>
    <option value="86">86 - RETURNABLE PACKAGE (RP) PELEPASAN</option>
    <option value="9">9 - BCF 1.5 / Barang Tidak Dikuasai</option>
    <option value="58">58 - Penyerahan ke Kementrian/Lembaga Lain</option> -->
    <!-- <option value="99">99 - DOKUMEN PENGELUARAN LAINNYA</option> -->
</select>
                                                </div>
                                            </div>
                                            <div class="form-group form-inline">
                                                <label for="inlineinput" class="col-md-2 col-form-label">*No
                                                    Dokumen</label>
                                                <div class="col-md-10 p-0">
                                                    <input type="text" class="form-control input-full" id="inlineinput"
                                                        name="nodok" placeholder="Isi Lengkap" required>
                                                </div>
                                            </div>
                                            <div class="form-group form-inline">
                                                <label for="inlineinput" class="col-md-2 col-form-label">*Tgl
                                                    Dokumen</label>
                                                <div class="col-md-10 p-0">
                                                    <input type="text" class="form-control input-full" id="inlineinput"
                                                        name="tgldok" placeholder="Isi Tanpa Simbol" required>
                                                </div>
                                            </div>
                                            <div class="form-group form-inline">
                                                <label for="inlineinput" class="col-md-2 col-form-label">NPWP</label>
                                                <div class="col-md-10 p-0">
                                                    <input type="text" class="form-control input-full" id="inlineinput"
                                                        name="npwp" placeholder="Isi Tanpa Simbol">
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
                                                    <th scope="col">Log Penarikan</th>
                                                    <th scope="col">Dokumen</th>
                                                    <th scope="col">Tanggal</th>
                                                    <th scope="col">Respon NPCT</th>
                                                    <th scope="col">Timestamp</th>
                                                    <th>Status Dokumen</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($log_data as $key => $value) {
                                                    echo "<tr>
                                                    <td><a href='" . base_url('application.php/PortalDashboard/lihat_log?id=' . $value->id) . "' target='_blank' class='btn btn-primary'>Buka</a></td>
                                                    <td>$value->no_dok</td>
                                                    <td>$value->tgl_dok</td>
                                                    <td>$value->data_respons</td>
                                                    <td>$value->tgl</td>";

                                                    if ($value->NO_DOK_INOUT != "") {
                                                        echo "<td><button class='btn btn-success'>Sudah Masuk</button></td>";
                                                    } else {
                                                        echo "<td><button class='btn btn-warning'>Belum Masuk</button></td>";
                                                    }

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
    <script src="<?php echo base_url(); ?>assets/assets_dashboard/js/core/jquery.3.2.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/assets_dashboard/js/core/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/assets_dashboard/js/core/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/assets_dashboard/js/plugin/datatables/datatables.min.js"></script>
    <script>
        $('#basic-datatables').DataTable({});
    </script>
</body>

</html>