	<div class="page-header">
		<h2>QM List</h2>
	</div>
	<?php
		$this->load->view('template/show_error');
	?>
	<div class="row">
	<div class="span3">
	<div class="accordion" id="accordion2">

			<div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
						Search
                    </a>
                  </div>
                  <div id="collapseThree" class="accordion-body collapse" style="height: 0px;">
                    <div class="accordion-inner">
					<?php $this->load->helper('search_helper'); ?>
					<?php echo form_open('recording/search_recordings'); ?>
					<?php $check_old_date = date( 'Y-m-d', strtotime($current_week[0]));  ?>
					  <label>Search Type: </label>
				      <select name="search_type" id="search_type">
					  <option value="">Please Select Search Type</option>
					  <option value="1">Current Week</option>
					  <option value="2">Current Month</option>
					  <option value="3">Older</option>
					  </select>
					  <div class="show_all">
                      <label>Agent Name: </label><input type="text" placeholder="Agent Name" name="agent_name" value="" id="agent_name">
					   <div class="show_data_range ">
					  <label>Start Date: </label><input type="text" placeholder="Start Date" name="start_date" value="" id="start_date">
					  <label>End Date: </label><input type="text" placeholder="End Date" name="end_date" value="" id="end_date">
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
					   <label>Recovery Status: </label>
					  <select name="recover" id="recover">
					  <option value="">All</option>
					  <option value="1">Yes</option>
					  <option value="0">No</option>
					  </select>
					<input type="hidden" id="check_old_date" value="<?php echo $check_old_date;?>">
					<button class="btn btn-primary search" type="button" >Search</button>
					</form>
                    </div>
                  </div>
                </div>

                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                      Current Week
                    </a>
                  </div>
                  <div id="collapseOne" class="accordion-body in collapse" style="height: auto;">
                    <div class="accordion-inner">
						<div class="row">
						<div class="span1">
						<p>
						<a class="current_week_new" start-date1="<?php echo $current_week[0];?>" style="cursor:pointer"  end-date1="<?php echo $current_week[6];?>" ><span class="badge badge-inverse">New : <?php echo $current_week_news_status; ?></span></a>
						</p>
						<p>
						<a class="current_week_expired" start-date2="<?php echo $current_week[0];?>"  style="cursor:pointer" end-date2="<?php echo $current_week[6];?>"><span class="badge badge-important">Expired : <?php echo $current_week_expired_status; ?></span></a>
						</p>
						</div>
						<div class="span1">
						<p>
						<a class="current_week_pending" start-date3="<?php echo $current_week[0];?>" end-date3="<?php echo $current_week[6];?>" style="cursor:pointer"><span class="badge badge-warning">Pending : <?php echo $current_week_pending_status; ?></span></a>
						</p>
						<p>
						<a class="current_week_complete" start-date4="<?php echo $current_week[0];?>" end-date4="<?php echo $current_week[6];?>" style="cursor:pointer"><span class="badge badge-success">Complete : <?php echo $current_week_complete_status; ?></span></a>
						</p>
						</div>
						</div>

						<p><table><tr><td class="span1"><?php $da1 = date( 'l', strtotime($current_week[6])); echo $da1;?></td><td class="span2" style="text-align:center;"><?php $da1 = date( 'd-m-Y', strtotime($current_week[6])); echo $da1;?></td><td><a class="checkdate" data-date="<?php echo $current_week[6];?>"  style="cursor:pointer"><i class="icon-list-alt pull-right"></i></a></tr></table></p>

						<p><table><tr><td class="span1"><?php $da1 = date( 'l', strtotime($current_week[5])); echo $da1;?></td><td class="span2" style="text-align:center;"><?php $da1 = date( 'd-m-Y', strtotime($current_week[5])); echo $da1;?></td><td><a class="checkdate" data-date="<?php echo $current_week[5];?>"  style="cursor:pointer"><i class="icon-list-alt pull-right"></i></a></tr></table></p>

						<p><table><tr><td class="span1"><?php $da1 = date( 'l', strtotime($current_week[4])); echo $da1;?></td><td class="span2" style="text-align:center;"><?php $da1 = date( 'd-m-Y', strtotime($current_week[4])); echo $da1;?></td><td><a class="checkdate" data-date="<?php echo $current_week[4];?>"  style="cursor:pointer"><i class="icon-list-alt pull-right"></i></a></tr></table></p>

						<p><table><tr><td class="span1"><?php $da1 = date( 'l', strtotime($current_week[3])); echo $da1;?></td><td class="span2" style="text-align:center;"><?php $da1 = date( 'd-m-Y', strtotime($current_week[3])); echo $da1;?></td><td><a class="checkdate" data-date="<?php echo $current_week[3];?>"  style="cursor:pointer"><i class="icon-list-alt pull-right"></i></a></tr></table></p>

						<p><table><tr><td class="span1"><?php $da1 = date( 'l', strtotime($current_week[2])); echo $da1;?></td><td class="span2" style="text-align:center;"><?php $da1 = date( 'd-m-Y', strtotime($current_week[2])); echo $da1;?></td><td><a class="checkdate" data-date="<?php echo $current_week[2];?>"  style="cursor:pointer"><i class="icon-list-alt pull-right"></i></a></tr></table></p>

						<p><table><tr><td class="span1"><?php $da1 = date( 'l', strtotime($current_week[1])); echo $da1;?></td><td class="span2" style="text-align:center;"><?php $da1 = date( 'd-m-Y', strtotime($current_week[1])); echo $da1;?></td><td><a class="checkdate" data-date="<?php echo $current_week[1];?>"  style="cursor:pointer"><i class="icon-list-alt pull-right"></i></a></tr></table></p>

						<p><table><tr><td class="span1"><?php $da1 = date( 'l', strtotime($current_week[0])); echo $da1;?></td><td class="span2" style="text-align:center;"><?php $da1 = date( 'd-m-Y', strtotime($current_week[0])); echo $da1;?></td><td><a class="checkdate" data-date="<?php echo $current_week[0];?>"  style="cursor:pointer"><i class="icon-list-alt pull-right"></i></a></tr></table></p>
                    </div>
                  </div>
                </div>
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
                      Older
                    </a>
                  </div>
                  <div id="collapseTwo" class="accordion-body collapse" style="height: 0px;">
                    <div class="accordion-inner">
					<div class="row">
					<div class="span1">
					<p>
					<a class="older_week_new" start-date="<?php echo $current_week[0];?>" end-date="<?php echo $current_week[6];?>" style="cursor:pointer"><span class="badge badge-inverse">New : <?php echo $old_news_status; ?></span></a>
					</p>
					<p>
					<a class="older_week_expired" start-date="<?php echo $current_week[0];?>" end-date="<?php echo $current_week[6];?>" style="cursor:pointer"><span class="badge badge-important">Expired : <?php echo $old_expired_status; ?></span></a>
					</p>
					</div>
					<div class="span1">
					<p>
					<a class="older_week_pending" start-date="<?php echo $current_week[0];?>" end-date="<?php echo $current_week[6];?>" style="cursor:pointer"><span class="badge badge-warning">Pending : <?php echo $old_pending_status; ?></span></a>
					</p>
					<p>
					<a class="older_week_complete" start-date="<?php echo $current_week[0];?>" end-date8="<?php echo $current_week[6];?>" style="cursor:pointer"><span class="badge badge-success">Complete : <?php echo $old_complete_status; ?></span></a>
					</p>
					</div>
					</div>

                    </div>
                  </div>
                </div>

              </div>
	 </div>
	 <div class="span9">
		<div id="show_recording"></div>
	 </div>
    </div>