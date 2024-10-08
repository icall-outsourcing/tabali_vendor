<?php if($Product->extratype == 'composite'): ?>
	<?php  $hr = array();  ?>	
	<?php foreach($ExtraItems as $key => $value ): ?>	
		<?php if(in_array($value->groupsectionby, $hr) == false): ?>			
			<?php  $hr[$value->groupsectionby] =  $value->groupsectionby  ?>
			<hr/>
		<?php endif; ?>
		<input id="<?php echo e($value->id); ?>" type="checkbox" name="<?php echo e($value->item_code); ?>" value="<?php echo e($value->id); ?>"  class="btn btn-info compositeId"> <?php echo e($value->ar_name); ?> <br>
	<?php endforeach; ?>
<?php else: ?>
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

<?php endif; ?>