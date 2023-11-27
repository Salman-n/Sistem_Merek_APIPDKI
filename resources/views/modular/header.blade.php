<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem Merek</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
  <link rel="stylesheet" href="https://unpkg.com/blocks.css/dist/blocks.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Asap&family=Comme:wght@200;400;500&family=IBM+Plex+Sans+Condensed&family=Kanit:wght@300&family=Silkscreen&display=swap" rel="stylesheet">
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>

  <style>
    .container {
      margin: 95px auto;
    }
    body{
      font-family: 'Asap', sans-serif;}
    .bg-custom{
      background-color: #002d80;
    }
    .custom-margin{
      margin-right: 45px;
    }
    .img-fluid{
      width: 99px; height: 45px;
    }
  </style>
</head>