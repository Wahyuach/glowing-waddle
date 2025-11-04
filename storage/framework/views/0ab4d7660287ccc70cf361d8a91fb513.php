<?php $__env->startSection('title', 'Data Pakan'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Data Pakan</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <p>Kelola data pakan Anda di sini.</p>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="<?php echo e(route('pakan.create')); ?>" class="btn btn-primary"><i class="fas fa-plus mr-1"></i> Tambah Pakan</a>
                </div>
                <div class="card-body">
                    
                    
                    <form action="<?php echo e(route('pakan.index')); ?>" method="GET" class="mb-3">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="show-entries" class="d-inline-block align-middle">Menampilkan</label>
                                <select id="show-entries" name="show_entries" class="form-control form-control-sm d-inline-block" style="width: auto;">
                                    <option value="10" <?php echo e($showEntries == 10 ? 'selected' : ''); ?>>10</option>
                                    <option value="25" <?php echo e($showEntries == 25 ? 'selected' : ''); ?>>25</option>
                                    <option value="50" <?php echo e($showEntries == 50 ? 'selected' : ''); ?>>50</option>
                                </select>
                                <span class="d-inline-block align-middle">hasil</span>
                            </div>
                            <div class="col-md-4 ml-auto">
                                <div class="input-group input-group-sm">
                                    
                                    <input type="text" class="form-control" name="search" placeholder="Cari Pakan..." value="<?php echo e($search); ?>">
                                    <div class="input-group-append">
                                        
                                        <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center">
                            <thead>
                                <tr>
                                    <th style="width: 1%;">NO</th>
                                    <th>NAMA<i class="fas fa-sort-alt"></i></th>
                                    <th>TIPE_PAKAN<i class="fas fa-sort-alt"></i></th>
                                    <th>STOK<i class="fas fa-sort-alt"></i></th>
                                    <th>UNIT<i class="fas fa-sort-alt"></i></th>
                                    <th>HARGA/UNIT<i class="fas fa-sort-alt"></i></th>
                                    <th style="width: 15%;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $pakans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pakan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration + ($pakans->currentPage() - 1) * $pakans->perPage()); ?></td>
                                        <td><?php echo e($pakan->name); ?></td>
                                        <td><?php echo e($pakan->tipePakan->name ?? '-'); ?></td>
                                        <td><?php echo e($pakan->stock); ?></td>
                                        <td><?php echo e($pakan->unit); ?></td>
                                        <td><?php echo e(number_format($pakan->price_per_unit, 2, ',', '.')); ?></td>
                                        <td>
                                            <div class="btn-group btn-group-sm-1" role="group">
                                                <a href="<?php echo e(route('pakan.show', $pakan->id)); ?>" class="btn btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                                                <a href="<?php echo e(route('pakan.edit', $pakan->id)); ?>" class="btn btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                                <form action="<?php echo e(route('pakan.destroy', $pakan->id)); ?>" method="POST" style="display:inline;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-danger" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7">Tidak ada data pakan.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="d-flex justify-content-between align-items-center">
                        
                        <span class="text-muted">Menampilkan <?php echo e($pakans->firstItem()); ?> hingga <?php echo e($pakans->lastItem()); ?> dari <?php echo e($pakans->total()); ?> data</span>
                        
                        <?php echo e($pakans->links('pagination::bootstrap-4')); ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        // Auto-submit form when 'show-entries' select box changes
        document.getElementById('show-entries').addEventListener('change', function() {
            this.closest('form').submit();
        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sphin\Documents\GitHub\glowing-waddle\resources\views/admin/pakan/index.blade.php ENDPATH**/ ?>