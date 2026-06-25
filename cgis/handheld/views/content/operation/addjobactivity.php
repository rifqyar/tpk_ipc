<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<div class="container">
<a href="<?php echo site_url('operation/opr'); ?>">
	<H4 style="color:white;"><< MENU HANDHELD</H4>
</a>
  <br>
	<H5 style="color:white;">JOB ACTIVITY</H5><br>
   <div class="container">
        <div class=" col-md-4 form-group">
              <label style="color:white;" for="jenispekerja">Jenis Pekerjaan</label>
   <br>
<form action="<?php echo site_url('operation/tambahjobactivity'); ?>" method="post" class="form-horizontal">
	   <div class="row">
                <div class=" col-md-12">
                  <input type="text" class="form-control" name="jenispekerja" required="required"><br>
                </div>
   </div>
    <div class="row">
                <div class="col-md-12">
                  <br><button type="submit" name="submit" class="btn btn-primary" style="border: 1px solid #a1a1a1;">SUBMIT</button>
                </div>
             </div>
</form>
<?php if ($this->session->flashdata('pesan')): ?>
    <script>
        setTimeout(function() {
            alert("<?php echo $this->session->flashdata('pesan'); ?>");
        }, 1000); // waktu delay dalam milidetik (dalam contoh ini 1 detik)
    </script>
<?php endif; ?>