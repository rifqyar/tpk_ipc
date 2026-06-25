<?php include 'header.php'; ?>

<div class="page-heading">
    <h3>Set Sedang Periksa</h3>
    <p>Ubah data dari stacking yard 1A ke sedang Periksa</p>
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
                        <th>NO SPK</th>
                        <th>NO CONTAINER</th>
                        <th>STATUS KONTAINER</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['NO_SPK']); ?></td>
                            <td><?php echo htmlspecialchars($row['NO_CONT']); ?></td>  
                            <td><?php echo htmlspecialchars($row['KETERANGAN']); ?></td>
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