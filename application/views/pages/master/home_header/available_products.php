
<!-- <p id="success" class="text-success"></p> -->
<input type="hidden" value=<?php echo $headerid; ?> id="headerid">
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
        $flg=0;
        foreach($available_products as $products) { ?>
    <tr>
        <td class="text-center"><img src="<?php echo IMGS_URL.$products->icon; ?>" alt="image" height="100"></td>
        <td class="text-center"><?= $products->pro_name;?><br></td>
        <td class="text-center"><?= $products->pro_code;?></td>
        <?php foreach($headers_mapping as $mapping) 
        {
             if($mapping->value == $products->id)
             {
                     $flg=1;   
             }
        }
        ?>
        <?php if($flg==1)
            {?> 
        <td class="btn btn-danger mt-3 btn-sm" id="changeaction2<?= $products->id ?>">
            <a href="javascript:void(0)" onclick="remove_map_product(<?= $products->id ?>);" style="color:white;"> Remove </a>
        </td>
        <?php } 
            else { ?>
             <td class="btn btn-primary mt-3 btn-sm" id="changeaction2<?= $products->id ?>">
            <a href="javascript:void(0)" onclick="map_product(<?= $products->id ?>);" style="color:white;">Map</a>
            <?php } ?>
        </td>
       
    </tr>
    <?php $flg=0; }?>
    </tbody>
</table>