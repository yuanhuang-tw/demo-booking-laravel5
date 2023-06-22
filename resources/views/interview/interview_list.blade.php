<?php $warning_data = array(); ?>
@foreach ($interviews_greater_than_today as $igtt)
  <?php $warning_data[] = array($igtt->i_date, $igtt->i_time); ?>
@endforeach

@extends('interview.main')

@section('content')
  <?php if (Auth::user()->isMKTG(Auth::user()->id)): ?>
  <p><i class="fa fa-commenting-o" aria-hidden="true"></i> <a href="{{ url('/') }}/msg/list">訊息管理</a></p> <br>
  <?php endif; ?>

  <p align="center">Total: {{$interviews_count}} interviews</p>

  <br>

  <table class="table table-hover">
    <thead>
      <tr style="font-weight: bold;">
        <td width="7%">ID &nbsp; <i class="fa fa-caret-down" aria-hidden="true"></i></td>
        <td width="10%">Date</td>
        <td width="6%">Time</td>
        <td>Client</td>
        <td width="9%">Scheduling<br>Status</td>
        <td width="11%">Request Form<br>Status</td>
        <td width="13%">Department Head<br>Status</td>
        <td width="10%">Programming<br>Status</td>
        <td width="6%">Detail</td>
        <td width="5%">Edit</td>
      </tr>
    </thead>
    <tbody>
      @foreach ($interviews as $i)
        <tr>
          <td>{{ $i->id }}</td>
          <td>
            <?php $d = explode('-', $i->i_date); ?>
            <a href="{{ url('/') }}/{{ $d[0] }}/{{ $d[1] }}">{{ $i->i_date }}</a>
            <?php
            $c = count($warning_data);

            for ($k = 0; $k < $c; $k++) {
                if ($warning_data[$k][0] == $i->i_date && substr($warning_data[$k][1], 0, 2) == substr($i->i_time, 0, 2)) {
                    echo '<i class="fa fa-exclamation-circle" aria-hidden="true" style="color: #dc3545;"></i>';
                }
            }
            ?>
          </td>
          <td>{{ $i->i_time }}</td>
          <td>{{ $i->i_client }}</td>
          <td>{{ $i->s_status }}</td>
          <td>@if ($i->s_status == 'Confirmed' && $i->stage_1 == 'y') Sent @endif</td>
          <td>{{ $i->department_status }}</td>
          <td>
            {{ $i->status }} @if ($i->status == 'Approved') {!! '<span style="color: #BEDB39;"><i class="fa fa-check-circle" aria-hidden="true"></i></span>' !!} @elseif ($i->status == 'Rejected') {!! '<span style="color: #dc3545;"><i class="fa fa-minus-circle" aria-hidden="true"></i></span>' !!} @endif
          </td>
          <td><a href="{{ url('/') }}/interview/{{ $i->id }}">Detail</a></td>
          <td><a href="{{ url('/') }}/interview/{{ $i->id }}/edit">Edit</a></td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <br><br><br>

  {!! $interviews->links() !!}
@endsection
