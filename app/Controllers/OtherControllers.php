<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Team;
use App\Models\User;

class CategoryController extends Controller
{
    private $categoryModel;

    public function __construct()
    {
        parent::__construct();
        $this->categoryModel = new Category();
        $this->auth->requireLogin();
        $this->auth->requireAdmin();
    }

    public function index()
    {
        $categories = $this->categoryModel->all();
        
        echo $this->render('categories/index', [
            'categories' => $categories
        ]);
    }

    public function create()
    {
        echo $this->render('categories/create');
    }

    public function store()
    {
        $post = $this->getPost();
        
        $errors = $this->validate($post, [
            'name' => 'required'
        ]);

        if (!empty($errors)) {
            $this->setFlash('error', 'Vui lòng điền tên danh mục');
            $this->redirect('/du_an_xuong/public/categories/create');
            return;
        }

        $this->categoryModel->create([
            'name' => $post['name'],
            'description' => $post['description'],
            'slug' => $this->generateSlug($post['name']),
            'icon' => $post['icon'],
            'color' => $post['color'],
            'status' => 'active',
            'created_by' => $this->auth->getId()
        ]);

        $this->setFlash('success', 'Tạo danh mục thành công');
        $this->redirect('/du_an_xuong/public/categories');
    }

    public function edit()
    {
        if (empty($_GET['id'])) {
            $this->redirect('/du_an_xuong/public/categories');
        }

        $category = $this->categoryModel->find($_GET['id']);
        
        if (!$category) {
            $this->setFlash('error', 'Danh mục không tồn tại');
            $this->redirect('/du_an_xuong/public/categories');
        }

        echo $this->render('categories/edit', ['category' => $category]);
    }

    public function update()
    {
        if (empty($_GET['id'])) {
            $this->redirect('/du_an_xuong/public/categories');
        }

        $post = $this->getPost();
        
        $this->categoryModel->update($_GET['id'], [
            'name' => $post['name'],
            'description' => $post['description'],
            'icon' => $post['icon'],
            'color' => $post['color'],
            'status' => $post['status']
        ]);

        $this->setFlash('success', 'Cập nhật danh mục thành công');
        $this->redirect('/du_an_xuong/public/categories');
    }

    public function delete()
    {
        if (empty($_GET['id'])) {
            $this->redirect('/du_an_xuong/public/categories');
        }

        $this->categoryModel->delete($_GET['id']);

        $this->setFlash('success', 'Xóa danh mục thành công');
        $this->redirect('/du_an_xuong/public/categories');
    }

    private function generateSlug($text)
    {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        return trim($text, '-');
    }
}

class TeamController extends Controller
{
    private $teamModel;
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->teamModel = new Team();
        $this->userModel = new User();
        $this->auth->requireLogin();
        $this->auth->requireAdmin();
    }

    public function index()
    {
        $teams = $this->teamModel->all();
        
        echo $this->render('teams/index', [
            'teams' => $teams
        ]);
    }

    public function show()
    {
        if (empty($_GET['id'])) {
            $this->redirect('/du_an_xuong/public/teams');
        }

        $team = $this->teamModel->getTeam($_GET['id']);
        $members = $this->teamModel->getMembers($_GET['id']);
        
        if (!$team) {
            $this->setFlash('error', 'Đội không tồn tại');
            $this->redirect('/du_an_xuong/public/teams');
        }

        echo $this->render('teams/show', [
            'team' => $team,
            'members' => $members
        ]);
    }

    public function create()
    {
        $users = $this->userModel->all();
        
        echo $this->render('teams/create', [
            'users' => $users
        ]);
    }

    public function store()
    {
        $post = $this->getPost();
        
        $errors = $this->validate($post, [
            'name' => 'required'
        ]);

        if (!empty($errors)) {
            $this->setFlash('error', 'Vui lòng điền tên đội');
            $this->redirect('/du_an_xuong/public/teams/create');
            return;
        }

        $this->teamModel->create([
            'name' => $post['name'],
            'description' => $post['description'],
            'leader_id' => $post['leader_id'],
            'status' => 'active',
            'created_by' => $this->auth->getId()
        ]);

        $this->setFlash('success', 'Tạo đội thành công');
        $this->redirect('/du_an_xuong/public/teams');
    }

    public function edit()
    {
        if (empty($_GET['id'])) {
            $this->redirect('/du_an_xuong/public/teams');
        }

        $team = $this->teamModel->find($_GET['id']);
        $users = $this->userModel->all();
        
        if (!$team) {
            $this->setFlash('error', 'Đội không tồn tại');
            $this->redirect('/du_an_xuong/public/teams');
        }

        echo $this->render('teams/edit', [
            'team' => $team,
            'users' => $users
        ]);
    }

    public function update()
    {
        if (empty($_GET['id'])) {
            $this->redirect('/du_an_xuong/public/teams');
        }

        $post = $this->getPost();
        
        $this->teamModel->update($_GET['id'], [
            'name' => $post['name'],
            'description' => $post['description'],
            'leader_id' => $post['leader_id'],
            'status' => $post['status']
        ]);

        $this->setFlash('success', 'Cập nhật đội thành công');
        $this->redirect('/du_an_xuong/public/teams/' . $_GET['id']);
    }

    public function addMember()
    {
        if (empty($_POST['team_id']) || empty($_POST['user_id'])) {
            return;
        }

        $this->teamModel->addMember(
            $_POST['team_id'],
            $_POST['user_id'],
            $_POST['position'] ?? null
        );

        $this->setFlash('success', 'Thêm thành viên thành công');
        $this->redirect('/du_an_xuong/public/teams/' . $_POST['team_id']);
    }

    public function removeMember()
    {
        if (empty($_GET['team_id']) || empty($_GET['user_id'])) {
            $this->redirect('/du_an_xuong/public/teams');
        }

        $this->teamModel->removeMember($_GET['team_id'], $_GET['user_id']);

        $this->setFlash('success', 'Xóa thành viên thành công');
        $this->redirect('/du_an_xuong/public/teams/' . $_GET['team_id']);
    }
}
