<!DOCTYPE html>
<html>
<head>
    <title>Tambah User</title>
</head>
<body>
    <h1>Form Tambah Data User</h1>

    <form method="POST" action="{{ route('user.tambah_simpan') }}">
        @csrf
    
        <label>Username</label>
        <input type="text" name="username" value="{{ old('username') }}" placeholder="Masukan Username">
        <br>
    
        <label>Nama</label>
        <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukan Nama">
        <br>
    
        <label>Password</label>
        <input type="password" name="password" placeholder="Masukan Password">
        <br>
    
        <label>Level ID</label>
        <input type="number" name="level_id" value="{{ old('level_id') }}" placeholder="Masukan ID Level">
        <br><br>
    
        <input type="submit" class="btn btn-success" value="Simpan">
    </form>
    
</body>
</html>
