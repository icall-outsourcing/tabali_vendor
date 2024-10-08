<div class="panel panel-default">
	<!-- Default panel contents -->	
	<div class="panel-heading">
		<div class="row">
			<div class="col-lg-4">
				<div class="input-group">
					<?php if(!empty($model->model_name)): ?>
					<span class="input-group-btn CreateAdd">
                    	<?php if (Auth::check() && Auth::user()->is('admin')): ?>
						<a class="btn btn-primary" id="DownloadA" title="Download all data" href="javascript:document.getElementById('exportreport').submit();"><i class="fa fa-download"></i></a>
       					<a class="btn btn-primary" id="ExcelA" 	 title="Download selected data" onclick="saveAsExcel('tableToExcel', '<?php echo e($model->model_name); ?>.xls')"><i class="fa fa-file-excel-o"></i></a>
       					<?php endif; ?>
       					<a class="btn btn-primary" id="CreateA" title="Create" href="<?php echo e(URL::route($model->model_name.'.create')); ?>"><i>Add <?php echo e($model->model_name); ?></i></a>
				    </span>
      				<?php endif; ?>
      				<select class="form-control" id="rows" onchange="pageid();">
						<?php for($i = 10; $i <= 200; $i=$i+10): ?> 
							<option><?php echo e($i); ?></option>
						<?php endfor; ?>
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
					<?php foreach($model->getCasts() as $key => $value): ?>
						
						<?php if(strpos($value, '_id') !== false): ?>
							<th class="col-<?php echo e($value); ?>">
								<?php echo Form::select($value,[null =>'Please Select'] + eval('return $'. $value . ';'),null,['class' => 'filter form-control input-sm select2','id' => $value,'onchange'=>'pageid();']); ?>

							</th>
						<?php elseif(strpos($value, '_by') !== false): ?>
							
							<th class="col-<?php echo e($value); ?>">
								<?php echo Form::select($value,[null =>'Please Select'] + eval('return $'. $value . ';'),null,['class' => 'filter form-control input-sm select2','id' => $value,'onchange'=>'pageid();']); ?>

							</th>
						<?php elseif(strpos($key, '_relation') !== false): ?>
							<?php  $COLUMN	= str_replace('_relation','',$key);  ?>
							<th class="col-<?php echo e($COLUMN); ?>">
							<input name="<?php echo e($value.'.'.$COLUMN); ?>" id="<?php echo e($key); ?>" onchange='pageid();' value="" class="form-control input-sm" style="width: 100%;padding: 3px;box-sizing: border-box;"></input>
							</th>
						<?php else: ?>
							<th class="col-<?php echo e($value); ?>">
							<input name="<?php echo e($value); ?>" id="<?php echo e($value); ?>" onchange='pageid();' value="" class="form-control input-sm" style="width: 100%;padding: 3px;box-sizing: border-box;"></input>
							</th>
						<?php endif; ?>
					<?php endforeach; ?>
					<th class="col-md-1 col-action text-center"></th>
				</tr>
				<tr>
					<?php foreach($model->getCasts() as $key => $value): ?>
						<?php if(strpos($key, '_relation') !== false): ?> 
							<th class="col-<?php echo e($value); ?>" class="text-center"><div class="text-center"><?php echo e(trans('form.'.$value)); ?><span name="id" type="asc" class="sort fa fa-sort pull-right"></span></div></th>
						<?php else: ?>
							<th class="col-<?php echo e($value); ?>" class="text-center"><div class="text-center"><?php echo e(trans('form.'.$value)); ?><span name="<?php echo e($value); ?>" type="asc" class="sort fa fa-sort pull-right"></span></div></th>
						<?php endif; ?>
					<?php endforeach; ?>
						<th class="col-md-1 col-action text-center">Action</th>
				</tr>
			</thead>
			<tbody id="data" class="insertData text-center">
				<?php foreach($datatable as $row ): ?>
					<?php if(!empty($model->model_name)): ?>
					<tr style="cursor:pointer" class="tr clickable-row" data-id="<?php echo e(URL::route($model->model_name.'.show',   $row->id)); ?>" data-href="<?php echo e(URL::route($model->model_name.'.show',   $row->id)); ?>">
					<?php endif; ?>
						<?php foreach($model->getCasts() as $key => $column): ?>
							<?php if($key === 'img'): ?>
								<td class="col-<?php echo e($column); ?> text-center">
									<img class="img" src="<?php echo e(asset($row->$column)); ?>" width="25" height="25">
								</td>
							<?php elseif($column === 'id'): ?>
								<!--  -->
								<td class="col-<?php echo e($column); ?>" id="<?php echo e($row->$column); ?>"><?php echo e($row->$column); ?></td>
							<?php elseif(strpos($column, '_id') !== false): ?> 
								<?php  $COLUMN	=str_replace('_id','',$column);  ?>
								<td class="col-<?php echo e($column); ?>">
									<?php if(!empty($row->$COLUMN->name)): ?><?php echo e($row->$COLUMN->name); ?><?php endif; ?>
									<?php if(!empty($row->$COLUMN->contact_name)): ?><?php echo e($row->$COLUMN->contact_name); ?><?php endif; ?>
									<?php if($column == 'order_id'): ?><?php echo e($row->$column); ?><?php endif; ?>
								</td>
							<?php elseif(strpos($column, '_code') !== false): ?> 
								<?php  $COLUMN	=str_replace('_code','',$column);  ?>
								<td class="col-<?php echo e($column); ?>">
									<?php if(!empty($row->$COLUMN->contact_name)): ?><?php echo e($row->$COLUMN->contact_name); ?><?php endif; ?>
								</td>								
							<?php elseif(strpos($column, '_by') !== false): ?> 
								<?php  $COLUMN	=str_replace('_by','_name',$column);  ?>
								<td class="col-<?php echo e($column); ?>">
									<?php if(!empty($row->$COLUMN->name)): ?><?php echo e($row->$COLUMN->name); ?><?php endif; ?>
								</td>
							<?php elseif(strpos($column, '_List') !== false): ?>
								<td class="col-<?php echo e($column); ?>">
									<?php if(!empty($row->$column)): ?>
										<?php foreach($row->$column as $key => $value): ?>
											<span class="label label-default"><?php echo e($key); ?></span>
										<?php endforeach; ?>
									<?php endif; ?>
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
					   		<button data-route="<?php echo e(URL::route($model->model_name.'.show',   $row->id)); ?>" id ="=<?php echo e($row->id); ?>"  type="button" class="Show btn btn-info btn-xs"><i class="fa fa-eye"></i></button>
					   		<a            href="<?php echo e(URL::route($model->model_name.'.edit',   $row->id)); ?>" class="Edit btn btn-primary btn-xs" ><i class=" fa fa-pencil-square-o"></i></a>
					   		
							<?php if(Auth::user()->is('admin')): ?>
								<?php if($model->model_name == 'User'): ?>
									<button data-route="<?php echo e(URL::route($model->model_name.'.destroy',$row->id)); ?>" id="<?php echo e($row->id); ?>" data-token="<?php echo e(csrf_token()); ?>" type="button" class="destroy btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button> 
								<?php endif; ?>
							<?php endif; ?>


					   		


					    </td>
					    <?php endif; ?>
					</tr>
				<?php endforeach; ?>
				<?php /*
				<tr>
					<td colspan="{{count($model->getCasts())+1}}"> 
						<div class="row">
							<div class="col-md-6 text-left">{!! str_replace('/?','?',$datatable->appends(['search' => Input::get('search')])->appends(['sort' => Input::get('sort')])->render())!!} </div>
							<div class="col-md-6 text-right"><ul class="pagination text-left">Show {!! $datatable->count() !!} of {!! $datatable->total() !!}</ul>
							</div>
						</div>
					</td>
				</tr>
				*/?>
			</tbody>
			<tfooter class="tfooter" >
			</tfooter>
		</table>
	</div>
	<div class="box-footer">
		<div class="col-md-6 text-left"  id="loadpaginate"><?php echo str_replace('/?','?',$datatable->render()); ?> </div>
		<div class="col-md-6 text-right" ><ul id="loadingcount" class="pagination text-left">Show <?php echo $datatable->count(); ?> of <?php echo $datatable->total(); ?></ul></div>
	</div>
</div>

