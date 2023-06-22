<ul class="booking-event">
  @if ($interview->status == 'Approved')
    <li>
      <a href="{{ url('/') }}/interview/{{ $interview->id }}" style="font-weight: bold; color: #EA2E49; text-decoration: underline;">{{ $interview->i_time }} // {{ $interview->i_client }} ({{ $interview->s_status }}) &lbrace;{{ $interview->name }}&rbrace;</a>
    </li>
  @else
    @if ($interview->status == 'Rejected')
      <li><a href="{{ url('/') }}/interview/{{ $interview->id }}"><b>{{ $interview->i_time }}</b> // {{ $interview->i_client }} ({{ $interview->s_status }}) <span style="font-weight: bold; color: #EA2E49; text-decoration: underline;">({{ $interview->status }})</span> &lbrace;{{ $interview->name }}&rbrace;</a></li>
    @else
      @if ($interview->department_status == 'Approved')
        <li><a href="{{ url('/') }}/interview/{{ $interview->id }}" style="color: #3cb371;"><b>{{ $interview->i_time }}</b> // {{ $interview->i_client }} ({{ $interview->s_status }}) &lbrace;{{ $interview->name }}&rbrace;</a></li>
      @else
        <li><a href="{{ url('/') }}/interview/{{ $interview->id }}"><b>{{ $interview->i_time }}</b> // {{ $interview->i_client }} ({{ $interview->s_status }}) &lbrace;{{ $interview->name }}&rbrace;</a></li>
      @endif
    @endif
  @endif
</ul>
