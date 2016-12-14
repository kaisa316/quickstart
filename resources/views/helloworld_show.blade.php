@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">hello world</div>

                <div class="panel-body">
				<form action="{{ url('/add_hw') }}" method="post">
                        {{ csrf_field() }}
						<input type="text" name="name" />
						<input type="text" name="age"/>
						<input type="submit" value="提交"/> 
				</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
