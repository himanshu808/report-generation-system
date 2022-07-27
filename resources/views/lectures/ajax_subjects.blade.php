<option>Select Subject</option>
@if(!empty($subjects))
  @foreach($subjects as $key => $value)
    <option value="{{ $key }}">{{ $value }}</option>
  @endforeach
@endif