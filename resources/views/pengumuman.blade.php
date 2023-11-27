@include('modular.header')
@include('modular.navbar')
<div class="container">

@foreach ($pengumumans as $pengumuman)
<div class="card" >
  <div class="card-body">
    <h5 class="card-title">{{$pengumuman->title}}</h5>
    <h6 class="card-subtitle mb-2 text-body-secondary">{{$pengumuman->created_at}}</h6>
    <p class="card-text">{{$pengumuman->content}}</p>
  </div>
</div>
<br>
@endforeach

</div>
<script>
    // document ready
  
    $(document).ready(function(){
});
    </script>

@include('modular.footer')