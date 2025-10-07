<!DOCTYPE html>
<html>
<head>
    <title>Form Biodata</title>
</head>
<body>
    <h2>Input Biodata</h2>
    <form action="/proses" method="post">
        @csrf
        <label>Nama:</label><br>
        <input type="text" name="nama"><br>
        <label>Umur:</label><br>
        <input type="text" name="umur"><br>
        <label>Alamat:</label><br>
        <input type="text" name="alamat"><br>
        <button type="submit">Kirim</button>
    </form>
</body>
</html>