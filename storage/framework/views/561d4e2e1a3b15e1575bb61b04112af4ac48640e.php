<!-- language -->
  <?php if(session()->has('lang')): ?>
      <?php echo e(App::setLocale(session()->get('lang'))); ?>

  <?php else: ?>
      <?php echo e(App::setLocale('ar')); ?>

  <?php endif; ?>
  
<!-- language -->
<?php $roles = app('Bican\Roles\Models\Role'); ?>
<?php $permissions = app('Bican\Roles\Models\Permission'); ?>
<?php $printers = app('\App\Printer'); ?>
<!-- listing roles array for select element -->
<?php  
	$roles        = $roles->pluck('name','id')->toArray();
	$permissions  = $permissions->pluck('name','id')->toArray(); 
	$printers     = $printers->all(); 
 ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('layouts.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="Append roles_list col-md-4">
        <div class="form-group">
          <label for="Roles"><?php echo e(trans('form.roles')); ?></label>
          <?php echo Form::select("roles_list[]",$roles ,$EditData->RolesList,["class" => "form-control select2","id" => "role","required" =>"required",'multiple'=>'multiple',"style"=>"width:100%"]); ?>

        </div>
    </div>
    <div class="Append permissions_list col-md-4">
        <div class="form-group">
          <label for="Permissions"><?php echo e(trans('form.permissions')); ?></label>
          <?php echo Form::select("permissions_list[]",$permissions ,$EditData->PermissionsList,["class" => "form-control select2","id" => "permissions","required" =>"required",'multiple'=>'multiple',"style"=>"width:100%"]); ?>

        </div>
    </div>
    <?php if(Auth::user()->is('admin|helpdesk')): ?>
    <div class="Append col-md-12">
      <div class="panel panel-default clearfix">
        <div class="panel-heading" style="height:50px !important">
          <!-- <button type="button" class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#feature-2"> <i class="glyphicon glyphicon-resize-vertical"></i>Toggle Feature Set</button> -->
          <div class="col-xs-5 panel-title"> Printer Name</div>
          <div class="col-xs-5 text-center"> Branch Name </div>
          <!-- <div class="col-xs-4 text-center"> ID </div> -->
          <div class="col-xs-2 text-center"> check </div>
        </div>      
        <div id="feature-2" class="collapse in">
            <?php foreach($printers as $print): ?>
              <div class="panel-body">
                <div class="row">                  
                  <div class="col-xs-5"><?php echo e($print->printer_name); ?> </div>
                  <div class="col-xs-5 text-center"><?php echo e($print->printer_key); ?></div>                
                  <?php if(array_search($print->id, array_column($EditData->printers->toArray(), 'id')) !== false): ?>                    
                      <div class="col-xs-2 text-center"> <input type="checkbox" name="printers[]" value="<?php echo e($print->id); ?>" checked></div>
                  <?php else: ?> 
                      <div class="col-xs-2 text-center"> <input type="checkbox" name="printers[]" value="<?php echo e($print->id); ?>"></div>
                  <?php endif; ?>                  
                </div>
              </div> 
            <?php endforeach; ?>               
        </div>
      </div>
    </div>
    <?php endif; ?> 


	<script type="text/javascript">
		$('.NewAppend').append($('.Append'));
		document.getElementById("password").required = false;
	</script>
  <style>
button#submit {
    margin: -11px 20px 62px 0;
}
</style>
<?php $__env->stopSection(); ?>













<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>