<!DOCTYPE html>
<html>
<head>
  <title>TeluWell | Form Booking</title>
  <style>
    body{background:#fff;color:#333;font-family:Arial;text-align:center}
    form{background:#f9f9f9;display:inline-block;padding:25px 35px;border-radius:10px;margin-top:40px;box-shadow:0 0 5px #ddd}
    input,select{display:block;width:230px;padding:7px;margin:6px auto;border:1px solid #ccc;border-radius:5px}
    button{background:#f44336;color:#fff;border:none;padding:8px 15px;border-radius:5px;margin-top:12px;cursor:pointer}
    button:hover{background:#d32f2f}
  </style>
</head>
<body>
  <h2 style="color:#f44336">TeluWell – Form Booking Psikolog</h2>
  <form action="/booking/simpan" method="POST">
    @csrf
    <input type="text" name="nama" placeholder="Nama" required>
    <input type="number" name="usia" placeholder="Usia" required>
    <input type="text" name="jurusan" placeholder="Jurusan" required>
    <select name="psikolog" required>
      <option value="">-- Pilih Psikolog --</option>
      @foreach($psikologs as $p)<option>{{ $p }}</option>@endforeach
    </select>
    <button type="submit">Simpan</button>
  </form>
</body>
</html>
