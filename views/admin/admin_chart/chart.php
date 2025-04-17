<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
        .main-chart {
                width: 100%;
                height: 600px;
                overflow-y: auto;
        }

        h1 {
                font-size: 28px;
                font-weight: bold;
                color: #fdd835;
                /* Đồng bộ màu vàng */
                text-align: center;
                margin-top: 20px;
                margin-bottom: 20px;
                text-transform: uppercase;
        }

        .chart-container {
                background: #1a1a1a;
                border-radius: 10px;
                margin-bottom: 20px;
                box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.1);
                max-width: 1000px;
                margin: 20px auto;
                height: 500px;
                display: none;
        }

        .chart-container.active {
                display: block;
                /* Hiển thị biểu đồ của trang hiện tại */
        }

        .chart-container h2 {
                margin-bottom: 10px;
        }

        .filter-form {
                text-align: center;
                margin-bottom: 20px;
        }

        .filter-form label {
                margin-right: 10px;
                color: #333;
        }

        .filter-form input {
                padding: 5px;
                border-radius: 5px;
                border: 1px solid #ccc;
                background-color: #3333;
                color: #fff;
        }

        .filter-form button {
                padding: 5px 15px;
                background-color: #fdd835;
                color: #000;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                margin-left: 20px;
                font-size: 16px;
                font-weight: bold;
                text-transform: uppercase;
        }

        .filter-form button:hover {
                background-color: #e6c200;
        }

        .pagination {
                text-align: center;
        }

        .pagination button {
                padding: 8px 16px;
                margin: 0 5px;
                background-color: #fdd835;
                color: #000;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 16px;
        }

        .pagination button:hover {
                background-color: #e6c200;
        }

        .pagination button:disabled {
                background-color: #666;
                cursor: not-allowed;
        }
</style>

<div class="main-content">
        <h1>Thống kê doanh thu</h1>

        <div class="filter-form">
                <form method="GET" action="">
                        <input type="hidden" name="controller" value="Revenue">
                        <input type="hidden" name="action" value="index">
                        <label for="start_date">Từ ngày:</label>
                        <input type="date" id="start_date" name="start_date"
                                value="<?php echo htmlspecialchars($startDate ?? date('Y-m-d')); ?>">
                        <label for="end_date">Đến ngày:</label>
                        <input type="date" id="end_date" name="end_date"
                                value="<?php echo htmlspecialchars($endDate ?? date('Y-m-d', strtotime('+30 days'))); ?>">
                        <button type="submit">Lọc</button>
                </form>
        </div>

        <div class="main-chart">
                <!-- Biểu đồ tổng doanh thu -->
                <div class="chart-container" id="chart-1">
                        <h2 style="text-align: center; color: #fdd835;">Tổng doanh thu</h2>
                        <canvas id="totalRevenueChart"></canvas>
                </div>

                <!-- Biểu đồ doanh thu theo rạp -->
                <div class="chart-container" id="chart-2">
                        <h2 style="text-align: center; color: #fdd835;">Doanh thu theo rạp</h2>
                        <canvas id="theaterRevenueChart"></canvas>
                </div>
                <div class="pagination">
                        <button id="prevBtn"><i class="fa fa-long-arrow-alt-left"></i></button>
                        <button id="nextBtn"><i class="fa fa-long-arrow-alt-right"></i></button>
                </div>
        </div>

        <!-- Nút phân trang -->
</div>

<script>
        // Phân trang
        const charts = document.querySelectorAll('.chart-container');
        let currentPage = 0;

        function showChart(page) {
                // Ẩn tất cả biểu đồ
                charts.forEach(chart => chart.classList.remove('active'));
                // Hiển thị biểu đồ của trang hiện tại
                charts[page].classList.add('active');

                // Cập nhật trạng thái nút
                document.getElementById('prevBtn').disabled = page === 0;
                document.getElementById('nextBtn').disabled = page === charts.length - 1;
        }

        // Hiển thị biểu đồ đầu tiên khi tải trang
        showChart(currentPage);

        // Xử lý nút Previous
        document.getElementById('prevBtn').addEventListener('click', () => {
                if (currentPage > 0) {
                        currentPage--;
                        showChart(currentPage);
                }
        });

        // Xử lý nút Next
        document.getElementById('nextBtn').addEventListener('click', () => {
                if (currentPage < charts.length - 1) {
                        currentPage++;
                        showChart(currentPage);
                }
        });

        // Biểu đồ tổng doanh thu
        const totalRevenueCtx = document.getElementById('totalRevenueChart').getContext('2d');
        new Chart(totalRevenueCtx, {
                type: 'line',
                data: {
                        labels: <?php echo json_encode($labels); ?>,
                        datasets: [{
                                label: 'Tổng doanh thu (VND)',
                                data: <?php echo $jsonData; ?>,
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
                                                callback: function(value) {
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
                                                color: '#bbb',
                                                maxTicksLimit: 10 // Giới hạn số lượng nhãn trên trục X
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
                                                label: function(context) {
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
                                                callback: function(value) {
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
                                                color: '#bbb',
                                                maxTicksLimit: 10 // Giới hạn số lượng nhãn trên trục X
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
                                                label: function(context) {
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