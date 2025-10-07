<!DOCTYPE html>
<html>
<head>
  <title>Hasil Booking</title>
  <style>
    body{background:#fff;color:#333;font-family:Arial;text-align:center}
    table{
      margin:30px auto;
      border-collapse:collapse;
      width:80%;
      box-shadow:0 0 5px #ddd;
      border-radius:10px;
      overflow:hidden; /* penting agar radius berlaku */
    }
    th{
      background:#f44336;
      color:white;
      padding:10px;
    }
    td{
      padding:8px;
      border-bottom:1px solid #eee;
    }
    tr:nth-child(even){background:#f9f9f9}
    a{
      background:#f44336;
      color:white;
      padding:7px 14px;
      border-radius:5px;
      text-decoration:none;
      margin:6px;
      display:inline-block;
    }
    a:hover{background:#d32f2f}
  </style>
</head>
<body>
  <h2 style="color:#f44336">Daftar Booking Psikolog</h2>
  <table>
    <tr><th>No</th><th>Nama</th><th>Usia</th><th>Jurusan</th><th>Psikolog</th></tr>
    @foreach($bookings as $i=>$b)
    <tr>
      <td>{{ $i+1 }}</td>
      <td>{{ $b['nama'] }}</td>
      <td>{{ $b['usia'] }}</td>
      <td>{{ $b['jurusan'] }}</td>
      <td>{{ $b['psikolog'] }}</td>
    </tr>
    @endforeach
  </table>

  <a href="/booking">Tambah Lagi</a>
  <a href="/booking/reset">Hapus Semua</a>
</body>
</html>
