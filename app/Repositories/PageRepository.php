<?php
/**
 * Laravella CMS
 * File: PageRepository.php
 * Created by Elman (https://linkedin.com/in/huseyn0w)
 * Date: 24.10.2019
 */

namespace App\Repositories;


use App\Http\Models\Category;
use App\Http\Models\Page;
use App\Http\Models\PageTranslation;
use App\Http\Models\Post;
use App\Http\Models\User;

class PageRepository extends BaseRepository
{
    protected $main_table = 'pages';

    protected $translated_table = 'page_translations';

    protected $translated_table_join_column = 'page_id';

    protected $select_fields = [
        'id',
        'author_id',
        'title',
        'content',
        'custom_fields',
        'slug',
        'meta_description',
        'meta_keywords',
        'status',
        'template',
        'created_at',
        'updated_at'
    ];

    public function __construct(Page $model)
    {
        parent::__construct();
        $this->model = $model;

        $this->translated_table_model = new PageTranslation;
    }

    public function getSearchResult($request, $page = 1, $count =1)
    {

        $filter = $request->filter;

        $searched_string = $request->get('query');

        $result = $this->getFilteredResult($searched_string, $filter, $page, $count);

        return $result;

    }

    public function getPaginatedSearchResult($string, $filter, $current_page)
    {
        $result = $this->getFilteredResult($string, $filter, $current_page);


        return $result;
    }

    private function getFilteredResult(string $searched_string, string $filter, $current_page=1, $count = 1)
    {


        switch ($filter)
        {
            case "page":
                $result = $this->filterByPage($searched_string, $count, $current_page);
                break;
            case "user":
                $result = $this->filterByUser($searched_string, $count, $current_page);
                break;
            case "post":
                $result = $this->filterByPost($searched_string, $count, $current_page);
                break;
            case "category":
                $result = $this->filterByCategory($searched_string, $count, $current_page);
                break;
            default:
                $result = throwAbort();
                break;
        }



        return $result;
    }

    private function FilterByPage($key, $count, $current_page)
    {
        $this->locale = get_current_lang();

        $pages = Page::join('page_translations', 'pages.id', '=', 'page_translations.page_id')
            ->select(['page_translations.title', 'page_translations.slug'])
            ->where ('page_translations.locale', $this->locale)
            ->where(function($q) use($key) {
                $q->where('page_translations.title', 'LIKE', '%' . $key . '%')
                    ->orWhere('page_translations.slug', 'LIKE', '%' . $key . '%')
                    ->orWhere('page_translations.content', 'LIKE', '%' . $key . '%')
                    ->orWhere('page_translations.custom_fields', 'LIKE', '%' . $key . '%');
            })
            ->paginate($count, ['*'], 'page', $current_page);

        return $pages;
    }

    private function filterByCategory($key, $count, $current_page)
    {
        $this->locale = get_current_lang();

        $category = Category::join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->select(['category_translations.title', 'category_translations.slug'])
            ->where('category_translations.locale', $this->locale)
            ->where(function($q) use($key) {
                $q->where('category_translations.title', 'LIKE', '%' . $key . '%')
                    ->orWhere('category_translations.slug', 'LIKE', '%' . $key . '%')
                    ->orWhere('category_translations.description', 'LIKE', '%' . $key . '%');
            })
            ->paginate($count, ['*'], 'page', $current_page);


        return $category;
    }

    private function filterByPost($key, $count, $current_page)
    {
        $this->locale = get_current_lang();

        $posts = Post::join('post_translations', 'posts.id', '=', 'post_translations.post_id')
            ->select(['post_translations.title', 'post_translations.slug',])
            ->where ('post_translations.locale', $this->locale)
            ->where(function($q) use($key) {
                $q->where('post_translations.title', 'LIKE', '%' . $key . '%')
                ->orWhere('post_translations.slug', 'LIKE', '%' . $key . '%')
                ->orWhere('post_translations.preview', 'LIKE', '%' . $key . '%')
                ->orWhere('post_translations.content', 'LIKE', '%' . $key . '%');
            })
            ->paginate($count, ['*'], 'page', $current_page);
//        dd($posts);
        return $posts;
    }

    private function filterByUser($key, $count, $current_page)
    {
        $users = User::select(['name', 'surname', 'username', 'about_me'])
            ->where ('name', 'LIKE', '%' . $key . '%')
            ->orWhere('surname', 'LIKE', '%' . $key . '%')
            ->orWhere('username', 'LIKE', '%' . $key . '%')
            ->orWhere('country', 'LIKE', '%' . $key . '%')
            ->orWhere('city', 'LIKE', '%' . $key . '%')
            ->orWhere('email', 'LIKE', '%' . $key . '%')
            ->paginate($count, ['*'], 'page', $current_page);

        return $users;
    }
    
}