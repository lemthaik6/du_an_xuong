<?php

namespace App\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Models\Comment;
use App\Models\Attachment;

class TaskController extends Controller
{
    private $taskModel;
    private $projectModel;
    private $userModel;
    private $commentModel;
    private $attachmentModel;

    public function __construct()
    {
        parent::__construct();
        $this->taskModel = new Task();
        $this->projectModel = new Project();
        $this->userModel = new User();
        $this->commentModel = new Comment();
        $this->attachmentModel = new Attachment();
        $this->auth->requireLogin();
    }

    public function index()
    {
        $isAdmin = $this->auth->isAdmin();
        
        if ($isAdmin) {
            $page = $_GET['page'] ?? 1;
            $tasks = $this->taskModel->paginate($page, 10);
            $data = $tasks['data'];
        } else {
            $data = $this->taskModel->getAssigned($this->auth->getId());
        }
        
        echo $this->render('tasks/index', [
            'tasks' => $data,
            'overdue' => $this->taskModel->getOverdue(),
            'upcoming' => $this->taskModel->getUpcoming(),
            'isAdmin' => $isAdmin
        ]);
    }

    public function show($id)
    {
        if (empty($id)) {
            $this->redirect('/du_an_xuong/public/tasks');
        }

        $task = $this->taskModel->getTask($id);
        
        if (!$task) {
            $this->setFlash('error', 'Tác vụ không tồn tại');
            $this->redirect('/du_an_xuong/public/tasks');
        }

        $comments = $this->commentModel->getByTask($id);
        $attachments = $this->attachmentModel->getByTask($id);

        echo $this->render('tasks/show', [
            'task' => $task,
            'comments' => $comments,
            'attachments' => $attachments,
            'isAdmin' => $this->auth->isAdmin()
        ]);
    }

    public function create()
    {
        $project_id = $_GET['project_id'] ?? null;
        
        if (!$project_id) {
            $this->redirect('/du_an_xuong/public/projects');
        }

        $project = $this->projectModel->find($project_id);
        
        if (!$project) {
            $this->setFlash('error', 'Dự án không tồn tại');
            $this->redirect('/du_an_xuong/public/projects');
        }

        $projects = $this->projectModel->all();
        $users = $this->userModel->all();
        
        // Provide empty arrays if null
        if (!is_array($projects)) {
            $projects = [];
        }
        if (!is_array($users)) {
            $users = [];
        }

        echo $this->render('tasks/form', [
            'project' => $project,
            'projects' => $projects,
            'users' => $users
        ]);
    }

    public function store()
    {
        // Get project_id from GET or POST
        $project_id = $_GET['project_id'] ?? $_POST['project_id'] ?? null;
        
        if (empty($project_id)) {
            $this->redirect('/du_an_xuong/public/projects');
        }

        $post = $this->getPost();
        
        $errors = $this->validate($post, [
            'title' => 'required'
        ]);

        if (!empty($errors)) {
            $this->setFlash('error', 'Vui lòng điền tiêu đề tác vụ');
            $this->redirect('/du_an_xuong/public/tasks/create?project_id=' . $project_id);
            return;
        }

        $taskId = $this->taskModel->create([
            'title' => $post['title'],
            'description' => $post['description'],
            'project_id' => $project_id,
            'assigned_to' => !empty($post['assigned_to']) ? $post['assigned_to'] : null,
            'status' => 'todo',
            'progress' => 0,
            'due_date' => !empty($post['due_date']) ? $post['due_date'] : null,
            'created_by' => $this->auth->getId()
        ]);

        $this->setFlash('success', 'Tạo tác vụ thành công');
        $this->redirect('/du_an_xuong/public/tasks/' . $taskId);
    }

    public function edit($id)
    {
        if (empty($id)) {
            $this->redirect('/du_an_xuong/public/tasks');
        }

        $task = $this->taskModel->find($id);
        
        if (!$task) {
            $this->setFlash('error', 'Tác vụ không tồn tại');
            $this->redirect('/du_an_xuong/public/tasks');
        }

        $projects = $this->projectModel->all();
        $users = $this->userModel->all();
        
        // Provide empty arrays if null
        if (!is_array($projects)) {
            $projects = [];
        }
        if (!is_array($users)) {
            $users = [];
        }

        echo $this->render('tasks/form', [
            'task' => $task,
            'projects' => $projects,
            'users' => $users
        ]);
    }

    public function update($id)
    {
        if (empty($id)) {
            $this->redirect('/du_an_xuong/public/tasks');
        }

        $post = $this->getPost();
        
        $this->taskModel->update($id, [
            'title' => $post['title'],
            'description' => $post['description'],
            'assigned_to' => !empty($post['assigned_to']) ? $post['assigned_to'] : null,
            'status' => $post['status'],
            'progress' => !empty($post['progress']) ? $post['progress'] : 0,
            'due_date' => !empty($post['due_date']) ? $post['due_date'] : null
        ]);

        // Update project progress
        $task = $this->taskModel->find($id);
        if ($task) {
            $this->projectModel->updateProgress($task['project_id']);
        }

        $this->setFlash('success', 'Cập nhật tác vụ thành công');
        $this->redirect('/du_an_xuong/public/tasks/' . $id);
    }

    public function delete($id)
    {
        if (empty($id)) {
            $this->redirect('/du_an_xuong/public/tasks');
        }

        $task = $this->taskModel->find($id);
        $project_id = $task['project_id'];

        $this->taskModel->delete($id);

        $this->setFlash('success', 'Xóa tác vụ thành công');
        $this->redirect('/du_an_xuong/public/projects/' . $project_id);
    }

    public function addComment()
    {
        $post = $this->getPost();
        
        if (empty($post['task_id']) || empty($post['content'])) {
            return;
        }

        $this->commentModel->create([
            'task_id' => $post['task_id'],
            'user_id' => $this->auth->getId(),
            'content' => $post['content']
        ]);

        $this->setFlash('success', 'Thêm bình luận thành công');
        $this->redirect('/du_an_xuong/public/tasks/' . $post['task_id']);
    }

    public function uploadAttachment()
    {
        if (empty($_FILES['file']) || empty($_GET['task_id'])) {
            return;
        }

        $file = $_FILES['file'];
        $task_id = $_GET['task_id'];
        
        // Validate file
        $allowed = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if (!in_array($ext, $allowed)) {
            return;
        }

        // Create upload directory if not exists
        $uploadDir = __DIR__ . '/../../storage/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filename = time() . '_' . basename($file['name']);
        $filepath = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            $this->attachmentModel->create([
                'task_id' => $task_id,
                'file_name' => $file['name'],
                'file_path' => '/du_an_xuong/storage/uploads/' . $filename,
                'file_size' => $file['size'],
                'uploaded_by' => $this->auth->getId()
            ]);

            $this->setFlash('success', 'Upload tệp thành công');
        }

        $this->redirect('/du_an_xuong/public/tasks/' . $task_id);
    }
}
