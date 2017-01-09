<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\HelloWorld as HwModel;
use Illuminate\Http\Request;

class HelloWorldController extends Controller {

	public function __construct() {
		$this->middleware('auth')->only('update');

	}

	/**
	 * request dependency inject
	 */
	public function show_list(Request $request) {
		$name = $request->input('name');
		$list = HwModel::get();
		return view('helloworld_show',['list'=>$list]);
	}

	/**
	 *更新
	 */
	public function update(Request $request) {
		$id = $request->input('id');
		$attr = [
			'title'=>$request->input('title'),	
			'content'=>$request->input('content')	
		];

		HwModel::where('id',$id)->update($attr);
		return redirect('helloworld');
	}

	/**
	 *get one record
	 */
	public function get_one($id) {
		$info = HwModel::find($id);
		return view('helloworld_modify',['info'=>$info]);
	}

}



?>
