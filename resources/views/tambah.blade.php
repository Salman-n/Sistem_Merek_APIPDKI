@include('modular.header')
@include('modular.navbar')
<div class="container">
    <h3>Tambah Permohonan Merek</h3>
    <form action="{{ route('tambah') }}" method="POST" enctype="multipart/form-data">
    
    @csrf
    <div class="row">
        <div class="form-group col-12 col-md-6">
            <label for="nama_usaha">Nama Usaha</label>
            <input type="text" class="form-control" id="nama_usaha" name="nama_usaha" required>
        </div>
        <div class="form-group col-12 col-md-6">
            <label for="alamat_usaha">Alamat Usaha</label>
            <input type="text" class="form-control" id="alamat_usaha" name="alamat_usaha" required>
        </div>
        <div class="form-group col-12 col-md-6">
            <label for="pemilik_usaha">Pemilik Usaha</label>
            <input type="text" class="form-control" id="pemilik_usaha" name="pemilik_usaha" required>
        </div>
        <div class="form-group col-12 col-md-6">
            <label for="logo">Logo</label>
            <input type="file" class="form-control form-control-file" required id="logo" name="logo">
        </div>
        <div class="form-group col-12 col-md-6">
            <label for="umk">Surat UMK (optional)</label>
            <input type="file" class="form-control form-control-file" id="umk" name="umk">
        </div>
        <div class="form-group col-12 col-md-6">
            <label for="ttd">Tanda Tangan</label>
            <input type="file" class="form-control form-control-file" required id="ttd" name="ttd">
        </div>
</div>
<br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@include('modular.footer')