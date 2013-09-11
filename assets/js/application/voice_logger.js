$(document).on('shown', function(event) {

	$("#abc").hide(100);
	$("#yes_no").hide(100);
	$(":radio:eq(0)").click(function(){
		$("#abc").hide(100);
		$("#yes_no").show(100);
	});

	$(":radio:eq(1)").click(function(){
		$("#yes_no").hide(100);
		$("#abc").show(100);
	});

	$('#chosen_a').change(function(){
		var criteria_id =  $(':selected',this).data('id');
		$('.criteria_rate2').val(criteria_id);
	});
});

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
	$(".assign_form").click(function() {

        var id =  $(this).attr('data-id');
		$("#id").val(id);
		$('#assign_form').modal('show');
	});
	//delete APPS part
	$(".delete_row").click(function() {

        var criteria_id =  $(this).attr('data-id');
		var qm_id =  $(this).attr('qm-id');

		var answ = confirm('Delete this category row?');
		if(answ)
		{
			deletenotificationAjax(criteria_id,qm_id);
		}
		else
		{
			return false;
		}
	});

	function deletenotificationAjax(criteria_id,qm_id)
	{
		$.ajax({
			type: "POST",
			async : false,
			url: config.base_url + 'index.php/criteria/ajax_delete_row',
			dataType: 'json',
			data : {
				criteria_id : criteria_id,
				qm_id : qm_id,
			},
			success : function(data) {
				if(data=='success')
				{
					alert('The category has been deleted');
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