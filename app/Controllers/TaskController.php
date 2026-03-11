<?php

namespace App\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\Comment;
use App\Models\Attachment;

class TaskController extends Controller
{
    private $taskModel;
    private $projectModel;
    private $commentModel;
    private $attachmentModel;

    public function __construct()
    {
        parent::__construct();
        $this->taskModel = new Task();
        $this->projectModel = new Project();
        $this->commentModel = new Comment();
        $this->attachmentModel = new Attachment();
        $this->auth->requireLogin();
    }

    public function index()
    {
        // Hiển thị tác vụ của user
        $tasks = $this->taskModel->getAssigned($this->auth->getId());
        
        echo $this->render('tasks/index', [
            'tasks' => $tasks,
            'overdue' => $this->taskModel->getOverdue(),
            'upcoming' => $this->taskModel->getUpcoming()
        ]);
    }

    public function show()
    {
        if (empty($_GET['id'])) {
            $this->redirect('/du_an_xuong/public/tasks');
        }

        $task = $this->taskModel->getTask($_GET['id']);
        
        if (!$task) {
            $this->setFlash('error', 'Tác vụ không tồn tại');
            $this->redirect('/du_an_xuong/public/tasks');
        }

        $comments = $this->commentModel->getByTask($_GET['id']);
        $attachments = $this->attachmentModel->getByTask($_GET['id']);

        echo $this->render('tasks/show', [
            'task' => $task,
            'comments' => $comments,
            'attachments' => $attachments
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

        echo $this->render('tasks/create', [
            'project' => $project
        ]);
    }

    public function store()
    {
        if (empty($_GET['project_id'])) {
            $this->redirect('/du_an_xuong/public/projects');
        }

        $post = $this->getPost();
        
        $errors = $this->validate($post, [
            'title' => 'required'
        ]);

        if (!empty($errors)) {
            $this->setFlash('error', 'Vui lòng điền tiêu đề tác vụ');
            $this->redirect('/du_an_xuong/public/tasks/create?project_id=' . $_GET['project_id']);
            return;
        }

        $taskId = $this->taskModel->create([
            'title' => $post['title'],
            'description' => $post['description'],
            'project_id' => $_GET['project_id'],
            'assigned_to' => $post['assigned_to'],
            'status' => 'todo',
            'due_date' => $post['due_date'],
            'created_by' => $this->auth->getId()
        ]);

        $this->setFlash('success', 'Tạo tác vụ thành công');
        $this->redirect('/du_an_xuong/public/tasks/' . $taskId);
    }

    public function edit()
    {
        if (empty($_GET['id'])) {
            $this->redirect('/du_an_xuong/public/tasks');
        }

        $task = $this->taskModel->find($_GET['id']);
        
        if (!$task) {
            $this->setFlash('error', 'Tác vụ không tồn tại');
            $this->redirect('/du_an_xuong/public/tasks');
        }

        echo $this->render('tasks/edit', ['task' => $task]);
    }

    public function update()
    {
        if (empty($_GET['id'])) {
            $this->redirect('/du_an_xuong/public/tasks');
        }

        $post = $this->getPost();
        
        $this->taskModel->update($_GET['id'], [
            'title' => $post['title'],
            'description' => $post['description'],
            'assigned_to' => $post['assigned_to'],
            'status' => $post['status'],
            'progress' => $post['progress'],
            'due_date' => $post['due_date']
        ]);

        // Update project progress
        $task = $this->taskModel->find($_GET['id']);
        if ($task) {
            $this->projectModel->updateProgress($task['project_id']);
        }

        $this->setFlash('success', 'Cập nhật tác vụ thành công');
        $this->redirect('/du_an_xuong/public/tasks/' . $_GET['id']);
    }

    public function delete()
    {
        if (empty($_GET['id'])) {
            $this->redirect('/du_an_xuong/public/tasks');
        }

        $task = $this->taskModel->find($_GET['id']);
        $project_id = $task['project_id'];

        $this->taskModel->delete($_GET['id']);

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
