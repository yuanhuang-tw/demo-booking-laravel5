@extends('interview.main')

@section('content')
  @include('interview.errors')

  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <form method="post" action="{{ url('/') }}/dj">
        <div class="form-group">
          <label for="datepicker">Date</label> <br>
          <input type="text" class="form-control" id="datepicker" name="date" value="{{ old('date')}}">
        </div>
        <div class="form-group">
          <label for="start_hour">Start Hour</label> <br>
          <input type="text" class="form-control" id="start_hour" name="start_hour" value="{{ old('start_hour')}}">
        </div>
        <div class="form-group">
          <label for="end_hour">End Hour</label> <br>
          <input type="text" class="form-control" id="end_hour" name="end_hour" value="{{ old('end_hour')}}">
        </div>
        <div class="form-group">
          <label for="msg">Messages</label>
          <textarea class="form-control" rows="6" id="msg" name="msg">{{ (old('msg')) }}</textarea>
        </div>

        <br>

        <button type="submit" class="btn btn-primary">Submit</button>
        {{ csrf_field() }}
      </form>

      <br><br>
    </div>
    <div class="col-md-2"></div>
  </div>
@endsection

@section('js')
  <script>
  $("#datepicker").datepicker({dateFormat: "yy-mm-dd"});
  </script>
@endsection
