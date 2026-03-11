<?php

namespace App\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\Category;
use App\Models\Team;

class DashboardController extends Controller
{
    private $projectModel;
    private $taskModel;
    private $userModel;
    private $categoryModel;
    private $teamModel;

    public function __construct()
    {
        parent::__construct();
        $this->projectModel = new Project();
        $this->taskModel = new Task();
        $this->userModel = new User();
        $this->categoryModel = new Category();
        $this->teamModel = new Team();
        $this->auth->requireLogin();
    }

    public function index()
    {
        if ($this->auth->isAdmin()) {
            return $this->adminDashboard();
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

        echo $this->render('dashboard/user', [
            'user' => $user,
            'assignedTasks' => $assignedTasks,
            'myProjects' => $myProjects,
            'overdueTasks' => $overdueTasks,
            'upcomingTasks' => $upcomingTasks
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
