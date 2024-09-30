<?php


class UserController extends Controller
{
    var $uses = ['user'];
    public function login()
    {

        $user = $this->request->post();
        var_dump(($user));
        if (!empty($user)) {
            $user = $this->User->select('*', "username='{$user['email']}' limit 1");
            var_dump(($user));
            $user['password'] = $this->encrypt->decrypt($user['password']);
        }
        // 

        return $this->render('users/login');
    }

    public function register()
    {
        if ($this->request->isPost()) {
            $user = new stdClass;
            $user->name = $this->request->post('name');
            $user->username = $this->request->post('email');
            $user->role = 1;
            $user->password = $this->encrypt->encrypt($this->request->post('password'));
            $this->User->insert((array)$user);


            // return $this->redirect('/users/');
        }
        return $this->render('users/register');
    }

    public function show($id)
    {
        // $user = User::find($id);
        return $this->render('users.show', ['user' => $user]);
    }

    public function edit($id)
    {
        // $user = User::find($id);
        if ($this->request->isPost()) {
            $user->name = $this->request->post('name');
            $user->email = $this->request->post('email');
            $user->password = $this->request->post('password');
            $user->save();
            // return $this->redirect('/users');
        }
        return $this->render('users.edit', ['user' => $user]);
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return $this->redirect('/users');
    }
}
