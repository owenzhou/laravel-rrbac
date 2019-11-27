@extends('layouts.blank')

@section('content')


<div class="row">
	
	<table class="table table-bordered">
		
		<tr>
			<td>权限模块名</td>
		</tr>

		@foreach($list as $k=>$v)

		<tr>
			<td>
			{{$k}}
			<br/>
			@foreach($v as $i=>$m)
			&nbsp;&nbsp;&nbsp;&nbsp;<input name="opt" type="checkbox" value="{{$m}}" /> {{$i}}
			@endforeach()
			</td>
		</tr>

		@endforeach()

	</table>

</div>


@endsection()