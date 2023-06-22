@extends('interview.main')

@section('css')
  <style>
  @media print {
    body { width: 100%; }
    .talking-points { font-size: 120%; }
  }
  </style>
@endsection

@section('content')
  @include('interview.errors')

  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
      @if ($interview->s_status == 'Confirmed' && $interview->stage_1 != 'y' && $interview->status != 'Approved')
        @can('send_to_department_head', $interview)
        	@if ($department == 'sales')
        		<a href="/send-to-department-head/{{ $interview->id }}"><button class="btn btn-primary" id="send-to-department-head">[Sales] Send Request Form to Department Head</button></a>
        	@endif

        	@if ($department == 'mktg')
        		<a href="/send-to-department-head/{{ $interview->id }}"><button class="btn btn-primary" id="send-to-department-head">[MKTG] Send Request Form to Department Head</button></a>
        	@endif

        	@if ($department == 'prog' || $department == 'admin')
        		<a href="/send-to-department-head/{{ $interview->id }}"><button class="btn btn-primary" id="send-to-department-head">[Prog] Send Request Form to Department Head</button></a>
        	@endif
        @endcan
      @endif


      @if ($interview->s_status == 'Confirmed' && $interview->stage_1 == 'y' && $interview->department_status != 'Approved' && $interview->status != 'Approved')
        @can('department_head_control', $interview)
          <a href="/department-head-approve/{{ $interview->id }}"><button class="btn btn-primary" id="approve">[Department Head] Approve Request Form and Send to Programming</button></a>
        @endcan
      @endif

      @if ($interview->s_status == 'Confirmed' && $interview->stage_1 == 'y' && $interview->department_status != 'Rejected' && $interview->status != 'Approved')
        @can('department_head_control', $interview)
          <a href="/department-head-reject/{{ $interview->id }}"><button class="btn btn-danger" id="reject" style="float: right;">[Department Head] Reject Request Form</button></a>
        @endcan
      @endif

      <br><br>

      <table class="table table-bordered">
        <tr>
          <td width="35%"><b>ID</b></td>
          <td>{{ $interview->id }}</td>
        </tr>
        <tr>
          <td><b>Applicant</b></td>
          <td>{{ $interview->belongsToUser->name }}</td>
        </tr>
        <tr>
          <td><b>ICRT Sales / Contact</b></td>
          <td>{{ $interview->contact }}</td>
        </tr>
        <tr>
          <td><b>Interview Date</b></td>
          <td>
            <?php $d = explode('-', $interview->i_date); ?>
            <a href="{{ url('/') }}/{{ $d[0] }}/{{ $d[1] }}">{{ $interview->i_date }}</a>
          </td>
        </tr>
        <tr>
          <td><b>Interview Time</b></td>
          <td>{{ $interview->i_time }}</td>
        </tr>
        <tr>
          <td><b>Client</b></td>
          <td>{{ $interview->i_client }}</td>
        </tr>
        <tr>
          <td><b>Scheduling Status</b></td>
          <td>{{ $interview->s_status }}</td>
        </tr>
        <tr>
          <td><b>Interview Type</b></td>
          <td>{{ $interview->i_type }}</td>
        </tr>
        <tr>
          <td><b>Language</b></td>
          <td>{{ $interview->language }}</td>
        </tr>
        <tr>
          <td><b>Talking Points</b></td>
          <td class="talking-points">{!! nl2br(e($interview->tp)) !!}</td>
        </tr>
        <tr>
          <td><b>Interviewee / Bio</b></td>
          <td>{!! nl2br(e($interview->interviewee)) !!}</td>
        </tr>
        <tr>
          <td><b>Additional Background Info</b></td>
          <td>{!! nl2br(e($interview->additional)) !!}</td>
        </tr>
        <tr>
          <td><b>Programming Request</b></td>
          <td>{!! nl2br(e($interview->pr)) !!}</td>
        </tr>
        <tr>
          <td><b>Created at</b></td>
          <td>{{ $interview->created_at }}</td>
        </tr>
        <tr>
          <td><b>Updated at</b></td>
          <td>{{ $interview->updated_at }}</td>
        </tr>
        <tr>
          <td><b>Request Form Status</b></td>
          <td>@if ($interview->s_status == 'Confirmed' && $interview->stage_1 == 'y') Sent @endif</td>
        </tr>
        <tr>
          <td><b>Department Head Status</b></td>
          <td>{{ $interview->department_status }}</td>
        </tr>
        <tr>
          <td><b>Programming Status</b></td>
          <td>
            {{ $interview->status }} @if ($interview->status == 'Approved') {!! '<span style="color: #BEDB39;"><i class="fa fa-check-circle" aria-hidden="true"></i></span>' !!} @elseif ($interview->status == 'Rejected') {!! '<span style="color: #dc3545;"><i class="fa fa-minus-circle" aria-hidden="true"></i></span>' !!} @endif
          </td>
        </tr>
        <tr>
          <td><b>Attachment</b></td>
          <td>
            @if ($interview->status != 'Approved')
              @can('upload', $interview)
                <form method="post" enctype="multipart/form-data" action="{{ url()->current() }}/upload">
                  <input type="file" name="file">
                  <input type="hidden" name="i_id" value="{{ $interview->id }}">
                  <button class="btn btn-primary" type="submit" style="margin-top: 8px;">Upload</button>
                  {{ csrf_field() }}
                </form>

                @if ($interview->file == 'y')
                  <br><br>
                @endif
              @endcan
            @elseif ($interview->status == 'Approved' && $department == 'admin')
              <form method="post" enctype="multipart/form-data" action="{{ url()->current() }}/upload">
                <input type="file" name="file">
                <input type="hidden" name="i_id" value="{{ $interview->id }}">
                <button class="btn btn-primary" type="submit" style="margin-top: 8px;">Upload</button>
                {{ csrf_field() }}
              </form>

              @if ($interview->file == 'y')
                <br><br>
              @endif
            @endif

            @if ($interview->file == 'y')
              <a href="/download/{{ $interview->file_name }}">{{ $interview->file_name }}</a> <span style="font-size: 90%;">({{ $interview->file_size }} / {{ $interview->file_datetime }})</span>
            @endif
          </td>
        </tr>
      </table>

      <br>

      @if ($interview->status != 'Approved')
        @can('edit', $interview)
          <a href="/interview/{{ $interview->id }}/edit"><button class="btn btn-primary">Edit</button></a>
        @endcan

        @can('destroy', $interview)
          <a href="/interview/{{ $interview->id }}/delete"><button class="btn btn-danger" id="del-btn" style="float: right;"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button></a>
        @endcan
      @endif

      @if ($interview->status == 'Approved' && $department == 'admin')
        @can('edit', $interview)
          <a href="/interview/{{ $interview->id }}/edit"><button class="btn btn-primary">Edit</button></a>
        @endcan

        @can('destroy', $interview)
          <a href="/interview/{{ $interview->id }}/delete"><button class="btn btn-danger" id="del-btn" style="float: right;"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button></a>
        @endcan
      @endif

      <br><br>
    </div>
    <div class="col-md-2"></div>
  </div>
@endsection

@section('js')
  <script>
  $('#del-btn').click(function() {
      if (confirm('Do you really want to "DELETE" this interview? \n\n 要 "刪除" 此訪問嗎？ \n') == false) {
          return false;
      }
  });

  $('#send-to-department-head').click(function() {
      if (confirm('Do you want to send Request Form to Department Head? \n\n 要 "傳送" 申請嗎？ \n') == false) {
          return false;
      }
  });

  $('#approve').click(function() {
      if (confirm('[Department Head] Are you sure to "Approve" Request Form? \n\n 要 "允許" 申請嗎？ \n') == false) {
          return false;
      }
  });

  $('#reject').click(function() {
      if (confirm('[Department Head] Are you sure to "Reject" Request Form? \n\n 要 "拒絕" 申請嗎？ \n') == false) {
          return false;
      }
  });
  </script>
@endsection
