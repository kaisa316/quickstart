@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">hello world</div>

                <div class="panel-body">

				<!--add new record-->
				<form action="{{ url('/add_hw') }}" method="post">
                        {{ csrf_field() }}
						<input type="text" name="name" />
						<input type="text" name="age"/>
						<input type="submit" value="新增"/> 
				</form>
				<!--更新 -->
				<form action="{{ url('/update_hw') }}" method="post">
                        {{ csrf_field() }}
						<input type="text" name="name" />
						<input type="submit" value="更新"/> 
				</form>
				<!--delete record -->
				<form action="{{ url('/delete_hw') }}" method="post">
                        {{ csrf_field() }}
						<input type="submit" value="删除"/> 
				</form>


				<table>
					@foreach($list as $item)
					<tr>
						<td>{{$item->title}}</td>
						<td>{{$item->created_at}}</td>
						<td></td>
					</tr>
					@endforeach

				</table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
