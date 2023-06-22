@extends('interview.main')

@section('content')
  <div class="month-year">
    <span style="font-size: 160%;">{{ $m_full_text }}</span> / {{ $y }}
  </div>

  <div style="float: left;">
    <a href="{{ $last_month_btn }}" style="font-size: 0; float: left; padding-right: 4px;">
      <button class="btn btn-primary">
        <i class="fa fa-angle-double-left" aria-hidden="true"></i>
        Last Month
      </button>
    </a>
    <a href="{{ $next_month_btn }}">
      <button class="btn btn-primary">
        Next Month <i class="fa fa-angle-double-right" aria-hidden="true"></i>
      </button>
    </a>
  </div>

  <form class="form-inline">
    <div class="form-group">
      <select name="month" id="month" class="form-control">
    		<option value=""></option>
    		<option value="01">January</option>
    		<option value="02">February</option>
    		<option value="03">March</option>
    		<option value="04">April</option>
    		<option value="05">May</option>
    		<option value="06">June</option>
    		<option value="07">July</option>
    		<option value="08">August</option>
    		<option value="09">September</option>
    		<option value="10">October</option>
    		<option value="11">November</option>
    		<option value="12">December</option>
    	</select>
    </div>
    <div class="form-group">
      <select name="year" id="year" class="form-control">
    		<option value=""></option>
        @for ($i = date("Y") - 3; $i < date("Y") + 4; $i++)
          <option value="{{$i}}">{{$i}}</option>
        @endfor
    	</select>
    </div>
  </form>

  <div class="week">
    <div class="week-2">Sun</div>
    <div class="week-2">Mon</div>
    <div class="week-2">Tue</div>
    <div class="week-2">Wed</div>
    <div class="week-2">Thu</div>
    <div class="week-2">Fri</div>
    <div class="week-2">Sat</div>
  </div>
  <div class="day">
    @for ($i = 0; $i < 42; $i++)
      <?php
      $current_day = date("Y-m-d", strtotime("+$i days", strtotime($d_day)));
      $current_day_y = substr($current_day, 0, 4);
      $current_day_m = substr($current_day, 5, 2);
      $current_day_d = substr($current_day, 8, 2);

      $w = date_create($current_day);
      $wd = date_format($w, 'D');
      ?>
      <div class="day-2 <?php echo ($m != $current_day_m) ? 'day-null' : ''; ?>">
        <div class="show-day">
          @if ($current_day > date("Y-m-d"))
            <a href="{{ url('/') }}/create/{{ $current_day_y . $current_day_m . $current_day_d }}">
              <span class="show-day-2">
                {{ $current_day_m }} / {{ $current_day_d }} <span class="wd">({{ $wd }})</span>
              </span>
            </a>
          @elseif ($current_day == date("Y-m-d"))
            <span class="show-day-2-today">
              {{ $current_day_m }} / {{ $current_day_d }} <span class="wd">({{ $wd }})</span>
            </span>
          @else
            <span class="show-day-2">
              {{ $current_day_m }} / {{ $current_day_d }} <span class="wd">({{ $wd }})</span>
            </span>
          @endif
        </div>

        @if (array_key_exists($current_day, $all_interviews))
          @if (date("w", mktime(0, 0, 0, $current_day_m, $current_day_d, $current_day_y)) != 0 && date("w", mktime(0, 0, 0, $current_day_m, $current_day_d, $current_day_y)) != 6)
            @foreach ($all_interviews[$current_day] as $interview)
              <?php $h = explode(':', trim($interview->i_time)); ?>
              @if ($h[0] < 8)
                @include('interview.show_data_in_div')
              @endif
            @endforeach

            <!-- Section-1 -->
            <div class="section-1">
              <span class="dj dj-1">
                [Stevie G]
                @if ($current_day == date("Y-m-d") && date('G') >= 8 && date('G') < 12)
                <i class="fa fa-volume-up" aria-hidden="true"></i>
                @endif
              </span>
              @foreach ($all_interviews[$current_day] as $interview)
                <?php $h = explode(':', trim($interview->i_time)); ?>
                @if ($h[0] >= 8 && $h[0] < 12)
                  @include('interview.show_data_in_div')
                @endif
              @endforeach
            </div>

            <!-- Section-2 -->
            <div class="section-2">
              <span class="dj dj-2">
                [Caitlin Magee]
                @if ($current_day == date("Y-m-d") && date('G') >= 13 && date('G') < 16)
                <i class="fa fa-volume-up" aria-hidden="true"></i>
                @endif
              </span>
              @foreach ($all_interviews[$current_day] as $interview)
                <?php $h = explode(':', trim($interview->i_time)); ?>
                @if ($h[0] >= 13 && $h[0] < 16)
                  @include('interview.show_data_in_div')
                @endif
              @endforeach
            </div>
            <div class="section-2">
              <span class="dj dj-3">
                [Joey Chou]
                @if ($current_day == date("Y-m-d") && date('G') >= 16 && date('G') < 17)
                <i class="fa fa-volume-up" aria-hidden="true"></i>
                @endif
              </span>
              @foreach ($all_interviews[$current_day] as $interview)
                <?php $h = explode(':', trim($interview->i_time)); ?>
                @if ($h[0] >= 16 && $h[0] < 17)
                  @include('interview.show_data_in_div')
                @endif
              @endforeach
            </div>

            <!-- Section-3 -->
            <div class="section-3">
              <span class="dj dj-4">
                [Joseph Lin]
                @if ($current_day == date("Y-m-d") && date('G') >= 17)
                <i class="fa fa-volume-up" aria-hidden="true"></i>
                @endif
              </span>
              @foreach ($all_interviews[$current_day] as $interview)
                <?php $h = explode(':', trim($interview->i_time)); ?>
                @if ($h[0] >= 17)
                  @include('interview.show_data_in_div')
                @endif
              @endforeach
            </div>
          @else
            @foreach ($all_interviews[$current_day] as $interview)
              @include('interview.show_data_in_div')
            @endforeach
          @endif
        @endif
      </div>
    @endfor
  </div>

  <div style="width: 100%; text-align: right; padding: 30px 0px; font-size: 3rem;">
    <a href="javascript:;" id="go-top" style="color: #000000;"><i class="fa fa-arrow-up fa-3x" aria-hidden="true"></i></a>
  </div>
@endsection

@section('js')
  <script>
  const dj1 = document.querySelectorAll('.dj-1');
  const dj2 = document.querySelectorAll('.dj-2');
  const dj3 = document.querySelectorAll('.dj-3');
  const dj4 = document.querySelectorAll('.dj-4');
  const allDj = [dj1, dj2, dj3, dj4];

  allDj.forEach((djs) => {
    djs.forEach((dj) => {
      dj.addEventListener('mouseover', () => {
        djs.forEach((djName) => {
          const allUl = djName.parentElement.querySelectorAll('ul');

          if (allUl.length > 0) {
            allUl.forEach((ul) => {
              for (let li of ul.children) {
                li.classList.add('active');
              }
            });
          }
        });
      });

      dj.addEventListener('mouseout', () => {
        djs.forEach((djName) => {
          const allUl = djName.parentElement.querySelectorAll('ul');

          if (allUl.length > 0) {
            allUl.forEach((ul) => {
              for (let li of ul.children) {
                li.classList.remove('active');
              }
            });
          }
        });
      });
    });
  });

  $("#year").children().each(function() {
      if ($(this).text() == '{{ $y }}') {
          $(this).attr("selected", true);

          $("#year option[value='']").remove();
      }
  });

  $("#month").children().each(function() {
      if ($(this).val() == '{{ $m }}') {
          $(this).attr("selected", true);

          $("#month option[value='']").remove();
      }
  });

  // $('#go-btn').click(function() {
  //     location.href = '{{ url('/') }}/' + $('#year').val()  + '/' + $('#month').val();
  // });

  $("#year, #month").change(function() {
      location.href = '{{ url('/') }}/' + $('#year').val()  + '/' + $('#month').val();
  });

  $("#go-top").click(function() {
      $('html, body').animate({scrollTop: 0}, 800);
  })
  </script>
@endsection
