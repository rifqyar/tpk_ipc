<div class="col-lg-2 col-sm-2"> 
<div class="panel">
  <div class="">
    <div class="list-group" data-plugin="nav-tabs" role="tablist"> 
        <a class="list-group-item active" data-toggle="tab" href="#category-1" aria-controls="category-1" role="tab">KONTAINER</a>
        <a class="list-group-item" data-toggle="tab" href="#category-2" aria-controls="category-2"role="tab">KEMASAN</a>
    </div>
  </div>
</div>
</div>
<div class="col-lg-10 col-sm-10">
<div class="panel">
  <div class="panel-body">
    <div class="tab-content"> 
      <div class=" tab-pane animation-fade active" id="category-1" role="tabpanel">
        <div class="panel-group panel-group-simple panel-group-continuous" id="accordion2"
          aria-multiselectable="true" role="tablist">
          <div class="panel">
            <div class="panel-heading" id="question-1" role="tab">
                <a class="panel-title" aria-controls="answer-1" aria-expanded="false" data-toggle="collapse" href="#answer-1" data-parent="#accordion2">REQUEST</a>
            </div>
            <div class="panel-collapse collapse" id="answer-1" aria-labelledby="question-1"
              role="tabpanel">
              <div class="panel-body">
                BELUM TERSEDIA
              </div>
            </div>
          </div>
          <div class="panel">
            <div class="panel-heading" id="question-2" role="tab">
                <a class="panel-title" aria-controls="answer-2" aria-expanded="true" data-toggle="collapse" href="#answer-2" data-parent="#accordion2">RESPONSE</a>
                </div>
            <div class="panel-collapse collapse in" id="answer-2" aria-labelledby="question-2"
              role="tabpanel">
              <div class="panel-body">
                <?php echo $table_kontainer; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane animation-fade" id="category-2" role="tabpanel">
        <div class="panel-group panel-group-simple panel-group-continuous" id="accordion" aria-multiselectable="true" role="tablist"> 
          <div class="panel">
            <div class="panel-heading" id="question-5" role="tab">
                <a class="panel-title" aria-controls="answer-5" aria-expanded="false" data-toggle="collapse" href="#answer-5" data-parent="#accordion">REQUEST</a>
            </div>
            <div class="panel-collapse collapse" id="answer-5" aria-labelledby="question-5" role="tabpanel">
              <div class="panel-body">BELUM TERSEDIA</div>
            </div>
          </div>
          <div class="panel">
            <div class="panel-heading" id="question-6" role="tab">
                <a class="panel-title" aria-controls="answer-6" aria-expanded="true" data-toggle="collapse" href="#answer-6" data-parent="#accordion">RESPONSE</a>
            </div>
            <div class="panel-collapse collapse in" id="answer-6" aria-labelledby="question-6"
              role="tabpanel">
              <div class="panel-body">BELUM TERSEDIA</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<script>
$(function(){
	$('.list-group[data-plugin="nav-tabs"]').length && $('a[data-toggle="tab"]').on("shown.bs.tab", function(e){
			$(e.target).addClass("active").siblings().removeClass("active")
	})
})
</script>
