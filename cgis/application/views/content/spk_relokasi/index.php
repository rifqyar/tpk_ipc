<div class="container">
    <h1>SPK Relocation List</h1>
    <div class="mb-3">
        <a class="btn btn-success" href="<?php echo site_url('planningrelo/add_relo'); ?>">Buat SPK</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>NO SPK</th>
                <th>TGL SPK</th>
                <th>NO DOK</th>
                <th>TGL DOK</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($headers)): ?>
                <?php foreach ($headers as $header): ?>
                    <tr>
                        <td><?php echo $header['NO_SPK']; ?></td>
                        <td><?php echo $header['TGL_SPK']; ?></td>
                        <td><?php echo $header['NO_DOK']; ?></td>
                        <td><?php echo $header['TGL_DOK']; ?></td>
                        <td>
                            <a class="btn btn-info" href="<?php echo site_url('planningrelo/spk_relokasi_detail/' . $header['ID']); ?>">Details</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
