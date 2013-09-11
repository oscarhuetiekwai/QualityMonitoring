
$(document).ready(function() {



	$('#mymodel').modal({backdrop: 'static',keyboard: false});


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

	//delete APPS part
	$(".checkdate").click(function() {

        var date =  $(this).attr('data-date');

		//alert(date);
		preview_current_date(date);
	});

	function preview_current_date(date)
	{
		$.ajax({
			type: "POST",
			url: config.base_url + 'index.php/recording/preview_recording',
			data : {
				date : date,
			},
			success : function(data) {
				//$('#myModal').modal('show').empty().append(data);
				$('#show_recording').empty().append(data);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
			}
		});

	}

	$(".show_data_range").hide();
	 $(".show_all").hide();
	$("#search_type").change(function() {
		var search_type =	$("#search_type").val();
		//alert(search_type);
      if (search_type == 3 || search_type == "") {
          $(".show_data_range").show();
		   $(".show_all").show();
      } else {
          $(".show_data_range").hide();
		   $(".show_all").show();
      }
	});


	//delete APPS part
	$(".search").click(function() {
		var search_type =	$("#search_type").val();
		var agent_name =	$("#agent_name").val();
		var start_date =	$("#start_date").val();
		var end_date =	$("#end_date").val();
		var status =	$("#status").val();
		var recover =	$("#recover").val();

		var check_old_date =	$("#check_old_date").val();
		if(start_date > end_date){
			alert("Your Date range not correct, please try again");
			return false;
		}else{
			search_recording(search_type,agent_name,start_date,end_date,status,check_old_date,recover);
		}
	});

	function search_recording(search_type,agent_name,start_date,end_date,status,check_old_date,recover)
	{
		$.ajax({
			type: "POST",
			url: config.base_url + 'index.php/recording/search_recording',
			data : {
				search_type : search_type,
				agent_name : agent_name,
				start_date : start_date,
				end_date : end_date,
				status : status,
				recover : recover,
				check_old_date : check_old_date,
			},
			success : function(data) {
				//$('#myModal').modal('show').empty().append(data);
				//alert(data);
				$('#show_recording').empty().append(data);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
			}
		});

	}


	//delete APPS part
	$(".delete_row").click(function() {

        var qm_id =  $(this).attr('data-id');

		var answ = confirm('Delete this qm row?');
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
			url: config.base_url + 'index.php/qm/ajax_delete_row',
			dataType: 'json',
			data : {
				qm_id : qm_id,
			},
			success : function(data) {
				if(data=='success')
				{
					alert('The qm has been deleted');
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

	// for current week only
	$(".current_week_complete").click(function() {

        var start_date =  $(this).attr('start-date4');
		var end_date =  $(this).attr('end-date4');

		//alert(date);
		current_week_complete(start_date,end_date);
	});

	function current_week_complete(start_date,end_date)
	{
		$.ajax({
			type: "POST",
			url: config.base_url + 'index.php/recording/current_week_complete',
			data : {
				start_date : start_date,
				end_date : end_date,
			},
			success : function(data) {
				//$('#myModal').modal('show').empty().append(data);
				$('#show_recording').empty().append(data);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
			}
		});

	}

	$(".current_week_pending").click(function() {

        var start_date =  $(this).attr('start-date3');
		var end_date =  $(this).attr('end-date3');

		//alert(date);
		current_week_pending(start_date,end_date);
	});

	function current_week_pending(start_date,end_date)
	{
		$.ajax({
			type: "POST",
			url: config.base_url + 'index.php/recording/current_week_pending',
			data : {
				start_date : start_date,
				end_date : end_date,
			},
			success : function(data) {
				//$('#myModal').modal('show').empty().append(data);
				$('#show_recording').empty().append(data);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
			}
		});

	}

	$(".current_week_new").click(function() {

		var end_date =  $(this).attr('end-date1');

        var start_date =  $(this).attr('start-date1');
		
		//alert(date);
		current_week_new(start_date,end_date);
	});

	function current_week_new(start_date,end_date)
	{
		$.ajax({
			type: "POST",
			url: config.base_url + 'index.php/recording/current_week_new',
			data : {
				start_date : start_date,
				end_date : end_date,
			},
			success : function(data) {
				//$('#myModal').modal('show').empty().append(data);
				$('#show_recording').empty().append(data); 
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
			}
		});

	}

	$(".current_week_expired").click(function() {

        var start_date =  $(this).attr('start-date2');
		var end_date =  $(this).attr('end-date2');

		//alert(date);
		current_week_expired(start_date,end_date);
	});

	function current_week_expired(start_date,end_date)
	{
		$.ajax({
			type: "POST",
			url: config.base_url + 'index.php/recording/current_week_expired',
			data : {
				start_date : start_date,
				end_date : end_date,
			},
			success : function(data) {
				//$('#myModal').modal('show').empty().append(data);
				$('#show_recording').empty().append(data);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
			}
		});

	}



	// for older week only
	$(".older_week_complete").click(function() {

        var start_date =  $(this).attr('start-date');
		 //var end_date =  $(this).attr('end-date');

		//alert(date);
		older_week_complete(start_date);
	});

	function older_week_complete(start_date)
	{
		$.ajax({
			type: "POST",
			url: config.base_url + 'index.php/recording/older_week_complete',
			data : {
				start_date : start_date,
			},
			success : function(data) {
				//$('#myModal').modal('show').empty().append(data);
				$('#show_recording').empty().append(data);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
			}
		});

	}

	$(".older_week_pending").click(function() {

        var start_date =  $(this).attr('start-date');

		//alert(date);
		older_week_pending(start_date);
	});

	function older_week_pending(start_date)
	{
		$.ajax({
			type: "POST",
			url: config.base_url + 'index.php/recording/older_week_pending',
			data : {
				start_date : start_date,
			},
			success : function(data) {
				//$('#myModal').modal('show').empty().append(data);
				$('#show_recording').empty().append(data);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
			}
		});

	}

	$(".older_week_new").click(function() {

        var start_date =  $(this).attr('start-date');

		//alert(date);
		older_week_new(start_date);
	});

	function older_week_new(start_date)
	{
		$.ajax({
			type: "POST",
			url: config.base_url + 'index.php/recording/older_week_new',
			data : {
				start_date : start_date,
			},
			success : function(data) {
				//$('#myModal').modal('show').empty().append(data);
				$('#show_recording').empty().append(data);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
			}
		});

	}

	$(".older_week_expired").click(function() {

        var start_date =  $(this).attr('start-date');


		//alert(date);
		older_week_expired(start_date);
	});

	function older_week_expired(start_date)
	{
		$.ajax({
			type: "POST",
			url: config.base_url + 'index.php/recording/older_week_expired',
			data : {
				start_date : start_date,

			},
			success : function(data) {
				//$('#myModal').modal('show').empty().append(data);
				$('#show_recording').empty().append(data);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
			}
		});
	}

});