<?php $__env->startSection('title', 'Detail Data Ternak'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Detail Data Ternak</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section class="content">
        <div class="container-fluid">
            
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo e(session('error')); ?>

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
            

            
            
            <?php if($errors->has('weight') && !session('show_edit_weight_modal')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h5><i class="icon fas fa-ban"></i> Validasi Gagal!</h5>
                    <ul>
                        <?php $__currentLoopData = $errors->get('weight'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php $__currentLoopData = $errors->get('measurement_date'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Detail Ternak: <?php echo e($ternak->tag_number); ?></h3>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">TAGGING</label>
                        <div class="col-sm-9">
                            <p class="form-control-static"><?php echo e($ternak->tag_number); ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Spesies</label>
                        <div class="col-sm-9">
                            <p class="form-control-static"><?php echo e($ternak->species->name ?? '-'); ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Kategori</label>
                        <div class="col-sm-9">
                            <p class="form-control-static"><?php echo e($ternak->kategori->name ?? '-'); ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Sub Kategori</label>
                        <div class="col-sm-9">
                            <p class="form-control-static"><?php echo e($ternak->subKategori->name ?? '-'); ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tipe Domba</label>
                        <div class="col-sm-9">
                            <p class="form-control-static"><?php echo e($ternak->tipeDomba->name ?? '-'); ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jenis Domba</label>
                        <div class="col-sm-9">
                            <p class="form-control-static"><?php echo e($ternak->jenisDomba->name ?? '-'); ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-9">
                            <p class="form-control-static"><?php echo e($ternak->gender); ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Kandang</label>
                        <div class="col-sm-9">
                            <p class="form-control-static"><?php echo e($ternak->kandang->kandang_id ?? '-'); ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Usia Masuk(Bulan)</label>
                        <div class="col-sm-9">
                            <p class="form-control-static"><?php echo e($ternak->usia_masuk_dalam_bulan ?? '-'); ?> bulan</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Usia (Hari)</label>
                        <div class="col-sm-9">
                            <p class="form-control-static"><?php echo e($ternak->umur_hari ?? '-'); ?> hari</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Hari di Farm</label>
                        <div class="col-sm-9">
                            <p class="form-control-static"><?php echo e($ternak->hari_di_peternakan ?? '-'); ?> hari</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Kondisi</label>
                        <div class="col-sm-9">
                            <p class="form-control-static"><?php echo e($ternak->kondisi->name ?? '-'); ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Berat Masuk (kg)</label>
                        <div class="col-sm-9">
                            <p class="form-control-static"><?php echo e($ternak->entry_weight ?? '-'); ?> kg</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Berat Saat Ini (kg)</label>
                        <div class="col-sm-9">
                            <p class="form-control-static"><?php echo e($ternak->current_weight ?? '-'); ?> kg</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Terakhir Diukur</label>
                        <div class="col-sm-9">
                            <p class="form-control-static"><?php echo e($ternak->last_weight_date ? \Carbon\Carbon::parse($ternak->last_weight_date)->format('d-m-Y') : '-'); ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Upweight</label> 
                        <div class="col-sm-9">
                            <p class="form-control-static"><?php echo e($ternak->upweight ?? '-'); ?> kg</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-9">
                            <p class="form-control-static"><?php echo e($ternak->date_of_birth ?? '-'); ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tanggal Masuk</label>
                        <div class="col-sm-9">
                            <p class="form-control-static"><?php echo e($ternak->date_of_entry ?? '-'); ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <p class="form-control-static"><?php echo e($ternak->status->name ?? '-'); ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Induk Betina</label>
                        <div class="col-sm-9">
                            <p class="form-control-static"><?php echo e($ternak->dam->tag_number ?? '-'); ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Induk Jantan</label>
                        <div class="col-sm-9">
                            <p class="form-control-static"><?php echo e($ternak->sire->tag_number ?? '-'); ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Catatan</label>
                        <div class="col-sm-9">
                            <p class="form-control-static"><?php echo e($ternak->notes ?? '-'); ?></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Foto</label>
                        <div class="col-sm-9">
                            <?php if($ternak->photo_path): ?>
                                <img src="<?php echo e(asset($ternak->photo_path)); ?>" alt="Foto Ternak" class="img-thumbnail" style="max-width: 200px;">
                            <?php else: ?>
                                <p class="form-control-static">-</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <hr>
                    <h4>Tambah Riwayat Bobot Baru</h4>
                    <form action="<?php echo e(route('ternak.weights.store', $ternak->tag_number)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="form-group row">
                            <label for="new_weight" class="col-sm-3 col-form-label">Berat (kg)</label>
                            <div class="col-sm-9">
                                <input type="number" step="0.01" class="form-control <?php $__errorArgs = ['weight'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="new_weight" name="weight" value="<?php echo e(old('weight')); ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_measurement_date" class="col-sm-3 col-form-label">Tanggal Pengukuran</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control <?php $__errorArgs = ['measurement_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="new_measurement_date" name="measurement_date" value="<?php echo e(old('measurement_date', \Carbon\Carbon::now()->format('Y-m-d'))); ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn btn-primary">Tambah Riwayat</button>
                            </div>
                        </div>
                    </form>


                    <hr>
                    <h4>Riwayat Bobot</h4>
                    <?php if($weightHistories->isNotEmpty()): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm text-center">
                                <thead>
                                    <tr>
                                        <th>Tanggal Pengukuran</th>
                                        <th>Bobot (kg)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $weightHistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e(\Carbon\Carbon::parse($history->measurement_date)->format('d-m-Y')); ?></td>
                                            <td><?php echo e($history->weight); ?> kg</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-warning btn-edit-weight"
                                                            data-toggle="modal" data-target="#editWeightModal"
                                                            data-id="<?php echo e($history->id); ?>"
                                                            data-weight="<?php echo e($history->weight); ?>"
                                                            data-date="<?php echo e($history->measurement_date); ?>">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                    <form action="<?php echo e(route('weights.destroy', $history->id)); ?>" method="POST" style="display:inline;">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus riwayat bobot ini?')">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p>Tidak ada riwayat bobot untuk ternak ini.</p>
                    <?php endif; ?>
                </div>
                <div class="card-footer">
                    <a href="<?php echo e(route('ternak.edit', $ternak->tag_number)); ?>" class="btn btn-warning">Edit Data Utama Ternak</a>
                    <a href="<?php echo e(route('ternak.index')); ?>" class="btn btn-secondary">Kembali ke Daftar Ternak</a>
                </div>
            </div>
            </div>
    </section>

    
    <div class="modal fade" id="editWeightModal" tabindex="-1" role="dialog" aria-labelledby="editWeightModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editWeightForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="modal-header">
                        <h5 class="modal-title" id="editWeightModalLabel">Edit Riwayat Bobot</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_history_id">
                        <div class="form-group">
                            <label for="edit_weight">Berat (kg)</label>
                            <input type="number" step="0.01" class="form-control" id="edit_weight" name="weight" required>
                            
                            <?php $__errorArgs = ['weight', 'edit_weight_modal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback d-block" role="alert"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="form-group">
                            <label for="edit_measurement_date">Tanggal Pengukuran</label>
                            <input type="date" class="form-control" id="edit_measurement_date" name="measurement_date" required>
                            
                            <?php $__errorArgs = ['measurement_date', 'edit_weight_modal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback d-block" role="alert"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(document).ready(function() {
            // Logika untuk mengisi data ke modal edit
            $('#editWeightModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Tombol yang memicu modal
                var historyId = button.data('id');
                var weight = button.data('weight');
                var date = button.data('date');

                var modal = $(this);
                modal.find('#edit_history_id').val(historyId);
                modal.find('#edit_weight').val(weight);
                modal.find('#edit_measurement_date').val(date);

                // Atur action form modal sesuai dengan ID riwayat bobot, dengan prefix admin
                modal.find('#editWeightForm').attr('action', '/admin/weights/' + historyId);

                // Hapus kelas is-invalid dan pesan feedback dari percobaan sebelumnya
                modal.find('.is-invalid').removeClass('is-invalid');
                modal.find('.invalid-feedback').remove();
            });

            // Logika untuk menampilkan modal edit secara otomatis jika ada error validasi
            // Ini bekerja dengan mengirimkan pesan error dengan custom bag dari controller
            <?php if(session('show_edit_weight_modal') && $errors->edit_weight_modal->any()): ?>
                $(function() { // Menggunakan $(function() { ... }) untuk memastikan DOM siap
                    var modal = $('#editWeightModal');
                    modal.modal('show');

                    // Isi ulang data ke modal dari old input jika validasi gagal
                    modal.find('#edit_history_id').val("<?php echo e(old('id')); ?>");
                    modal.find('#edit_weight').val("<?php echo e(old('weight')); ?>");
                    modal.find('#edit_measurement_date').val("<?php echo e(old('measurement_date')); ?>");

                    // Tampilkan pesan error validasi langsung di dalam modal
                    <?php $__errorArgs = ['weight', 'edit_weight_modal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        modal.find('#edit_weight').addClass('is-invalid').after('<span class="invalid-feedback d-block" role="alert"><?php echo e($message); ?></span>');
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <?php $__errorArgs = ['measurement_date', 'edit_weight_modal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        modal.find('#edit_measurement_date').addClass('is-invalid').after('<span class="invalid-feedback d-block" role="alert"><?php echo e($message); ?></span>');
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    // Atur action form modal berdasarkan old('id') jika tersedia
                    var oldHistoryId = "<?php echo e(old('id')); ?>";
                    if (oldHistoryId) {
                        modal.find('#editWeightForm').attr('action', '/admin/weights/' + oldHistoryId);
                    }
                });
            <?php endif; ?>
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sphin\Documents\GitHub\glowing-waddle\resources\views/admin/ternak/model/show.blade.php ENDPATH**/ ?>