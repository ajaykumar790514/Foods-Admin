<?php if($count==0){?>
<script type="text/javascript">
$(document).ready(function() {
    $(".validate-form").validate({
        rules: 
        {
            img:"required",
            banner_title:"required",
            seq:"required",                                      
            banner_offer:"required",     
            text_line1:"required",
             link_type:"required",                                      
            link_id:"required",     
            banner_type:"required",
        },
        messages: 
        {
            img:"Please select image",
            banner_title:"Please enter banner title",
            seq:"Please enter banner seq",                                      
            banner_offer:"Please enter banner offer", 
            text_line1:"Please enter banner text line 1",
            link_type:"Please select link type",                                      
            link_id:"Please enter link id",     
            banner_type:"Please select banner type",
        }
    }); 
});
</script>
<?php }else{?>
<script type="text/javascript">
$(document).ready(function() {
    $(".validate-form").validate({
        rules: 
        {
           banner_title:"required",
            seq:"required",                                      
            banner_offer:"required",     
            text_line1:"required",
             link_type:"required",                                      
            link_id:"required",     
            banner_type:"required",
        },
        messages: 
        {
            banner_title:"Please enter banner title",
            seq:"Please enter banner seq",                                      
            banner_offer:"Please enter banner offer", 
            text_line1:"Please enter banner text line 1",
            link_type:"Please select link type",                                      
            link_id:"Please enter link id",     
            banner_type:"Please select banner type",
        }
    }); 
});
</script>
<?php };?>
<div class="card-content collapse show">
    <div class="card-body">
        <form class="form ajaxsubmit validate-form reload-page reload-tb" action="<?=$action_url?>" method="POST" enctype="multipart/form-data">
            <div class="form-body w-100">
                <div class="col-12 p-0">
                    <div class="cards">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="control-label">Banner Image:</label>
                                    <input type="file" class="form-control" name="img">  
                                    <?php 
                                      if(!empty($value->img))
                                      {?>
                                       <img src="<?=IMGS_URL.$value->img;?>" height="80px">
                                      <?php }
                                     ?>                        
                                </div>
                                 <div class="form-group col-md-12">
                                    <label class="control-label">Banner Title:</label>
                                    <input type="text" class="form-control" name="banner_title"   placeholder="Enter banner title"  value="<?=@$value->banner_title;?>">                          
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Banner Seq:</label>
                                    <input type="number" class="form-control" name="seq"   placeholder="Enter banner seq"   value="<?=@$value->seq;?>">                          
                                </div>
                                 <div class="form-group col-md-6">
                                    <label class="control-label">Banner Offer:</label>
                                    <input type="text" class="form-control" name="banner_offer"    value="<?=@$value->banner_offer;?>"  placeholder="Enter banner offer">                          
                                </div>
                               
                                
                                 <div class="form-group col-md-6">
                                    <label class="control-label">Text Line 1:</label>
                                    <input type="text" class="form-control" name="text_line1"    value="<?=@$value->text_line1;?>"  placeholder="Enter banner text line 1">                          
                                </div>
                                 <div class="form-group col-md-6">
                                    <label class="control-label">Text Line 2:</label>
                                    <input type="text" class="form-control" name="text_line2"    value="<?=@$value->text_line2;?>"  placeholder="Enter banner text line 2">                          
                                </div>
                                 <div class="form-group col-md-6">
                                    <label class="control-label">Text Line 3:</label>
                                    <input type="text" class="form-control" name="text_line3"    value="<?=@$value->text_line3;?>"  placeholder="Enter banner text line 3">                          
                                </div>
                                 <div class="form-group col-md-6">
                                    <label class="control-label">Text Line 4:</label>
                                    <input type="text" class="form-control" name="text_line4"    value="<?=@$value->text_line4;?>"  placeholder="Enter banner text line 4">                          
                                </div>
                                 <div class="form-group col-md-6">
                                    <label class="control-label">Link Type:</label>
                                    <select class="form-control" name="link_type" >
                                        <option>--select type--</option>
                                        <option value="product" <?php if(@$value->link_type=='product'){echo "selected";} ;?>>Product</option>
                                        <option value="category" <?php if(@$value->link_type=='category'){echo "selected";} ;?>>Category</option>
                                    </select>                        
                                </div>
                                 <div class="form-group col-md-6">
                                    <label class="control-label">Link ID:</label>
                                    <input type="text" class="form-control" name="link_id"    value="<?=@$value->link_id;?>"  placeholder="Enter banner link id">                          
                                </div>
                                 <div class="form-group col-md-12">
                                    <label class="control-label">Banner Type:</label>
                                    <select class="form-control" name="banner_type" >
                                        <option>--select type--</option>
                                        <option value="1" <?php if(@$value->banner_type=='1'){echo "selected";} ;?>>Top Banner</option>
                                        <option value="1" <?php if(@$value->banner_type=='0'){echo "selected";} ;?>>Other Banner</option>
                                    </select>                        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions text-right">
            <button type="reset" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-primary waves-light" ><i id="loader" class=""></i>Add</button>
            </div>
           </form>
        <!-- End: form -->

    </div>
</div>