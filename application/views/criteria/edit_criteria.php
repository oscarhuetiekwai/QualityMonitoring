<div class="well">
<ul class="dshb_icoNav clearfix">
	<li><a href="<?php echo site_url("qm/index"); ?>" class="disable_step"><span class="label label-default">Step 1</span> <h4>Form </h4></a></li> <i class="icon-arrow-right"></i>
	<li><a href="#" ><span class="label label-success">Step 2</span> <h4>Category </h4></a></li> <i class="icon-arrow-right"></i>
	<li><a href="#" class="disable_step"><span class="label label-default">Step 3</span> <h4>Question</h4></a></li>
</ul>
<br>
<?php $this->load->view('template/show_error'); ?>
	<a class="btn btn-warning" href="#add_criteria" data-toggle="modal"><i class="icon-plus"></i> Add Category</a> <a class="btn " href="<?php echo site_url('qm/index');?>"><i class="icon-arrow-left"></i> Back To Form List</a>
	<br><br>
<h4>Form : <?php echo $qm_title; ?> <a class="preview_form btn btn-small" title="Preview Form" style="margin-top:-5px;">Form Preview <i class="icon-search"></i></a></h4>
		<table class="table table-striped table-hover" <?php if(isset($data_record)){ ?> id="dt_d" <?php } ?>>
			<thead>
				<tr>
				  <th>No</th>
				  <th>Category Title</th>
				 <?php if($weightage == 2){ ?> <th>Category Rate <br>Total Rate Now: <span class="badge badge-warning"><?php echo $count_total_criteria_rate; ?>%</span></th><?php } ?>
				  <th>Action</th>
				</tr>
			  </thead>
			   <tbody>
			<?php
				$num = 0;  if(isset($data_record)) :foreach($data_record as $row): $num++;
			?>
				<tr>
				  <td><?php echo $num; ?></td>
				  <td><a href="<?php echo site_url('question/index/'.$qm_id.'/'.$row->criteria_id);?>"  ><?php echo $row->criteria_title; ?></a></td>
				 <?php if($weightage == 2){ ?><td><?php echo $row->criteria_rate; ?>%</td><?php } ?>
				  <td><a href="<?php $hash = md5($row->criteria_id.SECRETTOKEN);  echo site_url('criteria/edit_criteria/'.$qm_id.'/'.$row->criteria_id.'/'.$hash); ?>" title="Edit"><i class="icon-edit"></i></a>
					<a href="#" class="delete_row" data-id="<?php echo $row->criteria_id; ?>" qm-id="<?php echo $qm_id; ?>"  title="Delete"><i class="icon-trash"></i></a></td>
				</tr>
			<?php endforeach; ?>
			<?php else : ?>
				<tr><td colspan="6">No Result Found.</td></tr>
			<?php endif; ?>

			  </tbody>
			</table>
</div>
	<?php  //var_dump($data_records); ?>


	
<!-- add form -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="add_criteria">
    <div class="modal-header"  style="cursor:move">
	  <a href="<?php echo site_url('criteria/index/'.$qm_id); ?>"  class="close">×</a>
      <h3 id="myModalLabel" title="drag me around">Add Category <i class="icon-move" style="margin-top:10px;"></i></h3>
    </div>
	<?php echo form_open("criteria/add_criteria/$qm_id"); ?>
    <div class="modal-body" style="max-height:400px;min-height:400px;">
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

			<div id="yes_no" >
			<div class=" control-group formSep template">
			<label for="input01" class="control-label">Category Title*:</label>
			<div class="controls">
			<select name="old_criteria_title" id="chosen_a" data-placeholder="Select Category" class="chzn_z span3 dropDownId">
			<option value=""></option>
			<?php if(isset($data_records_all)) : foreach($data_records_all as $row) : ?>
			<option value="<?php echo $row->criteria_id; ?>" data-id="<?php echo $row->criteria_rate; ?>"><?php echo $row->criteria_title; ?></option>
			<?php endforeach; ?>
			<?php endif; ?>
			</select>
			</div>
			</div>

			<?php if($weightage == 2){ ?><div class=" control-group formSep template">
			<label for="input01" class="control-label">Category Rate*:</label>
			<div class="controls">
			<input id="title" name="criteria_rate2" size="30" type="text" class="criteria_rate2 span2" value="" />
			</div>
			</div><?php } ?>
			</div>

			<div id="abc" >

			<div class=" control-group formSep template">
			<label for="input01" class="control-label">Category Title*:</label>
			<div class="controls">
			<input id="title" name="criteria_title" size="30" type="text"   class="" value="<?php echo set_value('criteria_title'); ?>" placeholder="Category Title"  title="Eg: Your Category Title"  />
			</div>
			</div>

			<?php if($weightage == 2){ ?><div class="control-group formSep template">
			<label for="input01" class="control-label">Category Rate*:</label>
			<div class="controls">
			<input id="title" name="criteria_rate" size="30" type="text"   class="" value="<?php echo set_value('criteria_rate'); ?>" placeholder="Category Rate"  title="Eg: Your Category Rate"  />
			</div>
			</div><?php } ?>

			</div>

    </div>
	</div>
    <div class="modal-footer">
		<input type="hidden" name="module_index" id="module_index" value="<?php echo site_url('criteria/index/'.$qm_id); ?>" />
		<input type="hidden" name="weightage" value="<?php echo $weightage; ?>" />
		  <a href="<?php echo site_url('criteria/index/'.$qm_id); ?>"  class="btn">Close</a>
		  <button class="btn btn-primary" type="submit">Save changes</button>

		</form>
    </div>
</div>
	
<!-- edit form -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="edit_criteria">
    <div class="modal-header"  style="cursor:move">
      <a href="<?php echo site_url('criteria/index/'.$qm_id); ?>"  class="close">×</a>
      <h3 id="myModalLabel" title="drag me around">Edit Category <i class="icon-move" style="margin-top:10px;"></i></h3>
    </div>
	<?php echo form_open("criteria/edit_criteria/$qm_id"); ?>
    <div class="modal-body" >
    <div class="form-horizontal">


	<div class="control-group">
	<div class="control">
	<label for="control-label" class="control-label"></label>
	<code>Note :</code> All field mark with <code>*</code> are required.
	</div>
	</div><!-- /control-group -->

	
		<div class="control-group formSep template">
			<label for="input01" class="control-label">Category Title*:</label>
			<div class="controls">
			<input id="title" name="criteria_title" size="30" type="text"   class="span3" value="<?php echo set_value('criteria_title',$data_records->criteria_title); ?>" placeholder="Category Title"  title="Eg: Your Category Title"  />
			</div>
			</div>
			
			<?php if($weightage == 2){ ?><div class="control-group formSep template">
			<label for="input01" class="control-label">Category Rate*:</label>
			<div class="controls">
			<input id="title" name="criteria_rate" size="30" type="text"   class="span3" value="<?php echo set_value('criteria_rate',$data_records->criteria_rate); ?>" placeholder="Category Rate"  title="Eg: Your Category Rate"  />
			</div>
			</div><?php } ?>

    </div>
	</div>
    <div class="modal-footer">
				<input type="hidden" name="criteria_id" id="criteria_id"  value="<?php echo set_value('criteria_id',$data_records->criteria_id); 	?>" >
			<input type="hidden" name="qm_id" id="qm_id"  value="<?php echo $qm_id; ?>" >
			<input type="hidden" name="module_index" id="module_index" value="<?php echo site_url('criteria/index/'.$qm_id);?>" />
			<input type="hidden" name="weightage" value="<?php echo $weightage; ?>" />


		  <a href="<?php echo site_url('criteria/index/'.$qm_id); ?>"  class="btn">Close</a>
		  <button class="btn btn-primary" type="submit">Save changes</button>

		</form>
    </div>
</div>

<script type='text/javascript'>//<![CDATA[
$(window).load(function(){
	$("#edit_criteria").modal({backdrop: 'static',keyboard: false}).draggable({
	   handle: ".modal-header",cursor: "move"
	});
$("#add_criteria").draggable({
	   handle: ".modal-header",cursor: "move"
	});
});//]]>
</script>