<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Predictive Analytics • Coffee Sales</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <style>
        :root { --green:#2e7d32; --light:#e8f5e8; }
        body { margin:0; font-family:'Segoe UI',system-ui,sans-serif; background:#f8fcf8; min-height:100vh; }
        .container { max-width:1150px; margin:40px auto; padding:20px; background:white; border-radius:20px; box-shadow:0 12px 50px rgba(0,0,0,0.12); }

        .back-btn {
            display:inline-block; padding:12px 28px; background:white; color:var(--green);
            font-weight:600; font-size:16px; text-decoration:none; border-radius:8px;
            box-shadow:0 6px 20px rgba(0,0,0,0.1); margin-bottom:30px; transition:.3s;
        }
        .back-btn:hover { transform:translateY(-3px); background:#f0f7f0; }

        header {
            background:linear-gradient(135deg,#2e7d32,#4caf50); color:white; padding:60px 40px;
            text-align:center; border-radius:24px; margin-bottom:50px;
            box-shadow:0 20px 50px rgba(46,125,50,0.35);
        }
        h1 { margin:0; font-size:48px; font-weight:800; }
        header p { margin:12px 0 0; font-size:22px; opacity:0.94; }

        .section { padding:40px 20px; }
        h2 { text-align:center; color:var(--green); font-size:28px; margin:50px 0 40px; font-weight:700; }

        table.sales { width:100%; border-collapse:collapse; margin:30px 0; background:white; border-radius:16px; overflow:hidden; box-shadow:0 8px 30px rgba(0,0,0,0.08); }
        table.sales th { background:var(--light); padding:18px; color:#1b5e20; font-weight:800; text-transform:uppercase; font-size:14px; letter-spacing:0.5px; }
        table.sales td { padding:16px; text-align:center; border-bottom:1px solid #eee; }
        table.sales tr:hover td { background:#f8fff8; }
        table.sales tr.forecast td { background:#d4edda; font-weight:700; color:#155724; }

        .chart-box { height:420px; margin:40px 0; padding:20px; background:white; border-radius:16px; box-shadow:0 8px 30px rgba(0,0,0,0.08); }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="back-btn">Back to Dashboard</a>

        <header>
            <h1>Predictive Analytics</h1>
            <p>What Will Happen?</p>
        </header>

        <?php
        $sales = [
            "Oct 1"  => 75,   "Oct 2"  => 77,   "Oct 3"  => 90,   "Oct 4"  => 84,
            "Oct 5"  => 105,  "Oct 6"  => 99,   "Oct 7"  => 120,  "Oct 8"  => 112,
            "Oct 9"  => 99,   "Oct 10" => 85,   "Oct 11" => 95,   "Oct 12" => 104,
            "Oct 13" => 110,  "Oct 14" => 116,  "Oct 15" => 124,  "Oct 16" => 119,
            "Oct 17" => 99,   "Oct 18" => 86,   "Oct 19" => 78,   "Oct 20" => 91,
            "Oct 21" => 104   // ← Your exact forecast value
        ];
        ?>

        <div class="section">
            <h2>Daily Sales – October 2025</h2>
            <table class="sales">
                <thead>
                    <tr><th>Date</th><th>Total Sales</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($sales as $date => $total): ?>
                        <tr <?= $date === "Oct 21" ? 'class="forecast"' : '' ?>>
                            <td>
                                <strong><?= $date ?>, 2025<?= $date === "Oct 21" ? " (Forecast)" : "" ?></strong>
                            </td>
                            <td><strong><?= $date === "Oct 21" ? number_format($total) : $total ?></strong></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="section">
            <h2>Sales Forecast Trend</h2>
            <div class="chart-box">
                <canvas id="chart"></canvas>
            </div>
        </div>
    </div>

    <script>
        const labels = <?= json_encode(array_keys($sales)) ?>;
        const data   = <?= json_encode(array_values($sales)) ?>;

        new Chart(document.getElementById('chart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Sales',
                    data: data,
                    borderColor: '#2e7d32',
                    backgroundColor: 'rgba(76,175,80,0.1)',
                    pointBackgroundColor: '#2e7d32',
                    pointRadius: 6,
                    tension: 0.3,
                    borderWidth: 3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Daily Sales Trend & Forecast – October 2025',
                        font: {size: 20, weight: 'bold'},
                        color: '#2e7d32'
                    },
                    datalabels: {
                        color: '#2e7d32',
                        font: {weight: 'bold', size: 13},
                        anchor: 'end',
                        align: 'top',
                        formatter: (value) => Number(value).toFixed(2)
                    }
                },
                scales: {
                    y: { beginAtZero: false, suggestedMin: 60, suggestedMax: 140 }
                }
            },
            plugins: [ChartDataLabels]
        });
    </script>
</body>
</html>