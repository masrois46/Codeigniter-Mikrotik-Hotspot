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
                        <div class="panel-heading">
                            List Users Hotspot
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
                                        foreach($user_sync as $user) {
                                            $date_now = strtotime(date('d-m-Y'));
                                            $date_expired = strtotime($user['expired']);
                                            if($date_now > $date_expired){
                                                $expired = 'Expired';
                                            }else{
                                                $expired = '';
                                            }
                                    ?>
                                    <tr <?php if($expired=='Expired' && $user['disabled']=='false'){ echo 'style="background-color:red;"'; }else if($expired=='Expired' && $user['disabled']=='true'){ echo 'style="background-color:orange;"'; } ?>>
                                        <td><?php echo $user['name']; ?></td>
                                        <td><?php echo $user['password']; ?></td>
                                        <td><?php echo $user['server']; ?></td>
                                        <td><?php echo $user['registered']; ?></td>
                                        <td><?php echo $user['expired']; ?></td>
                                        <td><?php echo $user['profile']; ?></td>
                                        <td><?php echo $user['uptime']; ?></td>
                                        <?php if($user['registered']=='00-00-000' || $user['expired']=='00-00-0000'){ echo '<td><button class="btn btn-xs btn-primary">Sync Now</button></td>'; }else if($expired=='Expired'){ echo '<td class="bg-danger">'.$expired.'</td>'; }else{ echo '<td>Aktif</td>'; } ?>
                                        <td><?php if($expired=='Expired' && $user['disabled']=='false'){ echo '<button class="btn btn-xs btn-primary" id="disableAkun" data-id="'.$user['.id'].'">Disable</button>'; }else if($user['disabled'] == 'false'){ echo 'Enable'; }else if($user['disabled'] == 'true'){ echo 'Disable'; } ?></td>
                                        <td><button class="btn btn-xs btn-primary">Edit</button> <button class="btn btn-xs btn-primary">Delete</button></td>
                                    </tr>                                     
                                    <?php } ?>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                            <div class="well">
                                <h4>Informasi</h4>
                                <table border="0" width="100%">
                                    <tr>
                                        <td bgcolor="red" width="5%">&nbsp;</td>
                                        <td>Sudah expired tapi masih aktif</td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="orange" width="5%">&nbsp;</td>
                                        <td>Sudah expired dan sudah tidak aktif</td>
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

<script>
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