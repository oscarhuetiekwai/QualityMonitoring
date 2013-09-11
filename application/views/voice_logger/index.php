	<div class="page-header">
		<h2>Call List</h2>
	</div>
	<?php
		$this->load->view('template/show_error');
	?>
	<div class="row">
	<div class="span3">
	<div class="accordion" id="accordion2">
		<div class="accordion-group">
		  <div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
			 Search
			</a>
		  </div>
		  <div id="collapseOne" class="accordion-body in collapse" style="height: 530px;">
			<div class="accordion-inner">
			<?php $this->load->helper('search_helper'); ?>
			<?php echo form_open('voice_logger/search_voice_logger'); ?>
			<?php //$check_old_date = date( 'Y-m-d', strtotime($current_week[0]));  ?>

			  <!--<label>Agent Name: </label><input type="text" placeholder="Agent Name" name="agent_name" value="" id="agent_name">-->
				<label>Start Date: </label><input type="text" placeholder="Start Date" name="start_date" value="<?php echo set_value('start_date'); ?>" id="start_date">
				<label>End Date: </label><input type="text" placeholder="End Date" name="end_date" value="<?php echo set_value('end_date'); ?>" id="end_date">
				<label>Agent: </label>
					<select name="agent" id="chosen_a" data-placeholder="Select Agent" class="chzn_z  " >
						<option value=""></option>
						<?php if(isset($user_record)) : foreach($user_record as $user_row) : ?>
						<option value="<?php echo $user_row->userid; ?>" <?php if(!empty($userid)){ if($userid == $user_row->userid){?>selected<?php } }  ?>><?php echo $user_row->username; ?></option>
						<?php endforeach; ?>
						<?php endif; ?>
					</select>
				<label>Ext: </label>
					<select name="ext" id="chosen_b" data-placeholder="Select Ext" class="chzn_a" style="z-index:9999;">
						<option value=""></option>
						<?php if(isset($ext_record)) : foreach($ext_record as $ext_row) : ?>
						<option value="SIP/<?php echo $ext_row->name; ?>" <?php echo set_select('name', $ext_row->name); ?> >SIP/<?php echo $ext_row->name; ?></option>
						<?php endforeach; ?>
						<?php endif; ?>
					</select>
				<label>Caller ID: </label>
				<input type="text" value="<?php echo set_value('callerid'); ?>" Placeholder="Caller ID" name="callerid">
				<button class="btn btn-primary" type="submit" data-loading-text="Loading..." >Search</button>
			</form>
			</div>
		  </div>
		</div>
	</div>
	</div>

	<div class="span9">
		<div id="show_recording"></div>
		<?php if($page == "voice_logger"){ ?><p><h5>Total Of Row(s) : <?php  if(isset($total_rows)){ echo $total_rows; }?></h5></p><?php } ?>
		<table class="table table-striped table-hover table-bordered">
			<thead>
				<tr>
				  <th>No</th>
				  <th>Date</th>
				   <th>ID</th>
				  <th>Time</th>
				  <th>Agent</th>
				  <th>Ext</th>
				  <th>Caller No</th>
				  <th>Queue</th>
				    <th>Status</th>
				  <th>Action</th>
				</tr>
			  </thead>
			   <tbody>
			<?php
				$num = 0; if($this->uri->segment(3)){ $num = $num + $this->uri->segment(3);}  if(isset($data_records)) :foreach($data_records as $row): $num++;
				$date = date( 'Y-m-d', strtotime($row->queuetime));
				$time = date( 'H:i:s a', strtotime($row->queuetime));
			?>
				<tr>
				 <td><?php echo $num; ?></td>
				  <td><?php echo $date; ?></td>
				   <td><?php echo $row->callid; ?></td>
				  <td><?php echo $time; ?></td>
				  <td><?php echo $row->username; ?></td>
				  <td><?php echo $row->extension; ?></td>
				  <td><?php echo $row->callerid; ?></td>
				  <td><?php echo $row->queuename; ?></td>
					<?php
						$check = 1;
						foreach($recording_record as $record_row){
							if($record_row->unique_id == $row->callid){
								$check = 0;
								if($record_row->status == 1){
									$assign_form_url = site_url('recording/assign_form/'.$record_row->record_id.'/');
									$btn =  "<a href='".$assign_form_url."'   class='btn btn-small btn-inverse'><i class='icon-arrow-right icon-white'></i> Select Form</a>";
									$status = "<span class='label label-inverse'>New</span>";
								}else if($record_row->status == 4){
									$url = site_url('qm/qm_form_complete/'.$record_row->record_id.'/'.$record_row->userid);
									$btn =  "<a href='".$url."' class='show_qm_form btn btn-small'><i class='icon-eye-open'></i> View<a>";
									$status = "<span class='label label-success'>Complete</span>";
								}else if($record_row->status == 5){
									$url = site_url('qm/qm_form_pending_save/'.$record_row->record_id.'/'.$record_row->userid);
									$btn =  "<a href='".$url."' class='show_qm_form btn btn-small btn-warning'><i class='icon-check'></i> Score<a>";
									$status = "<span class='label label-warning'>Pending</span>";
								}else if($record_row->status == 3){
									$url = site_url('qm/qm_form/'.$record_row->record_id.'/'.$record_row->userid);
									$btn =  "<a href='".$url."' class='show_qm_form btn btn-small  btn-warning'><i class='icon-check'></i> Score<a>";
									$status = "<span class='label label-warning'>Pending</span>";
								}else{
									$url = site_url('qm/qm_form/'.$record_row->record_id.'/'.$record_row->userid);
									$btn =  "<a href='".$url."' class='show_qm_form btn btn-small'><i class='icon-eye-open'></i> View<a>";
									$status = "<span class='label label-important'>Expired</span>";
								}


						?>
							<td><?php echo $status; ?></td>
							<td class="span2"><?php echo $btn; ?></td>
						<?php
							}
						}
						if($check == 1){
							echo  "<td><span class='label label-inverse'>New</span></td><td><a href='#'  data-id=".$row->id." role='button'  data-toggle='modal' class='btn btn-small btn-inverse assign_form'><i class='icon-arrow-right icon-white'></i> Select Form</a></td>";
						}

					?>

				</tr>
			<?php endforeach; ?>
			<?php else : ?>
				<tr>
					<td colspan="10">
						<strong>No Record Found!</strong>
					</td>
				</tr>
			<?php endif; ?>
			  </tbody>
		</table>
		<?php if(isset($data_records)){  echo $this->pagination->create_links(); } ?>

	 </div>
    </div>

<!-- Modal -->
<div id="assign_form" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Select QM Form</h3>
  </div>
  <div class="modal-body">
  <div class="modal-body" style="max-height:500px;min-height:300px;">
  <?php echo form_open('voice_logger/submit_form'); ?>
    	<select name="qm_id" id="chosen_t" data-placeholder="Select Form" class="chzn_t span5" required>
			<option value=""></option>
			<?php foreach($qm_record as $qm_row) : ?>
			<option value="<?php echo $qm_row->qm_id; ?>" <?php echo set_select('qm_title', $qm_row->qm_title); ?> ><?php echo $qm_row->qm_title; ?></option>
			<?php endforeach; ?>

		</select>
		<input type="hidden" id="id" value="" name="id">
  </div>
	</div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button type="submit"  class="btn btn-primary">Use Form</button>
  </div>
    </form>
</div>