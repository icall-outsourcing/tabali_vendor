<!-- language -->
  <?php if(session()->has('lang')): ?>
      <?php echo e(App::setLocale(session()->get('lang'))); ?>

  <?php else: ?>
      <?php echo e(App::setLocale('ar')); ?>

  <?php endif; ?>


<tbody  id="data" class="insertData text-center">
	<?php foreach($DataTable as $row ): ?>
		<?php if(!empty($myModal->model_name)): ?>
			<tr style="cursor:pointer" class="loadingrow tr clickable-row" data-id="<?php echo e(URL::route($myModal->model_name.'.show',   $row->id)); ?>" data-href="<?php echo e(URL::route($myModal->model_name.'.show',   $row->id)); ?>">
		<?php endif; ?>
			<?php foreach($myModal->getCasts() as $key => $column): ?>
				<?php if($column == 'int'): ?>	
				<?php elseif($key === 'img'): ?>
					<td class="col-<?php echo e($column); ?> text-center">
						<img class="img" src="<?php echo e(asset($row->$column)); ?>" width="25" height="25">
					</td>
				<?php elseif($column === 'id'): ?>
					<!--  -->
					<td class="col-<?php echo e($column); ?>" id="<?php echo e($row->$column); ?>"><?php echo e($row->$column); ?></td>
				<?php elseif($column === 'action'): ?>
					<?php if($row->status == 'opened'): ?>
						<td class="col-<?php echo e($column); ?>s">
							<?php if($row->version > 1): ?>
		   						<a href="#" id="showorder" data-route="<?php echo e(URL::route($myModal->model_name.'.show',   $row->id)); ?>" class="alarm Edit btn btn-primary btn-xs"><i class="fa fa-flag"></i></a>
							<?php endif; ?>
							<audio id="myAudio">
							  <source src="<?php echo e(asset('/music/order.mp3')); ?>" type="audio/mpeg">
							  Your browser does not support the audio element. 
							</audio>
							<script>
								var x = document.getElementById("myAudio");
								x.play(); 
							</script>
						</td>
					<?php elseif($row->status === 'viewed'): ?>
						<td class="col-<?php echo e($column); ?>s"><button type="button" data-route="<?php echo e(URL::route('Order.status',$row->id)); ?>" data-name="processing" id="ChangeAction" class="btn btn-block btn-primary btn-xs">processing</button></td>
					<?php elseif($row->status === 'processing'): ?>
						<td class="col-<?php echo e($column); ?>s"><button type="button" data-route="<?php echo e(URL::route('Order.status',$row->id)); ?>" data-name="ondelivery"  id="ChangeAction" class="btn btn-block btn-warning btn-xs">ondelivery</button></td>
					<?php elseif($row->status === 'ondelivery'): ?>
						<td class="col-<?php echo e($column); ?>s"><button type="button" data-route="<?php echo e(URL::route('Order.status',$row->id)); ?>" data-name="closed"     id="ChangeAction" class="btn btn-block btn-success btn-xs">closed</button></td>
					<?php elseif($row->status === 'closed'): ?>
						<td class="col-<?php echo e($column); ?>s"><button type="button" class="ChangeAction  btn btn-block btn-primary btn-xs">canceled</button></td>
						
					<?php endif; ?>
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
				

				<?php elseif(strpos($column, 'available') !== false): ?> 
					<td class="col-<?php echo e($column); ?>">
						<select name="<?php echo e($column); ?>" id="<?php echo e($row->id); ?>-<?php echo e($column); ?>" class="form-control input-sm">
							<option value='ON' <?php if($row->$column=='ON'): ?> selected="selected" <?php endif; ?>>ON</option>                                
		                                        <option value='OFF' <?php if($row->$column=='OFF'): ?> selected="selected" <?php endif; ?>>OFF</option>
                                                        <option value='1' <?php if($row->$column=='1'): ?> selected="selected" <?php endif; ?>>unAailable till 1 hour</option>
                                                        <option value='2' <?php if($row->$column=='2'): ?> selected="selected" <?php endif; ?>>unAailable till 2 hour</option>
                                                        <option value='4' <?php if($row->$column=='4'): ?> selected="selected" <?php endif; ?>>unAailable till 4 hour</option>
                                                        <option value='next_day' <?php if($row->$column=='next_day'): ?> selected="selected" <?php endif; ?>>unAailable till next day</option>

						</select>
					</td>
<?php elseif(strpos($column, 'price') !== false && Auth::user()->is('admin|tabaliadmin')): ?> 
										<td class="col-<?php echo e($column); ?>">
											<input name="<?php echo e($column); ?>" id="<?php echo e($row->id); ?>-<?php echo e($column); ?>" value="<?php echo e($row->$column); ?>" class="form-control input-sm">
										</td>


				<?php else: ?>
					<!--  -->
					<td class="col-<?php echo e($column); ?>"><?php echo e($row->$column); ?></td>
				<?php endif; ?>
			<?php endforeach; ?>
		    <?php if(!empty($myModal->model_name)): ?>
				<td class="text-center col-action col-md-1">
			   		<a    id="updateproduct"    data-available="<?php echo e($row->id); ?>-available"  data-price="<?php echo e($row->id); ?>-price" href="#" data-route="<?php echo e(URL::route($myModal->model_name.'.update',   $row->id)); ?>" class="Edit btn btn-primary btn-xs" ><i class=" fa fa-pencil-square-o"></i></a>
			    </td>
		    <?php endif; ?>



		</tr>
	<?php endforeach; ?>
</tbody>
	<tr>
		<td colspan="<?php echo e(count($myModal->getCasts())+1); ?>"> 
			<div class="row">
				<div class="col-md-9 text-left"  id="loadpaginate"><?php echo str_replace('/?','?',$DataTable->appends(['search' => Input::get('search')])->appends(['sort' => Input::get('sort')])->render()); ?> </div>
				<div class="col-md-3 text-right" ><ul id="loadingcount" class="pagination text-left">Show <?php echo $DataTable->count(); ?> of <?php echo $DataTable->total(); ?></ul></div>
			</div>
		</td>
	</tr>
<script type="text/javascript">
	
</script>	
