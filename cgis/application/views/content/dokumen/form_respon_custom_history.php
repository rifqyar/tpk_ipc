<?php 
	// print_r($arrdata);
?>

<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
    <span class="ribbon-inner">
    <i class="icon md-navigation margin-0" aria-hidden="true"></i> <?php echo $title; ?>
    </span>
  </div>
  <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_post('form_data','tblkapallist'); return false;">
  	<i class="icon md-badge-check"></i> SAVE
  </button>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('/display/respon_custom/respon/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divcustoms'); return false;" popup="1">
        <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[ID]" id="ID" mandatory="no" class="form-control" value="<?php echo $id; ?>">
                  <div class="hint">ID</div>
                </div>
              </div>
              <div>
              	<label class="col-sm-3 control-label">HISTORY PPK</label>
              	<table class="table">
              		<tr>
              			<td>KONTAINER</td>
                    <td>USER LOGIN</td>
                    <td>TANGGAL PPK</td>
              		</tr>
                    <?php
                        $no = 0;
                        foreach($arrdata as $value) {
                    ?>
                                <tr>
                                      <td><?php echo $value->NO_CONT ?></td>
                                      <td><?php echo $value->user_login ?></td>
                                      <td><?php echo $value->tgl ?></td>
                                </tr>
                    <?php
                        }
                    ?>
                    <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('display/respon_custom/post'); ?>"/>
                </table>
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>