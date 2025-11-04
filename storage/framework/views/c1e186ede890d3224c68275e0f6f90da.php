<?php $__env->startSection('title', 'Data Kavling'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Data Kavling</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <p>Kelola data kavling Anda di sini.</p>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <a href="<?php echo e(route('kavling.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i>Kavling
                        </a>
                        <!-- <button type="button" class="btn btn-info ml-2" data-toggle="modal" data-target="#importCsvModal">
                            <i class="fas fa-file-import mr-1"></i>Import
                        </button>
                        
                        <a href="<?php echo e(asset('templates/template_kavlings.xlsx')); ?>" class="btn btn-success ml-2" download>
                            <i class="fas fa-download mr-1"></i>Template
                        </a> -->
                    </div>
                </div>
                <div class="card-body">
                    
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('warning')): ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <?php echo e(session('warning')); ?>

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <?php if($errors->has('csv_file') || $errors->has('import_errors')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h5><i class="icon fas fa-ban"></i> Impor Gagal!</h5>
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    
                    <form action="<?php echo e(route('kavling.index')); ?>" method="GET" class="mb-3">
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
                                    <input type="text" class="form-control" name="search" placeholder="Cari Kavling..." value="<?php echo e($search); ?>">
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
                                    <th>NO_KAVLING</th>
                                    <th>KAPASITAS</th>
                                    <th>POPULASI</th>
                                    <th>STATUS_KEPEMILIKAN</th>
                                    <th>INVESTOR</th>
                                    <th>ABK</th>
                                    <th style="width: 20%;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $kavlings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kavling): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration + ($kavlings->currentPage() - 1) * $kavlings->perPage()); ?></td>
                                        <td><?php echo e($kavling->no_kavling); ?></td>
                                        <td><?php echo e($kavling->kapasitas); ?></td>
                                        <td><?php echo e($kavling->jumlah_populasi_kandang); ?></td>
                                        <td><?php echo e($kavling->status_kepemilikan); ?></td>
                                        <td><?php echo e($kavling->investor->name ?? '-'); ?></td>
                                        <td><?php echo e($kavling->abk->name ?? '-'); ?></td>
                                        <td>
                                            <div class="btn-group btn-group-sm-1" role="group">
                                                <a href="<?php echo e(route('kavling.kandang.index', $kavling->no_kavling)); ?>" class="btn btn-primary" title="Lihat Kandang"><i class="fas fa-warehouse"></i></a>
                                                <a href="<?php echo e(route('kavling.show', $kavling->no_kavling)); ?>" class="btn btn-info" title="Lihat Detail Kavling"><i class="fas fa-eye"></i></a>
                                                <a href="<?php echo e(route('kavling.edit', $kavling->no_kavling)); ?>" class="btn btn-warning" title="Edit Kavling"><i class="fas fa-edit"></i></a>
                                                <form action="<?php echo e(route('kavling.destroy', $kavling->no_kavling)); ?>" method="POST" style="display:inline;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-danger" title="Hapus Kavling" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="8">Tidak ada data kavling.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Menampilkan <?php echo e($kavlings->firstItem()); ?> hingga <?php echo e($kavlings->lastItem()); ?> dari <?php echo e($kavlings->total()); ?> data</span>
                        <?php echo e($kavlings->links('pagination::bootstrap-4')); ?>

                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <div class="modal fade" id="importCsvModal" tabindex="-1" role="dialog" aria-labelledby="importCsvModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="<?php echo e(route('kavling.import')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-header">
                        <h5 class="modal-title" id="importCsvModalLabel">Impor Data Kavling dari CSV</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="csv_file">Pilih File CSV</label>
                            <input type="file" class="form-control-file <?php $__errorArgs = ['csv_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="csv_file" name="csv_file" required>
                            <small id="csvFileHelp" class="form-text text-muted">
                                Format kolom yang diharapkan: `no_kavling, kapasitas, status_kepemilikan, investor_id, abk_id`
                                <br><br>
                                <div style="max-height: 200px; overflow-y: auto; border: 1px solid #eee; padding: 10px; background-color: #f9f9f9;">
                                    
                                    <strong>investor_id:</strong><br>
                                    <?php $__empty_1 = true; $__currentLoopData = $investors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $investor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php echo e($investor->id); ?>: <?php echo e($investor->name); ?><br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        Tidak ada data investor.<br>
                                    <?php endif; ?>
                                    <br>
                                    
                                    <strong>abk_id:</strong><br>
                                    <?php $__empty_1 = true; $__currentLoopData = $abks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $abk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php echo e($abk->id); ?>: <?php echo e($abk->name); ?><br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        Tidak ada data ABK.<br>
                                    <?php endif; ?>
                                </div>
                            </small>
                            <?php $__errorArgs = ['csv_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Impor Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        console.log("Halaman Data Kavling!");

        document.getElementById('show-entries').addEventListener('change', function() {
            this.closest('form').submit();
        });

        // Menampilkan modal jika ada error validasi impor CSV
        <?php if($errors->has('csv_file') || $errors->has('import_errors')): ?>
            $(document).ready(function() {
                $('#importCsvModal').modal('show');
            });
        <?php endif; ?>
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sphin\Documents\GitHub\glowing-waddle\resources\views/admin/kavling/index.blade.php ENDPATH**/ ?>