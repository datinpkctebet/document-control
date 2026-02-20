@extends('layouts.app')

@section('title', 'Daftar Dokumen Internal')
@section('page_title', 'Daftar Dokumen Internal')
@section('page_description', 'Kelola dokumen internal')

@section('toolbar_actions')
@if(auth()->user()->isPetugas() || auth()->user()->isSuperadmin())
<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalUploadDokumen">
    <span class="svg-icon svg-icon-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="black" />
            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
        </svg>
    </span>
    Upload Dokumen
</button>
@endif
@endsection

@section('content')
<div class="card">
    <div class="card-header border-0 pt-6">
        <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1">
                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                    </svg>
                </span>
                <input type="text" id="searchInput" class="form-control form-control-solid w-250px ps-15" placeholder="Cari dokumen..." />
            </div>
        </div>

        <div class="card-toolbar">
            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                    <span class="svg-icon svg-icon-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="black" />
                        </svg>
                    </span>
                    Filter
                </button>
                <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true" id="kt-toolbar-filter">
                    <div class="px-7 py-5">
                        <div class="fs-5 text-dark fw-bolder">Filter Options</div>
                    </div>
                    
                    <div class="separator border-gray-200"></div>
                    
                    <div class="px-7 py-5" data-kt-customer-table-filter="form">
                        <div class="mb-10">
                            <label class="form-label fs-6 fw-bold">Klaster:</label>
                            <select class="form-select form-select-solid fw-bolder" id="filterKlaster" data-kt-select2="true" data-placeholder="Pilih Klaster" data-allow-clear="true" data-kt-customer-table-filter="klaster" data-dropdown-parent="#kt-toolbar-filter">
                                <option value="">Semua Klaster</option>
                                @foreach($listKlaster as $klaster)
                                <option value="{{ $klaster->id_pokja }}">{{ $klaster->pokja }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-10">
                            <label class="form-label fs-6 fw-bold">Pelayanan:</label>
                            <select class="form-select form-select-solid fw-bolder" id="filterPelayanan" data-kt-select2="true" data-placeholder="Pilih Pelayanan" data-allow-clear="true" data-kt-customer-table-filter="pelayanan" data-dropdown-parent="#kt-toolbar-filter">
                                <option value="">Semua Pelayanan</option>
                                @foreach($listPelayanan as $pelayanan)
                                <option value="{{ $pelayanan->id_pelayanan }}">{{ $pelayanan->jenis_pelayanan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-10">
                            <label class="form-label fs-6 fw-bold">Jenis Dokumen:</label>
                            <select class="form-select form-select-solid fw-bolder" id="filterJenisDokumen" data-kt-select2="true" data-placeholder="Pilih Jenis Dokumen" data-allow-clear="true" data-kt-customer-table-filter="jenisDokumen" data-dropdown-parent="#kt-toolbar-filter">
                                <option value="">Semua Jenis Dokumen</option>
                                @foreach($listJenisDokumen as $jenisDokumen)
                                <option value="{{ $jenisDokumen->id_jenis_dokumen_unit }}">{{ $jenisDokumen->jenis_dokumen }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-10">
                            <label class="form-label fs-6 fw-bold">Tahun:</label>
                            <select class="form-select form-select-solid fw-bolder" id="filterTahun" data-kt-select2="true" data-placeholder="Pilih Tahun" data-allow-clear="true" data-kt-customer-table-filter="tahun" data-dropdown-parent="#kt-toolbar-filter">
                                <option value="">Semua Tahun</option>
                                @foreach($listTahun as $tahun)
                                <option value="{{ $tahun->tahun }}">{{ $tahun->tahun }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-light btn-active-light-primary fw-bold me-2 px-6" id="resetFilter">Reset</button>
                            <button type="submit" class="btn btn-primary fw-bold px-6" id="applyFilter">Apply</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="documentsTable">
                <thead>
                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                        <th class="min-w-50px">KLASTER</th>
                        <th class="min-w-50px">PELAYANAN</th>
                        <th class="min-w-50px">JENIS DOKUMEN</th>
                        <th class="min-w-50px">NAMA DOKUMEN</th>
                        <th class="min-w-50px">TAHUN DOKUMEN</th>
                        <th class="min-w-50px">NO DOKUMEN</th>
                        <th class="min-w-100px text-center">AKSI</th>
                    </tr>
                </thead>

                <tbody class="fw-bold text-gray-600">
                    @forelse($dokumenInternal as $index => $dokumen)
                    <tr>
                        <td>
                            <div style="max-width: 150px;" data-bs-toggle="tooltip" title="{{ $dokumen->pokja->pokja ?? '-' }}">
                                {{ 
                                    $dokumen->pokja->pokja ? $dokumen->pokja->pokja : '-'
                                }}
                            </div>
                        </td>
                        <td>
                            <div style="max-width: 250px;" data-bs-toggle="tooltip" title="{{ $dokumen->pelayanan->jenis_pelayanan ?? '-' }}">
                                {{ 
                                    $dokumen->pelayanan->jenis_pelayanan ? $dokumen->pelayanan->jenis_pelayanan : '-'
                                }}
                            </div>
                        </td>
                        <td>
                            <div style="max-width: 250px;" data-bs-toggle="tooltip" title="{{ $dokumen->jenisDokumenUnit->jenis_dokumen ?? '-' }}">
                                {{
                                    $dokumen->jenisDokumenUnit->jenis_dokumen ? $dokumen->jenisDokumenUnit->jenis_dokumen : '-'
                                }}
                            </div>
                        </td>
                        <td>
                            <div style="max-width: 400px;" data-bs-toggle="tooltip" title="{{ $dokumen->nama_dokumen ?? '-' }}">
                                {{
                                    $dokumen->nama_dokumen ? $dokumen->nama_dokumen : '-'
                                }}
                            </div>
                        </td>
                        <td>
                            <div style="max-width: 150px;" data-bs-toggle="tooltip" title="{{ $dokumen->tahun_dokumen ?? '-' }}">
                                <span class="badge badge-light-success">{{ $dokumen->tahun_dokumen ?? '-' }}</span>
                            </div>
                        </td>
                        <td>
                            <div style="max-width: 150px;" data-bs-toggle="tooltip" title="{{ $dokumen->no_dokumen ?? '-' }}">
                                {{
                                    $dokumen->no_dokumen ? $dokumen->no_dokumen : '-'
                                }}
                            </div>
                        </td>
                        <td class="text-center">
                            <a href="{{ asset('uploads/internal_unit/' . $dokumen->file_dokumen) }}" type="button" class="btn btn-sm btn-light btn-active-primary" target="_blank" rel="noopener">
                                <i class="fa fa-eye"></i> Lihat
                            </a>
                            @if(auth()->user()->isPetugas() || auth()->user()->isSuperadmin())
                            <button type="button" class="btn btn-sm btn-light-warning" onclick="editDokumen({{ $dokumen->id_dokumen_internal_unit }})">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                            @endif

                            @if(auth()->user()->isPetugas() || auth()->user()->isSuperadmin())
                            <button type="button" class="btn btn-sm btn-light-danger" onclick="deleteDokumen({{ $dokumen->id_dokumen_internal_unit }})">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Upload Dokumen -->
<div class="modal fade" id="modalUploadDokumen" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bolder">Upload Dokumen</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                </div>
            </div>

            <form id="formUploadDokumen" enctype="multipart/form-data">
                @csrf
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    
                    <div class="fv-row mb-7">
                        <label class="required fw-bold fs-6 mb-2">Klaster</label>
                        <select class="form-select form-select-solid" name="id_pokja" id="upload_klaster" required>
                            <option value="">Pilih Klaster</option>
                        </select>
                    </div>
                    
                    <div class="fv-row mb-7">
                        <label class="required fw-bold fs-6 mb-2">Pelayanan</label>
                        <select class="form-select form-select-solid" name="id_pelayanan" id="upload_pelayanan" required>
                            <option value="">Pilih Pelayanan</option>
                        </select>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="required fw-bold fs-6 mb-2">Jenis Dokumen</label>
                        <select class="form-select form-select-solid" name="id_jenis_dokumen_unit" id="upload_jenis_dokumen" required>
                            <option value="">Pilih Jenis Dokumen</option>
                        </select>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="required fw-bold fs-6 mb-2">Tahun Dokumen</label>
                        <select class="form-select form-select-solid" name="tahun_dokumen" id="upload_tahun_dokumen" required>
                            <option value="">Pilih Tahun Dokumen</option>
                        </select>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="required fw-bold fs-6 mb-2">Nomor Dokumen</label>
                        <input type="text" name="no_dokumen" class="form-control form-control-solid" placeholder="Masukkan nomor dokumen" required />
                    </div>

                    <div class="fv-row mb-7">
                        <label class="required fw-bold fs-6 mb-2">Nama Dokumen</label>
                        <input type="text" name="nama_dokumen" class="form-control form-control-solid" placeholder="Masukkan nama dokumen" required />
                    </div>

                    <div class="fv-row mb-7">
                        <label class="required fw-bold fs-6 mb-2">File Dokumen</label>
                        <input type="file" name="file_dokumen" class="form-control form-control-solid" accept=".pdf" required />
                        <div class="form-text">Format: PDF. Maksimal 10MB</div>
                    </div>
                </div>

                <div class="modal-footer flex-center">
                    <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">Upload</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Dokumen -->
<div class="modal fade" id="modalEditDokumen" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bolder">Edit Dokumen</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                </div>
            </div>

            <form id="formEditDokumen" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_dokumen" id="edit_id_dokumen">
                
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">                    
                    <div class="fv-row mb-7">
                        <label class="required fw-bold fs-6 mb-2">Klaster</label>
                        <select class="form-select form-select-solid" name="edit_id_pokja" id="edit_klaster" required>
                            <option value="">Pilih Klaster</option>
                        </select>
                    </div>
                    
                    <div class="fv-row mb-7">
                        <label class="required fw-bold fs-6 mb-2">Pelayanan</label>
                        <select class="form-select form-select-solid" name="edit_id_pelayanan" id="edit_pelayanan" required>
                            <option value="">Pilih Pelayanan</option>
                        </select>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="required fw-bold fs-6 mb-2">Jenis Dokumen</label>
                        <select class="form-select form-select-solid" name="edit_id_jenis_dokumen_unit" id="edit_jenis_dokumen" required>
                            <option value="">Pilih Jenis Dokumen</option>
                        </select>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="required fw-bold fs-6 mb-2">Tahun Dokumen</label>
                        <select class="form-select form-select-solid" name="edit_tahun_dokumen" id="edit_tahun_dokumen" required>
                            <option value="">Pilih Tahun Dokumen</option>
                        </select>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="required fw-bold fs-6 mb-2">Nomor Dokumen</label>
                        <input type="text" name="edit_no_dokumen" id="edit_nomor_dokumen" class="form-control form-control-solid" placeholder="Masukkan nomor dokumen" required />
                    </div>

                    <div class="fv-row mb-7">
                        <label class="required fw-bold fs-6 mb-2">Nama Dokumen</label>
                        <input type="text" name="edit_nama_dokumen" id="edit_nama_dokumen" class="form-control form-control-solid" placeholder="Masukkan nama dokumen" required />
                    </div>

                    <div class="fv-row mb-7">
                        <label class="fw-bold fs-6 mb-2">File Dokumen</label>
                        <input type="file" name="edit_file_dokumen" class="form-control form-control-solid" accept=".pdf" />
                        <div class="form-text">Kosongkan jika tidak ingin mengubah file. Maksimal 10MB</div>
                        <div id="current_file_info" class="mt-2"></div>
                    </div>
                </div>

                <div class="modal-footer flex-center">
                    <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">Update</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

<script>
let currentElemenId = null;

$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // Initialize DataTable
    var table = $('#documentsTable').DataTable({
        responsive: false,  // Disable responsive karena banyak kolom
        scrollX: true,      // Enable horizontal scroll
        searching: true,
        pageLength: 25,
        order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: [-1] }  // Disable sort pada kolom terakhir (aksi)
        ]
    });

    // Search functionality
    $('#searchInput').on('keyup', function() {
        table.search(this.value).draw();
    });

    // Initialize Select2
    $('#filterKlaster, #filterPelayanan, #filterJenisDokumen, #filterTahun, #upload_klaster, #edit_klaster, #upload_pelayanan, #edit_pelayanan, #upload_tahun_dokumen, #edit_tahun_dokumen, #upload_jenis_dokumen, #edit_jenis_dokumen').select2();

    // Initialize Select2 in modals
    $('#modalUploadDokumen, #modalEditDokumen').on('shown.bs.modal', function () {
        $(this).find('select').select2({
            dropdownParent: $(this)
        });
    });

    // Load klaster, pelayanan, jenis dokumen on page load
    loadKlaster();
    loadPelayanan();
    loadJenisDokumen();
    loadTahunDokumen();

    // Apply filter
    $('#applyFilter').on('click', function() {
        let klaster = $('#filterKlaster').val();
        let pelayanan = $('#filterPelayanan').val();
        let jenisDokumen = $('#filterJenisDokumen').val();
        let tahun = $('#filterTahun').val();
        
        let url = '{{ route("dokumen.internal") }}?';
        if (tahun) url += 'tahun=' + tahun + '&';
        if (klaster) url += 'klaster=' + klaster + '&';
        if (pelayanan) url += 'pelayanan=' + pelayanan + '&';
        if (jenisDokumen) url += 'jenisDokumen=' + jenisDokumen + '&';
        
        window.location.href = url;
    });

    // Reset filter
    $('#resetFilter').on('click', function() {
        window.location.href = '{{ route("dokumen.internal") }}';
    });

    // Form upload submit
    $('#formUploadDokumen').on('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        console.log(formData);
        
        // Validate file size (10MB)
        let fileInput = $('input[name="file_dokumen"]')[0];
        if (fileInput.files.length > 0) {
            let fileSize = fileInput.files[0].size / 1024 / 1024; // in MB
            if (fileSize > 10) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Ukuran file maksimal 10MB',
                });
                return;
            }
        }

        $.ajax({
            url: '{{ route("dokumen.storeInternal") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('button[type="submit"]').attr('disabled', true);
                $('button[type="submit"] .indicator-label').hide();
                $('button[type="submit"] .indicator-progress').show();
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $('#modalUploadDokumen').modal('hide');
                        location.reload();
                    });
                }
            },
            error: function(xhr) {
                let errorMessage = 'Terjadi kesalahan';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = Object.values(xhr.responseJSON.errors).join('<br>');
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    html: errorMessage,
                });
            },
            complete: function() {
                $('button[type="submit"]').attr('disabled', false);
                $('button[type="submit"] .indicator-label').show();
                $('button[type="submit"] .indicator-progress').hide();
            }
        });
    });

    // Form edit submit
    $('#formEditDokumen').on('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        let dokumenId = $('#edit_id_dokumen').val();
        
        // Validate file size (10MB) if file is selected
        let fileInput = $('#formEditDokumen input[name="edit_file_dokumen"]')[0];
        if (fileInput.files.length > 0) {
            let fileSize = fileInput.files[0].size / 1024 / 1024; // in MB
            if (fileSize > 10) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Ukuran file maksimal 10MB',
                });
                return;
            }
        }

        $.ajax({
            url: '{{ url("dokumen/updateInternal") }}/' + dokumenId,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('button[type="submit"]').attr('disabled', true);
                $('button[type="submit"] .indicator-label').hide();
                $('button[type="submit"] .indicator-progress').show();
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        $('#modalEditDokumen').modal('hide');
                        location.reload();
                        // showDokumen(currentElemenId);
                    });
                }
            },
            error: function(xhr) {
                let errorMessage = 'Terjadi kesalahan';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = Object.values(xhr.responseJSON.errors).join('<br>');
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    html: errorMessage,
                });
            },
            complete: function() {
                $('button[type="submit"]').attr('disabled', false);
                $('button[type="submit"] .indicator-label').show();
                $('button[type="submit"] .indicator-progress').hide();
            }
        });
    });

    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
});

// Load Klaster
function loadKlaster() {
    $.ajax({
        url: '{{ route("dokumen.get-klaster") }}',
        type: 'GET',
        success: function(response) {
            if (response.success) {
                let options = '<option value="">Pilih Klaster</option>';
                response.data.forEach(function(item) {
                    options += `<option value="${item.id_pokja}">${item.pokja}</option>`;
                });
                $('#upload_klaster, #edit_klaster').html(options);
            }
        }
    });
}

// Load Pelayanan
function loadPelayanan() {
    $.ajax({
        url: '{{ route("dokumen.get-pelayanan") }}',
        type: 'GET',
        success: function(response) {
            if (response.success) {
                let options = '<option value="">Pilih Pelayanan</option>';
                response.data.forEach(function(item) {
                    options += `<option value="${item.id_pelayanan}">${item.jenis_pelayanan}</option>`;
                });
                $('#upload_pelayanan, #edit_pelayanan').html(options);
            }
        }
    });
}

// Load Jenis Dokumen
function loadJenisDokumen() {
    $.ajax({
        url: '{{ route("dokumen.get-jenis-dokumen") }}',
        type: 'GET',
        success: function(response) {
            if (response.success) {
                let options = '<option value="">Pilih Jenis Dokumen</option>';
                response.data.forEach(function(item) {
                    options += `<option value="${item.id_jenis_dokumen_unit}">${item.jenis_dokumen}</option>`;
                });
                $('#upload_jenis_dokumen, #edit_jenis_dokumen').html(options);
            }
        }
    });
}

// Load Tahun Dokumen
function loadTahunDokumen() {
    $.ajax({
        url: '{{ route("dokumen.get-tahun-dokumen") }}',
        type: 'GET',
        success: function(response) {
            if (response.success) {
                let options = '<option value="">Pilih Tahun Dokumen</option>';
                response.data.forEach(function(item) {
                    options += `<option value="${item.tahun_dokumen}">${item.tahun_dokumen}</option>`;
                });
                $('#upload_tahun_dokumen, #edit_tahun_dokumen').html(options);
            }
        }
    });
}

// Open upload modal with dokumen id
function openUploadModal(dokumenId) {
    currentDokumenId = dokumenId;
    $('#upload_id_dokumen_internal_unit').val(dokumenId);
    $('#modalUploadDokumen').modal('show');
}

// Edit dokumen
function editDokumen(dokumenId) {
    $.ajax({
        url: '{{ url("dokumen/get-dokumenInternal") }}/' + dokumenId,
        type: 'GET',
        success: function(response) {
            if (response.success) {
                let dokumen = response.data.find(item => item.id_dokumen_internal_unit == dokumenId);
                console.log(dokumen);
                if (dokumen) {
                    $('#edit_id_dokumen').val(dokumen.id_dokumen_internal_unit);
                    $('#edit_klaster').val(dokumen.id_pokja).trigger('change');
                    $('#edit_pelayanan').val(dokumen.id_pelayanan).trigger('change');
                    $('#edit_jenis_dokumen').val(dokumen.id_jenis_dokumen_unit).trigger('change');
                    $('#edit_tahun_dokumen').val(dokumen.tahun_dokumen).trigger('change');
                    $('#edit_nomor_dokumen').val(dokumen.no_dokumen);
                    $('#edit_nama_dokumen').val(dokumen.nama_dokumen);
                    $('#current_file_info').html(`<small class="text-muted">File saat ini: ${dokumen.file_dokumen}</small>`);
                    
                    $('#modalEditDokumen').modal('show');
                }
            }
        }
    });
}

// Delete dokumen
function deleteDokumen(dokumenId) {
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin ingin menghapus dokumen ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ url("dokumen/destroyInternal") }}/' + dokumenId,
                type: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: xhr.responseJSON?.message || 'Terjadi kesalahan',
                    });
                }
            });
        }
    });
}
</script>
@endpush