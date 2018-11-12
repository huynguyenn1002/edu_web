<div class="col-md-3">
  <div class="portlet sale-summary">
    <div class="portlet-title">
      <div class="caption font-red-haze sbold"> Sale Summary </div>
    </div>
    <div class="portlet-body">
      <ul class="list-unstyled">
        <li>
          <span class="sale-info"> TODAY SOLD
              <i class="fa fa-img-up"></i>
          </span>
            <span class="sale-num"> ${{$user->getTodaySold()}}</span>
        </li>
        <li>
          <span class="sale-info"> WEEKLY SOLD
              <i class="fa fa-img-down"></i>
          </span>
              <span class="sale-num"> ${{$user->getWeekSold()}}</span>
        </li>
        <li>
          <span class="sale-info"> TOTAL SOLD </span>
              <span class="sale-num"> ${{$user->getTotalSold()}}</span>
        </li>
      </ul>
    </div>
  </div>
</div>