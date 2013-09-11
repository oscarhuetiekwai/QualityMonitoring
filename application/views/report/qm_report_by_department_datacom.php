	<div class="page-header">
		<h2>QM Summary Report By Department</h2>
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
			<?php echo form_open('report/search_qm_report_by_department',$attributes); ?>
			<?php //$check_old_date = date( 'Y-m-d', strtotime($current_week[0]));  ?>

			<div class="show_data_range ">
				<label>Start Date: </label><input type="text" placeholder="Start Date" name="start_date" value="<?php echo set_value('start_date'); ?>" id="start_date">
				<label>End Date: </label><input type="text" placeholder="End Date" name="end_date" value="<?php echo set_value('end_date'); ?>" id="end_date">
			</div>

			<label>Select QM Form: </label>
			<select name="qmid[]" id="chosen_z" data-placeholder="Select QM Form" class="chzn_z" multiple>
				<option value=""></option>
				<?php if(isset($qm_record)) : foreach($qm_record as $qm_row) : ?>
				<option value="<?php echo $qm_row->qm_id; ?>" <?php if(!empty($qm_id)){ foreach($qm_id as $qm_id_row){ if($qm_id_row == $qm_row->qm_id){?>selected<?php } } } ?>><?php echo $qm_row->qm_title; ?></option>
				<?php endforeach; ?>
				<?php endif; ?>
			</select>

			<br /><br />

			<button class="btn btn-primary qm_report_by_department_datacom" ><i class="icon-search icon-white"></i> Search</button>
			<a class="btn btn-warning qm_report_by_department_excel_datacom" >Export To Excel</a>
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
		<?php if($page == "qm_report_by_department_datacom"){ ?><p><h5>Total Of Row(s) : <?php  if(isset($total_rows)){ echo $total_rows; }?></h5></p><?php } ?>
		<?php if(isset($data_records)){ ?>
			<table class="table table-striped table-hover table-bordered"><thead>
			<tr>
			  <th colspan="10">Department: <?php echo $this->session->userdata('tenant_name'); ?><?php if(!empty($start_date)){?><span class="offset1">Start Date: <?php echo $start_date; ?></span><?php } ?><?php if(!empty($end_date)){?><span class="offset1">End Date: <?php echo $end_date; ?></span><?php } ?></th>
			</tr>

			<tr>
			  <th>Form</th>
			  <th>Independent</th>
			  <th>Buddy</th>
			  <th>TM</th>
			  <th>Recovery Call</th>
			  <th>Critical Business</th>
			  <th>Critical Customer</th>
			  <th>Non Critical</th>
			  <th>Total Incomplete</th>
			  <th>Defect</th>
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
				$defect = 0;
				$total_defect = 0;
				$final_defect = 0;
				if($this->uri->segment(3)){ $num = $num + $this->uri->segment(3);}  if(isset($data_records)) :foreach($data_records as $row): $num++;
			?>
			   <tbody>
				<tr>
					<td><?php echo $row->qm_title; ?></td>
					<td><?php echo $row->independent; ?></td>
					<td><?php echo $row->buddy; ?></td>
					<td><?php echo $row->TM; ?></td>
					<td><?php echo $row->total_recover; ?></td>
					<td>
					<?php
					$total_cb_overall_score = 0;
					if(isset($total_cb_score)){
						foreach($total_cb_score as $total_cb_record_row){
							if($row->qm_id == $total_cb_record_row->qm_id){
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
							if($row->qm_id == $total_cc_record_row->qm_id){
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
							if($row->qm_id == $total_nc_record_row->qm_id){
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
							if($row->qm_id == $total_pending_row->qm_id){
								$total_pendings += 1;
							}else{
								$total_pendings += 0;
							}
						}
					}
					echo $total_pendings;
					$pending += $total_pendings;?></td>
					
					
					<td>
					<?php
					$total_defect_overall_score = 0;
					if(isset($total_defect_score)){
						foreach($total_defect_score as $total_defect_record_row){
							if($row->qm_id == $total_defect_record_row->qm_id){
								$total_defect_overall_score += $total_defect_record_row->total_question_nc;
							}else{
								$total_defect_overall_score += 0;
							}
						}
					}

					$total_defect = $total_defect_overall_score / $row->TM;
					if ( strpos( $total_defect, '.' ) === false ){
						echo $total_defect;
					}else{
						$total_defect = number_format((float)$total_defect, 2, '.', '');
						echo $total_defect;
					}
					?>%</td>
				</tr>
			<?php
			$i++;
			$independent += $row->independent;
			$buddy += $row->buddy;
			$TM += $row->TM;
			$cb += $total_cb_overall_score;

			$cc += $total_cc_overall_score;

			$nc += $total_nc_overall_score;

			$defect += $total_defect_overall_score;
			$recover += $row->total_recover;
			endforeach;
			$final_cb = $cb / $TM;
			$final_cc = $cc / $TM;
			$final_nc = $nc / $TM;
			$final_defect = $defect / $TM;
			?>
			<?php else : ?>
				<tr><td colspan="6">No Result Found.</td></tr>
			<?php endif; ?>
				<tr class="info">
				  <td><strong>Total</strong></td>
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
				   <td>
				  <?php
					if ( strpos( $final_defect, '.' ) === false ){
						echo $final_defect;
					}else{
						$final_defect = number_format((float)$final_defect, 2, '.', '');
						echo $final_defect;
					}
				  ?>%
				  </td>
				</tr>
			  </tbody>
		</table>
		<?php echo $this->pagination->create_links(); ?>
		<?php }?>
	 </div>
    </div>