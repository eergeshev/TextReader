@extends('layouts.app')

@section('content')
    <h3 style="text-align: center; margin-top: 0px">This is a text reader</h3>
    <div class="row col-sm-12">
        <div class="col-sm-5" >
            <form action="{{ route('text.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label mb-0" for="text" style="font-weight: 600; font-size: 20px">Текст</label>
                    <textarea class="form-control" name="text" id="text" cols="30" rows="5" style="font-size: 15px" placeholder="Текст..."></textarea>
                </div>
                <button class="btn btn-primary" style="float: right">Сохранить</button>
            </form>
        </div>
        <div class="col-sm-7 mt-4" >
            @foreach($datas as $data)
                <div   style="font-size: 20px; margin-bottom: 1px">
                    <p id="div{{$data->id}}">{{ $data->text }}</p>
                </div>
                <div class="d-flex mb-5 mt-1">
                    <label for="time">Time in ms</label>
                    <input type="text" id="time{{$data->id}}" class="form-control form-control-sm" style="width: 100px" placeholder="millisecond..." >
                    <button style="margin-left: 10%" class="btn btn-success"  id="val{{ $data->id }}" onclick="button( '#div{{ $data->id }}', '{{ $data->id }}', '#time{{$data->id}}')">Highlight</button>
                </div>
                
            @endforeach

        </div>
    </div>

@endsection
@push('scripts')
    <script>
        function button(div, text_id, time){

            var t = $(time).val()
            if(!t){
                alert('Please type time in millisecond!');
            }else{
                var words = $(div).text().split( /\s+/ );
                
                console.log(words);
                var text="";
                $.each(words, function(a, b) {
                    text += "<span id='p"+a+"' style='color:black'>" + b + "</span> ";
                });
                $(div).html(text).css('font-size', '20px');
                
                function change(index){
                    var q = index-1;
                    $(div).find('#p'+index).css("color", "orange");
                    $(div).find('#p'+q).css("color", "black");
                }

                function nextWord(){
                    for( var i=0; i < words.length+1; i++){
                        (function (i) {
                            setTimeout(function () {
                                change(i)
                            }, t * i);
                        })(i);
                    }
                }
                nextWord();
            }
        }     
    </script>
@endpush
    
    

 