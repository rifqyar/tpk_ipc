<?php include 'header.php'; ?>

<div class="page-heading">
    <h3>Bypass Penarikan</h3>
</div>
<div class="page-content">
    <p>Menu ini digunakan untuk set Inquiry data kontainer yang sudah ada di common area</p>
    <p>Contoh NHI jalur hijau</p>
</div>
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Input Dokumen</h4>
    </div>

    <div class="card-body">
        <div class="row">
            <form id="customform">
                <div class="col-md">
                    <div class="form-group">
                        <label for="nodok">Nomor Dokumen</label>
                        <input type="text" class="form-control" id="nodok" name="nodok" placeholder="Enter Nodok">
                    </div>

                    <div class="form-group">
                        <label for="tgldok">Tanggal Dokumen</label>
                        <input type="text" class="form-control" id="tgldok" name="tgldok"
                            placeholder="Contoh = 2024-01-31">
                    </div>
                    <div class="form-group">
                        <button onclick="submited()" class="btn btn-primary">Ambil data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <table id="example" class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">NO Dokumen</th>
                        <th scope="col">Tanggal Dokumen</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbody"></tbody>
            </table>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Log Riwayat</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <table id="bypass" class="table">
                <thead>
                    <tr>
                        <th scope="col">NO Dokumen</th>
                        <th scope="col">Tanggal Dokumen</th>
                        <th scope="col">Aksi</th>
                        <th scope="col">Waktu Get</th>
                    </tr>
                </thead>
                <tbody id="userpake">
                    <?php
                    foreach ($log_data as $key => $value) {
                        echo "<tr>
                                <td>$value->DOK</td>
                                <td>$value->TGL</td>
                                <td>$value->USERGET</td>
                                <td>$value->WK_PROSES</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Bypass Penarikan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="liveAlertPlaceholder"></div>
                <div class="form-group">
                    <label for="p1">No Dok</label>
                    <input type="text" class="form-control" id="p1" disabled>
                </div>
                <div class="form-group">
                    <label for="p1">Tanggal Dok</label>
                    <input type="text" class="form-control" id="p2" disabled>
                </div>
                <p id="p2"></p>
                <p>List Kontainer</p>
                <table id="example" class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">No Kontainer</th>
                            <th scope="col">UKR</th>
                            <th scope="col">Tipe</th>
                        </tr>
                    </thead>
                    <tbody id="tbodymodal"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button onclick="simpanPerubahan()" type="button" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>


<script>
    function submited() {
        const form = document.querySelector("#customform");
        var table = $("#example").DataTable();
        table.destroy();
        let notadata = [];
        notadata = `
        <div style="margin: auto; width: 60%;padding: 10px;">
            <div class="spinner-border" role="status" >
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>`;
        document.getElementById("tbody").innerHTML = notadata;

        form.addEventListener("submit", (e) => {
            e.preventDefault();
            const data = new FormData(e.target);
            const nodok = data.get("nodok");
            const tgldok = data.get("tgldok");

            //fetch start
            var formdata = new FormData();
            formdata.append("nodok", nodok);
            formdata.append("tgldok", tgldok);

            var requestOptions = {
                method: 'POST',
                body: formdata,
                redirect: 'follow'
            };

            fetch("<?php echo base_url(); ?>application.php/PortalHelpdesk/get_data_request", requestOptions)
                .then((response) => response.json())
                .then((json) => (notadata = json))
                .then(() => {
                    for (let item of notadata) {
                        tbody.innerHTML += `
                <td>${item.ID}</td>
                <td>${item.NO_DOK}</td>
                <td>${item.TGL_DOK}</td>
                <td>${item.KD_REQ}</td>
                <td><button onclick="setModalValue('${item.NO_DOK}','${item.TGL_DOK}')" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Set Inquiry
                    </button>
                </td>
                `;
                    }
                    let table = new DataTable("#example");
                    table.draw();
                });

            //fetch end
        });
    }

    function setModalValue(nodok, tgldok) {
        let nomors = 1;
        tbodymodal.innerHTML = '';
        document.getElementById("p1").value = nodok;
        document.getElementById("p2").value = tgldok;
        //fetch start
        var formdata = new FormData();
        formdata.append("nodok", nodok);
        formdata.append("tgldok", tgldok);

        var requestOptions = {
            method: 'POST',
            body: formdata,
            redirect: 'follow'
        };

        fetch("<?php echo base_url(); ?>application.php/PortalHelpdesk/get_data_request_kontainer", requestOptions)
            .then((response) => response.json())
            .then((json) => (notadata = json))
            .then(() => {
                for (let item of notadata) {
                    tbodymodal.innerHTML += `
                <td>${nomors++}</td>
                <td>${item.NO_CONT}</td>
                <td>${item.UKR_CONT}</td>
                <td>${item.TIPE_CONT}</td>
                `;
                }
            });

        //fetch end
    }

    function simpanPerubahan() {
        const alertPlaceholder = document.getElementById('liveAlertPlaceholder')
        const appendAlert = (message, type) => {
            const wrapper = document.createElement('div')
            wrapper.innerHTML = [
                `<div class="alert alert-${type} alert-dismissible" role="alert">`,
                `   <div>${message}</div>`,
                '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
                '</div>'
            ].join('')

            alertPlaceholder.append(wrapper)
            setTimeout(function () {
                window.location.reload();
            }, 1500);
        }

        dok = document.getElementById("p1").value;
        tgl = document.getElementById("p2").value;

        //fetch start
        var formdata = new FormData();
        formdata.append("nodok", dok);
        formdata.append("tgldok", tgl);

        var requestOptions = {
            method: 'POST',
            body: formdata,
            redirect: 'follow'
        };

        fetch("<?php echo base_url(); ?>application.php/PortalHelpdesk/bypass_request_set", requestOptions)
            .then((response) => response.json())
            .then(result => result)
            .then((result) => {
                if (result == 0) {
                    appendAlert('Data Gagal disimpan!', 'danger')
                } else {
                    appendAlert('Sukses proses data!', 'success')
                }
            })
            .catch(error => console.log('error', error));

        //fetch end
    }
</script>

<?php include 'footer.php'; ?>