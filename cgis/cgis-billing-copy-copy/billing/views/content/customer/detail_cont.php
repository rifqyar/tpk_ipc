<!DOCTYPE html>
<html>
<head>
  
</head>
<body>

<div class="container">
  <div class="table-responsive">          
  <table class="table">
    <thead>
      <tr>
            <!-- <td>NO.</td> -->
            <!-- <td style="background-color:silver">NO. SPK</td> -->
            <td style="background-color:silver">NO. KONTAINER</td>
            <td style="background-color:silver">DOKUMEN</td>

            <td style="background-color:silver">WAKTU START</td>
            <td style="background-color:silver">WAKTU FINISH</td>
      </tr>
    </thead>
    <tbody>
      <?php $NO = 0; foreach ($result_cont as $key => $value) {
      
      $no++;
        
      ?>
      

      <tr>
        <!-- <td><?php echo $no; ?></td> -->
        <!-- <td><?php echo $value->NO_SPK ?></td> -->
        <td><?php echo $value->NO_CONT ?></td>
        <td><?php echo $value->JNS_DOK ?><BR><?php echo $value->NO_DOK ?><BR><?php echo $value->TGL_DOK ?></td>

        <td><?php echo $value->WK_START ?></td>
        <td><?php echo $value->WK_FINISH ?></td>
      </tr>
      
      <?php } ?>
    </tbody>
  </table>
  </div>
</div>

</body>
</html>
