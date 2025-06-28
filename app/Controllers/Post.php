<?php
    namespace App\Controllers;
    use App\Models\PostModel;
    use CodeIgniter\Controller;

    class Post extends Controller{

        public function index()
        {
           
            return view('posts/create');
        }

        public function fetch()
        {
            $model = new PostModel();
            $data = $model->findAll();
            return $this->response->setJSON($data);
        }
        
        public function list(){
            
            $db = \Config\Database::connect();

            $builder = $db->table('posts');
            $builder->select('posts.id, posts.title, posts.content, posts.created_at, users.name as author');
            $builder->join('users', 'users.id = posts.user_id');
            $query = $builder->get();

            $data['posts'] = $query->getResult();
            return view('posts/list', $data);
        }

        public function createPost()
        {
            $model = new PostModel();
            $userId = session()->get('user_id');
            $title = $this->request->getPost('title');
            $content = $this->request->getPost('content');

            if (!$title) {
                return "Title is missing! Check your form input name.";
            }

            $data = [
                'title'   => $title,
                'content' => $content,
                'user_id' => $userId
            ];

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
            'content' => $this->request->getPost('content')
            ];
            $model->update($id, $data);
            return redirect()->to('posts/list');
        }

        public function delete($id){
            $model = new PostModel();
            $model->delete($id);
            return redirect()->to('posts/list');
        }

        public function savePost(){
        return view('posts/save');
        }

        public function view($id)
        {
            $model = new PostModel();
            $post = $model->getPostWithAuthor($id);
            
            return view('posts/view', ['post' => $post]);
        }




    }


?>