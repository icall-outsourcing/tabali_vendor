<!-- language -->
  <?php if(session()->has('lang')): ?>
      <?php echo e(App::setLocale(session()->get('lang'))); ?>

  <?php else: ?>
      <?php echo e(App::setLocale('ar')); ?>

  <?php endif; ?>

<?php  $branch_id  = Auth::User()->BranchsList;  ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid ">
	<!--Index-->
	<input type="hidden" id="key" 	 	 value="id">
	<input type="hidden" id="model"  	 value="Product">
	<input type="hidden" id="groupby" 	 value="id">
	<input type="hidden" id="path" 	 	 value="Setting">
	<input type="hidden" id="conditions" value='{}' name="conditions">
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
								<?php if($column === 'id'): ?>
									<!--  -->
									<td class="col-<?php echo e($column); ?>" id="<?php echo e($row->$column); ?>"><?php echo e($row->$column); ?></td>
								<?php elseif(strpos($column, '_id') !== false): ?> 
									<?php  $COLUMN	=str_replace('_id','',$column);  ?>
									<td class="col-<?php echo e($column); ?>">
										<?php if(!empty($row->$COLUMN->name)): ?><?php echo e($row->$COLUMN->name); ?><?php endif; ?>
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



								


								<?php elseif(strpos($column, 'available') !== false): ?> 
									<td class="col-<?php echo e($column); ?>">
										<select name="<?php echo e($column); ?>" id="<?php echo e($row->id); ?>-<?php echo e($column); ?>" class="form-control input-sm">
											<option <?php if($row->$column=='ON'): ?> selected="selected" <?php endif; ?>>ON</option>
											<option <?php if($row->$column=='OFF'): ?> selected="selected" <?php endif; ?>>OFF</option>
										</select>
									</td>
<?php elseif(strpos($column, 'price') !== false && Auth::user()->is('admin')): ?> 
										<td class="col-<?php echo e($column); ?>">
											<input name="<?php echo e($column); ?>" id="<?php echo e($row->id); ?>-<?php echo e($column); ?>" value="<?php echo e($row->$column); ?>" class="form-control input-sm">
										</td>

								




								<?php else: ?>
									<!--  -->
									<td class="col-<?php echo e($column); ?>"><?php echo e($row->$column); ?></td>
								<?php endif; ?>
							<?php endforeach; ?>
							<?php if(!empty($model->model_name)): ?>
							<td class="text-center col-action col-md-1">
						   		<a    id="updateproduct"    data-available="<?php echo e($row->id); ?>-available"  data-price="<?php echo e($row->id); ?>-price" href="#" data-route="<?php echo e(URL::route($model->model_name.'.update',   $row->id)); ?>" class="Edit btn btn-primary btn-xs" ><i class=" fa fa-pencil-square-o"></i></a>
						    </td>
						    <?php endif; ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
				<tfooter class="tfooter" >
				</tfooter>
			</table>
		</div>
		<div class="box-footer">
			<div class="col-md-9 text-left"  id="loadpaginate"><?php echo str_replace('/?','?',$datatable->render()); ?> </div>
			<div class="col-md-3 text-right" ><ul id="loadingcount" class="pagination text-left">Show <?php echo $datatable->count(); ?> of <?php echo $datatable->total(); ?></ul></div>
		</div>
	</div>



 	
	<!--End Index-->
</div>
<script type="text/javascript">
	$('.col-int').remove();

	$(document).on('click','#updateproduct',function(e){ 
			e.preventDefault();
			var available   = $('#'+$(this).data('available')).val();
			var price   	= $('#'+$(this).data('price')).val();
			var route   	= $(this).data('route');
			var _token 	 	=	"<?php echo e(csrf_token()); ?>";
			$.ajax({
              type: "PUT",
              url : route,
              data:{available:available,price:price,_token:_token},
              	success : function(data){
                    if(data == 'success'){
                      $.alert({
				      icon: 'icon fa fa-check',
				      title: '',
				      content: "<center>  لقد تم تحديث البيانات بنجاح </centre>"
				  });
                    }else{
                      for (var key in data) {
                            // skip loop if the property is from prototype
                            if (!data.hasOwnProperty(key)) continue;

                            var obj = data[key];
                            $( "#chnagemypasswordmessage" ).html("");
                            for (var prop in obj) {
                                // skip loop if the property is from prototype
                                if(!obj.hasOwnProperty(prop)) continue;

                                // your code
                                $( "#chnagemypasswordmessage" ).addClass( "alert alert-danger" );
                                $('#chnagemypasswordmessage').append('<center>'+obj[prop]+'</center><br/>');                          
                            }
                      }
                    }
              	},
				error : function(data){
				  $.alert({
				      icon: 'icon fa fa-ban fa-spin',
				      title: '- يوجد خطاء !',
				      content: "<center>يوجد خطا بالنظام يرجى عمل تحديث الصفحه واعاده المحاوله</centre>"
				  });
				  submit.show();
				}
              },"json");




	    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>