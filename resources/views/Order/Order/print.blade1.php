<object ID="WebBrowser1" WIDTH="0" HEIGHT="0" CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></object>
<style type="text/css">
  /* .page-break {display: none;width: 250px} */
  table{margin-bottom:10px;}
  .orderitems table, .orderitems th, .orderitems td {border: 1px solid black;}
  .orderitems td{ padding: 2px;}
  .orderitems td{ padding: 2px;}
  @media print {#notprint   { display: none;}}
  @media print {.page-break { display: table; page-break-after: always;}}
  table {border-collapse: collapse;}
</style>
@php use Carbon\Carbon; @endphp
@foreach ($needPrint as $key => $value)
  @php 
      $order = \App\Order::find($value->id);
      $order->printed     =  'Y';
      $order->save();
  @endphp
        
  @php 
    $created  = new Carbon($order->created_at);
    $updated  = new Carbon($order->updated_at);
    $ondelivery = new Carbon($order->ondelivery_at);
  @endphp
  <div class="page-break" style="border-style:solid;border-color:black;" >
    <!-- Head -->
    <table width="100%">
      <thead>
        <tr><td align="center" colspan="4" style="color: white;background: black;">Tabali</td></tr>
        <tr><td align="center" colspan="4">{{$order->branch->name}}</td></tr>
        <tr><td align="center" colspan="4">{{$order->payment_type}}</td></tr>
        <tr><td colspan="1"></td><td align="center" colspan="2" style="color: white;background: black;">{{$order->orderid}}</td><td colspan="1"></td></tr>
        <tr>
          <td align="center" width="25%">Date </td>
          <td align="center" width="75%" colspan="3">{{$created->format('Y/m/d')}}</td>
        </tr>
        <tr>
          <td align="center">Time </td>
          <td align="center" colspan="3">{{$created->format('A h:i:s')}}</td>
        </tr>
        <tr>
          <td align="center">delivery Boy</td>
          <td align="center" colspan="3">@if($order->driver_id) {{$order->driver->name}} @endif</td>
        </tr>
        <tr>
          <td align="center">Account </td>
          <td align="center" colspan="3">{{$order->account->account_name}}</td>
        </tr>
        <tr>
          <td align="center">ClientName</td>
          <td align="center" colspan="3">{{$order->contact->contact_name}}</td>
        </tr>
        <tr>
          <td align="center">Phone</td>
          <td align="center" colspan="3">{{$order->account->phone_number}} - {{$order->follow_up_phone}}</td>
        </tr>
        <tr>
          <td align="center">landmark</td>
          <td align="center" colspan="3">{{$order->address->landmark}}</td>
        </tr>


        
        
        <tr>
          <td align="center" colspan="3">@if($order->ondelivery_at) {{$ondelivery->format('A h:i:s Y/m/d')}} @endif</td>
          <td align="center"> : ﺧﺮﻭﺝ </td>
        </tr>
        <tr>
          <td align="center" colspan="3">{{$order->address->area}} - {{$order->address->subdistrict}} -  {{$order->address->district}}</td>
          <td align="center"> : ﻣﻨﻄﻘﺔ </td>
        </tr>

        <tr>
          <td align="center" colspan="3">, {{$order->address->address}}</td>
          <td align="center"> : اﻟﻌﻨﻮاﻥ</td>
        </tr>
                                      <tr>
          <td align="center" colspan="3">{{$order->address->building_number}}</td>
          <td align="center"> ﺭﻗﻢ اﻟﻤﺒﻨﻰ :</td>
        </tr>
        <tr>
          <td align="center">{{$order->address->floor}}</td>
          <td align="center"> : اﻟﺪﻭﺭ</td>
          <td align="center">{{$order->address->apartment}}</td>
          <td align="center"> : ﺭﻗﻢ اﻟﺸﻘﺔ</td>
        </tr>

        @if(!empty($order->order_comment))
        <tr  style="background-color: #9f9c9c;color: white;">
          <td align="center" colspan="3">{{$order->order_comment}}</td>
          <td align="center"> : ﻣﻼﺣﻈﺎﺕ</td>
        </tr>
        @endif
      </thead>
    </table>
    <!-- End Head -->
    <!-- items -->
    <table class=orderitems width="100%">
      <thead>
        <tr>
          <td width="10%">اﻟﺴﻌﺮ</td>
          <td width="10%">اﻟﻜﻤﻴﺔ</td>
          <td width="80%" align="right">اﻟﺼﻨﻒ</td>
        </tr>
      </thead>
      <tbody>
        @foreach ($order->items->where('version',$order->version) as $item)
          @if(empty($item->extra_items))
            <tr class="text-center">
              <td>{{$item->tprice}}</td>
              <td align="center">{{number_format($item->quantity ,-1,'','')}}</td>
              <td align="right">@if(!empty($item->product->ar_name)){{$item->product->ar_name}}@endif</td>
            </tr>
            @if($item->item_comment != '')
              <tr style="background-color: #9f9c9c;color:#fff">                 
                <td colspan="3" align="right">{{$item->item_comment}}</td>
              </tr>
            @endif
          @endif
          @foreach($order->items->where('version',$order->version) as $value)
            @if($value->extra_items == $item->id)
            <tr style="background-color: #9f9c9c;color:#fff">
              <td>{{$value->tprice}}</td>
              <td  align="center">
                {{number_format($item->quantity ,-1,'','')}}
              </td>
              <td colspan="2" align="right">
                {{$value->product->ar_name}} 
              </td>
            </tr>
            @endif
          @endforeach
        @endforeach
      </tbody>
    </table>
    <!-- End items -->
    <table width="100%">
      <tbody>
        <tr>
          <td width="10%">{{$order->total}}</td>
          <td width="10%"></td>
          <td width="80%" align="right"> : اﺟﻤﺎﻟﻰ اﻻﺻﻨﺎﻑ</td>
        </tr>
      </tbody>
    </table>
    <hr/>
    <table width="100%">
      <tbody>
        <tr>
          <td width="10%">{{$order->deliveryfees}}</td>
          <td width="10%"></td>
          <td width="80%" align="right"> : ﻣﺼﺎﺭﻳﻒ اﻟﺘﻮﺻﻴﻞ</td>
        </tr>
      </tbody>
    </table>
    <hr/>
    <table width="100%">
      <tbody>
        <tr>
          <td width="10%">{{$order->total + $order->deliveryfees}}</td>
          <td width="10%"></td>
          <td width="80%" align="right"> : اﻻﺟﻤﺎﻟﻰ</td>
        </tr>
      </tbody>
    </table>
    <hr/>
  </div>
  @php 
    $orderItemsver= $order->version - 1 ;
    $orderItems   = $order->items->where('flagtoprint','N')->lists('product_id','id')->toArray();
    $orderSection = \App\Product::whereIn('id', $orderItems)->groupBy('sectionid')->lists('sectiongroup','sectionid')->toArray();
    $totalextra   = \App\Product::where('extra', 1)->lists('id','id')->toArray();
    $checkextras  = DB::table('order_items')->where('order_id', $order->id)->whereIn('product_id',$totalextra)->where(function ($query) {$query->WhereNull('extra_items')->orWhere('extra_items', '=', 0);})->count();
  @endphp

  @php $extra_items = array() @endphp
  @if($driver == 'driver')
  @else
    @foreach ($orderSection as $key => $section)
      @if($key == '9')
        @if($checkextras > 0)
          <div class="page-break" id="{{$key}}">
            <center>#{{$order->orderid}}<h4 style="font-size: 22px;font-weight: bold;">{{$section}}</h4></center>
            <table class="orderitems" style="width:100%;font-size: 20px;font-weight: bold;">
              <thead>
                <tr>
                  <td width="10%"> اﻟﻜﻤﻴﻪ </td>
                  <td width="90%"  align="right"> اﻟﺼﻨﻒ </td>
                </tr>
              </thead>
              @foreach ($order->items->where('version',$order->version)->where('extra_items',null) as $item)
                <!-- check if it extra items -->
                @if ($item->product->section_name == $section)
                  @if(in_array($item->id, $extra_items)  == false)
                    <tbody>
                      <!-- check if it new or add or edit -->
                      @if($item->printeraction == 'new')
                          <tr>
                            <td>{{$item->quantity}}</td>
                            <td align="right">{{$item->product->ar_name}} </td>
                          </tr>
                          <!-- check the comment  -->
                          @if(!empty($item->item_comment))
                            <tr style="background-color: #9f9c9c;color: white;">
                               <td colspan="2" align="right">
                                </span>{{$item->item_comment}} </span>
                              </td>
                            </tr>
                          @endif
                          <!-- check if there is extra items -->
                          @foreach($order->items->where('version',$order->version) as $value)
                            @if($value->extra_items == $item->id)
                              @php $extra_items[$value->id] = $value->id @endphp
                              <tr style="background-color: #9f9c9c;color: white;">
                                 <td colspan="2" align="right">
                                  </span>{{$value->product->ar_name}} </span>
                                </td>
                              </tr>
                            @endif
                          @endforeach
                      @elseif($item->printeraction == 'add')
                          <tr><td colspan="2" align="right" style="background-color: #d9d7d7">أضا فه جديده </td></tr>
                          <tr>
                            <td>{{$item->quantity}}</td>
                            <td align="right">{{$item->product->ar_name}} </td>
                          </tr>
                          <!-- check the comment  -->
                          @if(!empty($item->item_comment))
                            <tr style="background-color: #9f9c9c;color: white;">
                               <td colspan="2" align="right">
                                </span>{{$item->item_comment}} </span>
                              </td>
                            </tr>
                          @endif
                          <!-- check if there is extra items -->
                          @foreach($order->items->where('version',$order->version) as $value)
                            @if($value->extra_items == $item->id)
                              @php $extra_items[$value->id] = $value->id @endphp
                              <tr style="background-color: #9f9c9c;color: white;">
                                 <td colspan="2" align="right">
                                  </span>{{$value->product->ar_name}} </span>
                                </td>
                              </tr>
                            @endif
                          @endforeach
                      @elseif($item->printeraction == 'edit' && $item->oldid > 0)
                        @php $olditems = \App\OrderItem::find($item->oldid); @endphp
                        <!-- check if items add or remove or edit -->
                        @if($item->quantity > $olditems->quantity)
                          @php $total  = $item->quantity - $olditems->quantity @endphp
                        @else
                          @php $total  = $olditems->quantity - $item->quantity @endphp
                        @endif
                        @if($item->extra_items != $olditems->extra_items ||  $item->quantity != $olditems->quantity ||  $item->tprice != $olditems->tprice || $item->item_comment != $olditems->item_comment )
                          <tbody>
                            <!-- Add -->
                            @if($item->quantity > $olditems->quantity )
                              <tr><td colspan="2" align="right" style="background-color: #d9d7d7">اضافه </td></tr>
                              <tr>
                                <td>{{$total}}</td>
                                <td align="right">{{$item->product->ar_name}} </td>
                              </tr>
                            <!-- Nothing -->
                            @elseif($item->quantity == $olditems->quantity)
                              <tr><td colspan="2" align="right" style="background-color: #d9d7d7">تعديل </td></tr>
                              <tr>
                                <td>{{$item->quantity}}</td>
                                <td align="right">{{$item->product->ar_name}} </td>
                              </tr>
                            <!-- remove -->
                            @else
                              <tr><td colspan="2" align="right" style="background-color: #d9d7d7">حذف </td></tr>
                              <tr>
                                <td>{{$total}}</td>
                                <td align="right">{{$item->product->ar_name}} </td>
                              </tr>
                            @endif
                              <!-- check the comment  -->
                              @if(!empty($item->item_comment))
                                <tr style="background-color: #9f9c9c;color: white;">
                                   <td colspan="2" align="right">
                                    </span>{{$item->item_comment}} </span>
                                  </td>
                                </tr>
                              @endif
                              <!-- check Extra Items -->
                              @foreach($order->items->where('version',$order->version) as $value)
                                @if($value->extra_items == $item->id)
                                @php $extra_items[$value->id] = $value->id @endphp
                                <tr style="background-color: #9f9c9c;color: white;">
                                   <td colspan="2" align="right">
                                    </span>{{$value->product->ar_name}} </span>
                                  </td>
                                </tr>
                                @endif
                              @endforeach
                          </tbody>
                        @endif
                      @endif
                    </tbody>
                  @endif
                @endif
              @endforeach


            @php 
               $excountRemoveItems = 0;
               $exversion            = $order->version - 1;
            @endphp
            @foreach ( \App\OrderItem::where('order_id',$order->id)->where('version',$exversion)->where('printeraction','remove')->get() as $remove)
              @if ($remove->product->sectiongroup == $section)
                @if(in_array($remove->id, $extra_items) == false)
                  <tbody>
                    @if($excountRemoveItems++  < 1)
                    @endif
                    <tr> <td colspan="2" align="right" style="background-color: #d9d7d7"> ﻟﻘﺪ ﺗﻢ ﺣﺬﻑ </td> </tr>
                    <tr style="color: #fff;background-color:#4e4f4e;">
                      <td>{{$remove->quantity}}</td>
                      <td align="right">{{$remove->product->ar_name}} {{$excountRemoveItems}}</td>
                    </tr>
                    @if(!empty($remove->item_comment))
                      <tr style="color: #fff;background-color:#4e4f4e;">
                         <td colspan="2" align="right">
                          </span>{{$remove->item_comment}} </span>
                        </td>
                      </tr>
                    @endif
                    @foreach($order->items->where('version',$order->version-1)->where('printeraction','remove') as $value)
                      @if($value->extra_items == $remove->id)
                      @php $extra_items[$value->id] = $value->id @endphp
                      <tr style="color: #fff;background-color:#4e4f4e;">
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
        <div class="page-break" id="{{$key}}">
          <center>#{{$order->orderid}}<h4 style="font-size: 22px;font-weight: bold;">{{$section}}</h4></center>
          <table class="orderitems" style="width:100%;font-size: 20px;font-weight: bold;">
            <thead>
              <tr>
                <td width="10%"> اﻟﻜﻤﻴﻪ </td>
                <td width="90%" align="right"> اﻟﺼﻨﻒ </td>
              </tr>
            </thead>
            <!-- Check new items -->
            @foreach ($order->items->where('version',$order->version) as $item)
              <!-- check the sectiongroup -->
              @if ($item->product->sectiongroup == $section)
                <!-- check if items in Extra or not -->
                @if(in_array($item->id, $extra_items) == false)
                  <tbody>
                    <!-- check if it new or add or edit -->
                    @if($item->printeraction     == 'new')
                        <tr>
                          <td>{{$item->quantity}}</td>
                          <td align="right">{{$item->product->ar_name}} </td>
                        </tr>
                        <!-- check the comment  -->
                        @if(!empty($item->item_comment))
                          <tr style="background-color: #9f9c9c;color: white;">
                             <td colspan="2" align="right">
                              </span>{{$item->item_comment}} </span>
                            </td>
                          </tr>
                        @endif
                        <!-- check if there is extra items -->
                        @foreach($order->items->where('version',$order->version) as $value)
                          @if($value->extra_items == $item->id)
                            @php $extra_items[$value->id] = $value->id @endphp
                            <tr style="background-color: #9f9c9c;color: white;">
                               <td colspan="2" align="right">
                                </span>{{$value->product->ar_name}} </span>
                              </td>
                            </tr>
                          @endif
                        @endforeach
                    @elseif($item->printeraction == 'add')
                        <tr><td colspan="2" align="right" style="background-color: #d9d7d7">أضا فه جديده </td></tr>
                        <tr>
                          <td>{{$item->quantity}}</td>
                          <td align="right">{{$item->product->ar_name}} </td>
                        </tr>
                        <!-- check the comment  -->
                        @if(!empty($item->item_comment))
                          <tr style="background-color: #9f9c9c;color: white;">
                             <td colspan="2" align="right">
                              </span>{{$item->item_comment}} </span>
                            </td>
                          </tr>
                        @endif
                        <!-- check if there is extra items -->
                        @foreach($order->items->where('version',$order->version) as $value)
                          @if($value->extra_items == $item->id)
                            @php $extra_items[$value->id] = $value->id @endphp
                            <tr style="background-color: #9f9c9c;color: white;">
                               <td colspan="2" align="right">
                                </span>{{$value->product->ar_name}} </span>
                              </td>
                            </tr>
                          @endif
                        @endforeach
                    @elseif($item->printeraction == 'edit' && $item->oldid > 0)
                      @php $olditems = \App\OrderItem::find($item->oldid); @endphp
                      <!-- check if items add or remove or edit -->
                      @if($item->quantity > $olditems->quantity)
                        @php $total  = $item->quantity - $olditems->quantity @endphp
                      @else
                        @php $total  = $olditems->quantity - $item->quantity @endphp
                      @endif
                      @if($item->extra_items  != $olditems->extra_items  ||  $item->quantity     != $olditems->quantity     ||  $item->tprice       != $olditems->tprice       || $item->item_comment != $olditems->item_comment )
                        <tbody>
                          <!-- Add -->
                          @if($item->quantity > $olditems->quantity )
                            <tr><td colspan="2" align="right"  style="background-color: #d9d7d7">اضافه </td></tr>
                            <tr>
                              <td>{{$total}}</td>
                              <td align="right">{{$item->product->ar_name}} </td>
                            </tr>
                          <!-- Nothing -->
                          @elseif($item->quantity == $olditems->quantity)
                            <tr><td colspan="2" align="right"  style="background-color: #d9d7d7">تعديل </td></tr>
                            <tr>
                              <td>{{$item->quantity}}</td>
                              <td align="right">{{$item->product->ar_name}} </td>
                            </tr>
                          <!-- remove -->
                          @else
                            <tr><td colspan="2" align="right"  style="background-color: #d9d7d7">حذف </td></tr>
                            <tr>
                              <td>{{$total}}</td>
                              <td align="right">{{$item->product->ar_name}} </td>
                            </tr>
                          @endif
                            <!-- check the comment  -->
                            @if(!empty($item->item_comment))
                              <tr style="background-color: #9f9c9c;color: white;">
                                 <td colspan="2" align="right">
                                  </span>{{$item->item_comment}} </span>
                                </td>
                              </tr>
                            @endif
                            <!-- check Extra Items -->
                            @foreach($order->items->where('version',$order->version) as $value)
                              @if($value->extra_items == $item->id)
                              @php $extra_items[$value->id] = $value->id @endphp
                              <tr style="background-color: #9f9c9c;color: white;">
                                 <td colspan="2" align="right">
                                  </span>{{$value->product->ar_name}} </span>
                                </td>
                              </tr>
                              @endif
                            @endforeach
                        </tbody>
                      @endif
                    @endif
                  </tbody>
                @endif
              @endif
            @endforeach



            <!-- Remove Items from delete button -->
            @php 
               $countRemoveItems = 0;
               $version          = $order->version - 1;
            @endphp
            @foreach ( \App\OrderItem::where('order_id',$order->id)->where('version',$version)->where('printeraction','remove')->get() as $remove)
              @if ($remove->product->sectiongroup == $section)
                @if(in_array($remove->id, $extra_items) == false)
                  <tbody>
                    @if($countRemoveItems++  < 1)
                      <tr> <td colspan="2" align="right" style="background-color: #d9d7d7"> ﻟﻘﺪ ﺗﻢ ﺣﺬﻑ </td> </tr>
                      <tr style="color: #fff;background-color:#4e4f4e;">
                        <td>{{$remove->quantity}}</td>
                        <td align="right">{{$remove->product->ar_name}} {{$countRemoveItems}}</td>
                      </tr>
                      @if(!empty($remove->item_comment))
                        <tr style="color: #fff;background-color:#4e4f4e;">
                           <td colspan="2" align="right">
                            </span>{{$remove->item_comment}} </span>
                          </td>
                        </tr>
                      @endif
                      @foreach($order->items->where('version',$order->version-1)->where('printeraction','remove') as $value)
                        @if($value->extra_items == $remove->id)
                        @php $extra_items[$value->id] = $value->id @endphp
                        <tr style="color: #fff;background-color:#4e4f4e;">
                           <td colspan="2" align="right">
                            </span>{{$value->product->ar_name}} </span>
                          </td>
                        </tr>
                        @endif
                      @endforeach
                    @endif
                  </tbody>
                @endif
              @endif

            @endforeach
          </table>
        </div> 
      @endif
    @endforeach
  @endif
  @php
    $orderItems = \App\OrderItem::where('order_id',$order->id)->update(['flagtoprint' => 'Y','updateorder'=>'printed']);
  @endphp
@endforeach