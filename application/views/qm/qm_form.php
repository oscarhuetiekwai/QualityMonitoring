<?php $this->load->view('template/show_error');
if($recording_type == 1){
## copy file to my server ##
$file = '/var/spool/asterisk/monitor/'.$record_filename;
$newfile = '/var/www/html/qm/file/'.$record_filename;

copy($file, $newfile);
}
?>
<div class='row'>
<div class='offset5' style='text-decoration:underline;'><h2><?php echo $qm_title; ?></h2></div>
<!--<div class='offset5'>
<p><?php //if($recording_type == 1){ ?><?php //$rest = substr($queuename, 0, 1);  if($rest == "t"){ ?>In Bound: <?php //}else{ ?> Out Bound:  <?php// } ?><?php //echo $queuename; ?><?php// }?></p></div>-->
<div class='well span12_a'><fieldset>
<legend>Agent Detail:</legend>
<strong>Agent Name:</strong> <?php echo $username; ?><br>
<?php if($recording_type == 1){ ?>
<strong>Date:</strong>  <?php $phpdate = $connecttime;
$mysqldate = date( 'Y-m-d H:i:s a', strtotime( $phpdate ) );echo $mysqldate; ?><br>
<strong>Extension Number:</strong> <?php echo $extension; ?><br>
<strong>Phone Number:</strong>  <?php echo $callerid; ?>
<?php } ?>
</div>
</div>

<div class='row'>
<div class='span5' >
<fieldset><legend style="margin-bottom:30px;"><?php if($recording_type == 1){ ?>Voice Recording:<?php }else if($recording_type == 2){ ?>Chat Recording:<?php }else{ ?>Others Recording:<?php } ?></legend>
<br />
<?php if($recording_type == 1){ ?><p style="margin-left:40px;"><?php echo $record_filename;?></p><?php } ?>
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

<?php echo form_open_multipart('qm/submit_other_recording2'); ?>

<textarea style="margin-top:20px;" class=" other_remark span5" rows="10" name="other_remark" id="other_remark" style="z-index:1;"><?php echo $others_recording; ?></textarea>
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
<?php echo form_open('qm/submit_qm_form'); ?>
<legend style="margin-bottom:15px;">Form: </legend>
<div class="form-inline" style="margin-bottom:15px;">
<label>Scoring Method: </label>
<select name="monitoring_type">
  <option value="1">Independent</option>
  <option value="2">Buddy</option>
</select>
</div>
<table class='table table-bordered table-hover'>
<?php
$i = 0;
$criteria = array();

$num = 0; $no = 0; $rm = 0; if(isset($recording_record)) :foreach($recording_record as $row): $num++; $no++;$rm++;
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
	<label class='radio'><input type='radio' name='type_n_<?php echo $no; ?>'  id="type_y1" value="<?php echo $row->question_score_y_yes; ?>">Yes - <?php echo $row->question_score_y_yes; ?></label><label class="radio"><input type="radio" name='type_n_<?php echo $no; ?>'  id='type_y2' value="<?php echo $row->question_score_y_no; ?>" >No - <?php echo $row->question_score_y_no; ?></label>

	<?php ## if got N / A
	if($row->question_na == 1){?>
		<label class="radio"><input type="radio" name='type_n_<?php echo $no; ?>'  id='type_y3' value="9911">N / A</label>
	<?php } ?>

	</td>
<?php }else if($row->question_type == "n"){ ?>
	<td class="span4">
	<?php if(!empty($row->question_score_n_a_value)){ ?>
		<label class='radio'><input type='radio' name='type_n_<?php echo $no; ?>' id='type_n1' value="<?php echo $row->question_score_n_a; ?>" ><?php echo $row->question_score_n_a_value." - ".$row->question_score_n_a; ?></label>
	<?php } ?>
	<?php if(!empty($row->question_score_n_b_value)){ ?>
		<label class='radio'><input type='radio' name='type_n_<?php echo $no; ?>' id='type_n1' value="<?php echo $row->question_score_n_b; ?>" ><?php echo $row->question_score_n_b_value." - ".$row->question_score_n_b; ?></label>
	<?php } ?>
	<?php if(!empty($row->question_score_n_c_value)){ ?>
		<label class='radio'><input type='radio' name='type_n_<?php echo $no; ?>' id='type_n1' value="<?php echo $row->question_score_n_c; ?>" ><?php echo $row->question_score_n_c_value." - ".$row->question_score_n_c; ?></label>
	<?php } ?>
	<?php if(!empty($row->question_score_n_d_value)){ ?>
		<label class='radio'><input type='radio' name='type_n_<?php echo $no; ?>' id='type_n1' value="<?php echo $row->question_score_n_d; ?>" ><?php echo $row->question_score_n_d_value." - ".$row->question_score_n_d; ?></label>
	<?php } ?>
	<?php if(!empty($row->question_score_n_e_value)){ ?>
		<label class='radio'><input type='radio' name='type_n_<?php echo $no; ?>' id='type_n1' value="<?php echo $row->question_score_n_e; ?>" ><?php echo $row->question_score_n_e_value." - ".$row->question_score_n_e; ?></label>
	<?php } ?>

	<?php ## if got N / A
			if($row->question_na == 1){?>
		<label class="radio"><input type="radio" name='type_n_<?php echo $no; ?>'  id='type_n1' value="9911">N / A</label>
	<?php } ?>
	</td>
<?php }else{ ?>
	<td class="span4">
	<label class='radio'><input type='radio' name='fatal_<?php echo $no; ?>'  id="fatal_1" value="1">Yes</label><label class="radio"><input type="radio" name='fatal_<?php echo $no; ?>'  id='fatal_2' value="0" >No</label>
	</td>
<?php } ?>
<td>
<label class='control-label' >Question Remark: </label><div class='controls'><textarea rows='3' class="span4" name='question_remark_<?php echo $rm; ?>'></textarea>
<input type='hidden' name='question_id[]' id='question_id'  value="<?php echo $row->question_id; ?>">
<input type='hidden' name='criteria_id[]' id='criteria_id'  value="<?php echo $row->criteria_id; ?>">
<input type='hidden' name='userid' id='userid'  value="<?php echo $userid; ?>">
<input type='hidden' name='lastname' id='lastname'  value="<?php echo $lastname; ?>">
<input type='hidden' name='firstname' id='firstname'  value="<?php echo $firstname; ?>">
<?php if($recording_type == 1){ ?>
<input type='hidden' name='connecttime' id='connecttime'  value="<?php echo $connecttime; ?>">
<input type='hidden' name='extension' id='extension'  value="<?php echo $extension; ?>">
<input type='hidden' name='callerid' id='callerid'  value="<?php echo $callerid; ?>">
<?php } ?>
<input type='hidden' name='record_id' id='record_id'  value="<?php echo $record_id; ?>">
<input type='hidden' name='qm_title' id='qm_id'  value="<?php echo $qm_title; ?>">
<input type='hidden' name='qm_id' id='qm_id'  value="<?php echo $qm_id; ?>">
</div>
</td>
</tr>
<?php endforeach; ?>
<?php else : ?>
	No Result Found
<?php endif; ?>
</table>
Overall Remark: </label><textarea rows='3' class="span7" name="question_overall_remark"></textarea>
<br />
<input type="submit" class="btn-primary btn button333" value="Submit Score" data-loading-text="Loading...">
</form>
</div>
</div>