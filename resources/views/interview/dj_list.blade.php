@extends('interview.main')

@section('content')
  <p><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <a href="{{ url('/') }}/dj">新增</a></p>

  <table class="table table-hover table-bordered">
    <thead>
      <tr style="font-weight: bold;">
        <td width="8%">ID &nbsp; <i class="fa fa-caret-down" aria-hidden="true"></i></td>
        <td width="13%">Date</td>
        <td width="10%">Start Hour</td>
        <td width="10%">End Hour</td>
        <td>Messages</td>
        <td width="8%">Delete</td>
      </tr>
    </thead>
    <tbody>
      @foreach ($msg as $m)
        <tr @if (date('Y-m-d') > $m->date) style="color: #AAAAAA;" @endif>
          <td>{{ $m->id }}</td>
          <td>{{ $m->date }}</td>
          <td>{{ $m->start_hour }}</td>
          <td>{{ $m->end_hour }}</td>
          <td>{{ $m->msg }}</td>
          <td><a href="{{ url('/') }}/dj/{{ $m->id }}/delete" class="del"><button class="btn btn-danger" id="del-btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button></a></td>
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
      return confirm('Do you really want to "DELETE" this message? \n\n 要"刪除"此訊問嗎？ \n');
      // if (confirm('Do you really want to "DELETE" this interview? \n\n 要"刪除"此訪問嗎？ \n') == false) {
      //     return false;
      // }
  });
  </script>
@endsection
