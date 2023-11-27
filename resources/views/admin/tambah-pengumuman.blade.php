@include('admin.modular.header')
<h1>Tambah Pengumuman</h1>
<hr>
<form method="POST" >
@csrf
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Judul Pengumuman</label>
  <input type="text" class="form-control" name="title">
</div>
<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Isi Pengumuman</label>
  <textarea class="form-control" name="content" rows="3"></textarea>
</div>
<button type="submit" class="btn btn-primary">Submit</button>
</form>

    @include('admin.modular.footer')