
	<div class="page-header">
		<h2>Add Form</h2>
	</div>
		<?php echo form_open('qm/add_qm'); ?>

		<fieldset>
		<?php
			$this->load->view('template/show_error');

		?>
		<div class="form-horizontal">

		<fieldset>

			<div class="control-group">
			<div class="control">
			<label for="control-label" class="control-label"></label>
			<code>Note :</code> All field mark with <code>*</code> are required.
			</div>
			</div><!-- /control-group -->

			<div class="control-group formSep template">
			<label for="input01" class="control-label">Form Title*:</label>
			<div class="controls">
			<input id="title" name="qm_title" size="30" type="text"   class="span8" value="<?php echo set_value('qm_title'); ?>" placeholder="Form Title"  title="Eg: Your Form Title"  />
			</div>
			</div>

			<!--<div class="control-group formSep ">
			<label for="input01" class="control-label">Question*: <a href="#" class="ttip_t" title="Question Title" style="text-decoration:none;color:grey;">[?]</a></label>
			<div class="controls">
			<select name="question" id="chosen_z" data-placeholder="Select Question" class="chzn_a span8">
			<option value=""></option>
			<?php if(isset($question_record)) : foreach($question_record as $row) : ?>
			<option value="<?php echo $row->question_id; ?>" <?php echo set_select('question_title', $row->question_title); ?> ><?php echo $row->question_title; ?></option>
			<?php endforeach; ?>
			<?php endif; ?>
			</select>
			</div>
			</div>-->



		<!--end product-->
		<!-- /single_form -->
		<div class="control-group template">
		<div class="controls">
		<input type="hidden" name="module_index" id="module_index" value="<?php echo site_url('qm/index/'); ?>" />
		<input type="submit" class="btn-primary btn" value="Save Change">&nbsp;<button type="reset" class="btn" id="cancel">Cancel</button>
		</div>
		</div>

		</fieldset>
		</form>
		</div>
		
<!-- Modal -->
<div id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="overflow:auto;">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin-right: 20px;margin-top: 5px;">×</button>
  <div class="modal-body">
    <div id="history_table"></div>
  </div>
</div>