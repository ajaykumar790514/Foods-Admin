<style>
    .my-checkbox {
        border: 1px solid #6c757d;
        border-radius: 4px;
        margin-right: 5px;
        width: 18px;
        height: 18px;
    }
    .form-check-label {
        padding-left: 5px;
    }
    .my-checkbox:checked {
        background-color: #007bff;
        border-color: #007bff;
    }
</style>

<?php if($count==0){?>
<script type="text/javascript">
$(document).ready(function() {
    $(".validate-form").validate({
        rules: 
        {
            icon:"required",
            name:"required",
            description:"required",                                      
            category:"required",     
            mrp:"required",
            selling_price:"required",
        },
        messages: 
        {
            icon:"Please select image",
            description:"Please enter description",
            mrp:"Please enter MRP",                                      
            category:"Please select category", 
            selling_price:"Please enter selling price",
            name: {
                required : "Please enter name!",
            }
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
            name:"required",
            description:"required",    
            category:"required", 
            mrp:"required",
            selling_price:"required",
        },
        messages: 
        {
            description:"Please enter description",
            mrp:"Please enter MRP",                                      
            category:"Please select category", 
            selling_price:"Please enter selling price",
            name: {
                required : "Please enter name!",
            }
        }
    }); 
});
</script>
<?php }?>
<div class="card-content collapse show">
    <div class="card-body">
        <form class="form ajaxsubmit validate-form reload-page reload-tb" action="<?=$action_url?>" method="POST" enctype="multipart/form-data">
            <div class="form-body w-100">
                <div class="col-12 p-0">
                    <div class="cards">
                        <div class="card-body">
                        <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="control-label">Categories:</label>
                                <div class="parent_cat_id" id="parent_cat_id" style="height: 200px; overflow: scroll;">
                                    <?php foreach ($parent_cat as $row): ?>
                                        <div class="form-check">
                                            <input class="my-checkbox" value="<?= $row->id; ?>" name="cat_id[]" id="defaultCheck<?= $row->id; ?>" type="checkbox">
                                            <label class="form-check-label" for="defaultCheck<?= $row->id; ?>"><?= $row->name; ?></label>
                                        </div>
                                        <?php foreach ($categories as $row2): ?>
                                            <?php if ($row->id == $row2->is_parent): ?>
                                                <div class="form-check ml-4">
                                                    <input class="my-checkbox" type="checkbox" value="<?= $row2->id; ?>" name="cat_id[]" onclick="select_parent_cat(this, <?= $row->id; ?>)" id="defaultCheck<?= $row2->id; ?>">
                                                    <label class="form-check-label" for="defaultCheck<?= $row2->id; ?>"><?= $row2->name; ?></label>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                            <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Product Name:</label>
                                <input type="text" class="form-control" name="pro_name"    value="<?=@$value->pro_name;?>">                          
                            </div>
                            <div class="form-group col-md-6">
                            <label for="recipient-name" class="control-label">Image</label>
                           <input type="file" class="form-control" name="icon"  value="<?=@$value->icon;?>">  
                            <?php if(@$value->icon !='')
                            {?>
                            <img class="float-right" src="<?=IMGS_URL.@$value->icon;?>" height="70px">
                                                    
                            <?php }?>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">MRP:</label>
                                <input type="number" class="form-control" name="mrp"    value="<?=@$value->mrp;?>">                          
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Selling Price:</label>
                                <input type="number" class="form-control" name="selling_price"    value="<?=@$value->selling_rate;?>">                          
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">TAX(%):</label>
                                <input type="number" class="form-control" name="tax"    value="<?=@$value->pro_tax;?>">                          
                            </div>
                            <div class="form-group col-md-12">
                            <label class="control-label">Description:</label>
                            <textarea class="form-control"  name="description" id="editor" rows="3"  data-parsley-trigger="change"><?=@$value->description;?></textarea>                       
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Meta Title:</label>
                                <input type="text" class="form-control" name="meta_title"    value="<?=@$value->meta_title;?>">                          
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">Meta Keywords:</label>
                                <input type="text" class="form-control" name="meta_key"    value="<?=@$value->meta_keyword;?>">                          
                            </div>
                            <div class="form-group col-md-12">
                                <label class="control-label">Meta Description:</label>
                                <input type="text" class="form-control" name="meta_desc"    value="<?=@$value->meta_description;?>">                          
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
CKEDITOR.replace( 'editor', {
toolbar: [
{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
'/',
{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
'/',
{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
{ name: 'others', items: [ '-' ] },
]
});
</script>
<script>
    $(document).ready(function() {
            $('#category').change(function() {
                var category_id = $(this).val();
                var sub_cat_id = $('#sub_cat_id').val();
                $.ajax
                ({
                    url: '<?= base_url('Master/loadSubcategories'); ?>',
                    type: 'POST',
                    data: { category_id: category_id, sub_cat_id: sub_cat_id },
                    success: function(data) 
                    {
                        $('#subcat_id').html(data);
                    }
                });
            });
        });
</script>