<script type="text/javascript">
$(document).ready(function() {
    $(".validate-form").validate({
        rules: {
            <?php if($count==0){?>
            icon:"required",
            <?php }?>
            name:"required",
            description:"required",                                      
            seq:"required",     
        },
        messages: {
            <?php if($count==0){?>
            icon:"Please select image",
            <?php }?>
            description:"Please enter description",                                      
            seq:"Please enter seq", 
            name: {
                required : "Please enter name!",
            }
        }
    }); 
});
</script>
<div class="card-content collapse show">
    <div class="card-body">
        <form class="form ajaxsubmit validate-form reload-page reload-tb" action="<?=$action_url?>" method="POST" enctype="multipart/form-data">
            <div class="form-body w-100">
                <div class="col-12 p-0">
                    <div class="cards">
                        <div class="card-body">
                            <div class="row">
                            <div class="form-group col-md-6">
                            <label class="control-label">Parent Category:</label>
                            <select class="form-control select2" style="width:100%;" name="parent_id">
                                <option value="">--Select--</option>
                                <?php foreach ($parent_cat as $parent) { ?>
                                <option value="<?php echo $parent->id; ?>" <?php if($parent->id==@$value->is_parent){ echo "selected";} ;?>>
                                    <?php echo $parent->name; ?>
                                </option>
                                <?php } ?>
                            </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Category Name:</label>
                                <input type="text" class="form-control" name="name"  value="<?=@$value->name;?>">                        
                            </div>

                            <div class="form-group col-md-6">
                                <label class="control-label">Sequence:</label>
                                <input type="number" class="form-control" name="seq"  value="<?=@$value->seq;?>">                          
                            </div>

                            
                            <div class="form-group col-md-6">
                            <label for="recipient-name" class="control-label">Image</label>
                           <input type="file" class="form-control" name="icon"  value="<?=@$value->icon;?>">  
                            <?php if(@$value->icon !='')
                            {?>
                            <img class="float-right" src="<?=IMGS_URL.@$value->icon;?>" height="70px">
                                                    
                            <?php }?>
                            </div>

                             <div class="form-group col-md-12">
                                <label class="control-label">Show in Header:</label>
                                <select class="form-control" name="header_type">
                                    <option>--Select--</option>
                                    <option value="YES">YES</option>
                                     <option value="NO">NO</option>
                                </select>                        
                            </div>
                            <div class="form-group col-md-12">
                            <label class="control-label">Description:</label>
                            <textarea class="form-control"  name="description"  rows="3"><?=@$value->description;?></textarea>
                          
                            </textarea>                        
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
