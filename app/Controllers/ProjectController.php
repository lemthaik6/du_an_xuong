<?php

namespace App\Controllers;

use App\Models\Project;
use App\Models\Category;
use App\Models\User;
use App\Models\Task;

class ProjectController extends Controller
{
    private $projectModel;
    private $categoryModel;
    private $userModel;
    private $taskModel;

    public function __construct()
    {
        parent::__construct();
        $this->projectModel = new Project();
        $this->categoryModel = new Category();
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
            'assigned_to' => $_GET['assigned_to'] ?? '',
            'budget_min' => $_GET['budget_min'] ?? '',
            'budget_max' => $_GET['budget_max'] ?? ''
        ];
        
        // Admin xem tất cả, User xem các dự án được gán
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
            $users = $this->userModel->getRegularUsers();
            
            if (!is_array($categories)) $categories = [];
            if (!is_array($users)) $users = [];
        } else {
            if (!empty($search)) {
                $data = $this->projectModel->searchByUser($this->auth->getId(), $search, $filters, $page, 10);
            } else {
                $data = $this->projectModel->getByUser($this->auth->getId());
            }
            $total = count($data);
            $pages = ceil($total / 10);
            $categories = [];
            $users = [];
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
            'users' => $users ?? []
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

        // Check permission: Admin or assigned user
        if (!$this->auth->isAdmin() && $project['assigned_to'] !== $this->auth->getId()) {
            $this->redirect('/du_an_xuong/public/403');
        }

        // Get tasks for this project
        $tasks = $this->taskModel->getByProject($id);
        if (!is_array($tasks)) {
            $tasks = [];
        }

        echo $this->render('projects/show', [
            'project' => $project,
            'tasks' => $tasks
        ]);
    }

    public function create()
    {
        $this->auth->requireAdmin();
        
        $categories = $this->categoryModel->getActive();
        $users = $this->userModel->getRegularUsers();
        
        // Provide empty arrays if null
        if (!is_array($categories)) {
            $categories = [];
        }
        if (!is_array($users)) {
            $users = [];
        }
        
        echo $this->render('projects/form', [
            'categories' => $categories,
            'users' => $users
        ]);
    }

    public function store()
    {
        $this->auth->requireAdmin();
        
        $post = $this->getPost();
        
        $errors = $this->validate($post, [
            'name' => 'required',
            'category_id' => 'required'
        ]);

        if (!empty($errors)) {
            $this->setFlash('error', 'Vui lòng điền đủ thông tin bắt buộc');
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
            'assigned_to' => !empty($post['assigned_to']) ? $post['assigned_to'] : null,
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
        $users = $this->userModel->getRegularUsers();
        
        // Provide empty arrays if null
        if (!is_array($categories)) {
            $categories = [];
        }
        if (!is_array($users)) {
            $users = [];
        }

        echo $this->render('projects/form', [
            'project' => $project,
            'categories' => $categories,
            'users' => $users
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
            'assigned_to' => !empty($post['assigned_to']) ? $post['assigned_to'] : null
        ]);

        $this->setFlash('success', 'Cập nhật dự án thành công');
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
