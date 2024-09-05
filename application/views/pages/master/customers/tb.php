<div class="card-block table-border-style">
        <div class="table-responsive">
            <table class="table" >
                <thead>
                    <tr>
                        <th class="sr_no">Sr. no.</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Dob</th>
                        <th>Gender</th>
                        <th>Default Address</th>
                        <th>Apartment</th>
                        <th>Floor</th>
                        <th>Landmark</th>
                        <th>Country</th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
                <?php $i=$page;
                   foreach ($rows as $row) {
                ?>
               <tr>
                    <td class="sr_no"><?=++$i?></td>
                    <td><?php echo $row->fname.' '.$row->lname;?></td>
                    <td>
                     <?php if(!empty($row->photo)) { ?>
                    <img  src="<?php echo IMGS_URL.$row->photo;?>" alt="<?php echo $row->fname.''.$row->lname?>" height="50" width="50" data-toggle="modal" data-target="#exampleModal<?php echo $row->customer_id;?>">
                    <div class="modal fade" id="exampleModal<?php echo $row->customer_id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                         <div class="modal-header"><?php echo $row->fname.''.$row->lname;?></div>   
                        <div class="modal-body">
                        <img  src="<?php echo IMGS_URL.$row->photo;?>" alt="<?php echo $row->fname.''.$row->lname;?>" height="100%" width="100%" >
                        </div>
                        <div class="modal-footer"></div>5
                        </div>
                    </div>
                    </div>
                     <?php }else {
                        // Image doesn't exist, display first letter with dark background
                        $initialLetter = strtoupper(substr($row->fname, 0, 1));
                        ?>
                        <div style="width: 50px; height: 50px; background-color: #333; color: #fff; text-align: center; line-height: 50px; font-size: 40px; font-weight: bold;">
                            <?php echo $initialLetter; ?>
                        </div>
                        <?php
                    }
                    ?> 
                     </td>
                     <td><?php echo $row->mobile;?></td>
                     <td><?php echo $row->email;?></td>
                     <td><?php echo format_date($row->dob);?></td>
                     <td><?php echo $row->gender;?></td>
                     <td><p><?php echo $row->address_line_1.' '.$row->address_line_2.' '.$row->address_line_3.'<br>'.$row->city.', '.$row->state.', '.$row->pincode;?></p></td>
                     <td><?php echo $row->apartment_name;?></td>
                     <td><?php echo $row->floor;?></td>
                     <td><?php echo $row->landmark;?></td>
                     <td><?php echo $row->country;?></td>
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
                                     

       