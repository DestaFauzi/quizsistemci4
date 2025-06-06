<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Kelas</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #4cc9f0;
            --border-radius: 8px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fb;
            color: var(--dark);
            line-height: 1.6;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 30px;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        h1 {
            color: var(--primary);
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }
        
        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        input[type="text"]:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }
        
        textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        button {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        
        button:hover {
            background-color: var(--secondary);
            transform: translateY(-2px);
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Buat Kelas Baru</h1>

        <form action="/guru/saveClass" method="POST">
            <div class="form-group">
                <label for="nama_kelas">Nama Kelas</label>
                <input type="text" name="nama_kelas" id="nama_kelas" required placeholder="Masukkan nama kelas">
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" required placeholder="Tambahkan deskripsi kelas"></textarea>
            </div>
            <div class="form-group">
                <label for="jumlah_level">Jumlah Level</label>
                <input type="text" name="jumlah_level" id="jumlah_level" required placeholder="Masukkan Jumlah Level">
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status">
                    <option value="aktif">Aktif</option>
                    <option value="non_aktif">Non-Aktif</option>
                </select>
            </div>

            <button type="submit">Buat Kelas</button>
        </form>
    </div>
</body>

</html>