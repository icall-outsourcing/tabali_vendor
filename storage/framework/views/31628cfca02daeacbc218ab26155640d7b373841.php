<!-- language -->
  <?php if(session()->has('lang')): ?>
      <?php echo e(App::setLocale(session()->get('lang'))); ?>

  <?php else: ?>
      <?php echo e(App::setLocale('ar')); ?>

  <?php endif; ?>
  <?php  $branch_id  = \App\Branch::all()->lists('name','id')->toArray();  ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid ">
	<!--Index-->
	<input type="hidden" id="key" 	 	 value="id">
	<input type="hidden" id="model"  	 value="User">
	<input type="hidden" id="groupby" 	 value="id">
	<input type="hidden" id="path" 	 	 value="Setting">
	<input type="hidden" id="conditions" value='{}' name="conditions">
 	<?php echo $__env->make('layouts.index', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<!--End Index-->
</div>
<script type="text/javascript">
	$('.col-int').remove();
	// $('.Show').remove();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>