<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabungan Berjangka</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0px;
        padding: 0px;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background-color: #f3b4e0ff;
    }

    .container {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 650px;
    }
h2 {
            text-align: center;
            color: #ff009dff;
            margin-bottom: 30px;
            border-bottom: 2px solid #ff009dff;
            padding-bottom: 10px;
        }
        
        h3 {
            color: #333;
            margin-top: 25px;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 1px dashed #ccc;
        }

        label {
            font-weight: 600;
            display: block;
            margin-top: 10px;
            color: #495057;
        }

        input[type="number"],
        select {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            margin-top: 5px;
            border-radius: 8px;
            border: 1px solid #ced4da;
            box-sizing: border-box;
            background-color: #f8f9fa;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background: #e43d83ff; 
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #d63573ff;
        }

        .result {
            margin-top: 30px;
            padding: 20px;
            background: #f7dfeaff; 
            border: 1px solid #e74c9aff;
            border-radius: 10px;
        }

        .result p {
            font-size: 16px;
            color: #333;
            line-height: 1.6;
            margin: 5px 0;
        }

        .result .bold {
            font-weight: bold;
            color: #ff008cff;
        }
        
        .summary-info {
            background-color: #f7e9f1ff;
            border: 1px solid #e65498ff;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }
        
        .summary-info p .value {
            font-weight: bold;
            color: #e24091ff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            border: 1px solid #dee2e6;
            padding: 12px 8px;
            text-align: right; 
        }
        
        td:first-child, th:first-child {
            text-align: center; 
        }

        th {
            background-color: #ff008cff;
            color: white;
            font-weight: 700;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .result-intro p {
            font-size: 17px;
            color: #333;
            margin: 5px 0;
            line-height: 1.5;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>APLIKASI TABUNGAN BERJANGKA</h2>
        <form method="post">
            <label for="target">Target Tabungan (Rp.) :</label>
            <input type="number" name="target" id="target" placeholder="Contoh: 1000000" required>

            <label for="mode">Silahkan Pilih Metode Perhitungan</label>
            <select name="mode" id="mode" required>
                <option value="bulan">Target Bulan</option>
                <option value="setoran">Jumlah Setoran Tetap</option>
            </select>

            <label for="nilai">Masukkan Bulan atau Setoran Tetap :</label>
            <input type="number" name="nilai" id="nilai" placeholder="Contoh: 5 (untuk bulan) atau 200000 (untuk setoran)" required>
            <input type="hidden" name="admin" value="12500">
            <button type="submit" name="hitung">Hitung Tabungan</button>
        </form>

        <?php
        if (isset($_POST['hitung'])) {
            $target = $_POST['target'];
            $mode   = $_POST['mode'];
            $nilai  = $_POST['nilai'];
            $bunga  = 0.0335; 
            $admin  = 12500;  

            echo "<div class='result'>";
            echo "<h3>Hasil Perhitungan</h3>";

            if ($mode == "bulan") {
                $bulan = $nilai;
                $setoran = round($target / $bulan); 

                echo "<div class='result-intro'>";
                echo "<p><span class='bold'>Setoran per bulan:</span> Rp " . number_format($setoran, 0, ',', '.') . "</p>";
                echo "<p><span class='bold'>Total tabungan yang diinginkan:</span> Rp " . number_format($target, 0, ',', '.') . " dalam $bulan bulan.</p>";
                echo "</div>";
                
                $saldo = 0;
                $total_bunga = 0;
                $total_admin = 0;

                echo "<table>
                        <tr>
                            <th>Bulan</th>
                            <th>Setoran</th>
                            <th>Bunga</th>
                            <th>Biaya Admin</th>
                            <th>Saldo Akhir</th>
                        </tr>";

                for ($i = 1; $i <= $bulan; $i++) {
                    $saldo_awal = $saldo;
                    $bunga_bulan = 0;
                    $admin_bulan = 0;
                    $saldo += $setoran; 
                    
                    if ($i > 1) {
                        $bunga_bulan = $saldo_awal * $bunga;
                        $total_bunga += $bunga_bulan;
                        $saldo += $bunga_bulan;
                        $admin_bulan = $admin;
                        $saldo -= $admin_bulan; 
                        $total_admin += $admin_bulan;
                    }

                    echo "<tr>
                            <td>$i</td>
                            <td>Rp " . number_format($setoran, 0, ',', '.') . "</td>
                            <td>Rp " . number_format(round($bunga_bulan), 0, ',', '.') . "</td>
                            <td>Rp " . number_format(round($admin_bulan), 0, ',', '.') . "</td>
                            <td>Rp " . number_format(round($saldo), 0, ',', '.') . "</td>
                        </tr>";
                }

                echo "</table>";
                echo "<div class='summary-info'>";
                echo "<p>Total saldo akhir setelah <span class='value'>$bulan bulan</span>: <span class='value'>Rp " . number_format(round($saldo), 0, ',', '.') . "</span></p>";
                echo "<p>Total bunga yang didapat: <span class='value'>Rp " . number_format(round($total_bunga), 0, ',', '.') . "</span></p>";
                echo "<p>Total biaya admin yang dipotong: <span class='value'>Rp " . number_format(round($total_admin), 0, ',', '.') . "</span></p>";
                echo "</div>";
            }
            else if ($mode == "setoran") {
                $setoran = $nilai;
                $saldo = 0;
                $bulan = 0;
                $total_bunga = 0;
                $total_admin = 0;

                echo "<div class='result-intro'>";
                echo "<p><span class='bold'>Setoran per bulan:</span> Rp " . number_format($setoran, 0, ',', '.') . "</p>";
                echo "<p><span class='bold'>Target tabungan yang diinginkan:</span> Rp " . number_format($target, 0, ',', '.') . "</p>";
                echo "</div>";

                echo "<table>
                        <tr>
                            <th>Bulan</th>
                            <th>Setoran</th>
                            <th>Bunga</th>
                            <th>Biaya Admin</th>
                            <th>Saldo Akhir</th>
                        </tr>";

                while ($saldo < $target || $bulan < 1) { 
                    $bulan++;
                    $saldo_awal = $saldo;
                    $bunga_bulan = 0;
                    $admin_bulan = 0;
                    $saldo += $setoran; 

                    if ($bulan > 1) {
                        $bunga_bulan = $saldo_awal * $bunga;
                        $total_bunga += $bunga_bulan;
                        $saldo += $bunga_bulan;
                        $admin_bulan = $admin;
                        $saldo -= $admin_bulan; 
                        $total_admin += $admin_bulan;
                    }
                    
                    echo "<tr>
                            <td>$bulan</td>
                            <td>Rp " . number_format($setoran, 0, ',', '.') . "</td>
                            <td>Rp " . number_format(round($bunga_bulan), 0, ',', '.') . "</td>
                            <td>Rp " . number_format(round($admin_bulan), 0, ',', '.') . "</td>
                            <td>Rp " . number_format(round($saldo), 0, ',', '.') . "</td>
                        </tr>";
                }

                echo "</table>";
                echo "<div class='summary-info'>";
                echo "<p><span class='bold'>Target Rp " . number_format($target, 0, ',', '.') . " tercapai dalam <span class='value'>$bulan bulan</span>.</span></p>";
                echo "<p>Total saldo akhir setelah <span class='value'>$bulan bulan</span>: <span class='value'>Rp " . number_format(round($saldo), 0, ',', '.') . "</span></p>";
                echo "<p>Total bunga yang didapat: <span class='value'>Rp " . number_format(round($total_bunga), 0, ',', '.') . "</span></p>";
                echo "<p>Total biaya admin yang dipotong: <span class='value'>Rp " . number_format(round($total_admin), 0, ',', '.') . "</span></p>";
                echo "</div>";
            }
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>