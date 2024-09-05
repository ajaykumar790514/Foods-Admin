<div class="card-block table-border-style">
        <div class="table-responsive">
            <table class="table" >
                <thead>
                    <tr>
                        <th class="sr_no">Sr. no.</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Desc</th>
                        <th>MRP</th>
                        <th>Selling Rate</th>
                        <th>TAX(%)</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
                <?php $i=$page;
                   foreach ($products as $row) {
                ?>
               <tr>
                    <td class="sr_no"><?=++$i?></td>
                    <td>
                    <?php 
                    foreach ($cat_pro_map as $cat) {
                        if($cat->pro_id == $row->id){
                            echo '('.$cat->name.') <br>';
                        } 
                        
                    }?>
                    </td>
                    <td><?=$row->pro_name?></td>
                   
                    <td>
                     <?php if(!empty($row->icon)) { ?>
                    <img  src="<?php echo IMGS_URL.$row->icon;?>" alt="<?php echo $row->pro_name;?>" height="50" width="50" data-toggle="modal" data-target="#exampleModal<?php echo $row->id;?>">
                    <div class="modal fade" id="exampleModal<?php echo $row->id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header"><?php echo $row->pro_name;?></div>   
                            <div class="modal-body">
                                <img  src="<?php echo IMGS_URL.$row->icon;?>" alt="<?php echo $row->pro_name;?>" height="100%" width="100%" >
                            </div>
                            <div class="modal-footer"></div>
                            </div>
                        </div>
                    </div>
                     <?php } ?> 
                     </td>
                     <td><?php $desc = strip_tags( $row->description);
                        $desc = substr($desc,0,15);
                        echo $desc; ?>
                        <?php if(strlen($row->description) > 15)
                        { ?>   
                            .... <button class="btn btn-primary btn-sm mt-2" data-toggle="modal" data-target="#read-desc<?php echo $row->id; ?>">Read More</button>
                        <?php } ?>
                        </td>
                     <td><?php echo $row->mrp;?></td>
                     <td><?php echo $row->selling_rate;?></td>
                     <td><?php echo $row->pro_tax;?></td>
                     <td class="text-center">
                       <span class="changeStatus" style="font-size:1.3rem;" data-toggle="change-status" value="<?=($row->status==1) ? 0 : 1?>" data="<?=$row->id?>,products,id,status" ><i class="<?=($row->status==1) ? 'ti-check-box text-success' : 'ti-na text-danger'?>" title="Click for chenage status"></i></span>
                   </td>

                    <td> 
                       <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Category (<?=$row->pro_name?>)" data-url="<?=$update_url?><?=$row->id?>" title="Update">
                           <i class="fa fa-pencil-square" style="font-size:1.3rem;"></i>
                       </a>

                       <a href="javascript:void(0)" onclick="_delete(this)" url="<?=$delete_url?><?=$row->id?>" title="Delete" >
                           <i class="fa fa-trash text-danger" style="font-size:1.3rem;"></i>
                       </a>
                       <a class="btn btn-success btn-sm mt-1" title="Product Mapping" href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Map Products ( <?=$row->pro_name?> )" data-url="<?=$map_url?><?=$row->id?>" >
                        Mapping
                    </a> 
                    </td>
               </tr> 
                <!--Read Description modal-->
                <div class="modal fade" id="read-desc<?php echo $row->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog  modal-lg"  role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                           <b style="color:black">Description</b>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>  </div>
                        <div class="modal-body">
                      <b><?php echo $row->description; ?></b>
                           </div>
                        </div>
                        </div>
                    </div>
                    </div>
    <!--/Read Description modal-->
                                   <?php }?>
                </tbody>
            </table>
        </div>
         <div class="row">
                           <div class="col-md-6 text-left">
                           <span>Showing <?= (@$products) ? $page+1 : 0 ?> to <?=$i?> of <?=$total_rows?> entries</span>
                             </div>
                                <div class="col-md-6 text-right">
                                    <?=$links?>
                                </div>
                                  </div>
</div>
                                     

       