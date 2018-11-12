@extends('layouts.dashboard')

@section('style')
  <link rel="shortcut icon" href="favicon.ico"/>
  <link rel="stylesheet" href="{{ asset('css/pages/profile.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap-fileinput.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/datatables.min.css') }}"/>
  <link href="{{ asset('css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />

  <style>
    .sale-summary {
      padding: 0 15px;
    }

    @media screen and (min-width: 1500px) {
      .sale-summary li .sale-info {
        font-size: 12px;
      }
    }
  </style>
@endsection

@section('content')
  @php
  $hasPrevPage = false;
  $prevPage = '';

  if(session()->has('page')){
      $hasPrevPage = true;
      $prevPage = session()->get('page');
  } elseif (old('page')){
      $hasPrevPage = true;
      $prevPage = old('page');
  }
  @endphp
  <div class="container">
    <div class="profile">
      <div class="col-md-12">
        @if (session('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
        @endif
      </div>
      <div class="tabbable-line tabbable-full-width">
        <ul class="nav nav-tabs">
          @if ($hasPrevPage)
            <li>
              <a href="#tab_1_1" data-toggle="tab"> Overview </a>
            </li>
            <li class="active">
              <a href="#tab_1_3" data-toggle="tab"> Account </a>
            </li>
          @else
            <li class="active">
              <a href="#tab_1_1" data-toggle="tab"> Overview </a>
            </li>
            <li>
              <a href="#tab_1_3" data-toggle="tab"> Account </a>
            </li>
          @endif

        </ul>
        <div class="tab-content">
          @include('user.profile-partials.overview')
          @include('user.profile-partials.account')
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="{{ asset('js/bootstrap-fileinput.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/datatables.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/datatables.bootstrap.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
  <script>

      $(document).ready( function () {
          let cols = $('#tabTeachingCourse').find('th').length;

          $('table.orderable').DataTable({
              "lengthMenu": [
                  [6, 10, 20, -1],
                  [6, 10, 20, "All"] // change per page values here
              ],
              "pageLength": parseInt('{{ config('view.paginate') }}'),
              "columnDefs": [{  // set default column settings
                  'orderable': false,
                  'targets': [cols - 1]
              }, {
                  "searchable": false,
                  "targets": [cols - 1]
              }]
          });

          $('.datepicker').datepicker({
              format: 'yyyy-mm-dd',
          });
      });
  </script>
@endsection
