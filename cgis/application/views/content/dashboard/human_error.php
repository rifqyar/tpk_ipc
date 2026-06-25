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
    
    <!-- konten -->
      <style>
        #loader {
        position: absolute;
        left: 50%;
        top: 50%;
        z-index: 1;
        width: 150px;
        height: 150px;
        margin: -75px 0 0 -75px;
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid blue;
        border-right: 16px solid green;
        border-bottom: 16px solid red;
        width: 120px;
        height: 120px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
      }

      @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
      }

      @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
      }

      /* Add animation to "page content" */
      .animate-bottom {
        position: relative;
        -webkit-animation-name: animatebottom;
        -webkit-animation-duration: 1s;
        animation-name: animatebottom;
        animation-duration: 1s
      }

      @-webkit-keyframes animatebottom {
        from { bottom:-100px; opacity:0 } 
        to { bottom:0px; opacity:1 }
      }

      @keyframes animatebottom { 
        from{ bottom:-100px; opacity:0 } 
        to{ bottom:0; opacity:1 }
      }
      </style>
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
                                            <h4 class="card-title">FORM</h4>
                                        </div>
                                        <?php
                                        echo form_open('PortalDashboard/search_container'); 
                                        ?>
                                        <div class="container">
                                              <H5 style="color:white;">PICK UP</H5><br>
                                              <div class="form_group form_material">
                                                  <div class="col-sm-3 col-md-3"  >
                                                    <input style="border: 1px solid #a1a1a1;"  class="form-control" type="text" name="search_spk" placeholder=" SEARCH NO SPK" autofocus required>
                                                  </div>
                                                  <br>
                                                  <div class="col-sm-1 col-md-1" >
                                                    <button type="submit" class="btn btn-primary" style="border: 1px solid #a1a1a1;">SEARCH</button>
                                                  </div>
                                              </div>
                                         </div>
                                        <hr>
                                        <?php
                                              echo form_close();
                                        ?>
                                        <?php if (isset($notif)): ?>
                                              <?php switch ($notif) {
                                                case 1:
                                                  echo "<br>
                                                  <div class= 'alert alert-primary' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
                                                      NO SPK : $NOSPK SUCCESS PICK UP
                                                  </div>";
                                                  break;
                                                case 2://already
                                                  echo "<br>
                                                  <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
                                                      WARNING ! NO SPK : $NOSPK NOT FOUND
                                                  </div>";
                                                  break;
                                                case 3://already
                                                  echo "<br>
                                                  <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
                                                      WARNING ! NO SPK : $NOSPK BELUM ANNCOUNCE
                                                  </div>";
                                                  break;
                                                  case 4://already
                                                  echo "<br>
                                                  <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
                                                      WARNING ! NO SPK : $NOSPK , TERDAPAT KONTAINER DI BLOK SAMPAH
                                                  </div>";
                                                  break;  
                                                default:
                                                  echo "<br>
                                                  <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
                                                      WARNING ! NO SPK : $NOSPK NOT FOUND
                                                  </div>";
                                                  break;
                                              } ?>
                                            <?php endif ?>

                                              <?php
                                            //echo form_open('operation/pickup');
                                          if(isset($status)){
                                            if ($status==1) { ?>
                                                <div class="container">
                                                  <div class="col-md-6 form-group">
                                                      <label style="color:white;" for="No_cont">NO SPK</label>
                                                      <input type="text" class="form-control" id="No_spk" name="nomerspk" value="<?php echo $spk; ?>" readonly><br>
                                                      <table>
                                                        <tr>
                                                          <th>
                                                            <H6 style="color:white;">NO KONTAINER</H6>
                                                            </th>
                                                            <th class="col-md-1">
                                                              <H6 style="color:white;">UKURAN</H6>
                                                            </th>
                                                          <th>
                                                          <H6 style="color:white;">NOMER TRUCK</H6>
                                                          </th>
                                                          <th>
                                                          <H6 style="color:white;">STATUS</H6>
                                                          </th>
                                                          </tr>
                                                          <?php for ($i=0; $i < $totale; $i++) { ?>
                                                            <tr>
                                                              <td>
                                                                <H6 style="color:white;"><input type="text" class="form-control" value="<?php echo $nilai[$i]['NO_CONT']; ?>" readonly></H6>
                                                              </td>
                                                              <td>
                                                                <H6 style="color:white;"><input type="text" class="form-control" value="<?php echo $nilai[$i]['UKR_CONT']; ?>" readonly></H6>
                                                              </td>

                                                              <td id="fl_send_npct1"><?php

                                                                if ($nilai[$i]['STATUS_CONT'] == '520'||$nilai[$i]['STATUS_CONT'] == '460' && $nilai[$i]['FL_SEND_NPCT1'] == 'Y') {
                                                                  echo '<a class="btn btn-primary sendingnpct1 '.$nilai[$i]['NO_CONT'].'" data-cont="'.$nilai[$i]['NO_CONT'].'" data-nomerspk="'.$spk.'" id="send">Send</a>';
                                                                }else{
                                                                  echo '<a class="btn btn-primary sendingnpct1 '.$nilai[$i]['NO_CONT'].'" data-cont="'.$nilai[$i]['NO_CONT'].'" data-nomerspk="'.$spk.'" id="send">Send</a>';
                                                                }

                                                              ?></td>
                                                            </tr>
                                                          <?php  } ?>
                                                        </table>
                                                          <br>
                                                        <!-- <button style=" width:150px; border: 1px solid #a1a1a1; height: 35px" id="str" type="submit"  class="btn btn-primary">PICKUP</button> -->
                                                  </div>
                                                </div>
                                            <?php ?>
                                        <?php }else { ?>
                                            <div class="container">
                                              <?php if (isset($kode)): ?>
                                                <?php switch ($kode) {
                                                  case 1:
                                                    echo "<br>
                                                    <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
                                                        WARNING ! $spk NOT FOUND
                                                    </div>";
                                                    break;
                                                  default:
                                                    echo "";
                                                    break;
                                                } ?>
                                              <?php endif ?>
                                            </div>
                                            <!-- tutup else -->
                                          <?php } } ?>
                                          <!-- <div id="loader" style="display: none;"></div>-->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="page-inner mt--5">
                            <div class="row row-card-no-pd mt--2">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Log Send</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="basic-datatables" class="display table table-striped table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">NO SPK</th>
                                                        <th scope="col">CONTAINER</th>
                                                        <th scope="col">WAKTU UPDATE</th>
                                                        <th scope="col">USER</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php 
                                                    foreach ($code as $key => $value) {
                                                    
                                                        echo "<tr>
                                                        <td>$value->NO_SPK</td>
                                                        <td>$value->NO_CONT</td>
                                                        <td>$value->WK_UPDATE</td>
                                                        <td>$value->OPERATOR_UPDATE</td>
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
          <script
            src="<?php echo base_url();?>assets/assets_dashboard/js/pickuphuman.js"></script>
    </body>
</html>