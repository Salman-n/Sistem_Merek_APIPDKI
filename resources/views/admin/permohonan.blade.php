@include('admin.modular.header')
<h1>Permohonan Merek</h1>
<hr>
<div class="table-responsive">
    <table id="datatable" class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Usaha</th>
                <th>Alamat Usaha</th>
                <th>Pemilik Usaha</th>
                <th>Lampiran</th>
                <th>Similaritas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permohonans as $permohonan)
            <tr>
                <td>{{$permohonan->id}}</td>
                <td>{{$permohonan->nama_usaha}}</td>
                <td>{{$permohonan->alamat_usaha}}</td>
                <td>{{$permohonan->pemilik_usaha}}</td>
                <td>
                    <img class="open-in-new-tab" src="{{$permohonan->logo}}" style="width:100px"></img>
                    @if ($permohonan->umk != null)
                    <img class="open-in-new-tab" src="{{$permohonan->umk}}" style="width:100px"></img>
                    @endif
                    <img class="open-in-new-tab" src="{{$permohonan->ttd}}" style="width:100px"></img>
                </td>
                <td>
                    <b>{{$permohonan->similaritas}}%</b>
                    - {{$permohonan->similaritas_merek}}
                </td>
                <td>
                    <a onclick="showalert('terima',{{$permohonan->id}},{{$permohonan->similaritas}})"><button class="btn btn-success">Terima</button></a>
                    <a onclick="showalert('perbaiki',{{$permohonan->id}})"><button class="btn btn-warning">Perbaiki</button></a>

                    <a onclick="showalert('tolak',{{$permohonan->id}})"><button class="btn btn-danger">Tolak</button></a>

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

        var images = document.querySelectorAll('.open-in-new-tab');

        // Add a click event listener to each image
        images.forEach(function(image) {
            image.addEventListener('click', function() {
                // Create a new window or tab with the base64 image data
                var newTab = window.open();
                newTab.document.write('<img src="' + this.src + '" alt="Base64 Image">');
            });
        });
    });

    function showalert(type, id, sim = 0) {
        if (type == "terima") {
            typemsg = "menerima";
        } else if (type == "tolak") {
            typemsg = "menolak"
        } else if (type == "perbaiki") {
            typemsg = "meminta perbaikan"
        }
        var simMsg = "";
        if (sim >= 65) {
            simMsg = "Merek ini memiliki similaritas diatas 65%"
        }

        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Untuk " + typemsg + " permohonan merek. aksi ini tidak dapat dikembalikan . " + simMsg,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: type,
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {

                window.location.href = "/admin/permohonan/" + type + "/" + id;
            }
        })
    }
</script>
@include('admin.modular.footer')