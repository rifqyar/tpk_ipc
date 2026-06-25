<div class="panel">
    
    <div class="panel-body container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <form name="form_data" id="form_data" class="form-horizontal" role="form"
                     method="post" autocomplete="off"
                    popup="1" enctype="multipart/form-data">
                    <div class="panel-body container-fluid">
                        <div class="row">
                            <div class="form-group form-material">
                                <label class="col-sm-3 control-label"><h4>List Dokumen : </h4></label>
                                <div class="col-sm-3 control-label">
                                <?php
                                $cek = $test;
                                for ($i=0; $i < count($cek); $i++) { 
                                    echo "<p style=\"font-size:0.8vw;\"><a href=\"http://103.234.195.126/upload/".$cek[$i]."\" target=\"_blank\">$cek[$i]</a></>";   
                                }
                                ?>
                                </div>
                            </div>

                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function () {});
</script>

