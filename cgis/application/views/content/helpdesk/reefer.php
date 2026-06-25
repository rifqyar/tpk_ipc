<div style="padding-left:20px">
  <h1>Double Monitoring Reefer</h1>
  <form>
    <label for="cont">No Kontainer:</label><br>
    <input type="text" id="cont" name="cont"><br>
    <button type="submit">Search</button>
  </form>


<?php 

if ($search != NULL) {
  ?>   <br>
  <p>Hanya sisakan kolom waktu dan Monitor yang paling atas</p>

  <h3>Raw Data Plug</h3>
  <div style="overflow-x:auto;">
    <table>
      <tr>
        <th>ID</th>
        <th>No SPK</th>
        <th>No Container</th>
        <th>Waktu</th>
        <th>Waktu Monitor</th>
        <th>Temperatur</th>
        <th>Monitor</th>
        <th>Opsi</th>
      </tr>
      <?php
                                                    // var_dump($search);die();
      $datdok = $datser['nod'];
      $dattgl = $datser['tgl'];
                                                    // var_dump($dattgl);die();
      if ($search != NULL) {
        foreach ($search as $key) {
          ?>
          <tr>
            <td><?php echo $key->ID?></td>
            <td><?php echo $key->NO_SPK?></td>
            <td><?php echo $key->NO_CONT?></td>
            <td><?php echo $key->WAKTU?></td>
            <td><?php echo $key->WAKTU_MONITOR?></td>
            <td><?php echo $key->TEMPERATURE_MONITOR?></td>
            <td><?php echo $key->FL_PLUG?></td>                  
            <td><?php
            if ($key->FL_PLUG == 'Y' AND !empty($key->WAKTU)) {
              echo "<a href='".site_url()."/helpdesk/fixreefer?id=$key->ID&cont=$key->NO_CONT' OnClick=\"return confirm('Anda Yakin Ingin Hapus Data?');\"> Hapus </a>";
            } else {
              ?> - <?php
            }
            
          ?></td>
          </tr>
          <?php
        }
      }
      ?>
    </table>
  </div> <?php
} else {
  echo "<br>";
  echo "~";
}



?>
</div>
<script>

</script>
</body>
</html>