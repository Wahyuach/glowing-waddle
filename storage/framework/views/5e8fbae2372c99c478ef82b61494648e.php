<?php $__env->startSection('title', 'Data Ternak'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Data Ternak</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <p>Kelola data ternak Anda di sini.</p>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <a href="<?php echo e(route('ternak.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i>Ternak
                        </a>
                        <button type="button" class="btn btn-info ml-2" data-toggle="modal" data-target="#importCsvModal">
                            <i class="fas fa-file-import mr-1"></i>Import
                        </button>
                        <a href="<?php echo e(asset('templates/template_ternaks.csv')); ?>" class="btn btn-success ml-2" download>
                            <i class="fas fa-download mr-1"></i>Template
                        </a>
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

                    
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo e(session('error')); ?>

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    
                    <?php if($errors->has('csv_file') || $errors->has('import_errors')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h5><i class="icon fas fa-ban"></i> Impor Gagal!</h5>
                            <ul>
                                <?php $__currentLoopData = $errors->get('csv_file'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = $errors->get('import_errors'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    
                    <form id="filterForm" action="<?php echo e(route('ternak.index')); ?>" method="GET" class="mb-3">
                        <div class="row">
                            <div class="col-md-2">
                                <label>Menampilkan</label>
                                <select name="show_entries" class="form-control form-control-sm">
                                    <option value="10" <?php echo e($showEntries == 10 ? 'selected' : ''); ?>>10</option>
                                    <option value="25" <?php echo e($showEntries == 25 ? 'selected' : ''); ?>>25</option>
                                    <option value="50" <?php echo e($showEntries == 50 ? 'selected' : ''); ?>>50</option>
                                    <option value="all" <?php echo e($showEntries == 'all' ? 'selected' : ''); ?>>Semua</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Spesies</label>
                                <select name="filter_species" class="form-control form-control-sm">
                                    <option value="">-- Semua Spesies --</option>
                                    <?php $__currentLoopData = $speciesFilterList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $species): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($species->id); ?>" <?php echo e($filterSpecies == $species->id ? 'selected' : ''); ?>><?php echo e($species->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Kategori</label>
                                <select name="filter_kategori" class="form-control form-control-sm">
                                    <option value="">-- Semua Kategori --</option>
                                    <?php $__currentLoopData = $kategoriFilterList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kategori): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($kategori->id); ?>" <?php echo e($filterKategori == $kategori->id ? 'selected' : ''); ?>><?php echo e($kategori->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Jenis Kelamin</label>
                                <select name="filter_gender" class="form-control form-control-sm">
                                    <option value="">-- Semua --</option>
                                    <option value="Jantan" <?php echo e($filterGender == 'Jantan' ? 'selected' : ''); ?>>Jantan</option>
                                    <option value="Betina" <?php echo e($filterGender == 'Betina' ? 'selected' : ''); ?>>Betina</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Kandang</label>
                                <select name="filter_kandang" class="form-control form-control-sm">
                                    <option value="">-- Semua Kandang --</option>
                                    <?php $__currentLoopData = $kandangFilterList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kandang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($kandang->kandang_id); ?>" <?php echo e($filterKandang == $kandang->kandang_id ? 'selected' : ''); ?>><?php echo e($kandang->kandang_id); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <label>Tipe Domba</label>
                                <select name="filter_tipe_domba" class="form-control form-control-sm">
                                    <option value="">-- Semua Tipe --</option>
                                    <?php $__currentLoopData = $tipeDombaFilterList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipeDomba): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($tipeDomba->id); ?>" <?php echo e($filterTipeDomba == $tipeDomba->id ? 'selected' : ''); ?>><?php echo e($tipeDomba->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Jenis Domba</label>
                                <select name="filter_jenis_domba" class="form-control form-control-sm">
                                    <option value="">-- Semua Jenis --</option>
                                    <?php $__currentLoopData = $jenisDombaFilterList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenisDomba): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($jenisDomba->id); ?>" <?php echo e($filterJenisDomba == $jenisDomba->id ? 'selected' : ''); ?>><?php echo e($jenisDomba->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Kondisi</label>
                                <select name="filter_kondisi" class="form-control form-control-sm">
                                    <option value="">-- Semua Kondisi --</option>
                                    <?php $__currentLoopData = $kondisiFilterList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kondisi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($kondisi->id); ?>" <?php echo e($filterKondisi == $kondisi->id ? 'selected' : ''); ?>><?php echo e($kondisi->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Status</label>
                                <select name="filter_status" class="form-control form-control-sm">
                                    <option value="">-- Semua Status --</option>
                                    <?php $__currentLoopData = $statusFilterList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($status->id); ?>" <?php echo e($filterStatus == $status->id ? 'selected' : ''); ?>><?php echo e($status->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label for="filter_last_measured_date_start">Terakhir Diukur (Mulai)</label>
                                <input type="date" name="filter_last_measured_date_start" id="filter_last_measured_date_start" class="form-control form-control-sm" value="<?php echo e($filterLastMeasuredDateStart ?? ''); ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="filter_last_measured_date_end">Terakhir Diukur (Akhir)</label>
                                <input type="date" name="filter_last_measured_date_end" id="filter_last_measured_date_end" class="form-control form-control-sm" value="<?php echo e($filterLastMeasuredDateEnd ?? ''); ?>">
                            </div>
                            <div class="col-md-4 ml-auto">
                                <label>Cari</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" name="search" class="form-control" placeholder="Cari Ternak..." value="<?php echo e($search); ?>">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-filter mr-1"></i>Terapkan Filter</button>
                                <a href="<?php echo e(route('ternak.index')); ?>" class="btn btn-secondary" id="resetFilterButton"><i class="fas fa-sync-alt mr-1"></i>Reset Filter</a>
                            </div>
                        </div>
                    </form>

                    
                    <form action="<?php echo e(route('ternak.bulkDelete')); ?>" method="POST" id="bulkDeleteForm">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>

                        <div class="mb-2">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data terpilih?')">
                                <i class="fas fa-trash-alt"></i> Hapus Data Terpilih
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-center">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select-all"></th>
                                        <!-- <th>NO</th> -->
                                        <th>TAGGING</th>
                                        <th>FOTO</th>
                                        <th>KATEGORI</th>
                                        <th>JENIS_KELAMIN</th>
                                        <th>KANDANG</th>
                                        <th>UMUR</th>
                                        <th>STATUS</th>
                                        <th>BERAT TERKINI</th>
                                        <th>TERAKHIR DIUKUR</th>
                                        <th>UPWEIGHT</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $ternaks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ternak): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><input type="checkbox" name="tag_numbers[]" value="<?php echo e($ternak->tag_number); ?>"></td>
                                            <!-- <td>
                                                <?php if($ternaks instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>
                                                    <?php echo e($loop->iteration + ($ternaks->firstItem() - 1)); ?>

                                                <?php else: ?>
                                                    <?php echo e($loop->iteration); ?>

                                                <?php endif; ?>
                                            </td> -->
                                            <td><?php echo e($ternak->tag_number); ?></td>
                                            <td>
                                                <?php if($ternak->photo_path): ?>
                                                    <img src="<?php echo e(asset($ternak->photo_path)); ?>" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                                <?php else: ?>
                                                    <i class="fas fa-image text-muted" style="font-size: 2.5em;"></i>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($ternak->kategori->name ?? '-'); ?></td>
                                            <td><?php echo e($ternak->gender); ?></td>
                                            <td><?php echo e($ternak->kandang->kandang_id ?? '-'); ?></td>
                                            <td><?php echo e($ternak->umur_hari ?? '-'); ?> hari</td>
                                            <td><?php echo e($ternak->status->name ?? '-'); ?></td>
                                            <td><?php echo e($ternak->current_weight ?? '-'); ?> kg</td>
                                            <td><?php echo e($ternak->last_weight_date ? \Carbon\Carbon::parse($ternak->last_weight_date)->format('d-m-Y') : '-'); ?></td>
                                            <td><?php echo e($ternak->upweight ?? '-'); ?> kg</td>
                                            <td>
                                                <div class="btn-group btn-group-sm-1">
                                                    <a href="<?php echo e(route('ternak.show', $ternak->tag_number)); ?>" class="btn btn-info" title="Lihat Detail"><i class="fas fa-eye"></i></a>
                                                    <a href="<?php echo e(route('ternak.edit', $ternak->tag_number)); ?>" class="btn btn-warning" title="Edit Data"><i class="fas fa-edit"></i></a>
                                                    
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="16">Tidak ada data ternak.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <?php if($ternaks instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>
                                <span class="text-muted">Menampilkan <?php echo e($ternaks->firstItem()); ?> - <?php echo e($ternaks->lastItem()); ?> dari <?php echo e($ternaks->total()); ?> data</span>
                                <?php echo e($ternaks->appends(request()->except('page'))->links('pagination::bootstrap-4')); ?>

                            <?php else: ?>
                                <span class="text-muted">Menampilkan semua <?php echo e($ternaks->count()); ?> data</span>
                            <?php endif; ?>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>

    
    <div class="modal fade" id="importCsvModal" tabindex="-1" role="dialog" aria-labelledby="importCsvModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="<?php echo e(route('ternak.import')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-header">
                        <h5 class="modal-title" id="importCsvModalLabel">Impor Data Ternak dari CSV</h5>
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
                                Format kolom yang diharapkan: `tag_number, species_id, kategori_id, sub_kategori_id, tipe_domba_id, jenis_domba_id, gender, date_of_birth, date_of_entry, usia_masuk_dalam_bulan, entry_weight, current_weight, last_weight_date, upweight, kondisi_id, status_id, kandang_id, dam_tag_number, sire_tag_number, notes, photo_path`
                                <br><br>
                                <div style="max-height: 200px; overflow-y: auto; border: 1px solid #eee; padding: 10px; background-color: #f9f9f9;">
                                    <strong>Contoh ID yang Tersedia:</strong><br>
                                    <strong>species_id:</strong><br>
                                    <?php $__empty_1 = true; $__currentLoopData = $speciesList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $species): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php echo e($species->id); ?>: <?php echo e($species->name); ?><br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        Tidak ada data spesies.<br>
                                    <?php endif; ?>
                                    <br>
                                    <strong>kategori_id:</strong><br>
                                    <?php $__empty_1 = true; $__currentLoopData = $kategoriList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kategori): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php echo e($kategori->id); ?>: <?php echo e($kategori->name); ?><br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        Tidak ada data kategori.<br>
                                    <?php endif; ?>
                                    <br>
                                    <strong>sub_kategori_id:</strong><br>
                                    <?php $__empty_1 = true; $__currentLoopData = $subKategoriList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subKategori): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php echo e($subKategori->id); ?>: <?php echo e($subKategori->name); ?><br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        Tidak ada data kategori.<br>
                                    <?php endif; ?>
                                    <br>
                                    <strong>tipe_domba_id:</strong><br>
                                    <?php $__empty_1 = true; $__currentLoopData = $tipeDombaList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipeDomba): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php echo e($tipeDomba->id); ?>: <?php echo e($tipeDomba->name); ?><br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        Tidak ada data tipe domba.<br>
                                    <?php endif; ?>
                                    <br>
                                    <strong>jenis_domba_id:</strong><br>
                                    <?php $__empty_1 = true; $__currentLoopData = $jenisDombaList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenisDomba): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php echo e($jenisDomba->id); ?>: <?php echo e($jenisDomba->name); ?><br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        Tidak ada data jenis domba.<br>
                                    <?php endif; ?>
                                    <br>
                                    <strong>kondisi_id:</strong><br>
                                    <?php $__empty_1 = true; $__currentLoopData = $kondisiList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kondisi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php echo e($kondisi->id); ?>: <?php echo e($kondisi->name); ?><br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        Tidak ada data kondisi.<br>
                                    <?php endif; ?>
                                    <br>
                                    <strong>status_id:</strong><br>
                                    <?php $__empty_1 = true; $__currentLoopData = $statusList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php echo e($status->id); ?>: <?php echo e($status->name); ?><br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        Tidak ada data status.<br>
                                    <?php endif; ?>
                                    <br>
                                    <strong>kandang_id:</strong><br>
                                    <?php $__empty_1 = true; $__currentLoopData = $kandangList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kandang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php echo e($kandang->kandang_id); ?><br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        Tidak ada data kandang.<br>
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
        document.getElementById('select-all').addEventListener('change', function () {
            const checked = this.checked;
            document.querySelectorAll('input[name="tag_numbers\\[\\]"]').forEach(cb => cb.checked = checked);
        });

        // Function to save filter values to localStorage
        function saveFilters() {
            const form = document.getElementById('filterForm');
            const elements = form.elements;
            let filters = {};
            for (let i = 0; i < elements.length; i++) {
                const element = elements[i];
                if (element.name && (element.tagName === 'SELECT' || element.tagName === 'INPUT')) {
                    filters[element.name] = element.value;
                }
            }
            localStorage.setItem('ternakFilters', JSON.stringify(filters));
        }

        // Function to load filter values from localStorage
        function loadFilters() {
            const savedFilters = localStorage.getItem('ternakFilters');
            if (savedFilters) {
                const filters = JSON.parse(savedFilters);
                const form = document.getElementById('filterForm');
                for (const name in filters) {
                    const element = form.elements[name];
                    if (element) {
                        element.value = filters[name];
                    }
                }
            }
        }

        // Event listener for form submission to save filters
        document.getElementById('filterForm').addEventListener('submit', function(event) {
            saveFilters();
        });

        // Event listener for reset button to clear filters
        document.getElementById('resetFilterButton').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior
            localStorage.removeItem('ternakFilters'); // Clear saved filters
            window.location.href = "<?php echo e(route('ternak.index')); ?>"; // Redirect to clear server-side filters
        });

        // Load filters when the page is ready
        $(document).ready(function() {
            loadFilters();

            // Tampilkan modal impor jika ada error validasi terkait impor
            var hasImportErrors = json_encode($errors->has('csv_file') || $errors->has('import_errors'));
            if (hasImportErrors) {
                $('#importCsvModal').modal('show');
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sphin\Documents\GitHub\glowing-waddle\resources\views/admin/ternak/index.blade.php ENDPATH**/ ?>