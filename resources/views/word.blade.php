{{ $nextWord->getTranslation() }}<br/>
{{ $nextWord->getPronunce() }}<br/>
<h2>Answer</h2>
<form action="/answer" method="POST">
	@foreach ($options as $word)
		<label><input type="radio" name="answer" value="{{ $word->getWord() }}" /> {{ $word->getWord() }}</label><br/>
	@endforeach

	<input type="hidden" name="_token" value="{{ csrf_token() }}"  />
	<input type="submit" value="Submit" />
</form>