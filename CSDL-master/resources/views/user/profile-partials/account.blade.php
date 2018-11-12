<div class="tab-pane @if ($hasPrevPage) active @endif" id="tab_1_3">
  <div class="row profile-account">
    <div class="col-md-3">
      <ul class="ver-inline-menu tabbable margin-bottom-10">
        <li @if (!$hasPrevPage || ($hasPrevPage && $prevPage === 'update_info')) class="active" @endif>
          <a data-toggle="tab" href="#tab_1-1">
            <i class="fa fa-cog"></i> Personal info </a>
          <span class="after"> </span>
        </li>
        <li @if ($hasPrevPage && $prevPage === 'update_ava') class="active" @endif>
          <a data-toggle="tab" href="#tab_2-2">
            <i class="fa fa-picture-o"></i> Change Avatar </a>
        </li>
        <li @if ($hasPrevPage && $prevPage === 'change_password') class="active" @endif>
          <a data-toggle="tab" href="#tab_3-3">
            <i class="fa fa-lock"></i> Change Password </a>
        </li>
        <li @if ($hasPrevPage && $prevPage === 'update_balance') class="active" @endif>
          <a data-toggle="tab" href="#tab_3-4">
            <i class="fa fa-money"></i> Balance </a>
        </li>
      </ul>
    </div>
    <div class="col-md-9">
      <div class="tab-content">
        <div id="tab_1-1" class="tab-pane @if (!$hasPrevPage || ($hasPrevPage && $prevPage === 'update_info')) active @endif">
          @include('user.profile-partials.forms.update_info')
        </div>
        <div id="tab_2-2" class="tab-pane @if ($hasPrevPage && $prevPage === 'update_ava') active @endif">
          @include('user.profile-partials.forms.update_avatar')
        </div>
        <div id="tab_3-3" class="tab-pane @if ($hasPrevPage && $prevPage === 'change_password') active @endif">
          @include('user.profile-partials.forms.change_password')
        </div>
        <div id="tab_3-4" class="tab-pane @if ($hasPrevPage && $prevPage === 'update_balance') active @endif">
          @include('user.profile-partials.forms.update_balance')
        </div>
      </div>
    </div>
  </div>
</div>