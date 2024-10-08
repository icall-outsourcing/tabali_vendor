<!-- language -->
  <?php if(session()->has('lang')): ?>
      <?php echo e(App::setLocale(session()->get('lang'))); ?>

  <?php else: ?>
      <?php echo e(App::setLocale('ar')); ?>

  <?php endif; ?>
<?php  $branch_id  = \App\Branch::all()->lists('name','id')->toArray();  ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('layouts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <script type="text/javascript">
    	jQuery(document).ready(function($) {
	    	$('#account_id').val("<?php echo e($account->id); ?>");
	    	$('#contact_id').val("<?php echo e($contact->id); ?>");
	    });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>