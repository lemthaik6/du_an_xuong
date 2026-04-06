<div style="display: flex; gap: 20px;">
    <div class="sidebar-menu">
        <h3>Menu</h3>
        <a href="<?php echo $baseUrl; ?>/dashboard">📊 Dashboard</a>
        <a href="<?php echo $baseUrl; ?>/users">👥 Quản lý Người dùng</a>
        <a href="<?php echo $baseUrl; ?>/categories">📑 Quản lý Danh mục</a>
        <a href="<?php echo $baseUrl; ?>/products">📦 Quản lý Sản phẩm</a>
        <a href="<?php echo $baseUrl; ?>/projects">📌 Quản lý Dự án</a>
        <a href="<?php echo $baseUrl; ?>/tasks">✓ Quản lý Tác vụ</a>
        <a href="<?php echo $baseUrl; ?>/teams">👨‍💼 Quản lý Đội nhóm</a>
        <a href="<?php echo $baseUrl; ?>/profile">⚙️ Hồ sơ của tôi</a>
    </div>
    
    <div class="main-content" style="flex: 1;">
        <!-- Chart.js Library -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
        
        <!-- Welcome Card -->
        <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; margin-bottom: 20px; padding: 30px;">
            <h2 style="margin: 0 0 10px 0; font-size: 28px;">📊 Dashboard Quản Trị</h2>
            <p style="margin: 0; opacity: 0.9;">Chào mừng bạn đến với trang quản lý hệ thống Du An Xuong</p>
        </div>
        
        <!-- Stats Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 20px;">
            <!-- Total Users -->
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center;">
                <div style="font-size: 40px; margin-bottom: 10px;">👥</div>
                <div style="font-size: 28px; font-weight: bold;"><?php echo $stats['total_users'] ?? 0; ?></div>
                <div style="font-size: 12px; opacity: 0.9; margin-top: 8px;">Người Dùng</div>
            </div>
            
            <!-- Total Projects -->
            <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center;">
                <div style="font-size: 40px; margin-bottom: 10px;">📌</div>
                <div style="font-size: 28px; font-weight: bold;"><?php echo $stats['total_projects'] ?? 0; ?></div>
                <div style="font-size: 12px; opacity: 0.9; margin-top: 8px;">Dự Án</div>
            </div>
            
            <!-- Total Tasks -->
            <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center;">
                <div style="font-size: 40px; margin-bottom: 10px;">✓</div>
                <div style="font-size: 28px; font-weight: bold;"><?php echo $stats['total_tasks'] ?? 0; ?></div>
                <div style="font-size: 12px; opacity: 0.9; margin-top: 8px;">Tác Vụ</div>
            </div>
            
            <!-- Total Teams -->
            <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center;">
                <div style="font-size: 40px; margin-bottom: 10px;">👨‍💼</div>
                <div style="font-size: 28px; font-weight: bold;"><?php echo $stats['total_teams'] ?? 0; ?></div>
                <div style="font-size: 12px; opacity: 0.9; margin-top: 8px;">Đội Nhóm</div>
            </div>
        </div>
        
        <!-- Charts Row 1 - Main Charts -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <!-- Pie Chart - Task Status -->
            <div class="card">
                <h3 style="margin-top: 0;">📊 Thống Kê Tác Vụ (Pie Chart)</h3>
                <canvas id="taskPieChart" style="max-height: 300px;"></canvas>
            </div>
            
            <!-- Column Chart - Overview Stats -->
            <div class="card">
                <h3 style="margin-top: 0;">📈 Biểu Đồ Tổng Quan</h3>
                <canvas id="statsColumnChart" style="max-height: 300px;"></canvas>
            </div>
        </div>
        
        <!-- Charts Row 2 - Tasks Overview -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <!-- Doughnut Chart - Task Status Alternative -->
            <div class="card">
                <h3 style="margin-top: 0;">🎯 Tỷ Lệ Hoàn Thành (Doughnut)</h3>
                <canvas id="taskDoughnutChart" style="max-height: 300px;"></canvas>
            </div>
            
            <!-- Bar Chart - Task Status Breakdown -->
            <div class="card">
                <h3 style="margin-top: 0;">📊 Chi Tiết Tác Vụ (Column)</h3>
                <canvas id="taskBarChart" style="max-height: 300px;"></canvas>
            </div>
        </div>
        
        <!-- Two Column Layout -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <!-- Overdue Tasks -->
            <div class="card">
                <h3 style="margin-top: 0; color: #e74c3c;">⚠️ Tác Vụ Quá Hạn</h3>
                <?php if (!empty($overdueTasks)): ?>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <?php foreach (array_slice($overdueTasks, 0, 5) as $task): ?>
                            <div style="padding: 12px; border-left: 4px solid #e74c3c; background: #fff5f5; border-radius: 4px;">
                                <div style="font-weight: bold; color: #2c3e50;"><?php echo htmlspecialchars($task['title']); ?></div>
                                <div style="font-size: 12px; color: #666; margin-top: 4px;">
                                    📌 <?php echo htmlspecialchars($task['project_name'] ?? 'N/A'); ?>
                                </div>
                                <div style="font-size: 12px; color: #666;">
                                    Hạn chót: <?php echo date('d/m/Y', strtotime($task['due_date'])); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div style="padding: 20px; text-align: center; color: #999;">
                        ✓ Không có tác vụ quá hạn
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Upcoming Tasks -->
            <div class="card">
                <h3 style="margin-top: 0; color: #f39c12;">⏰ Tác Vụ Sắp Tới (7 Ngày)</h3>
                <?php if (!empty($upcomingTasks)): ?>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <?php foreach (array_slice($upcomingTasks, 0, 5) as $task): ?>
                            <div style="padding: 12px; border-left: 4px solid #f39c12; background: #fffbf0; border-radius: 4px;">
                                <div style="font-weight: bold; color: #2c3e50;"><?php echo htmlspecialchars($task['title']); ?></div>
                                <div style="font-size: 12px; color: #666; margin-top: 4px;">
                                    📌 <?php echo htmlspecialchars($task['project_name'] ?? 'N/A'); ?>
                                </div>
                                <div style="font-size: 12px; color: #666;">
                                    Hạn chót: <?php echo date('d/m/Y', strtotime($task['due_date'])); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div style="padding: 20px; text-align: center; color: #999;">
                        ✓ Không có tác vụ sắp tới
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Recent Projects -->
        <div class="card" style="margin-top: 20px;">
            <h3 style="margin-top: 0;">📌 Dự Án Gần Đây</h3>
            <?php if (!empty($recentProjects)): ?>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid #ecf0f1;">
                            <th style="text-align: left; padding: 12px; color: #666; font-weight: 600; font-size: 13px;">Tên Dự Án</th>
                            <th style="text-align: left; padding: 12px; color: #666; font-weight: 600; font-size: 13px;">Trạng Thái</th>
                            <th style="text-align: left; padding: 12px; color: #666; font-weight: 600; font-size: 13px;">Tiến Độ</th>
                            <th style="text-align: left; padding: 12px; color: #666; font-weight: 600; font-size: 13px;">Ngày Tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($recentProjects, 0, 5) as $project): ?>
                            <tr style="border-bottom: 1px solid #ecf0f1;">
                                <td style="padding: 12px;"><a href="<?php echo $baseUrl; ?>/projects/<?php echo $project['id']; ?>" style="color: #3498db; text-decoration: none;"><?php echo htmlspecialchars($project['name']); ?></a></td>
                                <td style="padding: 12px;">
                                    <span style="display: inline-block; padding: 4px 8px; background: <?php 
                                        echo $project['status'] == 'planning' ? '#3498db' : 
                                             ($project['status'] == 'in_progress' ? '#f39c12' : 
                                              ($project['status'] == 'completed' ? '#27ae60' : '#95a5a6'));
                                    ?>; color: white; border-radius: 3px; font-size: 12px;">
                                        <?php 
                                            $statusMap = ['planning' => 'Kế Hoạch', 'in_progress' => 'Đang Làm', 'completed' => 'Hoàn Thành', 'cancelled' => 'Hủy'];
                                            echo $statusMap[$project['status']] ?? $project['status'];
                                        ?>
                                    </span>
                                </td>
                                <td style="padding: 12px;">
                                    <div style="width: 60px; height: 6px; background: #ecf0f1; border-radius: 3px; overflow: hidden;">
                                        <div style="height: 100%; background: #3498db; width: <?php echo min(100, $project['progress'] ?? 0); ?>%;"></div>
                                    </div>
                                    <span style="font-size: 11px; color: #999;"><?php echo $project['progress'] ?? 0; ?>%</span>
                                </td>
                                <td style="padding: 12px; font-size: 12px; color: #666;"><?php echo date('d/m/Y', strtotime($project['created_at'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div style="padding: 20px; text-align: center; color: #999;">
                    Chưa có dự án nào
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Teams List -->
        <div class="card" style="margin-top: 20px;">
            <h3 style="margin-top: 0;">👨‍💼 Các Đội Nhóm</h3>
            <?php if (!empty($allTeams)): ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px;">
                    <?php foreach (array_slice($allTeams, 0, 8) as $team): ?>
                        <div style="padding: 16px; border: 1px solid #ecf0f1; border-radius: 8px; transition: all 0.3s ease;">
                            <h4 style="margin: 0 0 8px 0; color: #2c3e50;"><?php echo htmlspecialchars($team['name']); ?></h4>
                            <p style="margin: 0 0 12px 0; font-size: 12px; color: #666; height: 30px; overflow: hidden;"><?php echo htmlspecialchars(substr($team['description'] ?? '', 0, 50)); ?></p>
                            <a href="<?php echo $baseUrl; ?>/teams/<?php echo $team['id']; ?>" style="display: inline-block; padding: 6px 12px; background: #3498db; color: white; text-decoration: none; border-radius: 4px; font-size: 12px;">Xem Chi Tiết</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div style="padding: 20px; text-align: center; color: #999;">
                    Chưa có đội nhóm nào
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Chart.js Configuration
    Chart.defaults.font.family = "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
    
    // 1. Task Pie Chart
    const taskPieCtx = document.getElementById('taskPieChart').getContext('2d');
    new Chart(taskPieCtx, {
        type: 'doughnut',
        data: {
            labels: ['Chưa Làm', 'Đang Làm', 'Hoàn Thành'],
            datasets: [{
                data: [
                    <?php echo $stats['todo_tasks'] ?? 0; ?>,
                    <?php echo $stats['in_progress_tasks'] ?? 0; ?>,
                    <?php echo $stats['completed_tasks'] ?? 0; ?>
                ],
                backgroundColor: ['#95a5a6', '#f39c12', '#27ae60'],
                borderColor: ['#7f8c8d', '#e67e22', '#229954'],
                borderWidth: 2,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: { size: 13 },
                        usePointStyle: true
                    }
                }
            }
        }
    });
    
    // 2. Stats Column Chart
    const statsCtx = document.getElementById('statsColumnChart').getContext('2d');
    new Chart(statsCtx, {
        type: 'bar',
        data: {
            labels: ['Người Dùng', 'Dự Án', 'Tác Vụ', 'Đội Nhóm'],
            datasets: [{
                label: 'Tổng Số',
                data: [
                    <?php echo $stats['total_users'] ?? 0; ?>,
                    <?php echo $stats['total_projects'] ?? 0; ?>,
                    <?php echo $stats['total_tasks'] ?? 0; ?>,
                    <?php echo $stats['total_teams'] ?? 0; ?>
                ],
                backgroundColor: [
                    'rgba(102, 126, 234, 0.8)',
                    'rgba(240, 147, 251, 0.8)',
                    'rgba(79, 172, 254, 0.8)',
                    'rgba(250, 112, 154, 0.8)'
                ],
                borderColor: [
                    '#667eea',
                    '#f093fb',
                    '#4facfe',
                    '#fa709a'
                ],
                borderWidth: 2,
                borderRadius: 8,
                hoverBackgroundColor: [
                    'rgba(102, 126, 234, 1)',
                    'rgba(240, 147, 251, 1)',
                    'rgba(79, 172, 254, 1)',
                    'rgba(250, 112, 154, 1)'
                ]
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: { font: { size: 12 } },
                    grid: { color: '#ecf0f1' }
                },
                y: {
                    ticks: { font: { size: 12 } },
                    grid: { display: false }
                }
            }
        }
    });
    
    // 3. Task Doughnut Chart
    const taskDoughnutCtx = document.getElementById('taskDoughnutChart').getContext('2d');
    const completedTasks = <?php echo $stats['completed_tasks'] ?? 0; ?>;
    const totalTasks = <?php echo $stats['total_tasks'] ?? 0; ?>;
    const incompleteTasks = totalTasks - completedTasks;
    
    new Chart(taskDoughnutCtx, {
        type: 'doughnut',
        data: {
            labels: ['Hoàn Thành', 'Chưa Hoàn Thành'],
            datasets: [{
                data: [completedTasks, incompleteTasks],
                backgroundColor: ['#27ae60', '#e74c3c'],
                borderColor: ['#229954', '#c0392b'],
                borderWidth: 2,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: { size: 13 },
                        usePointStyle: true
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const value = context.parsed;
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${context.label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
    
    // 4. Task Bar Chart
    const taskBarCtx = document.getElementById('taskBarChart').getContext('2d');
    new Chart(taskBarCtx, {
        type: 'bar',
        data: {
            labels: ['Chưa Làm', 'Đang Làm', 'Hoàn Thành'],
            datasets: [{
                label: 'Số Tác Vụ',
                data: [
                    <?php echo $stats['todo_tasks'] ?? 0; ?>,
                    <?php echo $stats['in_progress_tasks'] ?? 0; ?>,
                    <?php echo $stats['completed_tasks'] ?? 0; ?>
                ],
                backgroundColor: ['#95a5a6', '#f39c12', '#27ae60'],
                borderColor: ['#7f8c8d', '#e67e22', '#229954'],
                borderWidth: 2,
                borderRadius: 8,
                hoverBackgroundColor: ['#7f8c8d', '#e67e22', '#229954']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { font: { size: 12 } },
                    grid: { color: '#ecf0f1' }
                },
                x: {
                    ticks: { font: { size: 12 } },
                    grid: { display: false }
                }
            }
        }
    });
</script>
