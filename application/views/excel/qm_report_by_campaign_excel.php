<?php
$time = date('Y-m-d');
$filename = 'QM_Summary_Report_By_Campaign_' .$time. '.xls';
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
	<h3>QM Summary Report By Campaign</h3>
		<table class="table table-striped table-hover table-bordered"><thead>
			<tr>
			  <th colspan="7">Department: <?php echo $this->session->userdata('tenant_name'); ?><?php if(!empty($start_date)){?><br /><span class="offset1">Start Date: <?php echo $start_date; ?></span><br /><?php } ?><?php if(!empty($end_date)){?><span class="offset1">End Date: <?php echo $end_date; ?></span><?php } ?></th>
			</tr>

			<tr>
			  <th>Campaign / Queue</th>
			  <th>Independent</th>
			  <th>Buddy</th>
			  <th>TM</th>
			  <th>Recovery Call</th>
			  <th>Average Score</th>
			  <th>Total Incomplete</th>
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
				if($this->uri->segment(3)){ $num = $num + $this->uri->segment(3);}  if(isset($data_records)) :foreach($data_records as $row): $num++;
			?>
			   <tbody>
				<tr>
					<td><?php echo $row->queuename; ?></td>
					<td><?php echo $row->independent; ?></td>
					<td><?php echo $row->buddy; ?></td>
					<td><?php echo $row->TM; ?></td>
					<td><?php echo $row->total_recover; ?></td>
					<td>
					<?php
					$total_overall_score = 0;
					if(isset($total_record)){
						foreach($total_record as $total_record_row){
							if($row->queuename == $total_record_row->queuename){
								$total_overall_score += $total_record_row->final_score;
							}else{
								$total_overall_score += 0;
							}
						}
					}

					$total = $total_overall_score / $row->TM;
					if ( strpos( $total, '.' ) === false ){
						echo $total;
					}else{
						$total = number_format((float)$total, 2, '.', '');
						echo $total;
					}
					?>%
					</td>
					<td>
					<?php
					$total_pendings = 0;
					if(isset($total_pending)){
						foreach($total_pending as $total_pending_row){
							if($row->queuename == $total_pending_row->queuename){
								$total_pendings += 1;
							}else{
								$total_pendings += 0;
							}
						}
					}

					echo $total_pendings;
					?>
					</td>
				</tr>
			<?php $i++; endforeach; ?>
			<?php else : ?>
				<tr><td colspan="7">No Result Found.</td></tr>
			<?php endif; ?>
			  </tbody>
		</table>
	</body>
</html>