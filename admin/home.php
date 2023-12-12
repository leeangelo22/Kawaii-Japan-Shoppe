<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<h3 class="text-dark">Welcome <?php echo $_settings->userdata('username') ?>!</h3>
<hr>
<section class="content">
    <div class="container-fluid">
    <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-file-invoice"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Invoices</span>
                <span class="info-box-number">
                  <?php echo number_format($conn->query("SELECT * FROM invoice_list")->num_rows) ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-th-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Category</span>
                <span class="info-box-number"> <?php echo number_format($conn->query("SELECT * FROM category_list")->num_rows) ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <?php
          // Count available items
          $available_items_query = $conn->query("SELECT * FROM product_list WHERE status = 1");
          $available_items_count = $available_items_query->num_rows;

          // Count unavailable items
          $unavailable_items_query = $conn->query("SELECT * FROM product_list WHERE status = 2");
          $unavailable_items_count = $unavailable_items_query->num_rows;
          ?>

          <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                  <span class="info-box-icon bg-success elevation-1"><i class="fas fa-box-open"></i></span>

                  <div class="info-box-content">
                      <span class="info-box-text">Available Items</span>
                      <span class="info-box-number"><?php echo number_format($available_items_count) ?></span>
                  </div>
                  <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                  <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-ban"></i></span>

                  <div class="info-box-content">
                      <span class="info-box-text">Unavailable Items</span>
                      <span class="info-box-number"><?php echo number_format($unavailable_items_count) ?></span>
                  </div>
                  <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-box"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Available Items</span>
                <span class="info-box-number"><?php echo number_format($conn->query("SELECT * FROM product_list")->num_rows) ?></span>
              </div> -->
              <!-- /.info-box-content -->
            <!-- </div> -->
            <!-- /.info-box -->
          <!-- </div> -->
          <!-- /.col -->
          <!-- <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-hands-helping"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Unavailable Items</span>
                <span class="info-box-number"><?php echo number_format($conn->query("SELECT * FROM service_list")->num_rows) ?></span>
              </div> -->
              <!-- /.info-box-content -->
            <!-- </div> -->
            <!-- /.info-box -->
          <!-- </div> -->
          <!-- /.col -->
        </div>
    </div>
</section>

<!-- Chart Section -->
<div class="row">

    <!-- Left Column -->
<div class="col-md-4">
    <!-- Profit -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><b>Profits</b></h3>
        </div>
        <div class="card-body">
            <canvas id="profitChart" width="400" height="200"></canvas>
            <?php
            // Fetch the profit based on the selected filter
            $query = "SELECT SUM(total_amount) AS total_sales, SUM(sub_total) AS total_costs
                      FROM invoice_list";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                // Calculate profit
                $row = $result->fetch_assoc();
                $totalSales = $row['total_sales'];
                $totalCosts = $row['total_costs'];
                $profit = $totalSales - $totalCosts;

                // Display the profit
                // echo '<p>Total Sales: ₱' . number_format($totalSales, 2) . '</p>';
                // echo '<p>Total Costs: ₱' . number_format($totalCosts, 2) . '</p>';
                // echo '<p>Profit: ₱' . number_format($profit, 2) . '</p>';
            } else {
                echo 'No data available.';
            }
            ?>
        </div>
    </div>
</div>
<script>
    // Function to update the chart based on user selection
    function updateChart() {
        // Fetch data based on selected filter (you need to implement this part)

        // Example data (replace with actual data fetching)
        const lastWeekData = [/* Last week data for the selected chartType */];
        const currentWeekData = [/* Current week data for the selected chartType */];

        // Update chart based on the selected time frame
        const xValues = ['Profits', 'Total Sales', 'Total Costs'];
        const yValues = [<?php echo $profit; ?>, <?php echo $totalSales; ?>, <?php echo $totalCosts; ?>];

        // Update chart title
        // const chartTitle = 'Profits';
        // document.getElementById('chartTitle').textContent = chartTitle;

        // Get chart context
        const ctx = document.getElementById('profitChart').getContext('2d');

        // Update chart data and options
        const chart = new Chart(ctx, {
            type: 'bar', // Change chart type to bar
            data: {
                labels: xValues,
                datasets: [{
                    label: 'Profits',
                    data: yValues,
                    backgroundColor: ['#ffc107', '#28a745', '#4169E1']
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Initial chart rendering
    updateChart();
</script>


<!-- Middle Column -->
<div class="col-md-4">
    <!-- Most Purchased Items -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><b>Most Purchased Items</b></h3>
        </div>
        <div class="card-body">
            <canvas id="mostPurchasedChart" width="400" height="200"></canvas>
            <?php
            // Fetch the top 5 most purchased products
            $query = "SELECT product_list.product, SUM(invoices_items.quantity) AS total_quantity
                      FROM invoices_items
                      JOIN product_list ON invoices_items.form_id = product_list.id
                      GROUP BY product_list.product
                      ORDER BY total_quantity DESC
                      LIMIT 5"; // Limit the result to the top 5 items

            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                // Prepare data for the pie chart
                $labels = [];
                $data = [];

                while ($row = $result->fetch_assoc()) {
                    $labels[] = $row['product'];
                    $data[] = $row['total_quantity'];
                }

                // Output the pie chart data
                echo '<script>';
                echo 'var ctx = document.getElementById("mostPurchasedChart").getContext("2d");';
                echo 'var mostPurchasedChart = new Chart(ctx, {';
                echo '  type: "pie",';
                echo '  data: {';
                echo '    labels: ' . json_encode($labels) . ',';
                echo '    datasets: [{';
                echo '      data: ' . json_encode($data) . ',';
                echo '      backgroundColor: [';
                // You can customize the colors here if needed
                echo '        "#28a745",'; // Green
                echo '        "#4169E1",'; // Blue
                echo '        "#ffc107",'; // Yellow
                echo '        "#ff4d00",'; // Orange
                echo '        "#a50110",'; // Red
                echo '        "rgba(75, 192, 192, 0.7)",';
                echo '        "rgba(153, 102, 255, 0.7)"';
                echo '      ],';
                echo '    }],';
                echo '  },';
                echo '  options: {';
                echo '    title: {';
                echo '      display: true,';
                echo '      text: "Most Purchased Items",';
                echo '    },';
                echo '  },';
                echo '});';
                echo '</script>';
            } else {
                echo 'No data available.';
            }
            ?>
        </div>
    </div>
</div>

    <!-- Right Column -->
    <div class="col-md-4">
        <!-- Top Buyer -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><b>Top Buyer</b></h3>
            </div>
            <div class="card-body">
                <canvas id="topCustomerChart" width="400" height="200"></canvas>
                <?php
                // Fetch the top 5 customers and their total spent
                $query = "SELECT customer_name, SUM(total_amount) AS total_spent
                          FROM invoice_list
                          GROUP BY customer_name
                          ORDER BY total_spent DESC
                          LIMIT 5"; // Fetching the top 5 customers

                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    // Prepare data for the bar chart
                    $xValues = [];
                    $yValues = [];

                    while ($row = $result->fetch_assoc()) {
                        $xValues[] = $row['customer_name'];
                        $yValues[] = $row['total_spent'];
                    }

                    // Output the bar chart data
                    echo '<script>';
                    echo 'var ctx = document.getElementById("topCustomerChart").getContext("2d");';
                    echo 'var topCustomerChart = new Chart(ctx, {';
                    echo '  type: "bar",';
                    echo '  data: {';
                    echo '    labels: ' . json_encode($xValues) . ',';
                    echo '    datasets: [{';
                    echo '      label: "Total Spent",';
                    echo '      data: ' . json_encode($yValues) . ',';
                    echo '      backgroundColor: [';
                    // You can customize the colors here if needed
                    echo '        "#28a745",'; // Green
                    echo '        "#4169E1",'; // Blue
                    echo '        "#ffc107",'; // Yellow
                    echo '        "#ff4d00",'; // Orange
                    echo '        "#a50110",'; // Red
                    echo '        "rgba(75, 192, 192, 0.7)",';
                    echo '        "rgba(153, 102, 255, 0.7)"';
                    echo '      ],';
                    echo '    }],';
                    echo '  },';
                    echo '  options: {';
                    echo '    title: {';
                    echo '      display: true,';
                    echo '      text: "Top Buyer",';
                    echo '    },';
                    echo '    scales: {';
                    echo '      y: {';
                    echo '        beginAtZero: true,';
                    echo '      },';
                    echo '    },';
                    echo '  },';
                    echo '});';
                    echo '</script>';
                } else {
                    echo 'No data available.';
                }
                ?>
            </div>
        </div>
    </div>

</div>
<!-- End of row -->