<?php
    namespace App\Controllers;
    use App\Models\PostModel;
    use CodeIgniter\Controller;

    class Post extends Controller{

        public function index()
            {
                if (!session()->get('isLoggedIn')) {
                    return redirect()->to(base_url('login'));
                }
                helper('text');
                $postModel = new PostModel();
                $posts = $postModel
                    ->select('posts.*, users.name as author')
                    ->join('users', 'users.id = posts.user_id')
                    ->orderBy('posts.created_at', 'DESC')
                    ->paginate(8, 'default');

                $data = [
                    'posts' => $posts,
                    'pager' => $postModel->pager,
                ];

            return view('posts/list', $data);
        }
        public function myPosts(){
            
            $session = session();

            if (!$session->get('isLoggedIn')) {
                return redirect()->to(base_url('login'));
            }

            $userId = (int) $session->get('user_id');

            $model = new \App\Models\PostModel();

            $data['posts'] = $model->getMyPostsWithAuthor($userId)->paginate(5, 'default');
            $data['pager'] = $model->pager;

            return view('posts/my_posts', $data);
        }

        public function createView(){
           
            return view('posts/create');
        }

        public function fetch(){
            $model = new PostModel();
            $data = $model->findAll();
            return $this->response->setJSON($data);
        }
        
        public function list(){
            helper('text');
            $db = \Config\Database::connect();

            $builder = $db->table('posts');
            $builder->select('posts.id, posts.title, posts.content, posts.created_at, users.name as author');
            $builder->join('users', 'users.id = posts.user_id');
            $query = $builder->get();

            $data['posts'] = $query->getResult();
            return view('posts/list', $data);
        }

        public function createPost(){
            $model = new PostModel();
            $userId = session()->get('user_id');
            $title = $this->request->getPost('title');
            $content = $this->request->getPost('content');
            $created_at = $this->request->getPost('created_at');

            if (!$title) {
                return "Title is missing! Check your form input name.";
            }

            $data = [
                'title'   => $title,
                'content' => $content,
                'user_id' => $userId,
              
            ];
            session()->setFlashdata('success', 'Post created successfully.');

            $model->insert($data);

            return redirect()->to('posts/list');
        }

        public function editPost($id){
            $model = new PostModel();
            $data['post'] = $model->find($id);
            return view('posts/edit', $data);

        }

        public function update($id){

            $model = new PostModel();
            $data = [
        
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
           

            ];
            $model->update($id, $data);
            session()->setFlashdata('success', 'Updated successfully.');
            return redirect()->to('posts/list');
        }

        public function view($id){
            $model = new PostModel();
            $post = $model->getPostWithAuthor($id);
            
            return view('posts/view', ['post' => $post]);
        }
        
        // public function delete($id){
        //     $model = new PostModel();
        //     $model->delete($id);
        //     return redirect()->to('posts/list');
        // }

        // public function savePost(){
        //     return view('posts/save');
        // }


     public function delete($id){
    if ($this->request->isAJAX() && $this->request->getMethod() === 'post') {
        $model = new \App\Models\PostModel();

        if ($model->find($id)) {
            $model->delete($id);
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Post deleted successfully.'
            ]);
        }

        return $this->response->setStatusCode(404)->setJSON([
            'status' => 'error',
            'message' => 'Post not found.'
        ]);
    }

    return $this->response->setStatusCode(400)->setJSON([
        'status' => 'error',
        'message' => 'Invalid request.'
    ]);
}



    }


?>