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
        $projectStats = $this->projectModel->getStats();
        $taskStats = $this->taskModel->getStats();
        $totalUsers = $this->userModel->count();
        
        $recentProjects = $this->projectModel->getActive();
        $overdueTasks = $this->taskModel->getOverdue();
        $upcomingTasks = $this->taskModel->getUpcoming();

        echo $this->render('dashboard/admin', [
            'projectStats' => $projectStats,
            'taskStats' => $taskStats,
            'totalUsers' => $totalUsers,
            'recentProjects' => $recentProjects,
            'overdueTasks' => $overdueTasks,
            'upcomingTasks' => $upcomingTasks
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

        echo $this->render('dashboard/customer', [
            'user' => $user,
            'products' => $products,
            'totalProducts' => $totalProducts
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
