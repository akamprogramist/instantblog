@extends('layouts.admin')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">@lang('admin.money')</h1>
    </div>

    <div class="row box-white ms-3 me-3 mt-2 shadow-sm">
        @include('layouts.errors')
        <form method="POST" action="{{ url('/money/' . $money->id) }}" enctype="multipart/form-data">

            {{ method_field('PUT') }}

            @csrf
            <div class="tab-content">
                <div class="tab-pane active" id="mainsettings" role="tabpanel">
                    <div class="mb-3 row">
                        <label for="money_iqd" class="col-sm-4 col-form-label">@lang('admin.iqd')</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="money_iqd" name="money_iqd"
                                value="{{ $money->money_iqd }}" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="money_usd" class="col-sm-4 col-form-label">@lang('admin.usd')</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="money_usd" name="money_usd"
                                value="{{ $money->money_usd }}" required>
                        </div>
                    </div>

                </div>
            </div>
    </div>

    <div class="mb-3 row">
        <div class="offset-sm-4 col-sm-7">
            <button onclick="ClickSave()" type="submit" class="btn btn-primary me-3">@lang('admin.save')</button>
            <a href="{{ url('/home/') }}" class="btn btn-danger" role="button">@lang('admin.cancel')</a>
        </div>
    </div>
    </form>
@endsection
@push('scripts')
    <script>
        var toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'],
            ['link', 'clean']
        ];

        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: toolbarOptions
            },
        });
    </script>
@endpush
