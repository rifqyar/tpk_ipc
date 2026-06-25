<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Solver BOS</title>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/bulma/css/main.css">
    </head>
    <body>
        <nav class="navbar is-transparent">
            <div class="navbar-brand">
                <a
                    class="navbar-item"
                    href="<?php echo base_url();?>handheld.php/solverhandheld">
                    <img
                        src="https://bulma.io/images/bulma-logo.png"
                        alt="Bulma: a modern CSS framework based on Flexbox"
                        width="112"
                        height="28">
                </a>
                <div class="navbar-burger burger" data-target="navbarExampleTransparentExample">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>

            <div id="navbarExampleTransparentExample" class="navbar-menu">
                <div class="navbar-start">
                    <a
                        class="navbar-item"
                        href="<?php echo base_url();?>handheld.php/solverhandheld/signout">
                        SignOut
                    </a>
                </div>
            </div>
        </nav>
        <section class="section">
            <div class="container">
                <h1 class="title">
                    CEK PLUG
                </h1>
                <div class="columns is-mobile">
                    <div class="column">
                        <form action="" method="post">
                            <div class="field is-grouped">
                                <p class="control is-expanded">
                                    <input class="input" type="text" name="cont" placeholder="kontainer">
                                </p>
                                <p class="control">
                                    <button type="submit" class="button is-info">
                                        Search
                                    </button>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="columns is-mobile">
                    <div class="column">
                        <div class="table-container">
                            <table class="table">
                            <?php
                               // echo var_dump($treq);
                                if ($treq == "") {
                                    echo "kosong";
                                }else {
                                    //echo count($treq);
                                    if (count($treq) > 0) {
                                        foreach ($treq as $key => $value) {
                                            echo "<tr>
                                        <td>$value->ID</td>
                                        <td>$value->NO_CONT</td>
                                        <td>$value->UKR_CONT</td>
                                        <td>$value->TIPE_CONT</td>
                                        <td>$value->KD_CONT_JENIS</td>
                                        <td>$value->VESSEL</td>
                                        <td>$value->CALL_SIGN</td>
                                        <td>$value->ISO_CODE</td>
                                        <td>$value->BRUTO</td>
                                        <td>$value->VOY_IN</td>
                                        <td>$value->VOY_OUT</td>
                                        <td>$value->POD1</td>
                                        <td>$value->POD2</td>
                                        <td>$value->CLOSING_TIME</td>
                                        <td>$value->DISCHARGE</td>
                                        <td>$value->IMO</td>
                                        <td>$value->TEMP_CUST</td>
                                        <td>$value->TEMP_TERMINAL</td>
                                        <td>$value->PLUG_TERMINAL</td>
                                        <td>$value->UNPLUG_TERMINAL</td>
                                        <td>$value->WK_GATEOUT</td>
                                        <td>$value->FL_IMO</td>
                                        <td>$value->FL_DG</td>
                                        <td>$value->FL_REEFER</td>
                                        <td>$value->FL_OOG</td>
                                        <td>$value->FL_YARD</td>
                                        <td>$value->HOLD</td>
                                        <td>$value->NO_BL_AWB</td>
                                        <td>$value->TAR</td>
                                        <td>$value->FLAG_STATUS</td>
                                        <td>$value->FLAG_FINISH_PRINT</td>
                                        <td>$value->REF_NUMBER</td>
                                        <td>$value->KD_STATUS</td>
                                        <td>$value->TGL_STATUS</td>
                                        <td>$value->REMARK</td>
                                        <td>$value->FL_TRACK</td>
                                        <td>$value->FL_TRACKOUT</td>
                                        <td>$value->OPERATOR</td>
                                        <td>$value->FL_DASHBOARD</td></tr>";
                                        }
                                    }
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script type="text/javascript" src="echo base_url();?>assets/bulma/lib/main.js"></script>
    </body>
</html>