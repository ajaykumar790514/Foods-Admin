<div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                <div class="page-wrapper">
									<!-- Page-header start -->
                                    <div class="page-header card">
                                        <div class="card-block">
                                            <h5 class="m-b-10"><?=$title;?></h5>
                                            <ul class="breadcrumb-title b-t-default p-t-10">
                                                <li class="breadcrumb-item">
                                                    <a href="index.html"> <i class="fa fa-home"></i> </a>
                                                </li>
                                               <li class="breadcrumb-item"><a href="#!">Home</a>
                                                        </li>
                                                        <li class="breadcrumb-item"><a href="#!"><?=$title;?></a>
                                                        </li>
                                            </ul>
                                        </div>
                                    </div>
                                <!-- Page-header end -->
                                    
                                <!-- Page-body start -->
                                <div class="page-body">
                                    <!-- Basic table card start -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h5> 
                                               Manage Orders
                                            </h5>
                                            <form autocomplete="off" class="form dynamic-tb-search" action="<?=$tb_url?>" method="POST" enctype="multipart/form-data" tagret-tb="#tb">
                                             <div class="row justify-content-center">
                                             <div class="form-group col-md-2">
                                                <label>Start Date:</label>
                                                <input type="date" name="start_date" class="form-control">
                                             </div>
                                             <div class="form-group col-md-2">
                                                <label>End Date:</label>
                                                <input type="date" name="end_date" class="form-control">
                                             </div>
                                             <div class="form-group col-md-2">
                                                <label>Status:</label>
                                                <select class="form-control input-sm" style="width:100%;" name="status" id="status" >
                                                    <option value="">--Select Status--</option>
                                                    <?php foreach ($status as $s) { ?>
                                                        <option value="<?php echo $s->id; ?>" >
                                                            <?php echo $s->name; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label>Payment Mode:</label>
                                                <select class="form-control  input-sm" style="width:100%;" name="mode" id="mode">
                                                <option value="">--Select Payment Mode--</option>
                                                 <?php foreach ($mode as $m) { ?>
                                                <option value="<?php echo $m->id; ?>">
                                                <?php echo $m->name; ?>
                                                </option>
                                                <?php } ?>                                         
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group mb-0">
                                                    <label for="name">Search</label>
                                                    <input type="text" class="form-control input-sm" name="search" id="tb-search" value="<?php if($search!='null'){echo $search;}?>" placeholder="Search..." />
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                            <div class="card-header-right">
												<ul class="list-unstyled card-option">
													<li><i class="fa fa-chevron-left"></i></li>
													<li><i class="fa fa-window-maximize full-card"></i></li>
													<li><i class="fa fa-minus minimize-card"></i></li>
													<li><i class="fa fa-refresh reload-card"></i></li>
													<li><i class="fa fa-times close-card"></i></li>
												</ul>
											</div>
                                        </div>
                                        <div id="tb"></div>
                                    </div>
                                    <!-- Basic table card end -->
                                </div>
                                <!-- Page-body end -->
                            </div>
                        </div>
                        <!-- Main-body end -->

                        <div id="styleSelector">

                        </div>
                    </div>
                </div>