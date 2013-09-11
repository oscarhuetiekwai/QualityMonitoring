<div class="well">
<ul class="dshb_icoNav clearfix">
	<li><a href="<?php echo site_url("qm/index"); ?>"><span class="label label-success">Step 1</span> <h4>Form </h4></a></li> <i class="icon-arrow-right"></i>
	<li><a href="#" class="disable_step"><span class="label label-default">Step 2</span> <h4>Category </h4></a></li> <i class="icon-arrow-right"></i>
	<li><a href="#" class="disable_step"><span class="label label-default">Step 3</span> <h4>Question </h4></a></li>
</ul><br>

<?php $this->load->view('template/show_error'); ?>
<?php if($this->session->userdata('role_id')==ADMIN )	{ ?>
 <a class="btn btn-warning" href="#add_form" data-toggle="modal"><i class="icon-plus"></i> Add Form</a>
	<br><br><?php } ?>
		<table class="table table-striped table-hover" <?php if(isset($data_record)){ ?> id="dt_d" <?php } ?>>
			<thead>
				<tr>
				  <th>No</th>
				  <th class="span2">Form Title</th>
				  <th>Form Type</th>
				  <th>Score Rate</th>
				  <?php if($this->session->userdata('role_id')==ADMIN )	{ ?><th class="span1">Action</th><?php } ?>
				</tr>
			  </thead>
			   <tbody>
			<?php
				//var_dump($data_record);
				$num = 0; if($this->uri->segment(3)){ $num = $num + $this->uri->segment(3);} if(isset($data_record)) :foreach($data_record as $row): $num++;
			?>
				<tr>
					<td><?php echo $num; ?></td>
					<td class="span4"><a href="<?php echo site_url('criteria/index/'.$row->qm_id);?>"  ><?php echo $row->qm_title; ?></a></td>
					<td ><?php if($row->weightage == 1){ echo "Major & Minor";}else if($row->weightage == 3){echo "Critical & Non Critical";}else{echo "Default";} ?></td>

					<td class="span3">
					<?php
					if(isset($qm_level_rate_record)){
						foreach($qm_level_rate_record as $level_row){
							if($level_row->qm_id == $row->qm_id){
								echo "<strong>Level: ".$level_row->level."</strong><br />";
								echo "Minimum Rate: ".$level_row->minimum_rate."<br />";
								echo "Maximum Rate: ".$level_row->maximum_rate."<br />";
							}
						}
					}
					if($row->major_rate != 0 && $row->minor_rate != 0){
						echo "<strong>Major Rate</strong><br />";
						echo $row->major_rate."%<br />";
						echo "<strong>Minor Rate</strong><br />";
						echo $row->minor_rate."%";
					}
					?>

					</td>
					 <?php if($this->session->userdata('role_id')==ADMIN){ ?><td class="span2"><a href="<?php $hash = md5($row->qm_id.SECRETTOKEN);  echo site_url('qm/edit_qm/'.$row->qm_id.'/'.$hash); ?>" title="Edit"><i class="icon-edit"></i></a>
					<a href="#" class="delete_row" data-id="<?php echo $row->qm_id; ?>"  data-toggle="tooltip" title="Delete" data-placement="top"><i class="icon-trash"></i></a> <a href="#" class="duplicate_row" data-id="<?php echo $row->qm_id; ?>"  data-toggle="tooltip" title="Duplicate" data-placement="top"><i class="icon-tags"></i></a>  <a class="preview_form" title="Preview Form" qm-id="<?php echo $row->qm_id; ?>"><i class="icon-search"></i></a> </td><?php } ?>
				</tr>
			<?php endforeach; ?>
			<?php else : ?>
				<tr><td colspan="9">No Result Found.</td></tr>
			<?php endif; ?>

			  </tbody>
			</table>

	<?php //echo $this->pagination->create_links(); ?>

<!-- edit form -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="edit_form">
    <div class="modal-header"  style="cursor:move">
      <button class="close" type="button"  id="cancel">×</button>
      <h3 id="myModalLabel" title="drag me around">Edit Form <i class="icon-move" style="margin-top:10px;"></i></h3>
    </div>
	<?php echo form_open('qm/edit_qm'); ?>
    <div class="modal-body">
    <div class="form-horizontal">

	<div class="control-group">
	<div class="control">
	<label for="control-label" class="control-label"></label>
	<code>Note :</code> All field mark with <code>*</code> are required.
	</div>
	</div><!-- /control-group -->
	<div class="control-group formSep template">
	<label for="input01" class="control-label">Form Title*:</label>
	<div class="controls">
	<input id="title" name="qm_title" size="30" type="text" value="<?php echo set_value('qm_title', $data_records->qm_title); ?>" placeholder="QM Title"  title="Eg: Your QM Title"   />
	</div>
	</div>

	<div class="control-group template">
	<label for="input01" class="control-label">Form Type*:</label>
	<div class="controls">
		<label class="radio">
		  <input type="radio" name="weightage" id="optionsRadios1" value="2" <?php if($data_records->weightage == 2){?>checked<?php } ?>>
		  Default
		</label>
		<label class="radio">
		  <input type="radio" name="weightage" id="optionsRadios2" value="1" <?php if($data_records->weightage == 1){?>checked<?php } ?>>
		   Major &amp; Minor
		</label>
		<label class="radio">
		  <input type="radio" name="weightage" id="optionsRadios3" value="3" <?php if($data_records->weightage == 3){?>checked<?php } ?>>
		  Critical &amp; Non Critical
		</label>
	</div>
	</div>

	<div id="abc" style="display:none;">
	<div class="control-group  template">
	<label for="input01" class="control-label">Major Rate*:</label>
	<div class="controls">
	<input id="title" name="major_rate" size="30" type="text"    value="<?php echo set_value('major_rate', $data_records->major_rate); ?>" placeholder="Major Rate"  title="Eg: Your Major Rate"  />%
	</div>
	</div>

	<div class="control-group  template">
	<label for="input01" class="control-label">Minor Rate*:</label>
	<div class="controls">
	<input id="title" name="minor_rate" size="30" type="text"    value="<?php echo set_value('minor_rate', $data_records->minor_rate); ?>" placeholder="Minor Rate"  title="Eg: Your Minor Rate"  />%
	</div>
	</div>
    </div>

	<div id="abc2" style="display:none;">
	<div class="control-group template">
	<label for="input01" class="control-label"></label>
	<div class="controls" style="text-decoration:underline;">
	Non Critical Rate
	</div>
	</div>
	
	<div class="control-group template">
	<label for="input01" class="control-label">Level 1 Rate*:</label>
	<div class="controls">
	<input class="span1" name="level_1_min_rate" type="text" placeholder="Min Rate" value="<?php if(empty($minimum_rate1)){ echo "0"; }else{echo $minimum_rate1;} ?>">% <input style="margin-left:15px;" name="level_1_max_rate" class="span1" type="text" placeholder="Max Rate" value="<?php if(empty($maximum_rate1)){ echo "0"; }else{echo $maximum_rate1;} ?>" >%
	<span class="help-block"><span class="label label-success">Level 1</span> Meeting or exceeding expectations.</span>
	<input type="hidden" name="level" value="1" />
	</div>
	</div>

	<div class="control-group template">
	<label for="input01" class="control-label">Level 2 Rate*:</label>
	<div class="controls">
	<input class="span1" name="level_2_min_rate" type="text" placeholder="Min Rate"  value="<?php if(empty($minimum_rate2)){ echo "0"; }else{echo $minimum_rate2;} ?>">% <input style="margin-left:15px;" value="<?php if(empty($maximum_rate2)){ echo "0"; }else{echo $maximum_rate2;} ?>" name="level_2_max_rate" class="span1" type="text" placeholder="Max Rate">%
	<span class="help-block"><span class="label label-warning">Level 2</span> Meeting most standards.</span>
	<input type="hidden" name="level" value="2" />
	</div>
	</div>

	<div class="control-group template">
	<label for="input01" class="control-label">Level 3 Rate*:</label>
	<div class="controls">
	<input class="span1" name="level_3_min_rate" type="text" placeholder="Min Rate"  value="<?php if(empty($minimum_rate3)){ echo "0"; }else{echo $minimum_rate3;} ?>" >% <input style="margin-left:15px;" value="<?php if(empty($maximum_rate3)){ echo "0"; }else{echo $maximum_rate3;} ?>" name="level_3_max_rate" class="span1" type="text" placeholder="Max Rate">%
	<span class="help-block"><span class="label label-important">Level 3</span> Not meeting standards.</span>
	<input type="hidden" name="level" value="3" />
	</div>
	</div>
	
    </div>

    </div>
	</div>

    <div class="modal-footer">
		<input type="hidden" name="qm_id" id="qm_id"  value="<?php echo set_value('qm_id', $data_records->qm_id); ?>" >
		<input type="hidden" name="module_index" id="module_index" value="<?php echo site_url('qm/index/'); ?>" />
		<a href="<?php echo site_url('qm/index/'); ?>"  class="btn">Close</a>
		<button class="btn btn-primary" type="submit">Save changes</button>
		</form>
    </div>
</div>

<!-- add form -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="add_form">
    <div class="modal-header"  style="cursor:move">
      <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
      <h3 id="myModalLabel" title="drag me around">Add Form <i class="icon-move" style="margin-top:10px;"></i></h3>
    </div>
	<?php echo form_open('qm/add_qm'); ?>
    <div class="modal-body">
    <div class="form-horizontal">


	<div class="control-group">
	<div class="control">
	<label for="control-label" class="control-label"></label>
	<code>Note :</code> All field mark with <code>*</code> are required.
	</div>
	</div><!-- /control-group -->

	<div class="control-group template">
	<label for="input01" class="control-label">Form Title*:</label>
	<div class="controls">
	<input id="title" name="qm_title" size="30" type="text"    value="<?php echo set_value('qm_title'); ?>" placeholder="Form Title"  title="Eg: Your Form Title"  />
	</div>
	</div>

	<div class="control-group template">
	<label for="input01" class="control-label">Form Type*:</label>
	<div class="controls">
		<label class="radio">
		  <input type="radio" name="weightage" id="optionsRadios1" value="2" checked>
		  Default
		</label>
		<label class="radio">
		  <input type="radio" name="weightage" id="optionsRadios2" value="1" >
		   Major &amp; Minor
		</label>
		<label class="radio">
		  <input type="radio" name="weightage" id="optionsRadios3" value="3">
		  Critical &amp; Non Critical
		</label>
	</div>
	</div>

	<div id="abc" style="display:none;">
	<div class="control-group  template">
	<label for="input01" class="control-label">Major Rate*:</label>
	<div class="controls">
	<input id="title" name="major_rate" size="30" type="text"    value="<?php echo set_value('major_rate'); ?>" placeholder="Major Rate"  title="Eg: Your Major Rate"  />%
	</div>
	</div>

	<div class="control-group  template">
	<label for="input01" class="control-label">Minor Rate*:</label>
	<div class="controls">
	<input id="title" name="minor_rate" size="30" type="text"    value="<?php echo set_value('minor_rate'); ?>" placeholder="Minor Rate"  title="Eg: Your Minor Rate"  />%
	</div>
	</div>
    </div>

	<div id="abc2" style="display:none;">
	<div class="control-group  template">
	<label for="input01" class="control-label"></label>
	<div class="controls" style="text-decoration:underline;">
	Non Critical Rate
	</div>
	</div>
	<div class="control-group  template">
	<label for="input01" class="control-label">Level 1 Rate*:</label>
	<div class="controls">
	<input class="span1" name="level_1_min_rate" type="text" placeholder="Min Rate" >% <input style="margin-left:15px;" name="level_1_max_rate" class="span1" type="text" placeholder="Max Rate">%
	<span class="help-block"><span class="label label-success">Level 1</span> Meeting or exceeding expectations.</span>
	<input type="hidden" name="level" value="1" />
	</div>
	</div>

	<div class="control-group  template">
	<label for="input01" class="control-label">Level 2 Rate*:</label>
	<div class="controls">
	<input class="span1" name="level_2_min_rate" type="text" placeholder="Min Rate" >% <input style="margin-left:15px;" name="level_2_max_rate" class="span1" type="text" placeholder="Max Rate">%
	<span class="help-block"><span class="label label-warning">Level 2</span> Meeting most standards.</span>
	<input type="hidden" name="level" value="2" />
	</div>
	</div>

	<div class="control-group  template">
	<label for="input01" class="control-label">Level 3 Rate*:</label>
	<div class="controls">
	<input class="span1" name="level_3_min_rate" type="text" placeholder="Min Rate" >% <input style="margin-left:15px;" name="level_3_max_rate" class="span1" type="text" placeholder="Max Rate">%
	<span class="help-block"><span class="label label-important">Level 3</span> Not meeting standards.</span>
	<input type="hidden" name="level" value="3" />
	</div>
	</div>
    </div>

	</div>
	</div>
    <div class="modal-footer">
		<input type="hidden" name="module_index" id="module_index" value="<?php echo site_url('qm/index/'); ?>" />
		  <button data-dismiss="modal" class="btn">Close</button>
		  <button class="btn btn-primary" type="submit">Save changes</button>

		</form>
    </div>
</div>

<script type='text/javascript'>//<![CDATA[


$(window).load(function(){
	$("#edit_form").modal({backdrop: 'static',keyboard: false}).draggable({
	   handle: ".modal-header",cursor: "move"
	});
$("#add_form").draggable({
	   handle: ".modal-header",cursor: "move"
	});


});//]]>
</script>