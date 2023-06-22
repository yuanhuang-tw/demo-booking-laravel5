<p><b>Date</b><br>{{ $data->i_date }}</p>
<p><b>Time</b><br>{{ $data->i_time }}</p>
<p><b>Client</b><br>{{ $data->i_client }}</p>
<p><b>Detail</b><br><a href="{{ url('/') }}/interview/{{ $data->id }}">{{ url('/') }}/interview/{{ $data->id }}</a></p>
