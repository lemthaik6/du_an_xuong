<?php

namespace App\Controllers;

use App\Models\Project;
use App\Models\Category;
use App\Models\User;

class ProjectController extends Controller
{
    private $projectModel;
    private $categoryModel;
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->projectModel = new Project();
        $this->categoryModel = new Category();
        $this->userModel = new User();
        $this->auth->requireLogin();
    }

    public function index()
    {
        $page = $_GET['page'] ?? 1;
        
        // Admin xem tất cả, User xem các dự án được gán
        if ($this->auth->isAdmin()) {
            $projects = $this->projectModel->paginate($page, 10);
            $data = $projects['data'];
            $total = $projects['total'];
            $pages = $projects['pages'];
        } else {
            $data = $this->projectModel->getByUser($this->auth->getId());
            $total = count($data);
            $pages = 1;
        }
        
        echo $this->render('projects/index', [
            'projects' => $data,
            'total' => $total,
            'pages' => $pages,
            'current_page' => $page,
            'isAdmin' => $this->auth->isAdmin()
        ]);
    }

    public function show()
    {
        if (empty($_GET['id'])) {
            $this->redirect('/du_an_xuong/public/projects');
        }

        $project = $this->projectModel->getProject($_GET['id']);
        
        if (!$project) {
            $this->setFlash('error', 'Dự án không tồn tại');
            $this->redirect('/du_an_xuong/public/projects');
        }

        // Check permission: Admin or assigned user
        if (!$this->auth->isAdmin() && $project['assigned_to'] !== $this->auth->getId()) {
            $this->redirect('/du_an_xuong/public/403');
        }

        echo $this->render('projects/show', ['project' => $project]);
    }

    public function create()
    {
        $this->auth->requireAdmin();
        
        $categories = $this->categoryModel->getActive();
        $users = $this->userModel->getRegularUsers();
        
        echo $this->render('projects/create', [
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
            'start_date' => $post['start_date'],
            'end_date' => $post['end_date'],
            'budget' => $post['budget'],
            'assigned_to' => $post['assigned_to'],
            'created_by' => $this->auth->getId()
        ]);

        $this->setFlash('success', 'Tạo dự án thành công');
        $this->redirect('/du_an_xuong/public/projects/' . $projectId);
    }

    public function edit()
    {
        $this->auth->requireAdmin();
        
        if (empty($_GET['id'])) {
            $this->redirect('/du_an_xuong/public/projects');
        }

        $project = $this->projectModel->find($_GET['id']);
        
        if (!$project) {
            $this->setFlash('error', 'Dự án không tồn tại');
            $this->redirect('/du_an_xuong/public/projects');
        }

        $categories = $this->categoryModel->getActive();
        $users = $this->userModel->getRegularUsers();

        echo $this->render('projects/edit', [
            'project' => $project,
            'categories' => $categories,
            'users' => $users
        ]);
    }

    public function update()
    {
        $this->auth->requireAdmin();
        
        if (empty($_GET['id'])) {
            $this->redirect('/du_an_xuong/public/projects');
        }

        $post = $this->getPost();
        
        $this->projectModel->update($_GET['id'], [
            'name' => $post['name'],
            'description' => $post['description'],
            'category_id' => $post['category_id'],
            'status' => $post['status'],
            'start_date' => $post['start_date'],
            'end_date' => $post['end_date'],
            'budget' => $post['budget'],
            'assigned_to' => $post['assigned_to']
        ]);

        $this->setFlash('success', 'Cập nhật dự án thành công');
        $this->redirect('/du_an_xuong/public/projects/' . $_GET['id']);
    }

    public function delete()
    {
        $this->auth->requireAdmin();
        
        if (empty($_GET['id'])) {
            $this->redirect('/du_an_xuong/public/projects');
        }

        $this->projectModel->update($_GET['id'], ['status' => 'cancelled']);

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
