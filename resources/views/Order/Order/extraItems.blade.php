@if($Product->extratype == 'composite')
	@php $hr = array(); @endphp	
	@foreach($ExtraItems as $key => $value )	
		@if (in_array($value->groupsectionby, $hr) == false)			
			@php $hr[$value->groupsectionby] =  $value->groupsectionby @endphp
			<hr/>
		@endif
		<input id="{{$value->id}}" type="checkbox" name="{{$value->item_code}}" value="{{$value->id}}"  class="btn btn-info compositeId"> {{$value->ar_name}} <br>
	@endforeach
@else
	الاضافات   
	<select id="addEI" class="form-control select2">
		<option></option>
		@foreach($ExtraItems as $key => $value )
			@if($value->price == 0)
				<option id="{{$value->id}}" style="background-color: #f39c12;color:#FFF"><span class="label label-success">مجانى </span> {{$value->ar_name}}</option>
			@else
				<option id="{{$value->id}}">{{$value->ar_name}} - {{$value->price}}</option>
			@endif
		@endforeach
	</select>

@endif