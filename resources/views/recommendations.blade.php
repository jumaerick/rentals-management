<style>
.recommendation-ticker {
  overflow: hidden;
  white-space: nowrap;
  background: #f8f8f8;
  padding: 10px;
  border-radius: 8px;
  position: relative;
}

.recommendation-track {
  display: inline-block;
  animation: scroll-left 25s linear infinite;
}

.recommendation-ticker:hover .recommendation-track {
  animation-play-state: paused;
}

.course {
  display: inline-block;
  margin: 0 25px;
  padding: 10px 15px;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 0 5px rgba(0,0,0,0.1);
}

.course-title a {
  color: #e7c328;
  text-decoration: none;
}

@keyframes scroll-left {
  from {
    transform: translateX(0);
  }
  to {
    transform: translateX(-50%);
  }
}
</style>

<div class="container" style="text-align: center">
  <h2>Your Personalized Recommendations</h2>

  <div class="recommendation-ticker">
    <div class="recommendation-track">
      @foreach($recommendations as $rec)
        <div class="course">
          <h3 class="course-title"><a href="#">{{ $rec['course']->title }}</a></h3>
          <p>Reason: {{ $rec['reasons'] }}</p>
          <p>Match Score: {{ $rec['score'] }}</p>
        </div>
      @endforeach

      {{-- Duplicate only if there’s more than 1 item --}}
      @if(count($recommendations) > 3)
        @foreach($recommendations as $rec)
          <div class="course">
            <h3 class="course-title"><a href="#">{{ $rec['course']->title }}</a></h3>
            <p>Reason: {{ $rec['reasons'] }}</p>
            <p>Match Score: {{ $rec['score'] }}</p>
          </div>
        @endforeach
      @endif
    </div>
  </div>
</div>


<script>
    $('.course-title a').click(){
        alert('hello');
    }
</script>
