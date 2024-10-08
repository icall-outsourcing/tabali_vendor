<!-- language -->
  <?php if(session()->has('lang')): ?>
      <?php echo e(App::setLocale(session()->get('lang'))); ?>

  <?php else: ?>
      <?php echo e(App::setLocale('ar')); ?>

  <?php endif; ?>
  <?php  use Carbon\Carbon;  ?>
<tbody  id="data" class="insertData text-center">
	<?php foreach($DataTable as $row ): ?>
        <?php 
			$StartTime 	= Carbon::parse($row->created_at);
			$EndTime 	= Carbon::now();
			$Hours 		= $StartTime->diffInHours($EndTime);
			$Minutes 	= $StartTime->diffInMinutes($EndTime);
			$Seconds 	= $StartTime->diffInSeconds($EndTime);
			$Seconds =  $Seconds - $Minutes * 60;
			$Minutes =  $Minutes - $Hours * 60;
		 ?>
		<?php if(!empty($myModal->model_name)): ?>
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
					<?php elseif($Minutes > 15): ?> 
						style="background-color: #795548;color:#fff" 
					<?php endif; ?>
						style="cursor:pointer;" class="trtime loadingrow tr clickable-row" data-id="<?php echo e(URL::route($myModal->model_name.'.show',   $row->id)); ?>" data-href="<?php echo e(URL::route($myModal->model_name.'.show',   $row->id)); ?>">
					<?php endif; ?>
					
					
					
			<?php foreach($myModal->getCasts() as $key => $column): ?>
				<?php if($column == 'int'): ?>				
				<?php elseif($key === 'img'): ?>
					<td class="col-<?php echo e($column); ?> text-center">
						<img class="img" src="<?php echo e(asset($row->$column)); ?>" width="25" height="25">
					</td>
				<?php elseif($column === 'id'): ?>
					<!--  -->
					<td class="col-<?php echo e($column); ?>" id="<?php echo e($row->$column); ?>"><?php echo e($row->$column); ?>   || Time   <?php echo e($Minutes); ?></td>
                <?php elseif($column === 'total'): ?>
						    <td class="col-<?php echo e($column); ?>" id="<?php echo e($row->$column); ?>"><?php echo e($row->total + $row->deliveryfees); ?></td>
				<?php elseif($column === 'status'): ?>
					<?php if($row->status == 'opened'): ?>
						<td class="col-<?php echo e($column); ?>s">
							<?php if($row->version > 1): ?>
		   						<a href="#" id="showorder" data-route="<?php echo e(URL::route($myModal->model_name.'.show',   $row->id)); ?>" class="alarm Edit btn btn-primary btn-xs"><i class="fa fa-flag"></i></a>
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
						<td class="col-<?php echo e($column); ?>s"><button type="button" class="ChangeAction  btn btn-block btn-primary btn-xs">closed</button></td>
						
					<?php endif; ?>
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
								<span class="label label-default"><?php echo e($value->$COLUMN); ?></span>
							<?php endforeach; ?>
						<?php endif; ?>

						
					</td>
				<?php else: ?>
					<!--  -->
					<td class="col-<?php echo e($column); ?>"><?php echo e($row->$column); ?></td>
				<?php endif; ?>
			<?php endforeach; ?>
			
			<?php if(!empty($myModal->model_name)): ?>
				<td class="text-center col-action">
					<a 			  href="#" id="showorder" data-route="<?php echo e(URL::route($myModal->model_name.'.show',   $row->id)); ?>" class="Edit btn btn-info btn-xs" ><i class="fa fa-shopping-basket"></i></a>
					<a 	target="_blank"		  href="<?php echo e(URL::route('Account.show',['id' => $row->account_id ,'contact' => $row->contact_id,'branch'=>$row->branch_id,'address'=> $row->address_id] )); ?>" id="showAccount" class="Edit btn btn-primary btn-xs" ><i class="fa fa-user"></i></a>

			    </td>
		    <?php endif; ?>
		</tr>
	<?php endforeach; ?>
</tbody>
<tr>
		<td colspan="<?php echo e(count($myModal->getCasts())+1); ?>"> 
			<div class="row">
				<!--<div class="col-md-2">
					<button class="btn btn-primary" onclick="saveAsExcel('tableToExcel', '<?php echo e($myModal->model_name); ?>.xls')"><i class="fa fa-file-excel-o"></i> Export </button>
				</div>-->
				<div class="col-md-6 text-left"  id="loadpaginate"><?php echo str_replace('/?','?',$DataTable->appends(['search' => Input::get('search')])->appends(['sort' => Input::get('sort')])->render()); ?> </div>
				<div class="col-md-6 text-right" ><ul id="loadingcount" class="pagination text-left">Show <?php echo $DataTable->count(); ?> of <?php echo $DataTable->total(); ?></ul></div>
			</div>
		</td>
	</tr>
<script type="text/javascript">
	$('.col-int').remove();
	$('.Show').remove();
</script>