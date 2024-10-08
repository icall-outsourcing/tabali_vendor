<!-- language -->
  <?php if(session()->has('lang')): ?>
      <?php echo e(App::setLocale(session()->get('lang'))); ?>

  <?php else: ?>
      <?php echo e(App::setLocale('ar')); ?>

  <?php endif; ?>
<?php echo $__env->make('layouts.pageid', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<script type="text/javascript">
	$('.col-int').remove();
	$('.Show').remove();
	$('.destroy').remove();
</script>	