<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Task;
use App\Http\Controllers\Controller;
use App\Repositories\TaskRepository;

class TaskController extends Controller
{
    protected $tasks;

	public function  __construct(TaskRepository $tasks) {
//		$this->middleware('auth');
		$this->tasks = $tasks;
	}
	

	/**
	 * retrival data
	 */
	public function index(Request $request)	{
		$params = $request->all();
		$this->dd($params);
		
		$tasks = Task::orderBy('created_at', 'asc')->get();
		//$tasks = $request->user()->tasks()->get();
		$tasks = [];
		return view('tasks', [
			'tasks' => $tasks
		]);
	}

	private function dd($params) {
		vadump($params);
	}

	/**
	 * store data
	 */
	public function store(Request $request) {
		$this->validate($request,['name'=>'required|max:255']);
		$request->user()->tasks()->create([
			'name' => $request->name,
		]);

		return redirect('/tasks');
	}

	/**
	 * 删除
	 */
	public function destroy(Request $request ,Task $task) {
		$this->authorize('destory',$task);
		$task->delete();

		return redirect('/tasks');
	}

}
