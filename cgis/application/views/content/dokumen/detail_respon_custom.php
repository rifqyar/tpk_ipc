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
                        <td>NO Urut</td>
                        <td>KONTAINER</td>
                        <td>UKURAN</td>
                        <td>LOKASI</td>
                        <td>KETERANGAN</td>
                        <td>PERIKSA</td>
                        <td>STATUS PPK</td>
                        <td>PPK</td>
                        <td>ACTION</td>
                    </tr>
                    <?php $no = 0; foreach ($arrdata as $key => $value) {
                        $no++;
                    ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><span class="label label-success"><?php echo $value->no_antrian; ?></span></td>
                            <td><?php echo $value->NO_CONT ?></td>
                            <td><?php echo $value->SIZE ?></td>
                            <td><?php echo $value->LOKASI ?></td>
                            <td><?php echo $value->KETERANGAN ?></td>
                            <td>
                                <?php
                                    if ($value->FL_PERIKSA == 'Y') {
                                        echo 'Yes';
                                    } else {
                                        echo 'No';
                                    }
                                ?>
                            </td>
                            <td><?php echo $value->STATUS ?></td>
                            <td>
                            <?php
                                    if ($value->PPK) {
                                        echo $value->PPK;
                                    } else {
                                        echo '<span class="label label-danger">PPK NOT ACTIVE</span>';
                                    }
                                ?>
                            </td>
                            <td>
                                <?php
                                    if ($value->TGL_PPK) {
                                        echo '<span class="label label-success">PPK ACTIVE</span>';
                                    } else {
                                        echo '<span class="label label-danger">PPK NOT ACTIVE</span>';
                                    }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>