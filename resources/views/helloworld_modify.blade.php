@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">hello world</div>

                <div class="panel-body">
				<!--add or update-->
				<form action="{{ url('/add_or_update') }}" method="post" >
                        {{ csrf_field() }}
						<input type="hidden" name="id" value="{{$info->id}}" />
						<div class="form-group">
							<label >title：</label>
								<input type="text" name="title" value="{{$info->title}}" class="form-control" placeholder="标题"/>
						</div>
						<div class="form-group">
							<label>content:</label>
							<input type="text" name="content" value="{{$info->content}}" class="form-control" placeholder="内容"/>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary">add or update</button>
						</div>

				</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
