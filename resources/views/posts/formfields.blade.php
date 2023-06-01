<div class="d-none">
    <div id="header_add">
        <label class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.heading')</label>
        <div class="col-sm-10 col-md-7">
            <div class="input-group">
                <input type="text" class="form-control w-85" name="content[]" placeholder="@lang('messages.form.heading_help')">
                <input type="hidden" name="type[]" value="header">
                    <select class="form-select w-15" name="extra[]" aria-label="select">
                      <option value="h1" selected>H1</option>
                      <option value="h2">H2</option>
                      <option value="h3">H3</option>
                      <option value="h4">H4</option>
                      <option value="h5">H5</option>
                      <option value="h6">H6</option>                      
                    </select>
            </div>
        </div>
    </div>
    <div id="txt_add">
        <label class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.text')</label>
        <div class="col-sm-10 col-md-7">
            <textarea class="form-control" name="content[]" placeholder="@lang('messages.form.text_help')"></textarea>
            <input type="hidden" name="type[]" value="text">
            <input type="hidden" name="extra[]">
        </div>
    </div>
    <div id="img_add">
        <label class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.upload')</label>
        <div class="col-md-7 d-flex">
            <div class="fileinputs me-3">
                <label class="btn btn-info btnfile">@lang('messages.form.browse')
                    <input onchange="ImageUpload(this)" class="fileupload d-none" type="file" name="post_image">
                </label>
            </div>
            <input class="photo_upload" name="content[]" type="hidden" value="">             
            <input type="hidden" name="type[]" value="image">
            <div class="fileinfo d-flex">
            </div>
        </div>
    </div>
    <div id="youtube_add">
        <label class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.youtube')</label>
        <div class="col-sm-10 col-md-7">
            <input type="text" class="form-control" name="content[]" placeholder="@lang('messages.form.youtube_help')">
            <input type="hidden" name="type[]" value="youtube">
            <input type="hidden" name="extra[]">
        </div>
    </div>
    <div id="tweet_add">
        <label class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.tweet')</label>
        <div class="col-sm-10 col-md-7">
            <div class="input-group">                
                <input name="embed_url" type="text" class="form-control" placeholder="@lang('messages.form.tweet_help')">
                <button class="btn btn-success" type="button" onclick="ClickEmbed(this)">@lang('messages.form.embed')</button>
            </div>
        </div>
        <input type="hidden" class="form-control" name="content[]" value="">
        <input type="hidden" name="type[]" value="tweet">
        <input type="hidden" name="extra[]">
    </div>
    <div id="face_add">
        <label class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.facebook')</label>
        <div class="col-sm-10 col-md-7">
            <div class="input-group">               
                <input name="embed_url" type="text" class="form-control" placeholder="@lang('messages.form.facebook_help')">
                <button class="btn btn-success" type="button" onclick="ClickEmbed(this)">@lang('messages.form.embed')</button>
            </div>
        </div>
        <input type="hidden" class="form-control" name="content[]" value="">
        <input type="hidden" name="type[]" value="facebook">
        <input type="hidden" name="extra[]">
    </div>
    <div id="instagram_add">
        <label class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.instagram')</label>
        <div class="col-sm-10 col-md-7">
            <div class="input-group">                 
                <input name="embed_url" type="text" class="form-control" placeholder="@lang('messages.form.instagram_help')">
                <button class="btn btn-success" type="button" onclick="ClickEmbed(this)">@lang('messages.form.embed')</button>
            </div>
        </div>
        <input type="hidden" class="form-control" name="content[]" value="">
        <input type="hidden" name="type[]" value="instagram">
        <input type="hidden" name="extra[]">
    </div>
    <div id="pinterest_add">
        <label class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.pinterest')</label>
        <div class="col-sm-10 col-md-7">
            <div class="input-group">                 
                <input name="embed_url" type="text" class="form-control" placeholder="@lang('messages.form.pinterest_help')">
                <button class="btn btn-success" type="button" onclick="ClickEmbed(this)">@lang('messages.form.embed')</button>
            </div>
        </div>
        <input type="hidden" class="form-control" name="content[]" value="">
        <input type="hidden" name="type[]" value="pinterest">
        <input type="hidden" name="extra[]">
    </div>
    <div id="tiktok_add">
        <label class="offset-md-1 col-md-2 col-form-label">@lang('messages.form.addtiktok')</label>
        <div class="col-sm-10 col-md-7">
            <div class="input-group">                 
                <input name="embed_url" type="text" class="form-control" placeholder="@lang('messages.form.tiktok_help')">
                <button class="btn btn-success" type="button" onclick="ClickEmbed(this)">@lang('messages.form.embed')</button>
            </div>
        </div>
        <input type="hidden" class="form-control" name="content[]" value="">
        <input type="hidden" name="type[]" value="tiktok">
        <input type="hidden" name="extra[]">
    </div>
</div>