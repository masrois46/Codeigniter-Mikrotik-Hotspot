<div id="page-wrapper">
	<br />
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $hotspot_count; ?></div>
                                    <div>User Hotspot</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $ppp_count; ?></div>
                                    <div>User PPP</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-bar-chart-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $count_mountly; ?></div>
                                    <div>User Bulan Ini</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-bar-chart-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $count_total; ?></div>
                                    <div>Total User</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-8">
                	<div class="row">
                    	<div class="col-lg-6 col-md-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-user fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?php echo $hotspot_active; ?></div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="panel-footer">
                                        <span class="pull-left">Hotspot Active</span>
                                        <div class="clearfix"></div>
                                    </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-3">
                            <div class="panel panel-green">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-tasks fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?php echo $ppp_active; ?></div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="panel-footer">
                                        <span class="pull-left">PPP Active</span>
                                        <div class="clearfix"></div>
                                    </div>
                            </div>
                        </div>
                    </div>
                   	<div class="row">
                    	<div class="col-lg-12">
                        	<div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Chart
                            </div>
                            <div class="panel-body">
                            	
                                    <ul class="nav nav-tabs" role="tablist">
                                      <li class="nav-item">
                                        <a class="nav-link active" href="#area" role="tab" data-toggle="tab">Area Chart</a>
                                      </li>
                                      <li class="nav-item">
                                        <a class="nav-link" href="#donuts" role="tab" data-toggle="tab">Donats Chart</a>
                                      </li>
                                    </ul>
                                    <div class="tab-content">
                                      <div role="tabpanel" class="tab-pane fade in active" id="area"><div id="morris-area-chart"></div></div>
                                      <div role="tabpanel" class="tab-pane fade in active" id="donuts"><div id="morris-donut-chart"></div></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-info-circle fa-fw"></i> Server Information
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="list-group">
                                <a href=".#" class="list-group-item">
                                    <i class="fa fa-clock-o fa-fw"></i> Uptime
                                    <span class="pull-right text-muted small"><em id="uptime"></em>
                                    </span>
                                </a>
                                <a href=".#" class="list-group-item">
                                    <i class="fa fa-tasks fa-fw"></i> CPU Load
                                    <span class="pull-right text-muted small"><em id="cpu_load"></em>
                                    </span>
                                </a>
                                <a href=".#" class="list-group-item">
                                    <i class="fa fa-tasks fa-fw"></i> Board Name
                                    <span class="pull-right text-muted small"><em id="board_name"></em>
                                    </span>
                                </a>
                                <a href=".#" class="list-group-item">
                                    <i class="fa fa-tasks fa-fw"></i> CPU
                                    <span class="pull-right text-muted small"><em id="cpu"></em>
                                    </span>
                                </a>
                                <a href=".#" class="list-group-item">
                                    <i class="fa fa-tasks fa-fw"></i> Model
                                    <span class="pull-right text-muted small"><em id="model"></em>
                                    </span>
                                </a>
                                <a href=".#" class="list-group-item">
                                    <i class="fa fa-hdd-o fa-fw"></i> Free Memory
                                    <span class="pull-right text-muted small"><em id="free_memory"></em>
                                    </span>
                                </a>
                                <a href=".#" class="list-group-item">
                                    <i class="fa fa-hdd-o fa-fw"></i>Total Memory
                                    <span class="pull-right text-muted small"><em id="total_memory"></em>
                                    </span>
                                </a>
                                <a href=".#" class="list-group-item">
                                    <i class="fa fa-hdd-o fa-fw"></i> Free HDD Space
                                    <span class="pull-right text-muted small"><em id="free_hdd_space"></em>
                                    </span>
                                </a>
                                <a href=".#" class="list-group-item">
                                    <i class="fa fa-hdd-o fa-fw"></i> Total HDD Size
                                    <span class="pull-right text-muted small"><em id="total_hdd_space"></em>
                                    </span>
                                </a>
                                <a href=".#" class="list-group-item">
                                    <i class="fa fa-globe fa-fw"></i> Version
                                    <span class="pull-right text-muted small"><em id="version"></em>
                                    </span>
                                </a>
                            </div>
                            <!-- /.list-group -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>