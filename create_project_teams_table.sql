-- Tạo bảng project_teams để liên kết dự án với nhiều đội nhóm
CREATE TABLE IF NOT EXISTS `project_teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `project_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `assigned_date` timestamp DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`team_id`) REFERENCES `teams`(`id`) ON DELETE CASCADE,
  UNIQUE KEY `unique_project_team` (`project_id`, `team_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
