@extends('layouts.app')

@section('title', 'Daftar Dokumen')
@section('page_title', 'Daftar Dokumen Akreditasi')
@section('page_description', 'Kelola dokumen akreditasi')

@section('toolbar_actions')
<!-- Filter Tahun Kegiatan Akreditasi -->
<select class="form-select form-select-solid w-250px" id="filterTahunKegiatan" onchange="filterByTahun()">
    @foreach($listKegiatanAkreditasi as $kegiatan)
    <option value="{{ $kegiatan->id_akreditasi_kegiatan }}" 
        {{ $kegiatanAktif && $kegiatanAktif->id_akreditasi_kegiatan == $kegiatan->id_akreditasi_kegiatan ? 'selected' : '' }}>
        {{ $kegiatan->nama_kegiatan }}
    </option>
    @endforeach
</select>

@if(auth()->user()->isPetugas() || auth()->user()->isSuperadmin())
<!-- <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalUploadDokumen">
    <span class="svg-icon svg-icon-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="black" />
            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
        </svg>
    </span>
    Upload Dokumen
</button> -->
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
                            <label class="form-label fs-6 fw-bold">BAB:</label>
                            <select class="form-select form-select-solid fw-bolder" id="filterBab" data-kt-select2="true" data-placeholder="Pilih BAB" data-allow-clear="true" data-kt-customer-table-filter="bab" data-dropdown-parent="#kt-toolbar-filter">
                                <option value="">Semua BAB</option>
                                @foreach($listBab as $bab)
                                <option value="{{ $bab->id_master_bab }}">{{ $bab->master_bab }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-10">
                            <label class="form-label fs-6 fw-bold">Standar:</label>
                            <select class="form-select form-select-solid fw-bolder" id="filterStandar" data-kt-select2="true" data-placeholder="Pilih Standar" data-allow-clear="true" data-kt-customer-table-filter="standar" data-dropdown-parent="#kt-toolbar-filter">
                                <option value="">Semua Standar</option>
                                @foreach($listStandar as $standar)
                                <option value="{{ $standar->id_master_standar }}" data-bab="{{ $standar->id_master_bab }}">{{ $standar->master_standar }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-10">
                            <label class="form-label fs-6 fw-bold">Kriteria:</label>
                            <select class="form-select form-select-solid fw-bolder" id="filterKriteria" data-kt-select2="true" data-placeholder="Pilih Kriteria" data-allow-clear="true" data-kt-customer-table-filter="kriteria" data-dropdown-parent="#kt-toolbar-filter">
                                <option value="">Semua Kriteria</option>
                                @foreach($listKriteria as $kriteria)
                                <option value="{{ $kriteria->id_master_kriteria }}" data-standar="{{ $kriteria->id_master_standar }}">{{ $kriteria->master_kriteria }}</option>
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
                        <th class="min-w-50px">BAB</th>
                        <th class="min-w-100px">STANDAR</th>
                        <th class="min-w-100px">KRITERIA</th>
                        <th class="min-w-200px">ELEMEN PENILAIAN</th>
                        <th class="min-w-150px">R</th>
                        <th class="min-w-150px">D</th>
                        <th class="min-w-100px">DOKUMEN</th>
                        <th class="min-w-100px text-center">AKSI</th>
                        
                        @if(auth()->user()->level->id_level == 3)
                        <!-- Kolom Penilaian untuk Surveyor -->
                        <th class="min-w-80px text-center">NILAI</th>
                        <th class="min-w-150px">FAKTA & ANALISIS</th>
                        <th class="min-w-150px">REKOMENDASI</th>
                        @endif
                        
                        @if(auth()->user()->isPetugas())
                        <!-- Kolom PPS untuk Petugas -->
                        <th class="min-w-80px text-center">NILAI</th>
                        <th class="min-w-150px">FAKTA & ANALISIS</th>
                        <th class="min-w-150px">REKOMENDASI</th>
                        <th class="min-w-150px">RENCANA PERBAIKAN</th>
                        <th class="min-w-150px">INDIKATOR PENCAPAIAN</th>
                        <th class="min-w-100px">SASARAN</th>
                        <th class="min-w-100px">WAKTU</th>
                        <th class="min-w-100px">SUMBER DANA</th>
                        <th class="min-w-100px">PENANGGUNG JAWAB</th>
                        <th class="min-w-100px text-center">DETAIL PPS</th>
                        @endif
                    </tr>
                </thead>

                <tbody class="fw-bold text-gray-600">
                    @forelse($elemenPenilaian as $index => $elemen)
                    <tr>
                        <!-- <td>{{ $index + 1 }}</td> -->
                        <td>
                            <div class="text-truncate" style="max-width: 50px;" data-bs-toggle="tooltip" title="{{ $elemen->bab->master_bab ?? '-' }}">
                                {{ 
                                    preg_match('/BAB\s*([^\s]+)/', $elemen->bab->master_bab ?? '', $m) 
                                        ? $m[1] : '-' 
                                }}
                            </div>
                        </td>
                        <td>
                            <div class="text-truncate" style="max-width: 50px;" data-bs-toggle="tooltip" title="{{ $elemen->standar->master_standar ?? '-' }}">
                                {{
                                    preg_match('/Standar\s*([0-9\.]+)/', $elemen->standar->master_standar ?? '', $m)
                                        ? $m[1] : '-'
                                }}
                            </div>
                        </td>
                        <td>
                            <div class="text-truncate" style="max-width: 50px;" data-bs-toggle="tooltip" title="{{ $elemen->kriteria->master_kriteria ?? '-' }}">
                                {{
                                    preg_match('/Kriteria\s*([0-9\.]+)/', $elemen->kriteria->master_kriteria ?? '', $m)
                                        ? $m[1] : '-'
                                }}
                            </div>
                        </td>
                        <td>
                            <div class="text-truncate" style="max-width: 150px;" data-bs-toggle="tooltip" title="{{ strip_tags($elemen->elemen_penilaian) }}">
                                {!! Str::limit(strip_tags($elemen->elemen_penilaian), 100) !!}
                            </div>
                        </td>
                        <td>
                            <div class="text-truncate" style="max-width: 150px;" data-bs-toggle="tooltip" title="{{ strip_tags($elemen->r_penilaian) }}">
                                {!! Str::limit(strip_tags($elemen->r_penilaian), 50) !!}
                            </div>
                        </td>
                        <td>
                            <div class="text-truncate" style="max-width: 150px;" data-bs-toggle="tooltip" title="{{ strip_tags($elemen->d_penilaian) }}">
                                {!! Str::limit(strip_tags($elemen->d_penilaian), 50) !!}
                            </div>
                        </td>
                        <td>
                            @php
                                $dokumenCount = $elemen->dokumen->where('delete_at', 0)->count();
                            @endphp
                            @if($dokumenCount > 0)
                                <span class="badge badge-light-success">{{ $dokumenCount }} Dokumen</span>
                            @else
                                <span class="badge badge-light-danger">Belum ada</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-light btn-active-primary" onclick="showDokumen({{ $elemen->id_master_elemen_penilaian }})">
                                <i class="fa fa-eye"></i> Lihat
                            </button>
                            @if(auth()->user()->isPetugas() || auth()->user()->isSuperadmin())
                            <button type="button" class="btn btn-sm btn-light-primary" onclick="openUploadModal({{ $elemen->id_master_elemen_penilaian }})">
                                <i class="fa fa-upload"></i> Upload
                            </button>
                            @endif

                            @if(auth()->user()->level->id_level == 3)
                            <!-- Tombol Penilaian untuk Surveyor -->
                            <button type="button" class="btn btn-sm btn-light-warning" onclick="openPenilaianModal({{ $elemen->id_master_elemen_penilaian }})">
                                <i class="fa fa-star"></i> Penilaian
                            </button>
                            @endif

                            @if(auth()->user()->isPetugas())
                            <!-- Tombol Rencana Perbaikan untuk Petugas -->
                            <button type="button" class="btn btn-sm btn-light-success" onclick="openPerbaikanModal({{ $elemen->id_master_elemen_penilaian }})">
                                <i class="fa fa-tasks"></i> Perbaikan
                            </button>
                            @endif
                        </td>
                        @if(auth()->user()->level->id_level == 3)
                        <!-- Kolom Penilaian untuk Surveyor -->
                        <td class="text-center">
                            @php
                                $penilaian = $elemen->penilaian->first();
                            @endphp
                            @if($penilaian)
                                <span class="badge badge-light-{{ $penilaian->nilai == '10' ? 'success' : ($penilaian->nilai == '5' ? 'warning' : 'danger') }}">
                                    {{ $penilaian->nilai }}
                                </span>
                            @else
                                <span class="badge badge-light-secondary">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="text-truncate" style="max-width: 200px;" data-bs-toggle="tooltip" title="{{ $penilaian->fakta_analisis ?? '-' }}">
                                {{ $penilaian ? Str::limit(strip_tags($penilaian->fakta_analisis), 50) : '-' }}
                            </div>
                        </td>
                        <td>
                            <div class="text-truncate" style="max-width: 200px;" data-bs-toggle="tooltip" title="{{ $penilaian->rekomendasi ?? '-' }}">
                                {{ $penilaian ? Str::limit(strip_tags($penilaian->rekomendasi), 50) : '-' }}
                            </div>
                        </td>
                        @endif

                        @if(auth()->user()->isPetugas())
                        <!-- Kolom untuk Petugas (include penilaian dan PPS) -->
                        @php
                            $penilaian = $elemen->penilaian->first();
                            $perbaikan = $elemen->perbaikan->first();
                        @endphp

                        <!-- Nilai, Fakta, Rekomendasi (Read-only untuk petugas) -->
                        <td class="text-center">
                            @if($penilaian)
                                <span class="badge badge-light-{{ $penilaian->nilai == '10' ? 'success' : ($penilaian->nilai == '5' ? 'warning' : 'danger') }}">
                                    {{ $penilaian->nilai }}
                                </span>
                            @else
                                <span class="badge badge-light-secondary">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="text-truncate" style="max-width: 200px;">
                                {{ $penilaian ? Str::limit(strip_tags($penilaian->fakta_analisis), 50) : '-' }}
                            </div>
                        </td>
                        <td>
                            <div class="text-truncate" style="max-width: 200px;">
                                {{ $penilaian ? Str::limit(strip_tags($penilaian->rekomendasi), 50) : '-' }}
                            </div>
                        </td>

                        <!-- Kolom PPS -->
                        <td>
                            <div class="text-truncate" style="max-width: 200px;">
                                {{ $perbaikan ? Str::limit(strip_tags($perbaikan->rencana_perbaikan), 50) : '-' }}
                            </div>
                        </td>
                        <td>
                            <div class="text-truncate" style="max-width: 200px;">
                                {{ $perbaikan ? Str::limit(strip_tags($perbaikan->indikator_pencapaian), 50) : '-' }}
                            </div>
                        </td>
                        <td>
                            <div class="text-truncate" style="max-width: 150px;">
                                {{ $perbaikan->sasaran ?? '-' }}
                            </div>
                        </td>
                        <td>
                            <div class="text-truncate" style="max-width: 150px;">
                                {{ $perbaikan->waktu_penyelesaian ?? '-' }}
                            </div>
                        </td>
                        <td>
                            <div class="text-truncate" style="max-width: 150px;">
                                {{ $perbaikan->sumber_dana ?? '-' }}
                            </div>
                        </td>
                        <td>
                            <div class="text-truncate" style="max-width: 150px;">
                                {{ $perbaikan->penanggung_jawab ?? '-' }}
                            </div>
                        </td>
                        <td class="text-center">
                            @if($perbaikan)
                            <button type="button" class="btn btn-sm btn-light-info" onclick="showDetailPPS({{ $perbaikan->id_akreditasi_perbaikan }}, {{ $elemen->id_master_elemen_penilaian }})">
                                <i class="fa fa-list"></i> Detail
                            </button>
                            @else
                            <span class="badge badge-light-secondary">-</span>
                            @endif
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data</td>
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
                    <input type="hidden" name="id_master_elemen_penilaian" id="upload_id_master_elemen_penilaian">
                    
                    <div class="fv-row mb-7">
                        <label class="required fw-bold fs-6 mb-2">Elemen Penilaian</label>
                        <select class="form-select form-select-solid" name="id_master_elemen_penilaian_select" id="upload_elemen_penilaian">
                            <option value="">Pilih Elemen Penilaian</option>
                            @foreach($elemenPenilaian as $elemen)
                            <option value="{{ $elemen->id_master_elemen_penilaian }}">
                                {{ $elemen->bab->master_bab ?? '' }} - {{ Str::limit(strip_tags($elemen->elemen_penilaian), 80) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="required fw-bold fs-6 mb-2">Jenis Dokumen</label>
                        <select class="form-select form-select-solid" name="id_jenis_dokumen" id="upload_jenis_dokumen" required>
                            <option value="">Pilih Jenis Dokumen</option>
                        </select>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="required fw-bold fs-6 mb-2">Nama Dokumen</label>
                        <input type="text" name="nama_dokumen" class="form-control form-control-solid" placeholder="Masukkan nama dokumen" required />
                    </div>

                    <div class="fv-row mb-7">
                        <label class="fw-bold fs-6 mb-2">Keterangan</label>
                        <textarea name="keterangan_dokumen" class="form-control form-control-solid" rows="3" placeholder="Keterangan dokumen (opsional)"></textarea>
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
                        <label class="required fw-bold fs-6 mb-2">Jenis Dokumen</label>
                        <select class="form-select form-select-solid" name="id_jenis_dokumen" id="edit_jenis_dokumen" required>
                            <option value="">Pilih Jenis Dokumen</option>
                        </select>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="required fw-bold fs-6 mb-2">Nama Dokumen</label>
                        <input type="text" name="nama_dokumen" id="edit_nama_dokumen" class="form-control form-control-solid" required />
                    </div>

                    <div class="fv-row mb-7">
                        <label class="fw-bold fs-6 mb-2">Keterangan</label>
                        <textarea name="keterangan_dokumen" id="edit_keterangan_dokumen" class="form-control form-control-solid" rows="3"></textarea>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="fw-bold fs-6 mb-2">File Dokumen</label>
                        <input type="file" name="file_dokumen" class="form-control form-control-solid" accept=".pdf" />
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

<!-- Modal Lihat Dokumen -->
<div class="modal fade" id="modalLihatDokumen" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bolder">Daftar Dokumen</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                </div>
            </div>

            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="tableDokumenList">
                        <thead>
                            <tr class="fw-bolder text-muted">
                                <th class="min-w-50px">No</th>
                                <th class="min-w-150px">Jenis Dokumen</th>
                                <th class="min-w-200px">Nama Dokumen</th>
                                <th class="min-w-150px">Keterangan</th>
                                <th class="min-w-100px">File</th>
                                <th class="min-w-100px text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="dokumenListBody">
                            <tr>
                                <td colspan="6" class="text-center">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer flex-center">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Penilaian (Surveyor) -->
<div class="modal fade" id="modalPenilaian" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bolder">Input Penilaian</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                </div>
            </div>

            <form id="formPenilaian">
                @csrf
                <input type="hidden" name="id_master_elemen_penilaian" id="penilaian_id_elemen">
                
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <div class="fv-row mb-7">
                        <label class="required fw-bold fs-6 mb-2">Nilai</label>
                        <div class="d-flex gap-5">
                            <label class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="radio" name="nilai" value="0" id="nilai_0" onchange="toggleRekomendasi()" required />
                                <span class="form-check-label fw-bold">0</span>
                            </label>
                            <label class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="radio" name="nilai" value="5" id="nilai_5" onchange="toggleRekomendasi()" required />
                                <span class="form-check-label fw-bold">5</span>
                            </label>
                            <label class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="radio" name="nilai" value="10" id="nilai_10" onchange="toggleRekomendasi()" required />
                                <span class="form-check-label fw-bold">10</span>
                            </label>
                        </div>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="required fw-bold fs-6 mb-2">Fakta & Analisis</label>
                        <textarea name="fakta_analisis" id="penilaian_fakta" class="form-control form-control-solid" rows="4" required></textarea>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="fw-bold fs-6 mb-2" id="labelRekomendasi">Rekomendasi</label>
                        <textarea name="rekomendasi" id="penilaian_rekomendasi" class="form-control form-control-solid" rows="4"></textarea>
                        <div class="form-text text-danger d-none" id="rekomendasiHint">* Wajib diisi untuk nilai 0 atau 5</div>
                    </div>
                </div>

                <div class="modal-footer flex-center">
                    <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">Simpan</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Rencana Perbaikan (Petugas) -->
<div class="modal fade" id="modalPerbaikan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bolder">Rencana Perbaikan Strategis (PPS)</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                </div>
            </div>

            <form id="formPerbaikan">
                @csrf
                <input type="hidden" name="id_master_elemen_penilaian" id="perbaikan_id_elemen">
                
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <div class="row">
                        <div class="col-md-12 fv-row mb-7">
                            <label class="required fw-bold fs-6 mb-2">Rencana Perbaikan</label>
                            <textarea name="rencana_perbaikan" id="perbaikan_rencana" class="form-control form-control-solid" rows="3" required></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 fv-row mb-7">
                            <label class="required fw-bold fs-6 mb-2">Indikator Pencapaian</label>
                            <textarea name="indikator_pencapaian" id="perbaikan_indikator" class="form-control form-control-solid" rows="3" required></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 fv-row mb-7">
                            <label class="required fw-bold fs-6 mb-2">Sasaran</label>
                            <input type="text" name="sasaran" id="perbaikan_sasaran" class="form-control form-control-solid" required />
                        </div>
                        <div class="col-md-6 fv-row mb-7">
                            <label class="required fw-bold fs-6 mb-2">Waktu Penyelesaian</label>
                            <input type="text" name="waktu_penyelesaian" id="perbaikan_waktu" class="form-control form-control-solid" placeholder="Contoh: 3 bulan" required />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 fv-row mb-7">
                            <label class="required fw-bold fs-6 mb-2">Sumber Dana</label>
                            <input type="text" name="sumber_dana" id="perbaikan_dana" class="form-control form-control-solid" required />
                        </div>
                        <div class="col-md-6 fv-row mb-7">
                            <label class="required fw-bold fs-6 mb-2">Penanggung Jawab</label>
                            <input type="text" name="penanggung_jawab" id="perbaikan_pj" class="form-control form-control-solid" required />
                        </div>
                    </div>
                </div>

                <div class="modal-footer flex-center">
                    <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">Simpan</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail PPS -->
<div class="modal fade" id="modalDetailPPS" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bolder">Detail Kegiatan PPS Per Triwulan</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                        </svg>
                    </span>
                </div>
            </div>

            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <div class="mb-5">
                    <button type="button" class="btn btn-sm btn-primary" onclick="showFormKegiatanPPS()">
                        <i class="fa fa-plus"></i> Tambah Kegiatan
                    </button>
                </div>

                <!-- Form Tambah/Edit Kegiatan (Hidden by default) -->
                <div id="formKegiatanPPSContainer" class="card mb-5" style="display: none;">
                    <div class="card-body">
                        <form id="formKegiatanPPS">
                            @csrf
                            <input type="hidden" name="id_akreditasi_perbaikan" id="kegiatan_id_perbaikan">
                            <input type="hidden" name="id_master_elemen_penilaian" id="kegiatan_id_elemen">
                            <input type="hidden" name="kegiatan_id" id="kegiatan_id">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="required fw-bold fs-6 mb-2">Tahun Pelaporan</label>
                                    <input type="text" name="tahun_pelaporan" id="kegiatan_tahun" class="form-control form-control-solid" required />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="required fw-bold fs-6 mb-2">Periode (Triwulan)</label>
                                    <select name="periode_pelaporan" id="kegiatan_periode" class="form-select form-select-solid" required>
                                        <option value="">Pilih Triwulan</option>
                                        <option value="1">Triwulan 1 (Jan-Mar)</option>
                                        <option value="2">Triwulan 2 (Apr-Jun)</option>
                                        <option value="3">Triwulan 3 (Jul-Sep)</option>
                                        <option value="4">Triwulan 4 (Okt-Des)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="required fw-bold fs-6 mb-2">Kegiatan</label>
                                <textarea name="kegiatan" id="kegiatan_desc" class="form-control form-control-solid" rows="3" required></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="required fw-bold fs-6 mb-2">Status Kegiatan</label>
                                    <select name="status_kegiatan" id="kegiatan_status" class="form-select form-select-solid" required>
                                        <option value="">Pilih Status</option>
                                        <option value="belum">Belum Selesai</option>
                                        <option value="sudah">Sudah Selesai</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold fs-6 mb-2">Link Bukti</label>
                                    <input type="text" name="link_bukti" id="kegiatan_link" class="form-control form-control-solid" placeholder="URL bukti dokumen" />
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-light" onclick="hideFormKegiatanPPS()">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Table Kegiatan -->
                <div class="table-responsive">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="tableKegiatanPPS">
                        <thead>
                            <tr class="fw-bolder text-muted">
                                <th>No</th>
                                <th>Tahun</th>
                                <th>Triwulan</th>
                                <th>Kegiatan</th>
                                <th>Status</th>
                                <th>Link Bukti</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="kegiatanPPSBody">
                            <tr>
                                <td colspan="7" class="text-center">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer flex-center">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
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

// Function to filter by tahun kegiatan
function filterByTahun() {
    let tahun = $('#filterTahunKegiatan').val();
    let url = '{{ route("dokumen.index") }}';
    
    if (tahun) {
        url += '?tahun=' + tahun;
    }
    
    window.location.href = url;
}

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
    $('#filterBab, #filterStandar, #filterKriteria, #upload_elemen_penilaian, #upload_jenis_dokumen, #edit_jenis_dokumen').select2();

    // Load jenis dokumen on page load
    loadJenisDokumen();

    // Filter BAB change - cascade to Standar
    $('#filterBab').on('change', function() {
        let babId = $(this).val();
        let standarSelect = $('#filterStandar');
        
        if (babId) {
            standarSelect.find('option').each(function() {
                if ($(this).val() === '') return;
                if ($(this).data('bab') == babId) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        } else {
            standarSelect.find('option').show();
        }
        
        standarSelect.val('').trigger('change');
        $('#filterKriteria').val('').trigger('change');
    });

    // Filter Standar change - cascade to Kriteria
    $('#filterStandar').on('change', function() {
        let standarId = $(this).val();
        let kriteriaSelect = $('#filterKriteria');
        
        if (standarId) {
            kriteriaSelect.find('option').each(function() {
                if ($(this).val() === '') return;
                if ($(this).data('standar') == standarId) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        } else {
            kriteriaSelect.find('option').show();
        }
        
        kriteriaSelect.val('').trigger('change');
    });

    // Apply filter
    $('#applyFilter').on('click', function() {
        let bab = $('#filterBab').val();
        let standar = $('#filterStandar').val();
        let kriteria = $('#filterKriteria').val();
        let tahun = $('#filterTahunKegiatan').val();
        
        let url = '{{ route("dokumen.index") }}?';
        if (tahun) url += 'tahun=' + tahun + '&';
        if (bab) url += 'bab=' + bab + '&';
        if (standar) url += 'standar=' + standar + '&';
        if (kriteria) url += 'kriteria=' + kriteria;
        
        window.location.href = url;
    });

    // Reset filter
    $('#resetFilter').on('click', function() {
        window.location.href = '{{ route("dokumen.index") }}';
    });

    // Upload elemen penilaian change
    $('#upload_elemen_penilaian').on('change', function() {
        $('#upload_id_master_elemen_penilaian').val($(this).val());
    });

    // Form upload submit
    $('#formUploadDokumen').on('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        let elemenId = $('#upload_elemen_penilaian').val() || $('#upload_id_master_elemen_penilaian').val();
        formData.set('id_master_elemen_penilaian', elemenId);
        
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
            url: '{{ route("dokumen.store") }}',
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
        let fileInput = $('#formEditDokumen input[name="file_dokumen"]')[0];
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
            url: '{{ url("dokumen/update") }}/' + dokumenId,
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

// Load jenis dokumen
function loadJenisDokumen() {
    $.ajax({
        url: '{{ route("dokumen.get-jenis-dokumen") }}',
        type: 'GET',
        success: function(response) {
            if (response.success) {
                let options = '<option value="">Pilih Jenis Dokumen</option>';
                response.data.forEach(function(item) {
                    options += `<option value="${item.id_jenis_dokumen}">${item.jenis_dokumen}</option>`;
                });
                $('#upload_jenis_dokumen, #edit_jenis_dokumen').html(options);
            }
        }
    });
}

// Open upload modal with elemen id
function openUploadModal(elemenId) {
    currentElemenId = elemenId;
    $('#upload_id_master_elemen_penilaian').val(elemenId);
    $('#upload_elemen_penilaian').val(elemenId).trigger('change');
    $('#modalUploadDokumen').modal('show');
}

// Show dokumen list
function showDokumen(elemenId) {
    currentElemenId = elemenId;
    $('#modalLihatDokumen').modal('show');
    
    $.ajax({
        url: '{{ url("dokumen/get-dokumen") }}/' + elemenId,
        type: 'GET',
        success: function(response) {
            if (response.success) {
                let html = '';
                if (response.data.length > 0) {
                    response.data.forEach(function(item, index) {
                        html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.jenis_dokumen?.jenis_dokumen || '-'}</td>
                                <td>${item.nama_dokumen}</td>
                                <td>${item.keterangan_dokumen || '-'}</td>
                                <td>
                                    <a href="{{ url('dokumen/download') }}/${item.id_akreditasi_dokumen}" class="btn btn-sm btn-light-primary">
                                        <i class="fa fa-download"></i> Download
                                    </a>
                                </td>
                                <td class="text-center">
                                    @if(auth()->user()->isPetugas() || auth()->user()->isSuperadmin())
                                    <button type="button" class="btn btn-sm btn-light-warning me-2" onclick="editDokumen(${item.id_akreditasi_dokumen})">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                    <button type="button" class="btn btn-sm btn-light-danger" onclick="deleteDokumen(${item.id_akreditasi_dokumen})">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
                                    @endif
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = '<tr><td colspan="6" class="text-center">Belum ada dokumen</td></tr>';
                }
                $('#dokumenListBody').html(html);
            }
        },
        error: function() {
            $('#dokumenListBody').html('<tr><td colspan="6" class="text-center text-danger">Gagal memuat data</td></tr>');
        }
    });
}

// Edit dokumen
function editDokumen(dokumenId) {
    $.ajax({
        url: '{{ url("dokumen/get-dokumen") }}/' + currentElemenId,
        type: 'GET',
        success: function(response) {
            if (response.success) {
                let dokumen = response.data.find(item => item.id_akreditasi_dokumen == dokumenId);
                if (dokumen) {
                    $('#edit_id_dokumen').val(dokumen.id_akreditasi_dokumen);
                    $('#edit_jenis_dokumen').val(dokumen.id_jenis_dokumen).trigger('change');
                    $('#edit_nama_dokumen').val(dokumen.nama_dokumen);
                    $('#edit_keterangan_dokumen').val(dokumen.keterangan_dokumen);
                    $('#current_file_info').html(`<small class="text-muted">File saat ini: ${dokumen.file_dokumen}</small>`);
                    
                    $('#modalLihatDokumen').modal('hide');
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
                url: '{{ url("dokumen/destroy") }}/' + dokumenId,
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
                            showDokumen(currentElemenId);
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

// Toggle required rekomendasi based on nilai
function toggleRekomendasi() {
    let nilai = $('input[name="nilai"]:checked').val();
    let rekomendasiField = $('#penilaian_rekomendasi');
    let rekomendasiLabel = $('#labelRekomendasi');
    let rekomendasiHint = $('#rekomendasiHint');
    
    if (nilai == '0' || nilai == '5') {
        // Rekomendasi wajib
        rekomendasiField.attr('required', true);
        rekomendasiLabel.html('Rekomendasi <span class="text-danger">*</span>');
        rekomendasiHint.removeClass('d-none');
    } else {
        // Rekomendasi optional
        rekomendasiField.attr('required', false);
        rekomendasiLabel.html('Rekomendasi');
        rekomendasiHint.addClass('d-none');
    }
}

// Open penilaian modal
function openPenilaianModal(idElemen) {
    $('#penilaian_id_elemen').val(idElemen);
    
    // Load existing data jika ada
    $.ajax({
        url: '{{ url("penilaian/get") }}/' + idElemen,
        type: 'GET',
        success: function(response) {
            if (response.success && response.data) {
                // Fill form dengan data existing
                $('input[name="nilai"][value="' + response.data.nilai + '"]').prop('checked', true);
                $('#penilaian_fakta').val(response.data.fakta_analisis);
                $('#penilaian_rekomendasi').val(response.data.rekomendasi);
                toggleRekomendasi();
            } else {
                // Reset form untuk data baru
                $('#formPenilaian')[0].reset();
            }
        },
        error: function() {
            // Reset form jika error
            $('#formPenilaian')[0].reset();
        }
    });
    
    $('#modalPenilaian').modal('show');
}

// Submit penilaian form
$('#formPenilaian').on('submit', function(e) {
    e.preventDefault();
    
    let formData = $(this).serialize();
    
    $.ajax({
        url: '{{ url("penilaian/store") }}',
        type: 'POST',
        data: formData,
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
                    $('#modalPenilaian').modal('hide');
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

// Open perbaikan modal
function openPerbaikanModal(idElemen) {
    $('#perbaikan_id_elemen').val(idElemen);
    
    // Load existing data jika ada
    $.ajax({
        url: '{{ url("perbaikan/get") }}/' + idElemen,
        type: 'GET',
        success: function(response) {
            if (response.success && response.data) {
                // Fill form dengan data existing
                $('#perbaikan_rencana').val(response.data.rencana_perbaikan);
                $('#perbaikan_indikator').val(response.data.indikator_pencapaian);
                $('#perbaikan_sasaran').val(response.data.sasaran);
                $('#perbaikan_waktu').val(response.data.waktu_penyelesaian);
                $('#perbaikan_dana').val(response.data.sumber_dana);
                $('#perbaikan_pj').val(response.data.penanggung_jawab);
            } else {
                // Reset form untuk data baru
                $('#formPerbaikan')[0].reset();
            }
        },
        error: function() {
            // Reset form jika error
            $('#formPerbaikan')[0].reset();
        }
    });
    
    $('#modalPerbaikan').modal('show');
}

// Submit perbaikan form
$('#formPerbaikan').on('submit', function(e) {
    e.preventDefault();
    
    let formData = $(this).serialize();
    
    $.ajax({
        url: '{{ url("perbaikan/store") }}',
        type: 'POST',
        data: formData,
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
                    $('#modalPerbaikan').modal('hide');
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

let currentPerbaikanId = null;
let currentElemenIdPPS = null;

// Show detail PPS modal
function showDetailPPS(idPerbaikan, idElemen) {
    currentPerbaikanId = idPerbaikan;
    currentElemenIdPPS = idElemen;
    
    $('#kegiatan_id_perbaikan').val(idPerbaikan);
    $('#kegiatan_id_elemen').val(idElemen);
    
    // Load kegiatan list
    loadKegiatanPPS(idPerbaikan);
    
    $('#modalDetailPPS').modal('show');
}

// Load kegiatan PPS list
function loadKegiatanPPS(idPerbaikan) {
    $.ajax({
        url: '{{ url("perbaikan/kegiatan") }}/' + idPerbaikan,
        type: 'GET',
        success: function(response) {
            if (response.success) {
                let html = '';
                if (response.data.length > 0) {
                    response.data.forEach(function(item, index) {
                        let triwulanLabel = '';
                        switch(item.periode_pelaporan) {
                            case '1': triwulanLabel = 'Triwulan 1 (Jan-Mar)'; break;
                            case '2': triwulanLabel = 'Triwulan 2 (Apr-Jun)'; break;
                            case '3': triwulanLabel = 'Triwulan 3 (Jul-Sep)'; break;
                            case '4': triwulanLabel = 'Triwulan 4 (Okt-Des)'; break;
                        }
                        
                        let statusBadge = item.status_kegiatan == 'sudah' 
                            ? '<span class="badge badge-light-success">Sudah Selesai</span>'
                            : '<span class="badge badge-light-warning">Belum Selesai</span>';
                        
                        let linkBukti = item.link_bukti 
                            ? '<a href="' + item.link_bukti + '" target="_blank" class="btn btn-sm btn-light-primary">Lihat</a>'
                            : '-';
                        
                        html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${item.tahun_pelaporan}</td>
                                <td>${triwulanLabel}</td>
                                <td>${item.kegiatan}</td>
                                <td>${statusBadge}</td>
                                <td>${linkBukti}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-light-warning me-2" onclick="editKegiatanPPS(${item.id_akreditasi_perbaikan_kegiatan})">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-light-danger" onclick="deleteKegiatanPPS(${item.id_akreditasi_perbaikan_kegiatan})">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    html = '<tr><td colspan="7" class="text-center">Belum ada kegiatan</td></tr>';
                }
                $('#kegiatanPPSBody').html(html);
            }
        },
        error: function() {
            $('#kegiatanPPSBody').html('<tr><td colspan="7" class="text-center text-danger">Gagal memuat data</td></tr>');
        }
    });
}

// Show form tambah kegiatan
function showFormKegiatanPPS() {
    $('#formKegiatanPPS')[0].reset();
    $('#kegiatan_id').val('');
    $('#formKegiatanPPSContainer').slideDown();
}

// Hide form kegiatan
function hideFormKegiatanPPS() {
    $('#formKegiatanPPSContainer').slideUp();
    $('#formKegiatanPPS')[0].reset();
}

// Submit form kegiatan PPS
$('#formKegiatanPPS').on('submit', function(e) {
    e.preventDefault();
    
    let formData = $(this).serialize();
    let kegiatanId = $('#kegiatan_id').val();
    let url = kegiatanId ? '/perbaikan/kegiatan/update/' + kegiatanId : '/perbaikan/kegiatan/store';
    
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    hideFormKegiatanPPS();
                    loadKegiatanPPS(currentPerbaikanId);
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
        }
    });
});

// Edit kegiatan PPS
function editKegiatanPPS(id) {
    // Get data kegiatan
    $.ajax({
        url: '{{ url("perbaikan/kegiatan") }}/' + currentPerbaikanId,
        type: 'GET',
        success: function(response) {
            if (response.success) {
                let kegiatan = response.data.find(item => item.id_akreditasi_perbaikan_kegiatan == id);
                if (kegiatan) {
                    // Fill form
                    $('#kegiatan_id').val(kegiatan.id_akreditasi_perbaikan_kegiatan);
                    $('#kegiatan_tahun').val(kegiatan.tahun_pelaporan);
                    $('#kegiatan_periode').val(kegiatan.periode_pelaporan);
                    $('#kegiatan_desc').val(kegiatan.kegiatan);
                    $('#kegiatan_status').val(kegiatan.status_kegiatan);
                    $('#kegiatan_link').val(kegiatan.link_bukti);
                    
                    // Show form
                    $('#formKegiatanPPSContainer').slideDown();
                }
            }
        }
    });
}

// Delete kegiatan PPS
function deleteKegiatanPPS(id) {
    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah Anda yakin ingin menghapus kegiatan ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ url("perbaikan/kegiatan/delete") }}/' + id,
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
                            loadKegiatanPPS(currentPerbaikanId);
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