@extends('layouts.main')

@section('style')
  <style>
    .margin-top-40 {
      margin-top: 40px;
    }
  </style>
@endsection

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-ms-12 text-center">
        <h1>Top teaching score</h1>
      </div>
    </div>
    <div class="row margin-top-40">
      <div class="col-md-8 col-md-offset-2 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr style="background: #F7CA18; color: white;">
            <th>#</th>
            <th>Name</th>
            <th>Learing score</th>
          </tr>
          </thead>
          <tbody>
          @foreach($topUsers as $index => $topUser)
            <tr @if($index === 0) style="color: #F7CA18;" @endif>
              <td>{{ $index + 1 }}</td>
              <td>{{ $topUser->name }}</td>
              <td>{{ $topUser->teaching_score }}</td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection