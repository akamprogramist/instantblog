@extends('layouts.admin')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">@lang('admin.settings')</h1>  
    </div>
    <div class="row ms-3 me-3">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#mainsettings" role="tab">@lang('admin.main')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#optional" role="tab">@lang('admin.optional')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#adsense" role="tab">@lang('admin.adsense')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#google" role="tab">@lang('admin.googleamp')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#cookie" role="tab">@lang('admin.cookie')</a>
            </li>
        </ul>
    </div>
    <div class="row box-white ms-3 me-3 mt-2 shadow-sm">  
        @include('layouts.errors')
        <form method="POST" action="{{url('/settings/' . $setting->id)}}" enctype="multipart/form-data">

            {{ method_field('PUT') }}

            @csrf
            <div class="tab-content">
                <div class="tab-pane active" id="mainsettings" role="tabpanel">
                    <div class="mb-3 row">
                        <label for="site_name" class="col-sm-4 col-form-label">@lang('admin.sitename')</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="site_name" name="site_name" value="{{ $setting->site_name }}" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="site_desc" class="col-sm-4 col-form-label">@lang('admin.sitedesc')</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="site_desc" name="site_desc" value="{{ $setting->site_desc }}" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="site_title" class="col-sm-4 col-form-label">@lang('admin.sitetitle')</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="site_title" name="site_title" value="{{ $setting->site_title }}" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label" >@lang('admin.sitelogo')</label>
                        <div class="col-sm-7">     
                            <input type="file" class="form-control" id="site_logo" name="site_logo" aria-describedby="fileHelp">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label" >@lang('admin.sitelogolight')</label>
                        <div class="col-sm-7">     
                            <input type="file" class="form-control" id="site_logo_light" name="site_logo_light" aria-describedby="fileHelp">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="theme" class="col-sm-4 col-form-label">@lang('admin.defaulttheme')</label>
                        <div class="col-sm-7">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" 
                                    @if ($setting->theme == 'dark')
                                    checked="checked" 
                                    @endif
                                    type="radio" name="theme" id="theme1" value="dark"> @lang('admin.dark')
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input"
                                    @if ($setting->theme == 'light')
                                    checked="checked" 
                                    @endif
                                    type="radio" name="theme" id="theme2" value="light">@lang('admin.light')
                                </label>
                            </div>
                        </div>
                    </div>
                     <div class="mb-3 row">
                        <label for="site_title" class="col-sm-4 col-form-label">@lang('admin.sitefooter')</label>
                        <div class="col-sm-7 myeditor">
                            <div id="editor">{!! clean( $setting->footer ) !!}</div>
                            <input class="txtcont" type="hidden" name="footer">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="allow_users" class="col-sm-4 col-form-label">@lang('admin.allowuserpost')</label>
                        <div class="col-sm-7">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" 
                                    @if ($setting->allow_users == '0')
                                    checked="checked" 
                                    @endif
                                    type="radio" name="allow_users" id="inlineRadio1" value="0"> @lang('admin.yes')
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input"
                                    @if ($setting->allow_users == '1')
                                    checked="checked" 
                                    @endif
                                    type="radio" name="allow_users" id="inlineRadio2" value="1">@lang('admin.no')
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="check_cont" class="col-sm-4 col-form-label">@lang('admin.checkusercont')</label>
                        <div class="col-sm-7">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" 
                                    @if ($setting->check_cont == '0')
                                    checked="checked" 
                                    @endif
                                    type="radio" name="check_cont" id="inlineRadio1" value="0"> @lang('admin.yes')
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input"
                                    @if ($setting->check_cont == '1')
                                    checked="checked" 
                                    @endif
                                    type="radio" name="check_cont" id="inlineRadio2" value="1"> @lang('admin.no')
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="allow_comments" class="col-sm-4 col-form-label">@lang('admin.allowcomments')</label>
                        <div class="col-sm-7">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" 
                                    @if ($setting->allow_comments == '0')
                                    checked="checked" 
                                    @endif
                                    type="radio" name="allow_comments" id="inlineRadio1" value="0"> @lang('admin.yes')
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input"
                                    @if ($setting->allow_comments == '1')
                                    checked="checked" 
                                    @endif
                                    type="radio" name="allow_comments" id="inlineRadio2" value="1"> @lang('admin.no')
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="optional" role="tabpanel">

                    <div class="mb-3 row">
                        <label for="site_analytic" class="col-sm-4 col-form-label">@lang('admin.codehead')</label>
                        <div class="col-sm-7">
                        <textarea class="form-control" id="site_analytic" name="site_analytic" rows="5">{{ $setting->site_analytic }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="adsense" role="tabpanel">
                    <div class="mb-3">
                        <label for="header_ads">@lang('admin.postadscode')</label>
                        <textarea class="form-control" id="post_ads" name="post_ads" rows="5">{{ $setting->post_ads }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="page_ads">@lang('admin.postsideads')</label>
                        <textarea class="form-control" id="page_ads" name="page_ads" rows="5">{{ $setting->page_ads }}</textarea>
                    </div> 
                    <div class="mb-3">
                        <label for="page_ads">@lang('admin.betweenads')</label>
                        <textarea class="form-control" id="between_ads" name="between_ads" rows="5">{{ $setting->between_ads }}</textarea>
                    </div>                   
                </div>

                <div class="tab-pane" id="google" role="tabpanel">
                    <div class="mb-3 row">
                        <label for="amp_ad_server" class="col-sm-3 col-form-label">@lang('admin.adsonamp')</label>
                        <div class="col-sm-9">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" 
                                    @if ($setting->amp_ad_server == '0')
                                    checked="checked" 
                                    @endif
                                    type="radio" name="amp_ad_server" id="inlineRadio1" value="0"> @lang('admin.yes') 
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input"
                                    @if ($setting->amp_ad_server == '1')
                                    checked="checked" 
                                    @endif
                                    type="radio" name="amp_ad_server" id="inlineRadio2" value="1"> @lang('admin.no')
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="amp_adscode" class="col-sm-3 col-form-label">@lang('admin.adscode')</label>
                        <div class="col-sm-9">
                        <textarea class="form-control" id="amp_adscode" name="amp_adscode" rows="5">{{ $setting->amp_adscode }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="cookie" role="tabpanel">
                    <div class="mb-3 row">
                        <label for="cookie_option" class="col-sm-3 col-form-label">@lang('admin.showcookie')</label>
                        <div class="col-sm-9">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" 
                                    @if ($setting->cookie_option == '0')
                                    checked="checked" 
                                    @endif
                                    type="radio" name="cookie_option" id="inlineRadio1" value="0"> @lang('admin.yes') 
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input"
                                    @if ($setting->cookie_option == '1')
                                    checked="checked" 
                                    @endif
                                    type="radio" name="cookie_option" id="inlineRadio2" value="1"> @lang('admin.no')
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="cookie_title" class="col-sm-3 col-form-label">@lang('admin.cookietitle')</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" id="cookie_title" name="cookie_title" value="{{ $setting->cookie_title }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="cookie_body" class="col-sm-3 col-form-label">@lang('admin.cookiebody')</label>
                        <div class="col-sm-9">
                        <textarea class="form-control" id="cookie_body" name="cookie_body" rows="5">{{ $setting->cookie_body }}</textarea>
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
                
            </div>
        </form>
    </div>
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