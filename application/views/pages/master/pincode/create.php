
<script type="text/javascript">
$(document).ready(function() {
    $(".validate-form").validate({
        rules: 
        {
            pincode:"required",
            price:"required",
            km:"required",          
        },
        messages: 
        {                                     
            km:"Please enter km", 
            price:"Please enter  price",
            pincode: {
                required : "Please enter pincode!",
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
                                <div class="form-group col-md-4">
                                    <label class="control-label">Pincode:</label>
                                    <input type="number" class="form-control" name="pincode"    value="<?=@$value->pincode;?>">                          
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Price:</label>
                                    <input type="number" class="form-control" name="price"    value="<?=@$value->price;?>">                          
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Kilometer:</label>
                                    <input type="number" class="form-control" name="km"    value="<?=@$value->kilometer;?>">                          
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