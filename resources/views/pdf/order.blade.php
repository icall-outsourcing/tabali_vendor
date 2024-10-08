<!DOCTYPE html>

<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <title>Print Order Number #</title>    
    <style type="text/css" media="print">
      body {font-family: 'examplefont', sans-serif;  font-size: 13px !important;}
      .orderitems table, .orderitems th, .orderitems td {  border-bottom: 3px dotted #ddd;}
      /* .page-break {break-after: always;break-inside: avoid;}       */
      .page-break { display: table; page-break-after: always;}
      /* @media print {.page-break { display: table; page-break-after: always;}} */
      div{;margin:0px -10px 0px -40px  !important}
      table {border-collapse: collapse;}
      .line-break{background-color: #9f9c9c;font-size: 18px;font-weight: bold;}
    </style>
  </head>
  <body>
    @php use Carbon\Carbon; @endphp
    @foreach ($needPrint as $key => $value)
        @php 
            $order = \App\Order::find($value->id);
        @endphp    
              
        @php 
          $created  = new Carbon($order->created_at);
          $updated  = new Carbon($order->updated_at);
          $ondelivery = new Carbon($order->ondelivery_at);
        @endphp
        @if (in_array(0, $sectiontoprint)) 
          <div class="page-break" style="border-style:solid;border-color:black" >
            <!-- Head -->
            <table width="100%">
              <thead>
                <tr><td align="center" colspan="4"><img src="{{asset('img/logo2.png')}}" style="display: block;margin-left: auto;margin-right: auto;width: 50%;" ></td></tr>
                <tr><td align="center" colspan="4" style="background-color: #9f9c9c;font-size: 18px;font-weight: bold;">Tabali</td></tr>
                <tr><td align="center" colspan="4">{{$order->branch->name}}</td></tr>
                <tr><td align="center" colspan="4">{{$order->payment_type}}</td></tr>       
                <tr>
                  <td width="30%"></td>
                  <td align="center" colspan="2" style="background-color: #9f9c9c;font-size: 18px;font-weight: bold;">{{$order->orderid}}</td>
                  <td width="30%"></td>
                </tr>
                <tr>
                  <td align="left" width="30%">Date </td>
                  <td align="left" width="70%" colspan="3">{{$created->format('Y/m/d')}}</td>
                </tr>
                <tr>
                  <td align="left">Time </td>
                  <td align="left" colspan="3">{{$created->format('A h:i:s')}}</td>
                </tr>
                <tr>
                  <td align="left">delivery</td>
                  <td align="left" colspan="3">@if($order->driver_id) {{$order->driver->name}} @endif</td>
                </tr>
                <tr>
                  <td align="left">Account </td>
                  <td align="left" colspan="3">{{$order->account->account_name}}</td>
                </tr>
                <tr>
                  <td align="left">Name</td>
                  <td align="left" colspan="3">{{$order->contact->contact_name}}</td>
                </tr>
                <tr>
                  <td align="left">Phone</td>
                  <td align="left" colspan="3">{{$order->account->phone_number}} - {{$order->follow_up_phone}}</td>
                </tr>
              </thead>
            </table>
            <table width="100%">
              <thead>
                <tr>
                  <td align="left">Area </td>
                  <td align="left" colspan="3">{{ @$order->address->area }} - {{ @$order->address->subdistrict}} -  {{ @$order->address->district}}</td>
                </tr>
                <tr>
                  <td align="left">Address </td>
                  <td align="left" colspan="3">{{@$order->address->address}}</td>
                </tr>
                <tr>
                  <td align="left">landmark</td>
                  <td align="left">{{$order->address->landmark}}</td>
                  <td align="left">Building </td>
                  <td align="left">{{$order->address->building_number}}</td>
                </tr>
                <tr>
                  <td align="left">Floor </td>
                  <td align="left">{{@$order->address->floor}}</td>
                  <td align="left">Apartment</td>
                  <td align="left">{{@$order->address->apartment}}</td>
                </tr>                            
                @if(!empty($order->order_comment))
                <tr>
                  <td style="background-color: #9f9c9c;" align="center">Note</td>
                  <td style="background-color: #9f9c9c;;" align="center" colspan="3">{{$order->order_comment}}</td>  
                </tr>      
                @endif
              </thead>
            </table>
            <hr/>   
            <table class=orderitems width="100%">     
              <tr><td colspan="4" style="background-color: #9f9c9c;" align="center"></td></tr>
              <tbody>
                @foreach ($order->items->where('version',$order->version) as $item)
                  @if(empty($item->extra_items))
                    <tr class="text-center">
                      <td align="center">{{number_format($item->quantity ,-1,'','')}}</td>
                      <td align="left">@if(!empty($item->product->ar_name)){{$item->product->ar_name}}@endif </td>
                      <td align="right"> {{$item->tprice}}</td>
                    </tr>
                    @if(!empty($item->item_comment)) <tr style="background-color: #9f9c9c;color: white;"><td colspan="3"></span>{{$item->item_comment}} </span></td></tr> @endif
                  @endif
                @foreach($order->items->where('version',$order->version) as $value)
                  @if($value->extra_items == $item->id)
                  <tr style="background-color: darkgray">
                    <td></td>
                    <td align="left">{{$value->product->ar_name}}</td>
                    <td align="right">{{$value->tprice}}</td>
                  </tr>
                  @if(!empty($item->item_comment)) <tr style="background-color: #9f9c9c;color: white;"><td colspan="3"></span>{{$item->item_comment}} </span></td></tr> @endif
                  @endif
                @endforeach
                @endforeach
              </tbody>
              <tr><td colspan="4" style="background-color: #9f9c9c;" align="center"></td></tr>
            </table>  
            <table width="100%">
            <tbody>
              <tr>
                <td width="80%" align="left">Total</td>
                <td width="10%"></td>
                <td width="10%" align="right">{{$order->total}}</td>
              </tr>
              <tr>
                <td width="80%" align="left">Discount</td>
                <td width="10%"></td>
                <td width="10%" align="right">{{$order->discount}}%</td>
              </tr>
            </tbody>
            </table>
            <hr/>
            <table width="100%">
            <tbody>
              <tr>
              <td width="80%" align="left" style="font-weight: bold;">Total After Discount</td>
              <td width="10%"></td>
              @php $discount = ( 100 - $order->discount) / 100;  @endphp
              
              <td width="10%" align="right">{{ $Afterdiscount =  number_format($order->total *  $discount,2) }} </td>
              </tr>
              <tr>
              <td width="80%" align="left">Service (+)</td>
              <td width="10%"></td>
              <td width="10%" align="right">{{$order->deliveryfees}}</td>       
              </tr>
              <tr>
              <td width="80%" align="left">Tax (+)</td>
              <td width="10%"></td>
              <td width="10%" align="right">{{$order->taxfees}}</td>
              </tr>
              @if($order->voucher_amount > 0)
                <tr>
                  <td width="80%" align="left">Voucher Gift</td>
                  <td width="10%"></td>
                  <td width="10%" align="right"> - {{@$order->voucher_amount}}</td>
                </tr>               
              @endif  
            </tbody>
            </table>
            <hr/>
            <table width="100%">
            <tbody>
              <tr>
                <td width="80%" align="left" style="font-weight: bold;">Total</td>
                <td width="10%"></td>
                <td width="10%" align="right">{{number_format( (str_replace(',','',$Afterdiscount) + $order->deliveryfees + $order->taxfees - ($order->voucher_amount) ), 2)}}</td>        
              </tr>
            </tbody>
            </table>
            <hr/>
            <!-- Voucher Code -->
            @if(@$order->Voucher->gift->name)      
              <div align="center" colspan="4" style="background-color: #9f9c9c;width:99%;margin:auto">{{$order->Voucher->gift->name}}</div>
            @endif
            <!-- Voucher Code  -->
            <hr/>
            <div align="center" colspan="4" style="background-color: #9f9c9c;width:99%;margin:auto">{{$order->source}} / {{$order->payment_method}}</div>
            <!-- Voucher -->    
            <?php /*
            @if((str_replace(',','',$Afterdiscount) + $order->deliveryfees + $order->taxfees) > 100  && $order->discount == 0  && $order->voucher_id == '' && date('Y') == 2019)
              <img src="{{asset('img/voucher.png')}}" style="display: block;margin-left: auto;margin-right: auto;" >
              <center><p style="display: block;margin-left: auto;margin-right: auto;">The total order is over 100 EL, so you deserve a gift voucher. Don't forget to ask the driver man</p> </center>
            @endif
            */?>
            <!-- Voucher End-->
            <hr/>
          </div>
        @endif
      @php 
        $orderItemsver= $order->version - 1 ;
        $orderItems   = $order->items->where('flagtoprint','N')->lists('product_id','id')->toArray();
        $orderSection = \App\Product::whereIn('id', $orderItems)->groupBy('sectionid')->lists('sectiongroup','sectionid')->toArray();
        $totalextra   = \App\Product::where('extra', 1)->lists('id','id')->toArray();
        $checkextras  = DB::table('order_items')->where('order_id', $order->id)->whereIn('product_id',$totalextra)->where(function ($query) {$query->WhereNull('extra_items')->orWhere('extra_items', '=', 0);})->count();
      @endphp
      <style type="text/css" media="print">.headofitems:first-child{background: red !important;}</style>
      @php $extra_items = array() @endphp
      @if($driver == 'notdriver')
        @foreach ($orderSection as $key => $section)          
          @if (in_array($key, $sectiontoprint)) 
            @if($key == '19')
              @if($checkextras > 0)
                <!-- class="page-break" -->
                <div id="{{$key}}">
                  <div class="headofitems">
                    <div align="center" colspan="4" style="width:99%;margin:auto">{{$created->format('Y/m/d A h:i')}}</div>
                    <div align="center" colspan="4" style="background-color: #9f9c9c;width:99%;margin:auto">{{$order->orderid}} / {{$section}} </div>
                  </div>
                  <table class="orderitems" style="width:100%;font-size: 15px;font-weight: bold;">
                    <thead>
                      <tr>
                        <td width="10%"> ك </td>
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
                <hr/>
              @endif
            @else
              <div  id="{{$key}}">
                <div class="headofitems">
                  <div align="center" colspan="4" style="width:99%;margin:auto">{{$created->format('Y/m/d A h:i')}}</div>
                  <div align="center" colspan="4" style="background-color: #9f9c9c;width:99%;margin:auto">{{$order->orderid}} / {{$section}} </div>
                </div>
                <!-- <center><div style="background-color: #9f9c9c;font-size: 18px;font-weight: bold;">#{{$order->orderid}}</div><h4 style="background-color: #9f9c9c;font-size: 18px;font-weight: bold;">{{$section}}</h4></center> -->
                <table class="orderitems" style="width:100%;font-size: 15px;font-weight: bold;">
                  <thead>
                    <tr>
                      <td width="10%">Q</td>
                      <td width="90%" align="right"> items </td>
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
                            @if($item->extra_items  != $olditems->extra_items  ||  $item->quantity     != $olditems->quantity     ||  $item->tprice       != $olditems->tprice       || $item->item_comment != $olditems->item_comment)
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
                            @elseif($olditems->flagtoprint == "N" && $item->flagtoprint == "N")
                            <tbody>
                                <!-- Add -->                                                                
                                  <tr>
                                    <td>{{$item->quantity}}</td>
                                    <td align="right">{{$item->product->ar_name}} </td>
                                  </tr>
                                <!-- Nothing -->                                
                                
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
              <hr/>
            @endif
          @endif
        @endforeach
      @endif
      <div class="page-break"></div>
    @endforeach
  </body>
</html>