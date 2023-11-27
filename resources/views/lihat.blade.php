@include('modular.header')
@include('modular.navbar')
<div class="container">
    <h3>Detail Permohonan Merek</h3>
    
    <div class="row">
        <div class="form-group col-12 col-md-6">
            <label for="nama_usaha">Nama Usaha</label>
            <input disabled value="{{$permohonan->nama_usaha}}" type="text" class="form-control" id="nama_usaha" name="nama_usaha" required>
        </div>
        <div class="form-group col-12 col-md-6">
            <label for="alamat_usaha">Alamat Usaha</label>
            <input disabled  value="{{$permohonan->alamat_usaha}}" type="text" class="form-control" id="alamat_usaha" name="alamat_usaha" required>
        </div>
        <div class="form-group col-12 col-md-6">
            <label for="pemilik_usaha">Pemilik Usaha</label>
            <input disabled  value="{{$permohonan->pemilik_usaha}}" type="text" class="form-control" id="pemilik_usaha" name="pemilik_usaha" required>
        </div>
        <div class="form-group col-12 col-md-6">
            <label for="logo">Logo</label>
            <br>
            <img src="{{$permohonan->logo}}" style="max-width:250px" class="w-100">
        </div>
        <div class="form-group col-12 col-md-6">
            <label for="umk">Surat UMK (optional)</label>
            @if ($permohonan->umk != null)
            <br>
            <img src="{{$permohonan->umk}}"  style="max-width:250px"  class="w-100">
            @endif
        </div>
        <div class="form-group col-12 col-md-6">
            <label for="ttd">Tanda Tangan</label><br>
            <img src="{{$permohonan->ttd}}"  style="max-width:250px"  class="w-100">
        </div>
</div>
<br>
</div>
@include('modular.footer')