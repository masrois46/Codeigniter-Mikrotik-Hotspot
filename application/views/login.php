
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $this->session->flashdata('title').' - '.$this->session->flashdata('TITLE'); ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(); ?>assets/plugin/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url(); ?>assets/plugin/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>assets/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url(); ?>assets/plugin/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<?php if($type=='login') { ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form id="form" action="<?php echo base_url('login'); ?>" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="text" autofocus required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" required>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" id="btnLogin" class="btn btn-lg btn-success btn-block">Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php }else{ ?>
	<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Setup Administrator</h3>
                    </div>
                    <form id="form" action="<?php echo base_url('setup'); ?>" method="post">
                    	<div class="panel-body">
                            <fieldset>
                                <div class="form-group">
                                	<label>Username</label>
                                    <input class="form-control" placeholder="Username" name="username" type="text" value="<?php echo $data_admin['username']; ?>" autofocus required>
                                </div>
                                <div class="form-group">
                                	<label>Password</label>
                                    <input class="form-control" placeholder="Password" name="password" type="text" value="<?php echo $data_admin['password']; ?>" required>
                                </div>
                                <div class="form-group">
                                	<label>MIKROTIK HOST</label>
                                    <input class="form-control" placeholder="192.168.1.2" name="mikrotik_host" id="mikrotik_host" type="text" value="<?php echo $mikrotik_host['value']; ?>" required>
                                </div>
                                <div class="form-group">
                                	<label>MIKROTIK USER</label>
                                    <input class="form-control" placeholder="Admin" name="mikrotik_user" id="mikrotik_user" type="text" value="<?php echo $mikrotik_user['value']; ?>" required>
                                </div>
                                <div class="form-group">
                                	<label>MIKROTIK PASS</label>
                                    <input class="form-control" placeholder="XXXXX" name="mikrotik_pass" id="mikrotik_pass" type="text" value="<?php echo $mikrotik_pass['value']; ?>" required>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="button" id="cek_mikrotik" class="btn btn-lg btn-primary btn-block">Cek Koneksi Mikrotik</button>
                                <button type="submit" id="createconfig" class="btn btn-lg btn-success btn-block" disabled="disabled">Create Configuration</button>
                            </fieldset>
                    	</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>assets/plugin/jquery/jquery.min.js"></script>
	<script type="application/javascript">
		$("#form").submit(function(e) {
			var form = $("#form");
			$.ajax({
				type: form.attr("method"),
				url: form.attr("action"),
				data: form.serialize(),
				beforeSend: function()
				{
					$("#createconfig").html('Loading');
					$("#createconfig").prop('disabled', 'disabled');
					$("#btnLogin").html('Loading');
					$("#btnLogin").prop('disabled', 'disabled');
				},
				success: function(data)
				{
					if(data == "success")
					{
						alert('Berhasil');
						window.location.replace('<?php echo base_url(); ?>');
					}else{
						alert("Error, Please try again!");
					}
				},
				complete: function()
				{
					$("#createconfig").html('Create Configuration');
					$("#createconfig").removeAttr('disabled');
					$("#btnLogin").html('Login');
					$("#btnLogin").removeAttr('disabled');
				}
			});
			e.preventDefault();
		});
		
		$("#cek_mikrotik").click(function(){
			var host = $("#mikrotik_host").val();
			var user = $("#mikrotik_user").val();
			var pass = $("#mikrotik_pass").val();
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url('cek-mikrotik'); ?>',
				data: {
					'mikrotik_host': host,
					'mikrotik_user': user,
					'mikrotik_pass': pass
				},
				beforeSend: function(){
					$("#cek_mikrotik").html('Loading');
					$("#cek_mikrotik").prop('disabled', 'disabled');
				},
				success: function(data){
					if(data == "success"){
						$("#cek_mikrotik").remove();
						$("#createconfig").removeAttr('disabled');
						alert('Sukses');
					}else{
                        $("#cek_mikrotik").html('Cek Koneksi Mikrotik');
                        $("#cek_mikrotik").removeAttr('disabled');
						alert('Gagal, Silakan periksa kembali Data Mikrotik!');
					}
				},
				error: function(err){
					$("#cek_mikrotik").html('Cek Koneksi Mikrotik');
					$("#cek_mikrotik").removeAttr('disabled');
					alert('Gagal, Silakan periksa kembali Data Mikrotik');
				}
			});
		});
	</script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url(); ?>assets/plugin/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url(); ?>assets/plugin/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url(); ?>assets/dist/js/sb-admin-2.js"></script>

</body>

</html>
