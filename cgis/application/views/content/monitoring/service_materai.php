<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Monitoring E-Materai</title>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
</head>
<script>
	function realtime() {
		setTimeout(function () {
			window.location.reload();
			// alert("Hello"); 
		}, 150000);
	}
</script>

<body>
	<div id='loadingmessage' style='display:none' class='se-pre-con' align="center">
	</div>
	<div class="panel-body" style="padding: 5px 0;">
		<div class="header" align="center">
			<?php //if($title!=""): ?>
			<h2 class="header-title">
				<?php echo "MONITORING E-MATERAI"; ?>
			</h2>
		</div>
		<div class="card-body">
			<form id="customform">
				<div class="mb-3">
					<label for="exampleform2" class="form-label">Pilih Menu</label>
					<select class="form-select" id="exampleform2" name="opsi" aria-label="Default select example">
						<option selected value="1">Belum Proses</option>
						<option value="2">Sukses Kirim ke portal</option>
						<option value="3">Menunggu stamp oleh portal e-materai</option>
						<option value="4">Selesai Stamp</option>
					</select>
				</div>
				<button onclick="submited()" class="btn btn-primary">Ambil data</button>
			</form>
		</div>
		<div class="card-body">
			<table id="example" class="display" style="width: 100%">
				<thead>
					<tr>
						<th>ID Request</th>
						<th>No Nota</th>
						<th>Tanggal Nota</th>
						<th>NOMINAL</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody id="tbody"></tbody>
			</table>
		</div>
	</div>
</body>
<script>
	function submited() {
		const form = document.querySelector("#customform");

		form.addEventListener("submit", (e) => {
			e.preventDefault();
			const data = new FormData(e.target);
			const opsi = data.get("opsi");
			if (opsi == "1") {
				getDatabelumproses();
			} else if (opsi == "2") {
				menunggukirimportal();
			} else if (opsi == "3") {
				menunggustamp();
			} else if (opsi == "4") {
				selesai_stamp();
			} else {
				console.log("error");
			}
		});
	}

	function getDatabelumproses() {
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
		fetch(
			"<?php echo base_url(); ?>application.php/ServiceMaterai/listnota_belumproses"
		)
			.then((response) => response.json())
			.then((json) => (notadata = json))
			.then(() => {
				for (let item of notadata) {
					tbody.innerHTML += `
				<td>${item.ID_REQ}</td>
				<td>${item.NO_NOTA}</td>
				<td>${item.TGL_NOTA}</td>
				<td>${item.TOTAL_JUMLAH}</td>
				<td>-</td>
				`;
				}
				let table = new DataTable("#example");
			});
	}

	function menunggukirimportal() {
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
		fetch(
			"<?php echo base_url(); ?>application.php/ServiceMaterai/listnota_sudah_kirim"
		)
			.then((response) => response.json())
			.then((json) => (notadata = json))
			.then(() => {
				for (let item of notadata) {
					tbody.innerHTML += `
				<td>${item.ID_REQ}</td>
				<td>${item.NO_NOTA}</td>
				<td>${item.TGL_NOTA}</td>
				<td>${item.TOTAL_JUMLAH}</td>
				<td>-</td>
				`;
				}
				let table = new DataTable("#example");
			});

	}
	function menunggustamp() {
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
		fetch(
			"<?php echo base_url(); ?>application.php/ServiceMaterai/listnota_menunggu_stamp"
		)
			.then((response) => response.json())
			.then((json) => (notadata = json))
			.then(() => {
				for (let item of notadata) {
					tbody.innerHTML += `
				<td>${item.ID_REQ}</td>
				<td>${item.NO_NOTA}</td>
				<td>${item.TGL_NOTA}</td>
				<td>${item.TOTAL_JUMLAH}</td>
				<td>-</td>
				`;
				}
				let table = new DataTable("#example");
			});

	}
	function selesai_stamp() {
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
		fetch(
			"<?php echo base_url(); ?>application.php/ServiceMaterai/stamped_nota_finished"
		)
			.then((response) => response.json())
			.then((json) => (notadata = json))
			.then(() => {
				for (let item of notadata) {
					tbody.innerHTML += `
				<td>${item.ID_REQ}</td>
				<td>${item.NO_NOTA}</td>
				<td>${item.TGL_NOTA}</td>
				<td>${item.TOTAL_JUMLAH}</td>
				<td><a href="<?php echo base_url(); ?>application.php/ServiceMaterai/redirector_stamp?nota=${item.NO_NOTA}" target="_blank">Lihat Nota</a></td>
				`;
				}
				let table = new DataTable("#example");
			});

	}
</script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

</html>