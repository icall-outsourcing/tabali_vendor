
<?php if($Product->extratype != 'composite'): ?>
	الاضافات   
	<select id="addEI" class="form-control select2">
		<option></option>
		<?php foreach($ExtraItems as $key => $value ): ?>
			<?php if($value->price == 0): ?>
				<option id="<?php echo e($value->id); ?>" style="background-color: #f39c12;color:#FFF"><span class="label label-success">مجانى </span> <?php echo e($value->ar_name); ?></option>
			<?php else: ?>
				<option id="<?php echo e($value->id); ?>"><?php echo e($value->ar_name); ?> - <?php echo e($value->price); ?></option>
			<?php endif; ?>
		<?php endforeach; ?>
	</select>
<?php else: ?>
	<?php  $hr = array();  ?>
	<?php foreach($ExtraItems as $key => $value ): ?>	
		<?php if(in_array($value->item_code, $hr) == false): ?>			
			<hr/>
			<?php  $hr[$value->item_code] =  $value->item_code  ?>
		<?php endif; ?>
		<input id="<?php echo e($value->id); ?>" type="radio" name="<?php echo e($value->item_code); ?>" value="male" checked="checked" class="btn btn-info"> <?php echo e($value->ar_name); ?> <br>
	<?php endforeach; ?>
<?php endif; ?>