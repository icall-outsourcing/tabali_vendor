<style>
  body{     
    /* max-width: 450px; */
    max-width: 500px;
    margin: auto;
    
   }
   td{font-size: 27px;}
   .header{background-color: #9f9c9c63;font-size: 35px;font-weight: bold;}
   .subHeader{font-size: 30px;}
   .backColor{background-color: #9f9c9c63 !important ;}
   .footer{background-color: #9f9c9c63;font-size: 35px;font-weight: bold;}

</style>

<body>
  <div>
    <!-- Head -->
    <table width="100%">
      <col width="25%" />
      <col width="25%" />
      <col width="25%" />
      <col width="25%" />
      <thead>
        <tr><td align="center" colspan="4"><img src="{{asset('img/logo2.png')}}" style="display:block;width: 270px;" ></td></tr>
        <tr><td align="center" colspan="4" class="header">Tabali</td></tr>
        <tr><td align="center" colspan="4" class="subHeader">{{$order->branch->name}}</td></tr>
        <tr><td align="center" colspan="4" class="subHeader">{{$order->payment_type}}</td></tr>
        <tr><td></td><td  align="center" colspan="2" class="header">{{$order->orderid}}</td><td></td></tr>
        <tr>
          <td align="left">Date: </td>
          <td align="left" colspan="3">{{$created->format('Y/m/d')}}</td>
        </tr>
        <tr>
          <td align="left">Time: </td>
          <td align="left" colspan="3">{{$created->format('A h:i:s')}}</td>
        </tr>
        <tr>
          <td align="left">Delivery: </td>
          <td align="left" colspan="3">@if($order->driver_id) {{$order->driver->name}} @endif</td>
        </tr>
        <tr>
          <td align="left">Account: </td>
          <td align="left" colspan="3">{{$order->account->account_name}}</td>
        </tr>
        <tr>
          <td align="left">Name: </td>
          <td align="left" colspan="3">{{$order->contact->contact_name}}</td>
        </tr>
        <tr>
          <td align="left">Phone: </td>
          <td align="left" colspan="3">{{$order->account->phone_number}} - {{$order->follow_up_phone}}</td>
        </tr>
        <tr>
            <td align="left">Area: </td>
            <td align="left" colspan="3">{{ @$order->address->area }} - {{ @$order->address->subdistrict}} -  {{ @$order->address->district}}</td>
        </tr>                      
        <tr>
          <td align="left">Address: </td>
          <td align="left" colspan="3">{{@$order->address->address}}</td>
        </tr>
          <td align="left">landmark: </td>
          <td align="left">{{$order->address->landmark}}</td>
          <td align="left">Building: </td>
          <td align="left">{{$order->address->building_number}}</td>
        </tr>
        <tr>
          <td align="left">Floor: </td>
          <td align="left">{{@$order->address->floor}}</td>
          <td align="left">Apartment: </td>
          <td align="left">{{@$order->address->apartment}}</td>
        </tr>                                    
        <tr>
          @if(!empty($order->order_comment))             
            <td class="backColor" align="center">Note: </td>
            <td class="backColor" align="center" colspan="3">{{@$order->order_comment}}</td>  
          @endif
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
        @foreach ($order->items->where('version',$order->version) as $item)
          @if(empty($item->extra_items))
            <tr class="text-center">
              <td align="center">{{number_format($item->quantity ,-1,'','')}}</td>
              <td align="left">@if(!empty($item->product->ar_name)){{$item->product->ar_name}}@endif</td>
              <td align="right"> {{$item->tprice / $item->quantity}}</td>
              <td align="right"> {{$item->tprice}}</td>
            </tr>
            @if(!empty($item->item_comment)) <tr class="backColor" ><td colspan="4"></span>{{$item->item_comment}} </span></td></tr> @endif
          @endif
        @foreach($order->items->where('version',$order->version) as $value)
          @if($value->extra_items == $item->id)
          <tr style="background-color: darkgray">
            <td></td>
            <td align="left">{{$value->product->ar_name}}</td>
            <td align="right">{{$value->tprice}}</td>
          </tr>
          @if(!empty($item->item_comment)) <tr class="backColor" ><td colspan="4"></span>{{$item->item_comment}} </span></td></tr> @endif
          @endif
        @endforeach
        @endforeach
      </tbody>
      <tr><td colspan="4" style="background-color: #9f9c9c;" align="center"></td></tr>
    </table>  
    <!-- End Items -->


    <!-- Total  -->
    <table width="100%">
     <tbody>
      <tr>
        <td width="80%" align="left">Total</td>
        <td width="10%" align="right">{{$order->total}}</td>
      </tr>
      <tr>
        <td width="80%" align="left">Discount</td>
        <td width="10%" align="right">{{$order->discount}}</td>
      </tr>    
      <tr>
       <td width="80%" align="left" style="font-weight: bold;">Total After Discount</td>
       <td width="10%" align="right">@php $discount = ( 100 - $order->discount) / 100;  @endphp{{ $Afterdiscount =  number_format($order->total *  $discount,2) }}</td>
      </tr>
      <tr>
       <td width="80%" align="left">Delivery Fees (+)</td>
       <td width="10%" align="right">{{$order->deliveryfees}}</td>       
      </tr>
      <tr>
       <td width="80%" align="left">Tax (+)</td>
       <td width="10%" align="right">{{$order->taxfees}}</td>
      </tr> 
      @if($order->voucher_amount > 0)
        <tr>
          <td width="80%" align="left">Voucher Gift</td>
          <td width="10%" align="right"> - {{@$order->voucher_amount}}</td>
        </tr>               
      @endif     
      <tr class="backColor">
        <td width="80%"  align="left" style="font-weight: bold;">Total</td>        
        <td width="10%"  align="right">{{number_format( (str_replace(',','',$Afterdiscount) + $order->deliveryfees + $order->taxfees   - ($order->voucher_amount) ), 2)}}</td>
      </tr>
     </tbody>
    </table>
    <!-- Total End  -->


    <!-- Voucher Code -->
      @if(@$order->Voucher->gift->name)
        <div align="center" colspan="4" class="header">{{$order->Voucher->gift->name}}</div>      
      @endif

      @if((str_replace(',','',$Afterdiscount) + $order->deliveryfees + $order->taxfees) > 100  && $order->discount == 0  && $order->voucher_id == '' && date('Y') == 2019)
      <img src="{{asset('img/voucher.png')}}" style="display: block;margin-left: auto;margin-right: auto;/*width: 50%;*/" >
      <center><p style="display: block;margin-left: auto;margin-right: auto;">The total order is over 100 EL, so you deserve a gift voucher. Don't forget to ask the driver man</p> </center>
      @endif
    <!-- Voucher End-->
    
    
    <div align="center" colspan="4" class="footer">{{$order->source}} / {{$order->payment_method}}</div>
  </div>   
</div>

</body>