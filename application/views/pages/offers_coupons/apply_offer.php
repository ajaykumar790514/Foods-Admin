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
                                        <div class="col-12">
                                        <div class="d-flex flex-wrap">
                                            <div class="float-left col-md-10 col-lg-10 col-sm-12">
                                                <h5 class="card-title" id="test">Apply Offer</h5>
                                                <h6 class="card-subtitle"></h6>
                                            </div>
                                            <div class="float-right col-md-2 col-lg-2 col-sm-12">
                                                <div id="apply-category" class="modal  bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Apply On Category</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                                <form class="needs-validation" action="<?php echo base_url('apply-category'); ?>" method="post">
                                                            <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label class="control-label">ABC</label>
                                                                                <input type="text" class="form-control" name="abc">
                                                                            </div>
                                                                        </div>
                                                                    
                                                                    </div>
                                                            
                                                            </div> 
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                                <input type="submit" class="btn btn-danger waves-light" type="submit" value="Apply">
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <button class="float-right btn btn-primary" data-toggle="modal" data-target="#apply-category" >Apply On Category</button> -->
                                            </div>
                                        </div>
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
                                <div class="row pl-3 pr-3">
                               
                                <div class="col-4">
                                    <div class="form-group">
                                    <label class="control-label">Parent Categories:</label>
                                    <select class="form-control" style="width:100%;" name="parent_id" id="parent_id" onchange="fetch_category(this.value)">
                                    <option value="">Select</option>
                                    <?php foreach ($parent_cat as $parent) { ?>
                                    <option value="<?php echo $parent->id; ?>">
                                        <?php echo $parent->name; ?>
                                    </option>
                                    <?php } ?>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                    <label class="control-label"> Sub Categories:</label>
                                    <select class="form-control parent_cat_id" style="width:100%;" name="parent_cat_id" id="parent_cat_id" onchange="fetch_products(this.value)">
                                
                                    </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                <div class="row d-none apllyofferstab">
                                    <div class="col-6"></div>
                                    <div class="col-2  mb-2">
                                <a data-toggle="modal" class="float-right btn btn-primary" style="margin-top: 10px;margin-left:-2rem" href="#" data-target="#apply-category1" onclick="available_offers_cat()">Apply on category</a >
                                </div>
                                <div class="col-3  ml-2 mb-2">
                                <a  class="float-right btn btn-primary text-white" style="margin-top: 10px;margin-left:-2rem" onclick="remove_offers_cat()">Remove on category</a >
                                </div>
                                </div>
                                </div>
                                <!--Add property modal-->
                                <div id="apply-category1" class="modal  bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog  modal-lg">
                                                    <div class="modal-content" id="available_offers_list_cat">
                                                        
                                                    </div>
                                                </div> 
                                            </div>
                                            <!--/Add property modal-->
                                            <div class="col-12 mt-3" id="available_products">
                                                
                                            </div>
                                        </div>
                                    <!-- </form> -->
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
  <script>
function fetch_category(parent_id)
{
 $('.apllyofferstab').removeClass('d-none');   
$.ajax({
    url: "<?php echo base_url('fetch_sub_categories'); ?>",
    method: "POST",
    data: {
        parent_id:parent_id
    },
    success: function(data){
        $(".parent_cat_id").html(data);
        $.ajax({
        url: "<?php echo base_url('offers-coupons/fetch_products'); ?>",
        method: "POST",
        data: {
            parent_cat_id:parent_id,
        },
        success: function(data){
            $("#available_products").html(data);
        },
    });
    },
});
}
function fetch_products(parent_cat_id)
{
$('.apllyofferstab').removeClass('d-none');
$.ajax({
    url: "<?php echo base_url('offers-coupons/fetch_products'); ?>",
    method: "POST",
    data: {
        parent_cat_id:parent_cat_id,
    },
    success: function(data){
        $("#available_products").html(data);
    },
});
}
  </script>