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
        $data = Text::orderBy('created_at', 'desc')->first();
      
        return view('welcome', compact('data'));
    }

    public function store(Request $request){
        $data = $request->validate([
            'text' => 'required'
        ]);

        $newtext = new Text();
        $newtext->text = $data['text'];
        $newtext->save();

        return redirect()->back();
    }

    public function textHighlight(){
        // dd('hello');
        $data = Text::orderBy('created_at', 'desc')->first();
        $text = $data->text;
        $text_array = explode(" ", $text);

        $array_text = [];
        for($i=0; $i < count($text_array); $i++){
           
            $array_text[$i][0] = $text_array[$i];
            $array_text[$i][1] = 1000;

        }   
        // dd($array_text);     

        return $array_text;

    }
}
