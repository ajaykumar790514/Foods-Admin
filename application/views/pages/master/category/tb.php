 <div class="card-block table-border-style">
        <div class="table-responsive">
          <table class="table" >
             <thead>
                 <tr>
                   <th class="sr_no">Sr. no.</th>
                   <th>Name</th>
                   <th>Image</th>
                   <th>Desc</th>
                   <th>Sequence</th>
                   <th>Status</th>
                    <th>Actions</th>
                  </tr>
             </thead>
             <tbody>
                <?php $i=$page;
                   foreach ($rows as $row) {
                    if($row->is_parent=="0")
                    {
                ?>
               <tr>
                    <td class="sr_no"><?=++$i?></td>
                    <td><?=$row->name?></td>
                    <td>
                     <?php if(!empty($row->icon)) { ?>
                    <img  src="<?php echo IMGS_URL.$row->icon;?>" alt="<?php echo $row->name;?>" height="50" width="50" data-toggle="modal" data-target="#exampleModal<?php echo $row->id;?>">
                    <div class="modal fade" id="exampleModal<?php echo $row->id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                         <div class="modal-header"><?php echo $row->name;?></div>   
                        <div class="modal-body">
                        <img  src="<?php echo IMGS_URL.$row->icon;?>" alt="<?php echo $row->name;?>" height="100%" width="100%" >
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
                        <?php if(strlen($row->description) > 15){ ?>   
                            .... <button class="btn btn-primary btn-sm mt-2" data-toggle="modal" data-target="#read-desc<?php echo $row->id; ?>">Read More</button>
                        <?php } ?>
                        </td>
                     <td><?=$row->seq?></td>
                    <td class="text-center">
                       <span class="changeStatus" style="font-size:1.3rem;" data-toggle="change-status" value="<?=($row->active==1) ? 0 : 1?>" data="<?=$row->id?>,category,id,active" ><i class="<?=($row->active==1) ? 'ti-check-box text-success' : 'ti-na text-danger'?>" title="Click for chenage status"></i></span>
                   </td>

                    <td> 
                       <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Category (<?=$row->name?>)" data-url="<?=$update_url?><?=$row->id?>" title="Update">
                           <i class="fa fa-pencil-square" style="font-size:1.3rem;"></i>
                       </a>

                       <a href="javascript:void(0)" onclick="_delete(this)" url="<?=$delete_url?><?=$row->id?>" title="Delete" >
                           <i class="fa fa-trash text-danger" style="font-size:1.3rem;"></i>
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
    <?php //echo $categories;
                                                 foreach($categories as $cat)
                                                 {
                                                        if($cat->is_parent==$row->id)
                                                        { ?>
                                                         <tr class="jsgrid-filter-row">
                                                    <th></th>
                                                    <td><p class="text-xs"><i class="fa fa-arrow-right ml-5"></i><?php echo $cat->name;?> </p></td>
                                                    <td>
                                                  
                
                                                        <?php if(!empty($cat->thumbnail)) { ?>
                                                            <img  src="<?php echo IMGS_URL.$cat->icon;?>" alt="<?php echo $cat->name;?>" height="50" width="50" data-toggle="modal" data-target="#exampleModal<?php echo $cat->id;?>">
                                                            <div class="modal fade" id="exampleModal<?php echo  $cat->id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                            <div class="modal-content">
                                                             <div class="modal-header"><?php echo $cat->name;?></div>   
                                                            <div class="modal-body">
                                                            <img   src="<?php echo IMGS_URL.$cat->icon;?>" alt="<?php echo $cat->name;?>" height="100%" width="100%" >
                                                            </div>
                                                            <div class="modal-footer"></div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                        <?php } ?> 
                                                    </td>
                                                    <td>
                                                    <?php $desc = strip_tags( $cat->description);
                                                    $desc = substr($desc,0,15);
                                                    echo $desc; ?>&nbsp;&nbsp;

                                                    <?php if(strlen($cat->description) > 15){ ?>   
                                                        .... <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#read-desc<?php echo $cat->id; ?>">Read More</button>
                                                    <?php } ?>
    
                                                    </td>
                                                    <td><?php echo $cat->seq;?></td>
                                                    <td class="text-center">
                                                        <span class="changeStatus" style="font-size:1.3rem;" data-toggle="change-status" value="<?=($cat->active==1) ? 0 : 1?>" data="<?=$cat->id?>,category,id,active" ><i class="<?=($cat->active==1) ? 'ti-check-box text-success' : 'ti-na text-danger'?>" title="Click for chenage status"></i></span>
                                                    </td>
                                                    <td> 
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Category (<?=$cat->name;?>)" data-url="<?=$update_url?><?=$cat->id?>" title="Update">
                                                   <i class="fa fa-pencil-square" style="font-size:1.3rem;"></i>
                                                </a>

                                                <a href="javascript:void(0)" onclick="_delete(this)" url="<?=$delete_url?><?=$cat->id?>" title="Delete" >
                                                    <i class="fa fa-trash text-danger" style="font-size:1.3rem;"></i>
                                                </a>
                                                </td>
                                                    <!--Read Description modal-->
                                                <div id="read-desc<?php echo $cat->id; ?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Description</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <?php echo $cat->description; ?>
                                                            </div>
                                                            <div class="modal-footer">
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                    <!--/Read Description modal-->
                                    </tr> 
                                   <?php  }   } } }?>   
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

       