<div class="container mt-4">
    <h1>Detail Kontainer</h1>

    <!-- Pre-filled permit details -->
    <div class="card mb-4">
        <div class="card-header">
            Details
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="no_dok_inout"><strong>Nomor Dokumen:</strong></label>
                <input type="text" class="form-control" id="no_dok_inout"
                    value="<?php echo $permit_record['NO_DOK_INOUT']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="tgl_dok_inout"><strong>Tanggal:</strong></label>
                <input type="text" class="form-control" id="tgl_dok_inout"
                    value="<?php echo date('d-m-Y', strtotime($permit_record['TGL_DOK_INOUT'])); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="jenis_dok"><strong>Jenis Dokumen:</strong></label>
                <input type="text" class="form-control" id="jenis_dok"
                value="<?php echo $permit_record['JENIS_DOKUMEN']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="no_spk"><strong>NO SPK:</strong></label>
                <input type="text" class="form-control" id="no_spk"
                    value="Otomatis" readonly>
            </div>
            <div class="form-group">
                <label for="tgl_spk"><strong>Tanggal SPK:</strong></label>
                <input type="text" class="form-control" id="tgl_spk" value="<?php echo date('d-m-Y'); ?>" readonly>
            </div>
        </div>
    </div>

    <!-- Form to add new container (you can add pre-filled data from the permit record if needed) -->
    <form action="<?php echo site_url('planningrelo/spk_relokasi_store'); ?>" method="post">
        <h5>Select Containers to Add</h5>
        <div class="card mb-4">
            <div class="card-body">
                <?php if (!empty($containers)): ?>
                    <?php foreach ($containers as $container): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="containers[]"
                                value="<?php echo $container['NO_CONT']; ?>" id="container_<?php echo $container['NO_CONT']; ?>"
                                checked>
                            <label class="form-check-label" for="container_<?php echo $container['NO_CONT']; ?>">
                                <?php echo $container['NO_CONT']; ?> - <?php echo $container['SIZE']; ?> -
                                <?php echo $container['TYPE']; ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert alert-info">No related containers found.</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Hidden inputs to send form data -->
        <input type="hidden" name="no_spk"
            value="SPK_RELO/<?php echo date('y-m-d') . '-' . rand(100, 999); ?>">
        <input type="hidden" name="tgl_spk" value="<?php echo date('d-m-Y'); ?>">
        <input type="hidden" name="no_dok" value="<?php echo $permit_record['NO_DOK_INOUT']; ?>">
        <input type="hidden" name="jns_dok" value="<?php echo $permit_record['JENIS_DOKUMEN']; ?>">
        <input type="hidden" name="tgl_dok"
            value="<?php echo date('d-m-Y', strtotime($permit_record['TGL_DOK_INOUT'])); ?>">

        <button type="submit" class="btn btn-primary">Add Container</button>
        <a href="<?php echo site_url('planningrelo/spk_relokasi'); ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>