@extends('layouts.blank')

@section('title', '后台用户管理')

@section('content')

<div class="box">
	<div class="box-header">
		<h3 class="box-title">Data Table With Full Features</h3>
	</div>

	<!-- /.box-header -->
	<div class="box-body">
	<table class="table table-bordered table-hover dataTable">
		<thead>
			<tr>
				<th>编号</th>
				<th>用户名</th>
				<th>角色</th>
				<th>操作</th>
			</tr>
		</thead>

		<tbody>
			@foreach($list as $k=>$v)

			<tr>
				<td>{{$v['id']}}</td>
				<td>{{$v['name']}}</td>
				<td>
					@foreach($v['roles'] as $role)
					{{$role['name']}}<br/>
					@endforeach()
				</td>
				<td>
					<a href="/manager/admin/edit/{{$v['id']}}">修改</a>&nbsp;&nbsp;
					<a>删除</a>
				</td>
			</tr>

			@endforeach()
			<tr><td colspan="4">{{ $list->links('vendor.myPage') }}</td></tr>
		</tbody>

	</table>
	</div>
	<!-- /.box-body -->
</div>

@endsection()