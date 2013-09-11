	<div class="page-header">
		<h2>Others QM List</h2>
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
                  <div id="collapseOne" class="accordion-body in collapse" style="height: auto;">
                    <div class="accordion-inner">
					<?php $this->load->helper('search_helper'); ?>
					<?php echo form_open('others_recording/search_recording'); ?>
					<?php //$check_old_date = date( 'Y-m-d', strtotime($current_week[0]));  ?>
					  <label>Search Type: </label>
				      <select name="search_type" id="search_type">
					  <option value="">Please Select Search Type</option>
					  <option value="1">Current Week</option>
					  <option value="2">Current Month</option>
					  <option value="3">Older</option>
					  </select>
					  <div class="show_all">
                      <!--<label>Agent Name: </label><input type="text" placeholder="Agent Name" name="agent_name" value="" id="agent_name">-->
					   <div class="show_data_range ">
					  <label>Start Date: </label><input type="text" placeholder="Start Date" name="start_date" value="<?php echo search_date('start_date'); ?>" id="start_date">
					  <label>End Date: </label><input type="text" placeholder="End Date" name="end_date" value="<?php echo search_date('end_date'); ?>" id="end_date">
					  </div>
					  <label>Status: </label>
					  <select name="status" id="status">
					  <option value="">All</option>
					  <option value="1">New</option>
					  <option value="2">Expired</option>
					  <option value="3">Pending</option>
					  <option value="4">Complete</option>
					  </select>
					  </div>
					  <label>Recovery status: </label>
					  <select name="recover" id="recover">
					  <option value="">All</option>
					  <option value="1">Yes</option>
					  <option value="0">No</option>
					  </select>
					<input type="hidden" id="check_old_date" value="<?php// echo $check_old_date;?>">
					<!--<button class="btn btn-primary search" type="button" >Search</button>-->
					<button class="btn btn-primary" type="submit" >Search</button>
			
					<?php 
						$assign_form_url = site_url('others_recording/assign_form_agent/');
						echo  "<a href='".$assign_form_url."' class='btn btn-inverse'>Add New</a>"; ?>
					</form>
                    </div>
                  </div>
                </div>

              </div>
	 </div>
	 <div class="span9">
		<div id="show_recording"></div>
		<?php if($page == "others_recordings2"){?><p><h5>Total Of Row(s) : <?php  if(isset($total_rows)){ echo $total_rows; }?></h5></p><?php } ?>
		<?php if(isset($data_records)){ ?>
		<table class="table table-striped table-hover table-bordered">
			<thead>
				<tr>
				  <th>Date</th>
				  <th>Time</th>
				  <th>Agent</th>
				  <th>Status</th>
				  <th>Recovery</th>
				  <th>Action</th>
				</tr>
			  </thead>
			   <tbody>
			<?php
				$num = 0; if($this->uri->segment(3)){ $num = $num + $this->uri->segment(3);}  if(isset($data_records)) :foreach($data_records as $row): $num++;
				$date = date( 'Y-m-d', strtotime($row->date_created));
				$time = date( 'H:i:s a', strtotime($row->date_created));
				if($row->status == 1){
					$status = "<span class='label label-inverse'>New</span>";
				}else if($row->status == 2){
					$status = "<span class='label label-important'>Expired</span>";
				}else if($row->status == 3){
					$status = "<span class='label label-warning'>Pending</span>";
				}else if($row->status == 4){
					$status = "<span class='label label-success'>Complete</span>";
				}else if($row->status == 5){
					$status = "<span class='label label-warning'>Pending</span>";
				}
				
				if($row->recover == 1){
					$recover = "Yes";
				}else{
					$recover = "No";
				}
			?>
				<tr>
				  <td><?php echo $date; ?></td>
				  <td><?php echo $time; ?></td>
				  <td><?php foreach($get_agent_records as $agent_row){ if($agent_row->record_id == $row->record_id){echo $agent_row->username;}}  ?></td>
				  <td><?php echo $status; ?></td>
				  <td><?php echo $recover; ?></td>
				  <td>
					<?php   
					if($row->status == 1){
						$assign_form_url = site_url('others_recording/assign_form_agent/'.$row->record_id.'/');
						echo  "<a href='".$assign_form_url."'   class='btn btn-small btn-inverse'><i class='icon-arrow-right icon-white'></i> Select Form & Agent</a>";
					}else if($row->status == 4){
						$url = site_url('qm/qm_form_complete/'.$row->record_id.'/'.$row->userid);
						echo  "<a href='".$url."' class='show_qm_form btn btn-small'><i class='icon-eye-open'></i> View<a>";
					}else if($row->status == 5){
						$url = site_url('qm/qm_form_pending_save/'.$row->record_id.'/'.$row->userid);
						echo  "<a href='".$url."' class='show_qm_form btn btn-small btn-warning'><i class='icon-check'></i> Score<a>";
					}else if($row->status == 3){
						$url = site_url('qm/qm_form/'.$row->record_id.'/'.$row->userid);
						echo  "<a href='".$url."' class='show_qm_form btn btn-small  btn-warning'><i class='icon-check'></i> Score<a>";
					}else{
						$url = site_url('qm/qm_form/'.$row->record_id.'/'.$row->userid);
						echo  "<a href='".$url."' class='show_qm_form btn btn-small'><i class='icon-eye-open'></i> View<a>";
					} ?>
				  </td>
				</tr>
			<?php endforeach; ?>
			<?php else : ?>
				<tr><td colspan="6">No Result Found.</td></tr>
			<?php endif; ?>
			  </tbody>
		</table>
		<?php echo $this->pagination->create_links(); ?>
		<?php }else{ ?>
		<?php if($page == "others_recordings2"){?>
		<div class="alert alert-error">
              <button type="button" class="close" data-dismiss="alert">×</button>
              <strong>No Record Found!</strong>
         </div>
		<?php } } ?>
	 </div>
    </div>