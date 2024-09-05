<div class="card-block table-border-style">
        <div class="table-responsive">
            <table class="table" >
                <thead>
                    <tr>
                        <th class="sr_no">Sr. no.</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Offer</th>
                        <th>Seq</th>
                        <th>Banner Type</th>
                        <th>Link Type</th>
                        <th>Link ID</th>
                        <th>Text Line1</th>
                        <th>Text Line2</th>
                        <th>Text Line3</th>
                        <th>Text Line4</th>
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
                    <td><img src="<?=IMGS_URL.$row->img;?>" height="100px" width="100px"></td>
                    <td>
                        <?php 
                        $string = $row->banner_title;
                        $length = strlen($row->banner_title);
                        if ($length > 20) {
                            $chunks = str_split($string, 20);
                            $formatted_string = implode("<br>", $chunks);
                            echo $formatted_string;
                        } else {
                            echo $string;
                        }
                        ?>
                    </td>
                    <td><?=$row->banner_offer?></td>
                    <td><?=$row->seq?></td>
                    <td><?php if($row->banner_type=="1"){echo "Top Banner";}elseif($row->banner_type=="0"){echo "Other Banner";} ;?></td>
                    <td><?php if($row->link_type=="product"){echo "Product";}elseif($row->link_type=="category"){echo "Category";} ;?></td>
                    <td>
                           <?php 
                        $string2 = $row->link_id;
                        $length2 = strlen($string2);
                        if ($length2 > 20) {
                            $chunks2 = str_split($string2, 20);
                            $formatted_string2 = implode("<br>", $chunks2);
                            echo $formatted_string2;
                        } else {
                            echo $string2;
                        }
                        ?></td>
                         <td>
                           <?php 
                        $string3 = $row->text_line1;
                        $length3 = strlen($string3);
                        if ($length3 > 20) {
                            $chunks3 = str_split($string3, 20);
                            $formatted_string3 = implode("<br>", $chunks3);
                            echo $formatted_string3;
                        } else {
                            echo $string3;
                        }
                        ?></td>
                        <td>
                           <?php 
                        $string4 = $row->text_line2;
                        $length4 = strlen($string4);
                        if ($length4 > 20) {
                            $chunks4 = str_split($string4, 20);
                            $formatted_string4 = implode("<br>", $chunks4);
                            echo $formatted_string4;
                        } else {
                            echo $string4;
                        }
                        ?></td>
                        <td>
                           <?php 
                        $string5 = $row->text_line3;
                        $length5 = strlen($string5);
                        if ($length5 > 20) {
                            $chunks5 = str_split($string5, 20);
                            $formatted_string5 = implode("<br>", $chunks5);
                            echo $formatted_string5;
                        } else {
                            echo $string5;
                        }
                        ?></td>
                        <td>
                           <?php 
                        $string6 = $row->text_line4;
                        $length6 = strlen($string6);
                        if ($length6 > 20) {
                            $chunks6 = str_split($string6, 20);
                            $formatted_string6 = implode("<br>", $chunks6);
                            echo $formatted_string6;
                        } else {
                            echo $string6;
                        }
                        ?></td>
                     <td class="text-center">
                       <span class="changeStatus" style="font-size:1.3rem;" data-toggle="change-status" value="<?=($row->active==1) ? 0 : 1?>" data="<?=$row->id?>,pincodes_criteria,id,active" ><i class="<?=($row->active==1) ? 'ti-check-box text-success' : 'ti-na text-danger'?>" title="Click for chenage status"></i></span>
                   </td>

                    <td> 
                       <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Category (<?=$row->banner_title?>)" data-url="<?=$update_url?><?=$row->id?>" title="Update">
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
                                     

       