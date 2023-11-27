@include('modular.header')
@include('modular.navbar')
<div class="container">
    <h3>Ubah Permohonan Merek</h3>
    <form action="{{ route('edit') }}" method="POST" enctype="multipart/form-data">
    
    @csrf
    <input type="hidden" name="permohonan_id" value="{{$permohonan->id}}"></input>
    <div class="row">
        <div class="form-group col-12 col-md-6">
            <label for="nama_usaha">Nama Usaha</label>
            <input disabled value="{{$permohonan->nama_usaha}}" type="text" class="form-control" id="nama_usaha" name="nama_usaha" required>
        </div>
        <div class="form-group col-12 col-md-6">
            <label for="alamat_usaha">Alamat Usaha</label>
            <input value="{{$permohonan->alamat_usaha}}" type="text" class="form-control" id="alamat_usaha" name="alamat_usaha" required>
        </div>
        <div class="form-group col-12 col-md-6">
            <label for="pemilik_usaha">Pemilik Usaha</label>
            <input value="{{$permohonan->pemilik_usaha}}" type="text" class="form-control" id="pemilik_usaha" name="pemilik_usaha" required>
        </div>
        <div class="form-group col-12 col-md-6">
            <label for="logo">Logo</label>
            <br>
            <img src="{{$permohonan->logo}}" style="max-width:250px" class="w-100">
            <input type="file" class="form-control form-control-file" id="logo" name="logo">
        </div>
        <div class="form-group col-12 col-md-6">
            <label for="umk">Surat UMK (optional)</label>
            @if ($permohonan->umk != null)
            <br>
            <img src="{{$permohonan->umk}}"  style="max-width:250px"  class="w-100">
            @endif
            <input type="file" class="form-control form-control-file" id="umk" name="umk">
        </div>
        <div class="form-group col-12 col-md-6">
            <label for="ttd">Tanda Tangan</label><br>
            <img src="{{$permohonan->ttd}}"  style="max-width:250px"  class="w-100">
            <input type="file" class="form-control form-control-file" id="ttd" name="ttd">
        </div>
</div>
<br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@include('modular.footer')