<?php
/**
 * Laravella CMS
 * File: new_post.blade.php
 * Created by Elman (https://linkedin.com/in/huseyn0w)
 * Date: 16.08.2019
 */
?>

@extends('cpanel.core.index')

@push('extrastyles')
    <link rel="stylesheet" href="{{asset('admin')}}/css/datepicker.min.css" rel="stylesheet">
@endpush

@php
    $form_action = route('cpanel_save_new_post');

    if(!empty(request()->route('id')))  $form_action = route('cpanel_save_new_post', ['id' => request()->route('id')]);
@endphp
@section('content')

    @if ($update_message = Session::get('post_added'))
        <div class="col-12">
            @if ($update_message)
                <div class="alert alert-success">
                    <strong>@lang('cpanel/posts.post_added')</strong>
                </div>
            @endif
        </div>
    @endif

    <form action="{{ $form_action }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container-fluid">
            <div class="row">
                @if ($errors->any())
                    <div class="col-12">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <div class="col-xs-12 col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">@lang('cpanel/posts.new_post_headline')</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cpanel_title">@lang('cpanel/posts.title')</label>
                                        <input type="text" id="cpanel_title" required class="form-control" name="title" value="{{ old('title') }}" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cpanel_slug">@lang('cpanel/posts.slug')</label>
                                        <input type="text" id="cpanel_slug" required class="form-control" name="slug" value="{{ old('slug') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>@lang('cpanel/posts.preview')</label>
                                        <textarea name="preview" id="editor"  class="my-editor form-control">{{old('preview')}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>@lang('cpanel/posts.content')</label>
                                        <textarea name="content" id="editor"  class="my-editor form-control">{{old('content')}}</textarea>
                                    </div>
                                </div>
                            </div>
                            @include('cpanel.core.seo')
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                @include('cpanel.core.translation')
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>@lang('cpanel/posts.category')</label>
                                        <select name="category[]" multiple class="form-control multiple_list" id="post_category">
                                        @foreach($categories_list as $category)
                                            <option value="{{$category->category_id}}">{{$category->title}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>@lang('cpanel/posts.author')</label>
                                        <select name="author_id" id="author_id" class="form-control">
                                            @foreach($users_list as $user)
                                                @if($user->username === Auth::user()->username)
                                                    <option value="{{$user->id}}" selected>{{$user->username}}</option>
                                                @else
                                                    <option value="{{$user->id}}">{{$user->username}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>@lang('cpanel/posts.publish_date')</label>
                                        <input class="form-control" autocomplete="off" name="created_at" value="{{ \Carbon\Carbon::now() }}" required id="date_time_picker" type="text" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>@lang('cpanel/posts.status')</label>
                                        <select name="status" id="user_role" class="form-control">
                                            <option value="0">@lang('cpanel/posts.status_private')</option>
                                            <option value="1" selected>@lang('cpanel/posts.status_published')</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="custom_input_image">@lang('cpanel/posts.thumbnail')</label>
                                        <span class="input-group-btn">
                                          <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary choose-image">
                                            <i class="fa fa-picture-o"></i> @lang('cpanel/posts.thumbnail_label')
                                          </a>
                                        </span>
                                        <input id="thumbnail" class="form-control" type="hidden" name="thumbnail" value="{{ old('thumbnail') }}">
                                        <div class="post-thumbnail" style="display:none;">
                                            <button type="button" class="remove_thumbnail">X</button>
                                            <img src="{{ old('logo_url') }}" id="post-thumbnail" alt="Post Thumbnail">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info btn-fill pull-right">@lang('cpanel/posts.publish_button_label')</button>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('extrascripts')
    <script src="https://cdn.tiny.cloud/1/4vyoa49f4irghhao6v5lpc7z5z2hvhgau8wsjj1y9g65ovse/tinymce/4/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{{asset('admin')}}/js/datepicker.min.js"></script>
    <script src="{{asset('admin')}}/js/i18n/datepicker.en.js"></script>
@endpush
@push('finalscripts')
    <script src="{{asset('')}}/vendor/laravel-filemanager/js/lfm.js"></script>
    <script src="{{asset('admin')}}/js/post.js"></script>
    <script>
        var site_url = "<?php echo env('APP_URL'); ?>/";
    </script>
    <script src="{{asset('admin')}}/js/thumbnail.js"></script>
@endpush