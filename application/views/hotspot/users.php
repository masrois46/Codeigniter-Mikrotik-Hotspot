<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">User Hotspot</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading clearfix">
                        	List Users Hotspot
                            <div class="btn-group pull-right">
                                <button class="btn btn-sm btn-primary" onclick="addnew()"><li class="fa fa-plus"></li> Add New</button>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="tableHotspot">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Passowrd</th>
                                        <th>Server</th>
                                        <th>Registered</th>
                                        <th>Expired</th>
                                        <th>Profile</th>
                                        <th>Uptime</th>
                                        <th>Info</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
										$aktif = 0;
										$nonaktif = 0;
                                        foreach($user_sync as $user) {
                                            $date_now = strtotime(date('d-m-Y'));
                                            $date_expired = strtotime($user['expired']);
                                            if($date_now > $date_expired){
                                                $expired = 'Expired';
                                            }else{
                                                $expired = '';
                                            }
											
											if($user['disabled'] == 'false'){
												$aktif++;
											}else{
												$nonaktif++;
											}
                                    ?>
                                    <tr <?php if($expired=='Expired' && $user['disabled']=='false'){ echo 'style="background-color:#d9534f;"'; }else if($expired=='Expired' && $user['disabled']=='true'){ echo 'style="background-color:#f0ad4e"'; } ?>>
                                        <td><?php echo $user['name']; ?></td>
                                        <td><?php echo $user['password']; ?></td>
                                        <td><?php echo $user['server']; ?></td>
                                        <td><?php echo $user['registered']; ?></td>
                                        <td><?php echo $user['expired']; ?></td>
                                        <td><?php echo $user['profile']; ?></td>
                                        <td><?php echo $user['uptime']; ?></td>
                                        <?php if($user['registered']=='00-00-000' || $user['expired']=='00-00-0000'){ echo '<td><button class="btn btn-xs btn-primary" data-user="'.$user['name'].'" id="btnSync">Sync Now</button></td>'; }else if($expired=='Expired'){ echo '<td class="bg-danger">'.$expired.'</td>'; }else{ echo '<td>Aktif</td>'; } ?>
                                        <td><?php if($expired=='Expired' && $user['disabled']=='false'){ echo '<button class="btn btn-xs btn-primary" id="disableAkun" data-id="'.$user['.id'].'">Disable</button>'; }else if($user['disabled'] == 'false'){ echo 'Enable'; }else if($user['disabled'] == 'true'){ echo 'Disable'; } ?></td>
                                        <td><button class="btn btn-xs btn-primary" id="btnEdit" data-id="<?php echo $user['.id']; ?>" data-user="<?php echo $user['name']; ?>" data-pw="<?php echo $user['password']; ?>" data-server="<?php echo $user['server']; ?>" data-registered="<?php echo date('Y-m-d', strtotime($user['registered'])); ?>" data-expired="<?php echo date('Y-m-d', strtotime($user['expired'])); ?>" data-profile="<?php echo $user['profile']; ?>" data-status="<?php if($user['disabled'] == 'false'){ echo 'false'; }else if($user['disabled'] == 'true'){ echo 'true'; } ?>" data-status="<?php echo $user['disabled']; ?>">Edit</button> <a href="<?php echo base_url('hotspot/remove/'.urlencode($user['.id']).'/'.urlencode($user['name'])); ?>" onclick="return confirm('Apakah Anda Yakin?');"><button class="btn btn-xs btn-primary">Delete</button></a></td>
                                    </tr>                                     
                                    <?php } ?>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                            <div class="well">
                                <h4>Informasi</h4>
                                <table border="0" width="100%">
                                    <tr>
                                        <td bgcolor="#d9534f" width="5%">&nbsp;</td>
                                        <td>Sudah expired tapi masih aktif</td>
                                        <td align="right">Enabled: </td>
                                        <td align="right" width="5%"><?php echo $aktif; ?> User</td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#f0ad4e" width="5%">&nbsp;</td>
                                        <td>Sudah expired dan sudah tidak aktif</td>
                                        <td align="right">Disabled: </td>
                                        <td align="right" width="5%"><?php echo $nonaktif; ?> User</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
        
<!-- Modal Syncrone -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
      	<button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="titleModal"></h4>
      </div>

      <!-- Modal body -->
      <form id="form" action="<?php echo base_url('hotspot/syncronize'); ?>" method="post">
      <div class="modal-body" id="bodyModal">
      	<div class="form-group">
        	<label>Username</label>
            <input type="text" class="form-control" name="user" id="txtName" readonly="readonly" />
        </div>
        <div class="form-group">
        	<label>Register</label>
            <input type="date" class="form-control" name="registered" required/>
        </div>
        <div class="form-group">
        	<label>Expire</label>
            <input type="date" class="form-control" name="expired" id="txtName" required/>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
	  </form>
    </div>
  </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="ModalAdd" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
      	<button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Hotspot</h4>
      </div>

      <!-- Modal body -->
      <form id="formAdd" action="<?php echo base_url('hotspot/proses_add'); ?>" method="post">
      <div class="modal-body">
      	<div class="form-group">
        	<label>Username</label>
            <input type="text" class="form-control" name="user" required/>
        </div>
        <div class="form-group">
        	<label>Password</label>
            <input type="text" class="form-control" name="password" required/>
        </div>
        <div class="form-group">
        	<label>Server</label>
            <select class="form-control" name="server" required>
            	<?php foreach($list_server_hotspot as $row){ ?>
                <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
        	<label>Register</label>
            <input type="date" class="form-control" name="registered" required/>
        </div>
        <div class="form-group">
        	<label>Expire</label>
            <input type="date" class="form-control" name="expired" required/>
        </div>
        <div class="form-group">
        	<label>User Profile</label>
            <select class="form-control" name="profile" required>
            	<?php foreach($list_user_profile as $row){ if($row['name'] != 'default') {?>
                <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                <?php }} ?>
            </select>
        </div>
        <div class="form-group">
        	<label>Status</label>
            <select class="form-control" name="status" required>
            	<option value="false">Enable</option>
                <option value="true">Disable</option>
            </select>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btnSimpan">Submit</button>
      </div>
	  </form>
    </div>
  </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="ModalEdit" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
      	<button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="titleModal2"></h4>
      </div>

      <!-- Modal body -->
      <form id="formEdit" action="<?php echo base_url('hotspot/proses_edit'); ?>" method="post">
      <input type="hidden" name="id" id="Eid" />
      <div class="modal-body" id="bodyModal">
      	<div class="form-group">
        	<label>Username</label>
            <input type="text" class="form-control" name="user" id="EName" readonly="readonly" />
        </div>
        <div class="form-group">
        	<label>Password</label>
            <input type="text" class="form-control" name="password" id="Epassword" required/>
        </div>
        <div class="form-group">
        	<label>Server</label>
            <select class="form-control" name="server" id="Eserver">
            	<?php foreach($list_server_hotspot as $row){ ?>
                <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
        	<label>Register</label>
            <input type="date" class="form-control" name="registered" id="Eregister" required/>
        </div>
        <div class="form-group">
        	<label>Expire</label>
            <input type="date" class="form-control" name="expired" id="Eexpired" required/>
        </div>
        <div class="form-group">
        	<label>User Profile</label>
            <select class="form-control" name="profile" id="Eprofile">
            	<?php foreach($list_user_profile as $row){ if($row['name'] != 'default') {?>
                <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                <?php }} ?>
            </select>
        </div>
        <div class="form-group">
        	<label>Status</label>
            <select class="form-control" name="status" id="Estatus">
            	<option value="false">Enable</option>
                <option value="true">Disable</option>
            </select>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btnSEdit">Submit</button>
      </div>
	  </form>
    </div>
  </div>
</div>

<script>
	$("#tableHotspot tbody td #btnEdit").click(function(){
		$('#ModalEdit').modal();
		$('#titleModal2').html('Edit User '+$(this).data('user'));
		$('#Eid').val($(this).data('id'));
		$('#EName').val($(this).data('user'));
		$('#Epassword').val($(this).data('pw'));
		$('#Eserver option[value='+$(this).data('server')+']').attr('selected', 'selected');
		$('#Eregister').val($(this).data('registered'));
		$('#Eexpired').val($(this).data('expired'));
		$('#Eprofile option[value='+$(this).data('profile')+']').attr('selected', 'selected');
		$('#Estatus option[value='+$(this).data('status')+']').attr('selected', 'selected');
	});
	
	$("#tableHotspot tbody td #btnSync").click(function(){
		$('#myModal').modal();
		var user = $(this).data('user');
		$('#titleModal').html('Synchronize User '+user);
		$('#txtName').val(user);
	});
	
	function addnew(){
		$('#ModalAdd').modal();
	}
	
	$('#formAdd').submit(function(e){
		var form = $('#formAdd');
		e.preventDefault();
		$.ajax({
			type: 'post',
			url: form.attr('action'),
			data: form.serialize(),
			beforeSend: function(){
				$('#btnSimpan').html('Loading...');
			},
			success: function(data){
				if(data=="success"){
					alert('Tambah User Berhasil');
					window.location.replace('<?php echo base_url('hotspot'); ?>');
				}else{
					alert(data);
				}
			},
			completed: function(){
				$('#btnSimpan').html('Submit');
			}
		});
	});
	
	$("#formEdit").submit(function(e){
		var form = $("#formEdit");
		e.preventDefault();
		$.ajax({
			type: 'post',
			url: form.attr("action"),
			data: form.serialize(),
			beforeSend: function(){
				$("#btnSEdit").html('Loading...');
			},
			success: function(data){
				if(data=="success"){
					alert('Edit Berhasil');
					window.location.replace('<?php echo base_url('hotspot'); ?>');
				}else{
					alert(data);
				}
			},
			completed: function(){
				$("#btnSEdit").html('Submit');
			}
		});
	});
	
    $("#tableHotspot tbody td #disableAkun").click(function(){
        $.ajax({
            type: 'post',
            url: '<?php echo base_url('hotspot/disableakun'); ?>',
            data: {
                id: $(this).data('id')
            },
            success: function(data){
                if(data=="success"){
                    alert('Disable Berhasil!');
                    window.location.replace('<?php echo base_url('hotspot'); ?>');
                }else{
                    alert(data);
                }
            }
        });
    });
</script>