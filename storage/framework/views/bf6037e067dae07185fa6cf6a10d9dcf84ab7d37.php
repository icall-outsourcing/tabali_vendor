<style>
button#submit {
    margin: -11px 20px 62px 0;
}
</style>
<!-- language -->
  <?php if(session()->has('lang')): ?>
      <?php echo e(App::setLocale(session()->get('lang'))); ?>

  <?php else: ?>
      <?php echo e(App::setLocale('ar')); ?>

  <?php endif; ?>
  <!-- <?php  $branch_id  = \App\Branch::all()->lists('name','id')->toArray();  ?> -->

<?php $sections = app('\App\Product'); ?>
<?php     
	$sections     = $sections->whereNotNull('sectionid')->withTrashed()->orderBy('sectionid')->groupBy('sectionid')->get(); 
 ?>


<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('layouts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="Append col-md-12">
      <div class="panel panel-default clearfix">        



        <table class="table table-hover table-striped table-bordered">                    
          <thead>
            <tr>            
              <th scope="col">Section Name</th>
              <th scope="col">check</th>            
            </tr>
          </thead>
          <tbody>    
            <?php foreach($sections as $section): ?>
            <tr>
              <th scope="row"><?php echo e($section->sectiongroup); ?></th>              
              <?php if(array_search($section->sectionid, array_column($EditData->Dbsections(), 'sectionid')) !== false): ?>
              <td><input type="checkbox" name="sections[]" value="<?php echo e($section->sectionid); ?>" checked></td>
              <?php else: ?> 
              <td><input type="checkbox" name="sections[]" value="<?php echo e($section->sectionid); ?>"></td>
              <?php endif; ?>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>



      </div>
    </div>
	<script type="text/javascript">$('.NewAppend').append($('.Append'));</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>