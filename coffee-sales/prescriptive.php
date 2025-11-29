<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescriptive Analytics • Coffee Sales</title>
    <style>
        :root { --green:#2e7d32; --orange:#ff5722; --light:#e8f5e8; }
        body { margin:0; font-family:'Segoe UI',system-ui,sans-serif; background:#f8fcf8; min-height:100vh; }
        .container { max-width:1150px; margin:40px auto; padding:20px; background:white; border-radius:20px; box-shadow:0 12px 50px rgba(0,0,0,0.12); }

        .back-btn {
            display:inline-block; padding:12px 28px; background:white; color:var(--green);
            font-weight:600; font-size:16px; text-decoration:none; border-radius:8px;
            box-shadow:0 6px 20px rgba(0,0,0,0.1); margin-bottom:30px; transition:.3s;
        }
        .back-btn:hover { transform:translateY(-3px); background:#f0f7f0; }

        header {
            background:linear-gradient(135deg,#ff5722,#ff8a65); color:white; padding:60px 40px;
            text-align:center; border-radius:24px; margin-bottom:50px;
            box-shadow:0 20px 50px rgba(255,87,34,0.4);
        }
        h1 { margin:0; font-size:48px; font-weight:800; }
        header p { margin:12px 0 0; font-size:22px; opacity:0.94; }

        .section { padding:40px 20px; }
        h2 { text-align:center; color:var(--green); font-size:28px; margin:50px 0 40px; font-weight:700; }

        table.summary { width:100%; border-collapse:collapse; margin:30px 0; background:white; border-radius:16px; overflow:hidden; box-shadow:0 8px 30px rgba(0,0,0,0.08); }
        table.summary th { background:var(--orange); color:white; padding:20px; font-size:18px; font-weight:800; }
        table.summary td { padding:25px; text-align:center; background:#fff8f5; font-size:22px; font-weight:700; color:#d84315; }
        table.summary .highlight { color:#e65100; font-size:26px; }

        .recommendations {
            display:grid; grid-template-columns:repeat(auto-fit,minmax(340px,1fr)); gap:28px; margin-top:40px;
        }
        .rec-card {
            background:linear-gradient(135deg,#fff8f5,#ffe0b2); padding:30px; border-radius:18px;
            border-left:7px solid var(--orange); box-shadow:0 10px 30px rgba(255,87,34,0.15);
            transition:transform .3s;
        }
        .rec-card:hover { transform:translateY(-5px); }
        .rec-card h3 { margin:0 0 16px; color:var(--orange); font-size:23px; font-weight:700; }
        .rec-card p { margin:10px 0; font-size:16px; color:#333; line-height:1.6; }
        .rec-card strong { color:#e65100; }

        .footer-note {
            text-align:center; padding:45px; background:#fff3e0; border-radius:18px; margin:50px 0 20px;
            font-size:18px; color:#555; line-height:1.7; border:2px solid #ffccbc;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php" class="back-btn">Back to Dashboard</a>

        <header>
            <h1>Prescriptive Analytics</h1>
            <p>What Should We Do?</p>
        </header>

        <?php
        $conn = new mysqli("localhost", "root", "", "coffee_shop");
        if ($conn->connect_error) die("Connection failed");

        $totals = $conn->query("SELECT SUM(espresso) as e, SUM(latte) as l, SUM(cappuccino) as c, SUM(total_sales) as t FROM daily_sales")->fetch_assoc();
        $best = $conn->query("SELECT sale_date, total_sales FROM daily_sales ORDER BY total_sales DESC LIMIT 1")->fetch_assoc();
        $avg_daily = round($totals['t'] / 20, 2);
        $forecast_day21 = 104.88;  // Your exact Day 21 forecast
        ?>

        <div class="section">
            <h2>Key Insights Summary</h2>
            <table class="summary">
                <tr>
                    <th>Most Popular Drink</th>
                    <th>Total Cups Sold</th>
                    <th>Best Day</th>
                    <th>Oct 21 Forecast</th>
                </tr>
                <tr>
                    <td class="highlight">Espresso<br><small>(740 cups)</small></td>
                    <td class="highlight">1,968</td>
                    <td class="highlight">Oct 15<br><small>(124 cups)</small></td>
                    <td class="highlight">104 cups<br><small>↑ 6.5% from current avg</small></td>
                </tr>
            </table>
        </div>

        <div class="section">
            <h2>Actionable Recommendations</h2>
            <div class="recommendations">
                <div class="rec-card"><h3>Stock Optimization</h3><p><strong>Stock 40% more Espresso beans</strong> — bestseller (37% of sales).</p></div>
                <div class="rec-card"><h3>Staff Scheduling</h3><p><strong>Increase staff on Oct 14–16 & weekends</strong> — peak days average 118+ cups.</p></div>
                <div class="rec-card"><h3>Promotion Strategy</h3><p><strong>Run "Latte Tuesday" promotion</strong> on low days (avg 89 cups).</p></div>
                <div class="rec-card"><h3>Inventory Alert</h3><p><strong>Prepare for Oct 21 demand:</strong> forecast 104 cups — stock accordingly.</p></div>
                <div class="rec-card"><h3>Pricing Adjustment</h3><p><strong>Test +10% price on Cappuccino</strong> during peak hours.</p></div>
                <div class="rec-card"><h3>Growth Target</h3><p><strong>Aim for 2,200 cups in November</strong> (+12% growth).</p></div>
            </div>
        </div>

        <div class="footer-note">
            <strong>Prescriptive Analytics turns data into decisions.</strong><br>
            Based on October performance and the Oct 21 forecast of 104 cups, these actions will maximize profit and efficiency.
        </div>
    </div>
</body>
</html>