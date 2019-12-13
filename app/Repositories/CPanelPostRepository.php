<?php
/**
 * Laravella CMS
 * File: CPanelUserRepository.phpCreated by Elman (https://linkedin.com/in/huseyn0w)
 * Date: 09.08.2019
 */

namespace App\Repositories;

use App\Http\Models\Category;
use App\Http\Models\Post;
use App\Http\Models\PostTranslation;
use Doctrine\DBAL\Driver\PDOException;
use Illuminate\Database\QueryException;

class CPanelPostRepository extends BaseRepository
{
    protected $main_table = 'posts';

    protected $translated_table = 'post_translations';

    protected $translated_table_join_column = 'post_id';

    protected $select_fields = [
        'id',
        'author_id',
        'slug',
        'status',
        'created_at',
        'updated_at'
    ];


    public function __construct(Post $model)
    {
        parent::__construct();
        $this->model = $model;
        $this->translated_model = new PostTranslation;
    }



    public function trashedPosts($count){
        try{
            $this->locale = get_current_lang();
            $this->select_fields_ready_array = $this->generateSelectFieldsArray($this->select_fields);

            $data = $this->model::join($this->translated_table, $this->main_table.'.id', '=', $this->translated_table.'.'.$this->translated_table_join_column)
                ->select($this->select_fields_ready_array)
                ->where($this->translated_table.'.locale', $this->locale)
                ->with('author')->onlyTrashed()->paginate($count);

        } catch (QueryException $e) {
            dd($e->getMessage());
            throwAbort();
        } catch (PDOException $e) {
            dd($e->getMessage());
            throwAbort();
        } catch (\Error $e) {
            dd($e->getMessage());
            throwAbort();
        }

        return $data;
    }


    public function delete($id)
    {

        if(is_array($id))
        {
            foreach($id as $post_id)
            {
                $result = $this->deletePost($post_id);
            }
        }
        else{
            $result = $this->deletePost($id);

        }

        if(!$result) throwAbort();

        return $result;


    }

    private function deletePost($id)
    {

        $result = false;
        $post = $this->model::findOrFail($id);
        if($post->delete()) $result = true;

        return $result;

    }

    public function destroy($id)
    {
        if(is_array($id))
        {
            foreach($id as $post_id)
            {
                $result = $this->destroyPost($post_id);
            }
        }
        else{
            $result = $this->destroyPost($id);

        }

        if(!$result) throwAbort();

        return $result;


    }

    public function restore($id)
    {

        if(is_array($id))
        {
            foreach($id as $post_id)
            {
                $result = $this->restorePost($post_id);
            }
        }
        else{
            $result = $this->restorePost($id);

        }

        if(!$result) throwAbort();

        return $result;

    }

    public function restorePost($id)
    {

        if($this->model::withTrashed()->where('id', $id)->restore()) $result = true;

        if(!$result) return throwAbort();

        return $result;
    }




    private function destroyPost($id)
    {
        $deleted_post = false;

        $result = false;
        $post = Post::withTrashed()->find($id);
        if($post && $post->forceDelete()) $deleted_post = true;
        if($deleted_post)
        {
            $result = true;
        }

        return $result;

    }



}