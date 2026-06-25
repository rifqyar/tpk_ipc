<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
    <span class="ribbon-inner">
      <i class="icon md-lock-open" aria-hidden="true"></i> <?php echo "REPORT BC NEW"; ?>
    </span>
  </div>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <?php if (!empty($arrdata)): ?>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>NO_CONT</th>
                <th>NO_DOK</th>
                <th>TGL_DOK</th>
                <th>RESPON</th>
                <th>WK_RESPON</th>
                <th>WK_REQUEST_GATEPASS_TERMINAL</th>
                <th>APPROVE_GATEPASS_TERMINAL</th>
                <th>NPWP</th>
                <th>NAMA_CUST</th>
                <th>NO_SPK</th>
                <th>TERBIT_SPK</th>
                <th>BEHANDLE_IN</th>
                <th>MARSHALLING_BEHANDLE_1</th>
                <th>START_PERIKSA</th>
                <th>SELESAI_PERIKSA</th>
                <th>MARSHALLING_EX-BEHANDLE_1</th>
                <th>TRUCK_IN</th>
                <th>TRUCK_OUT</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($arrdata as $row): ?>
                <tr>
                  <td><?php echo $row['NO_CONT']; ?></td>
                  <td><?php echo $row['NO_DOK']; ?></td>
                  <td><?php echo $row['TGL_DOK']; ?></td>
                  <td><?php echo $row['RESPON']; ?></td>
                  <td><?php echo $row['WK_RESPON']; ?></td>
                  <td><?php echo $row['WK_REQUEST_GATEPASS_TERMINAL']; ?></td>
                  <td><?php echo $row['APPROVE_GATEPASS_TERMINAL']; ?></td>
                  <td><?php echo $row['NPWP']; ?></td>
                  <td><?php echo $row['NAMA_CUST']; ?></td>
                  <td><?php echo $row['NO_SPK']; ?></td>
                  <td><?php echo $row['TERBIT_SPK']; ?></td>
                  <td><?php echo $row['BEHANDLE_IN']; ?></td>
                  <td><?php echo $row['MARSHALLING_BEHANDLE_1']; ?></td>
                  <td><?php echo $row['START_PERIKSA']; ?></td>
                  <td><?php echo $row['SELESAI_PERIKSA']; ?></td>
                  <td><?php echo $row['MARSHALLING_EX-BEHANDLE_1']; ?></td>
                  <td><?php echo $row['TRUCK_IN']; ?></td>
                  <td><?php echo $row['TRUCK_OUT']; ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <p>No data found.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
