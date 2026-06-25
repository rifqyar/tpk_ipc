<div class="panel">
  <div class="panel-group panel-group-continuous" id="exampleAccordionContinuous" aria-multiselectable="true" role="tablist">
      <div class="panel">
        <div class="panel-heading" id="exampleHeadingContinuousOne" role="tab">
          <a class="panel-title" data-parent="#exampleAccordionContinuous" data-toggle="collapse" href="#exampleCollapseContinuousOne" aria-controls="exampleCollapseContinuousOne" aria-expanded="true">
              <i class="icon md-mail-send margin-0" aria-hidden="true"></i> SPJM Request
          </a>
        </div>
        <div class="panel-collapse collapse in" id="exampleCollapseContinuousOne" aria-labelledby="exampleHeadingContinuousOne" role="tabpanel">
          <div class="panel-body">
            <?php echo $table_spk_req_spjm; ?>
          </div>
        </div>
      </div>
      <div class="panel">
        <div class="panel-heading" id="exampleHeadingContinuousTwo" role="tab">
          <a class="panel-title collapsed" data-parent="#exampleAccordionContinuous" data-toggle="collapse" href="#exampleCollapseContinuousTwo" aria-controls="exampleCollapseContinuousTwo" aria-expanded="false">
          <i class="icon md-email-open margin-0" aria-hidden="true"></i> SPPMP Request</a>
        </a>
        </div>
        <div class="panel-collapse collapse" id="exampleCollapseContinuousTwo" aria-labelledby="exampleHeadingContinuousTwo" role="tabpanel">
          <div class="panel-body container-fluid">
              <?php echo $table_spk_req_sppmp; ?>
          </div>
        </div>
      </div>
  </div>
</div>