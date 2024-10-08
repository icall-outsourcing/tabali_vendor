<!-- language -->
  <?php if(session()->has('lang')): ?>
      <?php echo e(App::setLocale(session()->get('lang'))); ?>

  <?php else: ?>
      <?php echo e(App::setLocale('ar')); ?>

  <?php endif; ?>
  <?php  $branch_id  = \App\Branch::all()->lists('name','id')->toArray();  ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('layouts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


    <?php if($EditData->order_id): ?>
    <div class="Append order_id col-md-4">
      
        <div class="form-group">
            
            <label for="order_id" class="control-label"> رقم الطلب </label>
            <?php echo Form::text('order_id',$EditData->order_id,['class' => 'form-control','id' => 'order_id','disabled']); ?>


            <a href="#" id="showorder" data-route="<?php echo e(url(route('Order.show',$EditData->order_id))); ?>" class="Edit btn btn-info btn-xs" ><i class=" fa fa-shopping-basket"></i></a>
        </div>
      
    </div>
    <?php endif; ?>


    <div class="well Append col-md-4">
        
    <div class="  status col-md-12">
        <div class="form-group">
            <?php  $status = array ('opened'=>'opened','processing'=>'processing','closed'=>'closed'); ?>
            <label for="status" class="control-label"> حالة الشكوى </label>
            <?php echo Form::select('status',$status,$EditData->status,['class' => 'form-control','id' => 'status']); ?>

        </div>
    </div>
    <div class="  close_complain_comment col-md-12">
        <div class="form-group">
            <label for="close_complain_comment" class="control-label"> حل الشكوى  </label>
            <div class="check_close_complain_comment">
                <textarea class="form-control" id="close_complain_comment" name="close_complain_comment" cols="30" rows="5"><?php echo e($EditData->close_complain_comment); ?></textarea>
                </div>
        </div>
    </div>
    </div>
    <script type="text/javascript">
        $('.NewAppend').append($('.Append'));

        document.getElementById("Priority").disabled = true;
        document.getElementById("branch_id").disabled = true;
        document.getElementById("follow_up_phone").disabled = true;
        document.getElementById("complaint_type").disabled = true;
        document.getElementById("complain_comment").disabled = true;


	$(document).on('click','#showorder',function(e){ 
	   e.preventDefault();
	   var route   = $(this).data('route');
	   $.confirm({
		            title           : 'Show Order',
		            columnClass     : 'col-md-12',
		            closeIcon       :  true,
		            content         : 'url:'+route,
		            //animation     : 'top',
		            //closeAnimation: 'bottom',
		            animation       : 'zoom',
		            cancelButton: false, // hides the cancel button.
					confirmButton: false, // hides the confirm button.
	        	});
	        });


    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>