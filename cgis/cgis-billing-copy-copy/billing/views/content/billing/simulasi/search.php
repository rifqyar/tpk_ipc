<?php
  echo form_open('customer/src');
?>
<div class="container">
  <div class="form_group form_material">
    <div class="col-sm-4" >
      <input style="border-radius:10px; border: 2px solid #a1a1a1;"  class="form-control" type="text" name="search_js" placeholder=" SEARCH NO DOKUMEN" autofocus required>
    </div>
    <div class="col-sm-2" >
      <button type="submit" class="btn btn-primary" style="border-radius:10px; border: 2px solid #a1a1a1;">Search</button>
    </div>
  </div>
</div>


<?php
  echo form_close();
  //echo form_open('operation/marshalling');
  if ($status==1) { //print_r($result[0]['NO_DAFTAR_PABEAN']);die(); ?>
      <div class="container">
              <div class="row">
                  <div class="form-group form-material"><br><br>
                     <table class="table">
                       <tr>
                         <th>NO</th>
                         <th>NO. NO DAFTAR PABEAN</th>
                         <th>TGL. DOKUMEN</th>
                         <th>NO. DOKUMEN</th>
                       </tr>
                       <?php
                       $no = 1;
                       //foreach ($nilai as $nilai2): ?>
                       <tr>
                       <td>
                       	<?php echo $no++; ?>
                       </td>
                        <td>
                        	<?php echo $result[0]['NO_DAFTAR_PABEAN'] ?>
                        </td>
                        <td>
                        	<?php echo $result[0]['TGL_DOK_INOUT'] ?>
                        </td>
                        <td>
                        	<?php echo $result[0]['NO_DOK_INOUT'] ?>
                        </td>
                      </tr>
                       <?php //endforeach; ?>
                    </table>
                 </div>
              </div>
        </div>
      </div>
  <?php
}else { ?>
  <br>
  <div class="container-fluid">
    <?php if (isset($kode)): ?>
      <?php switch ($kode) {
        case 1:
          echo "<br>
          <div class= 'alert alert-danger' style='font-size:16px; font-family:sant-serif; font-weight:bold; ' >
             WARNING ! NO. DOKUMEN : $jobs TIDAK DITEMUKAN
          </div>";
          break;
        default:
          echo "";
          break;
      } ?>
    <?php endif ?>
           <div class="form-group form-material">
             
          </div>
     </div>
<!-- tutup else -->
<?php }
echo form_close();
?>
