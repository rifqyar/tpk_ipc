<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets2/style.css?v13">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script> -->
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->

  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.5/css/buttons.dataTables.min.css"/>
 









<!DOCTYPE html>
<html>
<body>
    <h2 class="page-title" align="center">REPORT PENUMPUKKAN</h2>
<div class="container-fluid">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                
                    <a href="<?php echo site_url('operation/opr'); ?>"><H4 style="color:white;"></H4></a><br><br>

                    <div class=" col-md-12 form-group">
                    <div class="row">


                      
                        
                                <div class="form_group form_material">
                                    <div class="col-sm-4" >
                                        <input type="date" class="form-control" id="start_date" name="start_date"><!-- autofocus required> -->
                                    </div>
                                    <div class="col-sm-4" >
                                        <input type="date" class="form-control" id="end_date" name="end_date"><!-- autofocus required> -->
                                    </div>
                                    <div class="col-sm-4" >
                                        <button id="filter_button" class="btn btn-primary">Filter</button>
                                        <button id="reset_button" class="btn btn-default">Reset</button>
                                    </div>
                                </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <br>
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <div class="panel"><br>
                <div class="form-group form-material">
                    
                        <table id="data_table" class="display" style="width:100%">
                            <thead>
                                <tr style="background-color:#3f51b5;">
                                    <th><H6 style="color:white;">No</H6></th>
                                    <th><H6 style="color:white;">No Dokumen</H6></th>
                                    <th><H6 style="color:white;">Tgl Dokumen</H6></th>
                                    <th><H6 style="color:white;">No Container</H6></th>
                                    <th><H6 style="color:white;">Ukuran Container</H6></th>
                                    <th><H6 style="color:white;">Tipe Container</H6></th>
                                    <th><H6 style="color:white;">Waktu Masuk</H6></th>
                                    <th><H6 style="color:white;">No SPK</H6></th>
                                    <th><H6 style="color:white;">WAKTU_BEHANDLE_IN</H6></th>
                                    <th><H6 style="color:white;">GATEOUT</H6></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table><p>
                </div>
            </div>
        </div>
    <div>

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Search</h4>
            </div>
            <div class="modal-body">
                <div class=" col-md-12 form-group">
                    <div class="row">
                        <div class="col-md-offset-1 col-md-10">
                        <?php
                            echo form_open('operation/reportStack');
                        ?>
                                <div class="form_group form_material">
                                    <div class="col-sm-4" >
                                        <input type="date" class="form-control" id="start_date" name="start_date"><!-- autofocus required> -->
                                    </div>
                                    <div class="col-sm-4" >
                                        <input type="date" class="form-control" id="end_date" name="end_date"><!-- autofocus required> -->
                                    </div>
                                    <div class="col-sm-4" >
                                        <button id="filter_button" class="btn btn-primary">Filter</button>
                                        <button id="reset_button" class="btn btn-default">Reset</button>
                                    </div>
                                </div>
                        <?php
                            echo form_close();
                        ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
</div>
   <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
   <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/2.3.5/js/dataTables.buttons.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
   
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
   
   <script src="https://cdn.datatables.net/buttons/2.3.5/js/buttons.html5.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/2.3.5/js/buttons.print.min.js"></script>
   
   <script>
      
            // Inisialisasi datatables
            var table = $('#data_table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo site_url('Report/get_data_by_date_range') ?>",
                    "type": "POST",
                    "data": function(d) {
                        
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    }
                },
                "searching": true,
                "scrollX": false,
                "columns": [
                    {"data": "no", "orderable": false }, // Kolom nomor
                    {"data": "NO_DOK", "searchable": true},
                    {"data": "TGL_DOK", "searchable": true},
                    {"data": "NO_CONT", "searchable": true},
                    {"data": "UKR_CONT", "searchable": true},
                    {"data": "TIPE_CONT", "searchable": true},
                    {"data": "WAKTU_MASUK", "searchable": true},
                    {"data": "NO_SPK", "searchable": true},
                    {"data": "WAKTU_BEHADNLE_IN", "searchable": true},
                    {"data": "GATEOUT", "searchable": true}
                    // ...tambahkan kolom lainnya
                ],
                "pageLength": 20, // Menampilkan 10 baris per halaman
                "lengthMenu": [20,40,60,80,100], // Pilihan jumlah baris per halaman
                dom: "<'row'<'col-md-6'l><'col-md-6'f><'col-md-12'Br>>" + // Mengatur tata letak elemen pada tabel
                    "<'row'<'col-md-12't>><'row'<'col-md-6'i><'col-md-6'p>>", // Mengatur tata letak elemen pada tabel
                buttons: [{
                    extend: 'excelHtml5',
                    autoFilter: true,
                    sheetName: 'Exported data'
                }],
                "columnDefs": [
                { 
                    "targets": [ 0 ], //first column / numbering column
                    "orderable": false, //set not orderable
                },
                ],
                            

            });
            // Tambahkan nomor pada setiap baris
            table.on('draw.dt', function() {
                var info = table.page.info();
                table.column(0, {search:'applied', order:'applied'}).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
                });
            });
            // Fungsi untuk melakukan filter data berdasarkan tanggal
            $('#filter_button').click(function() {
                // var start_date = new Date($('#start_date').val());
                // var end_date = new Date($('#end_date').val());
                // if (end_date.getFullYear() === start_date.getFullYear() &&
                //     end_date.getMonth() < start_date.getMonth() ||
                //     end_date.getMonth() === start_date.getMonth() && end_date.getDate() < start_date.getDate()) {
                //     // Tanggal akhir tidak boleh kurang dari tanggal awal
                //     alert('Tanggal akhir tidak boleh kurang dari tanggal awal!');
                //     return false;
                // }
                // else{
                //     table.draw();
                // }
                var start_date = document.getElementById("start_date").value;
                var end_date = document.getElementById("end_date").value;

                var start_month = parseInt(start_date.split("-")[1]);
                var end_month = parseInt(end_date.split("-")[1]);

                var start_year = parseInt(start_date.split("-")[0]);
                var end_year = parseInt(end_date.split("-")[0]);

                if (end_year < start_year) {
                    alert("Tahun pada tanggal akhir tidak boleh kurang dari tahun pada tanggal awal.");
                    return false;
                } else if (end_year == start_year && end_month < start_month) {
                    alert("Tanggal akhir tidak boleh kurang dari bulan pada tanggal awal.");
                    return false;
                } else {
                    table.draw();
                }
            });

            // Fungsi untuk reset filter
            $('#reset_button').click(function() {
                $('#start_date').val('');
                $('#end_date').val('');
                table.draw();
            });

            // Menambahkan fungsi filter data berdasarkan tanggal
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var start_date = $('#start_date').val();
                    var end_date = $('#end_date').val();
                    var date_column = data[2]; // Kolom ke-3 adalah kolom tanggal

                    if ((start_date === '' || end_date === '') ||
                        (date_column >= start_date && date_column <= end_date)) {
                        return true;
                    }

                    return false;
                }
            );

            // Menambahkan fungsi reset filter
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    return true;
                }
            );
   </script>
   
</body>
</html>
