<!DOCTYPE html>
<html lang="en">
    <head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Call Center QM</title>
	<?php
		##Bootstrap framework ##
		echo css('bootstrap.css');
	?>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/favicon.png">

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/lib/chosen/chosen.css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/lib/datepicker/datepicker.css" />

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/lib/multi-select/css/multi-select.css" />

	<script type='text/javascript' src='<?php echo base_url(); ?>assets/js/jquery.1.7.min.js'></script>
	<script type='text/javascript' src='<?php echo base_url(); ?>assets/js/jquery.1.8.min.js'></script>
	<style type="text/css">
	  body {
		padding-top: 60px;
		padding-bottom: 40px;
	  }
	  .sidebar-nav {
		padding: 9px 0;
	  }
	</style>
	<?php
		echo css('bootstrap-responsive.css');
	?>
	<script>
		//* hide all elements & show preloader
		document.documentElement.className += 'js';
		var config = {
		   'base_url': '<?php echo base_url(); ?>'
		};
	</script>
    </head>
    <body style="background-image: url(<?php echo base_url(); ?>assets/img/bg_c.png);">
	<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
		  <?php $this->load->view('template/header'); ?>
        </div>
      </div>
    </div>

    <div class="container">
	<?php if($this->session->userdata('role_id')==ADMIN || $this->session->userdata('role_id')==SUPERVISOR)	{ ?>
		<?php if(!empty($report)){ if($report != "report"){?>
        <div class="row">
        <div class="span10 offset1">
			<?php if(isset($main)){ $this->load->view($main); } else { echo 'Main content'; } ?>
        </div><!--/span-->
	    </div>
		<?php }else{ ?>
		  <div class="row">
			<div class="span12">
				<?php if(isset($main)){ $this->load->view($main); } else { echo 'Main content'; } ?>
			</div><!--/span-->
		  </div><!--/row-->
		<?php } }else{ ?>
		 <div class="row">
        <div class="span10 offset1">
			<?php if(isset($main)){ $this->load->view($main); } else { echo 'Main content'; } ?>
        </div><!--/span-->
	    </div>
		<?php } ?>
	<?php }else{ ?>
	  <div class="row">
        <div class="span12">
			<?php if(isset($main)){ $this->load->view($main); } else { echo 'Main content'; } ?>
        </div><!--/span-->
      </div><!--/row-->

	<?php } ?>

	<!-- footer -->
	<?php if($this->session->userdata('role_id')==ADMIN || $this->session->userdata('role_id')==SUPERVISOR)	{ ?>

	<?php if(!empty($report)){ if($report == "report"){?>

	<div class="row">

		<div class="span12">
		<hr>
			<footer class="pull-right">
				<p>&copy; QM 2013</p>
			</footer>
			</div><!--/span-->
      </div><!--/row-->

	<?php }  }else{ ?>
	    <div class="row">
	<div class="span10 offset1">
	<hr>
	<footer class="pull-right">
        <p>&copy; QM 2013</p>
	</footer>
	</div>
	</div>
	<?php } ?>
	<?php }else{ ?>
	  <div class="row">
	  	<?php if($page != "qm_form" ){ ?>
		<div class="span12">
		<hr>
			<footer class="pull-right">
				<p>&copy; QM 2013</p>
			</footer>
			</div><!--/span-->
      </div><!--/row-->
		<?php }else{ ?>

		<?php } ?>
	<?php } ?>
    </div><!--/.fluid-container-->
	</body>
</html>
<div id="preview_qm_form" class="modal2 hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="overflow:auto;">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Modal header</h3>
  </div>
  <div class="modal-body" style="overflow:scroll;">

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary">Save changes</button>
  </div>
</div>

<?php

// main bootstrap js
echo js('bootstrap.min.js');
echo js('bootstrap-datepicker.js');
//echo js('jquery.dataTables.sorting.js');

echo js('lib/datatables/jquery.dataTables.min.js');

echo js('ckeditor/ckeditor.js');

echo js('ckeditor/_samples/sample.js');

echo js('lib/chosen/chosen.jquery.min.js');

echo js('lib/datepicker/bootstrap-timepicker.min.js');

echo js('lib/multi-select/js/jquery.multi-select.js');

echo js('lib/multi-select/js/jquery.quicksearch.js');

echo js('lib/tiny_mce/jquery.tinymce.js');

echo js('easing.js');

echo js('jquery.ui.totop.js');

if(isset($js_list))
{
    foreach($js_list as $js_row)
    {
      $js_file = $js_row.'.js';
      echo js($js_file);
    }
}
?>
<?php
  //load the js function
  if(isset($js_function))
  {
    foreach($js_function as $js)
    {

      $js = $js.'.js';
      ?>
      <script src="<?php echo base_url(); ?>assets/js/application/<?php echo $js; ?>"></script>
      <?php
    }
  }
?>

<script type="text/javascript">
$('#delete_row').tooltip('show');
$(document).ready(function() {

	$(".preview_form").click(function() {
        var qm_id =  $(this).attr('qm-id');
		preview_qm(qm_id);
	});

	function preview_qm(qm_id)
	{
		$.ajax({
			type: "POST",

			url: config.base_url + 'qm/preview_qm',

			data : {
				qm_id : qm_id,
			},
			success : function(data) {
				$('#preview_qm_form').modal('show').empty().append(data);
				//alert(data);
			},
			error : function(XMLHttpRequest, textStatus, errorThrown) {
				alert(XMLHttpRequest + " : " + textStatus + " : " + errorThrown);
			}
		});
	}

	$(".chzn_z").chosen({
		allow_single_deselect: true
	});
	$(".chzn_a").chosen({
		allow_single_deselect: true
	});
	$(".chzn_b").chosen({
		allow_single_deselect: true
	});
	$(".chzn_t").chosen({
		allow_single_deselect: true
	});

	$('#button').button();

	// cancel button
	$("#cancel").click(function()
	{
		var index = $("#module_index").val();
		window.location = index;
	});

	$('#start_date').datepicker({
		format: 'yyyy-mm-dd'
	});
	$('#end_date').datepicker({
		format: 'yyyy-mm-dd'
	});

/*         $("#excel").click(function() {
          var form_action = "<?php echo site_url('dashboard/search_email_excel');?>";
          $("#myForm").attr("action", form_action);
          $("#myForm").submit();
        });

      $("#search").click(function() {
          var form_action = "<?php echo site_url('dashboard/search_dashboard');?>";
          $("#myForm").attr("action", form_action);
          $("#myForm").submit();
        }); */

	$('#dt_d').dataTable({
            "sDom": "<'row' <'ss3\'l><'ss7'f>r>t<'row'<'span4'i><'ss6'p>>",
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sSearch": "Search all columns:"
            }
    });

	$('#dt_e').dataTable({
            "sDom": "<'row'<'span5\'l><'span2'f>r>t<'row'<'span3'i><'span2'p>>",
            "sPaginationType": "bootstrap",
            "oLanguage": {
                "sSearch": "Search all columns:"
            }
    });

	// navigation drop down
	jQuery('ul.nav li.dropdown').hover(function() {
	  jQuery(this).find('.dropdown-menu').stop(true, true).delay(50).fadeIn();
	}, function() {
	  jQuery(this).find('.dropdown-menu').stop(true, true).delay(50).fadeOut();
	});

    $(function () {
        $("[rel='tooltip']").tooltip();
    });

	// scroll to top
	var defaults = {
	  	containerID: 'toTop', // fading element id
		containerHoverID: 'toTopHover', // fading element hover id
		scrollSpeed: 1200,
		easingType: 'linear'
	};
	$().UItoTop({ easingType: 'easeOutQuart' });
});

</script>