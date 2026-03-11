<div style="display: flex; gap: 20px;">
    <div class="sidebar-menu">
        <h3>Menu</h3>
        <a href="/du_an_xuong/public/dashboard">📊 Dashboard</a>
        <a href="/du_an_xuong/public/projects">📌 Dự án của tôi</a>
        <a href="/du_an_xuong/public/tasks">✓ Tác vụ của tôi</a>
        <a href="/du_an_xuong/public/teams">👨‍💼 Đội nhóm</a>
        <a href="/du_an_xuong/public/profile">⚙️ Hồ sơ của tôi</a>
    </div>
    
    <div class="main-content">
        <div class="card">
            <h2>Dashboard</h2>
            <p>Xin chào, <?php echo htmlspecialchars($_SESSION['full_name'] ?? 'User'); ?></p>
        </div>
        
        <div class="stats">
            <div class="stat-card" style="border-left-color: #3498db;">
                <h3>Dự Án Được Phân Công</h3>
                <div class="value"><?php echo $stats['assigned_projects'] ?? 0; ?></div>
            </div>
            <div class="stat-card" style="border-left-color: #e74c3c;">
                <h3>Tác Vụ Quá Hạn</h3>
                <div class="value"><?php echo $stats['overdue_tasks'] ?? 0; ?></div>
            </div>
            <div class="stat-card" style="border-left-color: #2ecc71;">
                <h3>Tác Vụ Sắp Tới</h3>
                <div class="value"><?php echo $stats['upcoming_tasks'] ?? 0; ?></div>
            </div>
        </div>
        
        <?php if (!empty($overdue_tasks)): ?>
            <div class="card">
                <h2 style="color: #e74c3c;">⚠️ Tác Vụ Quá Hạn</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Tiêu Đề</th>
                            <th>Dự Án</th>
                            <th>Hạn Chót</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($overdue_tasks as $task): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($task['title']); ?></td>
                                <td><?php echo htmlspecialchars($task['project_name'] ?? 'N/A'); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($task['due_date'])); ?></td>
                                <td>
                                    <a href="/du_an_xuong/public/tasks/<?php echo $task['id']; ?>" class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">Xem</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($upcoming_tasks)): ?>
            <div class="card">
                <h2>📅 Tác Vụ Sắp Tới</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Tiêu Đề</th>
                            <th>Dự Án</th>
                            <th>Hạn Chót</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($upcoming_tasks as $task): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($task['title']); ?></td>
                                <td><?php echo htmlspecialchars($task['project_name'] ?? 'N/A'); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($task['due_date'])); ?></td>
                                <td>
                                    <a href="/du_an_xuong/public/tasks/<?php echo $task['id']; ?>" class="btn btn-primary" style="font-size: 12px; padding: 6px 12px;">Xem</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
