@extends('layouts.main')

@push('style-internal')
    <link rel="stylesheet" href="/template/libs/select2/css/select2.min.css">
    <link rel="stylesheet" href="/template/libs/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endpush

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Kartu Tanda Penduduk</h1>
                </div>
                <div class="col-sm-6">
                    {{-- <a href="{{ route('identify-card.create') }}" class="float-lg-right btn btn-primary btn-sm"><i class="fas fa-plus"></i> KTP baru</a> --}}
                </div>
              </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Form Kartu Tanda Penduduk</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('identify-card.update', $identify_card->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">NIK</label>
                                            <input type="text" name="nik" id="nik" class="form-control" readonly value="{{ $identify_card->nik }}">
                                            <input type="hidden" id="code_district" value="{{ substr($identify_card->nik, 0, 6) }}">
                                            <input type="hidden" id="code_date" value="{{ substr($identify_card->nik, 6, -4) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Nama</label>
                                            <input type="text" name="nama" id="nama" class="form-control" required value="{{ $identify_card->nama }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Tempat Lahir</label>
                                            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required value="{{ $identify_card->tempat_lahir }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Tanggal Lahir</label>
                                            <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control" required value="{{ $identify_card->tgl_lahir }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Jenis Kelamin</label>
                                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required value="{{ $identify_card->nik }}">
                                                <option value=""></option>
                                                <option value="laki-laki" {{ $identify_card->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>laki-laki</option>
                                                <option value="perempuan" {{ $identify_card->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Provinsi</label>
                                            <select name="provinsi" id="provinsi" class="form-control" required data-placeholder="--Silahkan pilih provinsi--">
                                                <option></option>
                                                @foreach ($provinces as $province)
                                                    <option value="{{ $province->id }}" {{ $identify_card->provinsi == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Kabupaten/Kota</label>
                                            <select name="kabupaten" id="kabupaten" class="form-control" required data-placeholder="--Silahkan pilih Kabupaten/Kota--">
                                                <option value=""></option>
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}" {{ $identify_card->kabupaten == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Kecamatan</label>
                                            <select name="kecamatan" id="kecamatan" class="form-control" required data-placeholder="--Silahkan pilih kecamatan--">
                                                <option value=""></option>
                                                @foreach ($districts as $district)
                                                    <option value="{{ $district->id }}" {{ $identify_card->kecamatan == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Desa / Kelurahan</label>
                                            <input type="text" name="desa" id="desa" class="form-control" required value="{{ $identify_card->desa }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Alamat</label>
                                            <textarea name="alamat" id="alamat" class="form-control" required>{{ $identify_card->alamat }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">RT</label>
                                            <input type="text" name="rt" id="rt" class="form-control" required value="{{ $identify_card->rt }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">RW</label>
                                            <input type="text" name="rw" id="rw" class="form-control" required value="{{ $identify_card->rw }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Agama</label>
                                            <select name="agama" id="agama" class="form-control" required>
                                                <option value=""></option>
                                                @for ($i = 0; $i < count($agama); $i++)
                                                    <option value="{{ $agama[$i] }}" {{ $identify_card->agama == $agama[$i] ? 'selected' : '' }}>{{ $agama[$i] }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Status Perkawinan</label>
                                            <select name="status_perkawinan" id="agama" class="form-control" required>
                                                <option value=""></option>
                                                @for ($i = 0; $i < count($status_perkawinan); $i++)
                                                    <option value="{{ $status_perkawinan[$i] }}" {{ $identify_card->status_perkawinan == $status_perkawinan[$i] ? 'selected' : '' }}>{{ $status_perkawinan[$i] }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Pekerjaan</label>
                                            <select name="pekerjaan" id="pekerjaan" class="form-control" required data-placeholder="--Silahkan pilih pekerjaan--">
                                                <option value=""></option>
                                                @foreach ($pekerjaan as $item)
                                                    <option value="{{ $item->name }}" {{ $identify_card->pekerjaan == $item->name ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Kewarganegaraan</label>
                                            <select name="kewarganegaraan" id="kewarganegaraan" class="form-control" required>
                                                <option value=""></option>
                                                @for ($i = 0; $i < count($kewarganegaraan); $i++)
                                                    <option value="{{ $kewarganegaraan[$i] }}" {{ $identify_card->kewarganegaraan == $kewarganegaraan[$i] ? 'selected' : '' }}>{{ $kewarganegaraan[$i] }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Foto</label>
                                            <input type="file" name="foto" id="foto" class="form-control"> 
                                            <small class="text-danger">*silahkan isi jika ingin merubah/menambahkan foto</small>
                                        </div>
                                    </div>
                                    @if ($identify_card->foto)
                                        <div class="col-md-6">
                                            <img src="{{ url('storage/images/'.$identify_card->foto) }}" class="img-fluid mb-2" alt="white sample" width="100">
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection

@push('script-internal')
    <script src="/template/libs/select2/js/select2.full.min.js"></script>
    <script src="/template/js/identify-card.js"></script>
@endpush
