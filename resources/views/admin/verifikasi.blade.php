@include('admin.modular.header')
<h1>Verifikasi Pengguna</h1>
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
                    <a onclick="terima({{$user->id}})"><button class="btn btn-success">Terima</button></a>
                    <a onclick="tolak({{$user->id}})"><button class="btn btn-danger">Tolak</button></a>

                </td>


            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
<script>
    // document ready

    $(document).ready(function() {
        new DataTable('#datatable');
    });

    function terima(id) {

        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Untuk menerima pengguna ini. aksi ini tidak dapat dikembalikan",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Terima',
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {

                window.location.href = "/admin/verifikasi/terima/" + id;
            }
        })
    }


    function tolak(id) {

        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Untuk menolak pengguna ini. aksi ini tidak dapat dikembalikan",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Tolak',
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {

                window.location.href = "/admin/verifikasi/tolak/" + id;
            }
        })
    }
</script>
@include('admin.modular.footer')