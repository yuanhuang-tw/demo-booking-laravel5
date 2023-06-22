@extends('interview.main')

@section('content')
  <table class="table table-hover">
    <thead>
      <tr style="font-weight: bold;">
        <td width="7%">ID &nbsp; <i class="fa fa-caret-down" aria-hidden="true"></i></td>
        <td width="9%">Date</td>
        <td width="6%">Time</td>
        <td width="13%">Applicant</td>
        <td>Client</td>
        <td width="9%">Scheduling<br>Status</td>
        <td width="11%">Request Form<br>Status</td>
        <td width="13%">Department Head<br>Status</td>
        <td width="6%">Detail</td>
        {{-- <td width="5%">Edit</td> --}}
      </tr>
    </thead>
    <tbody>
      @foreach ($interviews as $i)
        <tr>
          <td>{{ $i->id }}</td>
          <td>
            <?php $d = explode('-', $i->i_date); ?>
            <a href="{{ url('/') }}/{{ $d[0] }}/{{ $d[1] }}">{{ $i->i_date }}</a>
          </td>
          <td>{{ $i->i_time }}</td>
          <td>{{ $i->belongsToUser->name }}</td>
          <td>{{ $i->i_client }}</td>
          <td>{{ $i->s_status }}</td>
          <td>@if ($i->s_status == 'Confirmed' && $i->stage_1 == 'y') Sent @endif</td>
          <td>{{ $i->department_status }}</td>
          <td><a href="{{ url('/') }}/interview/{{ $i->id }}">Detail</a></td>
          {{-- <td><a href="{{ url('/') }}/interview/{{ $i->id }}/edit">Edit</a></td> --}}
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
