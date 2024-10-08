<!-- language -->
  @if(session()->has('lang'))
      {{App::setLocale(session()->get('lang'))}}
  @else
      {{App::setLocale('ar')}}
  @endif


<tbody  id="data" class="insertData text-center">
	@foreach($DataTable as $row )
		@if (!empty($myModal->model_name))
			<tr style="cursor:pointer" class="loadingrow tr clickable-row" data-id="{{URL::route($myModal->model_name.'.show',   $row->id)}}" data-href="{{URL::route($myModal->model_name.'.show',   $row->id)}}">
		@endif
			@foreach($myModal->getCasts() as $key => $column)
				@if ($column == 'int')	
				@elseif ($key === 'img')
					<td class="col-{{$column}} text-center">
						<img class="img" src="{{asset($row->$column)}}" width="25" height="25">
					</td>
				@elseif ($column === 'id')
					<!--  -->
					<td class="col-{{$column}}" id="{{$row->$column}}">{{$row->$column}}</td>
				@elseif ($column === 'action')
					@if($row->status == 'opened')
						<td class="col-{{$column}}s">
							@if($row->version > 1)
		   						<a href="#" id="showorder" data-route="{{URL::route($myModal->model_name.'.show',   $row->id)}}" class="alarm Edit btn btn-primary btn-xs"><i class="fa fa-flag"></i></a>
							@endif
							<audio id="myAudio">
							  <source src="{{asset('/music/order.mp3')}}" type="audio/mpeg">
							  Your browser does not support the audio element. 
							</audio>
							<script>
								var x = document.getElementById("myAudio");
								x.play(); 
							</script>
						</td>
					@elseif ($row->status === 'viewed')
						<td class="col-{{$column}}s"><button type="button" data-route="{{URL::route('Order.status',$row->id)}}" data-name="processing" id="ChangeAction" class="btn btn-block btn-primary btn-xs">processing</button></td>
					@elseif ($row->status === 'processing')
						<td class="col-{{$column}}s"><button type="button" data-route="{{URL::route('Order.status',$row->id)}}" data-name="ondelivery"  id="ChangeAction" class="btn btn-block btn-warning btn-xs">ondelivery</button></td>
					@elseif ($row->status === 'ondelivery')
						<td class="col-{{$column}}s"><button type="button" data-route="{{URL::route('Order.status',$row->id)}}" data-name="closed"     id="ChangeAction" class="btn btn-block btn-success btn-xs">closed</button></td>
					@elseif ($row->status === 'closed')
						<td class="col-{{$column}}s"><button type="button" class="ChangeAction  btn btn-block btn-primary btn-xs">canceled</button></td>
						
					@endif
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
				

				@elseif (strpos($column, 'available') !== false) 
					<td class="col-{{$column}}">
						<select name="{{$column}}" id="{{$row->id}}-{{$column}}" class="form-control input-sm">
							<option value='ON' @if($row->$column=='ON') selected="selected" @endif>ON</option>                                
		                                        <option value='OFF' @if($row->$column=='OFF') selected="selected" @endif>OFF</option>
                                                        <option value='1' @if($row->$column=='1') selected="selected" @endif>unAailable till 1 hour</option>
                                                        <option value='2' @if($row->$column=='2') selected="selected" @endif>unAailable till 2 hour</option>
                                                        <option value='4' @if($row->$column=='4') selected="selected" @endif>unAailable till 4 hour</option>
                                                        <option value='next_day' @if($row->$column=='next_day') selected="selected" @endif>unAailable till next day</option>

						</select>
					</td>
@elseif (strpos($column, 'price') !== false && Auth::user()->is('admin|tabaliadmin')) 
										<td class="col-{{$column}}">
											<input name="{{$column}}" id="{{$row->id}}-{{$column}}" value="{{$row->$column}}" class="form-control input-sm">
										</td>


				@else
					<!--  -->
					<td class="col-{{$column}}">{{$row->$column}}</td>
				@endif
			@endforeach
		    @if (!empty($myModal->model_name))
				<td class="text-center col-action col-md-1">
			   		<a    id="updateproduct"    data-available="{{$row->id}}-available"  data-price="{{$row->id}}-price" href="#" data-route="{{URL::route($myModal->model_name.'.update',   $row->id)}}" class="Edit btn btn-primary btn-xs" ><i class=" fa fa-pencil-square-o"></i></a>
			    </td>
		    @endif



		</tr>
	@endforeach
</tbody>
	<tr>
		<td colspan="{{count($myModal->getCasts())+1}}"> 
			<div class="row">
				<div class="col-md-9 text-left"  id="loadpaginate">{!! str_replace('/?','?',$DataTable->appends(['search' => Input::get('search')])->appends(['sort' => Input::get('sort')])->render())!!} </div>
				<div class="col-md-3 text-right" ><ul id="loadingcount" class="pagination text-left">Show {!! $DataTable->count() !!} of {!! $DataTable->total() !!}</ul></div>
			</div>
		</td>
	</tr>
<script type="text/javascript">
	
</script>	
