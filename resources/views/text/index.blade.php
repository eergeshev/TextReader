@extends('layouts.app')

@section('content')
    <h3 style="text-align: center; margin-top: 0px">This is a text reader</h3>
    <div class="row col-sm-12">
        <div class="col-sm-5">
            <form action="{{ route('text.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label mb-0" for="text" style="font-weight: 600; font-size: 20px">Текст</label>
                    <textarea class="form-control" name="text" id="text" cols="30" rows="5" style="font-size: 15px" placeholder="Текст..."></textarea>
                </div>
                <div class="d-flex">
                    <label for="time" style="margin-left: 40%" aria-placeholder="ms...">Time in second</label>
                    <input type="text" class="form-control form-control-sm" name="time" style="width: 100px; margin-right: 10px">
                    <button class="btn btn-primary" style="float: right">Сохранить</button>
                </div>
            </form>
  
        </div>
        <div class="col-sm-7">
            @foreach($datas as $data)
                <div>
                    <p id="par{{ $data->id }}" style="font-size: 20px">{{ $data->simpletext }}</p>
                    <div>
                        <button style="margin-left: 10%" class="btn btn-success"  id="val{{ $data->id }}" onclick="button( '#par{{ $data->id }}', '{{ $data->id }}')">Play</button>
                        <a type="button" class="btn btn-warning" href="{{  route('text.editsettime', [$data->id]) }}">Edit time</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@push('scripts')
<script>
    function button(div, text_id){
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/text/play',
            type:'post',
            datatype: 'json',
            data: {
                'text_id': text_id,
                
            },
            success:function(data){
          
                var text="";
                
                $.each(data, function(a, b) {
                    text += "<span id='p"+a+"' style='color:black'>" + b[0] + "</span> ";
                });
            
                $(div).html(text).css('font-size', '20px');
                function change(index){
                    var q = index-1;
                    $(div).find('#p'+index).css("color", "orange");
                    $(div).find('#p'+q).css("color", "black");
                }

                nextWord();
                var t;
                function nextWord(){
                    for( var i=0; i < data.length; i++){
                        t = parseFloat(data[i][2]) - parseFloat(data[i][1]);
                        console.log(t);
                        (function (i) {
                            setTimeout(function () {
                                change(i)
                            }, 1000 * i);
                        })(i);
                    }
                }
                
            }
            
        });
        
    }     
</script>
@endpush
    
    

 