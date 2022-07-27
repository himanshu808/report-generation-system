<option>Select Batch</option>
@if(!empty($batches))
  @foreach($batches as $key => $value)
    <option value="{{ $key }}">{{ $value }}</option>
  @endforeach
@endif