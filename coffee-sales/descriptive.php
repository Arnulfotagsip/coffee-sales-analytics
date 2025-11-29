<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descriptive Analytics • Coffee Sales</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root { 
            --primary:#1565c0;     /* Deep blue */
            --accent:#42a5f5;      /* Light blue */
            --light:#e3f2fd; 
        }
        body { margin:0; font-family:'Segoe UI',system-ui,sans-serif; background:#f8fcf8; min-height:100vh; }
        .container { max-width:1150px; margin:40px auto; padding:20px; background:white; border-radius:20px; box-shadow:0 12px 50px rgba(0,0,0,0.12); }

        .back-btn {
            display:inline-block; padding:12px 28px; background:white; color:var(--primary);
            font-weight:600; font-size:16px; text-decoration:none; border-radius:8px;
            box-shadow:0 6px 20px rgba(0,0,0,0.1); margin-bottom:30px; transition:.3s;
        }
        .back-btn:hover { transform:translateY(-3px); background:#e8f4f0; }

        /* BLUE GRADIENT HEADER – matches your dashboard button perfectly */
        header {
            background:linear-gradient(135deg,#1565c0,#42a5f5); 
            color:white; 
            padding:60px 40px;
            text-align:center; 
            border-radius:24px; 
            margin-bottom:50px;
            box-shadow:0 20px 50px rgba(21,101,192,0.4);
        }
        h1 { margin:0; font-size:48px; font-weight:800; }
        header p { margin:12px 0 0; font-size:22px; opacity:0.94; }

        .section { padding:40px 20px; }
        h2 { text-align:center; color:var(--primary); font-size:28px; margin:50px 0 40px; font-weight:700; }

        table.sales { width:100%; border-collapse:collapse; margin:30px 0; background:white; border-radius:16px; overflow:hidden; box-shadow:0 8px 30px rgba(0,0,0,0.08); }
        table.sales th { background:var(--light); padding:18px; color:#0d47a1; font-weight:800; text-transform:uppercase; font-size:14px; letter-spacing:0.5px; }
        table.sales td { padding:16px; text-align:center; border-bottom:1px solid #eee; }
        table.sales tr:hover td { background:#f0f8ff; }
        table.sales tr:last-child td { background:#bbdefb; font-weight:700; color:var(--primary); font-size:18px; }

        .chart-box { height:420px; margin:40px 0; padding:20px; background:white; border-radius:16px; box-shadow:0 8px 30px rgba(0,0,0,0.08); }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="back-btn">Back to Dashboard</a>

        <!-- BLUE HEADER – Perfect match with dashboard -->
        <header>
            <h1>Descriptive Analytics</h1>
            <p>What Happened?</p>
        </header>

        <?php
        $conn = new mysqli("localhost", "root", "", "coffee_shop");
        if ($conn->connect_error) die("Connection failed");

        $result = $conn->query("SELECT sale_date, espresso, latte, cappuccino, total_sales FROM daily_sales ORDER BY sale_date");
        $dates = []; $tot = []; $sum_t = 0;

        while ($row = $result->fetch_assoc()) {
            $dates[] = date("M j", strtotime($row['sale_date']));
            $tot[] = (int)$row['total_sales'];
            $sum_t += $row['total_sales'];
        }
        ?>

        <!-- Daily Sales Table -->
        <div class="section">
            <h2>Daily Sales Table</h2>
            <table class="sales">
                <thead>
                    <tr><th>Date</th><th>Espresso</th><th>Latte</th><th>Cappuccino</th><th>Total</th></tr>
                </thead>
                <tbody>
                    <?php
                    $result->data_seek(0);
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>".date("M j, Y", strtotime($row['sale_date']))."</td>
                            <td>{$row['espresso']}</td>
                            <td>{$row['latte']}</td>
                            <td>{$row['cappuccino']}</td>
                            <td><strong>{$row['total_sales']}</strong></td>
                        </tr>";
                    }
                    ?>
                    <tr>
                        <td><strong>Grand Total</strong></td>
                        <td colspan="3"></td>
                        <td><strong><?=number_format($sum_t)?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Chart -->
        <div class="section">
            <h2>Total Sales Trend</h2>
            <div class="chart-box"><canvas id="chart"></canvas></div>
        </div>

        <!-- Descriptive Statistics Table (unchanged) -->
        <div class="section">
            <div style="background:white; border-radius:20px; overflow:hidden; box-shadow:0 15px 45px rgba(0,0,0,0.12);">
                <table style="width:100%; border-collapse:separate; border-spacing:0;">
                    <thead>
                        <tr>
                            <th colspan="8" style="background:#bbdefb; padding:22px; text-align:center; font-size:26px; color:#0d47a1; font-weight:800;">
                                Descriptive Statistics
                            </th>
                        </tr>
                        <tr style="background:#e3f2fd; color:#0d47a1;">
                            <th style="padding:16px; font-weight:800; text-transform:uppercase; letter-spacing:1px;">Product</th>
                            <th style="padding:16px; font-weight:800; text-transform:uppercase; letter-spacing:1px;">N</th>
                            <th style="padding:16px; font-weight:800; text-transform:uppercase; letter-spacing:1px;">Range</th>
                            <th style="padding:16px; font-weight:800; text-transform:uppercase; letter-spacing:1px;">Minimum</th>
                            <th style="padding:16px; font-weight:800; text-transform:uppercase; letter-spacing:1px;">Maximum</th>
                            <th style="padding:16px; font-weight:800; text-transform:uppercase; letter-spacing:1px;">Mean</th>
                            <th style="padding:16px; font-weight:800; text-transform:uppercase; letter-spacing:1px;">Standard Deviation</th>
                            <th style="padding:16px; font-weight:800; text-transform:uppercase; letter-spacing:1px;">Variance</th>
                        </tr>
                    </thead>
                    <tbody style="font-size:16px;">
                        <tr style="background:#f0f8ff;">
                            <td style="padding:18px 30px; font-weight:600; color:#1565c0;">Espresso</td>
                            <td style="text-align:center;">20</td>
                            <td style="text-align:center;">18</td>
                            <td style="text-align:center;">28</td>
                            <td style="text-align:center;">46</td>
                            <td style="text-align:center; color:#000; font-weight:normal;">37</td>
                            <td style="text-align:center;">5.52</td>
                            <td style="text-align:center;">30.52</td>
                        </tr>
                        <tr>
                            <td style="padding:18px 30px; font-weight:600; color:#1565c0;">Latte</td>
                            <td style="text-align:center;">20</td>
                            <td style="text-align:center;">17</td>
                            <td style="text-align:center;">25</td>
                            <td style="text-align:center;">42</td>
                            <td style="text-align:center; color:#000; font-weight:normal;">33.25</td>
                            <td style="text-align:center;">4.94</td>
                            <td style="text-align:center;">24.40</td>
                        </tr>
                        <tr style="background:#f0f8ff;">
                            <td style="padding:18px 30px; font-weight:600; color:#1565c0;">Cappuccino</td>
                            <td style="text-align:center;">20</td>
                            <td style="text-align:center;">16</td>
                            <td style="text-align:center;">20</td>
                            <td style="text-align:center;">36</td>
                            <td style="text-align:center; color:#000; font-weight:normal;">28.15</td>
                            <td style="text-align:center;">4.74</td>
                            <td style="text-align:center;">22.55</td>
                        </tr>
                        <tr style="background:#bbdefb; font-size:17px;">
                            <td style="padding:22px 30px; font-weight:800; color:#0d47a1;">Total Sales</td>
                            <td style="text-align:center; font-weight:700;">20</td>
                            <td style="text-align:center; font-weight:700;">18</td>
                            <td style="text-align:center; font-weight:700;">28</td>
                            <td style="text-align:center; font-weight:700;">46</td>
                            <td style="text-align:center; color:#000; font-weight:bold;">37</td>
                            <td style="text-align:center; font-weight:700;">5.52</td>
                            <td style="text-align:center; font-weight:700;">30.52</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <script>
            new Chart(document.getElementById('chart'), {
                type: 'bar',
                data: {
                    labels: <?=json_encode($dates)?>,
                    datasets: [{
                        label: 'Total Sales',
                        data: <?=json_encode($tot)?>,
                        backgroundColor: '#42a5f5',
                        borderColor: '#1565c0',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Daily Total Sales - October 2025',
                            font: {size: 20, weight: 'bold'},
                            color: '#1565c0'
                        }
                    },
                    scales: { y: { beginAtZero: true }}
                }
            });
        </script>
    </div>
</body>
</html>