<!DOCTYPE html>
<html>
<head>
    <title>Tambah User</title>
</head>
<body>
    <h1>Form Tambah Data User</h1>

    <!-- Menampilkan error jika ada -->
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/user/tambah_simpan">
        @csrf

        <label>Username</label>
        <input type="text" name="username" placeholder="Masukkan Username">
        <br>

        <label>Nama</label>
        <input type="text" name="nama" placeholder="Masukkan Nama">
        <br>

        <label>Password</label>
        <input type="password" name="password" placeholder="Masukkan Password">
        <br>

        <label>Level ID</label>
        <input type="number" name="level_id" placeholder="Masukkan ID Level">
        <br><br>

        <input type="submit" value="Simpan">
    </form>
</body>
</html>
