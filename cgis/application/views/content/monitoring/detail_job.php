<!DOCTYPE html>
<html>
<head>

</head>
<body>

<div class="container">
<div class="col-md-5 bg  navbar-right">

  <table class="table" align="right" width="100%">
    <tr>
		<td style="background-color: #dddddd;">STATUS</td>
		<td style="background-color: #dddddd;">WAKTU</td>
		<td style="background-color: #dddddd;">OPERATOR</td>
      </tr>
      <?php foreach ($result_cont as $key => $value) {

      ?>
      <tr>
        <td><?php echo $value->STATUS ?></td>
        <td><?php echo $value->WAKTU_STATUS ?></td>
		<td><?php echo $value->OPERATOR ?></td>
      </tr>	
      <?php } ?>
    </tbody>
  </table>
  </div>
</div>

</body>
</html>
