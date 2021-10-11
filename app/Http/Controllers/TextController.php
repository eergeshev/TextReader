<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Text;

class TextController extends Controller
{
    public function index(){
            $datas = Text::all();
        return view('text.index', compact('datas'));
    }

    public function store(Request $request){
        $data = $request->validate([
            'text' => 'required',
            'time' => 'required',
        ]);
        
        $array = explode(" ", $data['text']);
        $countchar = 0;
        for($i=0; $i<count($array); $i++){
            $q = strlen($array[$i]);
            $countchar += $q;
        }

        $totaltime = $data['time'];
        $timeForLetter = bcdiv($totaltime / $countchar, 1, 2) ;
        // dd($timeForLetter);

        $nested = [];
        for($i=0; $i<count($array); $i++){
            $stringlen = strlen($array[$i]);

            // $nested[$i]{'word'} = $array[$i];
            $nested[$i]['word'] = $array[$i];
            if($i == 0){
                $nested[$i]['start'] = 0;
                $nested[$i]['end'] = (int)$stringlen * $timeForLetter;
          
            }else{
              
                $nested[$i]['start'] =  $nested[$i-1]['end'] ;
                // $nested[$i]['end'] =  (int)$stringlen * $timeForLetter;
                $nested[$i]['end'] =  ((int)$stringlen * $timeForLetter) + $nested[$i-1]['end'] ;
            }
        }
        
        $newtext = new Text();
        $newtext->text = $nested;
        $newtext->simpletext = $data['text'];
        $newtext->totaltime = $totaltime;
        $newtext->save();

        return redirect()->back();
    }

    public function edittext($id){
        $data = Text::findOrFail($id);
      
        return view('text.settime', compact('data'));
    }

    public function  updatetime(Request $request){
        $data = $request->all();
        $index1 = $data['index1'];
        $index2 = $data['index2'];
        $value = $data['value'];
        // dd($data);
        $text = Text::findOrFail($data['text_id']);
      
        $array_text = $text->text;
        if($index2 == 1){
            $array_text[$index1]['start'] = $value;
        }elseif($index2 == 2){
            $array_text[$index1]['end'] = $value;
        }
        $text->text = $array_text;
        $text->update();
        // dd($text);
        $text_array = $text->text;
        $total = 0;
        for($i=0; $i < count($text_array); $i++){
            
            // $total += (int)$text_array[$i]['end'];
            $total += (int)$text_array[$i]['end'] - (int)$text_array[$i]['start'];
        }
        // dd($total);
        return $total;
    }

    public function play(Request $request){
        $data = $request->all();
        $text_id = $data['text_id'];

        $text = Text::findOrFail($text_id);
        $array_text = $text->text;
   
        return $array_text;
    }
    
}
