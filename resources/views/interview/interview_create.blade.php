@extends('interview.main')

@section('content')
  @include('interview.errors')

  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      @if ($booking_num_in_this_week >= 5)
      <div class="alert alert-danger">
        <b>[Notice]</b> 本週 booking 數量已達五個！請通知節目部。
      </div>
      @endif
      <form method="post" action="{{ url('/') }}/create">
        <div class="form-group">
          <label for="contact">ICRT Sales / Contact</label> <br>
          <input type="text" class="form-control" id="contact" name="contact" value="{{ (old('contact')) }}">
        </div>

        <br><br>

        <div class="form-group">
          <label for="datepicker">Interview Date</label> <br>
          @if ((is_null($ymd) || ! is_null($ymd)) && ! is_null(old('date')))
            <input type="text" class="form-control" id="datepicker" name="date" value="{{ old('date')}}">
          @elseif ( ! is_null($ymd) && is_null(old('date')))
            <input type="text" class="form-control" id="datepicker" name="date" value="{{ substr($ymd, 0, 4).'-'.substr($ymd, 4, 2).'-'.substr($ymd, 6, 2) }}">
          @else
            <input type="text" class="form-control" id="datepicker" name="date" value="">
          @endif
        </div>
        <div class="form-group">
          <label for="time">Interview Time (24 Hour)</label>
          <input type="text" class="form-control" id="time" name="time" value="{{ (old('time')) }}" placeholder="8:10 or 19:20">
        </div>
        <div class="form-group">
          <label for="client">Client</label> <br>
          <input type="text" class="form-control" id="client" name="client" value="{{ (old('client')) }}">
        </div>

        <div class="form-group">
          <label>Scheduling Status</label>

          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

          <label><input type="radio" name="s_status" value="Pending" @if (old('s_status') == 'Pending') {{ 'checked' }} @endif checked> Pending</label>

          &nbsp;&nbsp;&nbsp;&nbsp;

          <label><input type="radio" name="s_status" value="Confirmed" @if (old('s_status') == 'Confirmed') {{ 'checked' }} @endif> Confirmed</label>
        </div>
        <div class="form-group">
          <label>Interview Type</label>

          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

          <label><input type="radio" name="i_type" value="Phoner" @if (old('i_type') == 'Phoner') {{ 'checked' }} @endif> Phoner</label>

          &nbsp;&nbsp;&nbsp;&nbsp;

          <label><input type="radio" name="i_type" value="Studio" @if (old('i_type') == 'Studio') {{ 'checked' }} @endif checked> Studio</label>

          &nbsp;&nbsp;&nbsp;&nbsp;

          <label><input type="radio" name="i_type" value="Pre Record" @if (old('i_type') == 'Pre Record') {{ 'checked' }} @endif> Pre Record</label>
        </div>
        <div class="form-group">
          <label>Language</label>

          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

          <label><input type="radio" name="language" value="English" @if (old('language') == 'English') {{ 'checked' }} @endif checked> English</label>

          &nbsp;&nbsp;&nbsp;&nbsp;

          <label><input type="radio" name="language" value="Bilingual" @if (old('language') == 'Bilingual') {{ 'checked' }} @endif> Bilingual</label>
        </div>
        <div class="form-group">
          <label for="tp">Talking Points</label>
          <textarea class="form-control" rows="6" id="tp" name="tp">@if( ! is_null(old('tp'))){{ (old('tp')) }}@else{{'N/A'}}@endif</textarea>
        </div>
        <div class="form-group">
          <label for="interviewee">Interviewee / Bio</label>
          <textarea class="form-control" rows="6" id="interviewee" name="interviewee">@if( ! is_null(old('interviewee'))){{ (old('interviewee')) }}@else{{'N/A'}}@endif</textarea>
        </div>

        <br><br>

        <div class="form-group">
          <label for="additional">Additional Background Info (Optional)</label>
          <textarea class="form-control" rows="6" id="additional" name="additional">{{ (old('additional')) }}</textarea>
        </div>
        <div class="form-group">
          <label for="pr">Programming Request (Optional)</label>
          <textarea class="form-control" rows="6" id="pr" name="pr">{{ (old('pr')) }}</textarea>
        </div>

        <br>

        <button type="submit" class="btn btn-primary">Booking</button>
        {{ csrf_field() }}
      </form>

      <br><br>
    </div>
    <div class="col-md-2"></div>
  </div>

  @if (count($client_list) > 0)
  <div class="client-list">
    Your Clients List:
    <ul>
    @foreach ($client_list as $c)
      {{-- <span style="display: inline-block;">{<a href="javascript:;" onclick="copy_client('{{ $c->i_client }}');">{{ $c->i_client }}</a>}</span> &nbsp; --}}
      <li>
        <a href="javascript:;" onclick="copy_client('{{ $c->i_client }}');">{{ $c->i_client }}</a>
      </li>
    @endforeach
    </ul>
  </div>
  @endif
@endsection

@section('js')
  <script>
  $("#datepicker").datepicker({dateFormat: "yy-mm-dd"});

  function copy_client(client_name) {
    document.getElementById('client').value = client_name;
  }

  $('#client').focus(function () {
    $('.client-list').css('right', '0');
  });

  $('#client').blur(function () {
    $('.client-list').css('right', '-220px');
  });
  // </script>
@endsection
