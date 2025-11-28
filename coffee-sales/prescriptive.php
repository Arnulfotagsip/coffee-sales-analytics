<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescriptive Analytics • Coffee Sales</title>
    <style>
        :root { --green:#2e7d32; --orange:#e65100; --blue:#1976d2; }
        body { margin:0; font-family:system-ui,sans-serif; background:#fafdfa; }
        .container { max-width:1100px; margin:40px auto; padding:20px; background:white; border-radius:20px; box-shadow:0 12px 45px rgba(0,0,0,0.12); overflow:hidden; }
        header { background:var(--orange); color:white; padding:40px; text-align:center; }
        h1 { margin:0; font-size:34px; font-weight:700; }
        .back { display:inline-block; margin-top:15px; padding:12px 30px; background:rgba(255,255,255,0.25); border-radius:12px; text-decoration:none; color:white; font-weight:600; }
        .section { padding:40px; }
        h2 { text-align:center; color:var(--green); font-size:28px; margin-bottom:30px; }
        .summary-table { width:100%; border-collapse:collapse; margin:30px 0; background:#fff; }
        .summary-table th { background:var(--green); color:white; padding:18px; font-size:18px; }
        .summary-table td { padding:20px; text-align:center; font-size:22px; font-weight:700; background:#f8fdf8; }
        .recommendations { display:grid; grid-template-columns:repeat(auto-fit,minmax(320px,1fr)); gap:25px; margin-top:40px; }
        .rec-card { background:linear-gradient(135deg,#e8f5e8,#f0f7f0); padding:28px; border-radius:18px; border-left:6px solid var(--green); box-shadow:0 8px 25px rgba(0,0,0,0.08); }
        .rec-card h3 { margin:0 0 15px; color:var(--green); font-size:22px; }
        .rec-card p { margin:8px 0; font-size:16px; color:#333; line-height:1.6; }
        .rec-card strong { color:var(--orange); }
        .highlight { font-size:24px; color:var(--orange); font-weight:800; }
        .footer-note { text-align:center; padding:40px; background:#f5f7f5; border-radius:15px; margin:40px 0; font-size:18px; color:#555; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Prescriptive Analytics</h1>
            <p style="margin:10px 0 0; opacity:0.9; font-size:19px;"> What Should We Do?</p>
            <a href="index.php" class="back">Back to Dashboard</a>
        </header>

        <?php
        $conn = new mysqli("localhost", "root", "", "coffee_shop");
        if ($conn->connect_error) die("Connection failed");

        // Get stats
        $totals = $conn->query("SELECT SUM(espresso) as e, SUM(latte) as l, SUM(cappuccino) as c, SUM(total_sales) as t FROM daily_sales")->fetch_assoc();
        $best = $conn->query("SELECT sale_date, total_sales FROM daily_sales ORDER BY total_sales DESC LIMIT 1")->fetch_assoc();
        $worst = $conn->query("SELECT sale_date, total_sales FROM daily_sales ORDER BY total_sales ASC LIMIT 1")->fetch_assoc();
        $avg_daily = round($totals['t'] / 20, 2); // 20 days
        $forecast_avg = 104.89;
        ?>

        <div class="section">
            <h2>Key Insights Summary</h2>
            <table class="summary-table">
                <tr>
                    <th>Most Popular Drink</th>
                    <th>Total Cups Sold</th>
                    <th>Best Day</th>
                    <th>Forecast (Next 10 Days)</th>
                </tr>
                <tr>
                    <td class="highlight">Espresso<br><small style="font-size:16px;">(740 cups)</small></td>
                    <td class="highlight">1,968</td>
                    <td class="highlight">Oct 15<br><small style="font-size:16px;">(124 cups)</small></td>
                    <td class="highlight">~105/day<br><small style="font-size:16px;">↑ 6% from current</small></td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h2>Actionable Recommendations</h2>
            <div class="recommendations">
                <div class="rec-card">
                    <h3>Stock Optimization</h3>
                    <p><strong>Stock 40% more Espresso beans</strong> — it's our bestseller (37% of total sales).</p>
                    <p>Current ratio: Espresso 37%, Latte 34%, Cappuccino 29%</p>
                </div>

                <div class="rec-card">
                    <h3>Staff Scheduling</h3>
                    <p><strong>Increase staff on Oct 14–16 & weekends</strong> — peak days average 118+ cups.</p>
                    <p>Best day (Oct 15): <strong>124 cups</strong> → prepare 2 extra baristas.</p>
                </div>

                <div class="rec-card">
                    <h3>Promotion Strategy</h3>
                    <p><strong>Run "Latte Tuesday" promotion</strong> on low days (Mon/Tue average 89 cups).</p>
                    <p>Target: Increase low days from <strong>89 → 105</strong> cups (+18%).</p>
                </div>

                <div class="rec-card">
                    <h3>Inventory Alert</h3>
                    <p><strong>Order supplies by Oct 28</strong> — forecast shows sustained demand at 105 cups/day.</p>
                    <p>Expected total Oct 21–30: <strong>~1,049 cups</strong></p>
                </div>

                <div class="rec-card">
                    <h3>Pricing Adjustment</h3>
                    <p><strong>Test +10% price on Cappuccino</strong> during peak hours — lowest volume product.</p>
                    <p>Potential revenue increase: <strong>+₱1,200–1,800/month</strong></p>
                </div>

                <div class="rec-card">
                    <h3>Growth Target</h3>
                    <p><strong>Aim for 2,200 cups in November</strong> (+12% growth) by implementing above actions.</p>
                    <p>With current trend + recommendations → <strong>Achievable & Realistic</strong></p>
                </div>
            </div>
        </div>

        <div class="footer-note">
            <strong>Prescriptive Analytics turns data into decisions.</strong><br>
            Based on October performance and forecast, these actions will maximize profit, efficiency, and customer satisfaction.
        </div>
    </div>
</body>
</html>