<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary"> <span class="ribbon-inner"> <i class="icon md-view-compact margin-0" aria-hidden="true"></i> <?php echo $title; ?> </span> </div>
  <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="process('form_data','execute/process/read/codeco/gateout'); return false;"> <i class="icon md-dot-circle"></i> PROCESS </button>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="panel-group panel-group-simple margin-bottom-0" id="exampleAccordion" aria-multiselectable="true" role="tablist">
          <div class="panel">
          	<div>&nbsp;</div>
            <div>&nbsp;</div>
            <div class="panel-heading" id="HeadingOne" role="tab"> <a class="panel-title" data-parent="#exampleAccordion" data-toggle="collapse" href="#CollapseOne"
                aria-controls="CollapseOne" aria-expanded="true"> KONTAINER </a> </div>
            <div class="panel-collapse collapse in" id="CollapseOne" aria-labelledby="HeadingOne"
              role="tabpanel">
              <div class="panel-body">
                <form name="form_data" id="form_data" class="form-horizontal" role="form" action="execute/process/upload/codeco/gateout" method="post" autocomplete="off" enctype="multipart/form-data">
                  <div class="panel-body container-fluid">
                    <div class="form-group">
                      <div class="col-sm-2">&nbsp;</div>
                      <label class="col-sm-1 control-label">UPLOAD</label>
                      <div class="col-sm-5">
                        <div class="input-group input-group-file">
                          <input type="text" class="form-control" readonly="readonly" mandatory="yes">
                          <span class="input-group-btn"><span class="btn btn-primary btn-file"> <i class="icon md-upload" aria-hidden="true"></i>
                          <input type="file" name="files" id="files" mandatory="yes">
                          </span></span></div>
                      </div>
                      <div class="col-sm-2">
                      	<a href="<?php echo site_url('execute/download/excel/gateout'); ?>" class="btn btn-primary" data-toggle="tooltip" title="FORMAT EXCEL">
                        	<i class="icon md-attachment"></i>
                       	</a>
                      </div>
                    </div>
                  </div>
                  <div id="div_html" style="overflow:auto">&nbsp;</div>
                  <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('codeco/gateout'); ?>"/>
                </form>
              </div>
            </div>
          </div>
          <div class="panel">
            <div class="panel-heading" id="HeadingTwo" role="tab">
            	<a class="panel-title collapsed" data-parent="#exampleAccordion" data-toggle="collapse" href="#CollapseTwo" aria-controls="CollapseTwo" aria-expanded="false">KEMASAN</a>
            </div>
            <div class="panel-collapse collapse" id="CollapseTwo" aria-labelledby="HeadingTwo" role="tabpanel">
              <div class="panel-body">BELUM TERSEDIA</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
function process(form,url){
	if(validasi(form)){
		var arrform = new FormData(document.getElementById(form));
		$.ajax({
		type: 'POST',
		url : site_url+'/'+url,
		data: arrform,
		dataType : 'json',
		enctype: 'multipart/form-data',
		processData: false,
		contentType: false,
		cache: false,
		beforeSend: function(){Loading(true)},
		complete: function(){Loading(false)},
		success: function(data){
			if(data.html!=null){
				$('#div_html').html(data.html);
				if(data.error==0){
					$('#div_file').hide();
				}
			}else{
				$('#div_html').html('');
				notify(data.message,'error');
			}
		}
		});	
	}
}
</script>