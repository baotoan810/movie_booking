<!DOCTYPE html>
<html>

<head>
        <title>Doanh thu - Admin</title>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <style>
                body {
                        background-color: #121212;
                        color: #fff;
                        font-family: Arial, sans-serif;
                        padding: 20px;
                }

                h1 {
                        font-size: 28px;
                        font-weight: bold;
                        color: #fdd835;
                        text-align: center;
                        margin-top: 20px;
                        margin-bottom: 20px;
                }

                .chart-container {
                        background: #1a1a1a;
                        padding: 20px;
                        border-radius: 10px;
                        margin-bottom: 20px;
                        box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.1);
                        max-width: 800px;
                        margin: 0 auto;
                }

                .filter-form {
                        text-align: center;
                        margin-bottom: 20px;
                }

                .filter-form label {
                        margin-right: 10px;
                        color: #bbb;
                }

                .filter-form input {
                        padding: 5px;
                        border-radius: 5px;
                        border: 1px solid #ccc;
                        background-color: #333;
                        color: #fff;
                }

                .filter-form button {
                        padding: 5px 15px;
                        background-color: #fdd835;
                        color: #000;
                        border: none;
                        border-radius: 5px;
                        cursor: pointer;
                }

                .filter-form button:hover {
                        background-color: #e6c200;
                }
        </style>
</head>

<body>
        <h1>Thống kê doanh thu</h1>

        <!-- Form lọc thời gian -->
        <div class="filter-form">
                <form method="GET" action="admin.php?controller=revenue&action=index">
                        <label for="start_date">Từ ngày:</label>
                        <input type="date" id="start_date" name="start_date"
                                value="<?php echo htmlspecialchars($startDate ?? ''); ?>">
                        <label for="end_date">Đến ngày:</label>
                        <input type="date" id="end_date" name="end_date"
                                value="<?php echo htmlspecialchars($endDate ?? ''); ?>">
                        <button type="submit">Lọc</button>
                </form>
        </div>

        <!-- Biểu đồ tổng doanh thu -->
        <div class="chart-container">
                <h2 style="text-align: center; color: #fdd835;">Tổng doanh thu</h2>
                <canvas id="totalRevenueChart"></canvas>
        </div>

        <!-- Biểu đồ doanh thu theo rạp -->
        <div class="chart-container">
                <h2 style="text-align: center; color: #fdd835;">Doanh thu theo rạp</h2>
                <canvas id="theaterRevenueChart"></canvas>
        </div>

        <script>
                // Biểu đồ tổng doanh thu
                const totalRevenueCtx = document.getElementById('totalRevenueChart').getContext('2d');
                new Chart(totalRevenueCtx, {
                        type: 'line',
                        data: {
                                labels: <?php echo json_encode($labels); ?>,
                                datasets: [{
                                        label: 'Tổng doanh thu (VND)',
                                        data: <?php echo json_encode($data); ?>,
                                        borderColor: '#fdd835',
                                        backgroundColor: 'rgba(253, 216, 53, 0.2)',
                                        fill: true,
                                        tension: 0.1
                                }]
                        },
                        options: {
                                responsive: true,
                                scales: {
                                        y: {
                                                beginAtZero: true,
                                                title: {
                                                        display: true,
                                                        text: 'Doanh thu (VND)',
                                                        color: '#fff'
                                                },
                                                ticks: {
                                                        color: '#bbb',
                                                        callback: function (value) {
                                                                return value.toLocaleString('vi-VN');
                                                        }
                                                },
                                                grid: {
                                                        color: '#333'
                                                }
                                        },
                                        x: {
                                                title: {
                                                        display: true,
                                                        text: 'Ngày',
                                                        color: '#fff'
                                                },
                                                ticks: {
                                                        color: '#bbb'
                                                },
                                                grid: {
                                                        color: '#333'
                                                }
                                        }
                                },
                                plugins: {
                                        legend: {
                                                labels: {
                                                        color: '#fff'
                                                }
                                        },
                                        tooltip: {
                                                callbacks: {
                                                        label: function (context) {
                                                                let label = context.dataset.label || '';
                                                                if (label) {
                                                                        label += ': ';
                                                                }
                                                                label += context.parsed.y.toLocaleString('vi-VN') + ' VND';
                                                                return label;
                                                        }
                                                }
                                        }
                                }
                        }
                });

                // Biểu đồ doanh thu theo rạp
                const theaterRevenueCtx = document.getElementById('theaterRevenueChart').getContext('2d');
                new Chart(theaterRevenueCtx, {
                        type: 'line',
                        data: {
                                labels: <?php echo json_encode($allDates); ?>,
                                datasets: <?php echo json_encode($datasets); ?>
                        },
                        options: {
                                responsive: true,
                                scales: {
                                        y: {
                                                beginAtZero: true,
                                                title: {
                                                        display: true,
                                                        text: 'Doanh thu (VND)',
                                                        color: '#fff'
                                                },
                                                ticks: {
                                                        color: '#bbb',
                                                        callback: function (value) {
                                                                return value.toLocaleString('vi-VN');
                                                        }
                                                },
                                                grid: {
                                                        color: '#333'
                                                }
                                        },
                                        x: {
                                                title: {
                                                        display: true,
                                                        text: 'Ngày',
                                                        color: '#fff'
                                                },
                                                ticks: {
                                                        color: '#bbb'
                                                },
                                                grid: {
                                                        color: '#333'
                                                }
                                        }
                                },
                                plugins: {
                                        legend: {
                                                labels: {
                                                        color: '#fff'
                                                }
                                        },
                                        tooltip: {
                                                callbacks: {
                                                        label: function (context) {
                                                                let label = context.dataset.label || '';
                                                                if (label) {
                                                                        label += ': ';
                                                                }
                                                                label += context.parsed.y.toLocaleString('vi-VN') + ' VND';
                                                                return label;
                                                        }
                                                }
                                        }
                                }
                        }
                });
        </script>
</body>

</html>