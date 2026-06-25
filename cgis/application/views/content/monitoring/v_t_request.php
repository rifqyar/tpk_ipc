<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.4.1/materia/bootstrap.min.css">
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
        <link rel="stylesheet" href="style.css">
        <title>Rekon</title>
    </head>
    <body>
        <div class="col-md-12">
            <div class="container">
                <div class="row">
                    <div class="card text-center col-md-12">
                        <div class="card-header">
                            <ul class="nav nav-pills card-header-pills">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#">Back</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#"></a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Data Hasil Rekon NPCT1</h5>
                            <p class="card-text"></p>
                            <div>
                                <form
                                    class="form-inline"
                                    action="/tpk_ipc/cgis-dev/application.php/display/hasilrekon"
                                    method="GET">
                                    <div class="form-group mx-sm-3 mb-2">
                                        <label for="inputPassword2" class="sr-only">Kontainer</label>
                                        <input type="text" class="form-control" name="nocont" placeholder="kontainer">
                                    </div>
                                    <button type="submit" class="btn btn-primary mb-2">Search</button>
                                </form>
                            </div>
                            <hr>
                            <table class="table">
                                <tr>
                                    <td>NO_CONT</td>
                                    <td>:
                                        <?php echo $row->NO_CONT;?></td>
                                </tr>
                                <tr>
                                    <td>UKR_CONT</td>
                                    <td>:
                                        <?php echo $row->UKR_CONT;?></td>
                                </tr>
                                <tr>
                                    <td>TIPE_CONT</td>
                                    <td>:
                                        <?php echo $row->TIPE_CONT;?></td>
                                </tr>
                                <tr>
                                    <td>KD_CONT_JENIS</td>
                                    <td>:
                                        <?php echo $row->KD_CONT_JENIS;?></td>
                                </tr>
                                <tr>
                                    <td>VESSEL</td>
                                    <td>:
                                        <?php echo $row->VESSEL;?></td>
                                </tr>
                                <tr>
                                    <td>CALL_SIGN</td>
                                    <td>:
                                        <?php echo $row->CALL_SIGN;?></td>
                                </tr>
                                <tr>
                                    <td>ISO_CODE</td>
                                    <td>:
                                        <?php echo $row->ISO_CODE;?></td>
                                </tr>
                                <tr>
                                    <td>BRUTO</td>
                                    <td>:
                                        <?php echo $row->BRUTO;?></td>
                                </tr>
                                <tr>
                                    <td>VOY_IN</td>
                                    <td>:
                                        <?php echo $row->VOY_IN;?></td>
                                </tr>
                                <tr>
                                    <td>VOY_OUT</td>
                                    <td>:
                                        <?php echo $row->VOY_OUT;?></td>
                                </tr>
                                <tr>
                                    <td>POD1</td>
                                    <td>:
                                        <?php echo $row->POD1;?></td>
                                </tr>
                                <tr>
                                    <td>POD2</td>
                                    <td>:
                                        <?php echo $row->POD2;?></td>
                                </tr>
                                <tr>
                                    <td>CLOSING_TIME</td>
                                    <td>:
                                        <?php echo $row->CLOSING_TIME;?></td>
                                </tr>
                                <tr>
                                    <td>DISCHARGE</td>
                                    <td>:
                                        <?php echo $row->DISCHARGE;?></td>
                                </tr>
                                <tr>
                                    <td>IMO</td>
                                    <td>:
                                        <?php echo $row->IMO;?></td>
                                </tr>
                                <tr>
                                    <td>TEMP_CUST</td>
                                    <td>:
                                        <?php echo $row->TEMP_CUST;?></td>
                                </tr>
                                <tr>
                                    <td>TEMP_TERMINAL</td>
                                    <td>:
                                        <?php echo $row->TEMP_TERMINAL;?></td>
                                </tr>
                                <tr>
                                    <td>PLUG_TERMINAL</td>
                                    <td>:
                                        <?php echo $row->PLUG_TERMINAL;?></td>
                                </tr>
                                <tr>
                                    <td>UNPLUG_TERMINAL</td>
                                    <td>:
                                        <?php echo $row->UNPLUG_TERMINAL;?></td>
                                </tr>
                                <tr>
                                    <td>WK_GATEOUT</td>
                                    <td>:
                                        <?php echo $row->WK_GATEOUT;?></td>
                                </tr>
                                <tr>
                                    <td>FL_IMO</td>
                                    <td>:
                                        <?php echo $row->FL_IMO;?></td>
                                </tr>
                                <tr>
                                    <td>FL_DG</td>
                                    <td>:
                                        <?php echo $row->FL_DG;?></td>
                                </tr>
                                <tr>
                                    <td>FL_REEFER</td>
                                    <td>:
                                        <?php echo $row->FL_REEFER;?></td>
                                </tr>
                                <tr>
                                    <td>FL_OOG</td>
                                    <td>:
                                        <?php echo $row->FL_OOG;?></td>
                                </tr>
                                <tr>
                                    <td>FL_YARD</td>
                                    <td>:
                                        <?php echo $row->FL_YARD;?></td>
                                </tr>
                                <tr>
                                    <td>HOLD</td>
                                    <td>:
                                        <?php echo $row->HOLD;?></td>
                                </tr>
                                <tr>
                                    <td>NO_BL_AWB</td>
                                    <td>:
                                        <?php echo $row->NO_BL_AWB;?></td>
                                </tr>
                                <tr>
                                    <td>TAR</td>
                                    <td>:
                                        <?php echo $row->TAR;?></td>
                                </tr>
                                <tr>
                                    <td>FLAG_STATUS</td>
                                    <td>:
                                        <?php echo $row->FLAG_STATUS;?></td>
                                </tr>
                                <tr>
                                    <td>FLAG_FINISH_PRINT</td>
                                    <td>:
                                        <?php echo $row->FLAG_FINISH_PRINT;?></td>
                                </tr>
                                <tr>
                                    <td>REF_NUMBER</td>
                                    <td>:
                                        <?php echo $row->REF_NUMBER;?></td>
                                </tr>
                                <tr>
                                    <td>KD_STATUS</td>
                                    <td>:
                                        <?php echo $row->KD_STATUS;?></td>
                                </tr>
                                <tr>
                                    <td>TGL_STATUS</td>
                                    <td>:
                                        <?php echo $row->TGL_STATUS;?></td>
                                </tr>
                                <tr>
                                    <td>REMARK</td>
                                    <td>:
                                        <?php echo $row->REMARK;?></td>
                                </tr>
                                <tr>
                                    <td>FL_TRACK</td>
                                    <td>:
                                        <?php echo $row->FL_TRACK;?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
    </body>
</html>