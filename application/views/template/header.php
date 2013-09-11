          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">Call Center QM</a>
          <div class="nav-collapse collapse">
               <ul class="nav">
            <!-- <li <?php if($page == "dashboard"){ ?> class="active" <?php } ?>><a href="<?php echo site_url("dashboard/index"); ?>"><i class="icon-home icon-white"></i> Dashboard</a></li>-->
			 <?php if($this->session->userdata('role_id') == QA)	{ ?>
			 <!--<li <?php //if($page == "qm_form"){ ?> class="active" <?php //} ?>><a href="<?php //echo site_url("qm/qm_form"); ?>"><i class="icon-file icon-white"></i> QM Form</a></li>-->
			 <li <?php if($page == "recordings"){ ?> class="active" <?php } ?>><a href="<?php echo site_url("recording/index"); ?>"><i class="icon-file icon-white"></i> Voice Records</a></li>
			 <li <?php if($page == "chat_recordings" || $page == "chat_recordings2" ){ ?> class="active" <?php } ?>><a href="<?php echo site_url("chat_recording/index"); ?>"><i class="icon-file icon-white"></i> Chat Records</a></li>
			 <li <?php if($page == "others_recordings" || $page == "others_recordings2"){ ?> class="active" <?php } ?>><a href="<?php echo site_url("others_recording/index"); ?>"><i class="icon-file icon-white"></i> Others Records</a></li>
			  <li <?php if($page == "voice_logger"){ ?> class="active" <?php } ?>><a href="<?php echo site_url("voice_logger/index"); ?>"><i class="icon-file icon-white"></i> Voice Logger</a></li>
			 <?php } ?>
			  <?php if($this->session->userdata('role_id') == ADMIN || $this->session->userdata('role_id') == SUPERVISOR){ ?>
			 <li  <?php if($page == "qm" || $page == "add_qm" || $page == "edit_qm" || $page == "criteria" || $page == "add_criteria" || $page == "edit_criteria" || $page == "question" || $page == "add_question" || $page == "edit_question"){ ?> class="active" <?php } ?>><a href="<?php echo site_url("qm/index"); ?>"><i class="icon-list-alt icon-white"></i> Create Form</a></li>
			  <li  <?php if($page == "distribution" || $page == "add_distribution" || $page == "edit_distribution" ){ ?> class="active" <?php } ?>><a href="<?php echo site_url("distribution/index"); ?>"><i class="icon-list-alt icon-white"></i> Distribution</a></li>
			  <li class="dropdown ">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-folder-open icon-white"></i> Report <b class="caret"></b></a>
				<ul class="dropdown-menu">
				  <?php if($this->session->userdata('tenant_id') == 2){?>
				  <li class="nav-header">Careline Report</li>
					<!-- <li><a href="<?php //echo site_url("report/overall_summary_for_department"); ?>">Overall Summary For Department</a></li>
				  <li><a href="<?php //echo site_url("report/team_leader_result"); ?>">Team Leader Result</a></li>
				  <li><a href="<?php //echo site_url("report/agent_result"); ?>">Agent Result By Team Leader</a></li>-->
				  <li><a href="<?php echo site_url("report/agent_score_datacom"); ?>">QM Summary Detailed Report </a></li>
				  <li><a href="<?php echo site_url("report/qm_report_by_department_datacom"); ?>">QM Summary Report By Department</a></li>
				  <li><a href="<?php echo site_url("report/qm_report_by_agent_datacom"); ?>">QM Summary Report By Agent</a></li>
				  <li><a href="<?php echo site_url("report/qm_report_by_campaign_datacom"); ?>">QM Summary Report By Campaign / Queue</a></li>
				  <li><a href="<?php echo site_url("report/qm_report_by_section_datacom"); ?>">QM Summary Report By Section / Form</a></li>
				  <li><a href="<?php echo site_url("report/qm_report_by_qa_datacom"); ?>">QM Summary Report By QM Agent</a></li>
				  <li><a href="<?php echo site_url("report/qm_form_pass_fail_ratio"); ?>">QM Form Pass / Fail Ratio</a></li>
				  <li><a href="<?php echo site_url("report/category_pass_fail_ratio"); ?>">Category Pass / Fail Ratio</a></li>
				  <li><a href="<?php echo site_url("report/agent_performance"); ?>">Agent Performance - Defects by Question</a></li>				 
				  <?php }else if($this->session->userdata('tenant_id') == 0){ ?>
				  <li class="nav-header">Careline Report</li>
				  <li><a href="<?php echo site_url("report/agent_score_datacom"); ?>">QM Summary Detailed Report </a></li>
				  <li><a href="<?php echo site_url("report/qm_report_by_department_datacom"); ?>">QM Summary Report By Department</a></li>
				  <li><a href="<?php echo site_url("report/qm_report_by_agent_datacom"); ?>">QM Summary Report By Agent</a></li>
				  <li><a href="<?php echo site_url("report/qm_report_by_campaign_datacom"); ?>">QM Summary Report By Campaign / Queue</a></li>
				  <li><a href="<?php echo site_url("report/qm_report_by_section_datacom"); ?>">QM Summary Report By Section / Form</a></li>
				  <li><a href="<?php echo site_url("report/qm_report_by_qa_datacom"); ?>">QM Summary Report By QM Agent</a></li>
				  <li><a href="<?php echo site_url("report/qm_form_pass_fail_ratio"); ?>">QM Form Pass / Fail Ratio</a></li>
				  <li><a href="<?php echo site_url("report/category_pass_fail_ratio"); ?>">Category Pass / Fail Ratio</a></li>
				  <li><a href="<?php echo site_url("report/agent_performance"); ?>">Agent Performance - Defects by Question</a></li>			
				  <li class="nav-header">Direct Sales Report</li>
				  <li><a href="<?php echo site_url("report/agent_score"); ?>">QM Summary Detailed Report </a></li>
				  <li><a href="<?php echo site_url("report/qm_report_by_agent"); ?>">QM Summary Report By Agent</a></li>
				  <li><a href="<?php echo site_url("report/qm_report_by_campaign"); ?>">QM Summary Report By Campaign / Queue</a></li>
				  <li><a href="<?php echo site_url("report/qm_report_by_section"); ?>">QM Summary Report By Section / Form</a></li>
				  <li><a href="<?php echo site_url("report/qm_report_by_qa"); ?>">QM Summary Report By QM Agent</a></li>				  
				  <?php }else{ ?>
				  <li class="nav-header">Direct Sales Report</li>
				  <li><a href="<?php echo site_url("report/agent_score"); ?>">QM Summary Detailed Report </a></li>
				  <li><a href="<?php echo site_url("report/qm_report_by_agent"); ?>">QM Summary Report By Agent</a></li>
				  <li><a href="<?php echo site_url("report/qm_report_by_campaign"); ?>">QM Summary Report By Campaign / Queue</a></li>
				  <li><a href="<?php echo site_url("report/qm_report_by_section"); ?>">QM Summary Report By Section / Form</a></li>
				  <li><a href="<?php echo site_url("report/qm_report_by_qa"); ?>">QM Summary Report By QM Agent</a></li>
				  <?php } ?>
				</ul>
			  </li>
			  <?php } ?>

            </ul>
			<ul class="nav pull-right">
			  <li><a>Welcome <?php echo $this->session->userdata('username'); ?></a></li>
			  <li class="divider-vertical"></li>

			  <li><a  href="#" data-toggle="tooltip" rel="tooltip" data-placement="bottom" title="" data-original-title="You Logged Tenant"><?php echo $this->session->userdata('tenant_name'); ?></a></li>
			  <li class="divider-vertical"></li>
			  <li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog icon-white demo4"></i> <b class="demo4 caret"></b></a>
				<ul class="dropdown-menu">
				  <li><a href="<?php echo site_url("profile_setting/index"); ?>"><i class="icon-user demo4"></i> Profile Setting</a></li>
				  <li class="divider"></li>
				  <li><a href="<?php echo site_url("login/logout"); ?>"><i class="icon-off demo4"></i> Logout</a></li>
				</ul>
			  </li>
			</ul>
          </div><!--/.nav-collapse -->