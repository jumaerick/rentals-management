<h2>Your Personalized Recommendations</h2>

@foreach($recommendations as $rec)
    <div class="course">
        <h3>{{ $rec['course']->title }}</h3>
        <p>Reason: {{ $rec['reasons'] }}</p>
        <p>Match Score: {{ $rec['score'] }}</p>
    </div>
@endforeach