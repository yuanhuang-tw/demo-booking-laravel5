@extends('interview.main')

@section('content')
  <p><i class="fa fa-commenting-o" aria-hidden="true"></i> <a href="{{ url('/') }}/msg">新增訊息</a></p>

  <table class="table table-hover table-bordered">
    <thead>
      <tr style="font-weight: bold;">
        <td width="8%">ID &nbsp; <i class="fa fa-caret-down" aria-hidden="true"></i></td>
        <td width="13%">Start Date</td>
        <td width="13%">End Date</td>
        <td>Messages</td>
        <td width="8%">Edit</td>
        <td width="8%">Delete</td>
      </tr>
    </thead>
    <tbody>
      @foreach ($msg as $m)
        <tr @if (date('Y-m-d') > $m->end_date) style="color: #AAAAAA;" @endif>
          <td>{{ $m->id }}</td>
          <td>{{ $m->start_date }}</td>
          <td>{{ $m->end_date }}</td>
          <td>{{ $m->msg }}</td>
          <td>
            <a href="{{ url('/') }}/msg/{{ $m->id }}/edit">Edit</a>
          </td>
          <td>
            <a href="{{ url('/') }}/msg/{{ $m->id }}/delete" class="del"><button class="btn btn-danger" id="del-btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button></a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <br><br><br>

  {!! $msg->links() !!}
@endsection

@section('js')
  <script>
  $('.del').on('click', function() {
      // return confirm('Are you sure to "DELETE" this message??\n確定要刪除嗎？');
      return confirm('Do you really want to "DELETE" this message? \n\n 要"刪除"此訊息嗎？ \n');
  });
  </script>
@endsection
