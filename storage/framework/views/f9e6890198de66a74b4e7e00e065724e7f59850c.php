<!-- language -->
  <?php if(session()->has('lang')): ?>
      <?php echo e(App::setLocale(session()->get('lang'))); ?>

  <?php else: ?>
      <?php echo e(App::setLocale('ar')); ?>

  <?php endif; ?>
  
<?php  $branch_id  = \App\Branch::all()->lists('name','id')->toArray();  ?>
  

<?php $__env->startSection('content'); ?>
  <?php echo $__env->make('layouts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php if(Input::get('order')): ?>
    <input class="Append" type="hidden" id="order_id" name="order_id" value="<?php echo e(Input::get('order')); ?>">
    <?php endif; ?>
    <script type="text/javascript">
    	jQuery(document).ready(function($) {
	    	$('#account_id').val("<?php echo e($account->id); ?>");
	    	$('#contact_id').val("<?php echo e($contact->id); ?>");
	    	$('#branch_id').val("<?php echo e($branch->id); ?>");
	    	$('.NewAppend').append($('.Append'));
	    });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>