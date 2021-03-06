<?php
/**
 * Laravella CMS
 * File: PageRepository.php
 * Created by Elman (https://linkedin.com/in/huseyn0w)
 * Date: 24.10.2019
 */

namespace App\Repositories;


use App\Http\Models\Comments;
use App\Http\Models\Likes;
use App\Http\Models\Post;
use App\Http\Models\PostTranslation;
use Illuminate\Support\Facades\Auth;

class PostRepository extends BaseRepository
{
    protected $main_table = 'posts';

    protected $translated_table = 'post_translations';

    protected $translated_table_join_column = 'post_id';

    protected $select_fields = [
        'id',
        'author_id',
        'title',
        'content',
        'likes',
        'thumbnail',
        'slug',
        'meta_description',
        'meta_keywords',
        'status',
        'created_at',
        'updated_at'
    ];

    public function __construct(Post $model)
    {
        parent::__construct();
        $this->model = $model;
        $this->translated_table_model = new PostTranslation;
    }


    public function handleLike(int $post_id, int $user_id)
    {
        if(Auth::user()->id !== $user_id) return false;

        $result = false;

        $data = Likes::where('post_id', $post_id)->where('user_id', $user_id)->first();
        if(empty($data))
        {
            $like_added = Likes::insert([
                ['user_id' => $user_id, 'post_id' => $post_id]
            ]);

            if($like_added) {
                PostTranslation::where('post_id', $post_id)->increment('likes');
                $result = trans('default/post.like_added');
            }
        }
        else{
            $like_deleted = Likes::where('post_id', $post_id)->where('user_id', $user_id)->delete();
            if($like_deleted){
                PostTranslation::where('post_id', $post_id)->decrement('likes');
                $result = trans('default/post.like_deleted');
            }
        }

        return $result;
    }



    public function getTranslatedBy($param, $value)
    {
        $comments_per_page = get_comments_count_per_page();
        $data = parent::getTranslatedBy($param,$value);
        $data->setRelation('comments', $data->comments()->with('replies')->with('user')->orderBy('id', 'DESC')->paginate($comments_per_page));

        return $data;
    }
    
}