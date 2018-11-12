<div class="col-sm-12 col-md-4 col-lg-3">
    <div class="irs-sb-courses">
        <h3 class="irs-sblc-title text-center">Courses</h3>
        <ul class="list-unstyled irs-sbc-list">
            @php
                $categories = \App\CourseCategory::all();
            @endphp
            <li class="active"><a href="{{route('all-course')}}"><span class="flaticon-arrows-3"></span> All Courses</a></li>
            @foreach($categories as $category)
            <li><a href="{{route('category', ['id' => $category->id])}}"><span class="flaticon-arrows-3"></span> {{$category->name}}</a></li>
            @endforeach
        </ul>
    </div>
    @php
        $recently_courses = \App\Course::where('status', \App\Course::STATUS_ACTIVE)->orderBy('updated_at', 'desc')->take(4)->get();
    @endphp
    <div class="irs-sb-lcourses">
        <h3 class="irs-sbc-title text-center">Latest Courses</h3>
        @foreach($recently_courses as $course)
        <div class="irs-sblc-pack">
            <div class="irs-lc-thumb">
                <a href="{{ route('course-info', ['id' => $course->id ]) }}">
                    <img class="img-responsive" style="max-height: 80px; max-width: 80px;" src="{{ Storage::url($course->avatar) }}" alt="s7.png">
                    <div class="irs-sblc-overlay"></div>
                </a>
            </div>
            <div class="irs-sblc-details">
                <a href="{{ route('course-info', ['id' => $course->id ]) }}">
                    <h5>{{$course->name}}</h5>
                </a>
                <p class="irs-sblc-price text-thm2">$ {{$course->cost}}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>