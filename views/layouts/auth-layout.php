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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }
        
        .auth-container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
            perspective: 1000px;
        }
        
        .auth-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 40px;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .auth-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .auth-header h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }
        
        .auth-header .logo {
            font-size: 48px;
            margin-bottom: 15px;
        }
        
        .auth-header p {
            color: #666;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }
        
        input, select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.3s ease;
        }
        
        input:focus, select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background-color: #f9f9ff;
        }
        
        input::placeholder {
            color: #bbb;
        }
        
        .btn {
            width: 100%;
            padding: 12px 16px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            margin-top: 10px;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .auth-footer {
            text-align: center;
            margin-top: 25px;
        }
        
        .auth-footer p {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .auth-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .auth-footer a:hover {
            color: #764ba2;
            text-decoration: underline;
        }
        
        .flash {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            animation: slideUp 0.4s ease-out;
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
        
        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
        }
        
        .divider-line {
            flex: 1;
            height: 1px;
            background: #e0e0e0;
        }
        
        .divider-text {
            padding: 0 15px;
            color: #999;
            font-size: 12px;
        }
        
        @media (max-width: 480px) {
            .auth-container {
                padding: 10px;
            }
            
            .auth-card {
                padding: 25px;
            }
            
            .auth-header h1 {
                font-size: 24px;
            }
            
            .auth-header .logo {
                font-size: 40px;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <?php if (isset($flash)): ?>
                <div class="flash <?php echo htmlspecialchars($flash['type']); ?>">
                    <?php echo htmlspecialchars($flash['message']); ?>
                </div>
            <?php endif; ?>
            
            <?php echo $content ?? ''; ?>
        </div>
    </div>
</body>
</html>
