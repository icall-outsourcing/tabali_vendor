<!-- language -->
  @if(session()->has('lang'))
      {{App::setLocale(session()->get('lang'))}}
  @else
      {{App::setLocale('ar')}}
  @endif
  @php 
  	$branch_id  = \App\Branch::all()->lists('name','id')->toArray();
  	$order_id   = array();
  	$contact_id = array();
  	$created_by = \App\User::all()->lists('name','id')->toArray(); 
  @endphp
@extends('layouts.app')
@section('content')
<div class="container-fluid ">
	<!--Index-->
	<input type="hidden" id="key" 	 	 value="id">
	<input type="hidden" id="model"  	 value="Complaint">
	<input type="hidden" id="groupby" 	 value="id">
	<input type="hidden" id="path" 	 	 value="">
	<input type="hidden" id="conditions" value='{}' name="conditions">







<div class="panel panel-default">
	<!-- Default panel contents -->	
	<div class="panel-heading">
		<div class="row">
			<div class="col-lg-4">
				<div class="input-group">
					@if (!empty($model->model_name))
					<span class="input-group-btn CreateAdd">
                    	@role('admin')
						<a class="btn btn-primary" id="DownloadA" title="Download all data" href="javascript:document.getElementById('exportreport').submit();"><i class="fa fa-download"></i></a>
       					<a class="btn btn-primary" id="ExcelA" 	 title="Download selected data" onclick="saveAsExcel('tableToExcel', '{{$model->model_name}}.xls')"><i class="fa fa-file-excel-o"></i></a>
       					@endrole
       					<a class="btn btn-primary" id="CreateA" title="Create" href="{{URL::route($model->model_name.'.create')}}"><i>Add {{$model->model_name}}</i></a>
				    </span>
      				@endif
      				<select class="form-control" id="rows" onchange="pageid();">
						@for ($i = 10; $i <= 200; $i=$i+10) 
							<option>{{$i}}</option>
						@endfor
					</select>
    			</div>
			</div>
			<div class="col-lg-3"></div>
			<div class="col-lg-5">
				<div class="input-group"> 
					<input type="text" class="form-control" placeholder="Search for..." name="search" id="search" onchange="pageid();">
					<span class="input-group-btn"> 
						<button class="btn btn-primary glyphicon glyphicon-search" onclick="pageid();" type="button"></button> 
					</span> 
				</div>
			</div>
		</div>
	</div>
	<div class="classPageID">
	  	<!-- Table -->
	  	<input type="hidden" id="ordertype" name="ordertype" value="desc">
		<input type="hidden" id="orderby" 	name="orderby"   value="id">
		<table id="tableToExcel" class="table table-hover table-striped table-bordered">
			<thead id="header">
				<tr id="tfooter">
					<th class="col-md-1 col-action text-center"></th>
					@foreach($model->getCasts() as $key => $value)
						@if (strpos($value, '_id') !== false)
							<th class="col-{{$value}}">
								{!! Form::select($value,[null =>'Please Select'] + eval('return $'. $value . ';'),null,['class' => 'filter form-control input-sm select2','id' => $value,'onchange'=>'pageid();'])!!}
							</th>
						@elseif(strpos($value, '_by') !== false)
							
							<th class="col-{{$value}}">
								{!! Form::select($value,[null =>'Please Select'] + eval('return $'. $value . ';'),null,['class' => 'filter form-control input-sm select2','id' => $value,'onchange'=>'pageid();'])!!}
							</th>
						@elseif (strpos($key, '_relation') !== false)
							@php $COLUMN	= str_replace('_relation','',$key); @endphp
							<th class="col-{{$COLUMN}}">
							<input name="{{$value.'.'.$COLUMN}}" id="{{$key}}" onchange='pageid();' value="" class="form-control input-sm" style="width: 100%;padding: 3px;box-sizing: border-box;"></input>
							</th>
						@else
							<th class="col-{{$value}}">
							<input name="{{$value}}" id="{{$value}}" onchange='pageid();' value="" class="form-control input-sm" style="width: 100%;padding: 3px;box-sizing: border-box;"></input>
							</th>
						@endif
					@endforeach
				</tr>
				<tr>
					<th class="col-md-1 col-action text-center">Action</th>
					@foreach($model->getCasts() as $key => $value)
						@if (strpos($key, '_relation') !== false) 
							<th class="col-{{$value}}" class="text-center"><div class="text-center">{{ trans('form.'.$value) }}<span name="id" type="asc" class="sort fa fa-sort pull-right"></span></div></th>
						@else
							<th class="col-{{$value}}" class="text-center"><div class="text-center">{{ trans('form.'.$value) }}<span name="{{$value}}" type="asc" class="sort fa fa-sort pull-right"></span></div></th>
						@endif
					@endforeach
				</tr>
			</thead>
			<tbody id="data" class="insertData text-center">
				@foreach($datatable as $row )
					@if (!empty($model->model_name))
					<tr style="cursor:pointer" class="tr clickable-row" data-id="{{URL::route($model->model_name.'.show',   $row->id)}}" data-href="{{URL::route($model->model_name.'.show',   $row->id)}}">
					@endif
						@if (!empty($model->model_name))
						<td class="text-center col-action col-md-1">
					   		<button data-route="{{URL::route($model->model_name.'.show',   $row->id)}}" id ="={{$row->id}}"  type="button" class="Show btn btn-info btn-xs"><i class="fa fa-eye"></i></button>
					   		<a            href="{{URL::route($model->model_name.'.edit',   $row->id)}}" class="Edit btn btn-primary btn-xs" ><i class=" fa fa-pencil-square-o"></i></a>
					    </td>
					    @endif
						@foreach($model->getCasts() as $key => $column)
							@if ($key === 'img')
								<td class="col-{{$column}} text-center">
									<img class="img" src="{{asset($row->$column)}}" width="25" height="25">
								</td>
							@elseif ($column === 'id')
								<!--  -->
								<td class="col-{{$column}}" id="{{$row->$column}}">{{$row->$column}}</td>
							@elseif (strpos($column, '_id') !== false) 
								@php $COLUMN	=str_replace('_id','',$column); @endphp
								<td class="col-{{$column}}">
									@if(!empty($row->$COLUMN->name)){{$row->$COLUMN->name}}@endif
									@if(!empty($row->$COLUMN->contact_name)){{$row->$COLUMN->contact_name}}@endif
						                        @if($column== 'order_id' && !empty($row->order->orderid))
                                                                            {{ $row->order->orderid}}    
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
											<span class="label label-default">{{$value->$COLUMN}}</span>,
										@endforeach
									@endif

									
								</td>
							@else
								<!--  -->
								<td class="col-{{$column}}">{{$row->$column}}</td>
							@endif
						@endforeach
					</tr>
				@endforeach

			</tbody>
			<tfooter class="tfooter" >
			</tfooter>
		</table>
	</div>
	<div class="box-footer">
		<div class="col-md-6 text-left"  id="loadpaginate">{!! str_replace('/?','?',$datatable->render())!!} </div>
		<div class="col-md-6 text-right" ><ul id="loadingcount" class="pagination text-left">Show {!! $datatable->count() !!} of {!! $datatable->total() !!}</ul></div>
	</div>
</div>




























	<!--End Index-->
</div>
<script type="text/javascript">
	$('.col-int').remove();
</script>
@endsection
