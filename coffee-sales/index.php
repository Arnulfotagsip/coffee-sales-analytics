<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Sales • October 2025</title>
    <style>
        :root { --accent:#2e7d32; --light:#f0f7f0; --border:#e0e0e0; }
        body { margin:0; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif; background:#fafdfa; color:#222; }
        .container { max-width:960px; margin:40px auto; padding:0 20px; }
        header { text-align:center; padding:40px 0 30px; }
        h1 { margin:0; font-size:32px; font-weight:600; color:var(--accent); }
        .subtitle { color:#666; font-size:18px; margin:10px 0 0; }

        /* Stats Cards */
        .stats { display:flex; justify-content:center; gap:20px; flex-wrap:wrap; margin:50px 0; }
        .stat { background:white; padding:24px 32px; border-radius:20px; box-shadow:0 8px 25px rgba(0,0,0,0.08); min-width:160px; text-align:center; border:1px solid #eee; }
        .stat h3 { margin:0 0 8px; font-size:15px; color:#555; font-weight:500; }
        .stat p { margin:0; font-size:38px; font-weight:800; color:var(--accent); }
        .stat small { font-size:14px; color:#888; }

        /* 3 Analytics Buttons - Perfectly Aligned */
        .analytics-buttons {
            display:flex;
            justify-content:center;
            gap:18px;
            margin:60px 0 50px;
            flex-wrap:wrap;
        }
        .analytics-btn {
            padding:20px 36px;
            background:var(--accent);
            color:white;
            text-decoration:none;
            border-radius:20px;
            font-weight:700;
            font-size:19px;
            min-width:240px;
            text-align:center;
            box-shadow:0 10px 30px rgba(46,125,50,0.3);
            transition:all 0.3s ease;
        }
        .analytics-btn:hover {
            transform:translateY(-6px);
            box-shadow:0 18px 40px rgba(46,125,50,0.4);
        }
        .analytics-btn small {
            display:block;
            font-weight:500;
            opacity:0.9;
            font-size:15px;
            margin-top:6px;
        }

        /* Table */
        table { width:100%; border-collapse:collapse; background:white; border-radius:20px; overflow:hidden; 
                box-shadow:0 10px 35px rgba(0,0,0,0.1); }
        th { background:#e8f5e8; padding:20px 16px; font-weight:800; font-size:16px; color:#1b5e20; 
             text-transform:uppercase; letter-spacing:1px; }
        td { padding:18px 16px; text-align:center; border-bottom:1px solid #eee; }
        tr:hover td { background:#f8fff8; }
        tr:last-child td { background:#f0f7f0; font-weight:700; color:var(--accent); }
        footer { text-align:center; padding:60px 0 30px; color:#888; font-size:14px; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Coffee Sales Dashboard</h1>
          
        </header>

        <?php
        $conn = new mysqli("localhost", "root", "", "coffee_shop");
        if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

        $total_espresso = $conn->query("SELECT SUM(espresso) FROM daily_sales")->fetch_row()[0] ?? 0;
        $total_latte    = $conn->query("SELECT SUM(latte) FROM daily_sales")->fetch_row()[0] ?? 0;
        $total_capp     = $conn->query("SELECT SUM(cappuccino) FROM daily_sales")->fetch_row()[0] ?? 0;
        $total_sales    = $conn->query("SELECT SUM(total_sales) FROM daily_sales")->fetch_row()[0] ?? 0;
        $best_day       = $conn->query("SELECT sale_date, total_sales FROM daily_sales ORDER BY total_sales DESC LIMIT 1")->fetch_row();
        $best_date      = $best_day ? date("M j", strtotime($best_day[0])) : "-";
        $best_amount    = $best_day ? $best_day[1] : 0;
        ?>

        <div class="stats">
            <div class="stat"><h3>Total Espresso</h3><p><?php echo number_format($total_espresso); ?></p></div>
            <div class="stat"><h3>Total Latte</h3><p><?php echo number_format($total_latte); ?></p></div>
            <div class="stat"><h3>Total Cappuccino</h3><p><?php echo number_format($total_capp); ?></p></div>
            <div class="stat"><h3>Total Cups Sold</h3><p><?php echo number_format($total_sales); ?></p></div>
            <div class="stat"><h3>Best Day</h3><p><?php echo $best_amount; ?><br><small><?php echo $best_date; ?></small></p></div>
        </div>

             
        <div style="text-align:center; margin:60px 0 50px;">
            <div style="display:inline-flex; gap:20px; flex-wrap:wrap; justify-content:center; align-items:center;">
                
                <a href="descriptive.php" style="
                    padding:18px 32px;
                    background:#2e7d32;
                    color:white;
                    text-decoration:none;
                    border-radius:18px;
                    font-weight:700;
                    font-size:18px;
                    min-width:260px;
                    text-align:center;
                    box-shadow:0 10px 30px rgba(46,125,50,0.35);
                    transition:all 0.3s ease;
                "
                onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 18px 40px rgba(46,125,50,0.45)'"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(46,125,50,0.35)'">
                    Descriptive Analytics
                    <div style="font-size:14px; font-weight:500; opacity:0.9; margin-top:6px;"></div>
                </a>

                <a href="predictive.php" style="
                    padding:18px 32px;
                    background:#2e7d32;
                    color:white;
                    text-decoration:none;
                    border-radius:18px;
                    font-weight:700;
                    font-size:18px;
                    min-width:260px;
                    text-align:center;
                    box-shadow:0 10px 30px rgba(46,125,50,0.35);
                    transition:all 0.3s ease;
                "
                onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 18px 40px rgba(46,125,50,0.45)'"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(46,125,50,0.35)'">
                    Predictive Analytics
                    <div style="font-size:14px; font-weight:500; opacity:0.9; margin-top:6px;"></div>
                </a>

                <a href="prescriptive.php" style="
                    padding:18px 32px;
                    background:#2e7d32;
                    color:white;
                    text-decoration:none;
                    border-radius:18px;
                    font-weight:700;
                    font-size:18px;
                    min-width:260px;
                    text-align:center;
                    box-shadow:0 10px 30px rgba(46,125,50,0.35);
                    transition:all 0.3s ease;
                "
                onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 18px 40px rgba(46,125,50,0.45)'"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(46,125,50,0.35)'">
                    Prescriptive Analytics
                    <div style="font-size:14px; font-weight:500; opacity:0.9; margin-top:6px;"></div>
                </a>
                
            </div>
        </div>
        <table>
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
                    echo "<tr>";
                    echo "<td>" . date("M j, Y", strtotime($row['sale_date'])) . "</td>";
                    echo "<td>" . $row['espresso'] . "</td>";
                    echo "<td>" . $row['latte'] . "</td>";
                    echo "<td>" . $row['cappuccino'] . "</td>";
                    echo "<td><strong>" . $row['total_sales'] . "</strong></td>";
                    echo "</tr>";
                }
                ?>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong><?php echo number_format($total_espresso); ?></strong></td>
                    <td><strong><?php echo number_format($total_latte); ?></strong></td>
                    <td><strong><?php echo number_format($total_capp); ?></strong></td>
                    <td><strong><?php echo number_format($total_sales); ?></strong></td>
                </tr>
            </tbody>
        </table>

        <footer>
            Minimalist Coffee Sales • Running on XAMPP + MySQL
        </footer>
    </div>
</body>
</html>