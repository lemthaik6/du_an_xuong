<?php

namespace App\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\Category;
use App\Models\Team;
use App\Models\Product;

class DashboardController extends Controller
{
    private $projectModel;
    private $taskModel;
    private $userModel;
    private $categoryModel;
    private $teamModel;
    private $productModel;

    public function __construct()
    {
        parent::__construct();
        $this->projectModel = new Project();
        $this->taskModel = new Task();
        $this->userModel = new User();
        $this->categoryModel = new Category();
        $this->teamModel = new Team();
        $this->productModel = new Product();
        $this->auth->requireLogin();
    }

    public function index()
    {
        if ($this->auth->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($this->auth->isCustomer()) {
            return $this->customerDashboard();
        } else {
            return $this->userDashboard();
        }
    }

    private function adminDashboard()
    {
        // Lấy thống kê đếm
        $totalUsers = $this->userModel->count();
        $totalProjects = $this->projectModel->count();
        $totalTeams = $this->teamModel->count();
        
        $taskStats = $this->taskModel->getStats();
        $totalTasks = $taskStats['total'] ?? 0;
        
        // Lấy dữ liệu cho các card
        $recentProjects = $this->projectModel->all('created_at', 'DESC');
        $overdueTasks = $this->taskModel->getOverdue();
        $upcomingTasks = $this->taskModel->getUpcoming();
        $allTeams = $this->teamModel->all('created_at', 'DESC');

        // Chuẩn bị stats array
        $stats = [
            'total_users' => $totalUsers,
            'total_projects' => $totalProjects,
            'total_tasks' => $totalTasks,
            'total_teams' => $totalTeams,
            'todo_tasks' => $taskStats['todo'] ?? 0,
            'in_progress_tasks' => $taskStats['in_progress'] ?? 0,
            'completed_tasks' => $taskStats['completed'] ?? 0
        ];

        echo $this->render('dashboard/admin', [
            'stats' => $stats,
            'recentProjects' => $recentProjects,
            'overdueTasks' => $overdueTasks,
            'upcomingTasks' => $upcomingTasks,
            'allTeams' => $allTeams
        ]);
    }

    private function userDashboard()
    {
        $user = $this->auth->getUser();
        
        $assignedTasks = $this->taskModel->getAssigned($this->auth->getId());
        $myProjects = $this->projectModel->getByUser($this->auth->getId());
        $overdueTasks = $this->taskModel->getOverdue();
        $upcomingTasks = $this->taskModel->getUpcoming(3);

        $stats = [
            'assigned_projects' => count($myProjects),
            'assigned_tasks' => count($assignedTasks),
            'overdue_tasks' => count($overdueTasks),
            'upcoming_tasks' => count($upcomingTasks)
        ];

        echo $this->render('dashboard/user', [
            'user' => $user,
            'stats' => $stats,
            'assignedTasks' => $assignedTasks,
            'myProjects' => $myProjects,
            'overdue_tasks' => $overdueTasks,
            'upcoming_tasks' => $upcomingTasks
        ]);
    }

    private function customerDashboard()
    {
        $user = $this->auth->getUser();
        
        // Lấy sản phẩm mới nhất
        $products = $this->productModel->getActiveProducts(1, 8);
        $totalProducts = $this->productModel->getTotalActiveProducts();
        
        // Get baseUrl
        $baseUrl = $_ENV['APP_URL'] ?? 'http://localhost/du_an_xuong/public';
        $baseUrl = rtrim($baseUrl, '/');

        echo $this->render('dashboard/customer', [
            'user' => $user,
            'products' => $products,
            'totalProducts' => $totalProducts,
            'baseUrl' => $baseUrl
        ]);
    }

    public function statistics()
    {
        $this->auth->requireAdmin();
        
        $projectStats = $this->projectModel->getStats();
        $taskStats = $this->taskModel->getStats();
        $categories = $this->categoryModel->getActive();
        
        echo $this->render('dashboard/statistics', [
            'projectStats' => $projectStats,
            'taskStats' => $taskStats,
            'categories' => $categories
        ]);
    }
}
