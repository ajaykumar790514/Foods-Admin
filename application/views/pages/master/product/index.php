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
                                                <i class="ft-plus"></i> Add New Product
                                                </a>
                                            </h5>
                                            <!-- <form autocomplete="off" class="form dynamic-tb-search" action="<?=$tb_url?>" method="POST" enctype="multipart/form-data" tagret-tb="#tb"> -->
                                             <div class="row justify-content-center">
                                             <div class="col-md-4">
                                             <div class="form-group">
                                            <label class="control-label">Parent Categories:</label>
                                            <select class="form-control" style="width:100%;" name="parent_id" id="parent_id" onchange="fetch_sub_categories(this.value)">
                                            <option value="">Select</option>
                                            <?php foreach ($parent_cat as $parent) { ?>
                                            <option value="<?php echo $parent->id; ?>" <?php if(!empty($parent_id)) { if($parent_id==$parent->id) {echo "selected"; } }?>>
                                                <?php echo $parent->name; ?>
                                            </option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                            </div>

                                            <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Sub Categories:</label>
                                                <select class="form-control parent_cat_id" style="width: 100%;" name="parent_cat_id" id="parent_cat_id" value="<?= $cat_id ?>">
                                                    <option value="">Select</option>
                                                    <?php if ($cat_id !== 'null') : ?>
                                                        <?php foreach ($sub_cat as $scat) : ?>
                                                            <option value="<?php echo $scat->id; ?>" <?php if (!empty($cat_id) && $cat_id == $scat->id) echo "selected"; ?>>
                                                                <?php echo $scat->name; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>

                                            <div class="col-md-4">
                                                <div class="form-group mb-0">
                                                    <label for="name">Search</label>
                                                    <input type="text" class="form-control input-sm" name="search" id="tb-search" value="<?php if($search!='null'){echo $search;}?>" placeholder="Search..." />
                                                </div>
                                            </div>
                                        </div>
                                    <!-- </form> -->
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
    function select_parent_cat(btn,cat_id1,cat_id2){
    $('#defaultCheck'+cat_id1).prop('checked', true);
    $('#defaultCheck'+cat_id2).prop('checked', true);
   }
   function fetch_sub_categories(parent_id)
   {
    $.ajax({
        url: "<?php echo base_url('fetch_sub_categories'); ?>",
        method: "POST",
        data: {
            parent_id:parent_id //cat1 id
        },
        success: function(data){
            $(".parent_cat_id").html(data);

            var cat_id = $('#parent_cat_id').val(); //cat2 id
            if(parent_id)
            {
                $.ajax({
                    url: "<?php echo base_url('manage-product/tb'); ?>",
                    method: "POST",
                    data: {
                        cat_id:cat_id,
                        parent_id:parent_id,
                    },
                    success: function(data){
                    $("#tb").html(data);
                    },
                });
            }
        },
    });
   };
</script>
<script>
    document.getElementById('parent_cat_id').addEventListener('change', function() {
        fetch_products(this.value);
    });

    function fetch_products(sub_cat_id) {
        var parent_cat_id = document.getElementById('parent_cat_id').value; // Get selected sub-category ID
        var search = document.getElementById('tb-search').value;
        $.ajax({
                url: "<?php echo base_url('manage-product/tb'); ?>",
                method: "POST",
                data: {
                    cat_id: sub_cat_id,     // sub-category ID
                    parent_id: parent_cat_id,    // parent category ID
                    search: search,
                },
                success: function(data) {
                    // console.log(data);
                    $("#tb").html(data);
                },
            });
    }
    
var timer;
        var timeout = 100;
        $(document).on('keyup', '#tb-search', function(event){
            // if(event.keyCode == 13)
            // {
                $("#datatable").html('<div class="text-center"><img src="loader.gif"></div>');
            clearTimeout(timer);
            timer = setTimeout(function(){
                var search  = $('#tb-search').val();
                var parent_id = $('#parent_id').val();
                var parent_cat_id  = $('#parent_cat_id').val();
                var tbUrl = $('[name="tb"]').val();
                $.post(tbUrl,{search:search,
                    parent_id:parent_id,
                    cat_id:parent_cat_id,
                })
                .done(function(data){
                    $('#tb').html(data);
                    if($('#tb-search').val()!== '')
                    {
                        document.getElementById("tb-search").focus();
                        var search  = $('#tb-search').val();
                        $('#tb-search').val('');
                        $('#tb-search').val(search);
                    }  
                })
            }, timeout);

            return false;
            // }
        })
</script>