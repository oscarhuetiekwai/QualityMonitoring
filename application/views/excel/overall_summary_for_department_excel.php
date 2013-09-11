<?php

$time = date('YmdHis');
$filename = 'Overall_Summary_for_Department_' .$time. '.xls';

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
	<h3>Overall Summary for Department</h3>
		<table class="table table-striped table-hover table-bordered">

			<thead>
				<tr>
				  <th colspan="8">Department: <?php echo $this->session->userdata('tenant_name'); ?><?php if(!empty($start_date)){?><br />Start Date: <?php echo $start_date; ?><?php } ?><?php if(!empty($end_date)){?><br />End Date: <?php echo $end_date; ?><?php } ?></th>
				</tr>
				<tr>
				  <th>Form</th>
				  <th>Independent</th>
				  <th>Buddy</th>
				  <th>TM</th>
				  <th>Critical Business</th>
				  <th>Critical Customer</th>
				  <th>Non Critical</th>
				  <th>Defect</th>
				</tr>
			  </thead>
			   <tbody>

			<?php
				$independent  = 0;
				$buddy  = 0;
				$TM  = 0;
				$total_cb = 0;
				$total_cc = 0;
				$total_nc = 0;
				$final_total_cb = 0;
				$final_total_cc = 0;
				$final_total_nc = 0;
				$cb = 0;
				$cbsucess = 0;
				$cc = 0;
				$ccsucess = 0;
				$nc = 0;
				$ncsucess = 0;
				$total_defect = 0;
				$total_question = 0;
				$final_defect = 0;
				$num = 0; if($this->uri->segment(3)){ $num = $num + $this->uri->segment(3);}  if(isset($data_records)) :foreach($data_records as $row): $num++;
				$independent += $row->independent;
				$buddy += $row->buddy;
				$TM += $row->TM;
				$cb += $row->totalcb;
				$cbsucess += $row->totalcbsuccess;
				$cc += $row->totalcc;
				$ccsucess += $row->totalccsuccess;
				$nc += $row->totalnc;
				$ncsucess += $row->totalncsuccess;
			?>
				<tr>
				  <td><?php echo $row->qm_title; ?></td>
				  <td><?php echo $row->independent; ?></td>
				  <td><?php echo $row->buddy; ?></td>
				  <td><?php echo $row->TM; ?></td>
				  <td><?php $total_cb = $row->TM * $row->totalcb; $total_cb =($row->totalcbsuccess * 100 )/ $total_cb; echo $total_cb; ?>%</td>
				  <td><?php $total_cc = $row->TM * $row->totalcc; $total_cc =($row->totalccsuccess * 100 )/ $total_cc; echo $total_cc; ?>%</td>
				  <td><?php $total_nc = $row->TM * $row->totalnc; $total_nc =($row->totalncsuccess * 100 )/ $total_nc; echo $total_nc; ?>%</td>
				  <td><?php $total_question = $TM * ($row->totalcb + $row->totalcc + $row->totalnc); $total_defect = $total_question - ($row->totalcbsuccess + $row->totalccsuccess + $row->totalncsuccess); $final_defect = ($total_defect / $total_question) * 100; echo $final_defect; ?>%</td>
				</tr>

			<?php endforeach; ?>
			<tr class="info" style="background:lightblue;color:black;font-weight:bold;">
				<td style="font-weight:bold;">Total</td>
				<td><?php echo $independent;?></td>
				<td><?php echo $buddy; ?></td>
				<td><?php echo $TM; ?></td>
				 <td><?php $final_total_cb = $cb * $TM; $final_total_cb = ($cbsucess * 100 )/ $final_total_cb; echo $final_total_cb;?>%</td>
				  <td><?php $final_total_cc = $cc * $TM; $final_total_cc = ($ccsucess * 100 )/ $final_total_cc; echo $final_total_cc; ?>%</td>
				  <td><?php $final_total_nc = $nc * $TM; $final_total_nc = ($ncsucess * 100 )/ $final_total_nc; echo $final_total_nc; ?>%</td>
				<td></td>
			</tr>
			<?php else : ?>
				<tr><td colspan="7">No Result Found.</td></tr>
			<?php endif; ?>
			  </tbody>
		</table>

		<canvas id="canvas" height="450" width="600"></canvas>
	</body>
</html>
<?php
	echo js('Chart.js');
?>
<script type="text/javascript">

	var barChartData = {
		labels : ["January","February","March","April","May","June","July"],
		datasets : [
			{
				fillColor : "rgba(220,220,220,0.5)",
				strokeColor : "rgba(220,220,220,1)",
				data : [65,59,90,81,56,55,40]
			},
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,1)",
				data : [28,48,40,19,96,27,100]
			}
		]
	}
var myLine = new Chart(document.getElementById("canvas").getContext("2d")).Bar(barChartData);

</script>