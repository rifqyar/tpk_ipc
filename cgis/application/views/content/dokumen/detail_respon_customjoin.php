<?php 
	// print_r($arrdata);
?>

<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
    <span class="ribbon-inner">
    <i class="icon md-boat margin-0" aria-hidden="true"></i> <?php echo $title; ?>
    </span>
  </div>
  <br></br>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
            <div class="card-block p-a-0">
                <table class="table">
                    <tr>
                        <td>NO</td>
                        <td>NO URUT</td>
                        <td>KONTAINER</td>
                        <td>UKURAN</td>
                        <td>LOKASI</td>
                        <td>KETERANGAN</td>
                        <td>PPK KARANTINA</td>
                        <td>INFORMASI PEMERIKSA</td>
                        <td>JADWAL PERIKSA</td>
                    </tr>
                    <?php $no = 0; foreach ($arrdata as $key => $value) {
                        $no++;
                    ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $value->no_antrian ?></td>
                            <td><?php echo $value->NO_CONT ?></td>
                            <td><?php echo $value->SIZE ?></td>
                            <td><?php echo $value->LOKASI ?></td>
                            <td>BEHANDLE JOIN</td>
                            <td><?php echo $value->PPKKARANTINA ?></td>
                            <td>Karantina<br> Nama: <?php echo $value->NAMA ?><br>No Telp: <?php echo $value->NO_TELP ?>
                            <br><br>
                                Bea Cukai<br> Nama: <?php echo $value->NAMA_BC ?><br>No Telp: <?php echo $value->NO_TELPBC ?>
                            </td>
                            <td><?php echo $value->jadwal ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>