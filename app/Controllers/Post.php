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
        //     return redirect()->to('posts/my-posts');
        // }

        public function delete($id){
                $postModel = new \App\Models\PostModel();

                // Check if post exists
                $post = $postModel->find($id);
                if (!$post) {
                    return $this->response->setJSON(['status' => 'not_found']);
                }

                if ($postModel->delete($id)) {
                    return $this->response->setJSON(['status' => 'deleted']);
                } else {
                    return $this->response->setJSON(['status' => 'error']);
                }
        }

        public function view_ajax($id){
                $postModel = new  PostModel();
                $post = $postModel
                        ->select('posts.*, users.name as author')
                        ->join('users', 'users.id = posts.user_id')
                        ->where('posts.id', $id)
                        ->first();

                if (!$post) {
                    return 'Post not found.';
                }
        
                return view('posts/view_modal', ['post' => $post]);
        }

        public function edit_ajax($id)
        {
            $postModel = new PostModel();
            $post = $postModel
                        ->select('posts.*, users.name as author')
                        ->join('users', 'users.id = posts.user_id')
                        ->where('posts.id', $id)
                        ->first();

            if (!$post) {
                return $this->response->setStatusCode(404)->setBody('Post not found');
            }

            return view('posts/edit_modal', ['post' => $post]);
        }

        public function update_ajax($id)
        {
            $postModel = new PostModel();

            $data = [
                'title'   => $this->request->getPost('title'),
                'content' => $this->request->getPost('content'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $postModel->update($id, $data);

            return $this->response->setJSON(['status' => 'updated']);
        }

        public function create_Post()
        {
        return view('posts/create_post'); 
        }

       public function store()
        {
            $title = $this->request->getPost('title');
            $content = $this->request->getPost('content');
            $userId = session()->get('user_id');

            if (!$title || !$content) {
                return $this->response->setStatusCode(400)->setBody('Title or content missing');
            }

            $postModel = new \App\Models\PostModel();
            $postModel->insert([
                'title' => $title,
                'content' => $content,
                'user_id' => $userId,
            ]);

            // Now load and return updated list HTML
            helper('text');
            $posts = $postModel
                ->select('posts.*, users.name as author')
                ->join('users', 'users.id = posts.user_id')
                ->orderBy('posts.created_at', 'DESC')
                ->paginate(8, 'default');

            $pager = $postModel->pager;

            return view('posts/list_partial', ['posts' => $posts, 'pager' => $pager]);
        }














        public function savePost(){
            return view('posts/save');
        }

        public function authorPosts($authorName)
        {
            $postModel = new PostModel();
            $decodedAuthor = urldecode($authorName);

            $posts = $postModel
                ->select('posts.*, users.name as author')
                ->join('users', 'users.id = posts.user_id')
                ->where('LOWER(users.name)', strtolower($decodedAuthor))
                ->orderBy('posts.created_at', 'DESC')
                ->findAll();

            $data = [
                'authorName' => ucwords($decodedAuthor),
                'postCount'  => count($posts),
                'posts'      => $posts,
            ];

            return view('posts/author_posts', $data);
        }



    }


?>