<?php include 'header.php'; ?>

<div class="page-heading">
    <h3>Resend Autogate</h3>
    <p>Kirim ulang data ke autogate jika gatepass tidak dapat di scan</p>
</div>

<div class="page-content">
    <section class="row">
        <div class="mb-3">
            <label for="container_id" class="form-label">Nomor Container</label>
            <form method="get" action="<?php echo base_url('application.php/PortalHelpdesk/sendcustomdatamanual'); ?>">
                <input type="text" class="form-control" id="container_id" name="container_id"
                    placeholder="Enter container number"
                    value="<?php echo isset($_GET['container_id']) ? $_GET['container_id'] : ''; ?>">
                <div class="mb-3 mt-3">
                    <button type="submit" class="btn btn-primary">Proses</button>
                </div>
            </form>
        </div>

        <?php if (!empty($results)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>TRANSACTION ID</th>
                        <th>NO CONTAINER</th>
                        <th>SIZE</th>
                        <th>VESSEL</th>
                        <th>VOYAGE</th>
                        <th>NO DOCUMENT</th>
                        <th>TGL DOCUMENT</th>
                        <th>REMARKS</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['TRANSACTION_ID']); ?></td>
                            <td><?php echo htmlspecialchars($row['CONTAINER_ID']); ?></td>
                            <td><?php echo htmlspecialchars($row['CONTAINER_SIZE']); ?></td>
                            <td><?php echo htmlspecialchars($row['VESSEL_NAME']); ?></td>
                            <td><?php echo htmlspecialchars($row['VOYAGE']); ?></td>
                            <td><?php echo htmlspecialchars($row['DOCUMENT_NO']); ?></td>
                            <td><?php echo htmlspecialchars($row['DOCUMENT_DATE']); ?></td>
                            <td><?php echo htmlspecialchars($row['REMAKS']); ?></td>
                            <td>
                                <button class="btn btn-warning btn-resend"
                                    data-transaction="<?php echo htmlspecialchars($row['TRANSACTION_ID']); ?>">Resend</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No data found.</p>
        <?php endif; ?>
    </section>
</div>

<?php include 'footer.php'; ?>

<script>
    $(document).on('click', '.btn-resend', function () {
        var transaction_id = $(this).data('transaction');

        if (confirm('Anda Yakin Untuk Mengirim Ulang?')) {
            $.ajax({
                url: '<?php echo base_url('application.php/PortalHelpdesk/resendcustomdata'); ?>',
                type: 'POST',
                data: { transaction_id: transaction_id },
                success: function (response) {
                    var res = JSON.parse(response);
                    if (res.status === 'success') {
                        alert('Resend successful: ' + res.message);
                    } else {
                        alert('Resend failed: ' + res.message);
                    }
                    location.reload();  // Refresh the page

                },
                error: function () {
                    alert('Error occurred while sending request');
                }
            });
        }
    });
</script>