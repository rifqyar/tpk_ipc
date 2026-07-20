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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).on('click', '.btn-resend', function(e) {
        e.preventDefault();

        var button = $(this);
        var transactionId = button.data('transaction');

        Swal.fire({
            title: 'Konfirmasi Kirim Ulang',
            text: 'Apakah Anda yakin ingin mengirim ulang data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, kirim ulang',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then(function(result) {
            if (!result.isConfirmed) {
                return;
            }

            button.prop('disabled', true);

            Swal.fire({
                title: 'Memproses...',
                text: 'Data sedang dikirim ulang.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: function() {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '<?php echo base_url('application.php/PortalHelpdesk/resendcustomdata'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    transaction_id: transactionId
                },
                success: function(res) {
                    if (res.status === 'success') {
                        Swal.fire({
                            title: 'Berhasil',
                            text: res.message || 'Data berhasil dikirim ulang.',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then(function() {
                            location.reload();
                        });
                    } else {
                        button.prop('disabled', false);

                        Swal.fire({
                            title: 'Gagal',
                            text: res.message || 'Data gagal dikirim ulang.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    button.prop('disabled', false);

                    var message = 'Terjadi kesalahan saat mengirim ulang data.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        try {
                            var response = JSON.parse(xhr.responseText);

                            if (response.message) {
                                message = response.message;
                            }
                        } catch (parseError) {
                            message = 'Terjadi kesalahan: ' + error;
                        }
                    }

                    Swal.fire({
                        title: 'Gagal',
                        text: message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>