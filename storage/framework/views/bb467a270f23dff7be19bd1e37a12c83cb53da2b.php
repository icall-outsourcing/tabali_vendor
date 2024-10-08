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
 	<div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
				<li><a href="<?php echo e(url(route('Order.index'))); ?>" >Activity</a></li>
              	<li class="active"><a href="<?php echo e(url(route('Order.canceled'))); ?>">canceled</a></li>
              	<li><a href="<?php echo e(url(route('Order.closed'))); ?>">closed</a></li>
            </ul>
            <div class="tab-content">
				<div class="active tab-pane" id="canceled" style="width: 100%;height: 100%;overflow: auto;">
					<table id="canceledOrder" class="display" style="width:100%">
				        <thead>
				            <tr>
								<?php foreach($model->getCasts() as $key => $value): ?>
									<?php if($value == 'int' || $value === 'action'): ?> 
									<?php elseif(strpos($key, '_relation') !== false): ?> 
										<th class="col-<?php echo e($value); ?>" class="text-center"><div class="text-center"><?php echo e(trans('form.'.$value)); ?></div></th>
									<?php else: ?>
										<th class="text-center"><?php echo e(trans('form.'.$value)); ?></th>
									<?php endif; ?>
								<?php endforeach; ?>
									<th>سبب الالغاء</th>
                                    <th></th>
							</tr>
				        </thead>
				        <tbody>
			    			<?php foreach($datatable as $row ): ?>
								<tr style="cursor:pointer" class="tr clickable-row" data-id="<?php echo e(URL::route($model->model_name.'.show',   $row->id)); ?>" data-href="<?php echo e(URL::route($model->model_name.'.show',$row->id)); ?>">
									<?php foreach($model->getCasts() as $key => $column): ?>
										<?php if($column == 'int' || $column === 'action'): ?>

										<?php elseif($column === 'id'): ?>
											<td class="col-<?php echo e($column); ?>" id="<?php echo e($row->$column); ?>"><a href="#"><?php echo e($row->$column); ?></a></td>
										
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
									<td class="col-cancel_note"><?php echo e($row->cancel_note); ?></td>
									<td class="text-center col-action col-md-1">
										<a 			  href="#" id="showorder" data-route="<?php echo e(URL::route($model->model_name.'.show',   $row->id)); ?>" class="Edit btn btn-info btn-xs" ><i class=" fa fa-shopping-basket"></i></a>
									</td>
								</tr>
							<?php endforeach; ?>
				        </tbody>
				        <tfoot>
				            	<tr>
								<?php foreach($model->getCasts() as $key => $value): ?>
									<?php if($value == 'int' || $value === 'action'): ?> 
									<?php elseif(strpos($key, '_relation') !== false): ?> 
										<th class="col-<?php echo e($value); ?>" class="text-center"><div class="text-center"><?php echo e(trans('form.'.$value)); ?></div></th>
									<?php else: ?>
										<th class="text-center"><?php echo e(trans('form.'.$value)); ?></th>
									<?php endif; ?>
								<?php endforeach; ?>
									<th>سبب الالغاء</th>
									<th></th>
							</tr>
				        </tfoot>
				    </table>
				</div>
				
            </div>
        </div>
	</div>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" crossorigin="anonymous">
	<style type="text/css"></style>
	<script type="text/javascript">
	    $(document).ready(function() {
		    // Setup - add a text input to each footer cell
		    $('#canceledOrder tfoot th').each( function () {
		        var title = $(this).text();
		        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
		    } );
		 
		    // DataTable
		    var table = $('#canceledOrder').DataTable();
		 
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

	    



	     
                
           
	    
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>