<?php

namespace App\Controllers;

use App\Models\Notification;
use Core\Controller;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::all();
        return $this->view('notifications.index', ['notifications' => $notifications]);
    }

    public function create()
    {
        if ($this->request->isPost()) {
            $notification = new Notification();
            $notification->title = $this->request->post('title');
            $notification->body = $this->request->post('body');
            $notification->icon = $this->request->post('icon');
            $notification->tag = $this->request->post('tag');
            $notification->data = $this->request->post('data');
            $notification->save();
            return $this->redirect('/notifications');
        }
        return $this->view('notifications.create');
    }

    public function show($id)
    {
        $notification = Notification::find($id);
        return $this->view('notifications.show', ['notification' => $notification]);
    }

    public function edit($id)
    {
        $notification = Notification::find($id);
        if ($this->request->isPost()) {
            $notification->title = $this->request->post('title');
            $notification->body = $this->request->post('body');
            $notification->icon = $this->request->post('icon');
            $notification->tag = $this->request->post('tag');
            $notification->data = $this->request->post('data');
            $notification->save();
            return $this->redirect('/notifications');
        }
        return $this->view('notifications.edit', ['notification' => $notification]);
    }

    public function delete($id)
    {
        $notification = Notification::find($id);
        $notification->delete();
        return $this->redirect('/notifications');
    }
}

```
