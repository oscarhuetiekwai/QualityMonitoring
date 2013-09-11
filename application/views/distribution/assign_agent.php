<div class="page-header">
    <h1>Distribution</h1>
</div>
<?php $this->load->view('template/show_error'); ?>
<!--<a class="btn btn-warning " href="#add_profile" data-toggle="modal"><i class="icon-plus"></i> Add Profile</a> -->
<a class="btn btn-warning submit_id" ><i class="icon-plus"></i> Add Profile</a>
	<br><br>

		<table class="table table-striped table-hover" <?php if(isset($data_record)){ ?> id="dt_d" <?php } ?>>
			<thead>
				<tr>
				  <th>No</th>
				  <th>Profile Name</th>
				  <th>Profile Description</th>
				  <th>Agent</th>
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
				  <td><?php echo $row->profile; ?></td>
				  <td><?php echo $row->profile_description; ?></td>
				  <td>
				  <!-- Button to trigger modal -->
					<a href="#agent_modal" role="button" class="btn" data-toggle="modal"><i class="icon-eye-open"></i> View Agent</a>


				  </td>
				  <td>
					<a href="<?php echo site_url('distribution/assign_agent/'.$row->distid.'/'); ?>"   title="Assign Agent" ><i class="icon-user"></i></a>
					<a href="#" class="preview_profile" data-id="<?php echo $row->distid; ?>"  title="Preview Profile"><i class="icon-search"></i></a>
					<a href="<?php $hash = md5($row->distid.SECRETTOKEN); echo site_url('distribution/edit_distribution/'.$row->distid.'/'); ?>" title="Edit"><i class="icon-edit"></i></a>
					<a href="#" class="delete_row" data-id="<?php echo $row->distid; ?>"  title="Delete"><i class="icon-trash"></i></a></td>
				</tr>
			<?php endforeach; ?>
			<?php else : ?>
				<tr><td colspan="6">No Result Found.</td></tr>
			<?php endif; ?>
			  </tbody>
		</table>

	<?php //echo $this->pagination->create_links(); ?>


<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal2 fade in" id="add_agent">
    <div class="modal-header"  style="cursor:move">
      <a  href="<?php echo site_url('distribution/index'); ?>" class="close" type="button">×</a>
      <h3 id="myModalLabel" title="drag me around"> Assign Agent <i class="icon-move" style="margin-top:10px;"></i></h3>
    </div>
	<?php echo form_open("distribution/submit_assign_agent2/"); ?>
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
		<input id="distid" name="distid" type="hidden" value="<?php echo $dist_id; ?>" />
		  <a href="<?php echo site_url('distribution/index'); ?>" class="btn">Close</a>
		  <button class="btn btn-primary" type="submit">Save changes</button>

		</form>
    </div>
</div>

<!-- Modal -->
<div id="agent_modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Agent</h3>
  </div>
  <div class="modal-body">

			<table class="table table-hover table-bordered  table-striped" class="span8">
			  <tbody>
			<?php
			$num_cols2 = 3; //We set the number of columns
			$current_col2 = 0;
			$ia = 0;
			$department = array();
			if(isset($user_record)) : foreach($user_record as $row) :


				if($current_col2 == "0")echo "<tr>"; //Creates a new row if $curent_col iquals to 0

			?>
				<td class="span3" colspan="3">
			<?php echo $row->username; ?>

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
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>

<script type='text/javascript'>//<![CDATA[
$(window).load(function(){
	$("#add_agent").draggable({
	   handle: ".modal-header",cursor: "move"
	});


  //  var criteria_id =  $('.dropDownId').val();

});//]]>
</script>