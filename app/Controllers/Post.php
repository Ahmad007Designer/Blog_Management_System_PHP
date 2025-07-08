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
        
        public function deletePost($id){
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

        public function viewPost($id){
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

        public function editPost($id){
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

        public function updatePost($id){
            $postModel = new PostModel();

            $data = [
                'title'   => $this->request->getPost('title'),
                'content' => $this->request->getPost('content'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $postModel->update($id, $data);

            $updatedpost = $postModel
                        ->select('posts.*, users.name as author')
                        ->join('users', 'users.id = posts.user_id')
                        ->where('posts.id', $id)
                        ->first();
                // print_r($updatedpost['id']);
                // die;

                // print_r($updatedpost);        
                    $postHTML = '<div class="col-12 post-card mb-4" id="postctr-'. $updatedpost['id'] .'" data-author="'.strtolower($updatedpost['author']) .'">
                                        <div class="card shadow-sm border-0" style="transition: transform 0.2s ease, box-shadow 0.2s ease; border-radius: 0.75rem; overflow: hidden;">
                                            <div class="card-body" style="background: rgb(214, 252, 252); cursor: pointer;">
                                                <!-- Post title and action buttons -->
                                                <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap">
                                                    <h4 class="card-title fw-bold mb-2" style="color: rgba(0, 128, 128, 1);">
                                                    '.$updatedpost['title'].'                     
                                                    </h4>
                                                    <div class="d-flex flex-wrap gap-2" onclick="event.stopPropagation();">
                                                    <button type="button" class="btn btn-sm text-white view-post-btn" data-id="'. $updatedpost['id'] .'" style="background-color: teal;" title="View">
                                                    <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm text-white btn-edit-post" data-id="'. $updatedpost['id'] .'" style="background-color: orange;" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger delete-post" data-id="'. $updatedpost['id'] .'" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                    </button>                                    
                                                    </div>
                                                </div>
                                           
                                                <p class="truncate-text card-text text-muted mb-3">'.esc(strip_tags($updatedpost['content'])).'</p>
                                              
                                                <div class="text-start small text-secondary">
                                                    Created by: 
                                                    <a href="'. base_url('posts/author/' . urlencode($updatedpost['author'])) .'" class="fw-semibold text-decoration-none" style="color: rgba(0, 128, 128, 1);">
                                                    '. esc($updatedpost['author']).'</a>
                                                </div>
                                                <div class="text-end small text-secondary">    
                                                    <div>Created: '. date('d M Y h:i A', strtotime($updatedpost['created_at'])) .'</div>
                                                    <div>Updated: '. date('d M Y h:i A', strtotime($updatedpost['updated_at'])) .'</div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>';
            return $this->response->setJSON(['status' => 'updated', 'post_html'=> $postHTML]);
        }

        public function storePost(){
            $postModel = new PostModel();
            
            $title = $this->request->getPost('title');
            $content = $this->request->getPost('content');
            $userId = session()->get('user_id');

            if (!$title || !$content || !$userId) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Missing data']);
            }

            // Save post
                
            $postModel->save([
                'title' => $title,
                'content' => $content,
                'user_id' => $userId
            ]);
            $newPostId = $postModel->getInsertID();

            // Fetch latest post to display
            $db = \Config\Database::connect();
            $builder = $db->table('posts');
            $builder->select('posts.*, users.name as author');
            $builder->join('users', 'users.id = posts.user_id');
            $builder->where('posts.id', $newPostId);
            $post = $builder->get()->getRowArray();
            // print_r($post['id']);
            // die;
                
            $createhtml =  '
            <div class="col-12 post-card mb-4" id="postctr-'. $post['id'].'" data-author="'.strtolower($post        ['author']).' ">
                <div class="card shadow-sm border-0" style="transition: transform 0.2s ease, box-shadow 0.2s ease; border-radius: 0.75rem; overflow: hidden;">
                <div class="card-body" style="background: rgb(214, 252, 252); cursor: pointer;">
                    <!-- Post title and action buttons -->
                    <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap">
                        <h4 class="card-title fw-bold mb-2" style="color: rgba(0, 128, 128, 1);">
                            '.esc($post['title']).'
                        </h4>
                        <div class="d-flex flex-wrap gap-2" onclick="event.stopPropagation();">
                            <button type="button" class="btn btn-sm text-white view-post-btn" data-id="'.$post['id'].'" style="background-color: teal;" title="View">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                   
                    <p class="truncate-text card-text text-muted mb-3">'.esc(strip_tags($post['content'])).'</p>

             
                    <div class="text-start small text-secondary">
                        Created by:
                        <a href="'.base_url('posts/author/' . urlencode($post['author'])).'" class="fw-semibold text-decoration-none" style="color: rgba(0, 128, 128, 1);"> '.esc($post['author'])  .'</a>
                    </div>
                    <div class="text-end small text-secondary">
                        <div>Created: '. date('d M Y h:i A', strtotime($post['created_at'])) .'</div>
                        <div>Updated: '. date('d M Y h:i A', strtotime($post['updated_at'])) .'</div>
                    </div>
                    
                    </div>
                </div>
            </div>';
            return $this->response->setJSON([
                    'status' => 'success',
                    'html' => $createhtml
            ]);
        
        }

        public function authorPosts($authorName){
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

        public function create_post(){
            return view('posts/create');
        }

    }

?>