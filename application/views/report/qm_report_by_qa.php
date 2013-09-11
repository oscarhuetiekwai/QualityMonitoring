	<div class="page-header">
		<h2>QM Summary Report By QM Agent</h2>
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

			<label>Select QA: </label>
			<select name="supervisorid[]" id="chosen_z" data-placeholder="Select QA" class="chzn_z" multiple>
				<option value=""></option>
				<?php if(isset($qa_record)) : foreach($qa_record as $qa_row) : ?>
				<option value="<?php echo $qa_row->userid; ?>" <?php if(!empty($supervisor_id)){ foreach($supervisor_id as $supervisor_id_row){ if($supervisor_id_row == $qa_row->userid){?>selected<?php } } } ?>><?php echo $qa_row->username; ?></option>
				<?php endforeach; ?>
				<?php endif; ?>
			</select>

			<br /><br />

			<button class="btn btn-primary qm_report_by_qa" ><i class="icon-search icon-white"></i> Search</button>
			<a class="btn btn-warning qm_report_by_qa_excel" >Export To Excel</a>
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
		<?php if($page == "qm_report_by_qa"){ ?><p><h5>Total Of Row(s) : <?php  if(isset($total_rows)){ echo $total_rows; }?></h5></p><?php } ?>
		<?php if(isset($data_records)){ ?>
			<table class="table table-striped table-hover table-bordered"><thead>
			<tr>
			  <th colspan="7">Department: <?php echo $this->session->userdata('tenant_name'); ?><?php if(!empty($start_date)){?><span class="offset1">Start Date: <?php echo $start_date; ?></span><?php } ?><?php if(!empty($end_date)){?><span class="offset1">End Date: <?php echo $end_date; ?></span><?php } ?></th>
			</tr>

			<tr>
			  <th>QA</th>
			  <th>Independent</th>
			  <th>Buddy</th>
			  <th>TM</th>
			  <th>Recovery Call</th>
			  <th>Average Score</th>
			  <th>Total Incomplete</th>
			</tr>
		  </thead>
			<?php
				$independent  = 0;
				$buddy  = 0;
				$TM  = 0;
				$sum_score  = 0;
				$i = 0;
				$qa = array();
				$num = 0;
				$total = 0;
				if($this->uri->segment(3)){ $num = $num + $this->uri->segment(3);}  if(isset($data_records)) :foreach($data_records as $row): $num++;
			?>
			   <tbody>
				<tr>
					<td>
					<?php
						foreach($qa_record as $user_row){
							if($row->supervisor_id == $user_row->userid){
								echo $user_row->username;
							}
						}
					?>
					</td>
					<td><?php echo $row->independent; ?></td>
					<td><?php echo $row->buddy; ?></td>
					<td><?php echo $row->TM; ?></td>
					<td><?php echo $row->total_recover; ?></td>
					<td>
					<?php
					$total_overall_score = 0;
					if(isset($total_record)){
						foreach($total_record as $total_record_row){
							if($row->supervisor_id == $total_record_row->supervisor_id){
								$total_overall_score += $total_record_row->final_score;
							}else{
								$total_overall_score += 0;
							}
						}
					}

					$total = $total_overall_score / $row->TM;
					if ( strpos( $total, '.' ) === false ){
						echo $total;
					}else{
						$total = number_format((float)$total, 2, '.', '');
						echo $total;
					}
					
					?>%</td>
					<td>
					<?php
					$total_pendings = 0;
					//var_dump($total_pending);
					if(isset($total_pending)){
						foreach($total_pending as $total_pending_row){
							if($row->supervisor_id == $total_pending_row->supervisor_id){
								$total_pendings += 1;
							}else{
								$total_pendings += 0;
							}
						}
					}
					echo $total_pendings;
					?></td>
				</tr>
			<?php $i++; endforeach; ?>
			<?php else : ?>
				<tr><td colspan="6">No Result Found.</td></tr>
			<?php endif; ?>
			  </tbody>
		</table>
		<?php echo $this->pagination->create_links(); ?>
		<?php }?>
	 </div>
    </div>