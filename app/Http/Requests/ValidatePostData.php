<?php

namespace App\Http\Requests;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class ValidatePostData extends LaravellaRequest
{

    protected $table = 'post_translations';

    protected $ignore_column = 'post_id';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'title'             => ['string', 'required', 'max:20'],
            'slug'              => ['required', 'string', 'max:20'],
            'content'           => 'nullable|string',
            'meta_keywords'     => 'required|string',
            'meta_description'  => 'required|string',
            'created_at'        => 'sometimes|required|string',
            'updated_at'        => 'sometimes|required|string',
            'category'          => 'required|array',
            'thumbnail'         => 'nullable|url',
            'status'            => 'required|numeric'
        ];

        $title = $this->newRecordRule('title');
        $slug = $this->newRecordRule('slug');

        if($this->route_name === "cpanel_update_post")
        {
            $title = $this->updateRecordRule('title');
            $slug = $this->updateRecordRule('slug');
        }


        $rules['title'][] = $title;
        $rules['slug'][] = $slug;


        return $rules;
    }
}
