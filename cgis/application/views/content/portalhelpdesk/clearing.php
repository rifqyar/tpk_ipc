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

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).on('click', '.action-button', function(e) {
        e.preventDefault();

        var button = $(this);
        var action = button.data('action');
        var proforma = button.data('proforma');

        var isClearing = action === 'clearing';

        var confirmationTitle = isClearing ?
            'Konfirmasi Clearing' :
            'Konfirmasi Hapus';

        var confirmationMessage = isClearing ?
            'Apakah Anda yakin ingin melakukan clearing manual?' :
            'Apakah Anda yakin ingin menghapus data ini?';

        var confirmButtonText = isClearing ?
            'Ya, lakukan clearing' :
            'Ya, hapus';

        Swal.fire({
            title: confirmationTitle,
            text: confirmationMessage,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: confirmButtonText,
            cancelButtonText: 'Batal',
            reverseButtons: true,
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then(function(result) {
            if (!result.isConfirmed) {
                return;
            }

            // Mencegah tombol diklik berulang kali
            button.prop('disabled', true);

            Swal.fire({
                title: 'Memproses...',
                text: isClearing ?
                    'Proses clearing manual sedang dijalankan.' :
                    'Proses penghapusan data sedang dijalankan.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: function() {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "<?php echo base_url('application.php/PortalHelpdesk/prosesclearing'); ?>",
                method: 'POST',
                dataType: 'json',
                data: {
                    action: action,
                    proforma: proforma
                },
                success: function(res) {
                    if (res.status === 'success') {
                        Swal.fire({
                            title: 'Berhasil',
                            text: res.message || (
                                isClearing ?
                                'Clearing manual berhasil dilakukan.' :
                                'Data berhasil dihapus.'
                            ),
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
                            text: res.message || (
                                isClearing ?
                                'Clearing manual gagal dilakukan.' :
                                'Data gagal dihapus.'
                            ),
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    button.prop('disabled', false);

                    var message = 'Terjadi kesalahan saat memproses data.';

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