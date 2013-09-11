
$(document).ready(function() {


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
	$(".delete_row").click(function() {

        var question_id =  $(this).attr('data-id');
		var qm_id =  $(this).attr('qm-id');
		var criteria_id =  $(this).attr('criteria-id');

		var answ = confirm('Delete this question row?');
		if(answ)
		{
			deletenotificationAjax(question_id,qm_id,criteria_id);
		}
		else
		{
			return false;
		}
	});

	function deletenotificationAjax(question_id,qm_id,criteria_id)
	{
		$.ajax({
			type: "POST",
			async : false,
			url: config.base_url + 'index.php/question/ajax_delete_row',
			dataType: 'json',
			data : {
				question_id : question_id,
				qm_id : qm_id,
				criteria_id : criteria_id,
			},
			success : function(data) {
				if(data=='success')
				{
					alert('The question has been deleted');
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



});