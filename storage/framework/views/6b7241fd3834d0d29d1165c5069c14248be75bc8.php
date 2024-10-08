<!-- language -->
  <?php if(session()->has('lang')): ?>
      <?php echo e(App::setLocale(session()->get('lang'))); ?>

  <?php else: ?>
      <?php echo e(App::setLocale('ar')); ?>

  <?php endif; ?>
<center><a href="#" id="PrintOrder" class="btn btn-warning btn-sm"><i class="fa fa-print">print</i></a></center>
<section class="invoice notprintTable" id="notprint">
 <div class="row">
     <div class="col-xs-12">
   <h2 class="page-header">
    <i class="fa fa-barcode"></i> Order No # <?php echo e($order->orderid); ?>

    <small class="pull-right">Date: <?php echo e($order->created_at); ?></small>
   </h2>
     </div>
   </div>
 <div class="row">
  <div class="col-sm-12  text-right">
   <style type="text/css">
    table.products td {text-align: right;}
   </style>
   <table class="products" width="100%">
    <tr>
     <td width="8%" dir="rtl"><strong> <?php echo e($order->payment_method); ?></strong> 
          <td width="8%" align="right"><strong>ﻃﺮﻳﻘﻪ اﻟﺪﻓﻊ</strong></td>
     <td width="16%"> <?php echo e($order->follow_up_phone); ?>  <strong>:</strong></td>
     <td width="16%"><strong>ﺭﻗﻢ اﻟﺘﻠﻴﻔﻮﻥ</strong></td>
          <td width="16%"><?php echo e($order->contact->contact_name); ?> <strong>:</strong></td>
          <td width="16%" align="right"><strong>ﺃﺳﻢ اﻟﻌﻤﻴﻞ</strong></td>
    </tr>
    <tr>
     <td><?php if(!empty($order->address->area)): ?><?php echo e($order->address->area); ?><?php endif; ?> <strong>:</strong></td>
          <td align="right"><strong>اﻟﻤﻨﻈﻘﻪ</strong></td>
          <td><?php if(!empty($order->address->district)): ?><?php echo e($order->address->district); ?><?php endif; ?> <strong>:</strong></td>
          <td align="right"><strong>اﻟﻤﺪﻳﻨﻪ</strong></td>
     <td><?php if(!empty($order->address->governorate)): ?><?php echo e($order->address->governorate); ?><?php endif; ?> <strong>:</strong></td>
          <td align="right"><strong>اﻟﻤﺤﺎﻓﻈﺔ</strong></td>
       </tr>
       <tr>
                    <td><?php if(!empty($order->address->building_number)): ?><?php echo e($order->address->building_number); ?><?php endif; ?> <strong>:</strong></td>
          <td align="right"><strong>ﺭﻗﻢ اﻟﻌﻘﺎﺭ</strong></td>
     <td><?php if(!empty($order->address->landmark)): ?><?php echo e($order->address->landmark); ?><?php endif; ?> <strong>:</strong></td>
          <td align="right"><strong>ﻋﻼﻣﻪ ﻣﻤﻴﺰﻩ</strong></td>
          <?php /* <td>@if(!empty($order->address->address)){{$order->address->address}}@endif <strong>:</strong></td>*/ ?>
          <td><?php echo e($order->address->address); ?><strong>:</strong></td>
          <td align="right"><strong>اﻟﻌﻨﻮاﻥ</strong></td>
       </tr>
       <tr>
     <td><?php echo e($order->branch->name); ?> <strong>:</strong></td>
          <td><strong> اﻟﻔﺮﻉ </strong></td>
     <td><?php echo e($order->address->floor); ?> <strong>:</strong></td>
          <td><strong>اﻟﺪﻭﺭ</strong></td>
          <td><?php echo e($order->address->apartment); ?> <strong>:</strong></td>
     <td><strong>اﻟﺸﻘﻪ</strong></td>
    </tr>
    <tr style="background-color: #E0FFFF">
     <td colspan="5"><?php echo e($order->order_comment); ?> <strong>:</strong></td>
     <td><strong>ﻣﻠﺤﻮﻇﻪ ﻣﻦ ﺧﺪﻣﺔ اﻟﻌﻤﻼء</strong></td>
    </tr>
    <tr style="background-color: #E0FFFF">
     <td colspan="5"><?php echo e($order->branch_comment); ?> <strong>:</strong></td>
     <td><strong>ﻣﻠﺤﻮﻇﻪ ﻣﻦ اﻟﻔﺮﻉ</strong></td>
    </tr>
    <tr>
     <td></td>
     <td>ﻭﻗﺖ اﻟﻌﻮﺩﻩ</td>
     <td></td>
     <td>ﻭﻗﺖ اﻟﺘﺴﻠﻴﻢ</td>
     <td></td>
     <td>ﻭﻗﺖ اﻟﺨﺮﻭﺝ</td>
    </tr>
   </table>
  </div>
 </div>
 <hr/>
  <!-- Table row -->
   <div class="row">
     <div class="col-xs-12 table-responsive">
      <!-- table-striped --> <table class="table table-hover table-striped  text-right">
             <thead class="label-success" >
           <tr class="text-center">
      <th class="text-center" colspan="2">ﻃﺮﻳﻘﻪ اﻟﺘﺤﻀﻴﺮ</th>
      <th class="text-center">اﻟﺴﻌﺮ</th>
      <th class="text-center">اﻟﻌﺪﺩ</th>
      <th class="text-center" colspan="2">اﻟﻤﻨﺘﺞ</th>
           </tr>
          </thead>
          <tbody>
            <?php foreach($order->items->where('version',$order->version) as $item): ?>
                <?php if($item->extra_items == null): ?>
                      <tr class="text-center">
                  <td colspan="2"><?php if(!empty($item->item_comment)): ?><?php echo e($item->item_comment); ?><?php endif; ?></td>
                  <td><?php echo e($item->tprice); ?></td>
                  <td><?php echo e(number_format($item->quantity ,-1,'','')); ?></td>
                  <td colspan="2"><?php if(!empty($item->product->ar_name)): ?><?php echo e($item->product->ar_name); ?><?php endif; ?></td>
                  <!-- <td> <?php if($item->product->sellinguom > 1): ?> اﺿﺎﻓﻪ <?php else: ?> ﻭﺣﺪﻩ <?php endif; ?> </td>-->
                      </tr>
                      <tr class="text-center" >
                  <td colspan="6" class="text-right">
                  <?php foreach($order->items->where('version',$order->version) as $value): ?>
                    <?php if($value->extra_items == $item->id): ?>
                    <span class="btn  btn-xs btn-default"> <span class="btn  btn-xs btn-warning"> <?php echo e($value->tprice); ?> </span> &nbsp;&nbsp; <?php echo e($value->product->ar_name); ?> </span> &nbsp;
                    <?php endif; ?>
                  <?php endforeach; ?>
                  </td>
                      </tr>
                <?php endif; ?>
            <?php endforeach; ?>
          </tbody>

          <tfoot class="label-success">
            <tr><th colspan="5"> <?php echo e(number_format($order->total,2,'.','')); ?></th><th class="text-center">اﻻﺟﻤﺎﻟﻰ</th></tr>
            <tr><th colspan="5"> <?php echo e($order->discount); ?>% </th><th class="text-center">الخصم</th></tr>
            <?php  $discount = ( 100 - $order->discount) / 100;   ?>
            <tr><th colspan="5"><?php echo e($Afterdiscount =  number_format($order->total *  $discount,2)); ?></th><th class="text-center">الاجمالى بعد الخصم</th></tr>
            <tr><th colspan="5"> <?php echo e(number_format($order->deliveryfees,2,'.','')); ?></th><th class="text-center">ﺧﺪﻣﺔ اﻟﺘﻮﺻﻴﻞ</th></tr>
            <tr><th colspan="5"> <?php echo e($order->taxfees); ?></th><th class="text-center">الضريبه المضافه</th></tr>
            <?php if($order->voucher_amount > 0): ?>
              <tr><th colspan="5"> - <?php echo e(@$order->voucher_amount); ?></th><th class="text-center">قيمه القسيمه</th></tr>
            <?php endif; ?>
            <tr>
              <th colspan="5"><?php echo e(number_format( (str_replace(',','',$Afterdiscount) + $order->deliveryfees + $order->taxfees - ($order->voucher_amount)), 2)); ?> </th>
              <th class="text-center"> اﺟﻤﺎﻟﻰ اﻟﻔﺎﺗﻮﺭﻩ </th>
           </tr>
          </tfoot>
        </table>
     </div>
   </div>
</section>

  <div id="printTable" style="display:none">
    <style type="text/css" media="print">
      body {font-family: 'examplefont', sans-serif;  font-size: 13px !important;height: 500px !important; }
      #notprint   { display: none;}
      .orderitems table, .orderitems th, .orderitems td {  border-bottom: 3px dotted #ddd;}
      div{;margin:0px 0px 0px 0px  !important}
      table {border-collapse: collapse;}
      .header{background-color: #9f9c9c !important ;font-size: 18px;font-weight: bold;}
      .backColor{background-color: #9f9c9c !important ;}
      .page-break { display: table !important; page-break-after: always !important;height: auto !important}
      /* .page-break {break-after: always;break-inside: avoid;}       */
      /* @media  print {.page-break { display: table; page-break-after: always;}} */
    </style>

    <?php  use Carbon\Carbon;  ?>
    <?php  
      $created  = new Carbon($order->created_at);
      $updated  = new Carbon($order->updated_at);
      $ondelivery = new Carbon($order->ondelivery_at);
     ?>

  <div class="page-break"  >
    <!-- Head -->
    <table width="100%">
      <thead>
        <tr><td align="center" colspan="4"><img src="<?php echo e(asset('img/logo2.png')); ?>" style="display: block;margin-left: auto;margin-right: auto;width: 50%;" ></td></tr>
        <tr><td align="center" colspan="4" class="header">Tabali</td></tr>
        <tr><td align="center" colspan="4"><?php echo e($order->branch->name); ?></td></tr>      
        <tr><td align="center" colspan="4"><?php echo e($order->payment_type); ?></td></tr>       
        <tr>
          <td width="30%"></td>
          <td align="center" colspan="2" class="header"><?php echo e($order->orderid); ?></td>
          <td width="30%"></td>
        </tr>
        <tr>
          <td align="left" width="30%">Date </td>
          <td align="left" width="70%" colspan="3"><?php echo e($created->format('Y/m/d')); ?></td>
        </tr>
        <tr>
          <td align="left">Time </td>
          <td align="left" colspan="3"><?php echo e($created->format('A h:i:s')); ?></td>
        </tr>
        <tr>
          <td align="left">delivery</td>
          <td align="left" colspan="3"><?php if($order->driver_id): ?> <?php echo e($order->driver->name); ?> <?php endif; ?></td>
        </tr>
        <tr>
          <td align="left">Account </td>
          <td align="left" colspan="3"><?php echo e($order->account->account_name); ?></td>
        </tr>
        <tr>
          <td align="left">Name</td>
          <td align="left" colspan="3"><?php echo e($order->contact->contact_name); ?></td>
        </tr>
        <tr>
          <td align="left">Phone</td>
          <td align="left" colspan="3"><?php echo e($order->account->phone_number); ?> - <?php echo e($order->follow_up_phone); ?></td>
        </tr>
      </thead>
    </table>
    <table width="100%">
      <thead>
        <tr>
            <td align="left">Area </td>
            <td align="left" colspan="3"><?php echo e(@$order->address->area); ?> - <?php echo e(@$order->address->subdistrict); ?> -  <?php echo e(@$order->address->district); ?></td>
          </tr>
        <tr>
        <tr>
          <td align="left">Address </td>
          <td align="left" colspan="3"><?php echo e(@$order->address->address); ?></td>
        </tr>
          <td align="left">landmark</td>
          <td align="left"><?php echo e($order->address->landmark); ?></td>
          <td align="left">Building </td>
          <td align="left"><?php echo e($order->address->building_number); ?></td>
        </tr>
        <tr>
          <td align="left">Floor </td>
          <td align="left"><?php echo e(@$order->address->floor); ?></td>
          <td align="left">Apartment</td>
          <td align="left"><?php echo e(@$order->address->apartment); ?></td>
        </tr>                            
        <?php if(!empty($order->order_comment)): ?>
        <tr>
          <td class="backColor" align="center">Note</td>
          <td class="backColor" align="center" colspan="3"><?php echo e($order->order_comment); ?></td>  
        </tr>      
        <?php endif; ?>
      </thead>
    </table>
    <hr/>   
    <table class=orderitems width="100%">     
      <tr><td colspan="4" style="background-color: #9f9c9c;" align="center"></td></tr>
      <tbody>


        <!-- <tr class="text-center">
              <td align="center">Quantity</td>
              <td align="left">  Name</td>
              <td align="right"> Tprice </td>
        </tr> -->

        <?php foreach($order->items->where('version',$order->version) as $item): ?>
          <?php if(empty($item->extra_items)): ?>
            <tr class="text-center">
              <td align="center"><?php echo e(number_format($item->quantity ,-1,'','')); ?></td>
              <td align="left"><?php if(!empty($item->product->ar_name)): ?><?php echo e($item->product->ar_name); ?><?php endif; ?></td>
              <td align="right"> <?php echo e($item->tprice); ?></td>
            </tr>
            <?php if(!empty($item->item_comment)): ?> <tr class="backColor" ><td colspan="3"></span><?php echo e($item->item_comment); ?> </span></td></tr> <?php endif; ?>
          <?php endif; ?>
        <?php foreach($order->items->where('version',$order->version) as $value): ?>
          <?php if($value->extra_items == $item->id): ?>
          <tr style="background-color: darkgray">
            <td></td>
            <td align="left"><?php echo e($value->product->ar_name); ?></td>
            <td align="right"><?php echo e($value->tprice); ?></td>
          </tr>
          <?php if(!empty($item->item_comment)): ?> <tr class="backColor" ><td colspan="3"></span><?php echo e($item->item_comment); ?> </span></td></tr> <?php endif; ?>
          <?php endif; ?>
        <?php endforeach; ?>
        <?php endforeach; ?>
      </tbody>
      <tr><td colspan="4" style="background-color: #9f9c9c;" align="center"></td></tr>
    </table>  
    <table width="100%">
     <tbody>
      <tr>
        <td width="80%" align="left">Total</td>
        <td width="10%"></td>
        <td width="10%" align="right"><?php echo e($order->total); ?></td>
      </tr>
      <tr>
        <td width="80%" align="left">Discount</td>
        <td width="10%"></td>
        <td width="10%" align="right"><?php echo e($order->discount); ?></td>
      </tr>
     </tbody>
    </table>
    <hr/>
    <table width="100%">
     <tbody>
      <tr>
       <td width="80%" align="left" style="font-weight: bold;">Total After Discount</td>
       <td width="10%"></td>
       <?php  $discount = ( 100 - $order->discount) / 100;   ?>
       <td width="10%" align="right"><?php echo e($Afterdiscount =  number_format($order->total *  $discount,2)); ?></td>
      </tr>
      <tr>
       <td width="80%" align="left">Deliver Fees (+)</td>
       <td width="10%"></td>
       <td width="10%" align="right"><?php echo e($order->deliveryfees); ?></td>       
      </tr>
      <tr>
       <td width="80%" align="left">Tax (+)</td>
       <td width="10%"></td>
       <td width="10%" align="right"><?php echo e($order->taxfees); ?></td>
      </tr> 
      <?php if($order->voucher_amount > 0): ?>
        <tr>
          <td width="80%" align="left">Voucher Gift</td>
          <td width="10%"></td>
          <td width="10%" align="right"> - <?php echo e(@$order->voucher_amount); ?></td>
        </tr>               
      <?php endif; ?>
     </tbody>
    </table>
    <hr/>
    <table width="100%">
     <tbody>
      <tr>
        <td width="80%" align="left" style="font-weight: bold;">Total</td>
        <td width="10%"></td>
        <td width="10%" align="right"><?php echo e(number_format( (str_replace(',','',$Afterdiscount) + $order->deliveryfees + $order->taxfees   - ($order->voucher_amount) ), 2)); ?></td>
      </tr>
     </tbody>
    </table>
    <hr/>
    <!-- Voucher Code -->
    <?php if(@$order->Voucher->gift->name): ?>
      <div align="center" colspan="4" class="header"><?php echo e($order->Voucher->gift->name); ?></div>      
    <?php endif; ?>
    <!-- Voucher Code  -->
    <hr/>
    <div align="center" colspan="4" class="header"><?php echo e($order->source); ?> / <?php echo e($order->payment_method); ?></div>
    <!-- Voucher -->    
    <?php if((str_replace(',','',$Afterdiscount) + $order->deliveryfees + $order->taxfees) > 100  && $order->discount == 0  && $order->voucher_id == '' && date('Y') == 2019): ?>
      <img src="<?php echo e(asset('img/voucher.png')); ?>" style="display: block;margin-left: auto;margin-right: auto;/*width: 50%;*/" >
      <center><p style="display: block;margin-left: auto;margin-right: auto;">The total order is over 100 EL, so you deserve a gift voucher. Don't forget to ask the driver man</p> </center>
    <?php endif; ?>
    <!-- Voucher End-->
    <hr/>
  </div>   
</div>
<script type="text/javascript">
 //$(document).ready(function(){
 $(document).on('click','#PrintOrder',function(e){
   e.preventDefault();
      var restorepage = document.body.innerHTML;
      var printcontent = document.getElementById('printTable').innerHTML;
      document.body.innerHTML = printcontent;
      window.print();
       document.body.innerHTML = restorepage;
      location.reload();
    });
</script>
