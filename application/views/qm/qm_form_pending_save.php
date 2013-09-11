<?php $this->load->view('template/show_error');
if($recording_type == 1){
## copy file to my server ##
$file = '/var/spool/asterisk/monitor/'.$record_filename;
$newfile = '/var/www/html/qm/file/'.$record_filename;
	if(!empty($file)){
		copy($file, $newfile);
	}
}
?>
<div class='row'>
<div class='offset5' style='text-decoration:underline;'><h2><?php echo $qm_title; ?></h2></div>
</div>

<div class='offset5'>
<!--<p><?php $rest = substr($queuename, 0, 1);    if($rest == "t"){ ?>In Bound: <?php }else{ ?> Out Bound:  <?php } ?><?php echo $queuename; ?></p></div>-->
</div>
<div class='well '>
<div class="row">

<div class="span5">

<fieldset>
<legend>Agent Detail:</legend><strong>Agent Name:</strong> <?php echo $username; ?><br>
<?php if($recording_type == 1){ ?>
<strong>Date:</strong>  <?php $phpdate = $connecttime;
$mysqldate = date( 'Y-m-d H:i:s a', strtotime( $phpdate ) );echo $mysqldate; ?><br>
<strong>Extension Number:</strong> <?php echo $extension; ?><br>
<strong>Phone Number:</strong>  <?php echo $callerid; ?>
<?php } ?>
</fieldset>
</div>

<?php 
## datacom check level for non critical rate ##
if(!empty($qm_level_rate_record)){
	$level_1_minimum_rate = $qm_level_rate_record[0]->minimum_rate;
	$level_1_maximum_rate = $qm_level_rate_record[0]->maximum_rate;
	$level_2_minimum_rate = $qm_level_rate_record[1]->minimum_rate;
	$level_2_maximum_rate = $qm_level_rate_record[1]->maximum_rate;
	$level_3_minimum_rate = $qm_level_rate_record[2]->minimum_rate;
	$level_3_maximum_rate = $qm_level_rate_record[2]->maximum_rate;

	if($level_1_minimum_rate <=  $final_score_record[0]->question_nc_total && $level_1_maximum_rate >=  $final_score_record[0]->question_nc_total ){
		$level = 1;
	}else if($level_2_minimum_rate <=  $final_score_record[0]->question_nc_total && $level_2_maximum_rate >=  $final_score_record[0]->question_nc_total ){
		$level = 2;
	}else if($level_3_minimum_rate <=  $final_score_record[0]->question_nc_total && $level_3_maximum_rate >=  $final_score_record[0]->question_nc_total ){
		$level = 3;
	}
}
?>

<?php if($recording_record[0]->weightage == 3){ ?>
<div class="span5">
<?php }else{ ?>
<div class="span6">
<?php } ?>
<fieldset>
<legend>Final Score:</legend>

<?php

if($recording_record[0]->weightage == 2){
$x = 0;
foreach($final_score_record as $final_score_row ){
$x += $final_score_row->final_score;
}
echo "<strong>".$x."%</strong>";

}else if($recording_record[0]->weightage == 1){
echo "<strong>Major: ".$final_score_record[0]->question_major_total."%</strong><br />";
echo "<strong>Minor: ".$final_score_record[0]->question_minor_total."%</strong><br />";
echo "<strong>Overall QA Score: ".$final_score_record[0]->final_score."%</strong>";
}else if($recording_record[0]->weightage == 3){
echo "<strong>Critical Business: ".$final_score_record[0]->question_cb_total."%</strong><br />";
echo "<strong>Critical Customer: ".$final_score_record[0]->question_cc_total."%</strong><br />";
echo "<strong>Non Critical: ".$final_score_record[0]->question_nc_total."% - Level: ".$level."</strong><br />";

}
?>
<?php if($recording_record[0]->weightage == 3){ ?>
<span class="label label-success">Level 1</span> Meeting or exceeding expectations.<br />

<span class="label label-warning">Level 2</span> Meeting most standards.<br />

<span class="label label-important">Level 3</span> Not meeting standards.<br />
<?php } ?>
</fieldset>
</div>

<?php if($recording_record[0]->weightage == 3){ ?>
<div class="span1">
<?php if($final_score_record[0]->question_cb_total == 100 && $final_score_record[0]->question_cc_total == 100 && $level != 3 ){ ?>
<fieldset>
<img src="<?php echo base_url()."assets/img/pass.png"; ?>" alt="pass" style="margin-top:60px;">
</fieldset>
<?php }else{ ?>
<fieldset>
<img src="<?php echo base_url()."assets/img/fail.png"; ?>" alt="failed" style="margin-top:60px;">
</fieldset>
<?php } ?>
</div>
<?php } ?>

</div>

</div>

<div class='row'>
<div class='span5' >
<fieldset><legend style="margin-bottom:30px;"><?php if($recording_type == 1){ ?>Voice Recording:<?php }else if($recording_type == 2){ ?>Chat Recording:<?php }else{ ?>Others Recording:<?php } ?></legend>
<br />
<p style="margin-left:40px;"><?php echo $record_filename;?></p>
<p>

<?php if($recording_type == 1){ ?>

<audio id="video1" controls="controls" class="span4">
    <source src="<?php echo base_url()."file/".$record_filename;?>" type="audio/ogg">
	<source src="<?php echo base_url()."file/".$record_filename;?>" type="audio/mpeg">
	<source src="<?php echo base_url()."file/".$record_filename;?>" type="audio/wav">
	Your browser does not support the audio element. Please try other browser
</audio>

<script>
myVid=document.getElementById("video1");
function getCurTime()
{
var currentTime   = myVid.currentTime;
var total = currentTime.toFixed(0)
var minutes = Math.floor(total / 60);
var seconds = total % 60;

var check = seconds.toString().length;

if(check == 1){
var zero = 0;
var second = "" + zero + seconds;

$('#second').val(second);
}else{
$('#second').val(seconds);
}

	$('#minutes').val(minutes);
}
function getCurTime2()
{
var currentTime   = myVid.currentTime;
var total = currentTime.toFixed(0)
var minutes = Math.floor(total / 60);
var seconds = total % 60;

var check = seconds.toString().length;

if(check == 1){
var zero = 0;
var second = "" + zero + seconds;

$('#second2').val(second);
}else{
$('#second2').val(seconds);
}
	$('#minutes2').val(minutes);
}

</script>

<br><br>

<ul id="myTab" class="nav nav-tabs">
<li class="active"><a href="#show_tag" data-toggle="tab">Show Tag</a></li>
<li><a href="#add_tag" data-toggle="tab">Add Tag</a></li>
</ul>

<div id="myTabContent" class="tab-content">
	<div class="tab-pane fade in active" id="show_tag">
		<table class='table table-bordered table-hover  table-striped' >
		<tr><th>No</th><th>Start Tag</th><th>End Tag</th><th>Remark</th><th>Action</th></tr>
		<?php
		$a = 0;

		if(isset($voicetag_record)){
		foreach($voicetag_record as $voicetag_row){ $a++;
		?>
		<tr><td><?php echo $a; ?></td><td><?php echo $voicetag_row->start_tag; ?></td><td><?php echo $voicetag_row->end_tag; ?></td><td><?php echo $voicetag_row->remark; ?></td><td><a href="#" class="delete_voice_tag" data-id="<?php echo $voicetag_row->voice_tag_id; ?>"  title="Delete" ><i class="icon-trash"></i></a></td></tr>

		<?php

		}
		}else{
		echo "No Result Found";
		}

		?>
		</table>
	</div>

	<div class="tab-pane fade" id="add_tag">
		<div style="margin-left:100px;">
		<label>Start Tag: </label>
		<input type="text" id="minutes" readonly="readonly" style="width:15px;"> :
		<input type="text" id="second" readonly="readonly" class="span1">
		<button onclick="getCurTime()" type="button" class="btn" style="margin-top:-10px;">Get Start Tag</button><br>
		<label>End Tag: </label>
		<input type="text" id="minutes2" readonly="readonly" style="width:15px;"> :
		<input type="text" id="second2" readonly="readonly" class="span1">
		<button onclick="getCurTime2()" type="button" class="btn" style="margin-top:-10px;">Get End Tag</button><br>
		</p>
		<p><label>Tag Remark: </label><textarea rows="6" id="tag_remark"></textarea></p>
		<input type='hidden' name='tag_record_id' id='tag_record_id'  value="<?php echo $record_id; ?>">
		<button class="btn btn-primary submit_tag">Submit Tag</button>
		</div>
	</div>

</div>

<?php } else if($recording_type == 2){ ?>

<div class="well"><?php foreach($chatmessage_record as $chatmessage_row){ $chat = "- ".$chatmessage_row->tmessage."<br /><br />"; echo $chat;} ?></div>

<?php }else{ 
echo js('bootstrap-fileupload.min.js');
?>

<?php echo form_open_multipart('qm/submit_other_recording3'); ?>
<textarea style="margin-top:20px;" class="other_remark span5"  rows="10" name="other_remark" id="other_remark" style="z-index:1;"><?php echo $others_recording; ?></textarea>
<input type='hidden' name='others_record_id' id='others_record_id'  value="<?php echo $record_id; ?>">
<input type='hidden' name='userid' id='userid'  value="<?php echo $userid; ?>">
<div class="fileupload fileupload-new" data-provides="fileupload">
  <div class="input-append">
    <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input type="file" name="upload" readonly="readonly" /></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
  </div>
</div>
<br />
<?php $az = 0;  if(!empty($otherrecordingsfile_record)){  ?>
<table class="table table-striped table-hover table-bordered">
	<thead>
    <tr>
      <th>No</th>
      <th>File</th>
	  <th>Action</th>
    </tr>
	</thead>
	<?php foreach($otherrecordingsfile_record as $files_row){ $az++;?>
	<tbody>
    <tr>
      <td><?php echo $az;?></td>
      <td><?php echo $files_row->filename;?></td>
	   <td><a href="<?php echo base_url()."assets/record_file/".$files_row->filename;?>" target="_blank" title="Download"><i class="icon-download-alt"></i></a> <a href="" data-id="<?php echo $files_row->other_recordings_file_id; ?>" data-file="<?php echo $files_row->filename; ?>" title="Delete" class="delete_other_file"><i class="icon-trash" ></i> </a></td>
    </tr>
	</tbody>
	<?php } ?>
</table>
<?php } ?>
<button type="submit" class="btn btn-primary ">Submit</button>
</form>

<?php } ?>

</div>

<div class='span7' >
<fieldset>
<?php echo form_open('qm/edit_score_qm_form'); ?>
<legend style="margin-bottom:15px;">Form:</legend>
<div class="form-inline" style="margin-bottom:15px;">
<label>Scoring Method: </label>
<select name="monitoring_type">
  <option value="1" <?php if($monitoring_type == 1){?>selected<?php } ?>>Independent</option>
  <option value="2" <?php if($monitoring_type == 2){?>selected<?php } ?>>Buddy</option>
</select>
<label class="checkbox" style="margin-left:50px;">
    <input type="checkbox" name="recover" value="1" <?php if($recover == 1){?>checked<?php } ?>> Recover This From
</label>
</div>
<table class='table table-bordered table-hover'>
<?php $i = 0;
$criteria = array();
$z = 0;
$t = 0;
$question_score = array();
$final_score = array();
$num = 0; $no = 0; $rm = 0;

if(isset($recording_record)) :foreach($recording_record as $row ): $num++; $no++;$rm++;

$total_question_score = number_format($row->question_score_total);
$criteria[$i] = $row->criteria_title;

$criteria_rate = number_format($row->criteria_rate);

if($row->question_format == 1){
	$question_format = "( <b>Major</b> )";
}else if($row->question_format == 2){
	$question_format = "( <b>Minor</b> )";
}else if($row->question_format == 3){
	$question_format = "( <b>Fatal</b> )";
}else if($row->question_format == 4){
	$question_format = "( <b>Critical Business</b> )";
}else if($row->question_format == 5){
	$question_format = "( <b>Critical Customer</b> )";
}else if($row->question_format == 6){
	$question_format = "( <b>Non Critical</b> )";
}else{
	$question_format = "";
}

if($i > 0){
	if ($criteria[$i] != $criteria[$i-1]){
 ?>
<tr class='info'>
	<td colspan='3'>
  <?php
		if($row->weightage == 1 || $row->weightage == 3){
			echo "<strong>".$criteria[$i]."</strong>";
		}else{
			echo "<strong>".$criteria[$i]."</strong> <span style='font-weight:bold;'>(".$criteria_rate."%)</span>";
		}

		## score rate
		if($z > 0){
			if ($final_score[$z] != $final_score[$z-1]){
			if($row->weightage == 2){
		 ?>
		<tr class='warning'>
			<td colspan='3'>
			<?php

			echo "<strong>Rate: </strong><span class='badge badge-warning'>".$row->final_score."%</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

			echo "<strong>Point: </strong><span class='badge badge-inverse'>".$total_question_score."</span>";

			} }
		} else {
			if($row->weightage == 2){
		?>
		<tr class='warning'>
			<td colspan='3'>
			<?php

			echo "<strong>Rate: </strong><span class='badge badge-warning'>".$row->final_score."%</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

			echo "<strong>Point: </strong><span class='badge badge-inverse'>".$total_question_score."</span>";

			?>
			</td>
		</tr>
		<?php } }
			}
		} else {

		?>
<tr class='info'>
	<td colspan='3'>
<?php
			if($row->weightage == 1 || $row->weightage == 3){
				echo "<strong>".$criteria[$i]."</strong>";
			}else{
				echo "<strong>".$criteria[$i]."</strong> <span style='font-weight:bold;'>(".$criteria_rate."%)</span>";
			}

			## score rate
			if($z > 0){
				if ($final_score[$z] != $final_score[$z-1]){

				if($row->weightage == 2){?>
			<tr class='warning	'>
				<td colspan='3'>
				<?php

				echo "<strong>Rate: <strong><span class='badge badge-warning'>".$row->final_score."%</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

				echo "<strong>Point: </strong><span class='badge badge-inverse'>".$total_question_score."</span>";

				}
				}
			} else {
				if($row->weightage == 2){
			?>
			<tr class='warning'>
				<td colspan='3'>
				<?php

				echo "<strong>Rate: </strong><span class='badge badge-warning'>".$row->final_score."%</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

				echo "<strong>Point: </strong><span class='badge badge-inverse'>".$total_question_score."</span>";

				?>
				</td>
			</tr>
			<?php } }
	?>
	</td>
</tr>
<?php } ?>

<tr>
	<td colspan='3'>
	<?php echo "Q".$num.": ".$row->question_title." ".$question_format; $i++;?>
	</td>
</tr>
<tr>

	<?php if($row->question_type == "y"){ ?>
	<td class="span4">
	<label class='radio'><input type='radio' name='type_n_<?php echo $no; ?>'  id="type_y1" value="<?php echo $row->question_score_y_yes; ?>" <?php if($row->question_score_y_yes == $row->question_score){ ?>checked <?php }?> >Yes - <?php echo $row->question_score_y_yes; ?></label><label class="radio"><input type="radio" name='type_n_<?php echo $no; ?>'  id='type_y2' value="<?php echo $row->question_score_y_no; ?>" <?php if($row->question_score_y_no == $row->question_score){ ?>checked <?php }?>>No - <?php echo $row->question_score_y_no; ?></label>
		<?php ## if got N / A
	if($row->question_na == 1){?>
		<label class="radio"><input type="radio" name='type_n_<?php echo $no; ?>'  id='type_y2' value="9911" <?php if($row->question_score == "9911"){ ?>checked <?php }?>>N / A</label>
	<?php } ?>

	</td>
<?php }else if($row->question_type == "n"){ ?>
	<td class="span4">
	<?php if(!empty($row->question_score_n_a_value)){ ?>
		<label class='radio'><input type='radio' name='type_n_<?php echo $no; ?>' id='type_n1' value="<?php echo $row->question_score_n_a; ?>" <?php if($row->question_score_n_a == $row->question_score){ ?>checked <?php }?>><?php echo $row->question_score_n_a_value." - ".$row->question_score_n_a; ?></label>
	<?php } ?>
	<?php if(!empty($row->question_score_n_b_value)){ ?>
		<label class='radio'><input type='radio' name='type_n_<?php echo $no; ?>' id='type_n1' value="<?php echo $row->question_score_n_b; ?>" <?php if($row->question_score_n_b == $row->question_score){ ?>checked <?php }?> ><?php echo $row->question_score_n_b_value." - ".$row->question_score_n_b; ?></label>
	<?php } ?>
	<?php if(!empty($row->question_score_n_c_value)){ ?>
		<label class='radio'><input type='radio' name='type_n_<?php echo $no; ?>' id='type_n1' value="<?php echo $row->question_score_n_c; ?>" <?php if($row->question_score_n_c == $row->question_score){ ?>checked <?php }?> ><?php echo $row->question_score_n_c_value." - ".$row->question_score_n_c; ?></label>
	<?php } ?>
	<?php if(!empty($row->question_score_n_d_value)){ ?>
		<label class='radio'><input type='radio' name='type_n_<?php echo $no; ?>' id='type_n1' value="<?php echo $row->question_score_n_d; ?>" <?php if($row->question_score_n_d == $row->question_score){ ?>checked <?php }?> ><?php echo $row->question_score_n_d_value." - ".$row->question_score_n_d; ?></label>
	<?php } ?>
	<?php if(!empty($row->question_score_n_e_value)){ ?>
		<label class='radio'><input type='radio' name='type_n_<?php echo $no; ?>' id='type_n1' value="<?php echo $row->question_score_n_e; ?>" <?php if($row->question_score_n_e == $row->question_score){ ?>checked <?php }?> ><?php echo $row->question_score_n_e_value." - ".$row->question_score_n_e; ?></label>
	<?php } ?>

		<?php ## if got N / A
	if($row->question_na == 1){?>
			<label class='radio'><input  value="9911"  type='radio' name='type_n_<?php echo $no; ?>' id='type_n1' <?php if($row->question_score == "9911"){ ?>checked <?php } ?>>N / A</label>
	<?php } ?>
	</td>
<?php }else{ ?>
	<td class="span4">
	<label class='radio'><input type='radio' name='fatal_<?php echo $no; ?>'  id="fatal_1" value="1" <?php if($row->question_fatal == "1"){ ?>checked <?php } ?>>Yes</label><label class="radio"><input type="radio" name='fatal_<?php echo $no; ?>'  id='fatal_2' value="0" <?php if($row->question_fatal == "0"){ ?>checked <?php } ?>>No</label>
	</td>
<?php } ?>
	</td>

<td>
<label class='control-label' >Question Remark: </label><div class='controls'><textarea rows='3'  class="span4"  name='question_remark_<?php echo $rm; ?>'><?php echo $row->question_remark; ?></textarea>

<input type='hidden' name='question_id[]' id='question_id'  value="<?php echo $row->question_id; ?>">
<input type='hidden' name='criteria_id[]' id='criteria_id'  value="<?php echo $row->criteria_id; ?>">
<input type='hidden' name='record_id' id='record_id'  value="<?php echo $record_id; ?>">

</div>
</td>
</tr>

<?php endforeach; ?>
<?php else : ?>
	No Result Found
<?php endif; ?>
</table>
Overall Remark: </label><textarea rows='3' class="span7" name="question_overall_remark"><?php echo $row->question_overall_remark; ?></textarea>


<input type='hidden' name='qm_id' id='qm_id'  value="<?php echo $row->qm_id; ?>">
<br />
<input type="submit" class="btn-primary btn" value="Edit Score">
<a class="btn btn-danger record_id" id="record_id"  data-id="<?php echo $record_id; ?>">Set As Complete</a>
</form>
</div>
</div>