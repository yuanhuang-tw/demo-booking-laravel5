@extends('interview.main')

@section('content')
  @include('interview.errors')

  <form class="form-inline" method="post" action="{{ url('/') }}/search">
    <div class="form-group">
      <input type="text" class="form-control" id="datepicker" name="date1" value="{{ old('date1')}}" placeholder="Start Date">
    </div>

    ~

    <div class="form-group">
      <input type="text" class="form-control" id="datepicker-2" name="date2" value="{{ old('date2')}}" placeholder="End Date">
    </div>
    <button class="btn btn-primary" type="submit" style="margin-left: 5px;">Search</button>
    {{ csrf_field() }}
  </form>

  <br>

  @if (isset($interviews))
    <table class="table table-hover table-bordered">
      <thead>
        <tr style="font-weight: bold;">
          <td width="14%">Interview Date &nbsp; <i class="fa fa-caret-up" aria-hidden="true"></i></td>
          <td width="14%">Interview Time</td>
          <td width="13%">Applicant</td>
          <td>Client</td>
          <td width="15%">Scheduling Status</td>
          <td width="11%">Status</td>
        </tr>
      </thead>
      <tbody>
        @foreach ($interviews as $i)
          <tr>
            <td>{{ $i->i_date }}</td>
            <td>{{ $i->i_time }}</td>
            <td>{{ $i->belongsToUser->name }}</td>
            <td>{{ $i->i_client }}</td>
            <td>{{ $i->s_status }}</td>
            <td>{{ $i->status }} @if ($i->status == 'Approved') {!! '<span style="color: #BEDB39;"><i class="fa fa-check-circle" aria-hidden="true"></i></span>' !!} @endif</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif

  <br><br><br>
@endsection

@section('js')
  <script>
  $("#datepicker, #datepicker-2").datepicker({dateFormat: "yy-mm-dd"});
  </script>
@endsection
