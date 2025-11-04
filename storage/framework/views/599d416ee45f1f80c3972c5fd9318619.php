 

<?php $__env->startSection('title', 'Ternak Saya'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Ternak Saya</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Ternak</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tag Number</th>
                        <th>Kandang</th>
                        <th>Jenis Domba</th>
                        <th>Bobot Terkini (Kg)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $ternaks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $ternak): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($index + 1); ?></td>
                            <td>
                                
                                <a href="<?php echo e(route('ternak.show', $ternak->tag_number)); ?>">
                                    <?php echo e($ternak->tag_number); ?>

                                </a>
                            </td>
                            
                            <td><?php echo e($ternak->kandang->kandang_id ?? '-'); ?></td>
                            <td><?php echo e($ternak->jenisDomba->name ?? '-'); ?></td>
                            <td><?php echo e($ternak->current_weight ?? '-'); ?></td>
                            <td><?php echo e($ternak->status->name ?? '-'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center">
                                Anda belum memiliki data ternak.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sphin\Documents\GitHub\glowing-waddle\resources\views/investor/ternakku.blade.php ENDPATH**/ ?>