@include('admin.modular.header')
<h1>Pemohon</h1>
<hr>
<div class="table-responsive">
<table id="datatable" class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Waktu Daftar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
            <td>{{$user->id}}</td>   
            <td>{{$user->name}}</td>
               <td>{{$user->email}}</td>
               <td>{{$user->created_at}}</td>
               <td>
                <a href="/admin/pemohon/delete/{{$user->id}}"><button class="btn btn-danger">Hapus</button></a>
                
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
        new DataTable('#datatable');
});
    </script>
    @include('admin.modular.footer')