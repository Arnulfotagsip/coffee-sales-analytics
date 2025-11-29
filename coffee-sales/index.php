<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Sales • October 2025</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #f8fcf8;
            min-height: 100vh;
            padding: 40px 20px;
        }
        .wrapper {
            width: 100%;
            max-width: 1150px;
            margin: 0 auto;
        }

        /* Green Banner */
        .banner {
            background: linear-gradient(135deg, #2e7d32, #4caf50);
            color: white;
            padding: 48px 30px;
            border-radius: 28px;
            text-align: center;
            box-shadow: 0 20px 50px rgba(46,125,50,0.32);
            margin-bottom: 60px;
        }
        .banner h1 { margin:0; font-size:46px; font-weight:800; }
        .banner p { margin:12px 0 0; font-size:20px; opacity:0.94; }

        /* Three Buttons - Perfect Horizontal */
        .buttons {
            display: flex;
            justify-content: center;
            gap: 32px;
            margin-bottom: 80px;
            flex-wrap: wrap;
        }
        .btn {
            flex: 1;
            max-width: 330px;
            padding: 28px 20px;
            border-radius: 22px;
            text-decoration: none;
            color: white;
            font-weight: 700;
            font-size: 24px;
            text-align: center;
            box-shadow: 0 14px 38px rgba(0,0,0,0.22);
            transition: all 0.35s ease;
        }
        .btn:hover { transform: translateY(-10px); box-shadow: 0 24px 50px rgba(0,0,0,0.32); }
        .btn small { display:block; font-size:17px; margin-top:8px; font-weight:500; opacity:0.92; }

        .descriptive  { background:#2196f3; }
        .predictive   { background:#4caf50; }
        .prescriptive { background:#ff9800; }

        /* 4 Stats Cards */
        .stats {
            display: flex;
            justify-content: center;
            gap: 28px;
            flex-wrap: wrap;
            margin-bottom: 80px;
        }
        .stat {
            background: white;
            padding: 26px 34px;
            border-radius: 20px;
            box-shadow: 0 10px 32px rgba(0,0,0,0.1);
            min-width: 180px;
            text-align: center;
        }
        .stat h3 { margin:0 0 10px; font-size:16px; color:#555; font-weight:500; }
        .stat p { margin:0; font-size:40px; font-weight:800; color:#2e7d32; }

        /* Beautiful Table - Same Modern Style */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 12px 40px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .data-table th {
            background: #e8f5e8;
            padding: 20px;
            color: #1b5e20;
            font-weight: 800;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .data-table td {
            padding: 18px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }
        .data-table tr:hover td { background: #f8fff8; }
        .data-table tr:last-child td {
            background: #f0f7f0;
            font-weight: 700;
            color: #2e7d32;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="wrapper">

        <!-- Banner -->
        <div class="banner">
            <h1>Coffee Sales Analytics</h1>
            <p>Complete Sales Intelligence Dashboard </p>
        </div>

        <!-- Buttons -->
        <div class="buttons">
            <a href="descriptive.php" class="btn descriptive">Descriptive Analytics<small>What Happened?</small></a>
            <a href="predictive.php" class="btn predictive">Predictive Analytics<small>What Will Happen?</small></a>
            <a href="prescriptive.php" class="btn prescriptive">Prescriptive Analytics<small>What Should We Do?</small></a>
        </div>

        <?php
        $conn = new mysqli("localhost", "root", "", "coffee_shop");
        if ($conn->connect_error) die("Connection failed");

        $total_espresso = $conn->query("SELECT SUM(espresso) FROM daily_sales")->fetch_row()[0] ?? 0;
        $total_latte    = $conn->query("SELECT SUM(latte) FROM daily_sales")->fetch_row()[0] ?? 0;
        $total_capp     = $conn->query("SELECT SUM(cappuccino) FROM daily_sales")->fetch_row()[0] ?? 0;
        $total_sales    = $total_espresso + $total_latte + $total_capp;
        ?>

        <!-- Stats Cards -->
        <div class="stats">
            <div class="stat"><h3>Total Espresso</h3><p><?=number_format($total_espresso)?></p></div>
            <div class="stat"><h3>Total Latte</h3><p><?=number_format($total_latte)?></p></div>
            <div class="stat"><h3>Total Cappuccino</h3><p><?=number_format($total_capp)?></p></div>
            <div class="stat"><h3>Total Cups Sold</h3><p><?=number_format($total_sales)?></p></div>
        </div>

        <!-- Full Data Table - Back and Beautiful -->
        <table class="data-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Espresso</th>
                    <th>Latte</th>
                    <th>Cappuccino</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT sale_date, espresso, latte, cappuccino, total_sales FROM daily_sales ORDER BY sale_date");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . date("M j, Y", strtotime($row['sale_date'])) . "</td>
                        <td>{$row['espresso']}</td>
                        <td>{$row['latte']}</td>
                        <td>{$row['cappuccino']}</td>
                        <td><strong>{$row['total_sales']}</strong></td>
                    </tr>";
                }
                ?>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong><?=number_format($total_espresso)?></strong></td>
                    <td><strong><?=number_format($total_latte)?></strong></td>
                    <td><strong><?=number_format($total_capp)?></strong></td>
                    <td><strong><?=number_format($total_sales)?></strong></td>
                </tr>
            </tbody>
        </table>

    </div>
</body>
</html>