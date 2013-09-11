	<div class="page-header">
		<h2>QM Form Pass / Fail Ratio</h2>
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
			<?php echo form_open('report/qm_form_pass_fail_ratio',$attributes); ?>
			<?php //$check_old_date = date( 'Y-m-d', strtotime($current_week[0]));  ?>

			<div class="show_data_range ">
				<label>Start Date: </label><input type="text" placeholder="Start Date" name="start_date" value="<?php echo set_value('start_date'); ?>" id="start_date">
				<label>End Date: </label><input type="text" placeholder="End Date" name="end_date" value="<?php echo set_value('end_date'); ?>" id="end_date">
			</div>

			<label>Select QM Form: </label>
			<select name="qmid" id="chosen_z" data-placeholder="Select QM Form" class="chzn_z">
				<option value=""></option>
				<?php if(isset($qm_record)) : foreach($qm_record as $qm_row) : ?>
				<option value="<?php echo $qm_row->qm_id; ?>" <?php if(!empty($qm_id)){ if($qm_id == $qm_row->qm_id){?>selected<?php } }  ?>><?php echo $qm_row->qm_title; ?></option>
				<?php endforeach; ?>
				<?php endif; ?>
			</select>

			<label>Form Type: </label>
			<select name="formtype" id="chosen_b" data-placeholder="Select Critical / Non Critical" class="chzn_a">
				<option value=""></option>
				<option value="1" <?php if(!empty($formtype)){ if($formtype == 1){?>selected <?php } } ?>>Critical</option>
				<option value="2" <?php if(!empty($formtype)){ if($formtype == 2){?>selected <?php } } ?>>Non Critical</option>
			</select>

			<br /><br />

			<button class="btn btn-primary qm_form_pass_fail_ratio" ><i class="icon-search icon-white"></i> Search</button>
			<a class="btn btn-warning qm_form_pass_fail_ratio_excel" >Export To Excel</a>
			</form>
			</div>
		  </div>
		</div>
	  </div>
	 </div>
	 <?php	//var_dump($total_pass);?>
	 <div class="span9">
	<?php //var_dump($count_records);?>
		<div id="show_recording"></div>
		<?php if($page == "qm_form_pass_fail_ratio"){ ?><p><h5>Total Of Row(s) : <?php  if(isset($total_rows)){ echo $total_rows; }?></h5></p><?php } ?>
		<?php if(isset($data_records)){ ?>
			<table class="table table-striped table-hover table-bordered"><thead>
			<tr>
			  <th colspan="7">Department: <?php echo $this->session->userdata('tenant_name'); ?><?php if(!empty($start_date)){?><span class="offset1">Start Date: <?php echo $start_date; ?></span><?php } ?><?php if(!empty($end_date)){?><span class="offset1">End Date: <?php echo $end_date; ?></span><?php } ?></th>
			</tr>
			<tr>
			  <th colspan="7">Form: <?php if(!empty($data_records[0]->qm_title)){?><?php echo $data_records[0]->qm_title; ?><?php } ?><?php if(!empty($formtype)){?><span class="offset4">Form Type: <?php if($formtype == 1){echo "Critical";}else{echo "Non Critical";} ?></span><?php } ?></th>
			</tr>
			<tr>
			  <th>Question</th>
			  <th>Pass</th>
			  <th>Fail</th>
			  <th>Total Marked</th>
			  <th>N / A</th>
			  <th>Pass %</th>
			  <th>Fail %</th>
			</tr>
		  </thead>
			<?php
				$pass  = 0;
				$fail  = 0;
				$TM  = 0;
				$na  = 0;
				$i = 0;
				$total_cb = 0;
				$total_cc = 0;
				$total_TM = 0;
				$total_question = 0;
				$final_total_pass = 0;
				$final_total_fail = 0;
				$grand_total_pass = 0;
				$grand_total_fail = 0;
				$num = 0;
				$passed = 0;
				$failed = 0;
				$tq =0;
				$na = 0;
				$tp = 0;
				$tf = 0;
				if($this->uri->segment(3)){ $num = $num + $this->uri->segment(3);}  if(isset($data_records)) :foreach($data_records as $row): $num++;
			?>
			   <tbody>
				<tr>
					<td><?php echo $row->question_title; ?></td>
					<td>
					<?php
					$total_passed = 0;
					if(isset($total_pass)){
						foreach($total_pass as $total_pass_record_row){
							if($row->question_id == $total_pass_record_row->question_id){
								if($total_pass_record_row->question_format == 4){
									if($total_pass_record_row->question_cb == 1 && $total_pass_record_row->question_cb != 9911){
										$total_passed += 1;
									}
								}else if($total_pass_record_row->question_format == 5){
									if($total_pass_record_row->question_cc == 1 && $total_pass_record_row->question_cc != 9911){
										$total_passed += 1;
									}
								}else if($total_pass_record_row->question_format == 6){
									if($total_pass_record_row->question_nc == 1 && $total_pass_record_row->question_nc != 9911){
										$total_passed += 1;
									}
								}

							}

						}
					}
					echo $total_passed;
					?></td>
					<td>
					<?php
					$total_failed = 0;
					if(isset($total_fail)){
						foreach($total_fail as $total_fail_record_row){
							if($row->question_id == $total_fail_record_row->question_id){
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
					<td>
					<?php
					$total_question = $total_failed + $total_passed;
					echo $total_question;
					?>
					</td>
					<td>
					<?php
					$total_na_count = 0;
					if(isset($total_na)){
						foreach($total_na as $total_na_record_row){
							if($row->question_id == $total_na_record_row->question_id){
								if($total_na_record_row->question_format == 4){
									if($total_na_record_row->question_cb == 9911){
										$total_na_count += 1;
									}
								}else if($total_na_record_row->question_format == 5){
									if($total_na_record_row->question_cc == 9911){
										$total_na_count += 1;
									}
								}else if($total_na_record_row->question_format == 6){
									if($total_na_record_row->question_nc == 9911){
										$total_na_count += 1;
									}
								}
							}
						}
					}
					echo $total_na_count;
					?></td>
					<td>
					<?php
					$final_total_pass = ($total_passed / $total_question) * 100;

					if ( strpos( $final_total_pass, '.' ) === false ){
						echo $final_total_pass;
					}else{
						$final_total_pass = number_format((float)$final_total_pass, 2, '.', '');
						echo $final_total_pass;
					}

					?>
					%
					</td>
					<td>
					<?php
					$final_total_fail = ($total_failed / $total_question) * 100;
					if ( strpos( $final_total_fail, '.' ) === false ){
						echo $final_total_fail;
					}else{
						$final_total_fail = number_format((float)$final_total_fail, 2, '.', '');
						echo $final_total_fail;
					}
					?>
					%
					</td>

				</tr>
			<?php
			$i++;
			$passed += $total_passed;
			$failed += $total_failed;
			$tq += $total_question;
			$na += $total_na_count;
			$tp += $final_total_pass;
			$tf += $final_total_fail;
			endforeach;
			$grand_total_pass = ($passed / $tq) * 100;
			$grand_total_fail = ($failed / $tq) * 100;

			?>
			<?php else : ?>
				<tr><td colspan="6">No Result Found.</td></tr>
			<?php endif; ?>
				<tr class="info">
				  <td><strong>Total</strong></td>
				  <td><?php echo $passed; ?></td>
				  <td><?php echo $failed; ?></td>
				  <td><?php echo $tq; ?></td>
				  <td><?php echo $na; ?></td>
				  <td>
				  <?php
					if ( strpos( $grand_total_pass, '.' ) === false ){
						echo $grand_total_pass;
					}else{
						$grand_total_pass = number_format((float)$grand_total_pass, 2, '.', '');
						echo $grand_total_pass;
					}
				  ?>
				   %
				  </td>

				  <td>
				  <?php
					if ( strpos( $grand_total_fail, '.' ) === false ){
						echo $grand_total_fail;
					}else{
						$grand_total_fail = number_format((float)$grand_total_fail, 2, '.', '');
						echo $grand_total_fail;
					}
				  ?>
				  %
				  </td>

				</tr>
			  </tbody>
		</table>
		<?php echo $this->pagination->create_links(); ?>
		<?php }?>
	 </div>
    </div>