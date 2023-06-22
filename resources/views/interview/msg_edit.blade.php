@extends('interview.main')

@section('content')
  @include('interview.errors')

  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <form method="post" action="{{ url('/') }}/msg/{{ $msg->id }}">
        <div class="form-group">
          <label for="datepicker">Start Date</label> <br>
          <input type="text" class="form-control" id="datepicker" name="date1" value="{{ ! is_null(old('date1')) ? old('date1') : $msg->start_date }}">
        </div>
        <div class="form-group">
          <label for="datepicker-2">End Date</label> <br>
          <input type="text" class="form-control" id="datepicker-2" name="date2" value="{{ ! is_null(old('date2')) ? old('date2') : $msg->end_date }}">
        </div>
        <div class="form-group">
          <label for="msg">Messages</label>
          <textarea class="form-control" rows="6" id="msg" name="msg">{{ ! is_null(old('msg')) ? old('msg') : $msg->msg }}</textarea>
        </div>
        <div class="form-group">
          <label>Department</label>

          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

          <label><input type="radio" name="department" value="p" @if (old('department') == 'p' || $msg->department == 'p') {{ 'checked' }} @endif> Programming</label>

          &nbsp;&nbsp;&nbsp;&nbsp;

          <label><input type="radio" name="department" value="m" @if (old('department') == 'm' || $msg->department == 'm') {{ 'checked' }} @endif> Marketing</label>
        </div>

        <br>

        <button type="submit" class="btn btn-primary">Submit</button>
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
      </form>

      <br><br>
    </div>
    <div class="col-md-2"></div>
  </div>
@endsection

@section('js')
  <script>
  $("#datepicker, #datepicker-2").datepicker({dateFormat: "yy-mm-dd"});
  </script>
@endsection
