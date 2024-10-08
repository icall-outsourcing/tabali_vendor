<style>
  body{     
    /* max-width: 450px; */
    max-width: 500px;
    margin: auto;    
   }
   td{font-size: 35px;}
   .header{background-color: #9f9c9c63;font-size: 35px;font-weight: bold;}
   .subHeader{font-size: 30px;}
   .backColor{background-color: #9f9c9c63 !important ;}
   .footer{background-color: #9f9c9c63;font-size: 35px;font-weight: bold;}
</style>  
<body>

    <?php if(in_array(0, $sectiontoprint) && $order->print_receipt == 'N'): ?> 
      <div>
        <!-- Head -->
        <table width="100%">
          <col width="25%" />
          <col width="25%" />
          <col width="25%" />
          <col width="25%" />
          <thead>
            <tr><td align="center" colspan="4"><img src="<?php echo e(asset('img/logo2.png')); ?>" style="display:block;width: 270px;" ></td></tr>
            <tr><td align="center" colspan="4" class="header">Tabali</td></tr>
            <tr><td align="center" colspan="4" class="subHeader"><?php echo e($order->branch->name); ?></td></tr>
            <tr><td align="center" colspan="4" class="subHeader"><?php echo e($order->payment_type); ?></td></tr>
            <tr><td></td><td  align="center" colspan="2" class="header"><?php echo e($order->orderid); ?></td><td></td></tr>
            <tr>
              <td align="left">Date: </td>
              <td align="left" colspan="3"><?php echo e($created->format('Y/m/d')); ?></td>
            </tr>
            <tr>
              <td align="left">Time: </td>
              <td align="left" colspan="3"><?php echo e($created->format('A h:i:s')); ?></td>
            </tr>
            <tr>
              <td align="left">Delivery: </td>
              <td align="left" colspan="3"><?php if($order->driver_id): ?> <?php echo e($order->driver->name); ?> <?php endif; ?></td>
            </tr>
            <tr>
              <td align="left">Account: </td>
              <td align="left" colspan="3"><?php echo e($order->account->account_name); ?></td>
            </tr>
            <tr>
              <td align="left">Name: </td>
              <td align="left" colspan="3"><?php echo e($order->contact->contact_name); ?></td>
            </tr>
            <tr>
              <td align="left">Phone: </td>
              <td align="left" colspan="3"><?php echo e($order->account->phone_number); ?> - <?php echo e($order->follow_up_phone); ?></td>
            </tr>
            <tr>
                <td align="left">Area: </td>
                <td align="left" colspan="3"><?php echo e(@$order->address->area); ?> - <?php echo e(@$order->address->subdistrict); ?> -  <?php echo e(@$order->address->district); ?></td>
            </tr>                      
            <tr>
              <td align="left">Address: </td>
              <td align="left" colspan="3"><?php echo e(@$order->address->address); ?></td>
            </tr>
              <td align="left">landmark: </td>
              <td align="left"><?php echo e($order->address->landmark); ?></td>
              <td align="left">Building: </td>
              <td align="left"><?php echo e($order->address->building_number); ?></td>
            </tr>
            <tr>
              <td align="left">Floor: </td>
              <td align="left"><?php echo e(@$order->address->floor); ?></td>
              <td align="left">Apartment: </td>
              <td align="left"><?php echo e(@$order->address->apartment); ?></td>
            </tr>                                    
            <tr>
              <?php if(!empty($order->order_comment)): ?>             
                <td class="backColor" align="center">Note: </td>
                <td class="backColor" align="center" colspan="3"><?php echo e(@$order->order_comment); ?></td>  
              <?php endif; ?>
          </tr>              
          </thead>
        </table>
        <!-- End Head -->

        <!-- Items -->
        <table class=orderitems width="100%" border="1">
          <thead>        
            <tr><td colspan="4" class="backColor"></td></tr>
            <tr class="text-center">
                <td align="center">Q</td>
                <td align="left">item</td>
                <td align="center">p</td>
                <td align="center">T</td>
            </tr>
          </thead>
          <tbody>
            <?php foreach($order->items->where('version',$order->version) as $item): ?>
              <?php if(empty($item->extra_items)): ?>
                <tr class="text-center">
                  <td align="center"><?php echo e(number_format($item->quantity ,-1,'','')); ?></td>
                  <td align="left"><?php if(!empty($item->product->ar_name)): ?><?php echo e($item->product->ar_name); ?><?php endif; ?></td>
                  <td align="right"> <?php echo e($item->tprice / $item->quantity); ?></td>
                  <td align="right"> <?php echo e($item->tprice); ?></td>
                </tr>
                <?php if(!empty($item->item_comment)): ?> <tr class="backColor" ><td colspan="4"></span><?php echo e($item->item_comment); ?> </span></td></tr> <?php endif; ?>
              <?php endif; ?>
            <?php foreach($order->items->where('version',$order->version) as $value): ?>
              <?php if($value->extra_items == $item->id): ?>
              <tr style="background-color: darkgray">
                <td></td>
                <td align="left"><?php echo e($value->product->ar_name); ?></td>
                <td align="right"><?php echo e($value->tprice); ?></td>
              </tr>
              <?php if(!empty($item->item_comment)): ?> <tr class="backColor" ><td colspan="4"></span><?php echo e($item->item_comment); ?> </span></td></tr> <?php endif; ?>
              <?php endif; ?>
            <?php endforeach; ?>
            <?php endforeach; ?>
          </tbody>
          <tr><td colspan="4" style="background-color: #9f9c9c;" align="center"></td></tr>
        </table>  
        <!-- End Items -->


        <!-- Total  -->
        <table width="100%">
        <tbody>
          <tr>
            <td width="80%" align="left">Total</td>
            <td width="10%" align="right"><?php echo e($order->total); ?></td>
          </tr>
          <tr>
            <td width="80%" align="left">Discount</td>
            <td width="10%" align="right"><?php echo e($order->discount); ?></td>
          </tr>    
          <tr>
          <td width="80%" align="left" style="font-weight: bold;">Total After Discount</td>
          <td width="10%" align="right"><?php  $discount = ( 100 - $order->discount) / 100;   ?><?php echo e($Afterdiscount =  number_format($order->total *  $discount,2)); ?></td>
          </tr>
          <tr>
          <td width="80%" align="left">Service (+)</td>
          <td width="10%" align="right"><?php echo e($order->deliveryfees); ?></td>       
          </tr>
          <tr>
          <td width="80%" align="left">Tax (+)</td>
          <td width="10%" align="right"><?php echo e($order->taxfees); ?></td>
          </tr> 
          <?php if($order->voucher_amount > 0): ?>
            <tr>
              <td width="80%" align="left">Voucher Gift</td>
              <td width="10%" align="right"> - <?php echo e(@$order->voucher_amount); ?></td>
            </tr>               
          <?php endif; ?>     
          <tr class="backColor">
            <td width="80%"  align="left" style="font-weight: bold;">Total</td>        
            <td width="10%"  align="right"><?php echo e(number_format( (str_replace(',','',$Afterdiscount) + $order->deliveryfees + $order->taxfees   - ($order->voucher_amount) ), 2)); ?></td>
          </tr>
        </tbody>
        </table>
        <!-- Total End  -->


        <!-- Voucher Code -->
          <?php if(@$order->Voucher->gift->name): ?>
            <div align="center" colspan="4" class="header"><?php echo e($order->Voucher->gift->name); ?></div>      
          <?php endif; ?>

          <?php if((str_replace(',','',$Afterdiscount) + $order->deliveryfees + $order->taxfees) > 100  && $order->discount == 0  && $order->voucher_id == '' && date('Y') == 2019): ?>
            <img src="<?php echo e(asset('img/voucher.png')); ?>" style="display: block;margin-left: auto;margin-right: auto;/*width: 50%;*/" >
            <center><p style="display: block;margin-left: auto;margin-right: auto;">The total order is over 100 EL, so you deserve a gift voucher. Don't forget to ask the driver man</p> </center>
          <?php endif; ?>
        <!-- Voucher End-->
      
      
        <div align="center" colspan="4" class="footer"><?php echo e($order->source); ?> / <?php echo e($order->payment_method); ?></div>
      </div>
      <hr/>
    <?php endif; ?>

    <?php 
      $orderItemsver= $order->version - 1 ;      
      $orderItems   = $order->items->where('flagtoprint','N')->lists('product_id','id')->toArray();
      $orderSection = \App\Product::whereIn('id', $orderItems)->groupBy('sectionid')->lists('sectiongroup','sectionid')->toArray();
      $totalextra   = \App\Product::where('extra', 1)->lists('id','id')->toArray();
      $checkextras  = DB::table('order_items')->where('order_id', $order->id)->whereIn('product_id',$totalextra)->where(function ($query) {$query->WhereNull('extra_items')->orWhere('extra_items', '=', 0);})->count();
     ?>
    
        
    <?php  $extra_items = array()  ?>
    <?php if($driver == 'notdriver'): ?>
      <?php foreach($orderSection as $key => $section): ?>
        <?php if(in_array($key, $sectiontoprint)): ?> 
          <?php if($key == '19'): ?>
            <?php if($checkextras > 0): ?>
              <!-- class="page-break" -->
              <div id="<?php echo e($key); ?>" style="border-style: dotted">              
                <table width="100%" >
                  <col width="25%" />
                  <col width="25%" />
                  <col width="25%" />
                  <col width="25%" />
                  <thead>
                    <tr><td align="center" colspan="4" class="subHeader"><?php echo e($created->format('Y/m/d A h:i')); ?></td></tr>
                    <tr><td align="center" colspan="4" class="header"><?php echo e($order->orderid); ?> --- <?php echo e($section); ?></td></tr>
                    <tr>
                      <td width="10%">Q</td>
                      <td width="90%" align="right"> items </td>
                    </tr>
                  </thead>

                  <?php foreach($order->items->where('version',$order->version)->where('extra_items',null) as $item): ?>
                    <!-- check if it extra items -->
                    <?php if($item->product->section_name == $section): ?>
                      <?php if(in_array($item->id, $extra_items)  == false): ?>
                        <tbody>
                          <!-- check if it new or add or edit -->
                          <?php if($item->printeraction == 'new'): ?>
                              <tr>
                                <td><?php echo e($item->quantity); ?></td>
                                <td align="right"><?php echo e($item->product->ar_name); ?> </td>
                              </tr>
                              <!-- check the comment  -->
                              <?php if(!empty($item->item_comment)): ?>
                                <tr style="background-color: #9f9c9c;color: white;">
                                  <td colspan="2" align="right">
                                    </span><?php echo e($item->item_comment); ?> </span>
                                  </td>
                                </tr>
                              <?php endif; ?>
                              <!-- check if there is extra items -->
                              <?php foreach($order->items->where('version',$order->version) as $value): ?>
                                <?php if($value->extra_items == $item->id): ?>
                                  <?php  $extra_items[$value->id] = $value->id  ?>
                                  <tr style="background-color: #9f9c9c;color: white;">
                                    <td colspan="2" align="right">
                                      </span><?php echo e($value->product->ar_name); ?> </span>
                                    </td>
                                  </tr>
                                <?php endif; ?>
                              <?php endforeach; ?>
                          <?php elseif($item->printeraction == 'add'): ?>
                              <tr><td colspan="2" align="right" style="background-color: #d9d7d7">أضا فه جديده </td></tr>
                              <tr>
                                <td><?php echo e($item->quantity); ?></td>
                                <td align="right"><?php echo e($item->product->ar_name); ?> </td>
                              </tr>
                              <!-- check the comment  -->
                              <?php if(!empty($item->item_comment)): ?>
                                <tr style="background-color: #9f9c9c;color: white;">
                                  <td colspan="2" align="right">
                                    </span><?php echo e($item->item_comment); ?> </span>
                                  </td>
                                </tr>
                              <?php endif; ?>
                              <!-- check if there is extra items -->
                              <?php foreach($order->items->where('version',$order->version) as $value): ?>
                                <?php if($value->extra_items == $item->id): ?>
                                  <?php  $extra_items[$value->id] = $value->id  ?>
                                  <tr style="background-color: #9f9c9c;color: white;">
                                    <td colspan="2" align="right">
                                      </span><?php echo e($value->product->ar_name); ?> </span>
                                    </td>
                                  </tr>
                                <?php endif; ?>
                              <?php endforeach; ?>
                          <?php elseif($item->printeraction == 'edit' && $item->oldid > 0): ?>
                            <?php  $olditems = \App\OrderItem::find($item->oldid);  ?>
                            <!-- check if items add or remove or edit -->
                            <?php if($item->quantity > $olditems->quantity): ?>
                              <?php  $total  = $item->quantity - $olditems->quantity  ?>
                            <?php else: ?>
                              <?php  $total  = $olditems->quantity - $item->quantity  ?>
                            <?php endif; ?>
                            <?php if($item->extra_items != $olditems->extra_items ||  $item->quantity != $olditems->quantity ||  $item->tprice != $olditems->tprice || $item->item_comment != $olditems->item_comment ): ?>
                              <tbody>
                                <!-- Add -->
                                <?php if($item->quantity > $olditems->quantity ): ?>
                                  <tr><td colspan="2" align="right" style="background-color: #d9d7d7">اضافه </td></tr>
                                  <tr>
                                    <td><?php echo e($total); ?></td>
                                    <td align="right"><?php echo e($item->product->ar_name); ?> </td>
                                  </tr>
                                <!-- Nothing -->
                                <?php elseif($item->quantity == $olditems->quantity): ?>
                                  <tr><td colspan="2" align="right" style="background-color: #d9d7d7">تعديل </td></tr>
                                  <tr>
                                    <td><?php echo e($item->quantity); ?></td>
                                    <td align="right"><?php echo e($item->product->ar_name); ?> </td>
                                  </tr>
                                <!-- remove -->
                                <?php else: ?>
                                  <tr><td colspan="2" align="right" style="background-color: #d9d7d7">حذف </td></tr>
                                  <tr>
                                    <td><?php echo e($total); ?></td>
                                    <td align="right"><?php echo e($item->product->ar_name); ?> </td>
                                  </tr>
                                <?php endif; ?>
                                  <!-- check the comment  -->
                                  <?php if(!empty($item->item_comment)): ?>
                                    <tr style="background-color: #9f9c9c;color: white;">
                                      <td colspan="2" align="right">
                                        </span><?php echo e($item->item_comment); ?> </span>
                                      </td>
                                    </tr>
                                  <?php endif; ?>
                                  <!-- check Extra Items -->
                                  <?php foreach($order->items->where('version',$order->version) as $value): ?>
                                    <?php if($value->extra_items == $item->id): ?>
                                    <?php  $extra_items[$value->id] = $value->id  ?>
                                    <tr style="background-color: #9f9c9c;color: white;">
                                      <td colspan="2" align="right">
                                        </span><?php echo e($value->product->ar_name); ?> </span>
                                      </td>
                                    </tr>
                                    <?php endif; ?>
                                  <?php endforeach; ?>
                              </tbody>
                            <?php endif; ?>
                          <?php endif; ?>
                        </tbody>
                      <?php endif; ?>
                    <?php endif; ?>
                  <?php endforeach; ?>
                  <?php  
                    $excountRemoveItems = 0;
                    $exversion            = $order->version - 1;
                   ?>
                  <?php foreach( \App\OrderItem::where('order_id',$order->id)->where('version',$exversion)->where('printeraction','remove')->get() as $remove): ?>
                    <?php if($remove->product->sectiongroup == $section): ?>
                      <?php if(in_array($remove->id, $extra_items) == false): ?>
                        <tbody>
                          <?php if($excountRemoveItems++  < 1): ?>
                          <?php endif; ?>
                          <tr> <td colspan="2" align="right" style="background-color: #d9d7d7"> ﻟﻘﺪ ﺗﻢ ﺣﺬﻑ </td> </tr>
                          <tr style="color: #fff;background-color:#4e4f4e;">
                            <td><?php echo e($remove->quantity); ?></td>
                            <td align="right"><?php echo e($remove->product->ar_name); ?> <?php echo e($excountRemoveItems); ?></td>
                          </tr>
                          <?php if(!empty($remove->item_comment)): ?>
                            <tr style="color: #fff;background-color:#4e4f4e;">
                              <td colspan="2" align="right">
                                </span><?php echo e($remove->item_comment); ?> </span>
                              </td>
                            </tr>
                          <?php endif; ?>
                          <?php foreach($order->items->where('version',$order->version-1)->where('printeraction','remove') as $value): ?>
                            <?php if($value->extra_items == $remove->id): ?>
                            <?php  $extra_items[$value->id] = $value->id  ?>
                            <tr style="color: #fff;background-color:#4e4f4e;">
                              <td colspan="2" align="right">
                                </span><?php echo e($value->product->ar_name); ?> </span>
                              </td>
                            </tr>
                            <?php endif; ?>
                          <?php endforeach; ?>
                        </tbody>
                      <?php endif; ?>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </table>
              </div>
              <hr/>
            <?php endif; ?>
          <?php else: ?>
            
            <div id="section-<?php echo e($key); ?>" style="border-style: dotted;display: none;">
              <table width="100%" >
                <col width="25%" />
                <col width="25%" />
                <col width="25%" />
                <col width="25%" />
                <thead>
                  <tr><td align="center" colspan="4" class="subHeader"><?php echo e($created->format('Y/m/d A h:i')); ?></td></tr>
                  <tr><td align="center" colspan="4" class="header"><?php echo e($order->orderid); ?> --- <?php echo e($section); ?></td></tr>
                  <tr>
                    <td width="10%">Q</td>
                    <td width="90%" align="right"> items </td>
                  </tr>
                </thead>                                
                <!-- Check new items -->
                <?php foreach($order->items->where('version',$order->version) as $item): ?>                    
                  <!-- check the sectiongroup -->
                  <?php if($item->product->sectiongroup == $section): ?>
                    <!-- check if items in Extra or not -->
                    <?php if(in_array($item->id, $extra_items) == false): ?>
                      <tbody>                         
                        <!-- check if it new or add or edit -->
                        <?php if($item->printeraction     == 'new'): ?>
                            <script>document.getElementById("section-<?php echo e($key); ?>").style.display = "block";</script>
                            <tr>
                              <td><?php echo e($item->quantity); ?></td>
                              <td align="right"><?php echo e($item->product->ar_name); ?> </td>
                            </tr>
                            <!-- check the comment  -->
                            <?php if(!empty($item->item_comment)): ?>
                              <tr style="background-color: #9f9c9c;color: white;">
                                <td colspan="2" align="right">
                                  </span><?php echo e($item->item_comment); ?> </span>
                                </td>
                              </tr>
                            <?php endif; ?>
                            <!-- check if there is extra items -->
                            <?php foreach($order->items->where('version',$order->version) as $value): ?>
                              <?php if($value->extra_items == $item->id): ?>
                                <?php  $extra_items[$value->id] = $value->id  ?>
                                <tr style="background-color: #9f9c9c;color: white;">
                                  <td colspan="2" align="right">
                                    </span><?php echo e($value->product->ar_name); ?> </span>
                                  </td>
                                </tr>
                              <?php endif; ?>
                            <?php endforeach; ?>
                        <?php elseif($item->printeraction == 'add'): ?>
                            <script>document.getElementById("section-<?php echo e($key); ?>").style.display = "block";</script>
                            <tr><td colspan="2" align="right" style="background-color: #d9d7d7">أضا فه جديده </td></tr>
                            <tr>
                              <td><?php echo e($item->quantity); ?></td>
                              <td align="right"><?php echo e($item->product->ar_name); ?> </td>
                            </tr>
                            <!-- check the comment  -->
                            <?php if(!empty($item->item_comment)): ?>
                              <tr style="background-color: #9f9c9c;color: white;">
                                <td colspan="2" align="right">
                                  </span><?php echo e($item->item_comment); ?> </span>
                                </td>
                              </tr>
                            <?php endif; ?>
                            <!-- check if there is extra items -->
                            <?php foreach($order->items->where('version',$order->version) as $value): ?>
                              <?php if($value->extra_items == $item->id): ?>
                                <?php  $extra_items[$value->id] = $value->id  ?>
                                <tr style="background-color: #9f9c9c;color: white;">
                                  <td colspan="2" align="right">
                                    </span><?php echo e($value->product->ar_name); ?> </span>
                                  </td>
                                </tr>
                              <?php endif; ?>
                            <?php endforeach; ?>
                        <?php elseif($item->printeraction == 'edit' && $item->oldid > 0): ?>
                          <?php  $olditems = \App\OrderItem::find($item->oldid);  ?>
                          <!-- check if items add or remove or edit -->
                          <?php if($item->quantity > $olditems->quantity): ?>
                            <?php  $total  = $item->quantity - $olditems->quantity  ?>
                          <?php else: ?>
                            <?php  $total  = $olditems->quantity - $item->quantity  ?>
                          <?php endif; ?>
                          <?php if($item->extra_items  != $olditems->extra_items  ||  $item->quantity     != $olditems->quantity     ||  $item->tprice       != $olditems->tprice       || $item->item_comment != $olditems->item_comment): ?>
                            <tbody>
                              <script>document.getElementById("section-<?php echo e($key); ?>").style.display = "block";</script>
                              <!-- Add -->
                              <?php if($item->quantity > $olditems->quantity ): ?>
                                
                                <tr><td colspan="2" align="right"  style="background-color: #d9d7d7">اضافه </td></tr>
                                <tr>
                                  <td><?php echo e($total); ?></td>
                                  <td align="right"><?php echo e($item->product->ar_name); ?> </td>
                                </tr>
                              <!-- Nothing -->
                              <?php elseif($item->quantity == $olditems->quantity): ?>
                                <tr><td colspan="2" align="right"  style="background-color: #d9d7d7">تعديل </td></tr>
                                <tr>
                                  <td><?php echo e($item->quantity); ?></td>
                                  <td align="right"><?php echo e($item->product->ar_name); ?> </td>
                                </tr>
                              <!-- remove -->
                              <?php else: ?>
                                <tr><td colspan="2" align="right"  style="background-color: #d9d7d7">حذف </td></tr>
                                <tr>
                                  <td><?php echo e($total); ?></td>
                                  <td align="right"><?php echo e($item->product->ar_name); ?> </td>
                                </tr>
                              <?php endif; ?>
                                <!-- check the comment  -->
                                <?php if(!empty($item->item_comment)): ?>
                                  <tr style="background-color: #9f9c9c;color: white;">
                                    <td colspan="2" align="right">
                                      </span><?php echo e($item->item_comment); ?> </span>
                                    </td>
                                  </tr>
                                <?php endif; ?>
                                <!-- check Extra Items -->
                                <?php foreach($order->items->where('version',$order->version) as $value): ?>
                                  <?php if($value->extra_items == $item->id): ?>
                                  <?php  $extra_items[$value->id] = $value->id  ?>
                                  <tr style="background-color: #9f9c9c;color: white;">
                                    <td colspan="2" align="right">
                                      </span><?php echo e($value->product->ar_name); ?> </span>
                                    </td>
                                  </tr>
                                  <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                          <?php elseif($olditems->flagtoprint == "N" && $item->flagtoprint == "N"): ?>
                          <script>document.getElementById("section-<?php echo e($key); ?>").style.display = "block";</script>
                          <tbody>
                              <!-- Add -->                                                                
                                <tr>
                                  <td><?php echo e($item->quantity); ?></td>
                                  <td align="right"><?php echo e($item->product->ar_name); ?> </td>
                                </tr>
                              <!-- Nothing -->                                
                              
                                <!-- check the comment  -->
                                <?php if(!empty($item->item_comment)): ?>
                                  <tr style="background-color: #9f9c9c;color: white;">
                                    <td colspan="2" align="right">
                                      </span><?php echo e($item->item_comment); ?> </span>
                                    </td>
                                  </tr>
                                <?php endif; ?>
                                <!-- check Extra Items -->
                                <?php foreach($order->items->where('version',$order->version) as $value): ?>
                                  <?php if($value->extra_items == $item->id): ?>
                                  <?php  $extra_items[$value->id] = $value->id  ?>
                                  <tr style="background-color: #9f9c9c;color: white;">
                                    <td colspan="2" align="right">
                                      </span><?php echo e($value->product->ar_name); ?> </span>
                                    </td>
                                  </tr>
                                  <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>

                          <?php endif; ?>
                        <?php endif; ?>
                      </tbody>
                    <?php endif; ?>
                  <?php endif; ?>
                <?php endforeach; ?>
                <!-- Remove Items from delete button -->
                <?php  
                  $countRemoveItems = 0;
                  $version          = $order->version - 1;
                 ?>
                <?php foreach( \App\OrderItem::where('order_id',$order->id)->where('version',$version)->where('printeraction','remove')->get() as $remove): ?>
                  <?php if($remove->product->sectiongroup == $section): ?>
                    <?php if(in_array($remove->id, $extra_items) == false): ?>
                    <tbody>
                      <?php if($countRemoveItems++  < 1): ?>
                          <script>document.getElementById("section-<?php echo e($key); ?>").style.display = "block";</script>
                          <tr> <td colspan="2" align="right" style="background-color: #d9d7d7"> ﻟﻘﺪ ﺗﻢ ﺣﺬﻑ </td> </tr>
                          <tr style="color: #fff;background-color:#4e4f4e;">
                            <td><?php echo e($remove->quantity); ?></td>
                            <td align="right"><?php echo e($remove->product->ar_name); ?> <?php echo e($countRemoveItems); ?></td>
                          </tr>
                          <?php if(!empty($remove->item_comment)): ?>
                            <tr style="color: #fff;background-color:#4e4f4e;">
                              <td colspan="2" align="right">
                                </span><?php echo e($remove->item_comment); ?> </span>
                              </td>
                            </tr>
                          <?php endif; ?>
                          <?php foreach($order->items->where('version',$order->version-1)->where('printeraction','remove') as $value): ?>
                            <?php if($value->extra_items == $remove->id): ?>
                            <?php  $extra_items[$value->id] = $value->id  ?>
                            <tr style="color: #fff;background-color:#4e4f4e;">
                              <td colspan="2" align="right">
                                </span><?php echo e($value->product->ar_name); ?> </span>
                              </td>
                            </tr>
                            <?php endif; ?>
                          <?php endforeach; ?>
                      <?php endif; ?>
                    </tbody>
                    <?php endif; ?>
                  <?php endif; ?>

                <?php endforeach; ?>
                
                
              </table>
              <hr/>
            </div>
          <?php endif; ?>
        <?php endif; ?>
      <?php endforeach; ?>
    <?php endif; ?>

</body>