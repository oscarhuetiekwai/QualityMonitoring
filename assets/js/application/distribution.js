  function isNumber(evt) {
            var iKeyCode = (evt.which) ? evt.which : evt.keyCode
            if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
                return false;

            return true;
        }
$(document).ready(function() {

	$("#profile_name").keyup(function() {
		var profile_name = $('#profile_name').val();
		$('#profile_name1').val(profile_name);
		$('#profile_name2').val(profile_name);
		$('#profile_name3').val(profile_name);
		$('#profile_name4').val(profile_name);
	});

	$("#profile_description").keyup(function() {
		var profile_description = $('#profile_description').val();
		$('#profile_description1').val(profile_description);
		$('#profile_description2').val(profile_description);
		$('#profile_description3').val(profile_description);
		$('#profile_description4').val(profile_description);
	});


$(".chzn_b").chosen();

	$('#tp_1').timepicker({
		template: 'modal',
		showSeconds: false,
		showMeridian: false,
		disableFocus: true
	});
	$('#tp_2').timepicker({
		defaultTime: 'current',
		minuteStep: 1,
		disableFocus: true,
		template: 'dropdown'
	});

	$('#tp_3').timepicker({
		template: 'modal',
		showSeconds: false,
		showMeridian: false,
		disableFocus: true
	});

	$('#tp_modal').timepicker({
		defaultTime: 'current',
		minuteStep: 1,
		disableFocus: true,
		template: 'dropdown'
	});

	//check box hide and show
	$("#button_show_hide").hide(100);
    $('.check_me').click(function() {
        if ( $('.check_me:checked').length >= 1) {
            $("#button_show_hide").show(500);
        } else {
            $("#button_show_hide").hide(500);
        }
    });


	$('.select_group').toggle(function(){
        $('input:checkbox').attr('checked','checked');
        $(this).val('Uncheck All')
    },function(){
        $('input:checkbox').removeAttr('checked');
        $(this).val('Check All');
    })

	$('.select_group2').toggle(function(){
        $('input:checkbox').attr('checked','checked');
        $(this).val('Uncheck All')
    },function(){
        $('input:checkbox').removeAttr('checked');
        $(this).val('Check All');
    })

	$('.select_group3').toggle(function(){
        $('input:checkbox').attr('checked','checked');
        $(this).val('Uncheck All')
    },function(){
        $('input:checkbox').removeAttr('checked');
        $(this).val('Check All');
    })

	$('.submit_queue').click(function(){
        var val = [];
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
			var queue =  val[i];
			alert(queue);
		 submit_queue(queue);
        });
      });

	  function submit_queue(queue)
	{
		$.ajax({
			type: "POST",
			async : false,
			url: config.base_url + 'index.php/distribution/submit_queue',
			dataType: 'json',
			data : {
				queue : queue,
			},
			success : function(data) {

				if(data=='success')
				{
					//location.reload();
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


	$(".submit_id").click(function() {
		submit_id();
	});

	function submit_id()
	{
		$.ajax({
			type: "POST",
			async : false,
			url: config.base_url + 'index.php/distribution/submit_id',
			dataType: 'json',
			data : {
			},
			success : function(data) {

				window.location = config.base_url + 'index.php/distribution/add_distribution/' + data;

			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
			}
		});

	}

	$(".submit_hr").click(function() {
		//alert("Please fill up all start tag and end tag");
		var starttime = $(".starttime").val();
		var endtime = $(".endtime").val();
		var frequency = $("#frequency").val();

		alert(starttime);
		if(starttime == '' || endtime == '' || frequency == ''){
			alert("Please fill in all the field");
			return false;
		}

		submit_hr(starttime,endtime,frequency);

	});

	function submit_hr(starttime,endtime,frequency)
	{
		$.ajax({
			type: "POST",
			async : false,
			url: config.base_url + 'index.php/distribution/submit_hr_freq',
			dataType: 'json',
			data : {
				starttime : starttime,
				endtime : endtime,
				frequency : frequency,
			},
			success : function(data) {

				if(data=='success')
				{
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
			url: config.base_url + 'index.php/qm/ajax_delete_voice_tag',
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

		var answ = confirm('Set this form as complete?');
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
			url: config.base_url + 'index.php/qm/change_status_to_complete',
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
	$(".delete_row").click(function() {

        var dist_id =  $(this).attr('data-id');

		var answ = confirm('Delete this profile row?');
		if(answ)
		{
			deleteprofile(dist_id);
		}
		else
		{
			return false;
		}
	});

	function deleteprofile(dist_id)
	{
		$.ajax({
			type: "POST",
			async : false,
			url: config.base_url + 'index.php/distribution/ajax_delete_row',
			dataType: 'json',
			data : {
				dist_id : dist_id,
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
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
			}
		});
	}


	//delete APPS part
	$(".delete_hr").click(function() {

        var hfid =  $(this).attr('data-id');

		var answ = confirm('Delete this hour & frequency row?');
		if(answ)
		{
			delete_hr(hfid);
		}
		else
		{
			return false;
		}
	});

	function delete_hr(hfid)
	{
		$.ajax({
			type: "POST",
			async : false,
			url: config.base_url + 'index.php/distribution/ajax_delete_hr_row',
			dataType: 'json',
			data : {
				hfid : hfid,
			},
			success : function(data) {
				if(data=='success')
				{
					//alert('The form has been deleted');
					window.location.reload(true);
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
	$(".delete_queue").click(function() {

        var dqid =  $(this).attr('data-id');

		var answ = confirm('Delete this queue row?');
		if(answ)
		{
			delete_queue(dqid);
		}
		else
		{
			return false;
		}
	});

	function delete_queue(dqid)
	{
		$.ajax({
			type: "POST",
			async : false,
			url: config.base_url + 'index.php/distribution/ajax_delete_queue_row',
			dataType: 'json',
			data : {
				dqid : dqid,
			},
			success : function(data) {
				if(data=='success')
				{
					//alert('The form has been deleted');
					window.location.reload(true);
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
	$(".delete_agent").click(function() {

        var dist_id =  $(this).attr('dist-id');
		var agent_id =  $(this).attr('agent-id');

		var answ = confirm('Delete this agent row?');
		if(answ)
		{
			delete_agent(dist_id,agent_id);
		}
		else
		{
			return false;
		}
	});

	function delete_agent(dist_id,agent_id)
	{
		$.ajax({
			type: "POST",
			async : false,
			url: config.base_url + 'index.php/distribution/ajax_delete_agent_row',
			dataType: 'json',
			data : {
				dist_id : dist_id,
				agent_id : agent_id,
			},
			success : function(data) {
				if(data=='success')
				{
					//alert('The form has been deleted');
					window.location.reload(true);
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
	$(".delete_wrapup").click(function() {

        var dwid =  $(this).attr('data-id');

		var answ = confirm('Delete this wrapup row?');
		if(answ)
		{
			delete_wrapup(dwid);
		}
		else
		{
			return false;
		}
	});

	function delete_wrapup(dwid)
	{
		$.ajax({
			type: "POST",
			async : false,
			url: config.base_url + 'index.php/distribution/ajax_delete_wrapup_row',
			dataType: 'json',
			data : {
				dwid : dwid,
			},
			success : function(data) {
				if(data=='success')
				{
					//alert('The form has been deleted');
					window.location.reload(true);
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


	$(".assign_agent").click(function() {
		//alert("Please fill up all start tag and end tag");
	    var distid =  $(this).attr('data-id');

	

		assign_agent(distid);

	});

	function assign_agent(distid)
	{
		$.ajax({
			type: "POST",

			url: config.base_url + 'index.php/distribution/assign_agent',

			data : {
				distid : distid,
			},
			success : function(data) {

				$('#show_recording').empty().append(data);

			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
			}
		});

	}

	
	$(".preview_profile").click(function() {

        var distid =  $(this).attr('data-id');
		//alert(qm_id);

		preview_profile(distid);

	});

	function preview_profile(distid)
	{
		$.ajax({
			type: "POST",

			url: config.base_url + 'index.php/distribution/preview_profile',

			data : {
				distid : distid,
			},
			success : function(data) {
				$('#preview_profile').modal('show').empty().append(data);
				//alert(data);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
			}
		});
	}
	
	
	// enable and disable
	$(".activity").click(function() {

        var distid =  $(this).attr('data-id');
		var activity =  $(this).attr('data-active');

		active(distid,activity);
	});

	function active(distid,activity)
	{
		$.ajax({
			type: "POST",
			async : false,
			url: config.base_url + 'index.php/distribution/active_row',
			dataType: 'json',
			data : {
				distid : distid,
				activity : activity,
			},
			success : function(data) {
				if(data=='success')
				{
					//alert('The form has been deleted');
					window.location.reload(true);
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
});