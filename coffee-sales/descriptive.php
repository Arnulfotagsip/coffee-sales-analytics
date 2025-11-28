<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descriptive Analytics • Coffee Sales</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root { --green:#2e7d32; }
        body { margin:0; font-family:system-ui,sans-serif; background:#fafdfa; }
        .container { max-width:1100px; margin:40px auto; padding:20px; background:white; border-radius:20px; box-shadow:0 10px 40px rgba(0,0,0,0.1); overflow:hidden; }
        header { background:var(--green); color:white; padding:35px; text-align:center; }
        h1 { margin:0; font-size:32px; font-weight:600; }
        .back { 
            display:inline-block; 
            margin-top:18px; 
            padding:12px 34px; 
            background:rgba(255,255,255,0.25); 
            border-radius:12px; 
            text-decoration:none; 
            color:white; 
            font-weight:600; 
            font-size:16px;
        }
        .back:hover { background:rgba(255,255,255,0.35); }
        /* rest of your styles remain the same */
        .section { padding:40px; }
        h2 { text-align:center; color:var(--green); font-size:28px; margin-bottom:30px; }
        table { width:100%; border-collapse:collapse; margin:25px 0; }
        th { background:#e8f5e8; padding:16px; color:#1b5e20; font-weight:800; text-transform:uppercase; }
        td { padding:14px; text-align:center; border-bottom:1px solid #eee; }
        tr:hover td { background:#f8fff8; }
        tr:last-child td { background:#f0f7f0; font-weight:700; color:var(--green); font-size:18px; }
        .chart-box { height:420px; margin:30px 0; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Descriptive Analytics</h1>
            <p style="margin:10px 0 0; opacity:0.9;"> What Happened?</p>
            <a href="index.php" class="back">Back to Dashboard</a>
        </header>

        <?php
        $conn = new mysqli("localhost", "root", "", "coffee_shop");
        if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

        $result = $conn->query("SELECT sale_date, espresso, latte, cappuccino, total_sales FROM daily_sales ORDER BY sale_date");
        $dates = $esp = $lat = $cap = $tot = [];
        $sum_e = $sum_l = $sum_c = $sum_t = 0;

        while ($row = $result->fetch_assoc()) {
            $dates[] = date("M j", strtotime($row['sale_date']));
            $esp[] = $row['espresso'];
            $lat[] = $row['latte'];
            $cap[] = $row['cappuccino'];
            $tot[] = $row['total_sales'];
            $sum_e += $row['espresso'];
            $sum_l += $row['latte'];
            $sum_c += $row['cappuccino'];
            $sum_t += $row['total_sales'];
        }

        function stats($arr) {
            $n = count($arr);
            $min = min($arr); $max = max($arr);
            $mean = round(array_sum($arr)/$n, 2);
            $var = round(array_sum(array_map(fn($x) => pow($x-$mean,2), $arr)) / $n, 2);
            $std = round(sqrt($var), 2);
            return [$n, $max-$min, $min, $max, $mean, $std, $var];
        }
        list($ne,$re,$mine,$maxe,$meane,$stde,$vare) = stats($esp);
        list($nl,$rl,$minl,$maxl,$meanl,$stdl,$varl) = stats($lat);
        list($nc,$rc,$minc,$maxc,$meanc,$stdc,$varc) = stats($cap);
        list($nt,$rt,$mint,$maxt,$meant,$stdt,$vart) = stats($tot);
        ?>

        <!-- Your existing sections (tables + chart) remain unchanged -->
        <div class="section">
            <h2>Daily Sales Table</h2>
            <table>
                <thead><tr><th>Date</th><th>Espresso</th><th>Latte</th><th>Cappuccino</th><th>Total</th></tr></thead>
                <tbody>
                    <?php
                    $result->data_seek(0);
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>".date("M j/Y", strtotime($row['sale_date']))."</td><td>{$row['espresso']}</td><td>{$row['latte']}</td><td>{$row['cappuccino']}</td><td><strong>{$row['total_sales']}</strong></td></tr>";
                    }
                    ?>
                    <tr><td><strong>Grand Total</strong></td><td><strong><?=number_format($sum_e)?></strong></td><td><strong><?=number_format($sum_l)?></strong></td><td><strong><?=number_format($sum_c)?></strong></td><td><strong><?=number_format($sum_t)?></strong></td></tr>
                </tbody>
            </table>
        </div>

        <div class="section">
            <h2>Total Sales Trend</h2>
            <div class="chart-box"><canvas id="chart"></canvas></div>
        </div>

        <div class="section">
            <h2>Descriptive Statistics</h2>
            <table>
                <thead style="background:var(--green);color:white;">
                    <tr><th>Product</th><th>N</th><th>Range</th><th>Min</th><th>Max</th><th>Mean</th><th>Std Dev</th><th>Variance</th></tr>
                </thead>
                <tbody>
                    <tr><td>Espresso</td><td><?=$ne?></td><td><?=$re?></td><td><?=$mine?></td><td><?=$maxe?></td><td><?=$meane?></td><td><?=$stde?></td><td><?=$vare?></td></tr>
                    <tr><td>Latte</td><td><?=$nl?></td><td><?=$rl?></td><td><?=$minl?></td><td><?=$maxl?></td><td><?=$meanl?></td><td><?=$stdl?></td><td><?=$varl?></td></tr>
                    <tr><td>Cappuccino</td><td><?=$nc?></td><td><?=$rc?></td><td><?=$minc?></td><td><?=$maxc?></td><td><?=$meanc?></td><td><?=$stdc?></td><td><?=$varc?></td></tr>
                    <tr><td>Total Sales</td><td><?=$nt?></td><td><?=$rt?></td><td><?=$mint?></td><td><?=$maxt?></td><td><?=$meant?></td><td><?=$stdt?></td><td><?=$vart?></td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        new Chart(document.getElementById('chart'), {
            type: 'bar',
            data: {
                labels: <?=json_encode($dates)?>,
                datasets: [{ label: 'Total Sales', data: <?=json_encode($tot)?>, backgroundColor: '#2196f3' }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { title: { display: true, text: 'Daily Total Sales - October 2025', font: {size: 20} }}
            }
        });
    </script>
</body>
</html>