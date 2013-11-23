<select name=district id='district' class='form-control' onChange='getTownships();'>
@foreach( $districts as $district )
    <option value="{{$district->id}}">{{$district->name}}</option>
@endforeach