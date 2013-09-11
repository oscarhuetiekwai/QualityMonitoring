<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>QM Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
	<?php  echo css('bootstrap.css'); ?>
    <style type="text/css">
      body {
        padding-top: 100px;
        padding-bottom: 260px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
	<?php  echo css('bootstrap-responsive.css'); ?>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="../assets/ico/favicon.png">
  </head>
  <body class="login_background" >
    <div class="container">
		<div class="row-fluid login-wrapper">
        <div class="span4 box offset4">
            <div class="content-wrap">
                <h6>Log in</h6>
				<?php
					$attributes = array('id' => 'login_form');
					echo form_open('login/validate_credentials', $attributes);
					?>
				<?php
					$this->load->view('template/show_error');
				?>
				<input class="span12" type="text" name="username"  placeholder="Your Username">
                <input class="span12" type="password" name="password" placeholder="Your Password">
				<br />
				 <button class="btn-glow primary login" type="submit">Log in</button>
			</form>
            </div>
        </div>
		</div>
    </div> <!-- /container -->
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
