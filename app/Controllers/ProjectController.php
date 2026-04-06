<?php

namespace App\Controllers;

use App\Models\Project;
use App\Models\Category;
use App\Models\Team;
use App\Models\User;
use App\Models\Task;

class ProjectController extends Controller
{
    private $projectModel;
    private $categoryModel;
    private $teamModel;
    private $userModel;
    private $taskModel;

    public function __construct()
    {
        parent::__construct();
        $this->projectModel = new Project();
        $this->categoryModel = new Category();
        $this->teamModel = new Team();
        $this->userModel = new User();
        $this->taskModel = new Task();
        $this->auth->requireLogin();
    }

    public function index()
    {
        $page = $_GET['page'] ?? 1;
        $search = $_GET['search'] ?? '';
        $filters = [
            'category_id' => $_GET['category_id'] ?? '',
            'status' => $_GET['status'] ?? '',
            'team_id' => $_GET['team_id'] ?? '',
            'budget_min' => $_GET['budget_min'] ?? '',
            'budget_max' => $_GET['budget_max'] ?? ''
        ];
        
        // Admin xem tất cả, User xem các dự án từ nhóm được gán
        if ($this->auth->isAdmin()) {
            if (!empty($search)) {
                $data = $this->projectModel->search($search, $filters, $page, 10);
            } else {
                $projects = $this->projectModel->paginate($page, 10);
                $data = $projects['data'];
            }
            $total = count($data);
            $pages = ceil($total / 10);
            
            // Get filter options
            $categories = $this->categoryModel->getActive();
            $teams = $this->teamModel->all();
            
            if (!is_array($categories)) $categories = [];
            if (!is_array($teams)) $teams = [];
        } else {
            if (!empty($search)) {
                $data = $this->projectModel->searchByUser($this->auth->getId(), $search, $filters, $page, 10);
            } else {
                $data = $this->projectModel->getByUser($this->auth->getId());
            }
            $total = count($data);
            $pages = ceil($total / 10);
            $categories = [];
            $teams = [];
        }
        
        echo $this->render('projects/index', [
            'projects' => $data,
            'total' => $total,
            'pages' => $pages,
            'current_page' => $page,
            'isAdmin' => $this->auth->isAdmin(),
            'search' => $search,
            'filters' => $filters,
            'categories' => $categories ?? [],
            'teams' => $teams ?? []
        ]);
    }

    public function show($id)
    {
        if (empty($id)) {
            $this->redirect('/du_an_xuong/public/projects');
        }

        $project = $this->projectModel->getProject($id);
        
        if (!$project) {
            $this->setFlash('error', 'Dự án không tồn tại');
            $this->redirect('/du_an_xuong/public/projects');
        }

        // Check permission: Admin, created by user, or member of assigned team
        $hasAccess = false;
        if ($this->auth->isAdmin() || $project['created_by'] == $this->auth->getId()) {
            $hasAccess = true;
        } else {
            // Check if user is member of the assigned team
            $teamMembers = $this->teamModel->getTeamMembers($project['team_id']);
            foreach ($teamMembers as $member) {
                if ($member['id'] == $this->auth->getId()) {
                    $hasAccess = true;
                    break;
                }
            }
        }

        if (!$hasAccess) {
            $this->redirect('/du_an_xuong/public/403');
        }

        // Get tasks for this project
        $tasks = $this->taskModel->getByProject($id);
        if (!is_array($tasks)) {
            $tasks = [];
        }

        // Get assigned teams for this project
        $assignedTeams = $this->projectModel->getAssignedTeams($id);
        if (!is_array($assignedTeams)) {
            $assignedTeams = [];
        }

        // Get all teams for selection (admin only)
        $allTeams = [];
        if ($this->auth->isAdmin()) {
            $allTeams = $this->teamModel->all();
            if (!is_array($allTeams)) {
                $allTeams = [];
            }
        }

        echo $this->render('projects/show', [
            'project' => $project,
            'tasks' => $tasks,
            'assignedTeams' => $assignedTeams,
            'allTeams' => $allTeams,
            'isAdmin' => $this->auth->isAdmin()
        ]);
    }

    public function create()
    {
        $categories = $this->categoryModel->getActive();
        $teams = $this->teamModel->all();
        
        // Provide empty arrays if null
        if (!is_array($categories)) {
            $categories = [];
        }
        if (!is_array($teams)) {
            $teams = [];
        }
        
        echo $this->render('projects/form', [
            'categories' => $categories,
            'teams' => $teams
        ]);
    }

    public function store()
    {
        $this->auth->requireAdmin();
        
        $post = $this->getPost();
        
        $errors = $this->validate($post, [
            'name' => 'required',
            'category_id' => 'required',
            'team_id' => 'required'
        ]);

        if (!empty($errors)) {
            $this->setFlash('error', 'Vui lòng điền đủ thông tin bắt buộc (Tên, Danh mục, Nhóm)');
            $this->redirect('/du_an_xuong/public/projects/create');
            return;
        }

        $projectId = $this->projectModel->create([
            'name' => $post['name'],
            'description' => $post['description'],
            'slug' => $this->generateSlug($post['name']),
            'category_id' => $post['category_id'],
            'status' => $post['status'],
            'start_date' => !empty($post['start_date']) ? $post['start_date'] : null,
            'end_date' => !empty($post['end_date']) ? $post['end_date'] : null,
            'budget' => !empty($post['budget']) ? $post['budget'] : null,
            'progress' => !empty($post['progress']) ? (int)$post['progress'] : 0,
            'team_id' => $post['team_id'],
            'created_by' => $this->auth->getId()
        ]);

        $this->setFlash('success', 'Tạo dự án thành công');
        $this->redirect('/du_an_xuong/public/projects/' . $projectId);
    }

    public function edit($id)
    {
        $this->auth->requireAdmin();
        
        if (empty($id)) {
            $this->redirect('/du_an_xuong/public/projects');
        }

        $project = $this->projectModel->find($id);
        
        if (!$project) {
            $this->setFlash('error', 'Dự án không tồn tại');
            $this->redirect('/du_an_xuong/public/projects');
        }

        $categories = $this->categoryModel->getActive();
        $teams = $this->teamModel->all();
        
        // Provide empty arrays if null
        if (!is_array($categories)) {
            $categories = [];
        }
        if (!is_array($teams)) {
            $teams = [];
        }

        echo $this->render('projects/form', [
            'project' => $project,
            'categories' => $categories,
            'teams' => $teams
        ]);
    }

    public function update($id)
    {
        $this->auth->requireAdmin();
        
        if (empty($id)) {
            $this->redirect('/du_an_xuong/public/projects');
        }

        $post = $this->getPost();
        
        $this->projectModel->update($id, [
            'name' => $post['name'],
            'description' => $post['description'],
            'category_id' => $post['category_id'],
            'status' => $post['status'],
            'start_date' => !empty($post['start_date']) ? $post['start_date'] : null,
            'end_date' => !empty($post['end_date']) ? $post['end_date'] : null,
            'budget' => !empty($post['budget']) ? $post['budget'] : null,
            'progress' => !empty($post['progress']) ? (int)$post['progress'] : 0,
            'team_id' => $post['team_id']
        ]);

        $this->setFlash('success', 'Cập nhật dự án thành công');
        $this->redirect('/du_an_xuong/public/projects/' . $id);
    }

    public function updateTeams($id)
    {
        $this->auth->requireAdmin();
        
        if (empty($id)) {
            $this->setFlash('error', 'Dự án không tồn tại');
            $this->redirect('/du_an_xuong/public/projects');
            return;
        }

        $project = $this->projectModel->find($id);
        
        if (!$project) {
            $this->setFlash('error', 'Dự án không tồn tại');
            $this->redirect('/du_an_xuong/public/projects');
            return;
        }

        $post = $this->getPost();
        $teamIds = !empty($post['team_ids']) ? (is_array($post['team_ids']) ? $post['team_ids'] : [$post['team_ids']]) : [];
        
        // Validate team IDs
        $teamIds = array_filter($teamIds, function($id) {
            return is_numeric($id) && $id > 0;
        });

        // Update teams
        $this->projectModel->assignTeams($id, $teamIds);

        $this->setFlash('success', 'Cập nhật đội nhóm quản lý dự án thành công');
        $this->redirect('/du_an_xuong/public/projects/' . $id);
    }

    public function delete($id)
    {
        $this->auth->requireAdmin();
        
        if (empty($id)) {
            $this->redirect('/du_an_xuong/public/projects');
        }

        $this->projectModel->update($id, ['status' => 'cancelled']);

        $this->setFlash('success', 'Xóa dự án thành công');
        $this->redirect('/du_an_xuong/public/projects');
    }

    private function generateSlug($text)
    {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        return trim($text, '-');
    }
}
