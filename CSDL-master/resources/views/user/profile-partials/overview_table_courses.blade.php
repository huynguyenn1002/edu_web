<div class="tabbable-line tabbable-custom-profile">
  <ul class="nav nav-tabs">
    <li class="active">
      <a href="#tab_1_11" data-toggle="tab"> My courses </a>
    </li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="tab_1_11">
      <div class="table-toolbar">
        <div class="row">
          <div class="col-md-6">
            <div class="btn-group">
              <a href="{{ route('user.get_create_course') }}" class="btn sbold green"> Add New
                <i class="fa fa-plus"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="portlet-body">
        <table id="#tabTeachingCourse" class="table table-striped table-bordered table-hover order-column orderable">
          <thead>
          <tr>
            <th> <i class="fa fa-leanpub"></i> Course</th>
            <th> <i class="fa fa-calendar"></i> Created at</th>
            <th> <i class="fa fa-bookmark"></i> Price</th>
            <th> <i class="fa fa-users"></i> Students</th>
            <th> <i class="fa fa-money"></i> Total Revenue</th>
            <th> <i class="fa fa-star"></i> Status</th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          @foreach($teachingCourses as $teachingCourse)
            <tr>
              <td>{{ $teachingCourse->name }}</td>
              <td>{{ $teachingCourse->created_at->format('d/m/Y') }}</td>
              <td>{{ $teachingCourse->cost }}</td>
              <td>{{ $teachingCourse->buyers->count() }}</td>
              <td>{{ $teachingCourse->buyers->count() * $teachingCourse->cost }}</td>
              <td>
                @if($teachingCourse->status === \App\Course::STATUS_ACTIVE)
                  <span class="label label-sm label-success"> Active </span>
                @elseif($teachingCourse->status === \App\Course::STATUS_DEACTIVED)
                  <span class="label label-sm label-warning"> Deactived </span>
                @elseif($teachingCourse->status === \App\Course::STATUS_PENDING)
                  <span class="label label-sm label-info"> Pending </span>
                @elseif($teachingCourse->status === \App\Course::STATUS_REJECTED)
                  <span class="label label-sm label-danger"> Rejected </span>
                @endif
              </td>
              <td>
                <a href="{{ route('user.teaching_course_detail', ['id' => $teachingCourse->id]) }}"
                   class="btn blue-steel">
                  Detail
                </a>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>