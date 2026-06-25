<div class="panel">
    <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light"
        onclick="save_ajax('form_data','tblmnl'); return false;">
        <i class="icon md-badge-check"></i> PROSES
    </button>
    <div class="panel-body container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <form name="form_data" id="form_data" class="form-horizontal" role="form"
                    action="<?php echo 'display/prosesonlinee?id='.$arrdata->ID; ?>" method="post" autocomplete="off"
                    popup="1" enctype="multipart/form-data" onsubmit="save_post('form_data','tblmnl')">
                    <input type="hidden" name="action" id="action" readonly="readonly"
                        value="<?php echo site_url('display/prosesonlinee'); ?>" />
                    <div class="panel-body container-fluid">
                        <div class="row">
                            <div class="form-group form-material">
                                <label class="col-sm-3 control-label">Note</label>
                                <div class="col-sm-8">
                                    <textarea type="text" mandatory="yes" name="NOTE"
                                        class="form-control" placeholder="Catatan" ></textarea>
                                </div>
                                <input type="hidden" name="no_dok" value="<?php echo $arrdata->NO_DOK;?>">
                                <input type="hidden" name="tgl_dok" value="<?php echo $arrdata->TGL_DOK;?>">
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