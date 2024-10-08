<!-- language -->
  @if(session()->has('lang'))
      {{App::setLocale(session()->get('lang'))}}
  @else
      {{App::setLocale('ar')}}
  @endif
  @php use Carbon\Carbon; @endphp
<tbody  id="data" class="insertData text-center">
	@foreach($DataTable as $row )
        @php
			$StartTime 	= Carbon::parse($row->created_at);
			$EndTime 	= Carbon::now();
			$Hours 		= $StartTime->diffInHours($EndTime);
			$Minutes 	= $StartTime->diffInMinutes($EndTime);
			$Seconds 	= $StartTime->diffInSeconds($EndTime);
			$Seconds =  $Seconds - $Minutes * 60;
			$Minutes =  $Minutes - $Hours * 60;
		@endphp
		@if (!empty($myModal->model_name))
			<tr 
					@if($row->printed == "N" && $row->status === 'viewed')
						@if ($row->version > 1)
							style="background-color: #00FF00"
						@else
							style="background-color:#f39c12;color:#fff"
						@endif
					@elseif ($row->status === 'processing')
						style="background-color: green;color:#fff"
					@elseif ($row->status === 'ondelivery')
						style="background-color: #6600FF;color:#fff"
					@elseif ($row->status === 'canceled')
						style="background-color: #dd4b39;color:#fff" 
					@elseif($Minutes > 15) 
						style="background-color: #795548;color:#fff" 
					@endif
						style="cursor:pointer;" class="trtime loadingrow tr clickable-row" data-id="{{URL::route($myModal->model_name.'.show',   $row->id)}}" data-href="{{URL::route($myModal->model_name.'.show',   $row->id)}}">
					@endif
			@foreach($myModal->getCasts() as $key => $column)
				@if ($column == 'int')				
				@elseif ($key === 'img')
					<td class="col-{{$column}} text-center">
						<img class="img" src="{{asset($row->$column)}}" width="25" height="25">
					</td>
				@elseif ($column === 'id')
					<!--  -->
					<td class="col-{{$column}}" id="{{$row->$column}}">{{$row->$column}}   || Time   {{$Minutes}}</td>
				@elseif ($column === 'status')
					@if($row->status == 'opened')
						<td class="col-{{$column}}s">
							@if($row->version > 1)
		   						<a href="#" id="showorder" data-route="{{URL::route($myModal->model_name.'.show',   $row->id)}}" class="alarm Edit btn btn-primary btn-xs"><i class="fa fa-flag"></i></a>
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
						<td class="col-{{$column}}s"><button type="button" class="ChangeAction  btn btn-block btn-primary btn-xs">closed</button></td>
						
					@endif


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
				@elseif (strpos($column, '_code') !== false) 
					@php $COLUMN	=str_replace('_code','',$column); @endphp
					<td class="col-{{$column}}">
						@if(!empty($row->$COLUMN->contact_name)){{$row->$COLUMN->contact_name}}@endif
					</td>								
				@elseif (strpos($column, '_by') !== false)
						@php $COLUMN	=str_replace('_by','_name',$column); @endphp
						<td class="col-{{$column}}">
							@if(!empty($row->$COLUMN->name)){{$row->$COLUMN->name}}@endif
						</td>
				@elseif (strpos($column, '_List') !== false)
					<td class="col-{{$column}}">
						@if(!empty($row->$column))
							@foreach ($row->$column as $key => $value)
								<span class="label label-default">{{$key}}</span>
							@endforeach
						@endif
					</td>
				@elseif (strpos($key   , '_relation') !== false) 
					@php $COLUMN	= str_replace('_relation','',$key); @endphp
					<td class="col-{{$COLUMN}}">
						@if(!empty($row->$column))
							@foreach ($row->$column as $key => $value)
								<span class="label label-default">{{$value->$COLUMN}}</span>
							@endforeach
						@endif

						
					</td>
				@else
					<!--  -->
					<td class="col-{{$column}}">{{$row->$column}}</td>
				@endif
			@endforeach
			@if (!empty($myModal->model_name))
				<td class="text-center col-action">
					<a 			  href="#" id="showorder" data-route="{{URL::route($myModal->model_name.'.show',   $row->id)}}" class="Edit btn btn-info btn-xs" ><i class="fa fa-shopping-basket"></i></a>

			    </td>
		    @endif
		</tr>
	@endforeach
</tbody>
	<tr>
		<td colspan="{{count($myModal->getCasts())+1}}"> 
			<div class="row">
				<!--<div class="col-md-2">
					<button class="btn btn-primary" onclick="saveAsExcel('tableToExcel', '{{$myModal->model_name}}.xls')"><i class="fa fa-file-excel-o"></i> Export </button>
				</div>-->
				<div class="col-md-6 text-left"  id="loadpaginate">{!! str_replace('/?','?',$DataTable->appends(['search' => Input::get('search')])->appends(['sort' => Input::get('sort')])->render())!!} </div>
				<div class="col-md-6 text-right" ><ul id="loadingcount" class="pagination text-left">Show {!! $DataTable->count() !!} of {!! $DataTable->total() !!}</ul></div>
			</div>
		</td>
	</tr>
<script type="text/javascript">
	$('.col-int').remove();
	$('.Show').remove();
</script>