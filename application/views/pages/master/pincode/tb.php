<div class="card-block table-border-style">
        <div class="table-responsive">
            <table class="table" >
                <thead>
                    <tr>
                        <th class="sr_no">Sr. no.</th>
                        <th>Pincode</th>
                        <th>Price</th>
                        <th>Kilometer</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
                <?php $i=$page;
                   foreach ($pincode as $row) {
                ?>
               <tr>
                    <td class="sr_no"><?=++$i?></td>
                    <td><?=$row->pincode?></td>
                     <td><?php echo $row->price;?></td>
                     <td><?php echo $row->kilometer;?></td>
                     <td class="text-center">
                       <span class="changeStatus" style="font-size:1.3rem;" data-toggle="change-status" value="<?=($row->active==1) ? 0 : 1?>" data="<?=$row->id?>,pincodes_criteria,id,active" ><i class="<?=($row->active==1) ? 'ti-check-box text-success' : 'ti-na text-danger'?>" title="Click for chenage status"></i></span>
                   </td>

                    <td> 
                       <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Category (<?=$row->pincode?>)" data-url="<?=$update_url?><?=$row->id?>" title="Update">
                           <i class="fa fa-pencil-square" style="font-size:1.3rem;"></i>
                       </a>

                       <a href="javascript:void(0)" onclick="_delete(this)" url="<?=$delete_url?><?=$row->id?>" title="Delete" >
                           <i class="fa fa-trash text-danger" style="font-size:1.3rem;"></i>
                       </a>
                    </td>
               </tr> 
                   <?php }?>
                </tbody>
            </table>
        </div>
         <div class="row">
                           <div class="col-md-6 text-left">
                           <span>Showing <?= (@$pincode) ? $page+1 : 0 ?> to <?=$i?> of <?=$total_rows?> entries</span>
                             </div>
                                <div class="col-md-6 text-right">
                                    <?=$links?>
                                </div>
                                  </div>
</div>
                                     

       