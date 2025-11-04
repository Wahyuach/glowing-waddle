



<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-4 max-w-lg">
    <h1 class="text-2xl font-bold mb-4">Profil Pengguna</h1>

    <div class="bg-white rounded shadow p-6">
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Nama:</label>
            <p><?php echo e($user->name); ?></p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Email:</label>
            <p><?php echo e($user->email); ?></p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Subscription:</label>
            <?php if($user->subscription && $user->subscription->is_active): ?>
                <p class="text-green-600 font-semibold">Aktif sampai <?php echo e($user->subscription->expired_at->format('d M Y')); ?></p>
            <?php else: ?>
                <p class="text-red-600 font-semibold">Tidak aktif</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sphin\Documents\GitHub\glowing-waddle\resources\views/profile/index.blade.php ENDPATH**/ ?>