<div class="card-block table-border-style">
        <div class="table-responsive">
            <table class="table" >
                <thead>
                    <tr>
                        <th class="sr_no">ID</th>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Order Date</th>
                        <th>Total Value</th>
                        <th>Status</th>
                        <th>Payment Mode</th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
                <?php $i=$page;
                   foreach ($rows as $row) {
                ?>
               <tr>
                    <td class="sr_no"><?=++$i?></td>
                    <td><a class="text-primary" href="<?=base_url('orders/details/'.$row->orderid)?>"><b><?=$row->orderid?></b></a></td>
                     <td><p><?php echo $row->fname.' '.$row->lname.' , '.$row->email.' ( '.$row->mobile.' )';?></p></td>
                     <td><?php echo $row->total_value;?></td>
                     <td><?php echo $row->total_value;?></td>
                     <td><?php echo $row->status_name;?></td>
                     <td><?php echo $row->mode;?></td>
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
                                     

       