<div class="tab-pane @if (old('page')) active @endif" id="tab_1_3">
  <div class="row profile-account">
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<div class="col-md-3">
    <ul class="ver-inline-menu tabbable margin-bottom-10">
        <li @if (!old('page') || (old('page') && old('page') === 'update_info')) class="active" @endif>
            <a data-toggle="tab" href="#tab_1-1">
                <i class="fa fa-cog"></i> Personal info </a>
            <span class="after"> </span>
        </li>

        <li @if (old('page') && old('page') === 'change_password') class="active" @endif>
            <a data-toggle="tab" href="#tab_3-3">
                <i class="fa fa-lock"></i> Change Password </a>
        </li>
    </ul>
</div>
<div class="col-md-9">
    <div class="tab-content">
        <div id="tab_1-1" class="tab-pane @if (!old('page') || (old('page') && old('page') === 'update_info')) active @endif">
            @include('user.profile-partials.forms.update_info')
        </div>

        <div id="tab_3-3" class="tab-pane @if (old('page') && old('page') === 'change_password') active @endif">
            @include('user.profile-partials.forms.change_password')
        </div>
    </div>
</div>
</div>
</div>