@php
function generateGoogleCalendarLink($title, $startDateTime, $description = '', $durationMinutes = 60) {
    $start = \Carbon\Carbon::parse($startDateTime)->utc();
    $end = $start->copy()->addMinutes($durationMinutes);

    $startFormatted = $start->format('Ymd\THis\Z');
    $endFormatted = $end->format('Ymd\THis\Z');

    $params = [
        'action' => 'TEMPLATE',
        'text' => $title,
        'dates' => $startFormatted . '/' . $endFormatted,
        'details' => $description,
        'trp' => 'false',
    ];

    return 'https://calendar.google.com/calendar/render?' . http_build_query($params);
}
@endphp

<h1>Course Due Dates</h1>

@foreach($dueDates as $due)
    <div style="margin-bottom: 20px;">
        <h3>{{ $due->title }}</h3>
        <p>Due: {{ $due->due_date->format('M d, Y H:i') }}</p>
        
        <a href="{{ generateGoogleCalendarLink($due->title, $due->due_date, $due->description) }}" target="_blank" style="background-color:#4285F4; color:white; padding:8px 12px; text-decoration:none; border-radius:4px;">
            Add to Google Calendar
        </a>

        <a href="{{ route('events.download-ics', ['id' => $due->id]) }}" style="background-color:#0078D4; color:white; padding:8px 12px; border-radius:4px; text-decoration:none; margin-left:10px;">
            Download for Outlook
        </a>
    </div>
@endforeach
