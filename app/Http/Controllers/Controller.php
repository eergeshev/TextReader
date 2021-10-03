<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Text;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(){
        $datas = Text::all();

        return view('welcome', compact('datas'));
    }

    public function store(Request $request){
        $data = $request->validate([
            'text' => 'required'
        ]);

        $newtext = new Text();
        $newtext = new Text();
        $newtext->text = $data['text'];
        $newtext->save();
    
        return redirect()->back();
    }
}
