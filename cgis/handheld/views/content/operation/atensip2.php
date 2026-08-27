<?php
echo form_open('atensip2/search');
?>
<div class="container">
  <H4 style="color:white;">MENU ATENSI P2</H4>
  <br>
  <H5 style="color:white;">ATENSI P2</H5><br>
  <div class="form_group form_material">
    <div class="col-sm-3 col-md-3">
      <input style=" border: 1px solid #a1a1a1;" class="form-control" type="text" name="search" placeholder="SEARCH NO CONT / NO. DOK / NO. SPK" autofocus required>
    </div>
    <div class="col-sm-1 col-md-1">
      <button type="submit" class="btn btn-primary" style="border: 1px solid #a1a1a1;">SEARCH</button>
    </div>
  </div>
</div>
<hr>
<?php
echo form_close();
?>

<div class="container">
  <?php if (isset($notif)): ?>
    <?php switch ($notif) {
      case 1:
        echo "
           <br>
           <div class= 'alert alert-primary' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
              NO CONT : $nilai SUCCESS SUBMIT ATENSI
           </div>";
        break;
      case 2:
        echo "
           <br>
           <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
              NO CONT : $nilai NOT FOUND
           </div>";
        break;
      case 3:
        echo "
           <br>
           <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
              NO CONT : $nilai GAGAL DILAKUKAN HOLD ATENSI P2, HUBUNGI IT
           </div>";
        break;
      default:
        echo "
            <br>
            <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
               NO CONT : $nilai NOT FOUND
            </div>";
        break;
    } ?>
  <?php endif ?>
</div>
<?php
if (isset($status)) {
  if ($status == 1) {
    echo form_open('atensip2/hold_cont');
?>
    <div class="container-fluid">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th style="color:white;">NO SPK</th>
              <th style="color:white;">NO CONTAINER</th>
              <th style="color:white;">NO DOKUMEN</th>
              <th style="color:white;">TANGGAL DOKUMEN</th>
              <th style="color:white;">JENIS DOKUMEN</th>
            </tr>
          </thead>
          <tbody>
            <? foreach ($nilai as $val) {
            ?>

              <tr>
                <td>
                  <input type="hidden" class="form-control" id="id" name="id" value="<?= $val['ID']; ?>">

                  <input type="text" class="form-control" id="nospk" name="nospk" value="<?= $val['NO_SPK']; ?>" readonly>
                </td>
                <td>
                  <input type="text" class="form-control" id="nomercont" name="nomercont" value="<?= $val['NO_CONT']; ?>" readonly>
                </td>
                <td>
                  <input type="text" class="form-control" id="nodok" name="nodok" value="<?= $val['NO_DOK']; ?>" readonly>
                </td>
                <td>
                  <input type="text" class="form-control" id="tgldok" name="tgldok" value="<?= $val['TGL_DOK']; ?>" readonly>
                </td>
                <td>
                  <input type="text" class="form-control" id="jnsdok" name="jnsdok" value="<?= $val['JNS_DOK']; ?>" readonly>
                </td>
                <td>
                  <button id="str" type="submit" class="btn btn-primary">Hold Container</button>
                </td>
              </tr>
            <?
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
<?php
    echo form_close();
  }
}
?>