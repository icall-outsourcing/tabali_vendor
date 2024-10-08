<!-- language -->
  <?php if(session()->has('lang')): ?>
      <?php echo e(App::setLocale(session()->get('lang'))); ?>

  <?php else: ?>
      <?php echo e(App::setLocale('ar')); ?>

  <?php endif; ?>
 



<?php $__env->startSection('content'); ?>
   



<form action="<?php echo e(url('/Product/'.$Product->id.'/updateall')); ?>" data-toggle="validator"  id='myForm' role="form" method="POST" enctype="multipart/form-data">
<?php echo e(method_field('PUT')); ?>

    <?php echo csrf_field(); ?>

  <div class="form-row">


  <?php if(session()->has('message')): ?>
    <div class="alert alert-success">
        <?php echo e(session()->get('message')); ?>

    </div>
  <?php endif; ?>



    <div class="form-group col-md-3">
      <label for="ar_name">الأسم العربي </label>
      <input type="text" class="form-control" id="ar_name" value="<?php echo e($Product->ar_name); ?>" name="ar_name" required placeholder="فضلا أدخل أسم المنتج">
    </div>

	<div class="form-group col-md-3">
      <label for="en_name">الأسم الأنجليزي</label>
      <input type="text" class="form-control" id="en_name" value="<?php echo e($Product->en_name); ?>" name="en_name" required placeholder="فضلا أدخل أسم المنتج">
    </div>


  <div class="form-group col-md-3">
      <label for="price">السعر</label>
      <input type="text" class="form-control" id="price" value="<?php echo e($Product->price); ?>" name="price" required placeholder="أدخل السعر">
    </div>
  </div>

  <div class="form-group col-md-3">
      <label for="description">الوصف</label>
      <input type="text" class="form-control" id="description" value="<?php echo e($Product->description); ?>" name="description" required placeholder="فضلا أدخل وصف المنتج">
    </div>
  </div>

    <div class="form-group col-md-3">
	   <label for="available">التفعيل</label>
     <?php echo Form::select('available',[null=>'من فضلك أختر'] + $available,null,['class' => 'form-control select2','value'=>'$Product->available','id' => 'available','required' =>'required']); ?>


    </div>


	<div class="form-group col-md-3">
	   <label for="item_group_name"> نوع المنتج </label>
	                <select name="item_group_name" value="<?php echo e($Product->item_group_name); ?>" required id="item_group_name" class="chosen-select form-control" required="required">
                                        <option selected><?php echo e($Product->item_group_name); ?></option>
                                        <?php foreach($item_group_name as $value): ?>
                                            <option value="<?php echo e($value); ?>"><?php echo e($value); ?></option>
                                        <?php endforeach; ?>

                    </select>
    </div>



  </div>
  <div class="form-group col-md-12">
  <button type="submit" class="btn btn-success">تحديث</button>
  </div>
</form>



<script>
$('#sectionid').on('change',function(e){
  var selectedText = $("#sectionid option:selected").text();
  $('#section_name').val(selectedText);
  $('#sectiongroup').val(selectedText);
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>