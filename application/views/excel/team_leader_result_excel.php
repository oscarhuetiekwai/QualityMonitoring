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
body
{
font-family:verdana;
margin-left:50px;
}
table
{
width:700px;
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
				$num = 0; if($this->uri->segment(3)){ $num = $num + $this->uri->segment(3);}  if(isset($data_records)) :foreach($data_records as $row): $num++;
				$independent += $row->independent;
				$buddy += $row->buddy;
				$TM += $row->TM;
			?>
				<tr>
				  <td><?php echo $row->qm_title; ?></td>
				  <td><?php echo $row->independent; ?></td>
				  <td><?php echo $row->buddy; ?></td>
				  <td><?php echo $row->TM; ?></td>
				  <td></td>
				  <td></td>
				  <td></td>
				  <td></td>
				</tr>

			<?php endforeach; ?>
			<tr class="info">
				  <td>Total</td>
				  <td><?php echo $independent;?></td>
				  <td><?php echo $buddy; ?></td>
				  <td><?php echo $TM; ?></td>
				  <td></td>
				  <td></td>
				  <td></td>
				  <td></td>
				</tr>
			<?php else : ?>
				<tr><td colspan="7">No Result Found.</td></tr>
			<?php endif; ?>
			  </tbody>
		</table>
	</body>
</html>

