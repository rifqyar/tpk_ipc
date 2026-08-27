<div class="panel">
    <button type="submit"
        class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light"
        onclick="save_ajax('form_data','tblmnl'); return false;">
        <i class="icon md-badge-check"></i> PROSES
    </button>

    <div class="panel-body container-fluid">
        <div class="row">
            <div class="col-sm-12">

                <form name="form_data"
                    id="form_data"
                    class="form-horizontal"
                    role="form"
                    action="<?php echo 'online/prosesonline?id=' . $arrdata->ID; ?>"
                    method="post"
                    autocomplete="off"
                    popup="1"
                    enctype="multipart/form-data"
                    onsubmit="save_post('form_data','tblmnl')">

                    <input type="hidden"
                        name="action"
                        id="action"
                        readonly="readonly"
                        value="<?php echo site_url('online/prosesonline'); ?>" />

                    <div class="panel-body container-fluid">
                        <div class="row">
                            <!-- NOTE -->
                            <div class="form-group form-material">
                                <label class="col-sm-3 control-label">
                                    Note
                                </label>
                                <div class="col-sm-8">
                                    <textarea
                                        mandatory="yes"
                                        name="NOTE"
                                        class="form-control"
                                        placeholder="Catatan"></textarea>
                                </div>
                            </div>
                            <!-- RE-EXPORT -->
                            <div class="form-group form-material">
                                <label class="col-sm-3 control-label">
                                    Re-export
                                </label>
                                <div class="col-sm-8">
                                    <div class="checkbox-custom checkbox-primary">
                                        <input
                                            type="checkbox"
                                            name="RE_EXPORT"
                                            id="RE_EXPORT"
                                            value="1">
                                        <label for="RE_EXPORT">
                                            Ya, dokumen ini merupakan re-export
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- KOMPONEN RE-EXPORT -->
                            <div id="reexport_component"
                                style="display:none;">
                                <!-- DOKUMEN ASAL -->
                                <div class="form-group form-material">
                                    <label class="col-sm-3 control-label">
                                        Dokumen Asal
                                    </label>
                                    <div class="col-sm-8">
                                        <select
                                            name="ID_DOKUMEN_ASAL"
                                            id="ID_DOKUMEN_ASAL"
                                            class="form-control">
                                            <option value="">
                                                -- Pilih Dokumen Asal --
                                            </option>
                                            <?php foreach ($contasal as $row) { ?>
                                                <option
                                                    value="<?php echo $row->ID_DOKUMEN; ?>">
                                                    <?php echo $row->NO_DOK . ' - ' . $row->TGL_DOK; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- LIST CONTAINER LAMA -->
                                <div
                                    id="container_lama_component"
                                    style="display:none;">
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-8">
                                            <div class="panel panel-bordered">
                                                <!-- JUDUL -->
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        Harap pilih container lama
                                                    </h4>
                                                </div>
                                                <!-- LIST -->
                                                <div class="panel-body">
                                                    <div class="table-responsive">
                                                        <table
                                                            class="table table-hover table-bordered"
                                                            id="table_container_lama">
                                                            <thead>
                                                                <tr>
                                                                    <th width="50"
                                                                        class="text-center">
                                                                        Pilih
                                                                    </th>
                                                                    <th>
                                                                        No Container
                                                                    </th>
                                                                    <th>
                                                                        Size / Type
                                                                    </th>
                                                                    <th>
                                                                        Status
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="container_lama_list">
                                                                <!--
                                                                    Data container
                                                                    akan dimasukkan
                                                                    di sini
                                                                -->
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- HIDDEN DATA -->

                            <input type="hidden"
                                name="no_dok"
                                value="<?php echo $arrdata->NO_DOK; ?>">

                            <input type="hidden"
                                name="tgl_dok"
                                value="<?php echo $arrdata->TGL_DOK; ?>">

                            <input type="hidden"
                                name="FL_STATUS"
                                value="<?php echo $arrdata->FL_STATUS; ?>">

                            <input type="hidden"
                                name="ID_DOKUMEN"
                                value="<?php echo $arrdata->ID_DOKUMEN; ?>">

                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>
</div>


<script>
    $(function() {
        /*
         * CHECKBOX RE-EXPORT
         */
        $('#RE_EXPORT').on('change', function() {
            if ($(this).is(':checked')) {
                $('#reexport_component').slideDown();
            } else {
                $('#reexport_component').slideUp();
                // Reset dokumen
                $('#ID_DOKUMEN_ASAL').val('');
                // Reset list container
                $('#container_lama_component').hide();
                $('#container_lama_list').html('');
            }
        });
        /*
         * DOKUMEN ASAL DIPILIH
         */
        $('#ID_DOKUMEN_ASAL').on('change', function() {
            var idDokumen = $(this).val();
            if (idDokumen === '') {
                $('#container_lama_component').hide();
                $('#container_lama_list').html('');
                return;
            }
            $('#container_lama_component').slideDown();
            $('#container_lama_list').html(`
                <tr>
                    <td colspan="4" class="text-center">
                        <i class="fa fa-spinner fa-spin"></i>
                        Loading container...
                    </td>
                </tr>
            `);
            $.ajax({
                url: '<?php echo site_url("online/monitorOrderOnline/old_container"); ?>',
                type: 'POST',
                data: {
                    id: idDokumen
                },
                dataType: 'html',
                success: function(response) {
                    $('#container_lama_list').html(response);
                },
                error: function(xhr, status, error) {
                    console.log('AJAX Error:', error);
                    console.log(xhr.responseText);
                    $('#container_lama_list').html(`
                        <tr>
                            <td colspan="4" class="text-center text-danger">
                                Gagal mengambil data container.
                            </td>
                        </tr>
                    `);
                }
            });
        });
    });
</script>