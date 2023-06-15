@extends('layouts.master')
@section('css')
    <link href="{{ asset('/quill/dist/quill.snow.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/Sortable.js') }}"></script>
    <script src="{{ asset('/quill/dist/quill.min.js') }}"></script>
@endsection
@section('bodyclass')

    <body class="bg-userside">
    @endsection
    @section('jumbotron')
        <div class="jumbotron">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h1 class="display-4">@lang('messages.form.title_edit')</h1>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('content')
        <div class="container">
            <div class="content pt-5 pb-4">
                <div id="show-msg" class="alert alert-success print-success-msg d-none" role="alert">
                </div>
                @canany(['own-post', 'moderator-post'], $post)
                    <form method="POST" action="{{ url('/home/' . $post->id) }}" id="post_form">
                        {{ method_field('PUT') }}
                        <div class="mb-3 row">
                            <label for="post_title" class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.title')</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="post_title" name="post_title"
                                    value="{{ $post->post_title }}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="post_slug" class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.slug')</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="post_slug" name="post_slug"
                                    value="{{ $post->post_slug }}">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="post_desc" class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.description')</label>
                            <div class="col-md-7">
                                <textarea class="form-control" id="post_desc" name="post_desc">{{ $post->post_desc }}</textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="post_desc" class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.type')</label>
                            <div class="col-md-7">
                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link {{ !empty($post->post_media) & empty($post->post_video) ? 'active' : '' }}"
                                            id="pills-image-tab" data-bs-toggle="pill" href="#pills-image" role="tab"
                                            aria-controls="pills-image" aria-selected="true">@lang('messages.form.imagepost')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ !empty($post->post_video) ? 'active' : '' }}" id="pills-video-tab"
                                            data-bs-toggle="pill" href="#pills-video" role="tab" aria-controls="pills-video"
                                            aria-selected="false">@lang('messages.form.videopost')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ empty($post->post_video or $post->post_media) ? 'active' : '' }}"
                                            id="pills-text-tab" data-bs-toggle="pill" href="#pills-text" role="tab"
                                            aria-controls="pills-text" aria-selected="false">@lang('messages.form.textpost')</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-image" role="tabpanel"
                                aria-labelledby="pills-image-tab">
                                @if (!empty($post->post_media))
                                    <div class="mb-3 row">
                                        <label class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.upload')</label>
                                        <div class="col-md-7 d-flex">
                                            <div class="fileinputs me-3">
                                                <button onclick="ImageRemove(this)" type="button"
                                                    class="btn btn-warning editimage">@lang('messages.form.removetxt')</button>
                                            </div>
                                            <input class="photo_upload" name="post_media" type="hidden"
                                                value="{{ $post->post_media }}">
                                            <div class="fileinfo d-flex">
                                                <div class='flex-shrink-0'>
                                                    <img class='imgthumb img-fluid me-2' src="{{ $post->post_media }}">
                                                </div>
                                                <div class='flex-grow-1 ms-3'>
                                                    <input class='form-control' type='text' name='media_alt'
                                                        placeholder='@lang('messages.new.imagealt')' aria-label='Image Alt'
                                                        value="{{ $post->media_alt }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.imgoverlay')</label>
                                        <div class="col-sm-7">
                                            <div class="form-check">
                                                @if ($post->post_instant == '1')
                                                    <input class="form-check-input" type="checkbox" id="gridCheck1"
                                                        name="post_instant" value="1" checked>
                                                @else
                                                    <input class="form-check-input" type="checkbox" id="gridCheck1"
                                                        name="post_instant" value="0">
                                                @endif
                                                <label class="form-check-label" for="gridCheck1">
                                                    @lang('messages.form.imgoverlay_check')
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="mb-3 row">
                                        <label class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.upload')</label>
                                        <div class="col-md-7 d-flex">
                                            <div class="fileinputs me-3">
                                                <label class="btn btn-info btnfile">@lang('messages.form.browse')
                                                    <input onchange="ImageUpload(this)" class="fileupload d-none"
                                                        type="file" name="post_image">
                                                </label>
                                            </div>
                                            <input class="photo_upload" name="post_media" type="hidden" value="">
                                            <div class="fileinfo d-flex">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="tab-pane fade" id="pills-video" role="tabpanel" aria-labelledby="pills-video-tab">
                                <div class="mb-3 row">
                                    <label for="post_video"
                                        class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.postvideo')</label>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control" id="post_video" name="post_video"
                                            aria-describedby="videoHelp" value="{{ $post->video_url }}">
                                        <small id="videoHelp" class="form-text text-muted">@lang('messages.form.videoex')</small>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-text" role="tabpanel" aria-labelledby="pills-text-tab">
                                <div class="mb-3 row">
                                    <label for="post_video"
                                        class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.bg')</label>
                                    <div class="col-md-7">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="post_color"
                                                id="inlineRadio1" value="bg-primary" checked>
                                            <label class="form-check-label color-box bg-primary text-white"
                                                for="inlineRadio1"><i class="icon-card-list"></i>
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="post_color"
                                                id="inlineRadio2" value="bg-secondary">
                                            <label class="form-check-label color-box bg-secondary text-white"
                                                for="inlineRadio2"><i class="icon-card-list"></i>
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="post_color"
                                                id="inlineRadio3" value="bg-danger">
                                            <label class="form-check-label color-box bg-danger text-white"
                                                for="inlineRadio3"><i class="icon-card-list"></i>
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="post_color"
                                                id="inlineRadio4" value="bg-warning">
                                            <label class="form-check-label color-box bg-warning text-white"
                                                for="inlineRadio4"><i class="icon-card-list"></i>
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="post_color"
                                                id="inlineRadio5" value="bg-info">
                                            <label class="form-check-label color-box bg-info text-white" for="inlineRadio5"><i
                                                    class="icon-card-list"></i>
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="post_color"
                                                id="inlineRadio6" value="bg-dark">
                                            <label class="form-check-label color-box bg-dark text-white" for="inlineRadio6"><i
                                                    class="icon-card-list"></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @include('posts.tagselect')
                        <div class="mb-3 row">
                            <label for="post_size" class="offset-md-1 col-sm-2 col-form-label">
                                @lang('messages.form.size')
                            </label>
                            <div class="col-sm-7">
                                <select id="post_size" class="form-select" name="post_size">
                                    <option value="xl">XL</option>
                                    <option value="l">L</option>
                                    <option value="s">S</option>
                                    <option value="xs">XS</option>
                                </select>
                            </div>
                        </div>
                        @if (auth()->user()->can('moderator-post') or
                                $post->post_live == 1)
                            <div class="mb-3 row">
                                <label for="post_live" class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.publish')</label>
                                <div class="col-md-7">
                                    <input type="checkbox" class="form-check-input" name="post_live"
                                        {{ $post->post_live == 1 ? 'checked' : '' }}>
                                </div>
                            </div>
                        @endif

                        <div id="dynamic_field">
                            @php
                                $divcount = 1;
                            @endphp
                            @foreach ($post->contents as $content)
                                @if ($content->type == 'image')
                                    <div class="mb-3 row">
                                        <label class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.upload')</label>
                                        <div class="col-md-7 d-flex">
                                            <div class="fileinputs me-3">
                                                <button onclick="ImageRemove(this)" type="button"
                                                    class="btn btn-warning editimage">@lang('messages.form.removetxt')</button>
                                            </div>
                                            <input class="photo_upload" name="content[]" type="hidden"
                                                value="{{ $content->body }}">
                                            <input type="hidden" name="type[]" value="image">

                                            <div class="fileinfo d-flex">
                                                <div class='flex-shrink-0'>
                                                    <img class='imgthumb img-fluid me-2' src="{{ $content->body }}">
                                                </div>
                                                <div class='flex-grow-1 ms-3'>
                                                    <div class="input-group">
                                                        <input class="form-control" type="text" name="extra[]"
                                                            placeholder="@lang('messages.new.imagealt')" aria-label="Image Alt"
                                                            value="{{ $content->extra }}">
                                                        <input class="form-control" type="text" name="link[]"
                                                            placeholder="@lang('messages.new.link')" aria-label="Link"
                                                            value="{{ $content->link }}">
                                                        <select class='form-select short-select' name='blank[]'
                                                            aria-label='blankselect'>
                                                            <option
                                                                value='0'{{ $content->blank == '0' ? 'selected' : '' }}>
                                                                @lang('messages.new.self')</option>
                                                            <option value='1'
                                                                {{ $content->blank == '1' ? 'selected' : '' }}>
                                                                @lang('messages.new.blank')</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-md-1 d-flex align-items-center">
                                            <span class="span-click me-3 text-danger" onclick="delCont(this)"><i
                                                    class="icon-x-circle fw-bold"></i></span>
                                            <span class="span-move"><i class="icon-arrows-move fw-bold"></i></span>
                                        </div>
                                    </div>
                                @elseif ($content->type == 'text')
                                    <div class="mb-3 row">
                                        <label class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.text')</label>
                                        <div class="col-sm-10 col-md-7">
                                            <textarea class="form-control" name="content[]">{{ $content->body }}</textarea>
                                            <input type="hidden" name="type[]" value="text">
                                            <input type="hidden" name="extra[]">
                                        </div>
                                        <div class="col-sm-1 col-md-1 d-flex align-items-center">
                                            <span class="span-click me-3 text-danger" onclick="delCont(this)"><i
                                                    class="icon-x-circle fw-bold"></i></span>
                                            <span class="span-move"><i class="icon-arrows-move fw-bold"></i></span>
                                        </div>
                                    </div>
                                @elseif ($content->type == 'txteditor')
                                    <div class="mb-3 row">
                                        <label class="offset-md-1 col-md-2 col-form-label">
                                            @lang('messages.form.editor')</label>
                                        <div class="col-sm-10 col-md-7 alleditor myeditor">
                                            <div id="qeditor{{ $divcount++ }}">
                                                {!! clean($content->body) !!}
                                            </div>
                                            <input class="txtcont" type="hidden" name="content[]">
                                            <input type="hidden" name="type[]" value="txteditor">
                                            <input type="hidden" name="extra[]">
                                        </div>
                                        <div class="col-sm-1 col-md-1 d-flex align-items-center mt-3">
                                            <span class="span-click me-3 text-danger" onclick="delCont(this)"><i
                                                    class="icon-x-circle fw-bold"></i></span>
                                            <span class="span-move"><i class="icon-arrows-move fw-bold"></i></span>
                                        </div>
                                    </div>
                                @elseif ($content->type == 'youtube')
                                    <div class="mb-3 row">
                                        <label class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.youtube')</label>
                                        <div class="col-sm-10 col-md-7">
                                            <input type="text" class="form-control" name="content[]"
                                                value="https://www.youtube.com/watch?v={{ $content->body }}">
                                            <input type="hidden" name="type[]" value="youtube">
                                            <input type="hidden" name="extra[]">
                                        </div>
                                        <div class="col-sm-1 col-md-1 d-flex align-items-center">
                                            <span class="span-click me-3 text-danger" onclick="delCont(this)"><i
                                                    class="icon-x-circle fw-bold"></i></span>
                                            <span class="span-move"><i class="icon-arrows-move fw-bold"></i></span>
                                        </div>
                                    </div>
                                @elseif ($content->type == 'header')
                                    <div class="mb-3 row">
                                        <label class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.heading')</label>
                                        <div class="col-sm-10 col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control w-85" name="content[]"
                                                    placeholder="@lang('messages.form.heading_help')" value="{{ $content->body }}">
                                                <input type="hidden" name="type[]" value="header">
                                                <select class="form-select w-15" name="extra[]" aria-label="select">
                                                    <option value="h1" {{ $content->extra == 'h1' ? 'selected' : '' }}>H1
                                                    </option>
                                                    <option value="h2" {{ $content->extra == 'h2' ? 'selected' : '' }}>H2
                                                    </option>
                                                    <option value="h3" {{ $content->extra == 'h3' ? 'selected' : '' }}>H3
                                                    </option>
                                                    <option value="h4" {{ $content->extra == 'h4' ? 'selected' : '' }}>H4
                                                    </option>
                                                    <option value="h5" {{ $content->extra == 'h5' ? 'selected' : '' }}>H5
                                                    </option>
                                                    <option value="h6" {{ $content->extra == 'h6' ? 'selected' : '' }}>H6
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-md-1 d-flex align-items-center">
                                            <span class="span-click me-3 text-danger" onclick="delCont(this)"><i
                                                    class="icon-x-circle fw-bold"></i></span>
                                            <span class="span-move"><i class="icon-arrows-move fw-bold"></i></span>
                                        </div>
                                    </div>
                                @elseif (!empty($content->embed_id))
                                    <div class="mb-3 row">
                                        <label
                                            class="offset-md-1 col-md-2 col-form-label">{{ title_case($content->type) }}</label>
                                        <div class="col-sm-10 col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="embed_url"
                                                    value="{{ $content->embed->url }}" readonly>
                                                <input type="hidden" class="form-control" name="content[]"
                                                    value="{{ $content->body }}">
                                                <input type="hidden" name="type[]" value="{{ $content->type }}">
                                                <input type="hidden" name="extra[]">
                                                <button onclick="RemoveEmbed(this)" class="btn btn-outline-warning"
                                                    type="button">@lang('messages.form.removetxt')</button>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-md-1 d-flex align-items-center">
                                            <span class="span-click me-3 text-danger" onclick="delCont(this)"><i
                                                    class="icon-x-circle fw-bold"></i></span>
                                            <span class="span-move"><i class="icon-arrows-move fw-bold"></i></span>
                                        </div>
                                    </div>
                                @else
                                    <div class="mb-3 row">
                                        <label
                                            class="offset-md-1 col-md-2 col-form-label">{{ title_case($content->type) }}</label>
                                        <div class="col-sm-10 col-md-7">
                                            <input type="text" class="form-control" name="content[]"
                                                value="{{ $content->body }}">
                                            <input type="hidden" name="type[]" value="{{ $content->type }}">
                                            <input type="hidden" name="extra[]">
                                        </div>
                                        <div class="col-sm-1 col-md-1 d-flex align-items-center">
                                            <span class="span-click me-3 text-danger" onclick="delCont(this)"><i
                                                    class="icon-x-circle fw-bold"></i></span>
                                            <span class="span-move"><i class="icon-arrows-move fw-bold"></i></span>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="mb-3 row mb-5">
                            <label class="offset-md-1 col-md-2 col-form-label"><strong>@lang('messages.form.more') </strong> <a
                                    href="#" data-bs-toggle="modal" data-bs-target="#helpModal"><i
                                        class="icon-info-circle"></i></a>
                            </label>
                            <div class="col-md-7">
                                <button onclick="addNew('header_add')" type="button" name="header_add"
                                    class="btn btn-lg btn-light btnadd me-1" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="@lang('messages.form.addheading')"><i
                                        class="icon-type-h1"></i></button>
                                <button onclick="addNew('txt_add')" type="button" name="txt_add"
                                    class="btn btn-lg btn-light btnadd me-1" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="@lang('messages.form.addsimple')"><i class="icon-fonts"></i></button>
                                <button onclick="addText()" type="button" id="texteditor" class="btn btn-lg btn-light me-1"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('messages.form.addeditor')"><i
                                        class="icon-textarea-t"></i></button>
                                <button onclick="addNew('img_add')" type="button" name="img_add"
                                    class="btn btn-lg btn-light btnadd me-1" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="@lang('messages.form.addimage')"><i class="icon-image"></i></button>
                                <button onclick="addNew('youtube_add')" type="button" name="youtube_add"
                                    class="btn btn-lg btn-light btnadd me-1" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="@lang('messages.form.addyoutube')"><i
                                        class="icon-youtube"></i></button>
                                <button onclick="addNew('tweet_add')" type="button" name="tweet_add"
                                    class="btn btn-lg btn-light btnadd me-1" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="@lang('messages.form.addtweet')"><i
                                        class="icon-twitter"></i></button>
                                <button onclick="addNew('face_add')" type="button" name="face_add"
                                    class="btn btn-lg btn-light btnadd me-1" data-bs-toggle="tooltip"
                                    data-bs-placement="bottom" title="@lang('messages.form.addfb')"><i
                                        class="icon-facebook"></i></button>
                                <button onclick="addNew('instagram_add')" type="button" name="instagram_add"
                                    class="btn btn-lg btn-light btnadd" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    title="@lang('messages.form.addinst')"><i class="icon-instagram"></i></button>
                                <button onclick="addNew('pinterest_add')" type="button" name="pinterest_add"
                                    class="btn btn-lg btn-light btnadd" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    title="@lang('messages.form.addpin')"><i class="icon-pinterest"></i></button>
                                <button onclick="addNew('tiktok_add')" type="button" name="tiktok_add"
                                    class="btn btn-lg btn-light btnadd" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                    title="@lang('messages.form.addtiktok')"><i class="icon-tiktok"></i></button>
                            </div>
                        </div>
                        <div id="subbtn" class="mb-3 row mb-5">
                            <div class="offset-md-3 col-md-7">
                                <div id="show-err-msg" class="text-danger print-error-msg d-none">
                                    <ul id="list"></ul>
                                </div>
                                <button onclick="ClickForm()" id="submit"
                                    class="btn btn-success">@lang('messages.form.submit')</button>
                            </div>
                        </div>
                    </form>
                    <div class="modal fade" id="helpModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">@lang('messages.form.addex')</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-sm">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Heading</th>
                                                <td class="font-italic">This is my Heading.</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Text</th>
                                                <td class="font-italic">This is my text.</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Text Editor</th>
                                                <td class="font-italic">This is my <strong>text</strong> with style.</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Image</th>
                                                <td class="font-italic">Upload Image here.</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Youtube</th>
                                                <td class="font-italic">https://www.youtube.com/watch?v=_38JDGnr0vA</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Tweet</th>
                                                <td class="font-italic">https://twitter.com/Interior/status/463440424141459456
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Facebook</th>
                                                <td class="font-italic">
                                                    https://www.facebook.com/20531316728/posts/10154009990506729/</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Instagram</th>
                                                <td class="font-italic">https://www.instagram.com/p/tsxp1hhQTG/</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Pinterest</th>
                                                <td class="font-italic">https://www.pinterest.com/pin/99360735500167749/</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Tiktok</th>
                                                <td class="font-italic">
                                                    https://www.tiktok.com/@scout2015/video/6718335390845095173</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                    @include('posts.formfields')
                @else
                    <div class="alert alert-warning" role="alert">
                        <strong>@lang('messages.form.nofound')</strong> @lang('messages.backto') <a
                            href="{{ url('/') }}">@lang('messages.hometxt')</a>.
                    </div>
                @endcanany
            </div>
        </div>
    @endsection
    @push('scripts')
        <script>
            var embedURL = "{{ url('admincp/postEmbed') }}";
            var imgURL = "{{ url('admincp/uploadImg') }}";
            var delURL = "{{ url('admincp/deleteImg') }}";
            var delContent = "{{ url('/delete/content') }}";
            var embedtxt = "@lang('messages.form.embed')";
            var editortxt = "@lang('messages.form.editor')";
            var removetxt = "@lang('messages.form.removetxt')";
            var processing = "@lang('messages.form.processing')";
            var submittxt = "@lang('messages.form.submittxt')";
            var browse = "@lang('messages.form.browse')";
            var formtext = "@lang('messages.form.text')";
            var imguploaded = "@lang('messages.form.imguploaded')";
            var imgremoved = "@lang('messages.form.imgremoved')";
            var fileUploading = "@lang('messages.form.file_uploading')";
            var blank = "@lang('messages.new.blank')";
            var imagealt = "@lang('messages.new.imagealt')";
            var link = "@lang('messages.new.link')";
            var self = "@lang('messages.new.self')"
            Sortable.create(dynamic_field, {
                handle: '.span-move',
                animation: 150
            });

            let editors = document.querySelectorAll(".alleditor");
            if (editors.length > 0) {
                var ec = 1;
                var toolbarOptions = [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block', 'link'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    [{
                        'color': []
                    }, {
                        'background': []
                    }],
                    ['clean']
                ];
                editors.forEach(function() {
                    var quill = new Quill('#qeditor' + ec++, {
                        theme: 'snow',
                        modules: {
                            toolbar: toolbarOptions
                        },
                    });
                });
            }
        </script>
        <script src="{{ asset('/js/form.js') }}"></script>
    @endpush
