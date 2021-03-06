<?php
$time = date('Y-m-d');
$filename = 'QM_Form_Pass_Fail_Ratio_' .$time. '.xls';
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
	<h3>QM Form Pass / Fail Ratio</h3>
			<table class="table table-striped table-hover table-bordered"><thead>
			<tr>
			  <th colspan="7">Department: <?php echo $this->session->userdata('tenant_name'); ?><?php if(!empty($start_date)){?><br /><span class="offset1">Start Date: <?php echo $start_date; ?></span><?php } ?><?php if(!empty($end_date)){?><br /><span class="offset1">End Date: <?php echo $end_date; ?></span><?php } ?></th>
			</tr>
			<tr>
			  <th colspan="7">Form: <?php if(!empty($data_records[0]->qm_title)){?><?php echo $data_records[0]->qm_title; ?><?php } ?><?php if(!empty($formtype)){?><br /><span class="offset1">Form Type: <?php if($formtype == 1){echo "Critical";}else{echo "Non Critical";} ?></span><?php } ?></th>
			</tr>
			<tr>
			  <th>Question</th>
			  <th>Pass</th>
			  <th>Fail</th>
			  <th>Total Marked</th>
			  <th>N / A</th>
			  <th>Pass %</th>
			  <th>Fail %</th>
			</tr>
		  </thead>
			<?php
				$pass  = 0;
				$fail  = 0;
				$TM  = 0;
				$na  = 0;
				$i = 0;
				$total_cb = 0;
				$total_cc = 0;
				$total_TM = 0;
				$total_question = 0;
				$final_total_pass = 0;
				$final_total_fail = 0;
				$grand_total_pass = 0;
				$grand_total_fail = 0;
				$num = 0;
				$passed = 0;
				$failed = 0;
				$tq =0;
				$na = 0;
				$tp = 0;
				$tf = 0;
				if($this->uri->segment(3)){ $num = $num + $this->uri->segment(3);}  if(isset($data_records)) :foreach($data_records as $row): $num++;
			?>
			   <tbody>
				<tr>
					<td><?php echo $row->question_title; ?></td>
					<td>
					<?php
					$total_passed = 0;
					if(isset($total_pass)){
						foreach($total_pass as $total_pass_record_row){
							if($row->question_id == $total_pass_record_row->question_id){
								if($total_pass_record_row->question_format == 4){
									if($total_pass_record_row->question_cb == 1 && $total_pass_record_row->question_cb != 9911){
										$total_passed += 1;
									}
								}else if($total_pass_record_row->question_format == 5){
									if($total_pass_record_row->question_cc == 1 && $total_pass_record_row->question_cc != 9911){
										$total_passed += 1;
									}
								}else if($total_pass_record_row->question_format == 6){
									if($total_pass_record_row->question_nc == 1 && $total_pass_record_row->question_nc != 9911){
										$total_passed += 1;
										//var_dump($total_pass_record_row->question_nc);
									}
								}

							}

						}
					}
					echo $total_passed;
					?></td>
					<td>
					<?php
					$total_failed = 0;
					if(isset($total_fail)){
						foreach($total_fail as $total_fail_record_row){
							if($row->question_id == $total_fail_record_row->question_id){
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
					<td>
					<?php
					$total_question = $total_failed + $total_passed;
					echo $total_question;
					?>
					</td>
					<td>
					<?php
					$total_na_count = 0;
					if(isset($total_na)){
						foreach($total_na as $total_na_record_row){
							if($row->question_id == $total_na_record_row->question_id){
								if($total_na_record_row->question_format == 4){
									if($total_na_record_row->question_cb == 9911){
										$total_na_count += 1;
									}
								}else if($total_na_record_row->question_format == 5){
									if($total_na_record_row->question_cc == 9911){
										$total_na_count += 1;
									}
								}else if($total_na_record_row->question_format == 6){
									if($total_na_record_row->question_nc == 9911){
										$total_na_count += 1;
									}
								}
							}
						}
					}
					echo $total_na_count;
					?></td>
					<td>
					<?php
					$final_total_pass = ($total_passed / $total_question) * 100;

					if ( strpos( $final_total_pass, '.' ) === false ){
						echo $final_total_pass;
					}else{
						$final_total_pass = number_format((float)$final_total_pass, 2, '.', '');
						echo $final_total_pass;
					}

					?>
					%
					</td>
					<td>
					<?php
					$final_total_fail = ($total_failed / $total_question) * 100;
					if ( strpos( $final_total_fail, '.' ) === false ){
						echo $final_total_fail;
					}else{
						$final_total_fail = number_format((float)$final_total_fail, 2, '.', '');
						echo $final_total_fail;
					}
					?>
					%
					</td>

				</tr>
			<?php
			$i++;
			$passed += $total_passed;
			$failed += $total_failed;
			$tq += $total_question;
			$na += $total_na_count;
			$tp += $final_total_pass;
			$tf += $final_total_fail;
			endforeach;
			$grand_total_pass = ($passed / $tq) * 100;
			$grand_total_fail = ($failed / $tq) * 100;

			?>
			<?php else : ?>
				<tr><td colspan="9">No Result Found.</td></tr>
			<?php endif; ?>
				<tr class="info">
				  <td><strong>Total</strong></td>
				  <td><?php echo $passed; ?></td>
				  <td><?php echo $failed; ?></td>
				  <td><?php echo $tq; ?></td>
				  <td><?php echo $na; ?></td>
				  <td>
				  <?php
					if ( strpos( $grand_total_pass, '.' ) === false ){
						echo $grand_total_pass;
					}else{
						$grand_total_pass = number_format((float)$grand_total_pass, 2, '.', '');
						echo $grand_total_pass;
					}
				  ?>
				   %
				  </td>

				  <td>
				  <?php
					if ( strpos( $grand_total_fail, '.' ) === false ){
						echo $grand_total_fail;
					}else{
						$grand_total_fail = number_format((float)$grand_total_fail, 2, '.', '');
						echo $grand_total_fail;
					}
				  ?>
				  %
				  </td>

				</tr>
			  </tbody>
		</table>
	</body>
</html>