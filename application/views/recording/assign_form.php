If you unable to view the pop out, please click <a href="javascript:location.reload(true)">Refresh this page</a>
<!-- Assign Form Modal -->
<div id="mymodel" class="modal hide fade in mymodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <div class="modal-header" >
    <h3 id="myModalLabel">Form List</h3>
  </div>
  <div class="modal-body " style="max-height:500px;min-height:300px;">
  <?php echo form_open('recording/submit_form'); ?>
    	<select name="qm_id" id="chosen_a" data-placeholder="Select Form" class="chzn_z  span5" required>
			<option value=""></option>
			<?php if(isset($qm_record)) : foreach($qm_record as $qm_row) : ?>
			<option value="<?php echo $qm_row->qm_id; ?>" <?php echo set_select('qm_title', $qm_row->qm_title); ?> ><?php echo $qm_row->qm_title; ?></option>
			<?php endforeach; ?>
			<?php endif; ?>
		</select>
		<input type="hidden" name="record_id" id="record_id"  value="<?php echo $record_id; ?>" >
  </div>
  <div class="modal-footer">
  	<a class="btn" href="<?php echo site_url('recording/index/'); ?>">Back</a>
    <input type="submit" class="btn-primary btn" value="Use Form">
  </div>
  </form>
</div>

