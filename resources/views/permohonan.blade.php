@include('modular.header')
@include('modular.navbar')
<div class="container">
    <h3>Daftar Permohonan</h3>
    @if (!empty(session()->get('alert')))
    <div class="alert alert-{{ session()->get('alerttype') ?? 'success' }}" role="alert">
    {{ session()->get('alert') }}
</div>

@endif
    @if (Auth::check())
    
    <a href="/tambah"><button class="btn btn-primary">Tambah</button></a>
    @endif
<hr>
    <div class="table-responsive">
<table id="permohonan" class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Pemilik</th>
                <th>Logo</th>
                <th>similaritas</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permohonans as $permohonan)
            <tr>
            <td>{{$permohonan->id}}</td>   
            <td>{{$permohonan->nama_usaha}}</td>
               <td>{{$permohonan->alamat_usaha}}</td>
               <td>{{$permohonan->pemilik_usaha}}</td>
               <td><img width="200px" src="{{$permohonan->logo}}" ></img></td>
               <td>
    <b>{{$permohonan->similaritas}}%</b>
- {{$permohonan->similaritas_merek}}       
</td>
               <td>
                {{$permohonan->status}}
                <br>
                @if ($permohonan->status == "Perbaiki")
              
                <a href="/edit/{{$permohonan->id}}"><button class="btn btn-warning">Edit</button></a>
              
                @else 
                <a href="/lihat/{{$permohonan->id}}"><button class="btn btn-info">Lihat</button></a>
                @endif
               </td>
              
         
            </tr>
        @endforeach    
        </tbody>
    </table>
</div>
</div>
<script>
    // document ready
  
    $(document).ready(function(){
        new DataTable('#permohonan');
});
    </script>

@include('modular.footer')