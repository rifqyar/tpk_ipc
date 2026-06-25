<div style="padding-left:20px">
  <h1>Waktu Terakhir Get Data SSM</h1>
  <div style="overflow-x:auto;">
    <table>
      <tr>
        <th>Waktu</th>
      </tr>
      <?php
      if ($search != NULL) {
        foreach ($search as $key) {
          ?>
          <tr>
            <td><?php echo $key->tgl_get?></td>                  
          </tr>
          <?php
        }
      }
      ?>
    </table>
  </div>
</div>
<script>

</script>
</body>
</html>