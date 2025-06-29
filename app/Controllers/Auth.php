<?php
    namespace App\Controllers;
    use CodeIgniter\Controller;
    use App\Models\UserModel;
    use App\Models\PostModel;

    class Auth extends Controller{


        public function login(){
            return view("auth/login");
        }
        
        public function signup(){
            return view("auth/register");
        }
    
        public function logout(){
            session()->destroy();
            return redirect()->to(base_url('auth/login'))->with('success', 'Logged out successfully');
        }


        public function register(){
            helper(['form']);
            $validation=\Config\Services::validation();
            $rule =[
                'name'=> 'required|min_length[4]',
                'email'=> 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]',
                'password'=> 'required|min_length[6]',
                'confirmpassword' => 'required|matches[password]'
            ];

            if(!$this->validate($rule)){
                return view('auth/register',['validation'=> $this->validator]);
            }
            $userModel= new UserModel();
            $data=[
                'name'=>$this->request->getPost('name'),
                'email'=>$this->request->getPost('email'),
                'password'=> password_hash($this->request->getPost('password'),PASSWORD_DEFAULT)
            ];
            $userModel->save($data);

            return redirect()->to('/auth/login')->with('success','Registration Successfull. Please Login.');
        }

        
        public function authenticate()
        {
            $session = session();
            $userModel = new \App\Models\UserModel();

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

                    return redirect()->to('/posts/list');
                } else {
                    // Wrong password
                    return redirect()->to('/auth/login')->with('error', 'Invalid password.');
                }
            } else {
                // Email not found
                return redirect()->to('/auth/login')->with('error', 'Email not registered.');
            }
        }


    
    
    }

?>