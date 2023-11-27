@include('modular.header')
@include('modular.navbar')
<div class="container">
    <h3>Detail Profil</h3>
    <form action="{{ route('editprofil') }}" method="POST" enctype="multipart/form-data">
    
    @csrf
    <div class="row">
        <div class="form-group col-12 col-md-6">
            <label >Nama</label>
            <input value="{{$user->name}}" type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group col-12 col-md-6">
            <label ">Jenis Kelamin</label>
            <input value="{{$user->gender}}" type="text" class="form-control" id="gender" name="gender" required>
        </div>
        <div class="form-group col-12 col-md-6">
            <label>Alamat</label>
            <input value="{{$user->address}}" type="text" class="form-control" id="address" name="address" required>
        </div>
</div>
<br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@include('modular.footer')