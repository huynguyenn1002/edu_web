<div class="tab-pane @if (!$hasPrevPage) active @endif" id="tab_1_1">
  <div class="row">
    <div class="col-md-3">
      <ul class="list-unstyled profile-nav">
        <li>
          <img src="{{ Storage::url($user->avatar) }}" class="img-responsive pic-bordered" alt=""/>
        </li>
      </ul>
    </div>
    <div class="col-md-9">
      <div class="row">
        @include('user.profile-partials.overview_profile')
        @include('user.profile-partials.overview_pay_sumary')
        @include('user.profile-partials.overview_sale_sumary')
      </div>
    </div>
    <div class="col-md-12">
      @include('user.profile-partials.overview_table_courses')
    </div>
  </div>
</div>