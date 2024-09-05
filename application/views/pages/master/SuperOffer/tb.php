<div class="card-block table-border-style">
        <div class="table-responsive">
            <table class="table" >
                <thead>
                    <tr>
                        <th class="sr_no">Sr. no.</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Description</th>
                        <th>Seq</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
                <?php $i=$page;
                   foreach ($rows as $row) {
                ?>
               <tr>
                    <td class="sr_no"><?=++$i?></td>
                    <td><img src="<?=IMGS_URL.$row->thumbnail;?>" height="100px" width="100px"></td>
                    <td>
                        <?php 
                        $string = $row->title;
                        $length = strlen($row->title);
                        if ($length > 20) {
                            $chunks = str_split($string, 20);
                            $formatted_string = implode("<br>", $chunks);
                            echo $formatted_string;
                        } else {
                            echo $string;
                        }
                        ?>
                    </td>
                    <td><?=$row->start_date?></td>
                    <td><?=$row->end_date?></td>
                    <td>
                           <?php 
                        $string2 = $row->description;
                        $length2 = strlen($string2);
                        if ($length2 > 20) {
                            $chunks2 = str_split($string2, 20);
                            $formatted_string2 = implode("<br>", $chunks2);
                            echo $formatted_string2;
                        } else {
                            echo $string2;
                        }
                        ?></td>
                         <td><?=$row->seq?></td>
                     <td class="text-center">
                       <span class="changeStatus" style="font-size:1.3rem;" data-toggle="change-status" value="<?=($row->active==1) ? 0 : 1?>" data="<?=$row->id?>,super_offer,id,active" ><i class="<?=($row->active==1) ? 'ti-check-box text-success' : 'ti-na text-danger'?>" title="Click for chenage status"></i></span>
                   </td>

                    <td> 
                       <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Super Offer (<?=$row->title?>)" data-url="<?=$update_url?><?=$row->id?>" title="Update">
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
                           <span>Showing <?= (@$rows) ? $page+1 : 0 ?> to <?=$i?> of <?=$total_rows?> entries</span>
                             </div>
                                <div class="col-md-6 text-right">
                                    <?=$links?>
                                </div>
                                  </div>
</div>
                                     

       