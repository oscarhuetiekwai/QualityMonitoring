	<div class="page-header">		<h2>QM Summary Detailed Report</h2>	</div>	<?php		$this->load->view('template/show_error');	?>	<div class="row">	<div class="span3">	<div class="accordion" id="accordion2">		<div class="accordion-group">		  <div class="accordion-heading">			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">			Search			</a>		  </div>		  <div id="collapseOne" class="accordion-body in collapse" style="min-height: 500px;">			<div class="accordion-inner">			<?php $this->load->helper('search_helper'); ?>			<?php $attributes = array('id' => 'myform');?>			<?php echo form_open('report/search_agent_score',$attributes); ?>			<?php //$check_old_date = date( 'Y-m-d', strtotime($current_week[0]));  ?>			<div class="show_data_range ">				<label>Start Date: </label><input type="text" placeholder="Start Date" name="start_date" value="<?php echo set_value('start_date'); ?>" id="start_date">				<label>End Date: </label><input type="text" placeholder="End Date" name="end_date" value="<?php echo set_value('end_date'); ?>" id="end_date">			</div>			<label>Select QA: </label>			<select name="supervisorid[]" id="chosen_z" data-placeholder="Select QA" class="chzn_z" multiple>				<option value=""></option>				<?php if(isset($user_record)) : foreach($qa_record as $qa_row) : ?>				<option value="<?php echo $qa_row->userid; ?>" <?php if(!empty($supervisor_id)){ foreach($supervisor_id as $supervisor_id_row){ if($supervisor_id_row == $qa_row->userid){?>selected<?php } } } ?>><?php echo $qa_row->username; ?></option>				<?php endforeach; ?>				<?php endif; ?>			</select>			<label>Select Agent: </label>			<select name="userid[]" id="chosen_a" data-placeholder="Select Agent" class="chzn_a" multiple>				<option value=""></option>				<?php if(isset($user_record)) : foreach($user_record as $user_row) : ?>				<option value="<?php echo $user_row->userid; ?>" <?php if(!empty($userid)){ foreach($userid as $userid_row){ if($userid_row == $user_row->userid){?>selected<?php } } } ?>><?php echo $user_row->username; ?></option>				<?php endforeach; ?>				<?php endif; ?>			</select>			<br /><br />			<button class="btn btn-primary agent_score_datacom" ><i class="icon-search icon-white"></i> Search</button>			<a class="btn btn-warning agent_score_excel_datacom" >Export To Excel</a>			</form>			</div>		  </div>		</div>	  </div>	 </div>	 <?php //var_dump($userid); ?>	 <div class="span9">	<?php //var_dump($count_records);?>		<div id="show_recording"></div>		<?php if($page == "agent_score_datacom"){ ?><p><h5>Total Of Row(s) : <?php  if(isset($total_rows)){ echo $total_rows; }?></h5></p><?php } ?>		<?php if(isset($data_records)){		?>			<?php				$independent  = 0;				$i = 0;				$num = 0; if($this->uri->segment(3)){ $num = $num + $this->uri->segment(3);}  if(isset($data_records)) :foreach($data_records as $row): $num++;					foreach($qa_record as $user_row){						if($row->supervisor_id == $user_row->userid){							$qa[$i] = $user_row->username;							if($i > 0){								if ($qa[$i] != $qa[$i-1]){								?><table class="table table-striped table-hover table-bordered"><thead>									<tr>									  <th colspan="10">Department: <?php echo $this->session->userdata('tenant_name'); ?><?php if(!empty($start_date)){?><span class="offset1">Start Date: <?php echo $start_date; ?></span><?php } ?><?php if(!empty($end_date)){?><span class="offset1">End Date: <?php echo $end_date; ?></span><?php } ?></th>									</tr>									<tr><th colspan="10"><strong>QA By: <?php  echo $qa[$i]; ?></strong></th></tr>									<tr>									  <th>Agent</th>									  <th>Form Used</th>									  <th>Campaign / Queue</th>									  <th>Critical Business</th>									  <th>Critical Customer</th>									  <th>Non Critical</th>									  <th>Level</th>									  <th>Passed / Failed</th>									  <th>Total Incomplete</th>									  <th>Form Submited</th>									</tr>								  </thead><?php								}							} else {							?><table class="table table-striped table-hover table-bordered"><thead>									<tr>									  <th colspan="10">Department: <?php echo $this->session->userdata('tenant_name'); ?><?php if(!empty($start_date)){?><span class="offset1">Start Date: <?php echo $start_date; ?></span><?php } ?><?php if(!empty($end_date)){?><span class="offset1">End Date: <?php echo $end_date; ?></span><?php } ?></th>									</tr>									<tr><th colspan="10"><strong>QA By: <?php  echo $qa[$i]; ?></strong></th></tr>									<tr>									  <th>Agent</th>									  <th>Form Used</th>									  <th>Campaign / Queue</th>									  <th>Critical Business</th>									  <th>Critical Customer</th>									  <th>Non Critical</th>									  <th>Level</th>									  <th>Passed / Failed</th>									  <th>Total Incomplete</th>									  <th>Form Submited</th>									</tr>								  </thead><?php							}						}					}			?>			<tbody>				<tr>					<td><?php echo $row->username; ?></td>					<td><?php echo $row->qm_title; ?></td>					<td>					<?php					$queuename = "";					//var_dump($total_pending);					if(isset($callcontactsdetails)){						foreach($callcontactsdetails as $callcontactsdetails_row){							if($row->unique_id == $callcontactsdetails_row->callid){								$queuename = $callcontactsdetails_row->queuename;							}						}					}					echo $queuename;					?></td>					<td><?php echo $row->question_cb_total; ?>%</td>					<td><?php echo $row->question_cc_total; ?>%</td>					<td><?php echo $row->question_nc_total; ?>%</td>					<td>					<?php					$minimum_rate = "";					$maximum_rate = "";					foreach($qm_level_rate_record as $qm_level_rate_row){						if($row->qm_id ==  $qm_level_rate_row->qm_id){							$minimum_rate .= $qm_level_rate_row->minimum_rate . ', ';							$maximum_rate .= $qm_level_rate_row->maximum_rate . ', ';						}					}					$minimum_rate_explode = explode(",",$minimum_rate);					$maximum_rate_explode = explode(",",$maximum_rate);					$level_1_minimum_rate = $minimum_rate_explode[0];					$level_1_maximum_rate = $maximum_rate_explode[0];					$level_2_minimum_rate = $minimum_rate_explode[1];					$level_2_maximum_rate = $maximum_rate_explode[1];					$level_3_minimum_rate = $minimum_rate_explode[2];					$level_3_maximum_rate = $maximum_rate_explode[2];					if($level_1_minimum_rate <=  $row->question_nc_total && $level_1_maximum_rate >=  $row->question_nc_total ){						$level = 1;					}else if($level_2_minimum_rate <=  $row->question_nc_total && $level_2_maximum_rate >=  $row->question_nc_total ){						$level = 2;					}else if($level_3_minimum_rate <=  $row->question_nc_total && $level_3_maximum_rate >=  $row->question_nc_total ){						$level = 3;					}					echo $level;					?>					</td>					<td>					<?php					if($row->question_cb_total == 100 && $row->question_cc_total == 100 && $level != 3 ){						echo "Passed";					}else{						echo "Failed";					}					?>					</td>					<td>					<?php					$total_pendings = 0;					//var_dump($total_pending);					if(isset($total_pending)){						foreach($total_pending as $total_pending_row){							if($row->userid == $total_pending_row->userid){								$total_pendings += 1;							}else{								$total_pendings += 0;							}						}					}					echo $total_pendings;					?></td>					<td><?php echo $row->date_complete; ?></td>				</tr>			<?php  $i++; endforeach; ?>			<?php else : ?>				<tr><td colspan="10">No Result Found.</td></tr>			<?php endif; ?>			  </tbody>		</table>		<?php //var_dump($total_pending); ?>		<?php echo $this->pagination->create_links(); ?>		<?php }?>	 </div>    </div>