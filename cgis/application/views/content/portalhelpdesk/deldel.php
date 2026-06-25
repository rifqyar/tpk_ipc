<?php include 'header.php'; ?>

<div class="page-heading">
    <h3>Hapus Status Billing Delivery</h3>
</div>

<div class="page-content">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <form id="searchForm">
                    <div class="mb-3">
                        <label for="nomorDokumen" class="form-label mb-3">Nomor Dokumen Delivery</label>
                        <input type="text" class="form-control" id="nomorDokumen" name="nomor_dokumen"
                            placeholder="Masukkan nomor dokumen" required>
                    </div>
                    <button type="submit mb-3" class="btn btn-primary w-100">Submit</button>
                </form>
                <div class="mt-4">
                    <h5>Results:</h5>
                    <table class="table table-striped dataTable-table" id="resultsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NO DOK INOUT</th>
                                <th>TGL DOK INOUT</th>
                                <th>NO CONT</th>
                                <th>WK STATUS BIL</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Results will be appended here by JavaScript -->
                        </tbody>
                    </table>
                </div>
                <!-- <div class="mt-4">
                    <h5>Log Proses:</h5>
                    <table class="table table-striped" id="resultsTable">
                        <thead>
                            <tr>
                                <th>Nomor Dokumen</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($logs)): ?>
                                <?php foreach ($logs as $log): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($log['no_dok']); ?></td>
                                        <td><?php echo htmlspecialchars($log['tgl']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2" class="text-center">No logs found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div> -->

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#searchForm').submit(function (e) {
                e.preventDefault(); // Prevent the form from submitting in the traditional way

                // Get the input value
                var nomorDokumen = $('#nomorDokumen').val();

                // Make AJAX request to the server
                $.ajax({
                    url: "<?php echo base_url('application.php/PortalHelpdesk/getdelivery'); ?>", // Add application.php to base_url
                    method: 'POST',
                    data: { no_dok_inout: nomorDokumen },
                    dataType: 'json',
                    success: function (response) {
                        // Clear the previous results
                        $('#resultsTable tbody').empty();

                        // Check if there are results
                        if (response.length > 0) {
                            // Loop through the response and append to the table
                            $.each(response, function (index, data) {
                                var row = '<tr>' +
                                    '<td>' + data.ID + '</td>' +
                                    '<td>' + data.NO_DOK_INOUT + '</td>' +
                                    '<td>' + data.TGL_DOK_INOUT + '</td>' +
                                    '<td>' + data.NO_CONT + '</td>' +
                                    '<td>' + (data.WK_STATUS_BIL ? data.WK_STATUS_BIL : '-') + '</td>' +
                                    '<td><a href="#" class="delete-link" data-id="' + data.ID + '" data-no-dok-inout="' + data.NO_DOK_INOUT + '">Hapus Data</a></td>' +
                                    '</tr>';
                                $('#resultsTable tbody').append(row);
                            });
                        } else {
                            // If no data, show a message
                            var row = '<tr><td colspan="6" class="text-center">No data found</td></tr>';
                            $('#resultsTable tbody').append(row);
                        }
                    }
                });
            });

            // Optional: Initialize DataTable after data is loaded, if needed
            $('#resultsTable').DataTable();
        });

        $(document).on('click', '.delete-link', function (e) {
            e.preventDefault(); // Prevent default anchor behavior

            var id = $(this).data('id'); // Get the ID from the data attribute
            var noDokInout = $(this).data('no-dok-inout'); // Get the NO_DOK_INOUT from the data attribute

            // Show confirmation alert
            if (confirm('Apakah anda yakin untuk menghapus status billing ini?')) {
                // Send AJAX request to delete the data
                $.ajax({
                    url: "<?php echo base_url('application.php/PortalHelpdesk/prosesdel'); ?>", // The delete URL
                    method: 'POST',
                    data: { id: id, no_dok_inout: noDokInout }, // Include NO_DOK_INOUT
                    success: function (response) {
                        // Handle the success response
                        var res = JSON.parse(response);
                        alert(res.message); // Show the message from the response
                        location.reload(); // Reload the page to update the results
                    },
                    error: function (xhr, status, error) {
                        // Handle the error response
                        alert('Terjadi kesalahan saat menghapus data: ' + error);
                    }
                });
            }
        });

    </script>

    <?php include 'footer.php'; ?>