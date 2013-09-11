	<div class="page-header">
		<h2>Agent Performance</h2>
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
		  <div id="collapseOne" class="accordion-body in collapse" style="min-height: 500px;">
			<div class="accordion-inner">
			<?php $this->load->helper('search_helper'); ?>
			<?php $attributes = array('id' => 'myform');?>
			<?php echo form_open('report/search_qm_report_by_qa',$attributes); ?>
			<?php //$check_old_date = date( 'Y-m-d', strtotime($current_week[0]));  ?>

			<div class="show_data_range ">
				<label>Start Date: </label><input type="text" placeholder="Start Date" name="start_date" value="<?php echo set_value('start_date'); ?>" id="start_date">
				<label>End Date: </label><input type="text" placeholder="End Date" name="end_date" value="<?php echo set_value('end_date'); ?>" id="end_date">
			</div>

			<label>Select Agent: </label>

			<select name="userid[]" id="chosen_a" data-placeholder="Select Agent" class="chzn_a" multiple>
				<option value=""></option>
				<?php if(isset($user_record)) : foreach($user_record as $user_row) : ?>
				<option value="<?php echo $user_row->userid; ?>" <?php if(!empty($userid)){ foreach($userid as $userid_row){ if($userid_row == $user_row->userid){?>selected<?php } } } ?>><?php echo $user_row->username; ?></option>
				<?php endforeach; ?>
				<?php endif; ?>

			</select>

			<label>Select QA: </label>
			<select name="supervisorid[]" id="chosen_z" data-placeholder="Select QA" class="chzn_z" multiple>
				<option value=""></option>
				<?php if(isset($qa_record)) : foreach($qa_record as $qa_row) : ?>
				<option value="<?php echo $qa_row->userid; ?>" <?php if(!empty($supervisor_id)){ foreach($supervisor_id as $supervisor_id_row){ if($supervisor_id_row == $qa_row->userid){?>selected<?php } } } ?>><?php echo $qa_row->username; ?></option>
				<?php endforeach; ?>
				<?php endif; ?>
			</select>

			<br /><br />

			<button class="btn btn-primary search_agent_performance" ><i class="icon-search icon-white"></i> Search</button>
			<a class="btn btn-warning search_agent_performance_excel" >Export To Excel</a>
			</form>
			</div>
		  </div>
		</div>
	  </div>
	 </div>
	 <?php //var_dump($userid); ?>
	 <div class="span9">
	<?php //var_dump($data_records);?>
		<div id="show_recording"></div>
		<?php if($page == "agent_performance"){ ?><p><h5>Total Of Row(s) : <?php  if(isset($total_rows)){ echo $total_rows; }?></h5></p><?php } ?>
		<?php if(isset($data_records)){ ?>
			<table class="table table-striped table-hover table-bordered"><thead>
			<tr>
			  <th colspan="9">Department: <?php echo $this->session->userdata('tenant_name'); ?><?php if(!empty($start_date)){?><span class="offset1">Start Date: <?php echo $start_date; ?></span><?php } ?><?php if(!empty($end_date)){?><span class="offset1">End Date: <?php echo $end_date; ?></span><?php } ?></th>
			</tr>

			<tr>
			  <th>Agent</th>
			  <th>QA</th>
			  <th>Question</th>
			  <th>Fail</th>
			</tr>
		  </thead>
			<?php
				$num = 0;
				$i = 0;
				$failed = 0;
				if($this->uri->segment(3)){ $num = $num + $this->uri->segment(3);}  if(isset($data_records)) :foreach($data_records as $row): $num++;
			?>
			   <tbody>
				<tr>
					<td><?php echo $row->username; ?></td>
					<td>
					<?php
						foreach($qa_record as $user_row){
							if($row->supervisor_id == $user_row->userid){
								echo $user_row->username;
							}
						}
					?>
					</td>


					<td><?php echo $row->question_title; ?></td>
					<td>
					<?php
					$total_failed = 0;
					if(isset($total_fail)){
						foreach($total_fail as $total_fail_record_row){

							if($row->question_id == $total_fail_record_row->question_id && $total_fail_record_row->supervisor_id == $row->supervisor_id && $total_fail_record_row->userid == $row->userid){

								if($total_fail_record_row->question_format == 4){
									if($total_fail_record_row->question_cb == 0 && $total_fail_record_row->question_cb != 9911){
										$total_failed += 1;
									}
								}else if($total_fail_record_row->question_format == 5){
									if($total_fail_record_row->question_cc == 0 && $total_fail_record_row->question_cc != 9911){
										$total_failed += 1;
									}
								}else if($total_fail_record_row->question_format == 6){
									if($total_fail_record_row->question_nc == 0 && $total_fail_record_row->question_nc != 9911){
										$total_failed += 1;
									}
								}
							}
						}
					}
					echo $total_failed;
					?></td>

				</tr>
			<?php
			$i++;
			$failed += $total_failed;
			endforeach;
			/* $final_cb = $cb / $TM;
			$final_cc = $cc / $TM;
			$final_nc = $nc / $TM; */
			?>
			<?php else : ?>
				<tr><td colspan="6">No Result Found.</td></tr>
			<?php endif; ?>
			<tr class="info">
				  <td><strong>Total</strong></td>
				  <td></td>
				  <td></td>
				  <td><?php echo $failed; ?></td>
			</tr>
			</tbody>
		</table>
		<?php echo $this->pagination->create_links(); ?>
		<?php }?>
	 </div>
    </div>