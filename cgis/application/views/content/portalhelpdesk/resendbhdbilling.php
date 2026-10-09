<?php include 'header.php'; ?>

<div class="page-heading">
    <h3>Kirim Ulang Billing Behandle PJ</h3>
</div>

<div class="page-content">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="mt-4">
                    <h5>Data Behandle Tidak Muncul di BOS Billing</h5>
                    <table class="table table-striped dataTable-table" id="resultsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NOMOR DOKUMEN</th>
                                <th>TGL DOKUMEN</th>
                                <th>CONTAINERS</th>
                                <th>ID REQUEST</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data)): ?>
                                <?php foreach ($data as $key => $value): ?>
                                    <tr>
                                        <td><?php echo $key + 1 ?></td>
                                        <td><?php echo $value->no_dok ?></td>
                                        <td><?php echo $value->tgl_dok ?></td>
                                        <td><?php echo $value->containers ?></td>
                                        <td><?php echo $value->id_req ?></td>
                                        <td><a href="#" class="resend-link" data-id="<?php echo $value->id_bhd_billing ?>" data-no-dok="<?php echo $value->no_dok ?>">Kirim Ulang Data</a></td>
                                    </tr>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
                <!-- <div class="mt-4">
                    <h5>Log Proses:</h5>
                    <table class="table table-striped">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function() {
            $('#resultsTable').DataTable();
        })

        $(document).on('click', '.resend-link', function(e) {
            e.preventDefault();

            var id = $(this).data('id');
            var no_dok = $(this).data('no-dok');

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin Mengirim ulang data billing ini?',
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
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mohon tunggu',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: function() {
                        Swal.showLoading();
                    }
                });
                $.ajax({
                    url: "<?php echo base_url('application.php/PortalHelpdesk/prosesresendbhd'); ?>",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: id,
                        no_dok: no_dok
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire({
                                title: 'Berhasil',
                                text: res.message || 'Status billing berhasil dikirim ulang.',
                                icon: 'success',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonText: 'OK'
                            }).then(function() {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal',
                                text: res.message || 'Status billing gagal dikirim ulang.',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        var message = 'Terjadi kesalahan saat mengirim ulang data.';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        } else if (xhr.responseText) {
                            try {
                                var response = JSON.parse(xhr.responseText);

                                if (response.message) {
                                    message = response.message;
                                }
                            } catch (e) {
                                message += ' '
                                error;
                            }
                        }

                        Swal.fire({
                            title: 'Gagal',
                            text: message,
                            icon: 'error'
                        });
                    }
                });
            });
        });
    </script>

    <?php include 'footer.php'; ?>