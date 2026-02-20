@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('page_description', 'Dashboard')

@section('content')

<div class="row g-5 g-xl-8">
    
    <div class="col-xl-12">
        <div class="card card-xl-stretch mb-xl-8">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-60px me-5">
                        <span class="symbol-label bg-light-primary">
                            <span class="svg-icon svg-icon-1 svg-icon-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="black" />
                                    <rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="black" />
                                </svg>
                            </span>
                        </span>
                    </div>
                    <div class="flex-grow-1">
                        <h3 class="fw-bolder text-dark mb-1">Selamat Datang, {{ $user->nama_lengkap }}</h3>
                        <span class="text-muted fw-bold d-block">Level: {{ $user->level->level ?? '-' }}</span>
                        <span class="text-muted fw-bold d-block">{{ $user->instansi->instansi ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card card-xl-stretch mb-5 mb-xl-8" style="background: linear-gradient(to right, #f093fb 0%, #f5576c 100%);">
            <div class="card-body">
                <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="white" />
                        <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="white" />
                    </svg>
                </span>
                <div class="text-white fw-bolder fs-2 mb-2 mt-5">{{ $totalDokumen }}</div>
                <div class="fw-bold text-white">
                    Dokumen Terupload
                    @if($kegiatanAktif)
                    <div class="fs-8 opacity-75 mt-1">{{ $kegiatanAktif->nama_kegiatan }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card card-xl-stretch mb-xl-8" style="background: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);">
            <div class="card-body">
                <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M16.0173 9H15.3945C14.2833 9 13.263 9.61425 12.7431 10.5963L12.154 11.7091C12.0645 11.8781 12.1072 12.0868 12.2559 12.2071L12.6402 12.5183C13.2631 13.0225 13.7556 13.6691 14.0764 14.4035L14.2321 14.7601C14.2957 14.9058 14.4396 15 14.5987 15H18.6747C19.7297 15 20.4057 13.8774 19.912 12.945L18.6686 10.5963C18.1487 9.61425 17.1285 9 16.0173 9Z" fill="white" />
                        <rect opacity="0.3" x="14" y="4" width="4" height="4" rx="2" fill="white" />
                        <path d="M4.65486 14.8559C5.40389 13.1224 7.11161 12 9 12C10.8884 12 12.5961 13.1224 13.3451 14.8559L14.793 18.2067C15.3636 19.5271 14.3955 21 12.9571 21H5.04292C3.60453 21 2.63644 19.5271 3.20698 18.2067L4.65486 14.8559Z" fill="white" />
                        <rect opacity="0.3" x="6" y="5" width="6" height="6" rx="3" fill="white" />
                    </svg>
                </span>
                <div class="text-white fw-bolder fs-2 mb-2 mt-5">{{ $totalUsers }}</div>
                <div class="fw-bold text-white">Total Pengguna</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-xl-12">
        <div class="card card-xl-stretch mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder text-dark">Menu Cepat</span>
                    <span class="text-muted mt-1 fw-bold fs-7">Akses cepat ke fitur utama</span>
                </h3>
            </div>
            
            <div class="card-body pt-6">
                <div class="row g-5">
                    
                    <div class="col-md-6">
                        <a href="{{ route('dokumen.index') }}" class="card card-stretch border hover-elevate-up shadow-sm">
                            <div class="card-body d-flex align-items-center py-8">
                                <div class="symbol symbol-60px me-5">
                                    <span class="symbol-label bg-light-primary">
                                        <span class="svg-icon svg-icon-1 svg-icon-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z" fill="black" />
                                                <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black" />
                                            </svg>
                                        </span>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="text-gray-800 fw-bolder text-hover-primary fs-4 mb-1">Dokumen Internal</div>
                                    <div class="text-muted fw-bold">Kelola dan upload dokumen internal</div>
                                </div>
                                <span class="svg-icon svg-icon-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="black" />
                                    </svg>
                                </span>
                            </div>
                        </a>
                    </div>
                    
                    <div class="col-md-6">
                        <a href="{{ route('dokumen.index') }}" class="card card-stretch border hover-elevate-up shadow-sm">
                            <div class="card-body d-flex align-items-center py-8">
                                <div class="symbol symbol-60px me-5">
                                    <span class="symbol-label bg-light-primary">
                                        <span class="svg-icon svg-icon-1 svg-icon-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z" fill="black" />
                                                <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black" />
                                            </svg>
                                        </span>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="text-gray-800 fw-bolder text-hover-primary fs-4 mb-1">Dokumen Eksternal</div>
                                    <div class="text-muted fw-bold">Kelola dan upload dokumen eksternal</div>
                                </div>
                                <span class="svg-icon svg-icon-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="black" />
                                    </svg>
                                </span>
                            </div>
                        </a>
                    </div>

                    @if(auth()->user()->isSuperadmin())
                    <div class="col-md-6">
                        <a href="{{ route('master.elemen-penilaian.index') }}" class="card card-stretch border hover-elevate-up shadow-sm">
                            <div class="card-body d-flex align-items-center py-8">
                                <div class="symbol symbol-60px me-5">
                                    <span class="symbol-label bg-light-success">
                                        <span class="svg-icon svg-icon-1 svg-icon-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M21 10H13V11C13 11.6 12.6 12 12 12C11.4 12 11 11.6 11 11V10H3C2.4 10 2 10.4 2 11V13H22V11C22 10.4 21.6 10 21 10Z" fill="black" />
                                                <path opacity="0.3" d="M12 12C11.4 12 11 11.6 11 11V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V11C13 11.6 12.6 12 12 12Z" fill="black" />
                                                <path opacity="0.3" d="M18.1 21H5.9C5.4 21 4.9 20.6 4.8 20.1L3 13H21L19.2 20.1C19.1 20.6 18.6 21 18.1 21ZM13 18V15C13 14.4 12.6 14 12 14C11.4 14 11 14.4 11 15V18C11 18.6 11.4 19 12 19C12.6 19 13 18.6 13 18ZM17 18V15C17 14.4 16.6 14 16 14C15.4 14 15 14.4 15 15V18C15 18.6 15.4 19 16 19C16.6 19 17 18.6 17 18ZM9 18V15C9 14.4 8.6 14 8 14C7.4 14 7 14.4 7 15V18C7 18.6 7.4 19 8 19C8.6 19 9 18.6 9 18Z" fill="black" />
                                            </svg>
                                        </span>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="text-gray-800 fw-bolder text-hover-primary fs-4 mb-1">Master Elemen Penilaian</div>
                                    <div class="text-muted fw-bold">Kelola master data elemen penilaian</div>
                                </div>
                                <span class="svg-icon svg-icon-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="black" />
                                    </svg>
                                </span>
                            </div>
                        </a>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity or Information -->
    <div class="col-xl-12">
        <div class="card card-xl-stretch mb-xl-8">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder text-dark">Informasi</span>
                    <span class="text-muted mt-1 fw-bold fs-7">Informasi Dokumen Kontrol</span>
                </h3>
            </div>
            
            <div class="card-body pt-6">
                <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-6">
                    <span class="svg-icon svg-icon-2tx svg-icon-primary me-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black" />
                            <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="black" />
                            <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="black" />
                        </svg>
                    </span>
                    <div class="d-flex flex-stack flex-grow-1">
                        <div class="fw-bold">
                            <h4 class="text-gray-800 fw-bolder">Selamat Datang di Sistem Dokumen Kontrol</h4>
                            <div class="fs-6 text-gray-600">
                                Sistem ini digunakan untuk mengelola dokumen kontrol. 
                                @if(auth()->user()->isSuperadmin())
                                    Anda memiliki akses penuh untuk mengelola master data dan dokumen.
                                @elseif(auth()->user()->isPetugas())
                                    Anda dapat mengupload dan mengelola dokumen kontrol.
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    .hover-elevate-up:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
    }
</style>
@endpush

@push('scripts')
<script>
function filterDashboardByTahun() {
    let tahun = $('#filterTahunDashboard').val();
    let url = '{{ route("dashboard") }}';
    
    if (tahun) {
        url += '?tahun=' + tahun;
    }
    
    window.location.href = url;
}
</script>
@endpush