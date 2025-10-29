@extends('adminlte::page')

@section('title', 'Detail Data Ternak')

@section('content_header')
    <h1>Detail Data Ternak</h1>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            {{-- Alert Section for general messages (success, error, warning) --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{ session('warning') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            {{-- End Alert Section --}}

            {{-- Error Validasi untuk Form Tambah Riwayat Bobot --}}
            {{-- Periksa juga old('id') untuk memastikan ini bukan error dari modal edit --}}
            @if($errors->has('weight') && !session('show_edit_weight_modal'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h5><i class="icon fas fa-ban"></i> Validasi Gagal!</h5>
                    <ul>
                        @foreach ($errors->get('weight') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        @foreach ($errors->get('measurement_date') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Detail Ternak: {{ $ternak->tag_number }}</h3>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">TAGGING</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $ternak->tag_number }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Spesies</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $ternak->species->name ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Kategori</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $ternak->kategori->name ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Sub Kategori</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $ternak->subKategori->name ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tipe Domba</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $ternak->tipeDomba->name ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jenis Domba</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $ternak->jenisDomba->name ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $ternak->gender }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Kandang</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $ternak->kandang->kandang_id ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Usia Masuk(Bulan)</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $ternak->usia_masuk_dalam_bulan ?? '-' }} bulan</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Usia (Hari)</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $ternak->umur_hari ?? '-' }} hari</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Hari di Farm</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $ternak->hari_di_peternakan ?? '-' }} hari</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Kondisi</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $ternak->kondisi->name ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Berat Masuk (kg)</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $ternak->entry_weight ?? '-' }} kg</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Berat Saat Ini (kg)</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $ternak->current_weight ?? '-' }} kg</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Terakhir Diukur</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $ternak->last_weight_date ? \Carbon\Carbon::parse($ternak->last_weight_date)->format('d-m-Y') : '-' }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Upweight</label> {{-- <<< TAMBAHKAN INI --}}
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $ternak->upweight ?? '-' }} kg</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $ternak->date_of_birth ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tanggal Masuk</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $ternak->date_of_entry ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $ternak->status->name ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Induk Betina</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $ternak->dam->tag_number ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Induk Jantan</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $ternak->sire->tag_number ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Catatan</label>
                        <div class="col-sm-9">
                            <p class="form-control-static">{{ $ternak->notes ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Foto</label>
                        <div class="col-sm-9">
                            @if($ternak->photo_path)
                                <img src="{{ asset($ternak->photo_path) }}" alt="Foto Ternak" class="img-thumbnail" style="max-width: 200px;">
                            @else
                                <p class="form-control-static">-</p>
                            @endif
                        </div>
                    </div>

                    <hr>
                    <h4>Tambah Riwayat Bobot Baru</h4>
                    <form action="{{ route('ternak.weights.store', $ternak->tag_number) }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="new_weight" class="col-sm-3 col-form-label">Berat (kg)</label>
                            <div class="col-sm-9">
                                <input type="number" step="0.01" class="form-control @error('weight') is-invalid @enderror" id="new_weight" name="weight" value="{{ old('weight') }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_measurement_date" class="col-sm-3 col-form-label">Tanggal Pengukuran</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control @error('measurement_date') is-invalid @enderror" id="new_measurement_date" name="measurement_date" value="{{ old('measurement_date', \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
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
                    @if($weightHistories->isNotEmpty())
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
                                    @foreach($weightHistories as $history)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($history->measurement_date)->format('d-m-Y') }}</td>
                                            <td>{{ $history->weight }} kg</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-warning btn-edit-weight"
                                                            data-toggle="modal" data-target="#editWeightModal"
                                                            data-id="{{ $history->id }}"
                                                            data-weight="{{ $history->weight }}"
                                                            data-date="{{ $history->measurement_date }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>
                                                    <form action="{{ route('weights.destroy', $history->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus riwayat bobot ini?')">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>Tidak ada riwayat bobot untuk ternak ini.</p>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('ternak.edit', $ternak->tag_number) }}" class="btn btn-warning">Edit Data Utama Ternak</a>
                    <a href="{{ route('ternak.index') }}" class="btn btn-secondary">Kembali ke Daftar Ternak</a>
                </div>
            </div>
            </div>
    </section>

    {{-- Modal Edit Weight History --}}
    <div class="modal fade" id="editWeightModal" tabindex="-1" role="dialog" aria-labelledby="editWeightModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editWeightForm" method="POST">
                    @csrf
                    @method('PUT')
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
                            {{-- Error khusus untuk modal, jika ada --}}
                            @error('weight', 'edit_weight_modal')
                                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="edit_measurement_date">Tanggal Pengukuran</label>
                            <input type="date" class="form-control" id="edit_measurement_date" name="measurement_date" required>
                            {{-- Error khusus untuk modal, jika ada --}}
                            @error('measurement_date', 'edit_weight_modal')
                                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                            @enderror
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
@stop

@section('css')
    {{-- Tambahkan stylesheet tambahan jika diperlukan --}}
@stop

@section('js')
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
            @if(session('show_edit_weight_modal') && $errors->edit_weight_modal->any())
                $(function() { // Menggunakan $(function() { ... }) untuk memastikan DOM siap
                    var modal = $('#editWeightModal');
                    modal.modal('show');

                    // Isi ulang data ke modal dari old input jika validasi gagal
                    modal.find('#edit_history_id').val("{{ old('id') }}");
                    modal.find('#edit_weight').val("{{ old('weight') }}");
                    modal.find('#edit_measurement_date').val("{{ old('measurement_date') }}");

                    // Tampilkan pesan error validasi langsung di dalam modal
                    @error('weight', 'edit_weight_modal')
                        modal.find('#edit_weight').addClass('is-invalid').after('<span class="invalid-feedback d-block" role="alert">{{ $message }}</span>');
                    @enderror
                    @error('measurement_date', 'edit_weight_modal')
                        modal.find('#edit_measurement_date').addClass('is-invalid').after('<span class="invalid-feedback d-block" role="alert">{{ $message }}</span>');
                    @enderror

                    // Atur action form modal berdasarkan old('id') jika tersedia
                    var oldHistoryId = "{{ old('id') }}";
                    if (oldHistoryId) {
                        modal.find('#editWeightForm').attr('action', '/admin/weights/' + oldHistoryId);
                    }
                });
            @endif
        });
    </script>
@stop