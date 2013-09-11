<div class="well">
<ul class="dshb_icoNav clearfix">
	<li><a href="<?php echo site_url("qm/index"); ?>" class="disable_step"><span class="label label-default">Step 1</span> <h4>Form </h4></a></li> <i class="icon-arrow-right"></i>
	<li><a href="<?php echo site_url('criteria/index/'.$qm_id);?>"  class="disable_step"><span class="label label-default">Step 2</span> <h4>Category </h4></a></li> <i class="icon-arrow-right"></i>
	<li><a href="#"><span class="label label-success">Step 3</span> <h4>Question</h4></a></li>
</ul>
<br>
<?php $this->load->view('template/show_error'); ?>
<a class="btn btn-warning " href="#add_question" data-toggle="modal"><i class="icon-plus"></i> Add Question</a> <a class="btn " href="<?php echo site_url('qm/index');?>"><i class="icon-arrow-left"></i> Back To Form List</a> <a class="btn " href="<?php echo site_url('criteria/index/'.$qm_id);?>"><i class="icon-arrow-left"></i> Back To Category List</a>
	<br><br>
<h4>Form : <?php echo $qm_title; ?>  <a class="preview_form btn btn-small" title="Preview Form" style="margin-top:-5px;" qm-id="<?php echo $qm_id; ?>">Form Preview <i class="icon-search"></i></a></h4>
<h4>Category : <?php echo $criteria_title; ?></h4>
<br>

		<table class="table table-striped table-hover" <?php if(isset($data_record)){ ?> id="dt_d" <?php } ?>>
			<thead>
				<tr>
				  <th>No</th>
				  <th>Question Title</th>
				   <?php if($weightage == 1 || $weightage == 3){ ?> <th>Question Format</th><?php } ?>

				  <th>Question Type</th>
				  <th>Action</th>
				</tr>
			  </thead>
			   <tbody>
			<?php
				//var_dump($data_record);
				$num = 0; if(isset($data_record)) :foreach($data_record as $row): $num++;
			?>
				<tr>
				  <td><?php echo $num; ?></td>
				  <td><?php echo $row->question_title; ?></td>
				 <td><?php if($weightage == 1){ ?>
				 <?php if($row->question_format == 3){ echo 'Fatal'; }else if($row->question_format == 2){ echo "Minor"; }else if($row->question_format == 1){ echo "Major"; }  ?>
				 <?php }else if($weightage == 3){ ?>
				 <?php if($row->question_format == 4){ echo 'Critical Business'; }else if($row->question_format == 5){ echo "Critical Customer"; }else if($row->question_format == 6){ echo "Non Critical"; }  ?>
				 <?php } ?>
				 </td>
				  <td><?php if($row->question_format == 3){ echo ''; }else{ if($row->question_type == "y"){ echo "Yes / No"; }else{ echo "Multiple Choice"; } }?></td>
				  <td><a href="<?php $hash = md5($row->question_id.SECRETTOKEN);  echo site_url('question/edit_question/'.$qm_id.'/'.$criteria_id.'/'.$row->question_id.'/'.$hash); ?>" title="Edit"><i class="icon-edit"></i></a>
					<a href="#" class="delete_row" data-id="<?php echo $row->question_id; ?>"   qm-id="<?php echo $qm_id; ?>"  criteria-id="<?php echo $criteria_id; ?>" title="Delete"><i class="icon-trash"></i></a></td>
				</tr>
			<?php endforeach; ?>
			<?php else : ?>
				<tr><td colspan="6">No Result Found.</td></tr>
			<?php endif; ?>
			  </tbody>
		</table>
</div>
	<?php //echo $this->pagination->create_links(); ?>


	<!-- add form -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="add_question">
    <div class="modal-header"  style="cursor:move">
      <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
      <h3 id="myModalLabel" title="drag me around">Add Question <i class="icon-move" style="margin-top:10px;"></i></h3>
    </div>
	<?php echo form_open("question/add_question/$qm_id/$criteria_id"); ?>
    <div class="modal-body" style="max-height:400px;min-height:400px;">
    <div class="form-horizontal">


	<div class="control-group">
	<div class="control">
	<label for="control-label" class="control-label"></label>
	<code>Note :</code> All field mark with <code>*</code> are required.
	</div>
	</div><!-- /control-group -->

		<div class=" control-group formSep">
			<label for="input01" class="control-label">Question Type*:</label>
			<div class="controls">
			<label class="radio">
			  <input type="radio" name="question_title_type" id="question_title_type1" value="1" <?php echo set_radio('question_title_type', '1'); ?>>
			  Select Existing Question
			</label>
			<label class="radio">
			  <input type="radio" name="question_title_type" id="question_title_type2" value="0" <?php echo set_radio('question_title_type', '0'); ?>>
			  New Question
			</label>
			</div>
			</div>


			<div id="old"  >

			<div class="control-group formSep">
			<label for="input01" class="control-label">Question Title*:</label>
			<div class="controls">
			<select name="question_title_id" id="chosen_a" data-placeholder="Select Question" class="chzn_z span3">
			<option value=""></option>
			<?php if(isset($question_records)) : foreach($question_records as $row) : ?>
			<option value="<?php echo $row->question_id; ?>" <?php echo set_select('question_title_id', $row->question_title); ?> data-type="<?php echo $row->question_type; ?>" question_score_y_yes="<?php echo $row->question_score_y_yes; ?>" question_score_y_no="<?php echo $row->question_score_y_no; ?>" question_score_n_a="<?php echo $row->question_score_n_a; ?>" question_score_n_a_value="<?php echo $row->question_score_n_a_value; ?>" question_score_n_b="<?php echo $row->question_score_n_b; ?>" question_score_n_b_value="<?php echo $row->question_score_n_b_value; ?>" question_score_n_c="<?php echo $row->question_score_n_c; ?>" question_score_n_c_value="<?php echo $row->question_score_n_c_value; ?>" question_score_n_d="<?php echo $row->question_score_n_d; ?>" question_score_n_d_value="<?php echo $row->question_score_n_d_value; ?>" question_score_n_e="<?php echo $row->question_score_n_e; ?>" question_score_n_e_value="<?php echo $row->question_score_n_e_value; ?>" question_na="<?php echo $row->question_na; ?>" question_format="<?php echo $row->question_format; ?>"><?php echo $row->question_title; ?></option>
			<?php endforeach; ?>
			<?php endif; ?>
			</select>
			</div>
			</div>

			<div  class=" control-group formSep">
			<label for="input01" class="control-label">Question Format*:</label>
			<div class="controls">
			<input class="span2" name="question_format" id="question_format2" type="text" value=""  placeholder="Question Format" readonly="readonly">
			</div>
			</div>

			<div class="control-group formSep ">
			<label for="input01" class="control-label">Question With N/A*:</label>
			<div class="controls">
			   <input class="span2" name="question_na" id="question_na2" type="text" value=""  placeholder="N / A" readonly="readonly">
			</div>
			</div>


			<div class=" control-group formSep">
			<label for="input01" class="control-label">Question Type*:</label>
			<div class="controls">
			  <input class="span2" name="question_score_y_yes" id="data_type" type="text" value=""  placeholder="Question Type" readonly="readonly">
			</div>
			</div>

			<div id="aaa" class=" control-group formSep">
			<label for="input01" class="control-label">Yes / No Score*:</label>
			<div class="controls">
			<div class="input-prepend">
			  <span class="add-on">Yes Score</span>
			  <input class="span2" name="question_score_y_yes" id="question_score_y_yes" type="text" value=""  placeholder="Yes Score" readonly="readonly">
			</div>
			<div class="input-prepend">
			  <span class="add-on">No Score</span>
			  <input class="span2" name="question_score_y_no" id="question_score_y_no" type="text" value=""  placeoholder="No Score" readonly="readonly">
			</div>
			</div>
			</div>


			<div id="bbb"  class=" control-group formSep">
			<label for="input01" class="control-label">Multiple Choice*:</label>
			<div class="controls">
			<div class="input-prepend">
			  <span class="add-on">A Score </span>
			  <input class="span2" name="question_score_n_a" id="question_score_n_a" type="text" value="<?php echo set_value('question_score_n_a'); ?>"  placeholder="A Score" readonly="readonly">
			</div>
			<div class="input-prepend">
			  <span class="add-on">A Value </span>
			  <input class="span2" name="question_score_n_a_value"  id="question_score_n_a_value" type="text" value="<?php echo set_value('question_score_n_a_value'); ?>"  placeholder="A Value" readonly="readonly">
			</div>
			<br />
			<br />

			<div class="input-prepend">
			  <span class="add-on">B Score </span>
			  <input class="span2" name="question_score_n_b" id="question_score_n_b" type="text" value="<?php echo set_value('question_score_n_b'); ?>"  placeoholder="B Score" readonly="readonly">
			</div>
			<div class="input-prepend">
			  <span class="add-on">B Value </span>
			  <input class="span2" name="question_score_n_b_value" id="question_score_n_b_value" type="text" value="<?php echo set_value('question_score_n_b_value'); ?>"  placeholder="B Value" readonly="readonly">
			</div>
			<br />
			<br />

			<div class="input-prepend">
			  <span class="add-on">C Score</span>
			  <input class="span2" name="question_score_n_c" id="question_score_n_c" type="text" value="<?php echo set_value('question_score_n_c'); ?>"  placeholder="C Score" readonly="readonly">
			</div>
			<div class="input-prepend">
			  <span class="add-on">C Value </span>
			  <input class="span2" name="question_score_n_c_value" id="question_score_n_c_value" type="text" value="<?php echo set_value('question_score_n_c_value'); ?>"  placeholder="C Value" readonly="readonly">
			</div>
			<br />
			<br />

			<div class="input-prepend">
			  <span class="add-on">D Score</span>
			  <input class="span2" name="question_score_n_d" id="question_score_n_d" type="text" value="<?php echo set_value('question_score_n_d'); ?>"  placeoholder="D Score" readonly="readonly">
			</div>
			<div class="input-prepend">
			  <span class="add-on">D Value </span>
			  <input class="span2" name="question_score_n_d_value" id="question_score_n_d_value" type="text" value="<?php echo set_value('question_score_n_d_value'); ?>"  placeholder="D Value" readonly="readonly">
			</div>
			<br />
			<br />

			<div class="input-prepend">
			  <span class="add-on">E Score</span>
			  <input class="span2" name="question_score_n_e" id="question_score_n_e" type="text" value="<?php echo set_value('question_score_n_e'); ?>"  placeholder="E Score" readonly="readonly">
			</div>
			<div class="input-prepend">
			  <span class="add-on">E Value </span>
			  <input class="span2" name="question_score_n_e_value" id="question_score_n_e_value" type="text" value="<?php echo set_value('question_score_n_e_value'); ?>"  placeholder="E Value" readonly="readonly">
			</div>
			<br />
			<br />
			</div>
			</div>
			</div>
			<!-- old form -->

			<div id="new" class="control-group formSep template">
			<label for="input01" class="control-label">Question Title*:</label>
			<div class="controls">
			<input id="title" name="question_title" size="30" type="text"   class="span3" value="<?php echo set_value('question_title'); ?>" placeholder="Question Title"  title="Eg: Your Question Title"  />
			</div>
			</div>
			<?php if($weightage == 1){ ?>
			<div id="question_format" class=" control-group formSep">
			<label for="input01" class="control-label">Question Format*:</label>
			<div class="controls">
			<label class="radio">
			  <input type="radio" name="question_format" id="question_format1" value="1" <?php echo set_radio('question_format', '1'); ?>>
			  Major
			</label>
			<label class="radio">
			  <input type="radio" name="question_format" id="question_format2" value="2" <?php echo set_radio('question_format', '2'); ?>>
			  Minor
			</label>
			<label class="radio">
			  <input type="radio" name="question_format" id="question_format3" value="3" <?php echo set_radio('question_format', '3'); ?>>
			  Fatal
			</label>
			</div>
			</div>
			<?php }else if($weightage == 3){ ?>
			<div id="question_format" class=" control-group formSep">
			<label for="input01" class="control-label">Question Format*:</label>
			<div class="controls">
			<label class="radio">
			  <input type="radio" name="question_format" id="question_format1" value="4" <?php echo set_radio('question_format', '4'); ?>>
			  Critical Business
			</label>
			<label class="radio">
			  <input type="radio" name="question_format" id="question_format2" value="5" <?php echo set_radio('question_format', '5'); ?>>
			  Critical Customer
			</label>
			<label class="radio">
			  <input type="radio" name="question_format" id="question_format3" value="6" <?php echo set_radio('question_format', '6'); ?>>
			  Non Critical
			</label>
			</div>
			</div>
			<?php }else{ ?>

			<div id="question_format" class=" control-group formSep">
			<label for="input01" class="control-label">Question Format*:</label>
			<div class="controls">
			<label class="checkbox">
			  <input type="checkbox" class="fatal_check" name="question_format" id="question_format3" value="3" <?php echo set_radio('question_format', '3'); ?>>
			  Fatal
			</label>
			</div>
			</div>

			<?php } ?>

			<div id="question_na" class="control-group formSep template">
			<label for="input01" class="control-label">Question With N/A*:</label>
			<div class="controls">
			<label class="checkbox inline">
			  <input type="checkbox" id="inlineCheckbox1" value="1" name="question_na"> N / A
			</label>
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
			  Multiple Choice
			</label>
			</div>
			</div>

			<div id="yes_no" class="control-group formSep">
			<label for="input01" class="control-label">Yes / No Score*:</label>
			<div class="controls">
			<div class="input-prepend">
			  <span class="add-on">Yes Score</span>
			  <input class="span2" name="question_score_y_yes" id="question_score_y_yes" type="text" value="<?php echo set_value('question_score_y_yes'); ?>"  placeholder="Yes Score">
			</div>
			<div class="input-prepend">
			  <span class="add-on">No Score</span>
			  <input class="span2" name="question_score_y_no" id="question_score_y_no" type="text" value="<?php echo set_value('question_score_y_no'); ?>"  placeoholder="No Score">
			</div>
			</div>
			</div>

			<div id="abc" class=" control-group formSep">
			<label for="input01" class="control-label">Multiple Choice*:</label>
			<div class="controls">
			<div class="input-prepend">
			  <span class="add-on">A Score </span>
			  <input class="span2" name="question_score_n_a" id="question_score_n_a" type="text" value="<?php echo set_value('question_score_n_a'); ?>"  placeholder="A Score">
			</div>
			<div class="input-prepend">
			  <span class="add-on">A Value </span>
			  <input class="span2" name="question_score_n_a_value"  id="question_score_n_a_value" type="text" value="<?php echo set_value('question_score_n_a_value'); ?>"  placeholder="A Value">
			</div>
			<br />
			<br />

			<div class="input-prepend">
			  <span class="add-on">B Score </span>
			  <input class="span2" name="question_score_n_b" id="question_score_n_b" type="text" value="<?php echo set_value('question_score_n_b'); ?>"  placeoholder="B Score">
			</div>
			<div class="input-prepend">
			  <span class="add-on">B Value </span>
			  <input class="span2" name="question_score_n_b_value" id="question_score_n_b_value" type="text" value="<?php echo set_value('question_score_n_b_value'); ?>"  placeholder="B Value">
			</div>
			<br />
			<br />

			<div class="input-prepend">
			  <span class="add-on">C Score</span>
			  <input class="span2" name="question_score_n_c" id="question_score_n_c" type="text" value="<?php echo set_value('question_score_n_c'); ?>"  placeholder="C Score">
			</div>
			<div class="input-prepend">
			  <span class="add-on">C Value </span>
			  <input class="span2" name="question_score_n_c_value" id="question_score_n_c_value" type="text" value="<?php echo set_value('question_score_n_c_value'); ?>"  placeholder="C Value">
			</div>
			<br />
			<br />

			<div class="input-prepend">
			  <span class="add-on">D Score</span>
			  <input class="span2" name="question_score_n_d" id="question_score_n_d" type="text" value="<?php echo set_value('question_score_n_d'); ?>"  placeoholder="D Score">
			</div>
			<div class="input-prepend">
			  <span class="add-on">D Value </span>
			  <input class="span2" name="question_score_n_d_value" id="question_score_n_d_value" type="text" value="<?php echo set_value('question_score_n_d_value'); ?>"  placeholder="D Value">
			</div>
			<br />
			<br />

			<div class="input-prepend">
			  <span class="add-on">E Score</span>
			  <input class="span2" name="question_score_n_e" id="question_score_n_e" type="text" value="<?php echo set_value('question_score_n_e'); ?>"  placeholder="E Score">
			</div>
			<div class="input-prepend">
			  <span class="add-on">E Value </span>
			  <input class="span2" name="question_score_n_e_value" id="question_score_n_e_value" type="text" value="<?php echo set_value('question_score_n_e_value'); ?>"  placeholder="E Value">
			</div>
			<br />
			<br />
			</div>
			</div>
    </div>
	</div>
    <div class="modal-footer">
		<input type="hidden" name="module_index" id="module_index" value="<?php echo site_url('question/index/'.$qm_id); ?>" />
		<input type="hidden" name="weightage" value="<?php echo $weightage; ?>">
		  <button data-dismiss="modal" class="btn">Close</button>
		  <button class="btn btn-primary" type="submit">Save changes</button>

		</form>
    </div>
</div>
<script type='text/javascript'>//<![CDATA[

$(document).on('shown', function(event) {

	$('.fatal_check').click(function() {
		if( $(this).is(':checked')) {
			$("#question_na").hide();
			$("#yes_no").hide();
			$("#abc").hide();
			$("#question_type").hide();
		} else {
			$("#question_na").show();
			$("#yes_no").show();
			$("#abc").show();
			$("#question_type").show();
		}
	});

	$("#abc").hide(100);
	$("#yes_no").hide(100);
	$("#old").hide(100);
	$("#new").hide(100);
	$("#question_na").hide(100);
	$("#question_format").hide(100);
	$("#question_type").hide(100);
	 $(":radio:eq(0)").click(function(){
		$("#new").hide(100);
		$("#old").show(100);
		$("#question_type").hide(100);
		$("#question_format").hide(100);
		$("#question_na").hide(100);
		$("#abc").hide(100);
		$("#yes_no").hide(100);

	  });

	  $(":radio:eq(1)").click(function(){
		$("#old").hide(100);
		$("#new").show(100);
		$("#question_na").show(100);
		$("#question_format").show(100);
		$("#question_type").show(100);

	  });

	  // if minor major
	  <?php if($weightage == 1 ){ ?>

	  $(":radio:eq(2)").click(function(){
		$("#abc").hide(100);
		$("#yes_no").hide(100);
		$("#question_na").show(100);
		$("#question_type").show(100);
	  });

	  $(":radio:eq(3)").click(function(){
		$("#abc").hide(100);
		$("#yes_no").hide(100);
		$("#question_na").show(100);
		$("#question_type").show(100);
	  });

	  // checked fatal
	  $(":radio:eq(4)").click(function(){
		$("#abc").hide(100);
		$("#yes_no").hide(100);
		$("#question_na").hide(100);
		$("#question_type").hide(100);
	  });

	  // check fatal
	 $(":radio:eq(5)").click(function(){
		$("#abc").hide(100);
		$("#yes_no").show(100);
	  });

	  $(":radio:eq(6)").click(function(){
		$("#yes_no").hide(100);
		$("#abc").show(100);
	  });


	$("#abc2").hide(100);
	$("#yes_no2").hide(100);



    if ($(':radio:eq(5)').attr('checked')) {
		$("#abc2").hide(100);
		$("#yes_no2").show(100);
		 $(":radio:eq(5)").click(function(){
		$("#abc2").hide(100);
		$("#yes_no2").show(100);
	  });

	  $(":radio:eq(6)").click(function(){
		$("#yes_no2").hide(100);
		$("#abc2").show(100);
	  });
    } else {
      $("#yes_no2").hide(100);
		$("#abc2").show(100);
		 $(":radio:eq(5)").click(function(){
		$("#abc2").hide(100);
		$("#yes_no2").show(100);
	  });

	  $(":radio:eq(6)").click(function(){
		$("#yes_no2").hide(100);
		$("#abc2").show(100);
	  });
    }

	// if datacom
	<?php }else if($weightage == 3){ ?>
		  $(":radio:eq(2)").click(function(){
		$("#abc").hide(100);
		$("#yes_no").hide(100);
		$("#question_na").show(100);
		$("#question_type").show(100);
	  });

	  $(":radio:eq(3)").click(function(){
		$("#abc").hide(100);
		$("#yes_no").hide(100);
		$("#question_na").show(100);
		$("#question_type").show(100);
	  });

	  // checked fatal
	  $(":radio:eq(4)").click(function(){
		$("#abc").hide(100);
		$("#yes_no").hide(100);
		$("#question_na").show(100);
		$("#question_type").show(100);
	  });

	  // check fatal
	 $(":radio:eq(5)").click(function(){
		$("#abc").hide(100);
		$("#yes_no").show(100);
	  });

	  $(":radio:eq(6)").click(function(){
		$("#yes_no").hide(100);
		$("#abc").show(100);
	  });


	$("#abc2").hide(100);
	$("#yes_no2").hide(100);



    if ($(':radio:eq(5)').attr('checked')) {
		$("#abc2").hide(100);
		$("#yes_no2").show(100);
		 $(":radio:eq(5)").click(function(){
		$("#abc2").hide(100);
		$("#yes_no2").show(100);
	  });

	  $(":radio:eq(6)").click(function(){
		$("#yes_no2").hide(100);
		$("#abc2").show(100);
	  });
    } else {
      $("#yes_no2").hide(100);
		$("#abc2").show(100);
		 $(":radio:eq(5)").click(function(){
		$("#abc2").hide(100);
		$("#yes_no2").show(100);
	  });

	  $(":radio:eq(6)").click(function(){
		$("#yes_no2").hide(100);
		$("#abc2").show(100);
	  });
    }

	<?php }else{ ?>

/* 	$(":radio:eq(1)").click(function(){
		$("#abc").hide(100);
		$("#yes_no").hide(100);
		$("#question_na").hide(100);
		$("#question_type").hide(100);
	  });
	   */

	 $(":radio:eq(2)").click(function(){
		$("#abc").hide(100);
		$("#yes_no").show(100);
	  });

	  $(":radio:eq(3)").click(function(){
		$("#yes_no").hide(100);
		$("#abc").show(100);
	  });


	$("#abc2").hide(100);
	$("#yes_no2").hide(100);



    if ($(':radio:eq(3)').attr('checked')) {
		$("#abc2").hide(100);
		$("#yes_no2").show(100);
		 $(":radio:eq(3)").click(function(){
		$("#abc2").hide(100);
		$("#yes_no2").show(100);
	  });

	  $(":radio:eq(4)").click(function(){
		$("#yes_no2").hide(100);
		$("#abc2").show(100);
	  });
    } else {
      $("#yes_no2").hide(100);
		$("#abc2").show(100);
		 $(":radio:eq(3)").click(function(){
		$("#abc2").hide(100);
		$("#yes_no2").show(100);
	  });

	  $(":radio:eq(4)").click(function(){
		$("#yes_no2").hide(100);
		$("#abc2").show(100);
	  });
    }

	<?php } ?>



	$('#chosen_a').change(function(){
		// var data_type =  $(':selected',this).data('id');
		var data_type =  $(':selected',this).attr('data-type');
		var question_score_y_yes =  $(':selected',this).attr('question_score_y_yes');
		var question_score_y_no =  $(':selected',this).attr('question_score_y_no');
		var question_score_n_a =  $(':selected',this).attr('question_score_n_a');
		var question_score_n_a_value =  $(':selected',this).attr('question_score_n_a_value');
		var question_score_n_b =  $(':selected',this).attr('question_score_n_b');
		var question_score_n_b_value =  $(':selected',this).attr('question_score_n_b_value');
		var question_score_n_c =  $(':selected',this).attr('question_score_n_c');
		var question_score_n_c_value =  $(':selected',this).attr('question_score_n_c_value');
		var question_score_n_d =  $(':selected',this).attr('question_score_n_d');
		var question_score_n_d_value =  $(':selected',this).attr('question_score_n_d_value');
		var question_score_n_e =  $(':selected',this).attr('question_score_n_e');
		var question_score_n_e_value =  $(':selected',this).attr('question_score_n_e_value');
		var question_format =  $(':selected',this).attr('question_format');
		var question_na =  $(':selected',this).attr('question_na');

		if(question_na == 1){
			var question_with_na = "With N / A";
		}

		if(question_format == 1){
			var question_format_result = "Major";
		}else if(question_format == 2){
			var question_format_result = "Minor";
		}else if(question_format == 3){
			var question_format_result = "Fatal";
		}else{
			var question_format_result = "Without Weightage";
		}

		//alert(question_score_n_a);
		if(data_type == "y"){
			var question_type = "Yes / No";
		}else if(data_type == "n"){
			var question_type = "Multiple Choice";
		}
		//$('.criteria_rate2').val(criteria_id);
		$('#question_na2').val(question_with_na);
		$('#question_format2').val(question_format_result);
		$('#data_type').val(question_type);
		$('#question_score_y_yes').val(question_score_y_yes);
		$('#question_score_y_no').val(question_score_y_no);
		$('#question_score_n_a').val(question_score_n_a);
		$('#question_score_n_a_value').val(question_score_n_a_value);
		$('#question_score_n_b').val(question_score_n_b);
		$('#question_score_n_b_value').val(question_score_n_b_value);
		$('#question_score_n_c').val(question_score_n_c);
		$('#question_score_n_c_value').val(question_score_n_c_value);
		$('#question_score_n_d').val(question_score_n_d);
		$('#question_score_n_d_value').val(question_score_n_d_value);
		$('#question_score_n_e').val(question_score_n_e);
		$('#question_score_n_e_value').val(question_score_n_e_value);

	});


});
$(window).load(function(){
	$("#add_question").draggable({
	   handle: ".modal-header",cursor: "move"
	});


  //  var criteria_id =  $('.dropDownId').val();

});//]]>
</script>