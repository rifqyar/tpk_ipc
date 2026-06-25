<!DOCTYPE html>
<html>
<head>

</head>
<style>
      .wtd{
            width: 31%;
      }
</style>
<body>

<div class="container">
  <div class="table-responsive">
  <table class="table">
	  <tr>
		<td style="background-color:blue;color:#FFF"><b>TGL. MONITORING</b></td>
		<td style="background-color:blue;color:#FFF"><b>JAM MONITORING</b></td>
		<td style="background-color:blue;color:#FFF">TEMPERATURE</td>
        <td style="background-color:blue;color:#FFF">CATATAN</td>
        <td style="background-color:blue;color:#FFF">OPERATOR</td>
      </tr>
      <tr>
        <td>
            <?php 
                foreach($monitor_plug as $row) {
                    echo date('d-m-Y', strtotime($row['WAKTU_MONITOR']));
                    echo "<br>";
                }
            ?>
        </td>
        <td>
            <?php 
                foreach($monitor_plug as $row) {
                    echo date('H:i:s', strtotime($row['WAKTU_MONITOR']));
                    echo "<br>";
                }
            ?>
        </td>
        <td>
            <?php 
                foreach($monitor_plug as $row) {
                    echo $row['TEMPERATURE_MONITOR'];
                    echo "<br>";
                }
            ?>
        </td>
        <td>
            <?php 
                foreach($monitor_plug as $row) {
                    echo $row['NOTE'];
                    echo "<br>";
                }
            ?>
        </td>
        <td>
            <?php 
                foreach($monitor_plug as $row) {
                    echo $row['OPERATOR_MONITOR'];
                    echo "<br>";
                }
            ?>
        </td>
      </tr>
    </tbody>
  </table>
  </div>
</div>

</body>
</html>
