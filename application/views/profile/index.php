
<div class="row-fluid">
	<div class="span12">
		<h3 class="heading">User Profile</h3>
		<div class="row-fluid">
			<div class="span12">
				<form class="form-horizontal" method="POST" action="<?php echo site_url('profile_setting/update_profile'); ?>">
				<fieldset>
				<?php $this->load->view('template/show_error'); ?>
				<div class="control-group formSep">
				<label class="control-label">Username</label>
				<div class="controls text_line">
				<strong><input type="text" id="username" class="input-xlarge" name="username" value="<?php echo set_value('username',$admin_records->username); ?>" readonly="readonly" /></strong>
				</div>
				</div>

				<div class="control-group formSep">
				<label for="password" class="control-label">Password</label>
				<div class="controls">
				<div class="sepH_b">
				<input type="password" id="password" class="input-xlarge" value="" name="password" placeholder="New Password" />
				<span class="help-block" style="margin-top:0px;margin-bottom:20px;">Enter your password</span>
				</div>
				<input type="password" id="confirm_password" class="input-xlarge" name="confirm_password" placeholder="Comfirm Password" />
				<span class="help-block" style="margin-top:0px;">Repeat password</span>
				</div>
				</div>

				<div class="control-group">
				<div class="controls">
				<input type="hidden" name="module_index" id="module_index" value="<?php echo base_url('recording/index'); ?>" />
				<input type="submit" class="btn-primary btn" value="Save Change">&nbsp;<button type="reset" class="btn" id="cancel">Cancel</button>
				</div>
				</div>
				</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>