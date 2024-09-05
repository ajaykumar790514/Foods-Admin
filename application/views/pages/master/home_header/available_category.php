<div class="modal-body">
      
                                                                
<div class="card-block table-border-style">
  <div class="table-responsive">
   <table class="table" >
      <thead class="thead-light">
          <tr style="border:1px solid black">
              <th class="text-center">Image</th>
              <th class="text-center">Category Name</th>
              <th class="text-center">Action</th>
          </tr>
          </thead>
          <tbody>
              <?php
              $flg=0;
              foreach($parent_cat as $parent) {?>
          <tr>
              <td class="text-center"><img src="<?php echo IMGS_URL.$parent->icon; ?>" alt="image" height="100"></td>
              <td class="text-center"><?php echo $parent->name; ?></td>
              <?php foreach($headers_mapping as $mapping) 
              {
                   if($mapping->value == $parent->id)
                   {
                           $flg=1;   
                   }
              }
              ?>
                 <?php if($flg==1)
                  {?> 
              <td class="btn mt-3 btn-danger btn-sm" id="changeaction2<?= $parent->id ?>">
             
                  <a href="javascript:void(0)" onclick="remove_map_category(<?= $parent->id ?>);" style="color:white;"> Remove </a>
              </td>
              <?php } 
                  else { ?>
                    <td class="btn mt-3 btn-primary btn-sm" id="changeaction2<?= $parent->id ?>">
                  <a href="javascript:void(0)" onclick="map_category(<?= $parent->id ?>);" style="color:white;">Map</a>
                  <?php } ?>
              </td>

               
          </tr>
          <?php $flg=0; }?>
          </tbody>
             </table>
  </div></div>                                                     
                </div>