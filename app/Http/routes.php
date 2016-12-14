<?php
/**
 * 自我感受
 * 1、route 通过post or get 等method 后面再通过route parameter 进行匹配，感觉很精准，这样把范围最大的缩小了
 * 从实现一个最简单的增删改查开始
 */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


//use App\Task;
use Illuminate\Http\Request;

//cust_begin_zhyy
	Route::get('/', function (Request $request) {
		$req = $request->all();
		
		return '1111212';
	})->middleware('guest');


	//hello world begin
	Route::get('/helloworld',function() {
		//return 'hello world';	
		return view('helloworld_show');
	});

	//add new one hello world
	Route::post('/add_hw',function(Request $request) {
		$info = $request->all();	
		$name = $request->input('name');
		echo $name;
		print_r($info);	
		echo 'add hw';
	});
	//hello world end


	Route::get('/tasks', 'TaskController@index');//查
	Route::post('/task', 'TaskController@store');//增
	Route::delete('/task/{task}', 'TaskController@destroy');//删除

	Route::auth();//加上这行login就可以跳转正常了

	/*
	Route::group(['prefix'=>'admin'],function(){
		Route::any('/hello/',function(){
			echo __LINE__;
			//echo $age.'<br />';
			//return 'hello world';
		});
	});
	 */


//cust_end_zhyy





///**
// *Show Task Dashboard
// *
// */
//Route::get('/', function () {
//	$tasks = Task::orderBy('created_at', 'asc')->get();
//	return view('tasks', [
//		'tasks' => $tasks
//	]);
//});
//
///**
// * Add New Task
// */
//Route::post('/task', function (Request $request) {
//	$validator = Validator::make($request->all(), [
//		'name' => 'required|max:255',
//	]);
//
//	if ($validator->fails()) {
//		return redirect('/')
//			->withInput()
//			->withErrors($validator);
//	}
//
//	$task = new Task;
//	$task->name = $request->name;
//	$task->save();
//
//	return redirect('/');
//});
//
///**
// * Delete Task
// */
//Route::delete('/task/{task}', function (Task $task) {
//	$task->delete();
//	return redirect('/');
//});


//Route::auth();

//Route::get('/home', 'HomeController@index');

?>

