<div class="container mt-4">
    <h2>Relocation Data</h2>

    <!-- Search and Date Filters -->
    <div class="row mb-4">
        <div class="col-md-4">
            <input type="text" id="search-input" class="form-control" placeholder="Search...">
        </div>
        <div class="col-md-4">
            <input type="date" id="start-date" class="form-control" placeholder="Start Date">
        </div>
        <div class="col-md-4">
            <input type="date" id="end-date" class="form-control" placeholder="End Date">
        </div>
    </div>

    <!-- Data Table -->
    <form method="post" action="<?php echo site_url('Planningrelo/post_selected_data'); ?>">
        <table class="table table-bordered" id="data-table">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>TGL PPK</th>
                    <th>NO CONT</th>
                    <th>TIPE CONT</th>
                    <th>UKR CONT</th>
                    <th>KD CONT JENIS</th>
                    <th>VESSEL</th>
                    <th>VOY IN</th>
                    <th>NPWP</th>
                    <th>CONSIGNEE</th>
                    <th>NO BC11</th>
                    <th>TGL BC11</th>
                    <th>NO POS BC11</th>
                    <th>BRUTO</th>
                    <th>NO BL AWB</th>
                    <th>TGL BL AWB</th>
                    <th>NO DAFTAR PABEAN</th>
                    <th>TGL DAFTAR PABEAN</th>
                </tr>
            </thead>
            <tbody id="data-table-body">
                <?php if (!empty($headers)): ?>
                    <?php foreach ($headers as $row): ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="selected_data[]"
                                    value="<?php echo htmlspecialchars(json_encode($row)); ?>">
                            </td>
                            <!-- Format date as YYYY-MM-DD -->
                            <td>
                                <?php echo !empty($row['TGL_PPK']) ? date('Y-m-d', strtotime($row['TGL_PPK'])) : ''; ?>
                            </td>
                            <td><?php echo $row['NO_CONT']; ?></td>
                            <td><?php echo $row['TIPE_CONT']; ?></td>
                            <td><?php echo $row['UKR_CONT']; ?></td>
                            <td><?php echo $row['KD_CONT_JENIS']; ?></td>
                            <td><?php echo $row['VESSEL']; ?></td>
                            <td><?php echo $row['VOY_IN']; ?></td>
                            <td><?php echo $row['NPWP']; ?></td>
                            <td><?php echo $row['CONSIGNEE']; ?></td>
                            <td><?php echo $row['NO_BC11']; ?></td>
                            <!-- Format date as YYYY-MM-DD -->
                            <td>
                                <?php echo !empty($row['TGL_BC11']) ? date('Y-m-d', strtotime($row['TGL_BC11'])) : ''; ?>
                            </td>
                            <td><?php echo $row['NO_POS_BC11']; ?></td>
                            <td><?php echo $row['BRUTO']; ?></td>
                            <td><?php echo $row['NO_BL_AWB']; ?></td>
                            <!-- Format date as YYYY-MM-DD -->
                            <td>
                                <?php echo !empty($row['TGL_BL_AWB']) ? date('Y-m-d', strtotime($row['TGL_BL_AWB'])) : ''; ?>
                            </td>
                            <td><?php echo $row['NO_DAFTAR_PABEAN']; ?></td>
                            <!-- Format date as YYYY-MM-DD -->
                            <td>
                                <?php echo !empty($row['TGL_DAFTAR_PABEAN']) ? date('Y-m-d', strtotime($row['TGL_DAFTAR_PABEAN'])) : ''; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="18">No data available</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <button type="submit" name="submit" class="btn btn-primary">Submit Selected</button>
    </form>
</div>


<!-- JavaScript for Search and Date Filtering -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search-input');
        const startDate = document.getElementById('start-date');
        const endDate = document.getElementById('end-date');
        const tableBody = document.getElementById('data-table-body');
        const rows = tableBody.getElementsByTagName('tr');

        // Helper function to convert 'YYYYMMDD' string to a Date object
        function parseDate(dateString) {
            const year = parseInt(dateString.substring(0, 4), 10);
            const month = parseInt(dateString.substring(4, 6), 10) - 1; // Month is 0-indexed
            const day = parseInt(dateString.substring(6, 8), 10);
            return new Date(year, month, day);
        }

        // Function to filter table by search and date range
        function filterTable() {
            const searchValue = searchInput.value.toLowerCase();
            const start = startDate.value ? new Date(startDate.value) : null;
            const end = endDate.value ? new Date(endDate.value) : null;

            for (let i = 0; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                const dateCell = cells[1].textContent; // TGL_PPK is in the second column
                const rowDate = parseDate(dateCell);
                let match = true;

                // Check if the row matches the search
                if (searchValue) {
                    match = false;
                    for (let j = 1; j < cells.length; j++) {
                        if (cells[j].textContent.toLowerCase().includes(searchValue)) {
                            match = true;
                            break;
                        }
                    }
                }

                // Check if the row matches the date range
                if (match && start && rowDate < start) {
                    match = false;
                }
                if (match && end && rowDate > end) {
                    match = false;
                }

                // Show or hide the row based on the match
                rows[i].style.display = match ? '' : 'none';
            }
        }

        // Event listeners for search and date inputs
        searchInput.addEventListener('input', filterTable);
        startDate.addEventListener('change', filterTable);
        endDate.addEventListener('change', filterTable);
    });
</script>