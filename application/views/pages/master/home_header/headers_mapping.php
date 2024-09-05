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
                                                <h5 class="card-title" id="test">Product Header Data</h3>
                                                <h6 class="card-subtitle"></h6>
                                            </div>
                                            <div class="float-right col-md-2 col-lg-2 col-sm-12">
                                                <div id="add-headers-mapping" class="modal  bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content" id="mapping">
                                                         
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="float-right btn btn-primary" data-toggle="modal" data-target="#add-headers-mapping" onclick="add_mapping(<?php echo $headerid;?>)">Add Headers Items</button>
                                                
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
                                        <div class="card-block table-border-style">
                                            <div class="table-responsive">
                                            <table class="table" >
                                                <tr>
                                                    <th>S.No.</th>
                                                    <th>Header</th>
                                                    <th>Product Name</th>
                                                    <th>Product Photo</th>
                                                    <th>Product Code</th>
                                                    <th>Actions</th>
                                                </tr>
                                                <?php $i=1; foreach($headers_mapping as $value){ ?>
                                                <tr class="jsgrid-filter-row">
                                                    <th><?php echo $i++;?></th>
                                                    <td><?php echo $value->title;?></td>
                                                    <td><?php echo $value->prod_name;?><br></td>
                                                    <td>
                                                    <img src="<?php echo IMGS_URL.$value->icon; ?>" alt="image" height="100">
                                                    </td>
                                                    <td><?php echo $value->pro_code;?></td>
                                                    
                                                    <td>
                                                        <a href="<?php echo base_url('delete-header-mapping/' . $value->id); ?>" onclick="return confirm('Do you want to delete this?')"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                                <?php } ?>  
                                                </table>
                                            </div>
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
            business_id:"required",
            shop_id:"required",
            title:"required",
            type:"required"
        },
    }); 
});
</script>


<script type="text/javascript">
   function add_mapping(headerid)
   {
    $.ajax({
        url: "<?php echo base_url('add_mapping'); ?>",
        method: "POST",
        data: {
            headerid:headerid
        },
        success: function(data){
            $("#mapping").html(data);
        },
    });
    // $("#mapping").load("<?php echo base_url('add_mapping'); ?>"+headerid)
   }
</script>
<script type="text/javascript">
   function fetch_category(parent_id)
   {
    //    alert(business_id);
    $.ajax({
        url: "<?php echo base_url('fetch_sub_categories'); ?>",
        method: "POST",
        data: {
            parent_id:parent_id
        },
        success: function(data){
            $(".parent_cat_id").html(data);
               var headerid = $('#headerid').val();
                $.ajax({
                    url: "<?php echo base_url('fetch_products'); ?>",
                    method: "POST",
                    data: {
                        parent_cat_id:parent_id,
                        headerid:headerid
                    },
                    success: function(data){
                        $("#available_products").html(data);
                    },
                });
        },
    });
   }
   function fetch_sub_category(parent_id)
{
$.ajax({
    url: "<?php echo base_url('fetch_sub_category'); ?>",
    method: "POST",
    data: {
        parent_id:parent_id,
    },
    success: function(data){
        $(".sub_parent_cat_id").html(data);
        
    },
});
}
</script>
<script type="text/javascript">
   function fetch_products(parent_cat_id)
   {
    var headerid = $('#headerid').val();
    $.ajax({
        url: "<?php echo base_url('fetch_products'); ?>",
        method: "POST",
        data: {
            parent_cat_id:parent_cat_id,
            headerid:headerid
        },
        success: function(data){
            $("#available_products").html(data);
        },
    });
   }
</script>
<script type="text/javascript">
   function map_product(pid)
   {
    var headerid = $('#headerid').val();
    $.ajax({
        url: "<?php echo base_url('map_product'); ?>",
        method: "POST",
        data: {
            pid:pid,
            headerid:headerid
        },
        success: function(data){
            // fetch_products();
            $("#changeaction2"+pid).html(data);
        },
    });
   }
</script>
<script type="text/javascript">
   function remove_map_product(pid)
   {
    var headerid = $('#headerid').val();
    $.ajax({
        url: "<?php echo base_url('remove_map_product'); ?>",
        method: "POST",
        data: {
            pid:pid,
            headerid:headerid
        },
        success: function(data){
            // fetch_products();
            $("#changeaction2"+pid).html(data);
        },
    });
   }
</script>
 

 
