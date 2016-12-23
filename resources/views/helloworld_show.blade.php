@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">hello world</div>

                <div class="panel-body">
		

				<form action="{{ url('/add_hw') }}" method="post" >
                        {{ csrf_field() }}
						<div class="form-group">
							<label >title：</label>
								<input type="text" name="title" class="form-control" placeholder="标题"/>
						</div>
						<div class="form-group">
							<label>content:</label>
							<input type="text" name="content" class="form-control" placeholder="内容"/>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary">新增</button>
						</div>

				</form>
				<!--更新 -->
				<form action="{{ url('/update_hw') }}" method="post" class="form-inline">
                        {{ csrf_field() }}
						<div class="form-group">
							<label>title:</label>
							<input type="text" name="title" class="form-control" placeholder="标题"/>
						</div>
						<div class="form-group">
							<input type="submit" value="更新" class="btn btn-default"/> 
						</div>
				</form>
				<!--log test -->
				<form action="{{ url('/test_log') }}" method="post" >
                        {{ csrf_field() }}
						<div class="form-group">
							<label></label>
							<input type="text" name="log" class="form-control" placeholder="record log message"/>
						</div>
						<div class="form-group">
							<input type="submit" value="send log" class="btn btn-danger"/> 
						</div>
				</form>

				<table class="table table-hover">
					<tr>
						<th>ID</th>
						<th>title</th>
						<th>创建时间</th>
						<th>操作</th>
					</tr>
					@foreach($list as $item)
					<tr>
						<th>{{$item->id}}</th>
						<td>{{$item->title}}</td>
						<td>{{$item->created_at}}</td>
						<td>
							<a href="{{url('/get_one_helloworld').'/'.$item->id}}" class="btn btn-success" >修改</a>
							<!--delete record -->
							<form action="{{ url('/delete_hw') }}" method="post">
                			        {{ csrf_field() }}
									<input type="hidden" name="id" value="{{$item->id}}"/>
									<input type="submit" value="删除" class="btn btn-danger"/> 
							</form>
						</td>
					</tr>
					@endforeach

				</table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
