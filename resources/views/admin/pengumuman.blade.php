@include('admin.modular.header')
<h1>Pengumuman</h1>
<a href="/admin/pengumuman/tambah"><button class="btn btn-primary">Tambah</button></a>
<hr>
<table id="datatable" class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Judul Pengumuman</th>
                <th>Isi</th>
                <th>Tanggal dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengumumans as $pengumuman)
            <tr>
            <td>{{$pengumuman->id}}</td>   
            <td>{{$pengumuman->title}}</td>
            <td>{{$pengumuman->content}}</td>
               <td>{{$pengumuman->created_at}}</td>
               <td>
                <a href="/admin/pengumuman/delete/{{$pengumuman->id}}"><button class="btn btn-danger">Hapus</button></a>
                
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
        new DataTable('#datatable', {
            order: [[0, 'desc']]
        });
});
    </script>
    @include('admin.modular.footer')