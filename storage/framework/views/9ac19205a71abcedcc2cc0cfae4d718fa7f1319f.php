

<?php $__env->startSection('content'); ?>
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-red">400</h2>
            <div class="error-content">
                <br/>
                <h3><i class="fa fa-warning text-red"></i>We are sorry !</h3>
                <p>You don't have access for this link.</p>
                <p><a href="<?php echo e(url()->previous()); ?>"> Return to Back </a> Or back to home <a href="<?php echo e(url('/home')); ?>"> Return to Back </a></p>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>