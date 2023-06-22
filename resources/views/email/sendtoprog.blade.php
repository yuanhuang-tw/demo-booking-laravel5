<p><b>Client</b>: {{ $i->i_client }} (ID: {{ $i->id }})</p>
<p><b>Date</b>: {{ $i->i_date }}</p>
<p><b>Time</b>: {{ $i->i_time }}</p>
<p><b>Applicant</b>: {{ $i->belongsToUser->name }}</p>
