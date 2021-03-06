<?php

$time = date('Y-m-d');
$filename = 'agent_performance_' .$time. '.xls';

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment;filename=".$filename);
header("Content-Transfer-Encoding: binary ");

?>
<html>
<head>
<?php
	##Bootstrap framework ##
	echo css('bootstrap.css');

?>
<style type="text/css">

table
{
width:900px;
border-collapse:collapse;
}
table,th, td
{
border: 1px solid #DDDDDD;
}
th
{
background-color:#E3E4FA;
}
td
{
text-align:center;
padding:5px;
}
</style>
</head>
<body>
	<h3>Agent Performance - Defect By Question</h3>
		<table class="table table-striped table-hover table-bordered"><thead>
			<tr>
			  <th colspan="4">Department: <?php echo $this->session->userdata('tenant_name'); ?><?php if(!empty($start_date)){?><br /><span class="offset1">Start Date: <?php echo $start_date; ?></span><?php } ?><?php if(!empty($end_date)){?><br /><span class="offset1">End Date: <?php echo $end_date; ?></span><?php } ?></th>
			</tr>

			<tr>
			  <th>Agent</th>
			  <th>QA</th>
			  <th>Question</th>
			  <th>Fail</th>
			</tr>
		  </thead>
			<?php
				$num = 0;
				$i = 0;
				$failed = 0;
				if($this->uri->segment(3)){ $num = $num + $this->uri->segment(3);}  if(isset($data_records)) :foreach($data_records as $row): $num++;
			?>
			   <tbody>
				<tr>
					<td><?php echo $row->username; ?></td>
					<td>
					<?php
						foreach($qa_record as $user_row){
							if($row->supervisor_id == $user_row->userid){
								echo $user_row->username;
							}
						}
					?>
					</td>


					<td><?php echo $row->question_title; ?></td>
					<td>
					<?php
					$total_failed = 0;
					if(isset($total_fail)){
						foreach($total_fail as $total_fail_record_row){

							if($row->question_id == $total_fail_record_row->question_id && $total_fail_record_row->supervisor_id == $row->supervisor_id && $total_fail_record_row->userid == $row->userid){

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

				</tr>
			<?php
			$i++;
			$failed += $total_failed;
			endforeach;
			/* $final_cb = $cb / $TM;
			$final_cc = $cc / $TM;
			$final_nc = $nc / $TM; */
			?>
			<?php else : ?>
				<tr><td colspan="6">No Result Found.</td></tr>
			<?php endif; ?>
			<tr class="info">
				  <td><strong>Total</strong></td>
				  <td></td>
				  <td></td>
				  <td><?php echo $failed; ?></td>
			</tr>
			</tbody>
		</table>
	</body>
</html>