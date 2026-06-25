<div class="container">
    <h1>Create Gatepass <?php echo $container['NO_CONT']; ?></h1>

    <!-- Search Form -->
    <form id="searchForm">
        <div class="form-group">
            <label for="no_dok">Search by NO_DOK:</label>
            <input type="text" id="no_dok" name="no_dok" class="form-control" required>
            <button type="button" id="searchBtn" class="btn btn-primary">Search</button>
        </div>
    </form>

    <!-- Search Results -->
    <div id="searchResults" class="mt-4"></div>

    <!-- Gatepass Form -->
    <form id="gatepassForm" action="<?php echo site_url('planningrelo/update_container'); ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $container['ID']; ?>" />

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="no_cont">Container Number:</label>
                    <input type="text" id="no_cont" name="no_cont" class="form-control" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="ukr_cont">Container Size:</label>
                    <input type="text" id="ukr_cont" name="ukr_cont" class="form-control" readonly>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tipe_cont">Container Type:</label>
                    <input type="text" id="tipe_cont" name="tipe_cont" class="form-control" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="iso_code">ISO Code:</label>
                    <input type="text" id="iso_code" name="iso_code" class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="npwp">NPWP:</label>
                    <input type="text" id="npwp" name="npwp" class="form-control" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nama_cust">Customer Name:</label>
                    <input type="text" id="nama_cust" name="nama_cust" class="form-control" readonly>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="vessel">Vessel:</label>
                    <input type="text" id="vessel" name="vessel" class="form-control" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="voy_in">Voyage In:</label>
                    <input type="text" id="voy_in" name="voy_in" class="form-control" readonly>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="bruto">Bruto:</label>
                    <input type="text" id="bruto" name="bruto" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="no_bc11">NO_BC11:</label>
                    <input type="text" id="no_bc11" name="no_bc11" class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="no_pos_bc11">NO_POS_BC11:</label>
                    <input type="text" id="no_pos_bc11" name="no_pos_bc11" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="no_dok_selected">NO_DOK:</label>
                    <input type="text" id="no_dok_selected" name="no_dok_selected" class="form-control" readonly>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="tgl_dok">TGL_DOK:</label>
                    <input type="date" id="tgl_dok" name="tgl_dok" class="form-control" readonly>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Update Container</button>
        <a href="<?php echo site_url('planningrelo/spk_relokasi_detail/'.$container['ID_SPK']); ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>


<script>
    $(document).ready(function() {
    $('#searchBtn').on('click', function() {
        var no_dok = $('#no_dok').val();

        $.ajax({
            url: '<?php echo site_url('planningrelo/search_by_nodok'); ?>',
            method: 'POST',
            data: { no_dok: no_dok },
            dataType: 'json',
            success: function(data) {
                var results = '';

                if (data.length > 0) {
                    results += '<table class="table table-striped">';
                    results += '<thead><tr><th>NO_CONT</th><th>UKR_CONT</th><th>TIPE_CONT</th><th>NO DOKUMEN</th><th>TGL DOKUMEN</th><th>NPWP</th><th>NAMA_CUST</th><th>Select</th></tr></thead><tbody>';
                    
                    $.each(data, function(index, item) {
                        results += '<tr>';
                        results += '<td>' + item.NO_CONT + '</td>';
                        results += '<td>' + item.UKR_CONT + '</td>';
                        results += '<td>' + item.TIPE_CONT + '</td>';
                        results += '<td>' + item.NO_DOK + '</td>';
                        results += '<td>' + item.TGL_DOK + '</td>';
                        results += '<td>' + item.NPWP + '</td>';
                        results += '<td>' + item.NAMA_CUST + '</td>';
                        results += '<td><button type="button" class="btn btn-info select-btn" data-info=\'' + JSON.stringify(item) + '\'>Select</button></td>';
                        results += '</tr>';
                    });

                    results += '</tbody></table>';
                } else {
                    results = '<p>No records found.</p>';
                }

                $('#searchResults').html(results);
            }
        });
    });

    // Handle selection of search result
    $(document).on('click', '.select-btn', function() {
        var data = $(this).data('info');
        
        // Populate the form fields with the selected data
        $('#no_cont').val(data.NO_CONT);
        $('#ukr_cont').val(data.UKR_CONT);
        $('#tipe_cont').val(data.TIPE_CONT);
        $('#iso_code').val(data.ISO_CODE);
        $('#npwp').val(data.NPWP);
        $('#nama_cust').val(data.NAMA_CUST);
        $('#vessel').val(data.VESSEL);
        $('#voy_in').val(data.VOY_IN);
        $('#bruto').val(data.BRUTO);
        $('#no_bc11').val(data.NO_BC11);
        $('#no_pos_bc11').val(data.NO_POS_BC11);
        $('#no_dok_selected').val(data.NO_DOK);
        $('#tgl_dok').val(data.TGL_DOK);
    });
});

</script>