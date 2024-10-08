<!-- language -->
  @if(session()->has('lang'))
      {{App::setLocale(session()->get('lang'))}}
  @else
      {{App::setLocale('ar')}}
  @endif
  @php $branch_id  = \App\Branch::all()->lists('name','id')->toArray(); @endphp

@extends('layouts.app')
	@section('content')
	@php
		$branchID 		=  Auth::User()->getPermissions()->first()->id;
		$Userbranch 	=  Auth::User()->branch;
		$classname   	= \App\Product::where('depname',$Userbranch)->groupBy('classname')->lists('classname','classname')->toArray();
		$branch 		=  Auth::User()->branch;
	@endphp

	



<div class="container-fluid ">
	<!--Index-->
	<input type="hidden" id="key" 	 	 value="id">
	<input type="hidden" id="model"  	 value="Product">
	<input type="hidden" id="groupby" 	 value="id">
	<input type="hidden" id="path" 	 	 value="">
	<input type="hidden" id="conditions" value='{"depname":"{{$branch}}"}' name="conditions">
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
						@foreach($model->getCasts() as $key => $value)
							@if (strpos($value, '_id') !== false)
								<th class="col-{{$value}}">
									{!! Form::select($value,[null =>'Please Select'] + eval('return $'. $value . ';'),null,['class' => 'filter form-control input-sm select2','id' => $value,'onchange'=>'pageid();'])!!}
								</th>
							@elseif ($value == 'branch')
								<th class="col-{{$value}}">
									{!! Form::select($value,[null =>'Please Select'] + Auth::User()->BranchsList ,null,['class' => 'filter form-control input-sm select2','id' => $value,'onchange'=>'pageid();'])!!}
								</th>
							@else
								<th class="col-{{$value}}">
								<input name="{{$value}}" id="{{$value}}" onchange='pageid();' value="" class="form-control input-sm" style="width: 100%;padding: 3px;box-sizing: border-box;"></input>
								</th>
							@endif
						@endforeach
					</tr>
					<tr>
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






					<tr>
						<td colspan="{{count($model->getCasts())+1}}"> 
							<div class="row">
								<div class="col-md-6 text-left">{!! str_replace('/?','?',$datatable->appends(['search' => Input::get('search')])->appends(['sort' => Input::get('sort')])->render())!!} </div>
								<div class="col-md-6 text-right"><ul class="pagination text-left">Show {!! $datatable->count() !!} of {!! $datatable->total() !!}</ul>
								</div>
							</div>
						</td>
					</tr>
				</tbody>
				<tfooter class="tfooter" >
				</tfooter>
			</table>
		</div>
		<div class="panel-footer">
		</div>
	</div>
</div>
<script type="text/javascript">
	$('.col-int').remove();
	$('.Show').remove();
</script>



<script type="text/javascript">

	$(document).on('change', '#branchitems', function(){
 		var ID    = $(this).find("option:selected").attr("title");
  		var OnOff = $(this).val();
  		var branch= "{{$branchID}}";
  	        var route   = $(this).data('route');
                var token   = $(this).data('token');
  		

  		 $.ajax({
                    url     : route,
                    type    : 'POST',
                    data    : {_method: 'PUT', _token :token,id:ID,value:OnOff,columnname:branch},
                    dataType:'json',           
                    success : function(data){
                    //alert(data);
                    },
                });
                
                
                
	}); 
</script>


@endsection
