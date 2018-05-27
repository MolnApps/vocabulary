<h2>Stats</h2>
{{ request()->session()->get('correctAnswers') }} / {{ request()->session()->get('totalAnswers') }}
<h2>Solution</h2>
@if ($result)
	Correct
@else 
	Wrong
	The correct answer was {{ $correctAnswer }}
@endif
<hr/>
@include('word')