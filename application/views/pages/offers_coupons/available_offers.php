<div class="modal-header">
    <b>Add Offer</b>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">

<table class="table" style="border:1px solid black">
<thead class="thead-light">
    <tr style="border:1px solid black">
        <th class="text-center">Title</th>
        <th class="text-center">Value</th>
        <th class="text-center">Action</th>
    </tr>
    </thead>
    <tbody>
        <?php $flg=0;
        foreach($offers as $offer) { if($offer->active == '1') {?>
    <tr>
        <td class="text-center"><?= $offer->title;?></td>
        <td class="text-center"><?= $offer->value; if($offer->discount_type == '1') {echo "%";} else{echo " ₹";} ?></td>
        <?php foreach($offer_list as $val) 
        {
             if($val->product_id == $pid && $val->offer_assosiated_id == $offer->id)
             {
                     $flg=1;   
             }
        }
        ?>
        <td class="text-center" id="changeaction<?= $offer->id ?>">
        <?php  if($flg==1)
            {?> 
        <a class="btn btn-sm btn-danger" data-dismiss="modal" href="javascript:void(0)" onclick="remove_offer(<?= $offer->id.','.$offer->value.','.$offer->discount_type;?>)">Remove</a>
        <?php } 
            else { ?>
      <a class="btn btn-sm btn-success"  data-dismiss="modal" href="javascript:void(0)" onclick="add_offer(<?= $offer->id.','.$offer->value.','.$offer->discount_type;?>)" >Apply</a>
      <?php } ?>
          <!-- <a class="btn btn-sm btn-success"  data-dismiss="modal" href="javascript:void(0)" onclick="add_offer(<?= $offer->id.','.$offer->value.','.$offer->discount_type;?>)" >Apply</a> -->
        </td>
       
    </tr>
    
    <?php $flg=0; } }?>
    </tbody>
</table>
<input type="hidden" value="<?php echo $pid; ?>" id="pid">

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
</div>
        
<script type="text/javascript">
   function add_offer(oid,value,discount_type)
   {
    if(confirm('Are you sure?') == true)
        {
           var parent_cat_id = $('#parent_cat_id').val();
           var parent_id = $('#parent_id').val();
            var pid = $('#pid').val();
            if(parent_cat_id=='')
            {
                catid = parent_id;
            }else
            {
                catid = parent_cat_id;
            }
            $.ajax({
                url: "<?php echo base_url('offers-coupons/add_offer'); ?>",
                method: "POST",
                data: {
                    oid:oid,
                    pid:pid,
                    value:value,
                    discount_type:discount_type,
                    parent_cat_id:parent_cat_id,
                    parent_id:parent_id
                },
                success: function(data){
                    if(data == 'false') 
                    {
                        alert('Offer is already exist on this product.Kindly remove existing offer.');
                    }
                    else
                    {
                        $("#changeaction"+oid).html(data);
                          $.ajax({
                            url: "<?php echo base_url('offers-coupons/fetch_products'); ?>",
                            method: "POST",
                            data: {
                                parent_cat_id:catid,
                                
                            },
                            success: function(data){
                                    $("#available_products").html(data);
                                
                            },
                        });
                    }
                    
                },
            });
        }
   }
</script>
<script type="text/javascript">
   function remove_offer(oid,value,discount_type)
   {
    if(confirm('Are you sure?') == true)
    {
        var parent_cat_id = $('#parent_cat_id').val();
        var parent_id = $('#parent_id').val();
        var pid = $('#pid').val();
        if(parent_cat_id=='')
            {
                catid = parent_id;
            }else
            {
                catid = parent_cat_id;
            }
        $.ajax({
            url: "<?php echo base_url('offers-coupons/remove_offer'); ?>",
            method: "POST",
            data: {
                oid:oid,
                pid:pid,
                value:value,
                discount_type:discount_type,
                parent_cat_id:parent_cat_id,
                parent_id:parent_id
            },
            success: function(data){
                $("#changeaction"+oid).html(data);
                  $.ajax({
                            url: "<?php echo base_url('offers-coupons/fetch_products'); ?>",
                            method: "POST",
                            data: {
                                parent_cat_id:catid,
                            },
                            success: function(data){
                                    $("#available_products").html(data);
                                
                            },
                        });
            },
        });
    }
   }
</script>












