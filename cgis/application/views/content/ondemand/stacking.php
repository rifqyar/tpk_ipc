<?php include 'header.php'; ?>

<div class="page-heading">
    <h3>Update Stacking</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="card-body">
            <table id="example" class="display" style="width: 100%">
                <thead>
                    <tr>
                        <th>ID Data</th>
                        <th>VESSEL</th>
                        <th>VOYAGE</th>
                        <th>CONTAINER</th>
                        <th>STACK</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbody"></tbody>
                <?php
                foreach ($log_data as $key => $value) {
                    echo "<tr>
                    <td>{$value->ID}</td>
                    <td>{$value->NM_ANGKUT}</td>
                    <td>{$value->NO_VOY_FLIGHT}</td>
                    <td>{$value->NO_CONT}</td>
                    <td>{$value->WK_IN}</td>
                    <td><button type=\"button\" class=\"btn btn-outline-primary block\" data-bs-toggle=\"modal\" data-bs-target=\"#border-less\" onclick=\"myFunction('{$value->ID}', '{$value->NO_CONT}','{$value->WK_IN}')\">Update</button></td>
                    </tr>";
                }
                ?>
            </table>
        </div>
    </section>
</div>

<div class="modal fade text-left modal-borderless" id="border-less" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Stacking</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">

                <label for="inputdate" id="nocont"></label>
                <input type="text" id="iddata" hidden>
                <input type="datetime-local" id="inputdate" name="inputdate">

                <a onclick="submitStack()" class="btn btn-secondary">Update Stack</a>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function myFunction(id, nocont, wkin) {
        document.getElementById("nocont").innerHTML = nocont;
        document.getElementById("iddata").value = id;
        var inputDate = document.getElementById('inputdate');
        inputDate.value = wkin; 
    }

    function submitStack(){
        let id = document.getElementById("iddata").value;
        let nocont = document.getElementById("nocont").innerHTML;
        let wkstack = document.getElementById("inputdate").value;
        alert(nocont + ' ' + id + ' ' + wkstack);
        console.log(wkstack);
    }
</script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<?php include 'footer.php'; ?>