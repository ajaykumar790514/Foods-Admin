<!-- <p id="success" class="text-success"></p> -->

<table class="table" style="border:1px solid black">
<thead class="thead-light">
    <tr style="border:1px solid black">
        <th class="text-center">Image</th>
        <th class="text-center">Product Name</th>
        <th class="text-center">Product Code</th>
        <th class="text-center">Action</th>
    </tr>
    </thead>
    <tbody>
        <?php
        foreach($available_products as $products) { 
            ?>
    <tr>
        <td class="text-center"><img src="<?php echo IMGS_URL.$products->thumbnail; ?>" alt="image" height="100"></td>

        <?php   $offer_name = '';
        foreach($offer_products as $val) { if($val->prod_id == $products->prod_id) { $offer_name = "[".$val->title."]"; } }?>
        <td class="text-center"><?= $products->pro_name;?> <strong style="color: red;"><?= $offer_name;?></strong></td>
        <td class="text-center"><?= $products->pro_code;?></td>
        <td class="text-center">
        
        <a class="btn btn-sm btn-primary" data-toggle="modal" href="#" data-target="#available_offers" onclick="available_offers(<?= $products->id;?>)">Apply Offer</a>

      
        </td>
    </tr>
    <div id="available_offers" class="modal  bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog  modal-lg">
                                                            <div class="modal-content" id="available_offers_list">
                                                                
                                                                
                                                            </div>
                                                        </div>
                                                    </div> 
    <?php $flg=0; } ?>
    </tbody>
</table>
<script type="text/javascript">
   function available_offers(pid)
   {
    $.ajax({
        url: "<?php echo base_url('offers-coupons/available_offers'); ?>",
        method: "POST",
        data: {
            pid:pid
        },
        success: function(data){
            $("#available_offers_list").html(data);
        },
    });
   }
</script>
<script type="text/javascript">
   function available_offers_cat()
   {
    var parent_id = $('#parent_id').val();
    var parent_cat_id = $('#parent_cat_id').val();
    if(parent_cat_id=='')
            {
                catid = parent_id;
            }else
            {
                catid = parent_cat_id;
            }
    $.ajax({
        url: "<?php echo base_url('offers-coupons/available_offers_cat'); ?>",
        method: "POST",
        data: {
            parent_cat_id:catid
        },
        success: function(data){
            $("#available_offers_list_cat").html(data);
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
   function remove_offers_cat()
   {
    if(confirm('Are you sure?') == true)
    {
        var parent_id = $('#parent_id').val();
    var parent_cat_id = $('#parent_cat_id').val();
    if(parent_cat_id=='')
            {
                catid = parent_id;
            }else
            {
                catid = parent_cat_id;
            }
    $.ajax({
        url: "<?php  echo base_url('offers-coupons/remove_offer_cat'); ?>",
        method: "POST",
        data: {
            parent_cat_id:catid
        },
        success: function(data){
                //$("#changeaction"+oid).html(data);
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