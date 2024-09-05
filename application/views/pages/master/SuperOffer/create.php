<?php if($count==0){?>
<script type="text/javascript">
$(document).ready(function() {
    $(".validate-form").validate({
        rules: 
        {
            img:"required",
            title:"required",
            seq:"required",                                      
            description:"required",     
            start_date:"required",
            end_date:"required",  
              product_id:"required",
        },
        messages: 
        {
            img:"Please select image",
            banner_title:"Please enter banner title",
            seq:"Please enter banner seq",                                      
            description:"Please enter description", 
            start_date:"Please enter banner text line 1",
            end_date:"Please select link type",  
              product_id:"Please select product",   
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
            title:"required",
            seq:"required",                                      
            description:"required",     
            start_date:"required",
            end_date:"required", 
            product_id:"required",
        },
        messages: 
        {
            banner_title:"Please enter banner title",
            seq:"Please enter banner seq",                                      
            description:"Please enter description", 
            start_date:"Please enter banner text line 1",
            end_date:"Please select link type", 
             product_id:"Please select product", 
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
                                <div class="form-group col-md-6">
                                    <label class="control-label">Image:</label>
                                    <input type="file" class="form-control" name="img">  
                                    <?php 
                                      if(!empty($value->img))
                                      {?>
                                       <img src="<?=IMGS_URL.$value->img;?>" height="80px">
                                      <?php }
                                     ?>                        
                                </div>
                                  <div class="form-group col-md-6">
                                    <label class="control-label">Product:</label>
                                    <select class="form-control select2" name="product_id" id="product_id">
                                    <option>--Select--</option>
                                    <?php foreach($products as $product):?>
                                    <option value="<?=$product->id;?>" <?php if(@$value->product_id==$product->id){echo "selected";} ;?>  ><?=$product->pro_name;?> ( <?=$product->pro_code;?> ) </option>
                                    <?php endforeach;?>
                                     </select>                          
                                </div>
                                 <div class="form-group col-md-6">
                                    <label class="control-label">Title:</label>
                                    <input type="text" class="form-control" name="title"   placeholder="Enter  title"  value="<?=@$value->title;?>">                          
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Seq:</label>
                                    <input type="number" class="form-control" name="seq"   placeholder="Enter  seq"   value="<?=@$value->seq;?>">                          
                                </div>
                                 <div class="form-group col-md-6">
                                    <label class="control-label">Start Date:</label>
                                    <input type="datetime-local" class="form-control" name="start_date"    value="<?=@$value->start_date;?>" id="start_date" onchange="validateDates()"  >                          
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">End Date:</label>
                                    <input type="datetime-local" class="form-control" name="end_date" id="end_date" value="<?=@$value->end_date;?>" onchange="validateDates()">                          
                                </div>
                                 <div class="form-group col-md-12">
                                    <label class="control-label">Description:</label>
                                    <textarea class="form-control" name="description"  placeholder="Enter description"><?=@$value->description;?></textarea>                          
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions text-right">
            <button type="reset" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
    <button id="submitBtn" type="submit" class="btn btn-primary waves-light" ><i id="loader" class=""></i>Add</button>
            </div>
           </form>
        <!-- End: form -->

    </div>
</div>


<script>
    function validateDates() {
        var startDate = document.getElementById('start_date').value;
        var endDate = document.getElementById('end_date').value;
        // Convert string values to date objects
        var startDateObj = new Date(startDate);
        var endDateObj = new Date(endDate);

        // Get the current date
        var currentDate = new Date();

        // Error flag
        var error = false;

        // Compare start date with current date
        if (startDateObj < currentDate) {
            alert_toastr("error", "Start date cannot be in the past.");
            document.getElementById('start_date').value = "";
            error = true;
        }

        // Compare end date with start date
        if (endDateObj < startDateObj) {
            alert_toastr("error", "End date cannot be before the start date.");
            document.getElementById('end_date').value = "";
            error = true;
        }

        // Disable or enable the button based on error flag
        if (error) {
            document.getElementById('submitBtn').disabled = true;
        } else {
            document.getElementById('submitBtn').disabled = false;
        }
    }
</script>