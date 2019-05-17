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


use Illuminate\Http\Request;

//cust_begin_zhyy
	Route::get('/', function (Request $request) {
		$req = $request->all();
		return 'hello world';
	})->middleware('guest');
	Route::get('/helloworld/','HelloWorldController@show_list');
	Route::get('/kafka/producter','KafkaController@producter');
	Route::get('/kafka/consumer','KafkaController@consumer');

	/*
	Route::get('/helloworld',function() {
		//$hw_chunk = App\HelloWorld::where('id','>',5)->orderBy('id','desc')->chunk(10,function ($item){
		//	echo $item;
		//});
		//$first = App\HelloWorld::where('id','>',5)->where('id','<',10)->get();
		//$list = App\HelloWorld::get();
		//return $list;
		return view('helloworld_show',['list'=>$list]);
	});
	 */

	//add new one hello world
	//Route::post('/add_hw',function(Request $request) {
	//	$title = $request->input('title');
	//	$new = new App\HelloWorld();
	//	$new->title = $title;
	//	$new->save();
	//	 
	//	/*
	//	echo $request;
	//	App\HelloWorld::create(['title'=>$request->input('title')]);
	//	 */
	//	return redirect('/helloworld');
	//});

	//Route::post('update_hw',function(Request $request){
	//	/*
	//	$hw = App\HelloWorld::find(20);		
	//	$hw->title = $request->input('title');
	//	$hw->save();
	//	 */
	//	/*
	//	$result = App\HelloWorld::where('id','>',3)->where('id','<',7)->toSql();
	//	 */
	//	$cond_attr = ['title'=>'nanjing'];
	//	$update_attr = ['title'=>'zhangyy'];
	//	App\HelloWorld::updateOrCreate($cond_attr,$update_attr);
	//	return 'update hw';
	//});
	Route::get('get_one_helloworld/{id}','HelloWorldController@get_one')->where('id','[0-9]+');
	Route::post('add_or_update','HelloWorldController@update');

	Route::post('delete_hw',function(Request $request){
		/*
		$hw = App\HelloWorld::find(27);	
		$hw->delete();
		 */
		//第二种delete 方法
		$id = $request->input('id');
		App\HelloWorld::destroy($id);
		/*
		//第三种删除
		App\HelloWorld::where('title','')->delete();
		 */
		return redirect('/helloworld');
	});

	Route::post('test_log',function(Request $request){
		$log = $request->input('log');
		Log::info($log);	
		return redirect('/helloworld');
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

