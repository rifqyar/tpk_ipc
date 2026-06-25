<div style="padding-left:20px">
  <h1>Error Pickup / Ganti TID</h1>
  <form method="post" action="pck">
    <label for="cont">No Kontainer/SPK:</label><br>
    <input type="text" id="cont" name="cont"><br><br>
    <button type="submit">Search</button>
  </form>


  <?php 

  if ($search != NULL) {
  ?>   <br>

  <h3>Data SPK</h3>
  <div style="overflow-x:auto;">
    <table>
      <tr>
        <th>ID</th>
        <th>No SPK</th>
        <th>No Container</th>
        <th>TID</th>
        <th>Status</th>
        <th>Opsi</th>
      </tr>
      <?php
      if ($search != NULL) {
        foreach ($search as $key) {
          ?>
          <tr>
            <td><?php echo $key->ID?></td>
            <td><?php echo $key->NO_SPK?></td>
            <td><?php echo $key->NO_CONT?></td>                 
            <td><?php echo $key->ID_FLAT?></td>                 
            <td><?php echo $key->FL_SEND_NPCT1?></td>                 
            <td><button id="myBtn" onclick="update('<?php echo $key->ID?>','<?php echo $key->NO_CONT?>')">Proses</button></td>
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
  <!-- The Modal -->
  <div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
      <span class="close">&times;</span>
      <h1>Pilih TID</h1>
      <form action="" method="POST" id="foo">
            <div class="modal-body">
            <input class="form-control" type="text" id="id" name="id" placeholder="" style="margin: 10px;" readonly>
            <label>Container</label>
            <input class="form-control" type="text" id="cont" name="cont" placeholder="" style="margin: 10px;" readonly>
            <label>Temperatur</label>
            <input class="form-control" type="text" id="temper" name="temper" placeholder="" style="margin: 10px;">
            <label>Tanggal Plug Terminal</label>
            <input class="form-control" type="datetime-local" id="tgl_plug" name="tgl_plug" placeholder="Tanggal Plug Terminal" style="margin: 10px;" required>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_upt_plug" onclick="submit_plug()" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>

  </div>
</div>
<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

function update(id, no_cont) {                    
  $('#myModal').modal();
  $('#id').val(id);
  $('#cont').val(no_cont);                  
  console.log("Hello world!");
}
</script>
</body>
</html>