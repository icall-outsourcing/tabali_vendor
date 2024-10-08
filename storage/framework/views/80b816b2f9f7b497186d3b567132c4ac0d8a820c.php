<!-- language -->
    <?php if(session()->has('lang')): ?>
        <?php echo e(App::setLocale(session()->get('lang'))); ?>

    <?php else: ?>
        <?php echo e(App::setLocale('ar')); ?>

    <?php endif; ?>


<?php $__env->startSection('content'); ?>

    <div class="container-fluid">
      <div class="row">
      <div class="col-md-8 col-md-push-2">
        <div class="box box-Success">
              <div class="box-header with-border"><h3 class="box-title text-green"><?php echo e(trans('form.account')); ?></h3></div>
              <div class="box-body" style="display: block;">
                  <?php echo $__env->make('layouts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  <input class="Append" type="hidden" name="phone_number" value="<?php echo e(Input::get('phone_number')); ?>">
              </div>
          </div>
      </div>
        </div>      
    </div>
    <script type="text/javascript">
      $('.NewAppend').append($('.Append'));
      
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>