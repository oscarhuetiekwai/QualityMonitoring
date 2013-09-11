<!--<ul class="nav nav-list">
	<?php if($this->session->userdata('role_id')==ADMIN )	{ ?>
	<li class="nav-header">QM Criteria <span class="label label-success">Step 1</span></li>
	<li <?php if($page == "criteria"){ ?> class="active" <?php } ?>><a href="<?php echo site_url("criteria/index"); ?>">Criteria List</a></li>
	<li <?php if($page == "add_criteria"){ ?> class="active" <?php } ?>><a href="<?php echo site_url("criteria/add_criteria"); ?>">Add Criteria</a></li>
	<li class="nav-header">QM Question <span class="label label-success">Step 2</span></li>
	<li <?php if($page == "question"){ ?> class="active" <?php } ?>><a href="<?php echo site_url("question/index"); ?>">Question List</a></li>
	<li <?php if($page == "add_question"){ ?> class="active" <?php } ?>><a href="<?php echo site_url("question/add_question"); ?>">Add Question</a></li>
	<?php } ?>

	<?php if($this->session->userdata('role_id')==AGENT || $this->session->userdata('role_id')==ADMIN)	{ ?>
	<li class="nav-header">Create Form  <?php if($this->session->userdata('role_id')==ADMIN )	{ ?><span class="label label-success">Step 3</span><?php } ?></li>
	<li <?php if($page == "qm"){ ?> class="active" <?php } ?>><a href="<?php echo site_url("qm/index"); ?>">Form List</a></li>
	<?php } ?>
	<?php if($this->session->userdata('role_id')==ADMIN )	{ ?>
	<li <?php if($page == "add_qm"){ ?> class="active" <?php } ?>><a href="<?php echo site_url("qm/add_qm"); ?>">Add Form</a></li>
	<?php } ?>
</ul>-->