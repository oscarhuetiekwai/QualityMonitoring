
	<div class="page-header">
		<h2>Add Question</h2>
	</div>
		<?php echo form_open("question/add_question/$qm_id/$criteria_id"); ?>

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

			<div class=" control-group formSep">
			<label for="input01" class="control-label">Question Title Type*:</label>
			<div class="controls">
			<label class="radio">
			  <input type="radio" name="question_title_type" id="question_title_type1" value="1" <?php echo set_radio('question_title_type', '1'); ?>>
			  Old Question
			</label>
			<label class="radio">
			  <input type="radio" name="question_title_type" id="question_title_type2" value="0" <?php echo set_radio('question_title_type', '0'); ?>>
			  New Question
			</label>
			</div>
			</div>

			
			<div id="old"  class="control-group formSep ">
			<label for="input01" class="control-label">Question Title*:</label>
			<div class="controls">
			<select name="question_title_id" id="chosen_a" data-placeholder="Select Question" class="chzn_z span8">
			<option value=""></option>
			<?php if(isset($data_record)) : foreach($data_record as $row) : ?>
			<option value="<?php echo $row->question_id; ?>" <?php echo set_select('question_title_id', $row->question_title); ?> ><?php echo $row->question_title; ?></option>
			<?php endforeach; ?>
			<?php endif; ?>
			</select>
			</div>
			</div>

			<div id="new" class="control-group formSep template">
			<label for="input01" class="control-label">Question Title*:</label>
			<div class="controls">
			<input id="title" name="question_title" size="30" type="text"   class="span8" value="<?php echo set_value('question_title'); ?>" placeholder="Question Title"  title="Eg: Your Question Title"  />
			</div>
			</div>



			<div id="question_type" class=" control-group formSep">
			<label for="input01" class="control-label">Question Answer Type*:</label>
			<div class="controls">
			<label class="radio">
			  <input type="radio" name="question_type" id="question_type1" value="y" <?php echo set_radio('question_type', 'y'); ?>>
			  Yes / No
			</label>
			<label class="radio">
			  <input type="radio" name="question_type" id="question_type2" value="n" <?php echo set_radio('question_type', 'n'); ?>>
			  A, B, C, D, E
			</label>
			</div>
			</div>

			<div id="yes_no" class="control-group formSep">
			<label for="input01" class="control-label">Yes / No Score*:</label>
			<div class="controls">
			<div class="input-prepend">
			  <span class="add-on">Yes Score</span>
			  <input class="span3" name="question_score_y_yes" id="question_score_y_yes" type="text" value="<?php echo set_value('question_score_y_yes'); ?>"  placeholder="Yes Score">
			</div>
			<div class="input-prepend">
			  <span class="add-on">No Score</span>
			  <input class="span3" name="question_score_y_no" id="question_score_y_no" type="text" value="<?php echo set_value('question_score_y_no'); ?>"  placeoholder="No Score">
			</div>
			</div>
			</div>

			<div id="abc" class=" control-group formSep">
			<label for="input01" class="control-label">A, B, C, D, E Score*:</label>
			<div class="controls">
			<div class="input-prepend">
			  <span class="add-on">A Score </span>
			  <input class="span3" name="question_score_n_a" id="question_score_n_a" type="text" value="<?php echo set_value('question_score_n_a'); ?>"  placeholder="A Score">			
			</div>
			<div class="input-prepend">
			  <span class="add-on">A Value </span>
			  <input class="span6" name="question_score_n_a_value"  id="question_score_n_a_value" type="text" value="<?php echo set_value('question_score_n_a_value'); ?>"  placeholder="A Value">
			</div>
			<br />
			<br />
			  
			<div class="input-prepend">
			  <span class="add-on">B Score </span>
			  <input class="span3" name="question_score_n_b" id="question_score_n_b" type="text" value="<?php echo set_value('question_score_n_b'); ?>"  placeoholder="B Score">
			</div>
			<div class="input-prepend">
			  <span class="add-on">B Value </span>
			  <input class="span6" name="question_score_n_b_value" id="question_score_n_b_value" type="text" value="<?php echo set_value('question_score_n_b_value'); ?>"  placeholder="B Value">
			</div>
			<br />
			<br />

			<div class="input-prepend">
			  <span class="add-on">C Score</span>
			  <input class="span3" name="question_score_n_c" id="question_score_n_c" type="text" value="<?php echo set_value('question_score_n_c'); ?>"  placeholder="C Score">
			</div>
			<div class="input-prepend">
			  <span class="add-on">C Value </span>
			  <input class="span6" name="question_score_n_c_value" id="question_score_n_c_value" type="text" value="<?php echo set_value('question_score_n_c_value'); ?>"  placeholder="C Value">
			</div>
			<br />
			<br />
			
			<div class="input-prepend">
			  <span class="add-on">D Score</span>
			  <input class="span3" name="question_score_n_d" id="question_score_n_d" type="text" value="<?php echo set_value('question_score_n_d'); ?>"  placeoholder="D Score">
			</div>
			<div class="input-prepend">
			  <span class="add-on">D Value </span>
			  <input class="span6" name="question_score_n_d_value" id="question_score_n_d_value" type="text" value="<?php echo set_value('question_score_n_d_value'); ?>"  placeholder="D Value">
			</div>
			<br />
			<br />
			
			<div class="input-prepend">
			  <span class="add-on">E Score</span>
			  <input class="span3" name="question_score_n_e" id="question_score_n_e" type="text" value="<?php echo set_value('question_score_n_e'); ?>"  placeholder="E Score">
			</div>
			<div class="input-prepend">
			  <span class="add-on">E Value </span>
			  <input class="span6" name="question_score_n_e_value" id="question_score_n_e_value" type="text" value="<?php echo set_value('question_score_n_e_value'); ?>"  placeholder="E Value">
			</div>
			<br />
			<br />
			</div>
			</div>


		<!--end product-->
		<!-- /single_form -->
		<div class="control-group template">
		<div class="controls">
		<input type="hidden" name="module_index" id="module_index" value="<?php echo site_url('question/index/'.$qm_id.'/'.$criteria_id); ?>" />
		<input type="submit" class="btn-primary btn" value="Save Change">&nbsp;<button type="reset" class="btn" id="cancel">Cancel</button>
		</div>
		</div>

		</fieldset>
		</form>
		</div>
