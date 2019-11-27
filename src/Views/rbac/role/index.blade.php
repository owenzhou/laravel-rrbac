@extends('layouts.blank')

@section('content')

<div class="row">
	
	<table class="table table-bordered">
		
		<tr>
			<td>编号</td>
			<td>角色名称</td>
			<td>操作</td>
		</tr>

		@foreach($list as $v)

		<tr>
			<td>{{$v['id']}}</td>
			<td>{{$v['name']}}</td>
			<td>
				<a href="/manager/role/edit/{{$v['id']}}">修改</a>&nbsp;
				<a>删除</a>
			</td>
		</tr>

		@endforeach()

	</table>

</div>

@endsection()