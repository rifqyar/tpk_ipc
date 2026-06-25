<div class="container">
    <h1>SPK Relocation Detail</h1>

    <!-- Header Information -->
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label for="no_spk"><strong>NO SPK:</strong></label>
                <input type="text" class="form-control" id="no_spk" value="<?php echo $header['NO_SPK']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="tgl_spk"><strong>TGL SPK:</strong></label>
                <input type="text" class="form-control" id="tgl_spk" value="<?php echo $header['TGL_SPK']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="no_dok"><strong>NO DOK:</strong></label>
                <input type="text" class="form-control" id="no_dok" value="<?php echo $header['NO_DOK']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="tgl_dok"><strong>TGL DOK:</strong></label>
                <input type="text" class="form-control" id="tgl_dok" value="<?php echo $header['TGL_DOK']; ?>" readonly>
            </div>
        </div>
    </div>

    <!-- Update Form for NO DOK -->
    <?php if (empty($header['NO_DOK']) || empty($header['TGL_DOK'])): ?>
        <div class="card mt-4">
            <div class="card-body">
                <h4>Search Document</h4>
                <div class="form-group">
                    <label for="no_dok_input"><strong>Enter NO DOK:</strong></label>
                    <input type="text" class="form-control" id="no_dok_input" placeholder="Enter NO DOK">
                </div>
                <button id="search_button" class="btn btn-primary">Search</button>

                <!-- Results Table -->
                <div id="results_container" class="mt-4" style="display: none;">
                    <h5>Search Results</h5>
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>NO DOK</th>
                                <th>TGL DOK</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody id="results_table_body">
                            <!-- Search results will be appended here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Container Details -->
    <div class="container mt-4">
        <h2 class="text-center">Container List</h2>
        <table class="table table-bordered table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th>NO CONT</th>
                    <th>SIZE</th>
                    <th>TYPE</th>
                    <th>CONSIGNEE</th>
                    <th>NOMOR DOKUMEN PERIKSA</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($containers)): ?>
                    <?php foreach ($containers as $container): ?>
                        <tr>
                            <td><?php echo $container['NO_CONT']; ?></td>
                            <td><?php echo $container['SIZE']; ?></td>
                            <td><?php echo $container['TYPE']; ?></td>
                            <td><?php echo $container['CONSIGNEE']; ?></td>
                            <td><?php echo $container['NO_DOK_PERIKSA']; ?></td>
                            <td>
                                <?php if (empty($container['gatepass_status'])): ?>
                                    <form action="<?php echo site_url('planningrelo/create_gatepass/' . $container['ID']); ?>"
                                        method="post" class="form-inline">
                                        <input type="date" name="gatepass_date" class="form-control form-control-sm mr-2" required>
                                        <button type="submit" class="btn btn-primary btn-sm"
                                            onclick="return confirm('Are you sure you want to create a gatepass for this container?');">
                                            Buat Gatepass
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <a href="<?php echo site_url('planning/cetak_gatepass_delivery_banda/pdf/print/' . $container['gatepass_status']); ?>"
                                        target="_blank" class="btn btn-success btn-sm">
                                        Cetak Gatepass
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No container records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>


        </table>

    </div>

    <!-- Back button -->
    <a href="<?php echo site_url('planningrelo/spk_relokasi'); ?>" class="btn btn-secondary">Back to List</a>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        // Search for documents when the search button is clicked
        $('#search_button').on('click', function () {
            var no_dok_input = $('#no_dok_input').val();
            if (no_dok_input) {
                $.ajax({
                    url: "<?php echo site_url('planningrelo/search_document'); ?>",
                    method: "POST",
                    data: { no_dok_input: no_dok_input },
                    dataType: "json",
                    success: function (response) {
                        if (response.status === 'success') {
                            $('#results_table_body').empty(); // Clear previous results
                            $.each(response.data, function (i, doc) {
                                $('#results_table_body').append(
                                    '<tr>' +
                                    '<td>' + doc.NO_DOK_INOUT + '</td>' +
                                    '<td>' + doc.TGL_DOK_INOUT + '</td>' +
                                    '<td><button class="btn btn-success btn-sm select-document" data-no-dok="' + doc.NO_DOK_INOUT + '" data-tgl-dok="' + doc.TGL_DOK_INOUT + '">Pilih Dokumen</button></td>' +
                                    '</tr>'
                                );
                            });
                            $('#results_container').show(); // Show results container
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function () {
                        alert('An error occurred while searching for documents.');
                    }
                });
            } else {
                alert('Please enter a NO DOK to search.');
            }
        });

        // Handle document selection
        $(document).on('click', '.select-document', function () {
            var no_dok = $(this).data('no-dok');
            var tgl_dok = $(this).data('tgl-dok');
            var no_spk = $('#no_spk').val(); // Get NO_SPK value from the header

            var confirmUpdate = confirm("Are you sure you want to update the document fields?\nNO DOK: " + no_dok + "\nTGL DOK: " + tgl_dok);

            if (confirmUpdate) {
                // AJAX call to update the document
                $.ajax({
                    url: "<?php echo site_url('planningrelo/update_document'); ?>",
                    method: "POST",
                    data: {
                        no_spk: no_spk,
                        no_dok: no_dok,
                        tgl_dok: tgl_dok
                    },
                    dataType: "json",
                    success: function (response) {
                        alert(response.message); // Display success/error message
                        if (response.status === 'success') {
                            // Reload the page after successful update
                            location.reload();
                        }
                    },
                    error: function () {
                        alert('An error occurred while updating the document.');
                    }
                });
            }
        });
    });

</script>

<style>
    .table {
        margin-top: 20px;
        background-color: #ffffff;
    }

    .table th,
    .table td {
        vertical-align: middle;
        text-align: center;
    }

    .thead-dark th {
        background-color: #343a40;
        color: #ffffff;
    }

    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }

    .container h2 {
        font-weight: 600;
        color: #343a40;
        margin-bottom: 20px;
    }
</style>