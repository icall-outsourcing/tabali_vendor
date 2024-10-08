<!-- language -->
<?php if(session()->has('lang')): ?>
	<?php echo e(App::setLocale(session()->get('lang'))); ?>

<?php else: ?>
	<?php echo e(App::setLocale('ar')); ?>

<?php endif; ?>

<?php  use Carbon\Carbon;  ?>
<?php $Carbon = app('Carbon\Carbon'); ?>
<?php 
	$contact_id   = array();
	$address_id   = array();
	$account_id   = array();
	$branch_id    = Auth::User()->getPermissions()->lists('name','id')->toArray();
	$driver_id 	  = \App\Driver::whereIn('branch_id',array_values(Auth::user()->PermissionsList))->lists('name','id')->toArray();
 ?>
<?php $__env->startSection('content'); ?>
 	<div class="col-md-12" id="notprint">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
				<li class="active"><a href="<?php echo e(url(route('Order.index'))); ?>" >Activity</a></li>
              	<li><a href="<?php echo e(url(route('Order.canceled'))); ?>">canceled</a></li>
              	<li><a href="<?php echo e(url(route('Order.closed'))); ?>">closed</a></li>
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
									<?php for($i = 20; $i <= 200; $i=$i+20): ?>
										<option><?php echo e($i); ?></option>
									<?php endfor; ?>
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
											<?php foreach($model->getCasts() as $key => $value): ?>
												<?php if($value == 'int'): ?>
												<?php elseif($value =='id'): ?>
													<!--  -->
													<th width="6%"><input name="<?php echo e($value); ?>" id="<?php echo e($value); ?>" onchange='pageid();' class="form-control input-sm tfooter-input"></input></th>
												<?php elseif(strpos($value, '_id') !== false): ?>
													<!--  -->
													<th class="col-<?php echo e($value); ?>"><?php echo Form::select($value,[null =>'Please Select'] + eval('return $'. $value . ';'),null,['class' => 'filter form-control input-sm tfooter-input','id' => $value,'onchange'=>'pageid();']); ?></th>
												<?php elseif(strpos($key, '_relation') !== false): ?>
													<?php  $COLUMN	= str_replace('_relation','',$key);  ?>
													<th class="col-<?php echo e($COLUMN); ?>"><input name="<?php echo e($value.'.'.$COLUMN); ?>" id="<?php echo e($key); ?>" onchange='pageid();' class="form-control input-sm tfooter-input" ></input></th>
												<?php elseif($value == 'printed'): ?>
													<!--  -->
													<th class="col-<?php echo e($value); ?>" ><input name="<?php echo e($value); ?>" id="<?php echo e($value); ?>" onchange='pageid();' class="form-control input-sm tfooter-input"></input></th>
												<?php elseif($value == 'status'): ?>
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
												<?php else: ?>
													<!--  -->
													<th class="col-<?php echo e($value); ?>" ><input name="<?php echo e($value); ?>" id="<?php echo e($value); ?>" onchange='pageid();' class="form-control input-sm tfooter-input"></input></th>
												<?php endif; ?>
											<?php endforeach; ?>
											<th class="col-md-1 col-action text-center"></th>
										</tr>
										<tr>
											<?php foreach($model->getCasts() as $key => $value): ?>
												<?php if($value == 'int'): ?>
												<?php elseif(strpos($key, '_relation') !== false): ?> 
													<th class="col-<?php echo e($value); ?>" class="text-center"><div class="text-center"><?php echo e(trans('form.'.$value)); ?><span name="id" type="asc" class="sort fa fa-sort pull-right"></span></div></th>
												<?php else: ?>
													<th class="col-<?php echo e($value); ?>" class="text-center"><div class="text-center"><?php echo e(trans('form.'.$value)); ?><span name="<?php echo e($value); ?>" type="asc" class="sort fa fa-sort pull-right"></span></div></th>
												<?php endif; ?>
											<?php endforeach; ?>
												<th class="col-md-1 col-action text-center">Action</th>
										</tr>
									</thead>
									<tbody class="insertData text-center">
										<?php foreach($datatable as $row ): ?>
											<?php 
												$StartTime1 = Carbon::parse($row->created_at);
												$EndTime1 	= Carbon::now();
												$Hours1 	= $StartTime1->diffInHours($EndTime1);
												$Minutes1 	= $StartTime1->diffInMinutes($EndTime1);
												$Seconds1 	= $StartTime1->diffInSeconds($EndTime1);
												$Seconds1 	=  $Seconds1 - $Minutes1 * 60;
												$Minutes1 	=  $Minutes1 - $Hours1 * 60;
											 ?>
												<tr <?php if($row->status === 'canceled'): ?>
													style="background-color: #dd4b39;color:#fff" 
												<?php elseif($row->under_change == 'Y'): ?>
														style="background-color: #f4e34e"
												<?php elseif($row->payment_type == "HotSpot"): ?>
					                                    style="background-color: #00c0ef"
					                            <?php elseif($row->printed == "N" && $row->status === 'viewed'): ?>
													<?php if($row->version > 1): ?>
														style="background-color: #00FF00"
													<?php else: ?>
														style="background-color:#f39c12;color:#fff"
													<?php endif; ?>
												<?php elseif($row->status === 'processing'): ?>
													style="background-color: green;color:#fff"
												<?php elseif($row->status === 'ondelivery'): ?>
													style="background-color: #6600FF;color:#fff"
												<?php elseif($Minutes1 > 15): ?> 
													style="background-color: #795548;color:#fff" 
												<?php endif; ?>
													style="cursor:pointer;" class="trtime loadingrow tr clickable-row" data-id="<?php echo e(URL::route($model->model_name.'.show',   $row->id)); ?>" data-href="<?php echo e(URL::route($model->model_name.'.show',   $row->id)); ?>">
												<?php foreach($model->getCasts() as $key => $column): ?>
													<?php if($column == 'int'): ?>
													<?php elseif($column === 'id'): ?>
														<td class="col-<?php echo e($column); ?>" id="<?php echo e($row->$column); ?>"><?php echo e($row->$column); ?>   || Time   <?php echo e($Minutes1); ?></td>
													<?php elseif($column === 'total'): ?>
														<td class="col-<?php echo e($column); ?>" id="<?php echo e($row->$column); ?>">
															<?php  $discount = ( 100 - $row->discount) / 100;  $Afterdiscount =  number_format($row->total *  $discount,2)  ?>
															<?php echo e(number_format((float)$Afterdiscount + $row->deliveryfees + $row->taxfees -($row->voucher_amount), 2, '.', '')); ?>

														</td>
													<?php elseif($column === 'status'): ?>
														<?php if($row->status == 'opened'): ?>
															<td class="col-<?php echo e($column); ?>s">
																<?php if($row->version > 1): ?>
											   						<a href="#" id="showorder" data-route="<?php echo e(URL::route($model->model_name.'.show',   $row->id)); ?>" class="alarm Edit btn btn-primary btn-xs"><i class="fa fa-flag"></i></a>
																<?php endif; ?>
															</td>
														<?php elseif($row->status === 'viewed'): ?>
															<td class="col-<?php echo e($column); ?>s"><button type="button" data-route="<?php echo e(URL::route('Order.status',$row->id)); ?>" data-name="processing" id="ChangeAction" class="btn btn-block btn-primary btn-xs">viewed</button></td>
														<?php elseif($row->status === 'processing'): ?>
															<td class="col-<?php echo e($column); ?>s"><button type="button" data-route="<?php echo e(URL::route('Order.status',$row->id)); ?>" data-name="ondelivery"  id="ChangeAction" class="btn btn-block btn-warning btn-xs">processing</button></td>
														<?php elseif($row->status === 'ondelivery'): ?>
															<td class="col-<?php echo e($column); ?>s"><button type="button" data-route="<?php echo e(URL::route('Order.status',$row->id)); ?>" data-name="closed"     id="ChangeAction" class="btn btn-block btn-success btn-xs">ondelivery</button></td>
														<?php elseif($row->status === 'canceled'): ?>
															<td class="col-<?php echo e($column); ?>s"><button type="button" data-route="<?php echo e(url(route('Order.statuspost',$row->id))); ?>" data-token="<?php echo e(csrf_token()); ?>" data-name="canceled"     id="canceledOrder" class="btn btn-block btn-info btn-xs">canceled</button></td>
														<?php elseif($row->status === 'closed'): ?>
															<td class="col-<?php echo e($column); ?>s"><button type="button" class="ChangeAction  btn btn-block btn-primary btn-xs">canceled</button></td>
														<?php endif; ?>
													<?php elseif($column === 'driver_id'): ?>
														<?php  $COLUMN	=str_replace('_id','',$column);  ?>
														<td class="col-<?php echo e($column); ?><?php echo e($row->id); ?>">
															<?php if(!empty($row->$COLUMN->name)): ?>
																<button type="button" data-route="<?php echo e(URL::route('Order.driver',$row->id)); ?>" data-name="closed"     id="ChangeAction" class="btn btn-block btn-success btn-xs"><?php echo e($row->$COLUMN->name); ?></button>
															<?php else: ?>
																<?php if(!empty($row->$COLUMN)): ?>
																	<?php if(!empty(eval('return $row->$COLUMN->'.$COLUMN.'_name;'))): ?>
																		<?php echo e(eval('return $row->$COLUMN->'. $COLUMN.'_name;')); ?>

																	<?php endif; ?>
																<?php endif; ?>

															<?php endif; ?>
														</td>

													<?php elseif($column == 'address_id'): ?> 
														<?php  $COLUMN	=str_replace('_id','',$column);  ?>
														<td class="col-<?php echo e($column); ?>">
															<?php if(!empty($row->$COLUMN->address)): ?>
																<?php echo e($row->$COLUMN->address); ?> 
															<?php else: ?>
																<?php if(!empty($row->$COLUMN)): ?>
																	<?php if(!empty(eval('return $row->$COLUMN->address;'))): ?>
																		<?php echo e(eval('return $row->$COLUMN->address;')); ?>

																	<?php endif; ?>
																<?php endif; ?>

															<?php endif; ?>
														</td>


													<?php elseif(strpos($column, '_id') !== false): ?> 
														<?php  $COLUMN	=str_replace('_id','',$column);  ?>
														<td class="col-<?php echo e($column); ?>">
															<?php if(!empty($row->$COLUMN->name)): ?>
																<?php echo e($row->$COLUMN->name); ?>

															<?php else: ?>
																<?php if(!empty($row->$COLUMN)): ?>
																	<?php if(!empty(eval('return $row->$COLUMN->'.$COLUMN.'_name;'))): ?>
																		<?php echo e(eval('return $row->$COLUMN->'. $COLUMN.'_name;')); ?>

																	<?php endif; ?>
																<?php endif; ?>

															<?php endif; ?>
														</td>
													<?php elseif(strpos($column, '_by') !== false): ?> 
														<?php  $COLUMN	=str_replace('_by','_name',$column);  ?>
														<td class="col-<?php echo e($column); ?>">
															<?php if(!empty($row->$COLUMN->name)): ?><?php echo e($row->$COLUMN->name); ?><?php endif; ?>
														</td>
													<?php elseif(strpos($key   , '_relation') !== false): ?> 
														<?php  $COLUMN	= str_replace('_relation','',$key);  ?>
														<td class="col-<?php echo e($COLUMN); ?>">
															<?php if(!empty($row->$column)): ?>
																<?php foreach($row->$column as $key => $value): ?>
																	<span class="label label-default"><?php echo e($value->$COLUMN); ?></span>,
																<?php endforeach; ?>
															<?php endif; ?>

															
														</td>
													<?php else: ?>
														<!--  -->
														<td class="col-<?php echo e($column); ?>"><?php echo e($row->$column); ?></td>
													<?php endif; ?>
												<?php endforeach; ?>
												<?php if(!empty($model->model_name)): ?>
													<td class="text-center col-action col-md-1">
												   		<a 			  href="#" id="showorder" data-route="<?php echo e(URL::route($model->model_name.'.show',   $row->id)); ?>" class="Edit btn btn-info btn-xs" ><i class="fa fa-shopping-basket"></i></a>
												   		<a 		target="_blank"	  href="<?php echo e(URL::route('Account.show',['id' => $row->account_id ,'contact' => $row->contact_id,'branch'=>$row->branch_id,'address'=> $row->address_id] )); ?>" id="showAccount" class="Edit btn btn-primary btn-xs" ><i class="fa fa-user"></i></a>
												    </td>
											    <?php endif; ?>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
			        	</div>
						<div class="box-footer">
							<div class="col-md-6 text-left"  id="loadpaginate"><?php echo str_replace('/?','?',$datatable->render()); ?> </div>
							<div class="col-md-6 text-right" ><ul id="loadingcount" class="pagination text-left">Show <?php echo $datatable->count(); ?> of <?php echo $datatable->total(); ?></ul></div>
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
	<style type="text/css"></style>
	<script type="text/javascript">
		$(document).on('click','#showorder',function(e){ 
			e.preventDefault();
			var user 	= '<?php echo e(Auth::user()->is("branch")); ?>';
			
	        var route   = $(this).data('route');
	        var status 	= $(this).parent().parent().find('.col-status');
	        var action 	= $(this).parent().parent().find('.col-actions');
	        var id 		= $(this).parent().parent().find('.col-id').attr('id');
	        var btnroute   = "<?php echo e(URL::route('Order.status','')); ?>"+"/"+id;
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
	
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>