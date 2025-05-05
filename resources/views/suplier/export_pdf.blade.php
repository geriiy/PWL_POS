<!DOCTYPE html>
<html>
<head>
    <title>Export Data Suplier</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h3>Data Suplier</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Suplier</th>
                <th>Alamat</th>
                <th>Tanggal Input</th>
            </tr>
        </thead>
        <tbody>
            @foreach($supliers as $suplier)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $suplier->supplier_nama }}</td>
                    <td>{{ $suplier->supplier_alamat }}</td>
                    <td>{{ $suplier->created_at ? $suplier->created_at->format('Y-m-d H:i:s') : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
