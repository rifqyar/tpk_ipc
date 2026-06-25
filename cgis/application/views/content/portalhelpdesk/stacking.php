<?php include 'header.php'; ?>

<div class="page-heading">
    <h3>Update Stacking</h3>
</div>
<div class="page-content">
    <section class="row">
        <form id="customform">
            <div class="mb-3">
                <label for="kontainer" class="form-label">Nomor Kontainer</label>
                <input type="text" name="kontainer" class="form-control" id="exampleFormControlInput1">
            </div>
            <div class="mb-3">
                <button onclick="submited()" class="btn btn-primary">Cari</button>
            </div>
        </form>
        <div class="card-body">
            <table id="example" class="display" style="width: 100%">
                <thead>
                    <tr>
                        <th>ID Data</th>
                        <th>VESSEL</th>
                        <th>VOYAGE</th>
                        <th>CONTAINER</th>
                        <th>STACK</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbody"></tbody>
            </table>
        </div>
    </section>
</div>

<!-- modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Stacking</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="customform1">
                    <div class="mb-3">
                        <label for="kontainerstack" class="form-label">Kontainer</label>
                        <input type="text" disabled class="form-control" id="kontainerstack">
                    </div>
                    <div class="mb-3">
                        <div id="liveAlertPlaceholder"></div>
                        <label for="tglstack" class="form-label">Waktu Stack</label>
                        <input type="datetime-local" class="form-control" id="tglstack" name="stack">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button onclick="updateDataStack()" type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    let selectedId = "hey im null";
    let selectedContainer = "";
    let tanggalstack = "";
    let hasilRespon = "";

    //alert
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
    }

    function submited() {
        const form = document.querySelector("#customform");
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            const data = new FormData(e.target);
            const opsi = data.get("kontainer");
            var formdata = new FormData();

            formdata.append("container", opsi);
            var requestOptions = {
                method: 'POST',
                body: formdata
            };
            fetch(
                "<?php echo base_url(); ?>application.php/PortalHelpdesk/stacking_get_data", requestOptions)
                .then((response) => response.json())
                .then((json) => (notadata = json))
                .then(() => {
                    for (let item of notadata) {
                        tbody.innerHTML += `
                <td>${item.ID}</td>
                <td>${item.NM_ANGKUT}</td>
                <td>${item.NO_VOY_FLIGHT}</td>
                <td>${item.NO_CONT}</td>
                <td>${item.WK_IN}</td>
                <td><button onclick="selectdata(${item.ID}, '${item.NO_CONT}')" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Edit
                    </button>
                </td>
                `;
                    }
                    let table = new DataTable("#example");

                });
        });
    }

    function selectdata(id, nocont) {
        selectedId = id;
        selectedContainer = nocont;
        document.getElementById("kontainerstack").value = nocont;
    }

    function updateDataStack() {
        tanggalstack = document.getElementById("tglstack").value;
        if (!tanggalstack) {
            appendAlert('Anda Belum Mengisi Tanggal', 'danger');
        } else {
            // console.log(tanggalstack);
            //post
            var formdata = new FormData();
            formdata.append("id", selectedId);
            formdata.append("container", selectedContainer);
            formdata.append("tanggal", tanggalstack);

            var requestOptions = {
                method: 'POST',
                body: formdata,
                redirect: 'follow'
            };

            fetch("<?php echo base_url(); ?>application.php/PortalHelpdesk/stacking_update_data", requestOptions)
                .then(response => response.text())
                .then(result => {
                    hasilRespon = result
                    if (hasilRespon == 1) {
                        console.log('suges');
                    }
                })
                .catch(error => console.log('error', error));
        }
    }
</script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<?php include 'footer.php'; ?>