@extends('layouts.master')
@section('css')
<link href="{{ asset('/quill/dist/quill.snow.css') }}" rel="stylesheet">
<script src="{{ asset('/js/Sortable.js') }}"></script>
@endsection
@section('bodyclass')
<body class="bg-userside">
@endsection
@section('jumbotron')
    <div class="jumbotron">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <h1 class="display-4">@lang('messages.form.title_add')</h1>
                </div>
                <div class="col-md-3">
                    @auth
                    <div class="admin-item-img">
                        <a href="{{ url('/profile/' . auth()->user()->username) }}">
                            @if (substr( auth()->user()->avatar, 0, 4 ) === "http")
                            <img src="{{ auth()->user()->avatar }}" class="admin-image rounded-circle">
                            @else
                            <img src="{{ url('/images/' . auth()->user()->avatar) }}" class="admin-image rounded-circle">
                            @endif
                        </a>
                    </div>                    
                    <a href="{{ url('/profile/' . auth()->user()->username) }}">
                        <p class="member-item-user">{{ auth()->user()->name }}</p>
                    </a>
                    <p class="member-item-text">{{ auth()->user()->username }}</p>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    @modorall
    <div class="container">
        <div class="content pt-5 pb-4">
            <div id="show-msg" class="alert alert-success print-success-msg d-none" role="alert">
            </div>
            <form method="POST" action="{{ url('/home') }}" id="post_form">
                <div class="mb-3 row">
                    <label for="post_title" class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.title')</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" id="post_title" name="post_title">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="post_desc" class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.description')</label>
                    <div class="col-md-7">
                        <textarea class="form-control" id="post_desc" name="post_desc"></textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="post_desc" class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.type')</label>
                    <div class="col-md-7">
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-image-tab" data-bs-toggle="pill" href="#pills-image" role="tab" aria-controls="pills-image" aria-selected="true">@lang('messages.form.imagepost')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-video-tab" data-bs-toggle="pill" href="#pills-video" role="tab" aria-controls="pills-video" aria-selected="false">@lang('messages.form.videopost')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-text-tab" data-bs-toggle="pill" href="#pills-text" role="tab" aria-controls="pills-text" aria-selected="false">@lang('messages.form.textpost')</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-image" role="tabpanel" aria-labelledby="pills-image-tab">
                        <div class="mb-3 row">
                            <label class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.upload')</label>
                            <div class="col-md-7 d-flex">
                            <div class="fileinputs me-3">
                                <label class="btn btn-info btnfile">@lang('messages.form.browse')
                                    <input onchange="ImageUpload(this)" class="fileupload d-none" type="file" name="post_image">
                                </label>
                            </div>
                            <input class="photo_upload" name="post_media" type="hidden" value="">
                            <div class="fileinfo d-flex">
                            </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.imgoverlay')</label>
                            <div class="col-sm-7">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gridCheck1" name="post_instant" value="1">
                                    <label class="form-check-label" for="gridCheck1">
                                    @lang('messages.form.imgoverlay_check')
                                </label>
                                </div>
                           </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-video" role="tabpanel" aria-labelledby="pills-video-tab">
                        <div class="mb-3 row">
                            <label for="post_video" class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.postvideo')</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="post_video" name="post_video" aria-describedby="videoHelp">
                                <small id="videoHelp" class="form-text text-muted">@lang('messages.form.videoex')</small>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-text" role="tabpanel" aria-labelledby="pills-text-tab">
                        <div class="mb-3 row">
                            <label for="post_video" class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.bg')</label>
                            <div class="col-md-7">
                                <div class="form-check form-check-inline">    
                                    <input class="form-check-input" type="radio" name="post_color" id="inlineRadio1" value="bg-primary" checked>
                                        <label class="form-check-label color-box bg-primary text-white" for="inlineRadio1"><i class="icon-card-list"></i>
                                    </label> 
                                </div>
                                <div class="form-check form-check-inline">    
                                    <input class="form-check-input" type="radio" name="post_color" id="inlineRadio2" value="bg-secondary">
                                        <label class="form-check-label color-box bg-secondary text-white" for="inlineRadio2"><i class="icon-card-list"></i>
                                    </label> 
                                </div>
                                <div class="form-check form-check-inline">    
                                    <input class="form-check-input" type="radio" name="post_color" id="inlineRadio3" value="bg-danger">
                                        <label class="form-check-label color-box bg-danger text-white" for="inlineRadio3"><i class="icon-card-list"></i>
                                    </label> 
                                </div>
                                <div class="form-check form-check-inline">    
                                    <input class="form-check-input" type="radio" name="post_color" id="inlineRadio4" value="bg-warning">
                                        <label class="form-check-label color-box bg-warning text-white" for="inlineRadio4"><i class="icon-card-list"></i>
                                    </label> 
                                </div>
                                <div class="form-check form-check-inline">    
                                    <input class="form-check-input" type="radio" name="post_color" id="inlineRadio5" value="bg-info">
                                        <label class="form-check-label color-box bg-info text-white" for="inlineRadio5"><i class="icon-card-list"></i>
                                    </label> 
                                </div>
                                <div class="form-check form-check-inline">    
                                    <input class="form-check-input" type="radio" name="post_color" id="inlineRadio6" value="bg-dark">
                                        <label class="form-check-label color-box bg-dark text-white" for="inlineRadio6"><i class="icon-card-list"></i>
                                    </label> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('posts.tagselect')
                <div id="dynamic_field">
                </div>

                <div class="mb-3 row mb-5">
                    <label class="offset-md-1 col-md-2 col-form-label"><strong>@lang('messages.form.more') </strong> <a href="#" data-bs-toggle="modal" data-bs-target="#helpModal"><i class="icon-info-circle"></i></a>
                    </label>
                    <div class="col-md-7">             
                        <button onclick="addNew('header_add')" type="button" name="header_add" class="btn btn-lg btn-light btnadd me-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('messages.form.addheading')"><i class="icon-type-h1"></i></button>
                        <button onclick="addNew('txt_add')" type="button" name="txt_add" class="btn btn-lg btn-light btnadd me-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('messages.form.addsimple')"><i class="icon-fonts"></i></button>
                        <button onclick="addText()" type="button" id="texteditor" class="btn btn-lg btn-light me-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('messages.form.addeditor')"><i class="icon-textarea-t"></i></button>
                        <button onclick="addNew('img_add')" type="button" name="img_add" class="btn btn-lg btn-light btnadd me-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('messages.form.addimage')"><i class="icon-image"></i></button>
                        <button onclick="addNew('youtube_add')" type="button" name="youtube_add" class="btn btn-lg btn-light btnadd me-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('messages.form.addyoutube')"><i class="icon-youtube"></i></button>
                        <button onclick="addNew('tweet_add')" type="button" name="tweet_add" class="btn btn-lg btn-light btnadd me-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('messages.form.addtweet')"><i class="icon-twitter"></i></button>
                        <button onclick="addNew('face_add')" type="button" name="face_add" class="btn btn-lg btn-light btnadd me-1" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('messages.form.addfb')"><i class="icon-facebook"></i></button>
                        <button onclick="addNew('instagram_add')" type="button" name="instagram_add" class="btn btn-lg btn-light btnadd" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('messages.form.addinst')"><i class="icon-instagram"></i></button>
                        <button onclick="addNew('pinterest_add')" type="button" name="pinterest_add" class="btn btn-lg btn-light btnadd" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('messages.form.addpin')"><i class="icon-pinterest"></i></button>
                        <button onclick="addNew('tiktok_add')" type="button" name="tiktok_add" class="btn btn-lg btn-light btnadd" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('messages.form.addtiktok')"><i class="icon-tiktok"></i></button>
                    </div>
                </div>
                <div id="subbtn" class="mb-3 row mb-5">
                    <div class="offset-md-3 col-md-7">
                        <div id="show-err-msg" class="text-danger print-error-msg d-none">
                            <ul id="list"></ul>
                        </div>   
                        <button onclick="ClickForm()" id="submit" class="btn btn-success">@lang('messages.form.submit')</button>
                    </div>
                </div>
            </form>
            <div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">@lang('messages.form.addex')</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                        <td class="font-italic">https://twitter.com/Interior/status/463440424141459456</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Facebook</th>
                                        <td class="font-italic">https://www.facebook.com/20531316728/posts/10154009990506729/</td>
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
                                        <td class="font-italic">https://www.tiktok.com/@scout2015/video/6718335390845095173</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            @include('posts.formfields')    
        </div>
    </div>
    @else
    <div class="container">
        <h5>@lang('messages.form.nofound')</h5>
    </div>
    @endmodorall
@endsection

@push('scripts')
<script src="{{ asset('/quill/dist/quill.min.js') }}"></script>
<script>
    var embedURL = "{{ url('admincp/postEmbed') }}";
    var imgURL = "{{ url('admincp/uploadImg') }}";
    var delURL = "{{ url('admincp/deleteImg') }}";
    var avatarURL = "{{ url('/uploads/') }}";
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
    var self = "@lang('messages.new.self')";
    Sortable.create(dynamic_field, {
          handle: '.span-move',
          animation: 150,
    });   
</script>
<script src="{{ asset('/js/form.js') }}"></script>
@endpush
