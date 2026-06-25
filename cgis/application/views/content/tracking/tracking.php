<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Tracking Kontainer Common Area MTI</title>
</head>

<body class="bg-light">

    <div class="container">
        <main>
            <div class="py-5 text-center">
                <h2>Tracking History Kontainer Common Area MTI</h2>
            </div>

            <div class="row g-5">
                <div class="col-md-12 col-lg-12">
                    <h4 class="mb-3">Input Data</h4>
                    <form id="customform" class="needs-validation" method="POST">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="kontainer" class="form-label">No Container</label>
                                <input type="text" class="form-control" id="kontainer" name="kontainer" placeholder=""
                                    value="" required="">
                                <div class="invalid-feedback">
                                    Nomor Kontainer Diperlukan
                                </div>
                            </div>

                            <!-- <div class="col-12">
                                <label for="vessel" class="form-label">VESSEL</label>
                                <div class="input-group has-validation">
                                    <input type="text" class="form-control" id="vessel" name="vessel"
                                        placeholder="VESSEL" required="">
                                    <div class="invalid-feedback">
                                        Vessel is required.
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="voyage" class="form-label">NO VOYAGE</label>
                                <input type="text" class="form-control" id="voyage" name="voyage" placeholder="112S">
                                <div class="invalid-feedback">
                                    VOYAGE is required.
                                </div>
                            </div> -->

                            <hr class="my-4">

                            <button onclick="submited()" class="w-100 btn btn-primary btn-lg">Search</button>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped table-sm">
                            <!-- <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Data</th>
                                </tr>
                            </thead> -->
                            <tbody id="dataresult">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>

        <footer class="my-5 pt-5 text-muted text-center text-small">
    </div>


</body>
<script>
    function submited() {
        const form = document.querySelector("#customform");
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            const data = new FormData(e.target);
            const kontainer = data.get("kontainer");
            //const vessel = data.get("vessel");
            //const voyage = data.get("voyage");
            if (kontainer == '') {
                alert('Harap Melengkapi Data')
            } else {
                let notadata = [];
                notadata = `
                        <div style="margin: auto; width: 60%;padding: 10px;">
                            <div class="spinner-border" role="status" >
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>`;
                document.getElementById("dataresult").innerHTML = notadata;
                const formdata = new FormData();
                formdata.append("container", kontainer);
                // formdata.append("vessel", vessel);
                // formdata.append("voyage", voyage);

                const requestOptions = {
                    method: "POST",
                    body: formdata,
                    redirect: "follow"
                };
                fetch(
                    "<?php echo base_url(); ?>application.php/ApiTracking/getData"
                    , requestOptions)
                    .then((response) => response.json())
                    .then((json) => (notadata = json))
                    .then(document.getElementById("dataresult").innerHTML = '')
                    .then(() => {
                        for (let item of notadata) {
                            dataresult.innerHTML += `
                            <h2>Informasi</h2>
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Data</th>
                                </tr>
                            </thead>
                            <tr>
                                <td>Vessel</td>
                                <td>Nama Kapal</td>
                                <td>${item.VESSEL == null ? '-' : item.VESSEL}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Voyage IN</td>
                                <td>${item.VOY_IN == null ? '-' : item.VOY_IN}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Voyage OUT</td>
                                <td>${item.VOY_IN == null ? '-' : item.VOY_IN}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Waktu Bongkar</td>
                                <td>${item.DISCHARGE == null ? '-' : item.DISCHARGE}</td>
                            </tr>
                            <tr>
                                <td>Container</td>
                                <td>NO CONTAINER</td>
                                <td>${item.NO_CONT == null ? '-' : item.NO_CONT}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>SIZE</td>
                                <td>${item.UKR_CONT == null ? '-' : item.UKR_CONT}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>TYPE</td>
                                <td>${item.TIPE_CONT == null ? '-' : item.TIPE_CONT}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Lokasi</td>
                                <td>${item.LOCATION == null ? '-' : item.LOCATION}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Counter</td>
                                <td>${item.NO_SPK == null ? '-' : item.NO_SPK}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Vessel</td>
                                <td>${item.VESSEL == null ? '-' : item.VESSEL}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Voyage</td>
                                <td>${item.VOY_IN == null ? '-' : item.VOY_IN}</td>
                                <td></td>
                            </tr>
                            <h4>Handling</h4>
                            <thead>
                                <td>Kontainer</td>
                                <td>Kegiatan</td>
                                <td>Waktu</td>
                            </thead>

                            <tr>
                                <td>${item.NO_CONT == null ? '-' : item.NO_CONT}</td>
                                <td>BEHANDLE IN</td>
                                <td>${item.PRN_BEHANDLE_IN == null ? '-' : item.PRN_BEHANDLE_IN}</td>
                            </tr>

                            <tr>
                                <td></td>
                                <td>INSPECTION</td>
                                <td>${item.PB1_START_PERIKSA == null ? '-' : item.PB1_START_PERIKSA}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>GATE OUT</td>
                                <td>${item.WK_GATEOUT == null ? '-' : item.WK_GATEOUT}</td>
                            </tr>
                            <br>
                        `;
                            console.log(notadata)
                        }
                    });
            }
        });
    }
    function myDeleteFunction() {
        document.getElementById("myTable").deleteRow(0);
    }
</script>

</html>