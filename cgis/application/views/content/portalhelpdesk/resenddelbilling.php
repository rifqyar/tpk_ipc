<?php include 'header.php'; ?>

<div class="page-heading">
    <h3>Kirim Ulang Billing Delivery PJ</h3>
</div>

<div class="page-content">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Billing Delivery Tidak Muncul di BOS Billing</h5>
                        </div>
                        <div class="card-body">
                            <table class="table dataTable-table" id="resultsTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NOMOR DOKUMEN</th>
                                        <th>TGL DOKUMEN</th>
                                        <th>IMPORTIR</th>
                                        <th>ID REQUEST</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($data)): ?>
                                        <?php foreach ($data as $key => $value): ?>
                                            <tr>
                                                <td><?= $key + 1 ?></td>
                                                <td><?= $value->no_dok ?></td>
                                                <td><?= $value->tgl_dok ?></td>
                                                <td><?= $value->nama ?></td>
                                                <td><?= $value->id_req ?></td>
                                                <td><a href="#" class="resend-link" data-file="<?= $value->file_dok ?>" data-id="<?= $value->id_del_billing ?>" data-no-dok="<?= $value->no_dok ?>">Kirim Ulang Data</a></td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
            var file_dok = $(this).data('file') || '';

            var fileParts = file_dok.split('#');
            var file_bl = fileParts[0] || '';
            var file_do = fileParts[1] || '';

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin mengirim ulang data billing ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then(function(result) {
                if (!result.isConfirmed) {
                    return;
                }

                Swal.fire({
                    title: 'Data Tambahan',
                    width: 600,
                    html: `
                <div style="text-align: left;">
                    <label for="swal-no-do"
                        style="display: block; margin-bottom: 5px;">
                        No. DO
                    </label>

                    <input
                        type="text"
                        id="swal-no-do"
                        class="swal2-input"
                        placeholder="Masukkan No. DO"
                        style="width: 100%; margin: 0 0 15px 0;"
                    >

                    <label for="swal-no-bl"
                        style="display: block; margin-bottom: 5px;">
                        No. BL
                    </label>

                    <input
                        type="text"
                        id="swal-no-bl"
                        class="swal2-input"
                        placeholder="Masukkan No. BL"
                        style="width: 100%; margin: 0 0 20px 0;"
                    >

                    <div style="
                        display: flex;
                        align-items: center;
                        gap: 10px;
                        margin-bottom: 15px;
                    ">
                        <input
                            type="checkbox"
                            id="swal-is-nhi"
                            style="
                                width: 20px;
                                height: 20px;
                                cursor: pointer;
                            "
                        >

                        <label
                            for="swal-is-nhi"
                            style="
                                margin: 0;
                                cursor: pointer;
                                font-weight: 600;
                            "
                        >
                            Dokumen NHI
                        </label>
                    </div>

                    <div id="swal-nhi-form" style="display: none;">
                        <label for="swal-nhi-date"
                            style="display: block; margin-bottom: 5px;">
                            NHI Date <span style="color: red;">*</span>
                        </label>

                        <input
                            type="date"
                            id="swal-nhi-date"
                            class="swal2-input"
                            style="width: 100%; margin: 0 0 15px 0;"
                        >

                        <label for="swal-nhi-unsealing-date"
                            style="display: block; margin-bottom: 5px;">
                            NHI Unsealing Date
                            <span style="color: red;">*</span>
                        </label>

                        <input
                            type="date"
                            id="swal-nhi-unsealing-date"
                            class="swal2-input"
                            style="width: 100%; margin: 0 0 15px 0;"
                        >
                    </div>

                    <div style="
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        gap: 15px;
                        margin-top: 20px;
                    ">
                        ${
                            file_bl
                                ? `
                                    <a
                                        href="http://osbos.multiterminal.co.id/upload/${encodeURIComponent(file_bl)}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                    >
                                        <i class="bi bi-journal-bookmark-fill"></i>
                                        Cek Dokumen BL
                                    </a>
                                `
                                : '<span></span>'
                        }

                        ${
                            file_do
                                ? `
                                    <a
                                        href="http://osbos.multiterminal.co.id/upload/${encodeURIComponent(file_do)}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                    >
                                        <i class="bi bi-journal-bookmark-fill"></i>
                                        Cek Dokumen DO
                                    </a>
                                `
                                : '<span></span>'
                        }
                    </div>
                </div>
            `,
                    showCancelButton: true,
                    confirmButtonText: 'Kirim Ulang',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    focusConfirm: false,

                    didOpen: function() {
                        var checkboxNhi = document.getElementById('swal-is-nhi');
                        var formNhi = document.getElementById('swal-nhi-form');
                        var inputNhiDate = document.getElementById('swal-nhi-date');
                        var inputNhiUnsealingDate = document.getElementById(
                            'swal-nhi-unsealing-date'
                        );

                        checkboxNhi.addEventListener('change', function() {
                            if (this.checked) {
                                formNhi.style.display = 'block';

                                inputNhiDate.setAttribute('required', 'required');
                                inputNhiUnsealingDate.setAttribute(
                                    'required',
                                    'required'
                                );
                            } else {
                                formNhi.style.display = 'none';

                                inputNhiDate.removeAttribute('required');
                                inputNhiUnsealingDate.removeAttribute('required');

                                inputNhiDate.value = '';
                                inputNhiUnsealingDate.value = '';
                            }
                        });
                    },

                    preConfirm: function() {
                        var noDo = $('#swal-no-do').val().trim();
                        var noBl = $('#swal-no-bl').val().trim();

                        var isNhi = $('#swal-is-nhi').is(':checked');
                        var nhiDate = $('#swal-nhi-date').val();
                        var nhiUnsealingDate = $('#swal-nhi-unsealing-date').val();

                        if (!noDo) {
                            Swal.showValidationMessage('No. DO wajib diisi.');
                            return false;
                        }

                        if (!noBl) {
                            Swal.showValidationMessage('No. BL wajib diisi.');
                            return false;
                        }

                        if (isNhi && !nhiDate) {
                            Swal.showValidationMessage(
                                'NHI Date wajib diisi untuk dokumen NHI.'
                            );
                            return false;
                        }

                        if (isNhi && !nhiUnsealingDate) {
                            Swal.showValidationMessage(
                                'NHI Unsealing Date wajib diisi untuk dokumen NHI.'
                            );
                            return false;
                        }

                        /*
                         * Validasi opsional:
                         * NHI Unsealing Date tidak boleh sebelum NHI Date.
                         */
                        if (
                            isNhi &&
                            nhiDate &&
                            nhiUnsealingDate &&
                            nhiUnsealingDate < nhiDate
                        ) {
                            Swal.showValidationMessage(
                                'NHI Unsealing Date tidak boleh sebelum NHI Date.'
                            );
                            return false;
                        }

                        return {
                            no_do: noDo,
                            no_bl: noBl,
                            is_nhi: isNhi ? 1 : 0,
                            nhi_date: isNhi ? nhiDate : '',
                            nhi_unsealing_date: isNhi ?
                                nhiUnsealingDate :
                                ''
                        };
                    }
                }).then(function(formResult) {
                    if (!formResult.isConfirmed) {
                        return;
                    }

                    var formData = formResult.value;

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
                        url: "<?php echo base_url('application.php/PortalHelpdesk/prosesresenddel'); ?>",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id: id,
                            no_dok: no_dok,
                            no_do: formData.no_do,
                            no_bl: formData.no_bl,

                            // Data NHI
                            is_nhi: formData.is_nhi,
                            nhi_date: formData.nhi_date,
                            nhi_unsealing_date: formData.nhi_unsealing_date
                        },
                        success: function(res) {
                            if (res.status === 'success') {
                                Swal.fire({
                                    title: 'Berhasil',
                                    text: res.message ||
                                        'Status billing berhasil dikirim ulang.',
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
                                    text: res.message ||
                                        'Status billing gagal dikirim ulang.',
                                    icon: 'error'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            var message =
                                'Terjadi kesalahan saat mengirim ulang data.';

                            if (
                                xhr.responseJSON &&
                                xhr.responseJSON.message
                            ) {
                                message = xhr.responseJSON.message;
                            } else if (xhr.responseText) {
                                try {
                                    var response = JSON.parse(
                                        xhr.responseText
                                    );

                                    if (response.message) {
                                        message = response.message;
                                    }
                                } catch (parseError) {
                                    if (error) {
                                        message += ' ' + error;
                                    }
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
        });
    </script>

    <?php include 'footer.php'; ?>