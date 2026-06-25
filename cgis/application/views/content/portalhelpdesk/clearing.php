<?php include 'header.php'; ?>

<div class="page-heading">
    <h3>Clearing Billing Manual</h3>
</div>

<div class="page-content">
    <section class="row">
        <form method="GET" action="<?php echo base_url('application.php/PortalHelpdesk/clearing'); ?>">
            <div class="mb-3">
                <label for="noDok" class="form-label">NOMOR DOKUMEN PENGELUARAN</label>
                <input type="text" class="form-control" id="noDok" name="no_dok" required>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>
    </section>

    <?php if (!empty($results)): ?>
        <div class="mt-4">
            <h5>Query Results:</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>NOTA</th>
                        <th>SAP TGL PELUNASAN</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row): ?>
                        <tr>
                            <td><?php echo $row['NOTA']; ?></td>
                            <td><?php echo $row['SAP_TGL_PELUNASAN']; ?></td>
                            <td>
                                <?php if (is_null($row['SAP_TGL_PELUNASAN'])): ?>
                                    <a href="#" class="btn btn-success action-button" data-action="clearing"
                                        data-proforma="<?php echo $row['NOTA']; ?>">Clearing Manual</a>
                                    <a href="#" class="btn btn-danger action-button" data-action="hapus"
                                        data-proforma="<?php echo $row['NOTA']; ?>">Hapus Data</a>
                                <?php endif; ?>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="mt-4">
            <p class="text-center">No results found for the given NOMOR DOKUMEN PENGELUARAN.</p>
        </div>
    <?php endif; ?>
</div>
<?php include 'footer.php'; ?>

<script>
    $(document).on('click', '.action-button', function (e) {
        e.preventDefault();

        var action = $(this).data('action');  // 'clearing' or 'hapus'
        var proforma = $(this).data('proforma');  // The NOTA (used as PROFORMA)

        // Ask for confirmation
        var confirmationMessage = action === 'clearing' ? 'Yakin untuk melakukan clearing manual?' : 'Yakin untuk menghapus data?';
        if (confirm(confirmationMessage)) {
            // Send AJAX request to perform the action
            $.ajax({
                url: "<?php echo base_url('application.php/PortalHelpdesk/prosesclearing'); ?>",
                method: 'POST',
                data: { action: action, proforma: proforma },
                success: function (response) {
                    var res = JSON.parse(response);
                    alert(res.message);  // Display the response message
                    if (res.status === 'success') {
                        location.reload();  // Reload the page if the action was successful
                    }
                },
                error: function (xhr, status, error) {
                    alert('Terjadi kesalahan: ' + error);
                }
            });
        }
    });
</script>