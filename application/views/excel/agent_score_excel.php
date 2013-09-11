<?php

$time = date('Y-m-d');
$filename = 'QM_Detailed_Report_' .$time. '.xls';

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
	<h3>QM Summary Detailed Report</h3>
			<?php
				$independent  = 0;
				$i = 0;
				$num = 0; if($this->uri->segment(3)){ $num = $num + $this->uri->segment(3);}  if(isset($data_records)) :foreach($data_records as $row): $num++;
					foreach($qa_record as $user_row){
						if($row->supervisor_id == $user_row->userid){
							$qa[$i] = $user_row->username;
							if($i > 0){
								if ($qa[$i] != $qa[$i-1]){
								?><table class="table table-striped table-hover table-bordered">
									<thead>
									<tr>
									  <th colspan="9">Department: <?php echo $this->session->userdata('tenant_name'); ?><?php if(!empty($start_date)){?><br /><span class="offset1">Start Date: <?php echo $start_date; ?></span><br /><?php } ?><?php if(!empty($end_date)){?><br /><span class="offset1">End Date: <?php echo $end_date; ?></span><?php } ?></th>
									</tr>
									<tr><th colspan="9"><strong>QA By: <?php  echo $qa[$i]; ?></strong></th></tr>
									<tr>
									  <th>Agent</th>
									  <th>Form Used</th>
									  <th>Campaign / Queue</th>
									  <th>Total Major</th>
									  <th>Total Minor</th>
									  <th>Overall Score</th>
									  <th>Passed / Failed</th>
									  <th>Total Incomplete</th>
									  <th>Form Submited</th>
									</tr>
								  </thead><?php
								}
							} else {
							?><table class="table table-striped table-hover table-bordered">
								<thead>
									<tr>
									  <th colspan="9">Department: <?php echo $this->session->userdata('tenant_name'); ?><?php if(!empty($start_date)){?><br /><span class="offset1">Start Date: <?php echo $start_date; ?></span><?php } ?><?php if(!empty($end_date)){?><br /><span class="offset1">End Date: <?php echo $end_date; ?></span><?php } ?></th>
									</tr>
									<tr><th colspan="9"><strong>QA By: <?php  echo $qa[$i]; ?></strong></th></tr>
									<tr>
									  <th>Agent</th>
									  <th>Form Used</th>
									  <th>Campaign / Queue</th>
									  <th>Total Major</th>
									  <th>Total Minor</th>
									  <th>Overall Score</th>
									  <th>Passed / Failed</th>
									  <th>Total Incomplete</th>
									  <th>Form Submited</th>
									</tr>
								</thead><?php
							}
						}
					}
			?>
			<tbody>
				<tr>
					<td><?php echo $row->username; ?></td>
					<td><?php echo $row->qm_title; ?></td>
					<td>
					<?php
					$queuename = "";
					//var_dump($total_pending);
					if(isset($callcontactsdetails)){
						foreach($callcontactsdetails as $callcontactsdetails_row){
							if($row->unique_id == $callcontactsdetails_row->callid){
								$queuename = $callcontactsdetails_row->queuename;
							}
						}
					}
					echo $queuename;
					?></td>
					<td><?php echo $row->question_major_total; ?>%</td>
					<td><?php echo $row->question_minor_total; ?>%</td>
					<td><?php echo $row->final_score; ?>%</td>
					<td><?php if($row->final_score < 90){ echo "Failed"; }else{ echo "Passed"; } ?></td>
					<td>
					<?php
					$total_pendings = 0;
					//var_dump($total_pending);
					if(isset($total_pending)){
						foreach($total_pending as $total_pending_row){
							if($row->userid == $total_pending_row->userid){
								$total_pendings += 1;
							}else{
								$total_pendings += 0;
							}
						}
					}
					echo $total_pendings;
					?></td>
					<td><?php echo $row->date_complete; ?></td>
				</tr>
			<?php  $i++; endforeach; ?>
			<?php else : ?>
				<tr><td colspan="7">No Result Found.</td></tr>
			<?php endif; ?>
			  </tbody>
		</table>
	</body>
</html>