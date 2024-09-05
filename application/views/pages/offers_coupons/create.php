
<script type="text/javascript">
$(document).ready(function() {
    $(".validate-form").validate({
        rules: {   
            title:{
                required:true,
                remote:"<?=$remote?>null/title"
            },
            description:"required",
            discount_type:"required",
            value:"required",
            expiry_date:"required",
            start_date:"required",
        },
        messages: {
            title: {
                required : "Please Enter Title.",
                remote : "Title already exists!"
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
                            
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label">Title</label>
                                    <input type="text" class="form-control" name="title">
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label">Discount Type:</label>
                                    <select class="form-control" style="width:100%;" name="discount_type">
                                        <option value="">--Select--</option>
                                        <option value="0">Fixed</option>
                                        <option value="1">Percentage</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label">Value:</label>
                                    <input type="number" class="form-control" name="value">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label">Image:</label>
                                    <input type="file" name="photo" class="form-control"
                    size="55550" accept=".png, .jpg, .jpeg, .gif" >
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label">Start Date:</label>
                                    <input type="date" name="start_date" id="start_date" min="<?= date('Y-m-d'); ?>" class="form-control" onchange="validate_date()">
                                    <div id="msg"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label">Expiry Date:</label>
                                    <input type="date" name="expiry_date" id="expiry_date" min="<?= date('Y-m-d'); ?>" class="form-control" onchange="validate_date()">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="control-label">Description:</label>
                                    <textarea cols="92" rows="5" class="form-control" name="description"></textarea>
                                </div>
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

<script>
 function validate_date() {
    var start_date = new Date($("#start_date").val());
    var expiry_date = new Date($("#expiry_date").val());
    var current_date = new Date();

    // Check if start_date is in the past
    if (start_date < current_date) {
        msg = "Start date cannot be in the past.";
        document.getElementById('msg').style.color = 'red';
        document.getElementById('msg').innerHTML = msg;
        return false;
    }

    // Check if start_date is greater than or equal to expiry_date
    if (start_date >= expiry_date) {
        msg = "Start date should be less than expiry date.";
        document.getElementById('msg').style.color = 'red';
        document.getElementById('msg').innerHTML = msg;
        return false;
    }

    // Check if expiry_date is greater than start_date
    if (expiry_date <= start_date) {
        msg = "End date should be greater than start date.";
        document.getElementById('msg').style.color = 'red';
        document.getElementById('msg').innerHTML = msg;
        return false;
    }

    // If everything is valid, clear the error message
    document.getElementById('msg').innerHTML = "";

    // If everything is valid, allow form submission
    return true;
}


</script>
 