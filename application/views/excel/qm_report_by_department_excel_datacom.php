<?php
$time = date('Y-m-d');
$filename = 'QM_Summary_Report_By_Department_' .$time. '.xls';
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
	<h3>QM Summary Report By Department</h3>
		<table class="table table-striped table-hover table-bordered"><thead>
			<tr>
			  <th colspan="10">Department: <?php echo $this->session->userdata('tenant_name'); ?><?php if(!empty($start_date)){?><br /><span class="offset1">Start Date: <?php echo $start_date; ?></span><?php } ?><?php if(!empty($end_date)){?><br /><span class="offset1">End Date: <?php echo $end_date; ?></span><?php } ?></th>
			</tr>

			<tr>
			  <th>Form</th>
			  <th>Independent</th>
			  <th>Buddy</th>
			  <th>TM</th>
			  <th>Recovery Call</th>
			  <th>Critical Business</th>
			  <th>Critical Customer</th>
			  <th>Non Critical</th>
			  <th>Total Incomplete</th>
			  <th>Defect</th>
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
				$total_cb = 0;
				$total_cc = 0;
				$total_nc = 0;
				$cb = 0;
				$cc = 0;
				$nc = 0;
				$recover = 0;
				$pending = 0;
				$final_cb = 0;
				$final_cc = 0;
				$final_nc = 0;
				$defect = 0;
				$total_defect = 0;
				$final_defect = 0;
				if($this->uri->segment(3)){ $num = $num + $this->uri->segment(3);}  if(isset($data_records)) :foreach($data_records as $row): $num++;
			?>
			   <tbody>
				<tr>
					<td><?php echo $row->qm_title; ?></td>
					<td><?php echo $row->independent; ?></td>
					<td><?php echo $row->buddy; ?></td>
					<td><?php echo $row->TM; ?></td>
					<td><?php echo $row->total_recover; ?></td>
					<td>
					<?php
					$total_cb_overall_score = 0;
					if(isset($total_cb_score)){
						foreach($total_cb_score as $total_cb_record_row){
							if($row->qm_id == $total_cb_record_row->qm_id){
								$total_cb_overall_score += $total_cb_record_row->question_cb_total;
							}else{
								$total_cb_overall_score += 0;
							}
						}
					}

					$total_cb = $total_cb_overall_score / $row->TM;
					if ( strpos( $total_cb, '.' ) === false ){
						echo $total_cb;
					}else{
						$total_cb = number_format((float)$total_cb, 2, '.', '');
						echo $total_cb;
					}
					?>%</td>

					<td>
					<?php
					$total_cc_overall_score = 0;
					if(isset($total_cc_score)){
						foreach($total_cc_score as $total_cc_record_row){
							if($row->qm_id == $total_cc_record_row->qm_id){
								$total_cc_overall_score += $total_cc_record_row->question_cc_total;
							}else{
								$total_cc_overall_score += 0;
							}
						}
					}

					$total_cc = $total_cc_overall_score / $row->TM;
					if ( strpos( $total_cc, '.' ) === false ){
						echo $total_cc;
					}else{
						$total_cc = number_format((float)$total_cc, 2, '.', '');
						echo $total_cc;
					}
					?>%</td>

					<td>
					<?php
					$total_nc_overall_score = 0;
					if(isset($total_nc_score)){
						foreach($total_nc_score as $total_nc_record_row){
							if($row->qm_id == $total_nc_record_row->qm_id){
								$total_nc_overall_score += $total_nc_record_row->question_nc_total;
							}else{
								$total_nc_overall_score += 0;
							}
						}
					}

					$total_nc = $total_nc_overall_score / $row->TM;
					if ( strpos( $total_nc, '.' ) === false ){
						echo $total_nc;
					}else{
						$total_nc = number_format((float)$total_nc, 2, '.', '');
						echo $total_nc;
					}
					?>%</td>

					<td>
					<?php
					$total_pendings = 0;
					//var_dump($total_pending);
					if(isset($total_pending)){
						foreach($total_pending as $total_pending_row){
							if($row->qm_id == $total_pending_row->qm_id){
								$total_pendings += 1;
							}else{
								$total_pendings += 0;
							}
						}
					}
					echo $total_pendings;
					$pending += $total_pendings;?></td>
					
					
					<td>
					<?php
					$total_defect_overall_score = 0;
					if(isset($total_defect_score)){
						foreach($total_defect_score as $total_defect_record_row){
							if($row->qm_id == $total_defect_record_row->qm_id){
								$total_defect_overall_score += $total_defect_record_row->total_question_nc;
							}else{
								$total_defect_overall_score += 0;
							}
						}
					}

					$total_defect = $total_defect_overall_score / $row->TM;
					if ( strpos( $total_defect, '.' ) === false ){
						echo $total_defect;
					}else{
						$total_defect = number_format((float)$total_defect, 2, '.', '');
						echo $total_defect;
					}
					?>%</td>
				</tr>
			<?php
			$i++;
			$independent += $row->independent;
			$buddy += $row->buddy;
			$TM += $row->TM;
			$cb += $total_cb_overall_score;

			$cc += $total_cc_overall_score;

			$nc += $total_nc_overall_score;

			$defect += $total_defect_overall_score;
			$recover += $row->total_recover;
			endforeach;
			$final_cb = $cb / $TM;
			$final_cc = $cc / $TM;
			$final_nc = $nc / $TM;
			$final_defect = $defect / $TM;
			?>
			<?php else : ?>
				<tr><td colspan="10">No Result Found.</td></tr>
			<?php endif; ?>
				<tr class="info">
				  <td><strong>Total</strong></td>
				  <td><?php echo $independent;?></td>
				  <td><?php echo $buddy; ?></td>
				  <td><?php echo $TM; ?></td>
				  <td><?php echo $recover; ?></td>
				  <td>
				  <?php
					if ( strpos( $final_cb, '.' ) === false ){
						echo $final_cb;
					}else{
						$final_cb = number_format((float)$final_cb, 2, '.', '');
						echo $final_cb;
					}
				  ?>%
				  </td>
				   <td>
				  <?php
					if ( strpos( $final_cc, '.' ) === false ){
						echo $final_cc;
					}else{
						$final_cc = number_format((float)$final_cc, 2, '.', '');
						echo $final_cc;
					}
				  ?>%
				  </td>
				   <td>
				  <?php
					if ( strpos( $final_nc, '.' ) === false ){
						echo $final_nc;
					}else{
						$final_nc = number_format((float)$final_nc, 2, '.', '');
						echo $final_nc;
					}
				  ?>%
				  </td>
				  <td><?php echo $pending; ?></td>
				   <td>
				  <?php
					if ( strpos( $final_defect, '.' ) === false ){
						echo $final_defect;
					}else{
						$final_defect = number_format((float)$final_defect, 2, '.', '');
						echo $final_defect;
					}
				  ?>%
				  </td>
				</tr>
			  </tbody>
		</table>
	</body>
</html>