	<div class="page-header">
		<h2>QM Summary Report By Agent</h2>
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
			<?php echo form_open('report/search_qm_report_by_agent',$attributes); ?>
			<?php //$check_old_date = date( 'Y-m-d', strtotime($current_week[0]));  ?>

			<div class="show_data_range ">
				<label>Start Date: </label><input type="text" placeholder="Start Date" name="start_date" value="<?php echo set_value('start_date'); ?>" id="start_date">
				<label>End Date: </label><input type="text" placeholder="End Date" name="end_date" value="<?php echo set_value('end_date'); ?>" id="end_date">
			</div>

			<label>Select QA: </label>
			<select name="supervisorid[]" id="chosen_z" data-placeholder="Select QA" class="chzn_z" multiple>
				<option value=""></option>
				<?php if(isset($qa_record)) : foreach($qa_record as $qa_row) : ?>
				<option value="<?php echo $qa_row->userid; ?>" <?php if(!empty($supervisor_id)){ foreach($supervisor_id as $supervisor_id_row){ if($supervisor_id_row == $qa_row->userid){?>selected<?php } } } ?>><?php echo $qa_row->username; ?></option>
				<?php endforeach; ?>
				<?php endif; ?>
			</select>

			<label>Select Agent: </label>

			<select name="userid[]" id="chosen_a" data-placeholder="Select Agent" class="chzn_a" multiple>
				<option value=""></option>
				<?php if(isset($user_record)) : foreach($user_record as $user_row) : ?>
				<option value="<?php echo $user_row->userid; ?>" <?php if(!empty($userid)){ foreach($userid as $userid_row){ if($userid_row == $user_row->userid){?>selected<?php } } } ?>><?php echo $user_row->username; ?></option>
				<?php endforeach; ?>
				<?php endif; ?>

			</select>

			<br /><br />

			<button class="btn btn-primary qm_report_by_agent_datacom" ><i class="icon-search icon-white"></i> Search</button>
			<a class="btn btn-warning qm_report_by_agent_excel_datacom" >Export To Excel</a>
			</form>
			</div>
		  </div>
		</div>
	  </div>
	 </div>
	 <?php //var_dump($userid); ?>
	 <div class="span9">
	<?php //var_dump($count_records);?>
		<div id="show_recording"></div>
		<?php if($page == "qm_report_by_agent"){ ?><p><h5>Total Of Row(s) : <?php  if(isset($total_rows)){ echo $total_rows; }?></h5></p><?php } ?>
		<?php if(isset($data_records)){ ?>
			<?php
				$independent  = 0;
				$buddy  = 0;
				$TM  = 0;
				$sum_score  = 0;
				$i = 0;
				$qa = array();
				$num = 0;
				$total = 0;
				$total_cb = 0;
				$total_cc = 0;
				$total_nc = 0;
				$cb = 0;
				$cc = 0;
				$nc = 0;
				$recover = 0;
				$pending = 0;
				$final_cb = 0;
				$final_cc = 0;
				$final_nc = 0;
				$j = 0;
				$qa2 = array();
				if($this->uri->segment(3)){ $num = $num + $this->uri->segment(3);}  if(isset($data_records)) :foreach($data_records as $row): $num++;
					foreach($qa_record as $user_row){
						if($row->supervisor_id == $user_row->userid){
							$qa[$i] = $user_row->username;
							if($i > 0){
								if ($qa[$i] != $qa[$i-1]){
								?><table class="table table-striped table-hover table-bordered"><thead>
									<tr>
									  <th colspan="9">Department: <?php echo $this->session->userdata('tenant_name'); ?><?php if(!empty($start_date)){?><span class="offset1">Start Date: <?php echo $start_date; ?></span><?php } ?><?php if(!empty($end_date)){?><span class="offset1">End Date: <?php echo $end_date; ?></span><?php } ?></th>
									</tr>
									<tr><th colspan="9"><strong>QA By: <?php  echo $qa[$i]; ?></strong></th></tr>
									<tr>
									  <th>Agent</th>
									  <th>Independent</th>
									  <th>Buddy</th>
									  <th>TM</th>
									  <th>Recovery Call</th>
									  <th>Critical Business</th>
									  <th>Critical Customer</th>
									  <th>Non Critical</th>
									  <th>Total Incomplete</th>
									</tr>
								  </thead><?php
								}
							} else {
							?><table class="table table-striped table-hover table-bordered"><thead>
									<tr>
									  <th colspan="9">Department: <?php echo $this->session->userdata('tenant_name'); ?><?php if(!empty($start_date)){?><span class="offset1">Start Date: <?php echo $start_date; ?></span><?php } ?><?php if(!empty($end_date)){?><span class="offset1">End Date: <?php echo $end_date; ?></span><?php } ?></th>
									</tr>
									<tr><th colspan="9"><strong>QA By: <?php  echo $qa[$i]; ?></strong></th></tr>
									<tr>
									  <th>Agent</th>
									  <th>Independent</th>
									  <th>Buddy</th>
									  <th>TM</th>
									  <th>Recovery Call</th>
									  <th>Critical Business</th>
									  <th>Critical Customer</th>
									  <th>Non Critical</th>
									  <th>Total Incomplete</th>
									</tr>
								  </thead><?php
							}
						}
					}
			?>
			   <tbody>
				<tr>
					<td><?php echo $row->username; ?></td>
					<td><?php echo $row->independent; ?></td>
					<td><?php echo $row->buddy; ?></td>
					<td><?php echo $row->TM; ?></td>
					<td><?php echo $row->total_recover; ?></td>
					<td>
					<?php
					$total_cb_overall_score = 0;
					if(isset($total_cb_score)){
						foreach($total_cb_score as $total_cb_record_row){
							if($row->userid == $total_cb_record_row->userid){
								$total_cb_overall_score += $total_cb_record_row->question_cb_total;
							}else{
								$total_cb_overall_score += 0;
							}
						}
					}

					$total_cb = $total_cb_overall_score / $row->TM;
					if ( strpos( $total_cb, '.' ) === false ){
						echo $total_cb;
					}else{
						$total_cb = number_format((float)$total_cb, 2, '.', '');
						echo $total_cb;
					}
					?>%</td>

					<td>
					<?php
					$total_cc_overall_score = 0;
					if(isset($total_cc_score)){
						foreach($total_cc_score as $total_cc_record_row){
							if($row->userid == $total_cc_record_row->userid){
								$total_cc_overall_score += $total_cc_record_row->question_cc_total;
							}else{
								$total_cc_overall_score += 0;
							}
						}
					}

					$total_cc = $total_cc_overall_score / $row->TM;
					if ( strpos( $total_cc, '.' ) === false ){
						echo $total_cc;
					}else{
						$total_cc = number_format((float)$total_cc, 2, '.', '');
						echo $total_cc;
					}
					?>%</td>
					<td>
					<?php
					$total_nc_overall_score = 0;
					if(isset($total_nc_score)){
						foreach($total_nc_score as $total_nc_record_row){
							if($row->userid == $total_nc_record_row->userid){
								$total_nc_overall_score += $total_nc_record_row->question_nc_total;
							}else{
								$total_nc_overall_score += 0;
							}
						}
					}

					$total_nc = $total_nc_overall_score / $row->TM;
					if ( strpos( $total_nc, '.' ) === false ){
						echo $total_nc;
					}else{
						$total_nc = number_format((float)$total_nc, 2, '.', '');
						echo $total_nc;
					}
					?>%</td>

					<td>
					<?php

					$total_pendings = 0;
					//var_dump($total_pending);
					if(isset($total_pending)){
						foreach($total_pending as $total_pending_row){
							if($row->userid == $total_pending_row->userid){
								$total_pendings += 1;
							}else{
								$total_pendings += 0;
							}
						}
					}
					echo $total_pendings;
					$pending += $total_pendings;
					?></td>
				</tr>
			<?php
			$independent += $row->independent;
			$buddy += $row->buddy;
			$TM += $row->TM;
			$cb += $total_cb_overall_score;
			$cc += $total_cc_overall_score;
			$nc += $total_nc_overall_score;
			$recover += $row->total_recover;
			$j++;
			$i++;
			endforeach;
			$final_cb = $cb / $TM;
			$final_cc = $cc / $TM;
			$final_nc = $nc / $TM;
			?>
			<?php else : ?>
				<tr><td colspan="6">No Result Found.</td></tr>
			<?php endif; ?>
			  </tbody>
		</table>
		<?php echo $this->pagination->create_links(); ?>
		<table class="table table-striped table-hover table-bordered">
			<tr class="warning">
			  <td></td>
			  <td>Independent</td>
			  <td>Buddy</td>
			  <td>TM</td>
			  <td>Recovery Call</td>
			  <td>Critical Business</td>
			  <td>Critical Customer</td>
			  <td>Non Critical</td>
			  <td>Total Incomplete</td>
			</tr>
			<tr class="info">
			  <td><strong>Grand Total</strong></td>
			  <td><?php echo $independent;?></td>
			  <td><?php echo $buddy; ?></td>
			  <td><?php echo $TM; ?></td>
			  <td><?php echo $recover; ?></td>
			  <td>
			  <?php
			  	if ( strpos( $final_cb, '.' ) === false ){
					echo $final_cb;
				}else{
					$final_cb = number_format((float)$final_cb, 2, '.', '');
					echo $final_cb;
				}
			  ?>%
			  </td>
			   <td>
			  <?php
			  	if ( strpos( $final_cc, '.' ) === false ){
					echo $final_cc;
				}else{
					$final_cc = number_format((float)$final_cc, 2, '.', '');
					echo $final_cc;
				}
			  ?>%
			  </td>
			   <td>
			  <?php
			  	if ( strpos( $final_nc, '.' ) === false ){
					echo $final_nc;
				}else{
					$final_nc = number_format((float)$final_nc, 2, '.', '');
					echo $final_nc;
				}
			  ?>%
			  </td>
			  <td><?php echo $pending; ?></td>
			</tr>
		</table>
		<?php } ?>
	 </div>
    </div>