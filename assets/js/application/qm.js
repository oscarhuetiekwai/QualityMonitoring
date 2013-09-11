$(document).ready(function() {

	$("#abc").hide(100);
	$("#abc2").hide(100);

	$(":radio:eq(0)").click(function(){
	$("#abc").hide(100);
	$("#abc2").hide(100);
	});

	$(":radio:eq(1)").click(function(){
	$("#abc").show(100);
	$("#abc2").hide(100);
	});

	$(":radio:eq(2)").click(function(){
	$("#abc").hide(100);
	$("#abc2").show(100);
	});

	if ($(':radio:eq(1)').attr('checked')) {
		$("#abc").show(100);
		$("#abc2").hide(100);
    } else {
		$("#abc").hide(100);
		$("#abc2").hide(100);
    }

	if ($(':radio:eq(2)').attr('checked')) {
		$("#abc").hide(100);
		$("#abc2").show(100);
    } else {
		$("#abc").hide(100);
		$("#abc2").hide(100);
    }

// Pretty file
if ($('.prettyFile').length) {
    $('.prettyFile').each(function() {
        var pF          = $(this),
            fileInput   = pF.find('input[type="file"]');

        fileInput.change(function() {
            // When original file input changes, get its value, show it in the fake input
            var files = fileInput[0].files,
                info  = '';
            if (files.length > 1) {
                // Display number of selected files instead of filenames
                info     = files.length + ' files selected';
            } else {
                // Display filename (without fake path)
                var path = fileInput.val().split('\\');
                info     = path[path.length - 1];
            }

            pF.find('.input-append input').val(info);
        });

        pF.find('.input-append').click(function(e) {
            e.preventDefault();
            // Make as the real input was clicked
            fileInput.click();
        })
    });
}

	//check box hide and show
	$("#button_show_hide").hide(100);
    $('.check_me').click(function() {
        if ( $('.check_me:checked').length >= 1) {
            $("#button_show_hide").show(500);
        } else {
            $("#button_show_hide").hide(500);
        }
    });

	//check box hide and show
    $('.select_group').click(function() {
        if ( $('.select_group:checked').length >= 1) {
            $("#button_show_hide").show(500);
        } else {
            $("#button_show_hide").hide(500);
        }
    });

	//check all check box
	$(".select_group").click(function() {
		var table_id12 = $(this).closest('table').attr('id');
		if($(this).is(':checked'))
		{
			$("#"+table_id12+" :checkbox").attr('checked', $(this).attr('checked'));
		}
		else
		{
			 $("#"+table_id12+" :checkbox").attr('checked', false);
		}

	});


	$(".submit_other_recording").click(function() {
		//alert("Please fill up all start tag and end tag");
		var other_remark =	$(".other_remark").val();
		alert(other_remark);

		var others_record_id =	$("#others_record_id").val();

		if(other_remark == ''){
		alert("Please fill in the textarea fill before submit!");
		return false;
		}
		var answ = confirm('Submit Textarea?');

		if(answ)
		{
			submit_other_recording(other_remark,others_record_id);
		}
		else
		{
			return false;
		}
	});

	function submit_other_recording(other_remark,others_record_id)
	{
		$.ajax({
			type: "POST",
			async : false,
			url: config.base_url + 'index.php/qm/submit_other_recording',
			dataType: 'json',
			data : {
				other_remark : other_remark,
				others_record_id : others_record_id,
			},
			success : function(data) {


				if(data=='success')
				{
					alert('Your remark has successfully submitted');
					location.reload();
				}
				else if(data=='error')
				{
					alert('Error.');
				}

			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
			}
		});

	}

	$(".submit_tag").click(function() {
		//alert("Please fill up all start tag and end tag");
		var minutes =	$("#minutes").val();
		var minutes2 =	$("#minutes2").val();
		var second =	$("#second").val();
		var second2 =	$("#second2").val();
		var tag_remark =	$("#tag_remark").val();
		var tag_record_id =	$("#tag_record_id").val();

		if(minutes == '' || second == '' || minutes2 == '' || second2 == ''){
			alert("Please fill up all start tag and end tag");
			return false;
		}

		var answ = confirm('Submit tag?');
		if(answ)
		{
			submit_tag(minutes,second,minutes2,second2,tag_record_id,tag_remark);
		}
		else
		{
			return false;
		}
	});

	function submit_tag(minutes,second,minutes2,second2,tag_record_id,tag_remark)
	{
		$.ajax({
			type: "POST",
			async : false,
			url: config.base_url + 'index.php/qm/submit_tag',
			dataType: 'json',
			data : {
				minutes : minutes,
				second : second,
				minutes2 : minutes2,
				second2 : second2,
				tag_record_id : tag_record_id,
				tag_remark : tag_remark,
			},
			success : function(data) {


				//window.location.href = data;

				if(data=='success')
				{
					alert('Your Tag has successfully submitted');
					location.reload();
				}
				else if(data=='error')
				{
					alert('Error.');
				}

			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
			}
		});

	}


	//delete APPS part
	$(".delete_voice_tag").click(function() {

        var id =  $(this).attr('data-id');

		var answ = confirm('Delete this tag row?');
		if(answ)
		{
			delete_voice_tag(id);
		}
		else
		{
			return false;
		}
	});

	function delete_voice_tag(id)
	{
		$.ajax({
			type: "POST",
			async : false,
			url: config.base_url + 'qm/ajax_delete_voice_tag',
			dataType: 'json',
			data : {
				id : id,
			},
			success : function(data) {
				if(data=='success')
				{
					alert('Your selected tag has been deleted');
					location.reload();
				}
				else if(data=='error')
				{
					alert('Error.');
				}
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
			}
		});
	}

	//duplicate_row APPS part
	$(".record_id").click(function() {

        var record_id =  $(this).attr('data-id');

		var answ = confirm('Set this form as complete? Once set as complete, you are unable to edit this form anymore');
		if(answ)
		{
			change_status(record_id);
		}
		else
		{
			return false;
		}
	});

	function change_status(record_id)
	{
		$.ajax({
			type: "POST",
			async : false,
			url: config.base_url + 'qm/change_status_to_complete',
			dataType: 'json',
			data : {
				record_id : record_id,
			},
			success : function(data) {

					alert('The form has been set as completed');
					//location.reload();
					window.location.href = data;



			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
			}
		});
	}


	$(".preview").click(function() {
		var qm_title =  $(this).attr('data-id');
		preview_qm(qm_title);
	});

	function preview_qm(qm_title)
	{
		$.ajax({
			type: "POST",
			url: config.base_url + 'index.php/qm/preview_qm',
			data : {
				qm_title : qm_title,
			},
			success : function(data) {
				$('#myModal').modal('show').empty().append(data);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
			}
		});

	}

	$(".show_qm_form").click(function() {
		var qm_title =  $(this).attr('data-id');
		preview_qm_form(qm_title);
		//alert(qm_title);
	});

	function preview_qm_form(qm_title)
	{
		$.ajax({
			type: "POST",
			url: config.base_url + 'index.php/qm/preview_qm_form',
			data : {
				qm_title : qm_title,
			},
			success : function(data) {
				$('#qm_form').empty().append(data);
				//alert(123);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
			}
		});

	}

	$(".preview_question").click(function() {
		var criteria_id =  $(this).attr('criteria_id');
		preview_question(criteria_id);
		//alert(criteria_id);
	});

	function preview_question(criteria_id)
	{
		$.ajax({
			type: "POST",
			url: config.base_url + 'index.php/qm/preview_question',
			data : {
				criteria_id : criteria_id,
			},
			success : function(data) {
					$('#myModal2').modal('show').empty().append(data);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
			}
		});

	}


	$(':radio:checked').click(function(){
		$('.show_score').show();
	});


	//duplicate_row APPS part
	$(".duplicate_row").click(function() {

        var qm_id =  $(this).attr('data-id');

		var answ = confirm('Duplicate this Form row?');
		if(answ)
		{
			duplicate(qm_id);
		}
		else
		{
			return false;
		}
	});

	function duplicate(qm_id)
	{
		$.ajax({
			type: "POST",
			async : false,
			url: config.base_url + 'index.php/qm/ajax_duplicate_row',
			dataType: 'json',
			data : {
				qm_id : qm_id,
			},
			success : function(data) {
				if(data=='success')
				{
					alert('The form has been duplicated');
					location.reload();
				}
				else if(data=='error')
				{
					alert('Error.');
				}
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
			}
		});
	}



	//delete APPS part
	$(".delete_other_file").click(function() {

        var other_recordings_file_id =  $(this).attr('data-id');
		var file =  $(this).attr('data-file');

		var answ = confirm('Delete this file row?');
		if(answ)
		{
			delete_other_file(other_recordings_file_id,file);
		}
		else
		{
			return false;
		}
	});

	function delete_other_file(other_recordings_file_id,file)
	{
		$.ajax({
			type: "POST",
			async : false,
			url: config.base_url + 'qm/ajax_delete_other_file_row',
			dataType: 'json',
			data : {
				other_recordings_file_id : other_recordings_file_id,
				file : file,
			},
			success : function(data) {
				if(data=='success')
				{
					alert('The file has been deleted');
					location.reload();
				}
				else if(data=='error')
				{
					alert('Error.');
				}

			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
			}
		});
	}

	//delete APPS part
	$(".delete_row").click(function() {

        var qm_id =  $(this).attr('data-id');

		var answ = confirm('Delete this Form row?');
		if(answ)
		{
			deletenotificationAjax(qm_id);
		}
		else
		{
			return false;
		}
	});

	function deletenotificationAjax(qm_id)
	{
		$.ajax({
			type: "POST",
			async : false,
			url: config.base_url + 'qm/ajax_delete_row',
			dataType: 'json',
			data : {
				qm_id : qm_id,
			},
			success : function(data) {
				if(data=='success')
				{
					alert('The form has been deleted');
					location.reload();
				}
				else if(data=='error')
				{
					alert('Error.');
				}
				else if(data=='error_delete')
				{
					alert('There are already used this QM form, so you unable to remove this from, you only able to edit the form instead of remove');
				}
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert('The form has been deleted');
				location.reload();
			}
		});
	}



});