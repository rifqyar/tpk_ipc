<style>
/* Accordion Styles */
.accordion-section {
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.accordion-header {
    padding: 10px;
    cursor: pointer;
    background: #f1f1f1;
    font-weight: bold;
    transition: background 0.3s;
}
.accordion-header:hover {
    background: #e2e2e2;
}

.accordion-body {
    display: none;
    padding: 10px;
}
.accordion-section.active .accordion-body {
    display: block;
}

/* Form Styles */
.form-input {
    margin-bottom: 10px;
    width: 250px;
    padding: 7px;
    border-radius: 4px;
    border: 1px solid #ccc;
}

/* Result Table Styles */
#result {
    margin-top: 15px;
}
#result table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}
#result th, #result td {
    border: 1px solid #ccc;
    padding: 8px 12px;
    text-align: left;
}
#result th {
    background-color: #f2f2f2;
}
#result tr:nth-child(even) {
    background-color: #fafafa;
}

/* Action Buttons */
.action-btn {
    padding: 4px 8px;
    margin-right: 4px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    font-size: 12px;
}
.action-edit { background-color: #4CAF50; color: white; }
.action-delete { background-color: #f44336; color: white; }
</style>

<div class="accordion-section">
    <div class="accordion-header">Set Announce</div>
    <div class="accordion-body">
        <form id="announceForm" method="post">
            <input type="text" name="no_container" placeholder="NO CONTAINER" class="form-input"><br>
            <input type="text" name="no_spk" placeholder="NO SPK" class="form-input"><br>
            <button type="submit" class="btn btn-primary">GET DATA</button>
        </form>
        <div id="result"></div>
    </div>
</div>

<div class="accordion-section">
    <div class="accordion-header">Siap Periksa → Belum Siap Periksa</div>
    <div class="accordion-body">
        <form id="periksaForm" method="post">
            <input type="text" name="no_container" placeholder="NO CONTAINER" class="form-input"><br>
            <button type="submit" class="btn btn-primary">CEK DATA</button>
        </form>
        <div id="resultPeriksa"></div>
    </div>
</div>

<div class="accordion-section">
    <div class="accordion-header">Selesai Periksa → Siap Periksa</div>
    <div class="accordion-body">
        <form id="selesaiForm" method="post">
            <input type="text" name="no_container" placeholder="NO CONTAINER" class="form-input"><br>
            <button type="submit" class="btn btn-primary">CEK DATA</button>
        </form>
        <div id="resultSelesai"></div>
    </div>
</div>

<script>
document.querySelectorAll('.accordion-header').forEach(header => {
    header.addEventListener('click', () => {
        header.parentElement.classList.toggle('active');
    });
});

// Function untuk menangani submit form
function submitAnnounceForm(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    fetch('<?php echo site_url('Replaning/get_spk_for_announce'); ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const resultDiv = document.getElementById('result');
        if (data.status) {
            let html = `<table>
                            <tr>
                                <th>NO_SPK</th>
                                <th>NO_CONT</th>
                                <th>KETERANGAN</th>
                                <th>OPSI</th>
                            </tr>`;
            data.data.forEach(row => {
                html += `<tr>
                            <td>${row.NO_SPK}</td>
                            <td>${row.NO_CONT}</td>
                            <td>${row.KETERANGAN}</td>
                            <td>
                                <button class="action-btn action-delete" onclick="prose_mundur_announce('${row.NO_SPK}','${row.NO_CONT}')">Kembali ke Announce</button>
                            </td>
                         </tr>`;
            });
            html += '</table>';
            resultDiv.innerHTML = html;
        } else {
            resultDiv.innerHTML = `<span style="color:red">${data.message}</span>`;
        }
    })
    .catch(err => {
        document.getElementById('result').innerHTML = `<span style="color:red">Terjadi kesalahan: ${err}</span>`;
    });
}

document.getElementById('periksaForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('<?php echo site_url("replaning/get_spk_periksa"); ?>', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        const resultDiv = document.getElementById('resultPeriksa');

        if (data.status) {
            let html = `<table>
                <tr>
                    <th>NO_SPK</th>
                    <th>NO_CONT</th>
                    <th>STATUS</th>
                    <th>LOKASI</th>
                    <th>OPSI</th>
                </tr>`;

            data.data.forEach(row => {
                html += `<tr>
                    <td>${row.NO_SPK}</td>
                    <td>${row.NO_CONT}</td>
                    <td>${row.STATUS_CONT}</td>
                    <td>${row.LOKASI}</td>
                    <td>
                        <button class="action-btn action-delete" 
                            onclick="proses_mundur_periksa('${row.NO_CONT}','${row.NO_DOK}')">
                            Mundurkan
                        </button>
                    </td>
                </tr>`;
            });

            html += `</table>`;
            resultDiv.innerHTML = html;
        } else {
            resultDiv.innerHTML = `<span style="color:red">${data.message}</span>`;
        }
    });
});

function proses_mundur_periksa(noCont, noDok) {
    if (!confirm(`Yakin mundurkan container ${noCont}?`)) return;

    const formData = new FormData();
    formData.append('no_container', noCont);
    formData.append('no_dok', noDok);

    fetch('<?php echo site_url("replaning/set_periksa"); ?>', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        let html = '<h4>Hasil:</h4><ul>';
        for (let key in data) {
            html += `<li><b>${key}</b>: ${data[key]}</li>`;
        }
        html += '</ul>';

        document.getElementById('resultPeriksa').innerHTML = html;
    });
}

// Pasang event listener ke form
document.getElementById('announceForm').addEventListener('submit', submitAnnounceForm);

function prose_mundur_announce(noSpk, noCont) {
    if (confirm(`Apakah yakin ingin mengembalikan data NO_SPK: ${noSpk}, NO_CONT: ${noCont}?`)) {
        // Siapkan data POST
        const formData = new FormData();
        formData.append('no_spk', noSpk);
        formData.append('no_container', noCont);

        fetch('<?php echo site_url("replaning/set_announce"); ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Tampilkan log response
            let logHtml = '<h4>Hasil Proses:</h4><ul>';
            for (const key in data) {
                if (data.hasOwnProperty(key)) {
                    logHtml += `<li><strong>${key}:</strong> ${data[key]}</li>`;
                }
            }
            logHtml += '</ul>';
            document.getElementById('result').innerHTML = logHtml;
        })
        .catch(err => {
            document.getElementById('result').innerHTML = `<span style="color:red">Terjadi kesalahan: ${err}</span>`;
        });
    }
}

document.getElementById('selesaiForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('<?php echo site_url("replaning/get_spk_selesai"); ?>', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        const resultDiv = document.getElementById('resultSelesai');

        if (data.status) {
            let html = `<table>
                <tr>
                    <th>NO_SPK</th>
                    <th>NO_CONT</th>
                    <th>DOKUMEN</th>
                    <th>TANGGAL</th>
                    <th>OPSI</th>
                </tr>`;

            data.data.forEach(row => {
                html += `<tr>
                    <td>${row.NO_SPK}</td>
                    <td>${row.NO_CONT}</td>
                    <td>${row.NO_DOK}</td>
                    <td>${row.TGL_DOK}</td>
                    <td>
                        <button class="action-btn action-delete" 
                            onclick="proses_mundur_selesai('${row.NO_CONT}','${row.NO_DOK}')">
                            Mundurkan ke Siap Periksa
                        </button>
                    </td>
                </tr>`;
            });

            html += `</table>`;
            resultDiv.innerHTML = html;
        } else {
            resultDiv.innerHTML = `<span style="color:red">${data.message}</span>`;
        }
    });
});

function proses_mundur_selesai(noCont, noDok) {
    if (!confirm(`Yakin mundurkan container ${noCont} ke Siap Periksa?`)) return;

    const formData = new FormData();
    formData.append('no_container', noCont);
    formData.append('no_dok', noDok);

    fetch('<?php echo site_url("replaning/set_selesai"); ?>', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        let html = '<h4>Hasil:</h4><ul>';
        for (let key in data) {
            html += `<li><b>${key}</b>: ${data[key]}</li>`;
        }
        html += '</ul>';

        document.getElementById('resultSelesai').innerHTML = html;
    })
    .catch(err => {
        document.getElementById('resultSelesai').innerHTML =
            `<span style="color:red">Error: ${err}</span>`;
    });
}

</script>
