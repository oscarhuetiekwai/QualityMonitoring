
	<div class="page-header">
		<h2>Add Category</h2>
	</div>
		<?php echo form_open("criteria/add_criteria/$qm_id"); ?> 

		<fieldset>
		<?php
			$this->load->view('template/show_error');

		?>
		<div class="form-horizontal">

			<div class="control-group">
			<div class="control">
			<label for="control-label" class="control-label"></label>
			<code>Note :</code> All field mark with <code>*</code> are required.
			</div>
			</div><!-- /control-group -->
			
			
			<div class=" control-group formSep">
			<label for="input01" class="control-label">Category Type*:</label>
			<div class="controls">
			<label class="radio">
				<input type="radio" name="criteria_type" id="question_type1" value="y" <?php echo set_radio('criteria_type', 'y'); ?>>
				Old Category
			</label>
			<label class="radio">
			  <input type="radio" name="criteria_type" id="question_type2" value="n" <?php echo set_radio('criteria_type', 'n'); ?>>
				New Category
			</label>
			</div>
			</div>

			<div id="yes_no" class="control-group formSep">
			<label for="input01" class="control-label">Category Title*:</label>
			<div class="controls">
			<select name="old_criteria_title" id="chosen_a" data-placeholder="Select Category" class="chzn_z span8">
			<option value=""></option>
			<?php if(isset($data_records)) : foreach($data_records as $row) : ?>
			<option value="<?php echo $row->criteria_id; ?>" data-id="<?php echo $row->criteria_rate; ?>"><?php echo $row->criteria_title; ?></option>
			<?php endforeach; ?>
			<?php endif; ?>
			</select>
			</div>
			</div>

			<div id="abc" >
			
			<div class=" control-group formSep template">
			<label for="input01" class="control-label">Category Title*:</label>
			<div class="controls">
			<input id="title" name="criteria_title" size="30" type="text"   class="span8" value="<?php echo set_value('criteria_title'); ?>" placeholder="Category Title"  title="Eg: Your Category Title"  />
			</div>
			</div>
		
			<div class="control-group formSep template">
			<label for="input01" class="control-label">Category Rate*:</label>
			<div class="controls">
			<input id="title" name="criteria_rate" size="30" type="text"   class="span8" value="<?php echo set_value('criteria_rate'); ?>" placeholder="Category Rate"  title="Eg: Your Category Rate"  />
			</div>
			</div>
			
			</div>
			
		<!--end product-->
		<!-- /single_form -->
		<div class="control-group template">
		<div class="controls">
		<input type="hidden" name="module_index" id="module_index" value="<?php echo site_url('criteria/index/'.$qm_id);?>" />
		<input type="submit" class="btn-primary btn" value="Save Change">&nbsp;<button type="reset" class="btn" id="cancel">Cancel</button>
		</div>
		</div>
		</fieldset>
		</form>
		</div>