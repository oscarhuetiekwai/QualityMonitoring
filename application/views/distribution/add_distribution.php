
	<div class="page-header">
		<h2>Add Profile</h2>
	</div>
		<?php echo form_open("distribution/add_distribution/"); ?>

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

			<div id="new" class="control-group formSep template">
			<label for="input01" class="control-label">Profile Name*:</label>
			<div class="controls">
			<input name="profile_name" id="profile_name" size="30" type="text"   class="span8 profile_name" value="<?php echo set_value('profile_name',$data_record->profile); ?>" placeholder="Profile Name"  title="Eg: Your Profile Name" required />
			</div>
			</div>

			<div id="new" class="control-group formSep template">
			<label for="input01" class="control-label">Profile Description*:</label>
			<div class="controls">
			<textarea name="profile_description" id="profile_description"  rows="5"  class="span8 profile_description" placeholder="Profile Description"  title="Eg: Your Profile Description"  required /><?php echo set_value('profile_description',$data_record->profile_description); ?></textarea>
			</div>
			</div>

			<div class="control-group formSep ">
			<label for="input01" class="control-label">Criteria*:</label>
			<div class="controls">
			<p><span class="label label-inverse"  id="hr">Hours &amp; Frequency</span></p>
			<a href="#add_hr_freq" class="btn btn-warning" data-toggle="modal"><i class="icon-plus"></i> Add Hours &amp; Frequency</a><br><br>
			<table class="table table-hover table-bordered  table-striped" class="span8">
			 <thead>
				<tr>
				  <th>No</th>
				  <th>Start</th>
				  <th>End</th>
				  <th>Frequency</th>
				  <th>Action</th>
				</tr>
			  </thead>
			  <tbody>
			  <?php
				//var_dump($data_record);
				$num = 0; if(isset($hour_freq_record)) :foreach($hour_freq_record as $row): $num++;
			?>
				<tr>
				  <td><?php echo $num; ?></td>
				  <td><?php echo $row->starttime; ?></td>
				  <td><?php echo $row->endtime; ?></td>
				  <td><?php echo $row->freq; ?></td>
				  <td><a href="#" class="delete_hr" data-id="<?php echo $row->hfid; ?>" title="Delete"><i class="icon-trash"></i></a></td>
				</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr><td colspan="6">No Result Found.</td></tr>
			<?php endif; ?>
			  </tbody>
			</table>


			<p><span class="label label-inverse" id="queues">Queues</span></p>
			<a href="#add_queue" class="btn btn-warning" data-toggle="modal"><i class="icon-plus"></i> Add Queues</a><br><br>
			<table class="table table-hover table-bordered  table-striped" class="span8">
			 <thead>
				<tr>
					<th >No</th>
					<th >Queues</th>
					<th >Action</th>
				</tr>
			  </thead>
			  <tbody>
				<?php
				//var_dump($data_record);
				$num = 0; if(isset($queue_record)) :foreach($queue_record as $row): $num++;
				?>
				<tr>
				  <td class="span1"><?php echo $num; ?></td>
				  <td class="span7"><?php echo $row->queuename; ?></td>
				  <td><a href="#" class="delete_queue" data-id="<?php echo $row->dqid; ?>" title="Delete"><i class="icon-trash"></i></a></td>
				</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr><td colspan="6">No Result Found.</td></tr>
			<?php endif; ?>
			  </tbody>
			</table>

			<p><span class="label label-inverse"  id="wrapup">Wrap Ups</span></p>
			<a href="#add_wrapups" class="btn btn-warning" data-toggle="modal"><i class="icon-plus"></i> Add Wrap Ups</a><br><br>
			<table class="table table-hover table-bordered  table-striped" class="span8">
			 <thead>
				<tr>
					<th >No</th>
					<th >Wrap Ups</th>
					<th >Action</th>
				</tr>
			  </thead>
			  <tbody>
				<?php
				//var_dump($data_record);
				$num = 0; if(isset($wrapup_record)) :foreach($wrapup_record as $row): $num++;
				?>
				<tr>
				  <td class="span1"><?php echo $num; ?></td>
				  <td class="span7"><?php echo $row->wrapup; ?></td>
				  <td><a href="#" class="delete_wrapup" data-id="<?php echo $row->dwid; ?>" title="Delete"><i class="icon-trash"></i></a></td>
				</tr>
				<?php endforeach; ?>
				<?php else : ?>
					<tr><td colspan="6">No Result Found.</td></tr>
				<?php endif; ?>
			  </tbody>
			</table>
			</div>
			</div>


		<!--	<div class="control-group formSep ">
			<label for="input01" class="control-label">Assign Agent*:</label>
			<div class="controls">
			<a href="#add_agent" class="btn btn-warning" data-toggle="modal"><i class="icon-user"></i> Assign Agent</a><br><br>
			<table class="table table-hover table-bordered  table-striped" class="span8">
			 <thead>
				<tr>
				  <th>No</th>
				  <th>Agent</th>
				  <th>Action</th>
				</tr>
			  </thead>
			  <tbody>
			  <?php
				//var_dump($data_record);
				$num = 0; if(isset($agent_record)) :foreach($agent_record as $row): $num++;
			?>
				<tr>
				  <td><?php echo $num; ?></td>
				  <td><?php echo $row->username; ?></td>
				  <td><a href="#" class="delete_agent" dist-id="<?php echo $row->distid; ?>" agent-id="<?php echo $row->userid; ?>" title="Delete"><i class="icon-trash"></i></a></td>
				</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr><td colspan="6">No Result Found.</td></tr>
			<?php endif; ?>
			  </tbody>
			</table>
		</div>
		</div>-->
		
		<!--end product-->
		<!-- /single_form -->
		<div class="control-group template">
		<div class="controls">
		<input id="distid" name="distid" type="hidden" value="<?php echo $dist_id; ?>" />
		<input type="hidden" name="module_index" id="module_index" value="<?php echo site_url('distribution/index'); ?>" />
		<input type="submit" class="btn-primary btn" value="Save Change">&nbsp;<button type="reset" class="btn" id="cancel">Cancel</button>
		</div>
		</div>

		</fieldset>
		</form>
		</div>


<!-- add hour and Frequency -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="add_hr_freq">
    <div class="modal-header"  style="cursor:move">
      <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
      <h3 id="myModalLabel" title="drag me around">Add Hour &amp; Frequency <i class="icon-move" style="margin-top:10px;"></i></h3>
    </div>
	<?php echo form_open("distribution/submit_hr_freq"); ?>
    <div class="modal-body" style="max-height:400px;min-height:400px;">
    <div class="form-horizontal">


	<div class="control-group">
	<div class="control">
	<label for="control-label" class="control-label"></label>
	<code>Note :</code> All field mark with <code>*</code> are required.
	</div>
	</div><!-- /control-group -->

	<div class="control-group">
	<label for="input01" >Start*:</label>

	<input type="text" class="span5 starttime"name="starttime"  id="tp_1" value="00:00"/>

	</div>

	<div class="control-group">
	<label for="input01" >End*:</label>

	<input type="text" class="span5 " name="endtime" id="tp_3" value="00:00"/>

	</div>

	<div class="control-group">
	<label for="input01" >Frequency*:</label>

	<input id="frequency" name="frequency" size="30" type="text"   class="span5 frequency" value="<?php echo set_value('frequency'); ?>" placeholder="Frequency"  title="Eg: Your Frequency"  onkeypress="javascript:return isNumber (event)" />

	<input id="distid" name="distid" type="hidden" value="<?php echo $dist_id; ?>" />
	<input id="profile_name1" name="profile_name1" type="hidden" value="" />
	<input id="profile_description1" name="profile_description1" type="hidden" value="" />

	</div>

    </div>
	</div>
    <div class="modal-footer">

		  <button data-dismiss="modal" class="btn">Close</button>
		  <button class="btn btn-primary " type="submit">Submit</button>

		</form>
    </div>
</div>

<!-- add hour and Frequency -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal2 hide fade" id="add_queue">
    <div class="modal-header"  style="cursor:move">
      <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
      <h3 id="myModalLabel" title="drag me around">Add Queues <i class="icon-move" style="margin-top:10px;"></i></h3>
    </div>
	<?php echo form_open("distribution/submit_queues"); ?>
    <div class="modal-body" style="max-height:400px;min-height:400px;">
    <div class="form-horizontal">

		<input type="button" class="select_group btn btn-danger btn-small" value="Check All" />
		<br /><br />
		<table class="table table-hover table-bordered  table-striped" class="span8">
			  <tbody>
			<?php
			$num_cols = 3; //We set the number of columns
			$current_col = 0;


			if(isset($get_queue_record)) : foreach($get_queue_record as $row) :

			if($current_col == "0")echo "<tr>"; //Creates a new row if $curent_col iquals to 0



			?>

			<td>
			<label class="checkbox ">
			<input type="checkbox" name="check_queue[]" id="inlineCheckbox1" class="inlineCheckbox1" value="<?php echo $row->tenantqueueid; ?>" <?php if(isset($queue_record)){ foreach($queue_record as $row2) {if($row2->tenantqueueid == $row->tenantqueueid){ ?> checked <?php } } }?> ><?php echo $row->queuename; ?>
			</label>
			</td>
			<?php
			   if($current_col == $num_cols-1){ // Close the row if $current_col iquals to 2 in the example ($num_cols -1)
				   echo "</tr>";
				   $current_col = 0;
			   }else{
				   $current_col++;
			   }

			 endforeach; ?>
			<?php endif; ?>
			  </tbody>
			</table>
    </div>
	</div>
    <div class="modal-footer">
			<input id="profile_name2" name="profile_name2" type="hidden" value="" />
			<input id="profile_description2" name="profile_description2" type="hidden" value="" />
		  <input id="distid" name="distid" type="hidden" value="<?php echo $dist_id; ?>" />
		  <button data-dismiss="modal" class="btn">Close</button>
		  <button class="btn btn-primary" type="submit">Submit</button>

		</form>
    </div>
</div><!-- add hour and Frequency -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal2 hide fade" id="add_wrapups">
    <div class="modal-header"  style="cursor:move">
      <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
      <h3 id="myModalLabel" title="drag me around">Add Wrap Ups <i class="icon-move" style="margin-top:10px;"></i></h3>
    </div>
	<?php echo form_open("distribution/submit_wrapup/"); ?>
    <div class="modal-body" style="max-height:400px;min-height:400px;">
    <div class="form-horizontal">

		<input type="button" class="select_group2 btn btn-danger btn-small" value="Check All" />
		<br /><br />
		<table class="table table-hover table-bordered  table-striped" class="span8">
			  <tbody>
			<?php
			$num_cols2 = 3; //We set the number of columns
			$current_col2 = 0;
			if(isset($get_wrapup_record)) : foreach($get_wrapup_record as $row) :
				if($current_col2 == "0")echo "<tr>"; //Creates a new row if $curent_col iquals to 0
			?>

					<td class="span3">
					<label class="checkbox ">
					<input type="checkbox" name="check_wrapup[]" id="inlineCheckbox2" class="inlineCheckbox2" value="<?php echo $row->wrapupid; ?>" <?php if(isset($wrapup_record)){ foreach($wrapup_record as $row2) {if($row2->wrapupid == $row->wrapupid){ ?> checked <?php } } } ?> ><?php echo $row->wrapup; ?>
					</label>
					</td>


			<?php
			   if($current_col2 == $num_cols2-1){ // Close the row if $current_col iquals to 2 in the example ($num_cols -1)
				   echo "</tr>";
				   $current_col2 = 0;
			   }else{
				   $current_col2++;
			   }
			endforeach; ?>
			<?php endif; ?>
			  </tbody>
			</table>


    </div>
	</div>
    <div class="modal-footer">
		<input id="profile_name3" name="profile_name3" type="hidden" value="" />
		<input id="profile_description3" name="profile_description3" type="hidden" value="" />
		<input id="distid" name="distid" type="hidden" value="<?php echo $dist_id; ?>" />
		  <button data-dismiss="modal" class="btn">Close</button>
		  <button class="btn btn-primary" type="submit">Save changes</button>

		</form>
    </div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal2 hide fade" id="add_agent">
    <div class="modal-header"  style="cursor:move">
      <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
      <h3 id="myModalLabel" title="drag me around"> Assign Agent <i class="icon-move" style="margin-top:10px;"></i></h3>
    </div>
	<?php echo form_open("distribution/submit_assign_agent/"); ?>
    <div class="modal-body" style="max-height:400px;min-height:400px;">
    <div class="form-horizontal">

		<input type="button" class="select_group3 btn btn-danger btn-small" value="Check All" />
		<br /><br />
		<table class="table table-hover table-bordered  table-striped" class="span8">
			  <tbody>
			<?php
			$num_cols2 = 3; //We set the number of columns
			$current_col2 = 0;
			$ia = 0;
			$department = array();
			if(isset($get_agent_record)) : foreach($get_agent_record as $row) :
			  $department[$ia] = $row->name;
			  if($ia > 0){
					if ($department[$ia] != $department[$ia-1]){
					 echo "<tr><td colspan='3'><strong>".$department[$ia]."</strong></td></tr>";
					}
			   } else {
					echo "<tr><td colspan='3'><strong>".$department[$ia]."</strong></td></tr>";
			   }
				if($current_col2 == "0")echo "<tr>"; //Creates a new row if $curent_col iquals to 0

			?>
				<td class="span3">
				<label class="checkbox ">
				<input type="checkbox" name="check_agent[]" id="inlineCheckbox2" class="inlineCheckbox2" value="<?php echo $row->userid; ?>" <?php if(isset($agent_record)){ foreach($agent_record as $row2) {if($row2->userid == $row->userid){ ?> checked <?php } } } ?> ><?php echo $row->username; ?>
				</label>
				</td>
			<?php
			 	if($current_col2 == $num_cols2-1){ // Close the row if $current_col iquals to 2 in the example ($num_cols -1)
				   echo "</tr>";
				   $current_col2 = 0;
			   }else{
				   $current_col2++;
			   }

			  $ia++;
			endforeach; ?>
			<?php endif; ?>
			  </tbody>
			</table>


    </div>
	</div>
    <div class="modal-footer">
		<input id="profile_name4" name="profile_name4" type="hidden" value="" />
		<input id="profile_description4" name="profile_description4" type="hidden" value="" />
		<input id="distid" name="distid" type="hidden" value="<?php echo $dist_id; ?>" />
		  <button data-dismiss="modal" class="btn">Close</button>
		  <button class="btn btn-primary" type="submit">Save changes</button>
		</form>
    </div>
</div>
<script type='text/javascript'>//<![CDATA[
$(window).load(function(){
	$("#add_hr_freq").draggable({
	   handle: ".modal-header",cursor: "move"
	});

	$("#add_queue").draggable({
	   handle: ".modal-header",cursor: "move"
	});

	$("#add_wrapups").draggable({
	   handle: ".modal-header",cursor: "move"
	});

	$("#add_agent").draggable({
	   handle: ".modal-header",cursor: "move"
	});
});//]]>
</script>
