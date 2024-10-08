<!-- language -->
  <?php if(session()->has('lang')): ?>
      <?php echo e(App::setLocale(session()->get('lang'))); ?>

  <?php else: ?>
      <?php echo e(App::setLocale('ar')); ?>

  <?php endif; ?>

<?php $__env->startSection('content'); ?>

<?php  
	$branch_id  = \App\Branch::whereIn('id',array_values(Auth::user()->PermissionsList))->lists('name','id')->toArray();
	foreach ($branch_id as $key => $value) { $branchesDriver[$key] = $key;}
	$driver_id  = \App\Driver::whereIn('branch_id',$branchesDriver)->orderBy('name')->lists('name','id')->toArray(); 
	if(Auth::user()->is('supervisor|branch')){
		$report_type = array(
			'2'=>'Deilvered Orders By Driver',
			'5'=>'Complaint',
			'6'=>'Total Menu sales',
			'7'=>'Driver Report',
			'10'=>'Inquiry',
		);
	}else{
		$report_type = array(
			'ICALL REPORT',
			'Orders',
			'Deilvered Orders By Driver',
			'Deilvered Orders Rest',
			'Sales Orders RestStatus',
			'Complaint',
			'Total Menu sales',
			'Driver Report',
			'Count for menu item',
			'otlob and menus',
			'Inquiry'
			);
	}
	
	

 ?>

<?php echo Form::model('Report',['data-toggle'=>'validator','id'=>'myForm','role'=>'form','method'=>'POST','enctype' =>'multipart/form-data','route'=>"Report.store"]); ?>

	<?php echo csrf_field(); ?>

	<div class="row">
		<div class="col-md-8 col-md-push-2">
			<div class="box box-success">
	        	<div class="box-header with-border">
	          		<h3 class="box-title"><?php echo e(trans('form.report')); ?></h3>
	      			<div class="box-tools pull-right">
	        			<!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	        			<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button> -->
		          	</div>
			    </div>
		        <!-- /.box-header -->
		        <div class="box-body">
		        	<div class="row">
		            	<div class="col-md-6">
					        <div class="form-group">
					            <div class='input-group date' id='startdate'>
					                <input type='text' class="form-control" name="startdate" required="required"/>
					                <span class="input-group-addon">
					                    <span class="glyphicon glyphicon-calendar"></span>
					                </span>
					            </div>
					        </div>
					    </div>
					    <div class="col-md-6">
					        <div class="form-group">
					            <div class='input-group date' id='enddate'>
					                <input type='text' class="form-control" name="enddate" required="required"/>
					                <span class="input-group-addon">
					                    <span class="glyphicon glyphicon-calendar"></span>
					                </span>
					            </div>
					        </div>
					    </div>
		            	<!-- /.col -->
	          		</div>
	          		<!-- /.row -->


	          		<div class="row">
		            	<div class="col-md-6">
					        <div class="form-group">
				                <?php echo Form::select('branch_id[]',$branch_id ,null,['class' => 'form-control','id' => 'branch_id','multiple'=>'multiple','required'=>'required']); ?>

					        </div>
					    </div>
					    <div class="col-md-6">
					        <div class="form-group">
							<?php echo Form::select('report_type',[null =>'Please Select'] + $report_type ,null,['class' => 'form-control','id' => 'report_type']); ?>

							<div id="driverReport" style="display:none">							
								<br/><?php echo Form::select('driver_id',[null =>'Please Select'] + $driver_id ,null,['class' => 'form-control','id' => 'driver_id']); ?>

					        </div>
							
							</div>
					    </div>
		            	<!-- /.col -->
	          		</div>

	          		
	        	</div>
	        	<!-- /.box-body -->
	        	<div class="box-footer">
	        		<button type="submit" class="btn btn-success">Generate Report</button>
	        	</div>
			</div>
		</div>
	</div>
<?php echo Form::close(); ?>

<?php  $date = date("H") ;  ?>
<?php if( $date < 6): ?>
  	<script type="text/javascript">
	    $(function () {
	        $('#startdate').datetimepicker({
	        	format: 'YYYY-MM-DD HH:mm:ss',
	        	defaultDate: ' <?php echo e(date("Y-m-d", time() - 86400)); ?> 07:00:00'
	        });
	        $('#enddate').datetimepicker({
	            format: 'YYYY-MM-DD HH:mm:ss',
	            defaultDate: '<?php echo e(date("Y-m-d")); ?> 03:00:00',
	            useCurrent: false //Important! See issue #1075
	        });
	        $("#startdate").on("dp.change", function (e) {
	            $('#enddate').data("DateTimePicker").minDate(e.date);
	        });
	        $("#enddate").on("dp.change", function (e) {
	            $('#startdate').data("DateTimePicker").maxDate(e.date);
	        });
	    });
  	</script>
<?php else: ?>
  	<script type="text/javascript">
	    $(function () {
	        $('#startdate').datetimepicker({
	        	format: 'YYYY-MM-DD HH:mm:ss',
	        	defaultDate: ' <?php echo e(date("Y-m-d")); ?> 07:00:00'
	        });
	        $('#enddate').datetimepicker({
	            format: 'YYYY-MM-DD HH:mm:ss',
	            defaultDate: ' <?php echo e(date("Y-m-d", time() + 86400)); ?> 03:00:00',
	            useCurrent: false //Important! See issue #1075
	        });
	        $("#startdate").on("dp.change", function (e) {
	            $('#enddate').data("DateTimePicker").minDate(e.date);
	        });
	        $("#enddate").on("dp.change", function (e) {
	            $('#startdate').data("DateTimePicker").maxDate(e.date);
	        });
	    });
  	</script>
<?php endif; ?>
<script type="text/javascript">

$(document).on('change','#report_type',function(){ 
	var reportnumber = $(this).val();
	if(reportnumber == "7" ){
		$('#driverReport').show();
	}else{

		$('#driverReport').hide();
	}
})
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>