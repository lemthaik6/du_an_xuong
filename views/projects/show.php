<div style="max-width: 1000px; margin: 0 auto;">
    <div class="card" style="margin-bottom: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: start; gap: 20px;">
            <div style="flex: 1;">
                <h2 style="margin: 0 0 12px 0; color: #2c3e50;"><?php echo htmlspecialchars($project['name']); ?></h2>
                <p style="color: #666; margin: 0;">
                    <strong>Danh mục:</strong> <?php echo htmlspecialchars($project['category_name'] ?? 'N/A'); ?>
                </p>
            </div>
            <span style="background: <?php echo $project['status'] == 'planning' ? '#3498db' : ($project['status'] == 'in_progress' ? '#f39c12' : '#27ae60'); ?>; color: white; padding: 8px 12px; border-radius: 4px; white-space: nowrap;">
                <?php 
                    $statusMap = [
                        'planning' => '📋 Lên kế hoạch',
                        'in_progress' => '🔄 Đang tiến hành',
                        'completed' => '✔️ Hoàn thành',
                        'cancelled' => '❌ Hủy'
                    ];
                    echo $statusMap[$project['status']] ?? $project['status'];
                ?>
            </span>
        </div>
    </div>
    
    <div class="card" style="margin-bottom: 20px;">
        <h3 style="margin-top: 0;">📝 Mô Tả</h3>
        <p style="color: #333; line-height: 1.6;"><?php echo nl2br(htmlspecialchars($project['description'] ?? 'Không có mô tả')); ?></p>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
        <div class="card">
            <h3 style="margin-top: 0;">📅 Thông Tin</h3>
            <p style="margin: 8px 0;">
                <strong>Ngày bắt đầu:</strong><br>
                <?php echo $project['start_date'] ? date('d/m/Y', strtotime($project['start_date'])) : 'Không có'; ?>
            </p>
            <p style="margin: 8px 0;">
                <strong>Ngày kết thúc:</strong><br>
                <?php echo $project['end_date'] ? date('d/m/Y', strtotime($project['end_date'])) : 'Không có'; ?>
            </p>
            <?php if ($project['budget']): ?>
                <p style="margin: 8px 0;">
                    <strong>Ngân sách:</strong><br>
                    <?php echo number_format($project['budget'], 0, ',', '.'); ?> VND
                </p>
            <?php endif; ?>
        </div>
        
        <div class="card">
            <h3 style="margin-top: 0;">📊 Tiến Độ</h3>
            <div style="background: #ecf0f1; border-radius: 4px; overflow: hidden; height: 50px; margin-bottom: 8px;">
                <div style="background: linear-gradient(90deg, #3498db, #2980b9); height: 100%; width: <?php echo $project['progress']; ?>%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 18px;">
                    <?php echo $project['progress']; ?>%
                </div>
            </div>
        </div>
    </div>
    
    <!-- SECTION: Teams Management -->
    <?php if (isset($isAdmin) && $isAdmin): ?>
    <div class="card" style="margin-bottom: 20px; background: #f0f8ff; border: 2px solid #3498db;">
        <h3 style="margin-top: 0; color: #2980b9;">👥 Phân Công Đội Nhóm Quản Lý Dự Án</h3>
        
        <?php if (!empty($assignedTeams)): ?>
            <div style="margin-bottom: 16px;">
                <p style="margin: 0 0 12px 0; color: #333; font-weight: bold;">Đội nhóm hiện quản lý:</p>
                <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                    <?php foreach ($assignedTeams as $team): ?>
                        <span style="background: #27ae60; color: white; padding: 8px 12px; border-radius: 20px; font-size: 14px;">
                            ✓ <?php echo htmlspecialchars($team['name']); ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo $baseUrl; ?>/projects/<?php echo $project['id']; ?>/update-teams" style="background: white; padding: 16px; border-radius: 8px;">
            <p style="margin-top: 0; color: #555; font-size: 14px;">Tích chọn các đội nhóm để phân công quản lý dự án:</p>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 12px; margin-bottom: 16px;">
                <?php if (!empty($allTeams)): ?>
                    <?php foreach ($allTeams as $team): ?>
                        <?php 
                            $isChecked = false;
                            foreach ($assignedTeams as $assigned) {
                                if ($assigned['id'] == $team['id']) {
                                    $isChecked = true;
                                    break;
                                }
                            }
                        ?>
                        <div style="display: flex; align-items: center; padding: 8px; background: #f9f9f9; border-radius: 5px; border: 1px solid #ddd;">
                            <input 
                                type="checkbox" 
                                name="team_ids[]" 
                                value="<?php echo $team['id']; ?>"
                                id="team_<?php echo $team['id']; ?>"
                                <?php echo $isChecked ? 'checked' : ''; ?>
                                style="margin-right: 8px; cursor: pointer; width: 18px; height: 18px;"
                            >
                            <label for="team_<?php echo $team['id']; ?>" style="cursor: pointer; margin: 0; flex: 1; font-weight: 500;">
                                <?php echo htmlspecialchars($team['name']); ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: #999;">Chưa có đội nhóm nào trong hệ thống</p>
                <?php endif; ?>
            </div>
            
            <button type="submit" style="background: #2980b9; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">
                💾 Cập Nhật Phân Công
            </button>
        </form>
    </div>
    <?php endif; ?>
    
    <div class="card">
        <div style="margin-bottom: 16px;">
            <h3 style="margin: 0;">✓ Tác Vụ Trong Dự Án</h3>
        </div>
        <?php if (!empty($tasks)): ?>
            <div style="display: grid; gap: 12px;">
                <?php foreach ($tasks as $task): ?>
                    <div style="padding: 12px; border: 1px solid #ecf0f1; border-radius: 4px; cursor: pointer; transition: all 0.2s;">
                        <a href="<?php echo $baseUrl; ?>/tasks/<?php echo $task['id']; ?>" style="text-decoration: none; color: inherit;">
                            <div style="display: flex; justify-content: space-between; align-items: start; gap: 12px;">
                                <div style="flex: 1;">
                                    <h4 style="margin: 0 0 6px 0; color: #2c3e50;">
                                        <?php echo htmlspecialchars($task['title']); ?>
                                    </h4>
                                    <p style="margin: 0; font-size: 13px; color: #666;">
                                        Người làm: <?php echo htmlspecialchars($task['assigned_name'] ?? 'Chưa gán'); ?>
                                    </p>
                                </div>
                                <span style="background: <?php echo $task['status'] == 'todo' ? '#95a5a6' : ($task['status'] == 'in_progress' ? '#f39c12' : '#27ae60'); ?>; color: white; padding: 4px 8px; border-radius: 3px; font-size: 12px; white-space: nowrap;">
                                    <?php 
                                        $statusMap = [
                                            'todo' => 'Chưa làm',
                                            'in_progress' => 'Đang làm',
                                            'completed' => 'Hoàn thành'
                                        ];
                                        echo $statusMap[$task['status']] ?? $task['status'];
                                    ?>
                                </span>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p style="color: #999; text-align: center; padding: 20px;">
                Chưa có tác vụ trong dự án này.
            </p>
        <?php endif; ?>
    </div>
    
    <div class="card">
        <a href="<?php echo $baseUrl; ?>/projects" class="btn btn-primary">← Quay Lại Danh Sách Dự Án</a>
    </div>
</div>
