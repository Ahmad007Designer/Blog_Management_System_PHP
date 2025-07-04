<?php 
namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'title', 'content'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    public function getPostWithAuthor($id){
    return $this->select('posts.*, users.name as author')
                ->join('users', 'users.id = posts.user_id')
                ->where('posts.id', $id)
                ->first();
    }
    public function getMyPostsWithAuthor($userId)
    {
        return $this->select('posts.*, users.name as author')
                    ->join('users', 'users.id = posts.user_id')
                    ->where('posts.user_id', $userId)
                    ->orderBy('posts.created_at', 'DESC');
    }
    

}

