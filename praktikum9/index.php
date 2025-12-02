<?php include('pagination.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Pagination PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: auto;
        }
        h2 {
            color: #333;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
        .pagination a, .pagination strong {
            display: inline-block;
            padding: 8px 16px;
            margin: 0 4px;
            text-decoration: none;
            border: 1px solid #ddd;
            color: #333;
            border-radius: 3px;
        }
        .pagination a:hover {
            background-color: #4CAF50;
            color: white;
        }
        .pagination strong {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #4CAF50;
        }
        .info {
            background-color: #e8f5e9;
            padding: 10px;
            border-left: 4px solid #4CAF50;
            margin-bottom: 20px;
        }
        .debug {
            background-color: #fff3e0;
            padding: 10px;
            border-left: 4px solid #ff9800;
            margin-top: 20px;
            font-family: monospace;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Data Pengguna</h2>
    
    <div class="info">
        <strong>Halaman <?php echo $pagenum; ?> dari <?php echo $last; ?> | Total Data: <?php echo $rows; ?></strong>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>UserID</th>
                <th>Nama Depan</th>
                <th>Nama Belakang</th>
                <th>Nama Panggilan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($nquery) > 0) {
                while ($row = mysqli_fetch_array($nquery)) {
                    echo "<tr>";
                    echo "<td>" . $row['userid'] . "</td>";
                    echo "<td>" . $row['firstname'] . "</td>";
                    echo "<td>" . $row['lastname'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
            }
            ?>
        </tbody>
    </table>
    
    <div class="pagination">
        <?php echo $paginationCtrls; ?>
    </div>
    
    <div class="debug">
        Debug: Data per halaman = <?php echo $page_rows; ?> | Total halaman = <?php echo $last; ?>
    </div>
</div>
</body>
</html>
