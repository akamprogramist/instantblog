@extends('layouts.admin')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">@lang('admin.editcat')</h1>  
    </div>
    <div class="box-white ms-3 me-3 shadow-sm">
        @include('layouts.errors')
        <form method="POST" action="{{url('/cats/' . $tag->id)}}" enctype="multipart/form-data">
            {{ method_field('PUT') }}
            @csrf
            <div class="mb-3 row">
                <label for="title" class="col-sm-4 col-form-label">@lang('admin.cattitle')</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="title" name="title" value="{{ $tag->title }}" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="name" class="col-sm-4 col-form-label">@lang('admin.catname')</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="name" name="name" value="{{ $tag->name }}" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" >@lang('admin.image')</label>
                <div class="col-sm-1">
                    <img class="avatar img-fluid" src="{{ url('/uploads/' . $tag->tag_media) }}">
                </div> 
                <div class="col-sm-6">     
                    <input type="file" class="form-control-file" id="tag_media" name="tag_media" aria-describedby="fileHelp">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="desc" class="col-sm-4 col-form-label">@lang('admin.metadesc')</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="desc" name="desc" value="{{ $tag->desc }}">
                    <small id="desc" class="form-text text-muted">@lang('admin.metadescinfo')</small>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" >@lang('admin.catcolor')</label>
                <div class="col-sm-6"> 
                    <div class="form-check form-check-inline mt-2">    
                        <input class="form-check-input" type="radio" name="color" id="inlineRadio1" value="bg-cat-1" checked>
                        <label class="form-check-label color-box bg-cat-1 text-white" for="inlineRadio1"><i class="icon-card-list"></i>
                        </label> 
                    </div>
                    <div class="form-check form-check-inline mt-2">    
                        <input class="form-check-input" type="radio" name="color" id="inlineRadio2" value="bg-cat-4" >
                        <label class="form-check-label color-box bg-cat-4 text-white" for="inlineRadio2"><i class="icon-card-list"></i>
                        </label> 
                    </div>
                    <div class="form-check form-check-inline">    
                        <input class="form-check-input" type="radio" name="color" id="inlineRadio3" value="bg-danger">
                        <label class="form-check-label color-box bg-danger text-white" for="inlineRadio3"><i class="icon-card-list"></i>
                        </label> 
                    </div>
                    <div class="form-check form-check-inline mt-2">    
                        <input class="form-check-input" type="radio" name="color" id="inlineRadio4" value="bg-cat-2" >
                        <label class="form-check-label color-box bg-cat-2 text-white" for="inlineRadio4"><i class="icon-card-list"></i>
                        </label> 
                    </div>
                    <div class="form-check form-check-inline">    
                        <input class="form-check-input" type="radio" name="color" id="inlineRadio5" value="bg-primary" >
                        <label class="form-check-label color-box bg-primary text-white" for="inlineRadio5"><i class="icon-card-list"></i>
                        </label> 
                    </div>
                    <div class="form-check form-check-inline">    
                        <input class="form-check-input" type="radio" name="color" id="inlineRadio6" value="bg-info">
                        <label class="form-check-label color-box bg-info text-white" for="inlineRadio6"><i class="icon-card-list"></i>
                        </label> 
                    </div>                    
                    <div class="form-check form-check-inline">    
                        <input class="form-check-input" type="radio" name="color" id="inlineRadio7" value="bg-success">
                        <label class="form-check-label color-box bg-success text-white" for="inlineRadio7"><i class="icon-card-list"></i>
                        </label> 
                    </div>
                    <div class="form-check form-check-inline">    
                        <input class="form-check-input" type="radio" name="color" id="inlineRadio8" value="bg-warning">
                        <label class="form-check-label color-box bg-warning text-white" for="inlineRadio8"><i class="icon-card-list"></i>
                        </label> 
                    </div>
                    <div class="form-check form-check-inline mt-2">    
                        <input class="form-check-input" type="radio" name="color" id="inlineRadio9" value="bg-cat-3" >
                        <label class="form-check-label color-box bg-cat-3 text-white" for="inlineRadio9"><i class="icon-card-list"></i>
                        </label> 
                    </div>
                    <div class="form-check form-check-inline mt-2">    
                        <input class="form-check-input" type="radio" name="color" id="inlineRadio10" value="bg-cat-5" >
                        <label class="form-check-label color-box bg-cat-5 text-white" for="inlineRadio10"><i class="icon-card-list"></i>
                        </label> 
                    </div>
                    <div class="form-check form-check-inline">    
                        <input class="form-check-input" type="radio" name="color" id="inlineRadio11" value="bg-secondary" >
                        <label class="form-check-label color-box bg-secondary text-white" for="inlineRadio11"><i class="icon-card-list"></i>
                        </label> 
                    </div>
                    <div class="form-check form-check-inline">    
                        <input class="form-check-input" type="radio" name="color" id="inlineRadio12" value="bg-dark">
                        <label class="form-check-label color-box bg-dark text-white" for="inlineRadio12"><i class="icon-card-list"></i>
                        </label> 
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="offset-sm-4 col-sm-7">
                    <button type="submit" class="btn btn-primary me-3">@lang('admin.update')</button>
                    <a class="btn btn-danger" role="button" href="{{ url('cats') }}"> @lang('admin.cancel') </a>
                </div>
            </div>
        </form>
    </div>
@endsection