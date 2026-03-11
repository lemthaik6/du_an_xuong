<?php

namespace App\Controllers;

use App\Models\Team;
use App\Models\User;

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

    public function show($id)
    {
        if (empty($id)) {
            $this->redirect('/du_an_xuong/public/teams');
        }

        $team = $this->teamModel->getTeam($id);
        $members = $this->teamModel->getTeamMembers($id);
        $allUsers = $this->userModel->all();
        
        if (!$team) {
            $this->setFlash('error', 'Đội không tồn tại');
            $this->redirect('/du_an_xuong/public/teams');
        }

        echo $this->render('teams/show', [
            'team' => $team,
            'members' => $members,
            'available_users' => $allUsers
        ]);
    }

    public function create()
    {
        $users = $this->userModel->all();
        
        echo $this->render('teams/form', [
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

    public function edit($id)
    {
        if (empty($id)) {
            $this->redirect('/du_an_xuong/public/teams');
        }

        $team = $this->teamModel->find($id);
        $users = $this->userModel->all();
        
        if (!$team) {
            $this->setFlash('error', 'Đội không tồn tại');
            $this->redirect('/du_an_xuong/public/teams');
        }

        echo $this->render('teams/form', [
            'team' => $team,
            'users' => $users
        ]);
    }

    public function update($id)
    {
        if (empty($id)) {
            $this->redirect('/du_an_xuong/public/teams');
        }

        $post = $this->getPost();
        
        $this->teamModel->update($id, [
            'name' => $post['name'],
            'description' => $post['description'],
            'leader_id' => !empty($post['leader_id']) ? $post['leader_id'] : null,
            'status' => $post['status']
        ]);

        $this->setFlash('success', 'Cập nhật đội thành công');
        $this->redirect('/du_an_xuong/public/teams/' . $id);
    }

    public function addMember()
    {
        if (empty($_POST['team_id']) || empty($_POST['user_id'])) {
            return;
        }

        $this->teamModel->addMember(
            $_POST['team_id'],
            $_POST['user_id']
        );

        $this->setFlash('success', 'Thêm thành viên thành công');
        $this->redirect('/du_an_xuong/public/teams/' . $_POST['team_id']);
    }

    public function removeMember($team_id, $user_id)
    {
        if (empty($team_id) || empty($user_id)) {
            $this->redirect('/du_an_xuong/public/teams');
        }

        $this->teamModel->removeMember($team_id, $user_id);

        $this->setFlash('success', 'Xóa thành viên thành công');
        $this->redirect('/du_an_xuong/public/teams/' . $team_id);
    }
}
