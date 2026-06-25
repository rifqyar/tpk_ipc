<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
  	<span class="ribbon-inner">
		<i class="icon md-view-list margin-0" aria-hidden="true"></i> <?php echo $title; ?>
    </span>
  </div>
  <div>&nbsp;</div>
  <div>&nbsp;</div>
  <div>&nbsp;</div>
  <div class="panel-group panel-group-continuous" id="AccordionContinuous" aria-multiselectable="true" role="tablist">
      <div class="panel">
        <div class="panel-heading" id="HeadingContinuousOne" role="tab">
          <a class="panel-title collapsed" data-parent="#AccordionContinuous" data-toggle="collapse" href="#CollapseContinuousOne" aria-controls="CollapseContinuousOne" aria-expanded="false">
          	<i class="icon md-view-dashboard margin-0" aria-hidden="true"></i> SPJM
          </a>
        </div>
        <div class="panel-collapse collapse" id="CollapseContinuousOne" aria-labelledby="HeadingContinuousOne" role="tabpanel" >
          <div class="panel-body container-fluid">
          	<?php echo $table_spjm; ?>
          </div>
        </div>
	  </div>
      <div class="panel">
        <div class="panel-heading" id="HeadingContinuousTwo" role="tab">
          <a class="panel-title collapsed" data-parent="#AccordionContinuous" data-toggle="collapse" href="#CollapseContinuousTwo" aria-controls="CollapseContinuousTwo" aria-expanded="true">
          <i class="icon md-view-headline margin-0" aria-hidden="true"></i> SPPMP</a>
        </a>
        </div>
        <div class="panel-collapse collapse" id="CollapseContinuousTwo" aria-labelledby="HeadingContinuousTwo" role="tabpanel">
          <div class="panel-body container-fluid">
          	<?php echo $table_sppmp; ?>
          </div>
        </div>
      </div>
  </div>
</div>
