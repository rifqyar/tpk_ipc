<?php include 'header.php'; ?>

<div class="page-heading">
    <h3>Update Waktu Pickup dan Behandle In</h3>
</div>

<div class="page-content">
    <section class="row">
        <form id="updateForm" method="GET"
            action="<?php echo base_url('application.php/PortalHelpdesk/updatewkinnpck'); ?>">
            <div class="mb-3">
                <label for="noContainer" class="form-label">NO CONTAINER</label>
                <input type="text" class="form-control" id="noContainer" name="no_container" required>
            </div>
            <div class="mb-3">
                <label for="noSPK" class="form-label">NO SPK</label>
                <input type="text" class="form-control" id="noSPK" name="no_spk" required>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </section>

    <?php if (!empty($results)): ?>
        <div class="mt-4">
            <h5>Query Results:</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>NO SPK</th>
                        <th>NO DOK</th>
                        <th>TGL DOK</th>
                        <th>NO CONTAINER</th>
                        <th>WK PICKUP</th>
                        <th>WK IN</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row): ?>
                        <tr>
                            <td><?php echo $row['NO_SPK']; ?></td>
                            <td><?php echo $row['NO_DOK']; ?></td>
                            <td><?php echo $row['TGL_DOK']; ?></td>
                            <td><?php echo $row['NO_CONT']; ?></td>
                            <td><?php echo $row['WK_PICKUP']; ?></td>
                            <td><?php echo $row['WK_IN']; ?></td>
                            <td>
                                <button class="btn btn-secondary update-btn"
                                    data-no-spk="<?php echo $row['NO_SPK']; ?>"
                                    data-no-cont="<?php echo $row['NO_CONT']; ?>"
                                    data-wk-pickup="<?php echo $row['WK_PICKUP']; ?>"
                                    data-wk-in="<?php echo $row['WK_IN']; ?>"
                                    data-bs-toggle="modal" data-bs-target="#updateModal">
                                    Update
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="mt-4">
            <p class="text-center">No results found for the given NO CONTAINER and NO SPK.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Waktu Pickup dan Behandle In</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updatePickupForm">
                    <div class="mb-3">
                        <label for="modalNoSPK" class="form-label">NO SPK</label>
                        <input type="text" class="form-control" id="modalNoSPK" name="no_spk" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="modalNoCont" class="form-label">NO CONT</label>
                        <input type="text" class="form-control" id="modalNoCont" name="no_cont" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="modalWKPickup" class="form-label">WK PICKUP</label>
                        <input type="datetime-local" class="form-control" id="modalWKPickup" name="wk_pickup" required>
                    </div>
                    <div class="mb-3">
                        <label for="modalWKIn" class="form-label">WK BEHANDLE IN</label>
                        <input type="datetime-local" class="form-control" id="modalWKIn" name="wk_in" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
    // Populate the modal with data when the update button is clicked
    $(document).on('click', '.update-btn', function () {
        var noSpk = $(this).data('no-spk');
        var noCont = $(this).data('no-cont');
        var wkPickup = $(this).data('wk-pickup');
        var wkIn = $(this).data('wk-in');

        $('#modalNoSPK').val(noSpk);
        $('#modalNoCont').val(noCont);
        $('#modalWKPickup').val(wkPickup);
        $('#modalWKIn').val(wkIn);
    });

    // Handle form submission for updating data
    $('#updatePickupForm').on('submit', function (e) {
        e.preventDefault();

        // Show confirmation alert
        if (confirm('Apakah Anda yakin untuk mengupdate data ini?')) {
            // Serialize the form data
            var formData = $(this).serialize();

            // Send the AJAX request to update the data
            $.ajax({
                url: "<?php echo base_url('application.php/PortalHelpdesk/updatePickupAndBehandle'); ?>",
                method: 'POST',
                data: formData,
                success: function (response) {
                    var res = JSON.parse(response);
                    alert(res.message); // Show the message from the response
                    $('#updateModal').modal('hide'); // Hide the modal
                    location.reload(); // Reload the page to see the updated data
                },
                error: function (xhr, status, error) {
                    // Handle the error response
                    alert('Terjadi kesalahan saat mengupdate data: ' + error);
                }
            });
        } else {
            // If the user cancels, do nothing
            alert('Update dibatalkan.');
        }
    });
</script>
