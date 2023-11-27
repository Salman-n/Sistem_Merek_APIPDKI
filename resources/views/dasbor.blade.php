@include('modular.header')
@include('modular.navbar')
<div class="container">
    <h3>Dasbor</h3>
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
                </tr>
            </thead>
            <tbody>
                @foreach ($permohonans as $permohonan)
                <tr>
                    <td>{{$permohonan->id}}</td>
                    <td>{{$permohonan->nama_usaha}}</td>
                    <td>{{$permohonan->alamat_usaha}}</td>
                    <td>{{$permohonan->pemilik_usaha}}</td>
                    <td><img width="115" src="{{$permohonan->logo}}"></img></td>


                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    // document ready

    $(document).ready(function() {
        new DataTable('#permohonan');
    });
</script>

@include('modular.footer')