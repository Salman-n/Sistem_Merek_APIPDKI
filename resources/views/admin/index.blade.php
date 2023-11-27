@include('admin.modular.header')

<h1 class="wadmin">Selamat datang {{ Auth::guard("admin")->user()->name }}</h1>
<br>
<div class="row">

    <div class="col-12 col-md-6 col-lg-3 mb-4 custom-animation">
    <div class="center text-white rounded p-3 custom-gradient custom-shadow">
            <h1><b>{{ $pengguna }}</b></h1>
            Jumlah Semua Pengguna
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3 mb-4 custom-animation">
    <div class="center text-white rounded p-3 custom-gradient-1 custom-shadow">
            <h1><b>{{ $pemohon }}</b></h1>
            Jumlah Pemohon
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3 mb-4 custom-animation">
    <div class="center text-white rounded p-3 custom-gradient-2 custom-shadow">
            <h1><b>{{ $belumverif }}</b></h1>
            Jumlah Pengguna Belum Verifikasi
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3 mb-4 custom-animation">
    <div class="center text-white rounded p-3 custom-gradient-3 custom-shadow">
            <h1><b>{{ $admin }}</b></h1>
            Jumlah Admin
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3 mb-4 custom-animation">
    <div class="center text-white rounded p-3 custom-gradient-4 custom-shadow">
            <h1><b>{{ $pmerek }}</b></h1>
            Jumlah Permohonan
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3 mb-4 custom-animation">
    <div class="center text-white rounded p-3 custom-gradient-5 custom-shadow">
            <h1><b>{{ $pmerekterima }}</b></h1>
            Jumlah Merek Diterima
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3 mb-4 custom-animation">
    <div class="center text-white rounded p-3 custom-gradient-6 custom-shadow">
            <h1><b>{{ $pmerekproses }}</b></h1>
            Jumlah Permohonan merek dalam proses
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-3 mb-4 custom-animation">
    <div class="center text-white rounded p-3 custom-gradient-7 custom-shadow">
            <h1><b>{{ $pmerekperbaiki }}</b></h1>
            Jumlah permohonan merek perlu perbaikan
        </div>
    </div>

</div>

@include('admin.modular.footer')
