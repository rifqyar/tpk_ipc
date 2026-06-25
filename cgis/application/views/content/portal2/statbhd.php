<?php include 'header.php'; ?>

<div class="page-heading">
    <h3>Hapus Status Pembayaran Nota Behandle</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">NOMOR DOKUMEN</label>
            <input type="text" class="form-control" id="nodok" name="nodok"
                placeholder="Nomor dokumen yang dipakai buat bayar">
        </div>
        <div class="mb-3">
            <button type="button" class="btn btn-primary" onclick="fetchData()">Cari</button>
        </div>
        <br>
        <table class="table table-bordered mt-3" id="resultTable" style="display:none;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NO DOK</th>
                    <th>TGL DOK</th>
                    <th>JNS DOK</th>
                    <th>NO CONT</th>
                    <th>FL BIL</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody id="resultBody">
            </tbody>
        </table>
    </section>
</div>
    <script>
    function fetchData() {
        const nodok = document.getElementById('nodok').value;

        // Prepare the data to send
        const formData = new FormData();
        formData.append('nodok', nodok);

        // Send the POST request
        fetch('<?php echo base_url(); ?>/application.php/Portal2/get_data_billing', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                // Show the table
                document.getElementById('resultTable').style.display = 'table';

                // Clear previous results
                const resultBody = document.getElementById('resultBody');
                resultBody.innerHTML = '';

                // Populate the table with the new data
                data.forEach(item => {
                    const row = `<tr>
                        <td>${item.ID}</td>
                        <td>${item.NO_DOK}</td>
                        <td>${item.TGL_DOK}</td>
                        <td>${item.JNS_DOK}</td>
                        <td>${item.NO_CONT}</td>
                        <td>${item.FL_BIL}</td> 
                        <td>
                            <button onclick="proses('${item.ID}')">Hapus Data</button>
                        </td>
                    </tr>`;
                    resultBody.innerHTML += row;
                });
            } else {
                // If no data, hide the table
                document.getElementById('resultTable').style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
    }
    function proses(ID) {
    alert('Item ID: ' + ID);
}
    </script>

<?php include 'footer.php'; ?>