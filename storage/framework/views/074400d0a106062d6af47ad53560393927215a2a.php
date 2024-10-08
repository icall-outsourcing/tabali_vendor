<!-- language -->
  <?php if(session()->has('lang')): ?>
      <?php echo e(App::setLocale(session()->get('lang'))); ?>

  <?php else: ?>
      <?php echo e(App::setLocale('ar')); ?>

  <?php endif; ?>


<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('layouts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


    <script type="text/javascript">
	    $(function () {
	        $('#close_on').datetimepicker({
	        	format: 'HH:mm',
	        	defaultDate: ' <?php echo e(date("HH:mm", time())); ?>'
	        });	       	       
	    });
  	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>