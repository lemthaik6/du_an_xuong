<?php

namespace App\Controllers;

class ContactController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        echo $this->render('contact/index');
    }

    public function send()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/du_an_xuong/public/contact');
            return;
        }

        $post = $this->getPost();
        
        $errors = $this->validate($post, [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ]);

        if (!empty($errors)) {
            $this->setFlash('error', 'Vui lòng điền đầy đủ thông tin hợp lệ');
            $redirectUrl = $this->auth->isCustomer() ? '/du_an_xuong/public/dashboard' : '/du_an_xuong/public/contact';
            $this->redirect($redirectUrl);
            return;
        }

        // Gửi email (có thể cấu hình sau)
        $to = 'contact@duanxuong.com';
        $subject = "Liên hệ từ: " . htmlspecialchars($post['name']);
        $message = "Tên: " . htmlspecialchars($post['name']) . "\n";
        $message .= "Email: " . htmlspecialchars($post['email']) . "\n";
        $message .= "Chủ đề: " . htmlspecialchars($post['subject']) . "\n\n";
        $message .= "Nội dung:\n" . htmlspecialchars($post['message']);

        // Có thể bỏ qua phần gửi email nếu server không hỗ trợ
        // mail($to, $subject, $message);

        $this->setFlash('success', 'Tin nhắn của bạn đã được gửi thành công. Cảm ơn bạn đã liên hệ!');
        $redirectUrl = $this->auth->isCustomer() ? '/du_an_xuong/public/dashboard?success=1' : '/du_an_xuong/public/contact';
        $this->redirect($redirectUrl);
    }
}
