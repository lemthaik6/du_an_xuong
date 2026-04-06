-- Tạo bảng task_members để liên kết tác vụ với thành viên đội nhóm
CREATE TABLE IF NOT EXISTS `task_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `assigned_date` timestamp DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`task_id`) REFERENCES `tasks`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  UNIQUE KEY `unique_task_member` (`task_id`, `user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
