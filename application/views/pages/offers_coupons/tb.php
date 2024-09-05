<div class="card-block table-border-style">
        <div class="table-responsive">
            <table class="table" >
                <thead>
                    <tr>
                        <th class="sr_no">Sr. no.</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Value</th>
                        <th>Start date</th>
                        <th>Expiry date</th>
                        <th>Photo</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
                <?php $i=$page;
                   foreach ($rows as $row) {
                ?>
               <tr>
                    <td class="sr_no"><?=++$i?></td>
                    <td><?=$row->title?></td>
                     <td><?php $desc = strip_tags( $row->description);
                        $desc = substr($desc,0,15);
                        echo $desc; ?>
                        <?php if(strlen($row->description) > 15){ ?> 
                        .... <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#read-desc<?php echo $row->id; ?>">Read More</button>
                        <?php } ?>
                     </td>
                     <td><?php if($row->discount_type == '0'){echo "Rs";}  echo   ''.$row->value; if($row->discount_type == '1') {echo "%";} else{echo '';} ?></td>
                    <td><?php echo date('d-m-Y',strtotime($row->start_date));?></td>
                    <td><?php echo date('d-m-Y',strtotime($row->expiry_date));?></td>
                    <td class="jsgrid-cell jsgrid-align-center">
                    <?php
                        if (!empty($row->photo)) {
                    ?>
                            <img src="<?php echo IMGS_URL . $row->photo; ?>" alt="cover" height="50">
                    <?php
                        } else {
                            $name = $row->title;
                            $initial = strtoupper(substr($name, 0, 1));
                    ?>
                            <div style="width: 50px; height: 50px; background-color: #333; color: #fff; text-align: center; line-height: 50px; font-size: 20px; font-weight: bold;">
                                <?php echo $initial; ?>
                            </div>
                    <?php
                        }
                    ?>
                    </td>
                     <td class="text-center">
                       <span class="changeStatus" style="font-size:1.3rem;" data-toggle="change-status" value="<?=($row->active==1) ? 0 : 1?>" data="<?=$row->id?>,coupons_and_offers,id,active" ><i class="<?=($row->active==1) ? 'ti-check-box text-success' : 'ti-na text-danger'?>" title="Click for chenage status"></i></span>
                   </td>

                    <td> 
                       <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Offer (<?=$row->title?>)" data-url="<?=$update_url?><?=$row->id?>" title="Update">
                           <i class="fa fa-pencil-square" style="font-size:1.3rem;"></i>
                       </a>

                       <a href="javascript:void(0)" onclick="_delete(this)" url="<?=$delete_url?><?=$row->id?>" title="Delete" >
                           <i class="fa fa-trash text-danger" style="font-size:1.3rem;"></i>
                       </a>
                    </td>
               </tr> 
                  <!--Read Description modal-->
            <div id="read-desc<?php echo $row->id; ?>" class="modal  bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog  modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <b>Description</b>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <?php echo $row->description; ?>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    
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
            <span>Showing <?= (@$rows) ? $page+1 : 0 ?> to <?=$i?> of <?=$total_rows?> entries</span>
            </div>
            <div class="col-md-6 text-right">
            <?=$links?>
        </div>
    </div>
</div>
                                     

       