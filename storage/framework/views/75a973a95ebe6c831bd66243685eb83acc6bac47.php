<!-- language -->
  <?php if(session()->has('lang')): ?>
      <?php echo e(App::setLocale(session()->get('lang'))); ?>

  <?php else: ?>
      <?php echo e(App::setLocale('ar')); ?>

  <?php endif; ?>
<?php  $branch_id  = \App\Branch::all()->lists('name','id')->toArray();  ?>
  

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('layouts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="well Append col-md-4">
        
    <div class="  status col-md-12">
        <div class="form-group">
            <?php  $status = array ('opened'=>'opened','processing'=>'processing','closed'=>'closed'); ?>
            <label for="status" class="control-label"> حالة الشكوى </label>
            <?php echo Form::select('status',$status,$EditData->status,['class' => 'form-control','id' => 'status']); ?>

        </div>
    </div>
    <div class="  close_inquiry_comment col-md-12">
        <div class="form-group">
            <label for="close_inquiry_comment" class="control-label"> حل الشكوى  </label>
            <div class="check_close_inquiry_comment">
                <textarea class="form-control" id="close_inquiry_comment" name="close_inquiry_comment" cols="30" rows="5"><?php echo e($EditData->close_inquiry_comment); ?></textarea>
                </div>
        </div>
    </div>
    </div>
    <script type="text/javascript">
        $('.NewAppend').append($('.Append'));
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>