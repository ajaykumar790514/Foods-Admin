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
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="New <?=$title?>" data-url="<?=$new_url?>" class="btn btn-primary btn-sm" class="btn btn-primary btn-sm add-btn"> 
                                                <i class="ft-plus"></i> Add New Category
                                                </a>
                                            </h5>
                                            <form autocomplete="off" class="form dynamic-tb-search" action="<?=$tb_url?>" method="POST" enctype="multipart/form-data" tagret-tb="#tb">
                                             <div class="row justify-content-center">
                                             <div class="form-group col-md-2">
                                                <label>Parent Categories:</label>
                                                <select class="form-control input-sm" style="width:100%;" name="parent_id" id="parent_id" onchange="fetch_sub_categories(this.value)">
                                                    <option value="">Select</option>
                                                    <?php foreach ($parent_cat_list as $parent) { ?>
                                                        <option value="<?php echo $parent->id; ?>" <?php if(!empty($parent_id)) { if($parent_id==$parent->id) {echo "selected"; } }?>>
                                                            <?php echo $parent->name; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label>Sub Categories:</label>
                                                <select class="form-control parent_cat_id input-sm" style="width:100%;" name="parent_cat_id" id="parent_cat_id" onchange="fetch_results(this.value)">
                                                    <?php if(!empty($cat_id)) { ?>
                                                        <?php foreach ($sub_cat as $scat) { ?>
                                                            <option value="<?php echo $scat->id; ?>" <?php if(!empty($cat_id)) { if($cat_id==$scat->id) {echo "selected"; } }?>>
                                                                <?php echo $scat->name; ?>
                                                            </option>
                                                        <?php } ?>
                                                    <?php }?>                                            
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
<script>
  function fetch_results(cat_id)
   {
        var parent_id = $('#parent_id').val();
        $.ajax({
            url: "<?php echo base_url('manage-category/tb'); ?>",
            method: "POST",
            data: {
                cat_id:cat_id,  //cat2 id
                parent_id:parent_id,    //cat1 id
            },
            success: function(data){
                $("#tb").html(data);
               
            },
        });
        
   };
   function fetch_sub_categories(parent_id)
   {
    //ajax function for loading table by category 1
    var cat_id = $('#parent_cat_id').val(); //cat2 id
    $.ajax({
        url: "<?php echo base_url('manage-category/tb'); ?>",
        method: "POST",
        data: {
            cat_id:cat_id,   //cat2 id
            parent_id:parent_id,   //cat1 id
        },
        success: function(data){
            //alert("hello");
            $("#tb").html(data);
            //ajax function for loading sub categories
            $.ajax({
                url: "<?php echo base_url('manage-category/fetch_sub_categories'); ?>",
                method: "POST",
                data: {
                    parent_id:parent_id //cat1 id
                },
                success: function(data){
                    $(".parent_cat_id").html(data);


                },
            });
        },
    });
   

   }

</script>
                