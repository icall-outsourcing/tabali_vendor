<!-- language -->
  <?php if(session()->has('lang')): ?>
      <?php echo e(App::setLocale(session()->get('lang'))); ?>

  <?php else: ?>
      <?php echo e(App::setLocale('ar')); ?>

  <?php endif; ?>
<center><a href="#" id="PrintOrder" class="btn btn-warning btn-sm"><i class="fa fa-print">print</i></a></center>
<section class="invoice printTable">
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
    table.products td {
      text-align: right;
    }
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
                 <tr>
            <th colspan="5"> <?php echo e(number_format($order->total,2,'.','')); ?></th>
            <th class="text-center">اﻻﺟﻤﺎﻟﻰ</th>
           </tr>

           <tr>
            <th colspan="5"> <?php echo e(number_format($order->deliveryfees,2,'.','')); ?></th>
            <th class="text-center">ﺧﺪﻣﺔ اﻟﺘﻮﺻﻴﻞ</th>
           </tr>
           <!-- <tr>
            <th colspan="5"> <?php echo e(number_format($order->taxfees,2,'.','')); ?> </th>
            <th class="text-center">14% اﻟﻘﻴﻤﻪ اﻟﻤﻀﺎﻓﻪ</th>
           </tr> -->
                    <tr>
            <th colspan="5"> <?php echo e(number_format($order->total + $order->deliveryfees,2,'.','')); ?> </th>
            <th class="text-center"> اﺟﻤﺎﻟﻰ اﻟﻔﺎﺗﻮﺭﻩ </th>
           </tr>
          </tfoot>
        </table>
     </div>
   </div>
</section>











  <div id="printTable">
   <style type="text/css">
    .page-break {display: none;width: 250px}
    table{margin-bottom:10px;}
    .orderitems table, .orderitems th, .orderitems td {  border-bottom: 1px dotted #ddd;}
    .orderitems td{ padding: 2px;}
    .orderitems td{ padding: 2px;}
    @media  print {#notprint   { display: none;}}
    @media  print {.page-break { display: table; page-break-after: always;}}
    table {border-collapse: collapse;}
   </style>
   <?php  use Carbon\Carbon;  ?>
   <?php  
    $created  = new Carbon($order->created_at);
    $updated  = new Carbon($order->updated_at);
    $ondelivery = new Carbon($order->ondelivery_at);
    ?>
   <div class="page-break" style="padding: 9px;">
    <!-- Head -->
    <table width="100%">
     <thead>
      <tr><td align="center" colspan="4" style="background-color: black;color:white">Tabali</td></tr>
      <tr><td align="center" colspan="4"><?php echo e($order->branch->name); ?></td></tr>
      <tr><td align="center" colspan="4"><?php echo e($order->payment_type); ?></td></tr>
      <tr><td></td><td align="center" colspan="2" style="background-color: black;color:white"><?php echo e($order->orderid); ?></td><td></td></tr>       

      <tr>
        <td width="25%">Date</td>
       <td align="center" width="75%" colspan="3"><?php echo e($created->format('Y/m/d')); ?></td>
      </tr>

      <tr>
        <td>Time</td>
       <td align="center" colspan="3"><?php echo e($created->format('A h:i')); ?></td>
      </tr>

      <tr>
        <td>DliveryBoy</td>
       <td align="center" colspan="3"><?php if($order->driver_id): ?> <?php echo e($order->driver->name); ?> <?php endif; ?></td>
      </tr>
      
      <tr>
        <td>ClientName</td>
        <td align="center" colspan="3"><?php echo e($order->account->account_name); ?></td>
      </tr>

      <tr>
        <td>Phone</td>
        <td align="center" colspan="3"><?php echo e($order->account->phone_number); ?></td>
      </tr>
      <tr>
        <td>Area</td>
       <td align="center" colspan="3"><?php echo e($order->address->area); ?> - <?php echo e($order->address->subdistrict); ?> -  <?php echo e($order->address->district); ?></td>
      </tr>
      <tr>
        <td>Landmark</td>
        <td align="center" colspan="3"><?php echo e($order->address->landmark); ?></td>
      </tr>
      <tr>
        <td>Address</td>
        <td align="center" colspan="3">, <?php echo e($order->address->address); ?></td>
      </tr>
      <tr>
      <td>Floor</td>
       <td align="center"><?php echo e($order->address->floor); ?></td>
       <td>Apartment</td>
       <td align="center"><?php echo e($order->address->apartment); ?></td>
      </tr>
      <?php if(!empty($order->order_comment)): ?>
      <tr  style="background-color: #454444;color: white;">
        <td align="center">Note</td>
        <td align="center" colspan="3"><?php echo e($order->order_comment); ?></td>
      </tr>
      <?php endif; ?>
     </thead>
    </table>
    <!-- End Head -->
    <!-- items -->
    <table class=orderitems width="100%">     
     <tbody>
      <?php foreach($order->items->where('version',$order->version) as $item): ?>
        <?php if(empty($item->extra_items)): ?>
          <tr class="text-center">
            <td align="center"><?php echo e(number_format($item->quantity ,-1,'','')); ?></td>
            <td align="left"><?php if(!empty($item->product->ar_name)): ?><?php echo e($item->product->ar_name); ?><?php endif; ?></td>
            <td align="right"> <?php echo e($item->tprice); ?></td>
          </tr>
        <?php endif; ?>
       <?php foreach($order->items->where('version',$order->version) as $value): ?>
        <?php if($value->extra_items == $item->id): ?>
        <tr style="background-color: darkgray">
          <td></td>
          <td align="left"><?php echo e($value->product->ar_name); ?></td>
          <td align="right"><?php echo e($value->tprice); ?></td>
        </tr>
        <?php endif; ?>
       <?php endforeach; ?>
      <?php endforeach; ?>
     </tbody>
    </table>
    <!-- End items -->
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
        <td width="10%" align="right">0</td>
      </tr>
     </tbody>
    </table>
    <hr/>
    <table width="100%">
     <tbody>
      <tr>
       <td width="80%" align="left" style="font-weight: bold;">Total After Discount</td>
       <td width="10%"></td>
       <td width="10%" align="right"><?php echo e($order->total); ?></td>
      </tr>


      <tr>
       <td width="80%" align="left">Service (+)</td>
       <td width="10%"></td>
       <td width="10%" align="right"><?php echo e(($order->total + $order->deliveryfees) * 0.14); ?></td>
      </tr>
      <tr>
       <td width="80%" align="left">Tax (+)</td>
       <td width="10%"></td>
       <td width="10%" align="right"><?php echo e($order->total); ?></td>
      </tr>      
     </tbody>
    </table>
    <hr/>
    <table width="100%">
     <tbody>
      <tr>
        <td width="80%" align="right">Total</td>
        <td width="10%"></td>
        <td width="10%" align="right"><?php echo e($order->total + $order->deliveryfees); ?></td>
      </tr>
     </tbody>
    </table>
   </div>
   
<?php /*

   @php 
    $orderItems  = $order->items->where('version',$order->version)->lists('product_id','id')->toArray();
    $orderSection   = \App\Product::whereIn('id', $orderItems)->groupBy('sectionid')->lists('section_name','sectionid')->toArray();
    $totalextra  = \App\Product::where('extra', 1)->lists('id','id')->toArray();
    $checkextras  = DB::table('order_items')->where('order_id', $order->id)->whereIn('product_id',$totalextra)->where(function ($query) {$query->WhereNull('extra_items')->orWhere('extra_items', '=', 0);})->count();
   @endphp
   @php $extra_items = array() @endphp
   @foreach ($orderSection as $section)
    @if($section == 'اﻷﺿﺎﻓﺎﺕ ﻭ اﻟﺒﺪﻭﻥ')
     @if($checkextras > 0)
      <div class="page-break">
       <center><h4>{{$section}} #{{$order->orderid}}</h4></center>
       <table class="orderitems" style="width:100%">
        <thead>
         <tr>
          <td width="10%"> اﻟﻜﻤﻴﻪ </td>
          <td width="90%"  align="right"> اﻟﺼﻨﻒ </td>
         </tr>
        </thead>
       @foreach ($order->items->where('version',$order->version) as $item)
        @if ($item->product->section_name == $section)
         @if(in_array($item->id, $extra_items))
         @else
          <tbody>
           <tr>
            <td>{{$item->quantity}} </td>
            <td align="right">{{$item->product->ar_name}} </td>
           </tr>
           @if(!empty($item->item_comment))
            <tr style="background-color: #454444;color: white;">
              <td colspan="2" align="right">
               </span>{{$item->item_comment}} </span>
             </td>
            </tr>
           @endif
           @foreach($order->items->where('version',$order->version) as $value)
            @if($value->extra_items == $item->id)
            @php $extra_items[$value->id] = $value->id @endphp
            <tr style="background-color: #454444;color: white;">
              <td colspan="2" align="right">
               </span>{{$value->product->ar_name}} </span>
             </td>
            </tr>
            @endif
           @endforeach
          </tbody>
         @endif
        @endif
       @endforeach 
       </table>
      </div>
     @endif
    @else
     <div class="page-break">
      <center><h4>{{$section}} #{{$order->orderid}}</h4></center>
      <table class="orderitems" style="width:100%">
       <thead>
        <tr>
         <td width="10%"> اﻟﻜﻤﻴﻪ </td>
         <td width="90%" align="right"> اﻟﺼﻨﻒ </td>
        </tr>
       </thead>
      @foreach ($order->items->where('version',$order->version) as $item)
       @if ($item->product->section_name == $section)
        @if(in_array($item->id, $extra_items))
        @else
         <tbody>
          <tr>
           <td>{{$item->quantity}} </td>
           <td align="right">{{$item->product->ar_name}} </td>
          </tr>
          @if(!empty($item->item_comment))
           <tr style="background-color: #454444;color: white;">
             <td colspan="2" align="right">
              </span>{{$item->item_comment}} </span>
            </td>
           </tr>
          @endif
          @foreach($order->items->where('version',$order->version) as $value)
           @if($value->extra_items == $item->id)
           @php $extra_items[$value->id] = $value->id @endphp
           <tr style="background-color: #454444;color: white;">
             <td colspan="2" align="right">
              </span>{{$value->product->ar_name}} </span>
            </td>
           </tr>
           @endif
          @endforeach
         </tbody>
        @endif
       @endif
      @endforeach 
      </table>
     </div>
    @endif
   @endforeach
  </div>
*/?>
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