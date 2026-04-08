<div style="display: flex; gap: 20px;">
    <div class="sidebar-menu">
        <h3>Menu</h3>
        <a href="<?php echo $baseUrl; ?>/dashboard">📊 Dashboard</a>
        <a href="<?php echo $baseUrl; ?>/projects">📌 Dự án của tôi</a>
        <a href="<?php echo $baseUrl; ?>/tasks">✓ Tác vụ của tôi</a>
        <a href="<?php echo $baseUrl; ?>/teams">👨‍💼 Đội nhóm</a>
        <a href="<?php echo $baseUrl; ?>/contact">📧 Liên hệ</a>
        <a href="<?php echo $baseUrl; ?>/profile">⚙️ Hồ sơ của tôi</a>
        <a href="<?php echo $baseUrl; ?>/logout">🚪 Đăng xuất</a>
    </div>
    
    <div class="main-content" style="flex: 1;">
        <!-- Chart.js Library -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.js"></script>
        
        <!-- Welcome Card -->
        <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; margin-bottom: 20px; padding: 30px;">
            <h2 style="margin: 0 0 10px 0; font-size: 28px;">👋 Xin chào, <?php echo htmlspecialchars($_SESSION['full_name'] ?? 'User'); ?></h2>
            <p style="margin: 0; opacity: 0.9;">Đây là dashboard cá nhân của bạn - quản lý các dự án và tác vụ được giao</p>
        </div>
        
        <!-- Stats Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px; margin-bottom: 20px;">
            <!-- Assigned Projects -->
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center;">
                <div style="font-size: 40px; margin-bottom: 10px;">📌</div>
                <div style="font-size: 28px; font-weight: bold;"><?php echo $stats['assigned_projects'] ?? 0; ?></div>
                <div style="font-size: 12px; opacity: 0.9; margin-top: 8px;">Dự Án</div>
            </div>
            
            <!-- Assigned Tasks -->
            <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center;">
                <div style="font-size: 40px; margin-bottom: 10px;">✓</div>
                <div style="font-size: 28px; font-weight: bold;"><?php echo $stats['assigned_tasks'] ?? 0; ?></div>
                <div style="font-size: 12px; opacity: 0.9; margin-top: 8px;">Tác Vụ</div>
            </div>
            
            <!-- Overdue Tasks -->
            <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center;">
                <div style="font-size: 40px; margin-bottom: 10px;">⚠️</div>
                <div style="font-size: 28px; font-weight: bold;"><?php echo $stats['overdue_tasks'] ?? 0; ?></div>
                <div style="font-size: 12px; opacity: 0.9; margin-top: 8px;">Quá Hạn</div>
            </div>
            
            <!-- Upcoming Tasks -->
            <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center;">
                <div style="font-size: 40px; margin-bottom: 10px;">⏰</div>
                <div style="font-size: 28px; font-weight: bold;"><?php echo $stats['upcoming_tasks'] ?? 0; ?></div>
                <div style="font-size: 12px; opacity: 0.9; margin-top: 8px;">Sắp Tới</div>
            </div>
        </div>
        
        <!-- Charts Row -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <!-- Task Overview Chart -->
            <div class="card">
                <h3 style="margin-top: 0;">📊 Tổng Quan Tác Vụ</h3>
                <canvas id="taskOverviewChart" style="max-height: 300px;"></canvas>
            </div>
            
            <!-- Task Status Chart -->
            <div class="card">
                <h3 style="margin-top: 0;">🎯 Trạng Thái Tác Vụ</h3>
                <canvas id="taskStatusChart" style="max-height: 300px;"></canvas>
            </div>
        </div>
        
        <!-- Two Column Layout -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <?php if (!empty($overdue_tasks)): ?>
            <!-- Overdue Tasks -->
            <div class="card">
                <h3 style="margin-top: 0; color: #e74c3c;">⚠️ Tác Vụ Quá Hạn</h3>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <?php foreach (array_slice($overdue_tasks, 0, 5) as $task): ?>
                        <div style="padding: 12px; border-left: 4px solid #e74c3c; background: #fff5f5; border-radius: 4px;">
                            <div style="font-weight: bold; color: #2c3e50;"><?php echo htmlspecialchars($task['title']); ?></div>
                            <div style="font-size: 12px; color: #666; margin-top: 4px;">
                                📌 <?php echo htmlspecialchars($task['project_name'] ?? 'N/A'); ?>
                            </div>
                            <div style="font-size: 12px; color: #666;">
                                Hạn chót: <?php echo date('d/m/Y', strtotime($task['due_date'])); ?>
                            </div>
                            <a href="<?php echo $baseUrl; ?>/tasks/<?php echo $task['id']; ?>" style="display: inline-block; margin-top: 8px; padding: 6px 12px; background: #e74c3c; color: white; text-decoration: none; border-radius: 4px; font-size: 12px;">Xem Chi Tiết</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php else: ?>
            <div class="card">
                <h3 style="margin-top: 0; color: #27ae60;">✓ Không có tác vụ quá hạn</h3>
                <div style="padding: 40px; text-align: center;">
                    <div style="font-size: 48px; margin-bottom: 10px;">🎉</div>
                    <div style="color: #666;">Bạn không có tác vụ nào đã quá hạn. Tiếp tục hoàn thành tốt!</div>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($upcoming_tasks)): ?>
            <!-- Upcoming Tasks -->
            <div class="card">
                <h3 style="margin-top: 0; color: #f39c12;">⏰ Tác Vụ Sắp Tới (7 Ngày)</h3>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <?php foreach (array_slice($upcoming_tasks, 0, 5) as $task): ?>
                        <div style="padding: 12px; border-left: 4px solid #f39c12; background: #fffbf0; border-radius: 4px;">
                            <div style="font-weight: bold; color: #2c3e50;"><?php echo htmlspecialchars($task['title']); ?></div>
                            <div style="font-size: 12px; color: #666; margin-top: 4px;">
                                📌 <?php echo htmlspecialchars($task['project_name'] ?? 'N/A'); ?>
                            </div>
                            <div style="font-size: 12px; color: #666;">
                                Hạn chót: <?php echo date('d/m/Y', strtotime($task['due_date'])); ?>
                            </div>
                            <a href="<?php echo $baseUrl; ?>/tasks/<?php echo $task['id']; ?>" style="display: inline-block; margin-top: 8px; padding: 6px 12px; background: #f39c12; color: white; text-decoration: none; border-radius: 4px; font-size: 12px;">Xem Chi Tiết</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php else: ?>
            <div class="card">
                <h3 style="margin-top: 0; color: #3498db;">ℹ️ Không có tác vụ sắp tới</h3>
                <div style="padding: 40px; text-align: center;">
                    <div style="font-size: 48px; margin-bottom: 10px;">😎</div>
                    <div style="color: #666;">Không có tác vụ nào trong 7 ngày tới. Bạn có thể nghỉ ngơi!</div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- My Projects -->
        <div class="card">
            <h3 style="margin-top: 0;">📌 Dự Án Của Tôi</h3>
            <?php if (!empty($myProjects)): ?>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid #ecf0f1;">
                            <th style="text-align: left; padding: 12px; color: #666; font-weight: 600; font-size: 13px;">Dự Án</th>
                            <th style="text-align: left; padding: 12px; color: #666; font-weight: 600; font-size: 13px;">Trạng Thái</th>
                            <th style="text-align: left; padding: 12px; color: #666; font-weight: 600; font-size: 13px;">Tiến Độ</th>
                            <th style="text-align: left; padding: 12px; color: #666; font-weight: 600; font-size: 13px;">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($myProjects, 0, 5) as $project): ?>
                            <tr style="border-bottom: 1px solid #ecf0f1;">
                                <td style="padding: 12px;"><a href="<?php echo $baseUrl; ?>/projects/<?php echo $project['id']; ?>" style="color: #3498db; text-decoration: none; font-weight: 500;"><?php echo htmlspecialchars($project['name']); ?></a></td>
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
                                    <div style="width: 80px; height: 6px; background: #ecf0f1; border-radius: 3px; overflow: hidden; margin-bottom: 4px;">
                                        <div style="height: 100%; background: #3498db; width: <?php echo min(100, $project['progress'] ?? 0); ?>%;"></div>
                                    </div>
                                    <span style="font-size: 11px; color: #999;"><?php echo $project['progress'] ?? 0; ?>%</span>
                                </td>
                                <td style="padding: 12px;">
                                    <a href="<?php echo $baseUrl; ?>/projects/<?php echo $project['id']; ?>" style="display: inline-block; padding: 6px 12px; background: #3498db; color: white; text-decoration: none; border-radius: 4px; font-size: 12px;">Xem</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div style="padding: 20px; text-align: center; color: #999;">
                    Chưa có dự án nào được giao cho bạn
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Chart.js Configuration
    Chart.defaults.font.family = "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
    
    // Task Overview Chart (Column)
    const taskOverviewCtx = document.getElementById('taskOverviewChart').getContext('2d');
    new Chart(taskOverviewCtx, {
        type: 'bar',
        data: {
            labels: ['Dự Án', 'Tác Vụ', 'Quá Hạn', 'Sắp Tới'],
            datasets: [{
                label: 'Số Lượng',
                data: [
                    <?php echo $stats['assigned_projects'] ?? 0; ?>,
                    <?php echo $stats['assigned_tasks'] ?? 0; ?>,
                    <?php echo $stats['overdue_tasks'] ?? 0; ?>,
                    <?php echo $stats['upcoming_tasks'] ?? 0; ?>
                ],
                backgroundColor: [
                    'rgba(102, 126, 234, 0.8)',
                    'rgba(79, 172, 254, 0.8)',
                    'rgba(240, 147, 251, 0.8)',
                    'rgba(250, 112, 154, 0.8)'
                ],
                borderColor: [
                    '#667eea',
                    '#4facfe',
                    '#f093fb',
                    '#fa709a'
                ],
                borderWidth: 2,
                borderRadius: 8,
                hoverBackgroundColor: [
                    'rgba(102, 126, 234, 1)',
                    'rgba(79, 172, 254, 1)',
                    'rgba(240, 147, 251, 1)',
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
    
    // Task Status Breakdown Chart (Column)
    const taskStatusCtx = document.getElementById('taskStatusChart').getContext('2d');
    new Chart(taskStatusCtx, {
        type: 'bar',
        data: {
            labels: ['Chưa Làm', 'Đang Làm', 'Hoàn Thành'],
            datasets: [{
                label: 'Tác Vụ',
                data: [
                    <?php 
                        $todoCount = 0;
                        $inProgressCount = 0;
                        $completedCount = 0;
                        if (!empty($assignedTasks)) {
                            foreach ($assignedTasks as $task) {
                                if ($task['status'] == 'todo') $todoCount++;
                                else if ($task['status'] == 'in_progress') $inProgressCount++;
                                else if ($task['status'] == 'completed') $completedCount++;
                            }
                        }
                        echo $todoCount;
                    ?>,
                    <?php echo $inProgressCount; ?>,
                    <?php echo $completedCount; ?>
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
