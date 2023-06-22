@extends('interview.main')

@section('content')
  @include('interview.errors')

  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      <form method="post" action="/interview/{{ $interview->id }}">
        <div class="form-group">
          <label for="contact">ICRT Sales / Contact</label> <br>
          <input type="text" class="form-control" id="contact" name="contact" value="{{ ! is_null(old('contact')) ? old('contact') : $interview->contact }}">
        </div>
        <div class="form-group">
          <label for="datepicker">Interview Date</label> <br>
          <input type="text" class="form-control" id="datepicker" name="date" value="{{ ! is_null(old('date')) ? old('date') : $interview->i_date }}">
        </div>
        <div class="form-group">
          <label for="time">Interview Time (24 Hour)</label>
          <input type="text" class="form-control" id="time" name="time" value="{{ ! is_null(old('time')) ? old('time') : $interview->i_time }}" placeholder="8:10 or 19:20">
        </div>
        <div class="form-group">
          <label for="client">Client</label> <br>
          <input type="text" class="form-control" id="client" name="client" value="{{ ! is_null(old('client')) ? old('client') : $interview->i_client }}">
        </div>
        <div class="form-group">
          <label>Scheduling Status</label>

          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

          <label><input type="radio" name="s_status" value="Pending" @if (old('s_status') == 'Pending' || $interview->s_status == 'Pending') {{ 'checked' }} @endif> Pending</label>

          &nbsp;&nbsp;&nbsp;&nbsp;

          <label><input type="radio" name="s_status" value="Confirmed" @if (old('s_status') == 'Confirmed' || $interview->s_status == 'Confirmed') {{ 'checked' }} @endif> Confirmed</label>
        </div>
        <div class="form-group">
          <label>Interview Type</label>

          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

          <label><input type="radio" name="i_type" value="Phoner" @if (old('i_type') == 'Phoner' || $interview->i_type == 'Phoner') {{ 'checked' }} @endif> Phoner</label>

          &nbsp;&nbsp;&nbsp;&nbsp;

          <label><input type="radio" name="i_type" value="Studio" @if (old('i_type') == 'Studio' || $interview->i_type == 'Studio') {{ 'checked' }} @endif> Studio</label>

          &nbsp;&nbsp;&nbsp;&nbsp;

          <label><input type="radio" name="i_type" value="Pre Record" @if (old('i_type') == 'Pre Record' || $interview->i_type == 'Pre Record') {{ 'checked' }} @endif> Pre Record</label>
        </div>
        <div class="form-group">
          <label>Language</label>

          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

          <label><input type="radio" name="language" value="English" @if (old('language') == 'English' || $interview->language == 'English') {{ 'checked' }} @endif> English</label>

          &nbsp;&nbsp;&nbsp;&nbsp;

          <label><input type="radio" name="language" value="Bilingual" @if (old('language') == 'Bilingual' || $interview->language == 'Bilingual') {{ 'checked' }} @endif> Bilingual</label>
        </div>
        <div class="form-group">
          <label for="tp">Talking Points</label>
          <textarea class="form-control" rows="16" id="tp" name="tp">{{ ! is_null(old('tp')) ? old('tp') : $interview->tp }}</textarea>
        </div>
        <div class="form-group">
          <label for="interviewee">Interviewee / Bio</label>
          <textarea class="form-control" rows="6" id="interviewee" name="interviewee">{{ ! is_null(old('interviewee')) ? old('interviewee') : $interview->interviewee }}</textarea>
        </div>
        <div class="form-group">
          <label for="additional">Additional Background Info (Optional)</label>
          <textarea class="form-control" rows="6" id="additional" name="additional">{{ ! is_null(old('additional')) ? old('additional') : $interview->additional }}</textarea>
        </div>
        <div class="form-group">
          <label for="pr">Programming Request (Optional)</label>
          <textarea class="form-control" rows="6" id="pr" name="pr">{{ ! is_null(old('pr')) ? old('pr') : $interview->pr }}</textarea>
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
  $("#datepicker").datepicker({dateFormat: "yy-mm-dd"});
  </script>
@endsection
