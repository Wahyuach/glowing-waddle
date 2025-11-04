

<?php $__env->startSection('title', 'Profile'); ?>

<?php $__env->startSection('content_header'); ?>
<h1>Profile</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Displaying success message if exists -->
<?php if(session('success')): ?>
<div class="alert alert-success">
    <?php echo e(session('success')); ?>

</div>
<?php endif; ?>

<!-- Profile Information Card -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Profile Information</h3>
    </div>
    <div class="card-body">
        <!-- Profile form to update name and email -->
        <form action="<?php echo e(route('profil.update')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="<?php echo e(old('name', $user->name)); ?>" required>
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo e(old('email', $user->email)); ?>" required>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
</div>

<!-- Subscription Status (Only for Admins) -->
<?php if($user->isAdmin()): ?>
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">Subscription Status</h3>
    </div>
    <div class="card-body">
        <p><strong>Status:</strong> <?php echo e(ucfirst($subscriptionStatus)); ?></p>

        <!-- Show Subscribe/Payment button based on status -->
        <?php if($subscriptionStatus === 'inactive'): ?>
        <form action="<?php echo e(route('profil.subscribe')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-success">Subscribe Now</button>
        </form>
        <?php else: ?>
        <!-- No button if the status is active -->
        <p>You are already subscribed. Thank you!</p>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<!-- Password Reset Card -->
<div class="card mt-4">
    <div class="card-header">
        <h3 class="card-title">Reset Password</h3>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('profile.reset-password')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" name="current_password" id="current_password" class="form-control" required>
                <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-danger">Reset Password</button>
        </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<?php if(isset($snap_token)): ?>
<script src="https://app.midtrans.com/snap/snap.js" data-client-key="<?php echo e(env('MIDTRANS_CLIENT_KEY')); ?>"></script>

<script type="text/javascript">
    // CSRF token for AJAX
    const csrfToken = '<?php echo e(csrf_token()); ?>';

    // Get snap token and order id from session (passed by controller)
    const snapToken = "<?php echo e(session('snap_token') ?? ''); ?>";
    const orderId = "<?php echo e(session('payment_data.order_id') ?? ''); ?>";

    if (snapToken) {
        // Open Midtrans Snap UI
        snap.pay(snapToken, {
            onSuccess: function(result) {
                // Notify server to mark subscription active
                fetch("<?php echo e(route('profil.payment.complete')); ?>", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            order_id: orderId,
                            transaction_id: result.transaction_id ?? result.transactionId ?? null,
                            result: result
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Redirect back to profile with a status
                        window.location.href = "<?php echo e(route('profil.index')); ?>?status=success";
                    })
                    .catch(err => {
                        console.error('Error notifying server:', err);
                        window.location.href = "<?php echo e(route('profil.index')); ?>?status=error";
                    });
            },
            onPending: function(result) {
                window.location.href = "<?php echo e(route('profil.index')); ?>?status=pending";
            },
            onError: function(result) {
                window.location.href = "<?php echo e(route('profil.index')); ?>?status=error";
            },
            onClose: function() {
                window.location.href = "<?php echo e(route('profil.index')); ?>?status=closed";
            }
        });
    }
</script>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sphin\Documents\GitHub\glowing-waddle\resources\views/profile/index.blade.php ENDPATH**/ ?>