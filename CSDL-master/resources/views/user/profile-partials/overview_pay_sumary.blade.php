<div class="col-md-3">

  <div class="portlet sale-summary">
    <div class="portlet-title">
      <div class="caption font-red-haze sbold"> Pay Summary </div>
    </div>
    <div class="portlet-body">
      <ul class="list-unstyled">
        <li>
          <span class="sale-info"> TODAY PAID
              <i class="fa fa-img-up"></i>
          </span>
          <span class="sale-num">$ {{ $user->getTodayPaid() }}</span>
        </li>
        <li>
          <span class="sale-info"> WEEKLY PAID
              <i class="fa fa-img-down"></i>
          </span>
          <span class="sale-num"> ${{$user->getWeekPaid()}} </span>
        </li>
        <li>
          <span class="sale-info"> TOTAL PAID  </span>
          <span class="sale-num"> ${{$user->getTotalPaid()}} </span>
        </li>
      </ul>
    </div>
  </div>
</div>