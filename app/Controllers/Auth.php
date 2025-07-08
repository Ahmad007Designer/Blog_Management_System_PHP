<?php
    namespace App\Controllers;
    use CodeIgniter\Controller;
    use App\Models\UserModel;
    use App\Models\PostModel;
    class Auth extends Controller{
        public function login(){
            return view("users/login");
        }
        
        public function signup(){
            return view("users/register");
        }
    
        public function logout(){
            // session()->destroy();
            session()->remove(['isLoggedIn','name','email','id']);
            return redirect()->to(base_url('users/login'))->with('success', 'Logged out successfully');
        }


        public function register(){
            $validation=\Config\Services::validation();
            $rule =[
                'name'=> 'required|min_length[4]',
                'email'=> 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]',
                'password'=> 'required|min_length[6]',
                'confirmpassword' => 'required|matches[password]'
            ];

            if(!$this->validate($rule)){
                return view('users/register',['validation'=> $this->validator]);
            }
            $userModel= new UserModel();
            $data=[
                'name'=>$this->request->getPost('name'),
                'email'=>$this->request->getPost('email'),
                'password'=> password_hash($this->request->getPost('password'),PASSWORD_DEFAULT)
            ];
            $userModel->save($data);
            return redirect()->to('users/login')->with('success','Registration Successfull. Please Login.');
        }

        
        public function authenticate()
        {
            $session = session();
            $userModel = new UserModel();

            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            // Fetch user by email
            $user = $userModel->where('email', $email)->first();

            if ($user) {
                // Verify password
                if (password_verify($password, $user['password'])) {
                    // Set session data
                    $session->set([
                        'user_id'     => $user['id'],
                        'name'        => $user['name'],
                        'email'       => $user['email'],
                        'isLoggedIn'  => true,
                    ]);

                    return redirect()->to('posts/list')->with('success','Successfull Login');
                } else {
                    // Wrong password
                    return redirect()->to('users/login')->with('error', 'Invalid password.');
                }
            } else {
                // Email not found
                return redirect()->to('users/login')->with('error', 'Email not registered.');
            }
        }
    
    }

?>