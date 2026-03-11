<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Du An Xuong'; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            color: #333;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            background: #2c3e50;
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        header h1 {
            font-size: 24px;
            margin: 0;
        }
        
        nav {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        
        nav a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background 0.3s;
        }
        
        nav a:hover {
            background: #34495e;
        }
        
        .sidebar {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .sidebar-menu {
            width: 250px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .sidebar-menu a {
            display: block;
            padding: 12px 16px;
            color: #2c3e50;
            text-decoration: none;
            border-radius: 4px;
            margin-bottom: 8px;
            transition: background 0.3s;
        }
        
        .sidebar-menu a:hover {
            background: #ecf0f1;
        }
        
        .main-content {
            flex: 1;
        }
        
        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .card h2 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        table th {
            background: #34495e;
            color: white;
            padding: 12px;
            text-align: left;
        }
        
        table td {
            padding: 12px;
            border-bottom: 1px solid #ecf0f1;
        }
        
        table tr:hover {
            background: #f8f9fa;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.3s;
            font-size: 14px;
        }
        
        .btn-primary {
            background: #3498db;
            color: white;
        }
        
        .btn-primary:hover {
            background: #2980b9;
        }
        
        .btn-success {
            background: #27ae60;
            color: white;
        }
        
        .btn-success:hover {
            background: #229954;
        }
        
        .btn-danger {
            background: #e74c3c;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c0392b;
        }
        
        .btn-warning {
            background: #f39c12;
            color: white;
        }
        
        .btn-warning:hover {
            background: #d68910;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #2c3e50;
        }
        
        input, textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #bdc3c7;
            border-radius: 4px;
            font-size: 14px;
            font-family: inherit;
        }
        
        textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }
        
        .flash {
            padding: 12px 20px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .flash.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .flash.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            text-align: center;
            border-left: 4px solid #3498db;
        }
        
        .stat-card h3 {
            color: #7f8c8d;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        
        .stat-card .value {
            font-size: 32px;
            font-weight: bold;
            color: #2c3e50;
        }
        
        footer {
            text-align: center;
            padding: 20px;
            color: #7f8c8d;
            border-top: 1px solid #ecf0f1;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>📊 Du An Xuong</h1>
            <nav>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span>Xin chào, <?php echo htmlspecialchars($_SESSION['full_name'] ?? 'User'); ?></span>
                    <a href="<?php echo $baseUrl; ?>/profile">Hồ sơ</a>
                    <a href="<?php echo $baseUrl; ?>/logout">Đăng xuất</a>
                <?php else: ?>
                    <a href="<?php echo $baseUrl; ?>/login">Đăng nhập</a>
                    <a href="<?php echo $baseUrl; ?>/register">Đăng ký</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    
    <div class="container">
        <?php if (isset($flash)): ?>
            <div class="flash <?php echo htmlspecialchars($flash['type']); ?>">
                <?php echo htmlspecialchars($flash['message']); ?>
            </div>
        <?php endif; ?>
        
        <?php echo $content ?? ''; ?>
    </div>
    
    <footer>
        <p>&copy; 2026 Du An Xuong - Quản lý dự án. Bản quyền thuộc về nhà phát triển.</p>
    </footer>
</body>
</html>
