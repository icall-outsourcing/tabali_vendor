<!-- language -->
  <?php if(session()->has('lang')): ?>
      <?php echo e(App::setLocale(session()->get('lang'))); ?>

  <?php else: ?>
      <?php echo e(App::setLocale('ar')); ?>

  <?php endif; ?>
  

<?php $__env->startSection('content'); ?>
   


<form action="<?php echo e(route('Product.store')); ?>" data-toggle="validator"  id='myForm' role="form" method="POST" enctype="multipart/form-data">
    <script type="text/javascript">	<?php echo csrf_field(); ?>

    	$( document ).ready(function() {	  <div class="form-row">
    		function ExItem($vlaue= ''){
    			if ($vlaue == 9) {
    				$('.extragroup').show();	  <?php if(session()->has('message')): ?>
	    			$('#extragroup').prop( "disabled", false );	    <div class="alert alert-success">
    			}else{	        <?php echo e(session()->get('message')); ?>

	    			$('.extragroup').hide();	    </div>
	    			$('#extragroup').prop( "disabled", true );	  <?php endif; ?>
    			}
    		}
			$(document).on('change','#section_name',function(){
				var value = $('#section_name :selected').attr( "value" );	    <div class="form-group col-md-3">
				ExItem(value);	      <label for="ar_name">الأسم العربي </label>
			});	      <input type="text" class="form-control" id="ar_name" name="ar_name" required placeholder="فضلا أدخل أسم المنتج">
			ExItem();	    </div>
    	});
    </script>		<div class="form-group col-md-3">
      <label for="en_name">الأسم الأنجليزي</label>
      <input type="text" class="form-control" id="en_name" name="en_name" required placeholder="فضلا أدخل أسم المنتج">
    </div>


  <div class="form-group col-md-3">
      <label for="price">السعر</label>
      <input type="text" class="form-control" id="price" name="price" required placeholder="أدخل السعر">
    </div>
  </div>

  <div class="form-group col-md-3">
      <label for="description">الوصف</label>
      <input type="text" class="form-control" id="description" name="description" required placeholder="فضلا أدخل وصف المنتج">
    </div>
  </div>

	<div class="form-group col-md-3">
	   <label for="branch_id"> الفرع</label>
     <select name="branch_id[]" id="branch_id" multiple data-placeholder="Select Your Agent" class="chosen-select form-control" required="required">
                                        <option value="">فضلا اختر الفرع</option>
                                        <option value="1">El Tagamo3 El Khames</option>
                                        <option value="2">Korba</option>
                                        <option value="3">Zamalek</option>



                                    </select>

   </div>

    <div class="form-group col-md-3">
	   <label for="available">التفعيل</label>
     <?php echo Form::select('available',[null=>'من فضلك أختر'] + $available,null,['class' => 'form-control select2','id' => 'available','required' =>'required']); ?>


    </div>

    <div class="form-group col-md-3">
	   <label for="extra">اضافه</label>
     <?php echo Form::select('extra',[null=>' من فضلك أختر الاضافه'] + $extraornot,null,['class' => 'form-control select2','id' => 'extra','required' =>'required']); ?>


    </div>
	<div class="form-group col-md-3">
	   <label for="item_group_name"> نوع المنتج </label>
	                <select name="item_group_name" required id="item_group_name" class="chosen-select form-control" required="required">
                                        <option>فضلاً أختر أسم القسم</option>
                                        <?php foreach($item_group_name as $value): ?>
                                            <option value="<?php echo e($value); ?>"><?php echo e($value); ?></option>
                                        <?php endforeach; ?>

                    </select>
    </div>

	<div class="form-group col-md-3">
	   <label for="section_name"> القسم </label>
	                <select name="sectionid" id="sectionid" class="form-control" required>
                                        <option>فضلاً أختر أسم القسم</option>
                                        <?php foreach($section_name as $key => $value): ?>
                                            <option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
                                        <?php endforeach; ?>

                    </select>
                    <input type="hidden"  id="section_name" name='section_name'>
                    <input type="hidden"  id="sectiongroup" name='sectiongroup'>
    </div>


  </div>
  <div class="form-group col-md-12">
  <button type="submit" class="btn btn-success">إضافه</button>
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