<div class="container mt-4">
    <h1>Tambah Dokumen Pengeluaran Untuk Relokasi</h1>

    <!-- Search Form (GET) -->
    <form action="<?php echo site_url('planningrelo/spk_relokasi_add'); ?>" method="get">
        <div class="form-group">
            <label for="no_dok_inout">Search by NO DOK INOUT</label>
            <input type="text" class="form-control" name="no_dok_inout" id="no_dok_inout" placeholder="Enter NO DOK INOUT" value="<?php echo $this->input->get('no_dok_inout'); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary" name="search">Search</button>
    </form>

    <?php if (!empty($permit_records)): ?>
        <!-- Display the search results in a table -->
        <div class="card mt-4">
            <div class="card-header">
                Search Results
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th> <!-- Adding ID column -->
                            <th>NO DOKUMEN</th>
                            <th>TIPE DOKUMEN</th>
                            <th>Tanggal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($permit_records as $record): ?>
                            <tr>
                                <td><?php echo $record['ID']; ?></td> <!-- Displaying the ID -->
                                <td><?php echo $record['NO_DOK_INOUT']; ?></td>
                                <td><?php echo $record['NAMA']; ?></td>
                                <td><?php echo date('Y-m-d', strtotime($record['TGL_DOK_INOUT'])); ?></td>
                                <td>
                                    <!-- Select button with link to fill form page -->
                                    <a href="<?php echo site_url('planningrelo/spk_relokasi_fill_form?id=' . $record['ID'] . '&no_dok_inout=' . $record['NO_DOK_INOUT'] . '&tgl_dok=' . $record['TGL_DOK_INOUT']. '&jns_dok=' . $record['NAMA']); ?>" class="btn btn-success">
                                        Select
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php elseif (isset($permit_records) && empty($permit_records)): ?>
        <div class="alert alert-warning mt-4">
            No records found for the provided NO DOK INOUT.
        </div>
    <?php endif; ?>
</div>
