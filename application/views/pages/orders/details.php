<div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                <div class="page-wrapper">
									<!-- Page-header start -->
                                    <div class="page-header card">
                                        <div class="card-block">
                                            <h5 class="m-b-10"><?=$title;?></h5>
                                            <ul class="breadcrumb-title b-t-default p-t-10">
                                                <li class="breadcrumb-item">
                                                    <a href="index.html"> <i class="fa fa-home"></i> </a>
                                                </li>
                                               <li class="breadcrumb-item"><a href="#!">Home</a>
                                                        </li>
                                                        <li class="breadcrumb-item"><a href="#!"><?=$title;?></a>
                                                        </li>
                                            </ul>
                                        </div>
                                    </div>
                                <!-- Page-header end -->
                                    
                                <!-- Page-body start -->
                                <div class="page-body">
                                    <div class="row">
                                        <div class="col-4">
                                        <div class="card">
                                        <div class="card-body">
                                                <h4 class="card-title">ORDER SUMMARY: <strong>#<?php echo $orderData->orderid;?></strong></h4>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                                <td style="border-top: none !important; padding: .75rem; vertical-align: bottom; border-bottom: 1px solid #dee2e6;">Order Date</td>
                                                                <td style="border-top: none !important; padding: .75rem; vertical-align: bottom; border-bottom: 1px solid #dee2e6;">
                                                                <?php echo $orderData->order_date ?></td>
                                                            </tr>    
                                                            <tr>
                                                                <th>Total items</th>
                                                                <th><?php if($orderItems!==FALSE){echo count($orderItems);}else{echo '0';}?></th>
                                                            </tr>
                                                            <tr>
                                                                <th>Total Before Tax</th>
                                                                <th>₹ <?php echo bcdiv(($orderData->total_value - $orderData->tax), 1, 2); ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th>Tax</th>
                                                                <th>₹ <?php echo  bcdiv(($orderData->tax), 1, 2); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th>Total Savings</th>
                                                                <th>₹ <?php echo  bcdiv(($orderData->total_savings), 1, 2); ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th style="font-size: 1.3rem">Total</th>
                                                                <th style="font-size: 1.3rem">₹ <?php echo bcdiv(($orderData->total_value), 1, 2);  ?></th>
                                                            </tr>
                                                        
                                                        
                                                        
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                              <div class="card-body">
                                <h4 class="card-title"><strong>Order Details</strong></h4>
                                <div class="table-responsive">
                                    <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Customer Name</th>
                                                <th><?php echo $orderData->fname.' '.$orderData->lname.'<br> (<span class="text-primary">'.$orderData->email.'</span>)'; ?></th>
                                            </tr>
                                             <tr>
                                                <th>Customer Number</th>
                                                <th><?php echo '<span class="text-primary">'.$orderData->booking_contact.'</span>'; ?></th>
                                            </tr>
                                            <tr>
                                                <th>Shop Name</th>
                                                <th>Prashansha Bakery</th>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <th><?php 
                                                echo $orderData->address_line_1.', '.$orderData->address_line_2.', '.$orderData->address_line_3.',<br> '.$orderData->state.', '.$orderData->city.', '.$orderData->pincode;

                                                    ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             <tr>
                                                <td>Payment Method</td>
                                                <td><?php echo $orderData->mode; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><strong>Order Status</strong></h4>
                                <div class="table-responsive">
                                <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Status</th>
                                                <th>
                                                    <select class="select" id="order-status" style="width: 100%" data-placeholder="Choose">
                                              <?php  $rs=$this->orders_model->getCurrentStatus($orderData->id);
                                                             
                                                $orderStatusNew=$this->orders_model->getRowsNew($rs->order)?>
                                                        <?php foreach($orderStatusNew as $orstatus):?>
                                                        <option value="<?=$orstatus->id;?>" ><?=$orstatus->name;?></option>
                                                    <?php  endforeach;?>
                                                    <?php
                                                    ?>
                                                    </select>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="2"><button class="btn btn-danger float-right" id="status-update">Update Status</button></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                                     </div>
                                     <div class="col-8">
                                        <div class="card">
                                        <div class="card-body">
                                <h4 class="card-title">Order Items</h4>                        
                                <div class="contact-page-aside">
                                    <div class="table-responsive">
                                        <table id="demo-foo-addrow" class="table m-t-30 table-hover no-wrap contact-list" data-paging="true" data-paging-size="7">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Product Name</th>
                                                    <th>Rate</th>
                                                    <th>Qty</th>
                                                    <th>Amount</th>
                                                    <th>Tax</th>
                                                    <th>Offer Applied (if any)</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $total=0;
                                                    if($orderItems!==FALSE){
                                                        $count=1;
                                                        foreach($orderItems as $items){
                                                            echo '<tr>';
                                                            echo '<td>'.$count.'</td>';
                                                            echo '<td>';
                                                            echo '<img src="' .IMGS_URL.$items['thumbnail']. '" style="width:100px; max-height:100px;">&nbsp;&nbsp;' . $items['pro_name'] . '  <strong>(' . str_pad($items['pro_code'], 6, '0', STR_PAD_LEFT) . ')</strong>';
                                                            echo '</td>';
                                                            echo '<td>₹ '.bcdiv(($items['price_per_unit']), 1, 2).'</td>';
                                                            echo '<td>'.$items['qty'].'</td>';
                                                            echo '<td>₹ '.bcdiv(($items['total_price']), 1, 2).'</td>';
                                                            echo '<td>'.$items['tax_value'].'%</td>';
                                                            echo '<td>'?><?php  if($items['discount_type']==1){ echo $items['offer_applied'].'% OFF';}elseif($items['discount_type']==0){ echo '₹ '.$items['offer_applied'].' FLAT OFF';}elseif($items['discount_type']==2){echo $items['offer_applied'];}else{echo $items['offer_applied']; };?><?php '</td>';
                                                               echo '<td><b>₹ '.bcdiv( $items['total_price'], 1, 2).'</td>';
                                                                echo '</b></tr>';
                                                            $count++;
                                                           ?>
                                                       <?php  }
                                                    }
                                                ?>
                                            </tbody>
                                            
                                        </table>
                                    </div>
                                    <!-- .left-aside-column-->
                                </div>
                            </div>
                                        </div>
                                     </div>
                                  </div>
                                </div>
                                <!-- Page-body end -->
                            </div>
                        </div>
                        <!-- Main-body end -->

                    </div>
                </div>
 <script>
                         $('#status-update').click(function(e){
                                const swalWithBootstrapButtons = Swal.mixin({
                                    customClass: {
                                        confirmButton: 'btn btn-success',
                                        cancelButton: 'btn btn-danger'
                                    },
                                    buttonsStyling: true
                                })

                                swalWithBootstrapButtons.fire({
                                    title: 'Are you sure to update the status to '+$('#order-status option:selected').text()+' ?',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Yes, please!',
                                    cancelButtonText: 'No, cancel!',
                                    reverseButtons: true
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        return $.ajax({
                                            type:"POST",
                                            url: "<?=base_url();?>orders/updateOrderStatus",
                                            data: {item:{id: "<?php echo $orderData->id;?>",status:$('#order-status option:selected').val()}},
                                            'success': function (data) {

                                                swalWithBootstrapButtons.fire(
                                                    'Success!',
                                                    'Status has been updated.',
                                                    'success',
                                                ).then((result) => {
                                                    location.reload();
                                                })
                                            }
                                        });
                                    } else if (
                                        result.dismiss === Swal.DismissReason.cancel
                                    ) {
                                        swalWithBootstrapButtons.fire(
                                        'Cancelled',
                                        'You\'ve cancelled the transaction',
                                        'error'
                                        )
                                    }
                                })
                            
                        });
 </script>