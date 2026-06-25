
<div class="container">
<a href="<?php echo site_url('operation/opr'); ?>">
	<H4 style="color:white;"><< MENU HANDHELD</H4>
</a>
  <br>
	<H5 align="center" style="color:white;">LIST CONTAINER</H5><br>
</div>
<hr>
  <div class="container-fluid">
               <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
					<th style="color:white;">NO KONTAINER</th>
					 <th style="color:white;">STATUS</th>
                     <th style="color:white;">UKURAN</th>
					 <th style="color:white;">TYPE CONTAINER</th>
					 <th style="color:white;">LABEL</th>
                   </tr>
                  </thead>
                  <tbody>
                   <?php
                     foreach ($nilai as $nilai2) { 
					 echo form_open('operation/listcontainer');
					 ?>
                     <tr>
                      <td>
					  <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $nilai2['ID']; ?>" >

					  <input type="text" class="form-control" id="nomercont" name="nomercont" value="<?php echo $nilai2['NO_CONT']; ?>" readonly >
					  </td>
					  <td>
					  <select class="form-control" id="status_tipe" name="status_tipe" required aria-required="true">
							<option value="">Choose...</option>
							<option value="F">FULL</option>
							<option value="E">EMPTY</option>
						</select>
					  </td>	
					  <td>
						<select class="form-control" id="ukuran" name="ukuran">
						<option value="<?php echo $nilai2['UKR_CONT']; ?>">
						<?php echo $nilai2['UKR_CONT']; ?>
						</option> 
							<option value="20">20</option>
							<option value="40">40</option>
							<option value="45" >45</option>
						</select>
					  </td>					  
					  <td>
					  <select class="form-control" id="tipe" name="tipe" required aria-required="true">
							<option value="">Choose...</option>
							<option value="DRY">DRY</option>
							<option value="HQ">HQ</option>
							<option value="OVD" >OVD</option>
							<option value="TNK">TNK</option>
							<option value="OT">OT</option>
							<option value="RFR">RFR</option>
						</select>
					  </td>

					  <td>
							 <select class="form-control" id="test" name="test" required aria-required="true">
									<?php 
									    if ($nilai2['FL_DG'] == 'Y') {
											$slctd = 'selected';
										}else {
											$slctd = '-';
										}
										if ($nilai2['IMO'] != '') {
											echo "	<option value='Y' ".$slctd.">DG</option>
													<option value='N'>NON DG</option>
													<option value='N'>DG NON LABEL</option>";
										}else{
											echo "	<option value='N'>NON DG</option>
													<option value='Y' ".$slctd.">DG</option>
													<option value='N'>DG NON LABEL</option>";
										}
									?>
								</select> 
					  </td>
                      <td>
                        <button id="str" type="submit"  class="btn btn-primary">PROSES</button>
                      </td>
                    </tr>
                    <?php 
					echo form_close();
					} ?>
                  </tbody>
                </table>
              </div>
     </div>
<!-- tutup else -->
