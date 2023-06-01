@extends('layouts.admin')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">@lang('admin.addnewpage')</h1>  
    </div>
    <div class="box-white ms-3 me-3 shadow-sm">
        @include('layouts.errors')
        <form method="POST" action="{{ url('/pages') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3 row">
                <label for="page_title" class="col-sm-3 col-form-label">@lang('admin.pagetitle')</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="page_title" name="page_title" required>
                    <small id="name" class="form-text text-muted">@lang('admin.required')</small>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="page_slug" class="col-sm-3 col-form-label">@lang('admin.pageslug')</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="page_slug" name="page_slug" required>
                    <small id="name" class="form-text text-muted">@lang('admin.required')</small>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="page_content" class="col-sm-3 col-form-label">@lang('admin.pagecontent')</label>
                <div class="col-sm-9 myeditor">
                    <div id="pageeditor"></div>
                    <input class="txtcont" type="hidden" name="page_content">
                </div>
            </div>
            <div class="mb-3 row">
                <div class="offset-sm-3 col-sm-9">
                    <button onclick="ClickSave()" type="submit" class="btn btn-primary me-2">@lang('admin.create')</button>
                    <a class="btn btn-danger" role="button" href="{{ url('pages') }}"> @lang('admin.cancel') </a>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
<script>
var toolbarOptions = [
      ['bold', 'italic', 'underline', 'strike'],
      ['blockquote', 'code-block', 'link', 'image'],
      [{ 'list': 'ordered'}, { 'list': 'bullet' }],
      [{ 'color': [] }, { 'background': [] }],
      ['clean']
    ];
    
var Image = Quill.import('formats/image');
  Image.className = 'img-fluid';
  Quill.register(Image, true);

var quill = new Quill('#pageeditor', {
  theme: 'snow',
  modules: {
    toolbar: toolbarOptions
  },
});

</script>
@endpush