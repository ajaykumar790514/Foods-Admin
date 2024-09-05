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
                                        <div class="float-left col-md-10 col-lg-10 col-sm-12">
                                                <h5 class="card-title" id="test">Home Header Data</h3>
                                                <h6 class="card-subtitle"></h6>
                                            </div>
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
                                        <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex flex-wrap">
                                            <div class="float-left col-md-10 col-lg-10 col-sm-12">
                                                <h6 class="card-subtitle"></h6>
                                            </div>
                                            <div class="float-right col-md-2 col-lg-2 col-sm-12">
                                                <div id="add-home-header" class="modal  bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Add New Home Header Entry</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="needs-validation" action="<?php echo base_url('add-home-header'); ?>" method="post">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Title</label>
                                                                            <input type="text" class="form-control" name="title">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Type:</label>
                                                                            <select class="form-control" style="width:100%;" name="type">
                                                                                <option value="">--Select--</option>
                                                                                <option value="1">Product header</option>
                                                                                <option value="2">Category header</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Sequence:</label>
                                                                            <input type="number" class="form-control" name="seq">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Color Code</label>
                                                                            <input type="text" name="colorcode" class="form-control" cols="30" rows="5"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                               
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                                <input type="submit" class="btn btn-danger waves-light" type="submit" value="CREATE">
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="float-right btn btn-primary" data-toggle="modal" data-target="#add-home-header" >Add Home Header</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                    <div class="card-block table-border-style">
                                    <div class="table-responsive">
                                        <table class="table" >
                                                <tr>
                                                    <th>S.No.</th>
                                                    <th>Title</th>
                                                    <th>Type</th>
                                                    <th>Sequence</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                                <?php $i=1; foreach($home_header as $value){ ?>
                                                <tr>
                                                    <th><?php echo $i++;?></th>
                                                    <td><?php echo $value->title;?></td>
                                                    <th>
                                                        <?php if($value->type==1) { ?>
                                                    <?php echo 'Product header';?>
                                                    <?php } else {?>
                                                        <?php echo 'Category header';?>
                                                        <?php }?>
                                                    </th>
                                                    <td><?php echo $value->seq;?></td>
                                                    <td id="status<?php echo $value->id; ?>">
                                                    <td class="text-center">
                                                    <span class="changeStatus" style="font-size:1.3rem;" data-toggle="change-status" value="<?=($value->active==1) ? 0 : 1?>" data="<?=$value->id?>,home_headers,id,active" ><i class="<?=($value->active==1) ? 'ti-check-box text-success' : 'ti-na text-danger'?>" title="Click for chenage status"></i></span>
                                                </td>
                                                    <td>
                                                        <a  data-toggle="modal" href="#" data-target="#edit-home-header<?php echo $value->id; ?>" ><i class="fa fa-edit"></i></a>
                                                        <a href="<?php echo base_url('delete-home-header/' . $value->id); ?>" onclick="return confirm('Do you want to delete this?')"><i class="fa fa-trash"></i></a>
                                                        <?php if($value->type==1) { ?>
                                                        <a href="<?php echo base_url('product-headers-mapping/' . $value->id); ?>"><i class="fa fa-eye"></i></a>
                                                        <?php } else {?>
                                                            <a href="<?php echo base_url('cat-headers-mapping/' . $value->id); ?>"><i class="fa fa-eye"></i></a>
                                                            <?php }?>
                                                    </td>
                                                </tr>
                                                
                                                <div id="edit-home-header<?php echo $value->id; ?>" class="modal  bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Update Home Header</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="<?php echo base_url('edit-home-header/'.$value->id); ?>" method="post" required>
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Title</label>
                                                                            <input type="text" class="form-control" name="title" value="<?php echo $value->title; ?>" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Type:</label>
                                                                            <select class="form-control" style="width:100%;" name="type" required>
                                                                                <option value="1" <?php if($value->type == '1') {
                                                                            echo "selected";
                                                                        } ?>>Product header</option>
                                                                                <option value="2" <?php if($value->type == '2') {
                                                                            echo "selected";
                                                                        } ?>>Category header</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Sequence:</label>
                                                                            <input type="number" class="form-control" name="seq" value="<?php echo $value->seq; ?>" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Color Code</label>
                                                                            <textarea name="colorcode" class="form-control" cols="30" rows="5"><?php echo $value->colorcode; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                                <input type="submit" class="btn btn-danger waves-light" type="submit" value="UPDATE">
                                                            </div>
                                                                </form>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <?php } ?>  
                                                </table>
                                        </div>
                                    </div>
                                    </div>
                                </div>
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
 
 

 <script type="text/javascript">
$(document).ready(function() {
    $(".needs-validation").validate({
        rules: {
            title:"required",
            type:"required",
            seq:"required"
        },
    }); 
});
</script>
