<body>
 <nav class="navbar navbar-expand-lg navbar-ligt bg-custom fixed-top">
    <div class="container-fluid">
    <a class="navbar-brand text-white" href="/">
    <img src="https://hki.uns.ac.id/assets/img/illustrations/logo_ki2.png" alt="img" class="img-fluid"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link text-white" href="/">Dasbor</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="/pengumuman">Pengumuman</a>
          </li>
          @if (Auth::check())
          <li class="nav-item">
            <a class="nav-link text-white" href="/permohonan">Permohonan</a>
          </li>
          @endif
        </ul>
        <ul class="navbar-nav ms-auto custom-margin">
    @if (Auth::check())
        <li class="nav-item dropdown position-relative custom-margin">
            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{Auth::user()->name}}
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                @if (Auth::user()->level == "admin")
                    <li><a class="dropdown-item" href="/admin">Admin</a></li>
                @endif
                <li><a class="dropdown-item" href="/editprofil">Profil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">Logout</button>
                    </form>
                </li>
            </ul>
        </li>
    @else 
        <li class="nav-item">
            <a class="nav-link block" href="/login">Masuk</a>
        </li>
        <li class="nav-item">
            <a class="nav-link block" href="/register">Daftar</a>
        </li>
    @endif
</ul>

      </div>
    </div>
 </nav>
</body>