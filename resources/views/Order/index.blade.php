<!-- language -->
@if(session()->has('lang'))
	{{App::setLocale(session()->get('lang'))}}
@else
	{{App::setLocale('ar')}}
@endif
@extends('layouts.app')
@php use Carbon\Carbon; @endphp
@inject ('Carbon',Carbon\Carbon)
@php
	$contact_id   = array();
	$address_id   = array();
	$account_id   = array();
	$branch_id    = Auth::User()->getPermissions()->lists('name','id')->toArray();
	$driver_id 	  = \App\Driver::whereIn('branch_id',array_values(Auth::user()->PermissionsList))->lists('name','id')->toArray();
	if ( substr( date("H"), 0, 1 ) == 0 ) {$date = substr( date("H"), 1 );}else{$date = date("H");}
        if( $date < 6){
           $StartDate  = date("Y-m-d", time() - 86400).' 08:00:00';
           $EndDate    = date("Y-m-d").' 03:00:00';
        }else{
           $StartDate  = date("Y-m-d").' 08:00:00 ';
           $EndDate    = date("Y-m-d", time() + 86400).' 03:00:00';
        }
@endphp
@section('content')
 	<div class="col-md-12" id="notprint">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
				<li class="active"><a href="{{ url(route('Order.index')) }}" >Activity</a></li>
              	<li><a href="{{ url(route('Order.canceled')) }}">canceled</a></li>
              	<li><a href="{{ url(route('Order.closed')) }}">closed</a></li>
            </ul>
            <div class="tab-content">
            	<div class="active tab-pane" id="activity">
            		<input type="hidden" id="key" 	 	 value="id">
					<input type="hidden" id="model"  	 value="Order">
					<input type="hidden" id="groupby" 	 value="id">
					<input type="hidden" id="path" 	 	 value="Order">
					<input type="hidden" id="conditions" value='{"status":"opened,viewed,processing,ondelivery,canceled","confirm_cancellation":"N"}' name="conditions" >
					<input type="hidden" id="conditions" value='{}' name="conditions">
					<div class="box box-success">
						<div class="box-header with-border">
							<div class="col-md-row">
								<div class="col-md-1">
									<select class="input-sm" id="rows" onchange="pageid();">
									@for ($i = 50; $i <= 200; $i=$i+50)
										<option>{{$i}}</option>
									@endfor
									</select>
								</div>
								<div class="col-md-1"></div>
								<div class="col-md-8 text-center"><h3 class="box-title">Orders</h3></div>
								<div class="col-md-2">
									<div class="box-tools">
										<div class="input-group"> 
											<input type="text" class="form-control input-sm" placeholder="Search for..." name="search" id="search" onchange="pageid();">
											<span class="input-group-btn"> 
												<button class="btn btn-success fa fa-search btn-sm" onclick="pageid();" type="button"></button> 
											</span> 
										</div>
									</div>
								</div>
							</div>
		      			</div>
				        <div class="box-body">
							<div class="classPageID">
								<input type="hidden" id="ordertype" name="ordertype" value="desc">
								<input type="hidden" id="orderby" 	name="orderby"   value="id">
								<table id="tableToExcel" class="table table-hover table-bordered table-striped"> <!--  -->
									<thead id="header">
										<tr id="tfooter">
											@foreach($model->getCasts() as $key => $value)
												@if ($value == 'int')
												@elseif($value =='id')
													<!--  -->
													<th width="6%"><input name="{{$value}}" id="{{$value}}" onchange='pageid();' class="form-control input-sm tfooter-input"></input></th>
												@elseif(strpos($value, '_id') !== false)
													<!--  -->
													<th class="col-{{$value}}">{!! Form::select($value,[null =>'Please Select'] + eval('return $'. $value . ';'),null,['class' => 'filter form-control input-sm tfooter-input','id' => $value,'onchange'=>'pageid();'])!!}</th>
												@elseif (strpos($key, '_relation') !== false)
													@php $COLUMN	= str_replace('_relation','',$key); @endphp
													<th class="col-{{$COLUMN}}"><input name="{{$value.'.'.$COLUMN}}" id="{{$key}}" onchange='pageid();' class="form-control input-sm tfooter-input" ></input></th>
												@elseif ($value == 'printed')
													<!--  -->
													<th class="col-{{$value}}" ><input name="{{$value}}" id="{{$value}}" onchange='pageid();' class="form-control input-sm tfooter-input"></input></th>
												@elseif ($value == 'status')
													<th class="col-status">
														<select name="status" id="status" onchange='pageid();' class="filter form-control input-sm tfooter-input">
															<option  value="">All</option>
															<option  value="viewed">viewed</option>
															<option  value="opened">Edit</option>
															<option  value="processing">processing</option>
															<option  value="ondelivery">ondelivery</option>
															<option  value="canceled">canceled</option>
														</select>
													</th>
												@else
													<!--  -->
													<th class="col-{{$value}}" ><input name="{{$value}}" id="{{$value}}" onchange='pageid();' class="form-control input-sm tfooter-input"></input></th>
												@endif
											@endforeach
											<th class="col-md-1 col-action text-center"></th>
										</tr>
										<tr>
											@foreach($model->getCasts() as $key => $value)
												@if ($value == 'int')
												@elseif (strpos($key, '_relation') !== false) 
													<th class="col-{{$value}}" class="text-center"><div class="text-center">{{ trans('form.'.$value) }}<span name="id" type="asc" class="sort fa fa-sort pull-right"></span></div></th>
												@else
													<th class="col-{{$value}}" class="text-center"><div class="text-center">{{ trans('form.'.$value) }}<span name="{{$value}}" type="asc" class="sort fa fa-sort pull-right"></span></div></th>
												@endif
											@endforeach
												<th class="col-md-1 col-action text-center">Action</th>
										</tr>
									</thead>
									<tbody class="insertData text-center">
										@foreach($datatable as $row )
											@php
												$StartTime1 = Carbon::parse($row->created_at);
												$EndTime1 	= Carbon::now();
												$Hours1 	= $StartTime1->diffInHours($EndTime1);
												$Minutes1 	= $StartTime1->diffInMinutes($EndTime1);
												$Seconds1 	= $StartTime1->diffInSeconds($EndTime1);
												$Seconds1 	=  $Seconds1 - $Minutes1 * 60;
												$Minutes1 	=  $Minutes1 - $Hours1 * 60;
											@endphp
												<tr @if ($row->status === 'canceled')
													style="background-color: #dd4b39;color:#fff" 
												@elseif($row->under_change == 'Y')
														style="background-color: #f4e34e"
												@elseif($row->payment_type == "HotSpot")
					                                    style="background-color: #00c0ef"
					                            @elseif($row->printed == "N" && $row->status === 'viewed')
													@if ($row->version > 1)
														style="background-color: #00FF00"
													@else
														style="background-color:#f39c12;color:#fff"
													@endif
												@elseif ($row->status === 'processing')
													style="background-color: green;color:#fff"
												@elseif ($row->status === 'ondelivery')
													style="background-color: #6600FF;color:#fff"
												@elseif($Minutes1 > 15) 
													style="background-color: #795548;color:#fff" 
												@endif
													style="cursor:pointer;" class="trtime loadingrow tr clickable-row" data-id="{{URL::route($model->model_name.'.show',   $row->id)}}" data-href="{{URL::route($model->model_name.'.show',   $row->id)}}">
												@foreach($model->getCasts() as $key => $column)
													@if ($column == 'int')
													@elseif ($column === 'id')
														<td class="col-{{$column}}" id="{{$row->$column}}">{{$row->$column}}   || Time   {{$Minutes1}}</td>
													@elseif ($column === 'total')
														<td class="col-{{$column}}" id="{{$row->$column}}">{{$row->total + $row->deliveryfees}}</td>
													@elseif ($column === 'status')
														@if($row->status == 'opened')
															<td class="col-{{$column}}s">
																@if($row->version > 1)
											   						<a href="#" id="showorder" data-route="{{URL::route($model->model_name.'.show',   $row->id)}}" class="alarm Edit btn btn-primary btn-xs"><i class="fa fa-flag"></i></a>
																@endif
															</td>
														@elseif ($row->status === 'viewed')
															<td class="col-{{$column}}s"><button type="button" data-route="{{URL::route('Order.status',$row->id)}}" data-name="processing" id="ChangeAction" class="btn btn-block btn-primary btn-xs">viewed</button></td>
														@elseif ($row->status === 'processing')
															<td class="col-{{$column}}s"><button type="button" data-route="{{URL::route('Order.status',$row->id)}}" data-name="ondelivery"  id="ChangeAction" class="btn btn-block btn-warning btn-xs">processing</button></td>
														@elseif ($row->status === 'ondelivery')
															<td class="col-{{$column}}s"><button type="button" data-route="{{URL::route('Order.status',$row->id)}}" data-name="closed"     id="ChangeAction" class="btn btn-block btn-success btn-xs">ondelivery</button></td>
														@elseif ($row->status === 'canceled')
															<td class="col-{{$column}}s"><button type="button" data-route="{{url(route('Order.statuspost',$row->id))}}" data-token="{{ csrf_token() }}" data-name="canceled"     id="canceledOrder" class="btn btn-block btn-info btn-xs">canceled</button></td>
														@elseif ($row->status === 'closed')
															<td class="col-{{$column}}s"><button type="button" class="ChangeAction  btn btn-block btn-primary btn-xs">canceled</button></td>
														@endif
													@elseif ($column === 'driver_id')
														@php $COLUMN	=str_replace('_id','',$column); @endphp
														<td class="col-{{$column}}{{$row->id}}">
															@if(!empty($row->$COLUMN->name))
																<button type="button" data-route="{{URL::route('Order.driver',$row->id)}}" data-name="closed"     id="ChangeAction" class="btn btn-block btn-success btn-xs">{{$row->$COLUMN->name}}</button>
															@else
																@if (!empty($row->$COLUMN))
																	@if(!empty(eval('return $row->$COLUMN->'.$COLUMN.'_name;')))
																		{{eval('return $row->$COLUMN->'. $COLUMN.'_name;')}}
																	@endif
																@endif

															@endif
														</td>

													@elseif ($column == 'address_id') 
														@php $COLUMN	=str_replace('_id','',$column); @endphp
														<td class="col-{{$column}}">
															@if(!empty($row->$COLUMN->address))
																{{$row->$COLUMN->address}} 
															@else
																@if (!empty($row->$COLUMN))
																	@if(!empty(eval('return $row->$COLUMN->address;')))
																		{{eval('return $row->$COLUMN->address;')}}
																	@endif
																@endif

															@endif
														</td>


													@elseif (strpos($column, '_id') !== false) 
														@php $COLUMN	=str_replace('_id','',$column); @endphp
														<td class="col-{{$column}}">
															@if(!empty($row->$COLUMN->name))
																{{$row->$COLUMN->name}}
															@else
																@if (!empty($row->$COLUMN))
																	@if(!empty(eval('return $row->$COLUMN->'.$COLUMN.'_name;')))
																		{{eval('return $row->$COLUMN->'. $COLUMN.'_name;')}}
																	@endif
																@endif

															@endif
														</td>
													@elseif (strpos($column, '_by') !== false) 
														@php $COLUMN	=str_replace('_by','_name',$column); @endphp
														<td class="col-{{$column}}">
															@if(!empty($row->$COLUMN->name)){{$row->$COLUMN->name}}@endif
														</td>
													@elseif (strpos($key   , '_relation') !== false) 
														@php $COLUMN	= str_replace('_relation','',$key); @endphp
														<td class="col-{{$COLUMN}}">
															@if(!empty($row->$column))
																@foreach ($row->$column as $key => $value)
																	<span class="label label-default">{{$value->$COLUMN}}</span>,
																@endforeach
															@endif

															
														</td>
													@else
														<!--  -->
														<td class="col-{{$column}}">{{$row->$column}}</td>
													@endif
												@endforeach
												@if (!empty($model->model_name))
													<td class="text-center col-action col-md-1">
												   		<a 			  href="#" id="showorder" data-route="{{URL::route($model->model_name.'.show',   $row->id)}}" class="Edit btn btn-info btn-xs" ><i class="fa fa-shopping-basket"></i></a>
												   		<a 		target="_blank"	  href="{{URL::route('Account.show',['id' => $row->account_id ,'contact' => $row->contact_id,'branch'=>$row->branch_id,'address'=> $row->address_id] )}}" id="showAccount" class="Edit btn btn-primary btn-xs" ><i class="fa fa-user"></i></a>
												    </td>
											    @endif
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
			        	</div>
						<div class="box-footer">
							<div class="col-md-6 text-left"  id="loadpaginate">{!! str_replace('/?','?',$datatable->render())!!} </div>
							<div class="col-md-6 text-right" ><ul id="loadingcount" class="pagination text-left">Show {!! $datatable->count() !!} of {!! $datatable->total() !!}</ul></div>
						</div>
		        	</div>
  				</div>

                <?php /*
				<div class="tab-pane" id="canceled">
					<table id="canceledOrder" class="display" style="width:100%">
				        <thead>
				            <tr>
								@foreach($model->getCasts() as $key => $value)
									@if ($value == 'int' || $value === 'action') 
									@elseif (strpos($key, '_relation') !== false) 
										<th class="col-{{$value}}" class="text-center"><div class="text-center">{{ trans('form.'.$value) }}</div></th>
									@else
										<th class="text-center">{{ trans('form.'.$value) }}</th>
									@endif
								@endforeach
									<th>سبب الالغاء</th>
                                                                        <th></th>
							</tr>
				        </thead>
				        <tbody>
			    			@foreach(\App\Order::where('status','canceled')->whereIn('branch_id',array_values(Auth::user()->PermissionsList))->whereBetween('created_at', [$StartDate, $EndDate])->get() as $row )
								<tr style="cursor:pointer" class="tr clickable-row" data-id="{{URL::route($model->model_name.'.show',   $row->id)}}" data-href="{{URL::route($model->model_name.'.show',$row->id)}}">
									@foreach($model->getCasts() as $key => $column)
										@if ($column == 'int' || $column === 'action')

										@elseif ($column === 'id')
											<td class="col-{{$column}}" id="{{$row->$column}}"><a href="#">{{$row->$column}}</a></td>
										
										@elseif (strpos($column, '_id') !== false) 
											@php $COLUMN	=str_replace('_id','',$column); @endphp
											<td class="col-{{$column}}">
												@if(!empty($row->$COLUMN->name))
													{{$row->$COLUMN->name}}
												@else
													@if (!empty($row->$COLUMN))
														@if(!empty(eval('return $row->$COLUMN->'.$COLUMN.'_name;')))
															{{eval('return $row->$COLUMN->'. $COLUMN.'_name;')}}
														@endif
													@endif

												@endif
											</td>
										@elseif (strpos($column, '_by') !== false) 
											@php $COLUMN	=str_replace('_by','_name',$column); @endphp
											<td class="col-{{$column}}">
												@if(!empty($row->$COLUMN->name)){{$row->$COLUMN->name}}@endif
											</td>
										@elseif (strpos($key   , '_relation') !== false) 

											@php $COLUMN	= str_replace('_relation','',$key); @endphp
											<td class="col-{{$COLUMN}}">
												@if(!empty($row->$column))
													@foreach ($row->$column as $key => $value)
														<span class="label label-default">{{$value->$COLUMN}}</span>,
													@endforeach
												@endif
											</td>
										@else
											<!--  -->
											<td class="col-{{$column}}">{{$row->$column}}</td>
										@endif
									@endforeach
									<td class="col-cancel_note">{{$row->cancel_note}}</td>
									<td class="text-center col-action col-md-1">
										<a 			  href="#" id="showorder" data-route="{{URL::route($model->model_name.'.show',   $row->id)}}" class="Edit btn btn-info btn-xs" ><i class=" fa fa-shopping-basket"></i></a>
									</td>
								</tr>
							@endforeach
				        </tbody>
				        <tfoot>
				            	<tr>
								@foreach($model->getCasts() as $key => $value)
									@if ($value == 'int' || $value === 'action') 
									@elseif (strpos($key, '_relation') !== false) 
										<th class="col-{{$value}}" class="text-center"><div class="text-center">{{ trans('form.'.$value) }}</div></th>
									@else
										<th class="text-center">{{ trans('form.'.$value) }}</th>
									@endif
								@endforeach
									<th>سبب الالغاء</th>
									<th></th>
							</tr>
				        </tfoot>
				    </table>
				</div>
				<div class="tab-pane" id="closed" style="width: 100%;height: 100%;overflow: auto;">
					<table id="closedOrder" class="display" style="width:100%;">
				        <thead>
				            <tr>
								@foreach($model->getCasts() as $key => $value)
									@if ($value == 'int' || $value === 'action') 
									@elseif (strpos($key, '_relation') !== false) 
										<th class="col-{{$value}}" class="text-center"><div class="text-center">{{ trans('form.'.$value) }}</div></th>
									@else
										<th class="text-center">{{ trans('form.'.$value) }}</th>
									@endif
								@endforeach
									<th></th>
							</tr>
				        </thead>
				        <tbody>
			    			@foreach(\App\Order::where('status','closed')->whereIn('branch_id',array_values(Auth::user()->PermissionsList))->whereBetween('created_at', [$StartDate, $EndDate])->get() as $row )
								<tr style="cursor:pointer" class="tr clickable-row" data-id="{{URL::route($model->model_name.'.show',   $row->id)}}" data-href="{{URL::route($model->model_name.'.show',$row->id)}}">
									@foreach($model->getCasts() as $key => $column)
										@if ($column == 'int' || $column === 'action')

										@elseif ($column === 'id')
											<td class="col-{{$column}}" id="{{$row->$column}}"><a href="#">{{$row->$column}}</a></td>
										
										@elseif (strpos($column, '_id') !== false) 
											@php $COLUMN	=str_replace('_id','',$column); @endphp
											<td class="col-{{$column}}">
												@if(!empty($row->$COLUMN->name))
													{{$row->$COLUMN->name}}
												@else
													@if (!empty($row->$COLUMN))
														@if(!empty(eval('return $row->$COLUMN->'.$COLUMN.'_name;')))
															{{eval('return $row->$COLUMN->'. $COLUMN.'_name;')}}
														@endif
													@endif

												@endif
											</td>
										@elseif (strpos($column, '_by') !== false) 
											@php $COLUMN	=str_replace('_by','_name',$column); @endphp
											<td class="col-{{$column}}">
												@if(!empty($row->$COLUMN->name)){{$row->$COLUMN->name}}@endif
											</td>
										@elseif (strpos($key   , '_relation') !== false) 

											@php $COLUMN	= str_replace('_relation','',$key); @endphp
											<td class="col-{{$COLUMN}}">
												@if(!empty($row->$column))
													@foreach ($row->$column as $key => $value)
														<span class="label label-default">{{$value->$COLUMN}}</span>,
													@endforeach
												@endif

												
											</td>
										@else
											<!--  -->
											<td class="col-{{$column}}">{{$row->$column}}</td>
										@endif
									@endforeach
									<td class="text-center col-action col-md-1">
										<a 			  href="#" id="showorder" data-route="{{URL::route($model->model_name.'.show',   $row->id)}}" class="Edit btn btn-info btn-xs" ><i class=" fa fa-shopping-basket"></i></a>
									</td>
								</tr>
							@endforeach
				        </tbody>
				        <tfoot>
				            	<tr>
								@foreach($model->getCasts() as $key => $value)
									@if ($value == 'int' || $value === 'action') 
									@elseif (strpos($key, '_relation') !== false) 
										<th class="col-{{$value}}" class="text-center"><div class="text-center">{{ trans('form.'.$value) }}</div></th>
									@else
										<th class="text-center">{{ trans('form.'.$value) }}</th>
									@endif
								@endforeach
									<th></th>
							</tr>
				        </tfoot>
				    </table>
				</div>
				*/?>
            </div>
        </div>
	</div>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" crossorigin="anonymous">
	<style type="text/css"></style>
	<script type="text/javascript">
		$(document).ready(function() {
		    //$('#closedOrder').DataTable();
                    $('#canceledOrder').DataTable();
		});


        $(document).ready(function() {
		    // Setup - add a text input to each footer cell
		    $('#closedOrder tfoot th').each( function () {
		        var title = $(this).text();
		        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
		    } );
		 
		    // DataTable
		    var table = $('#closedOrder').DataTable();
		 
		    // Apply the search
		    table.columns().every( function () {
		        var that = this;
		        $( 'input', this.footer() ).on( 'keyup change', function () {
		            if ( that.search() !== this.value ) {
		                that
		                    .search( this.value )
		                    .draw();
		            }
		        } );
		    } );
		} );



		$(document).on('click','#showorder',function(e){ 
			e.preventDefault();
			var user 	= '{{Auth::user()->is("branch")}}';
			
	        var route   = $(this).data('route');
	        var status 	= $(this).parent().parent().find('.col-status');
	        var action 	= $(this).parent().parent().find('.col-actions');
	        var id 		= $(this).parent().parent().find('.col-id').attr('id');
	        var btnroute   = "{{URL::route('Order.status','')}}"+"/"+id;
			$.confirm({
	            title           : 'Show Order',
	            columnClass     : 'col-md-12',
	            closeIcon       :  true,
	            content         : 'url:'+route,
	            animation       : 'zoom',
	            cancelButton: false, // hides the cancel button.
				confirmButton: false, // hides the confirm button.
				contentLoaded : function(){
            		if(user > 0 && status.text() == 'opened' ){
            			status.text('viewed');
            			action.html('<button type="button" data-route="'+btnroute+'" data-name="processing" id="ChangeAction" class="btn btn-block btn-primary btn-xs">processing</button>');
            		}
                },
	    	});
	    });

	    $(document).on('click','#ChangeAction',function(e){ 
			e.preventDefault();
	        var route   = $(this).data('route');
			$.confirm({
	            title           : 'Change status',
	            columnClass     : 'col-md-4 col-md-push-4',
	            closeIcon       :  true,
	            content         : 'url:'+route,
	            //animation     : 'top',
	            //closeAnimation: 'bottom',
	            animation       : 'zoom',
	            cancelButton: false, // hides the cancel button.
				confirmButton: false, // hides the confirm button.
	    	});
	    });



	     
                
           
	    $(document).on('click','#canceledOrder',function(e){ 
			e.preventDefault();
	        var route   = $(this).data('route');
			var token   = $(this).data('token');
			$.ajax({
	            url     : route,
	            type    : 'post',
	            data    : {_method: 'POST', _token :token,type:'canceled'},
	            dataType:'json',
	            success : function(data){
	            	$("#"+data.id).parents("tr").remove();
                    $("#"+data.id).remove();
	    		}
	    	});
	    });
	</script>
	<div class="autoPrint content" id="autoPrint"></div>
	
@endsection