@extends('layouts.app')

@section('content')
    <h3 style="text-align: center; margin-top: 0px">This is a text reader</h3>
    <div class="row col-sm-12">
        <div class="col-sm-4" style="" >
            <table class="table table-bordered table-sm" style="width: 300px; margin: 0px auto">
                <thead>
                    <tr>
                        <th>Words</th>
                        <th>Start time</th>
                        <th>Duration</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 0; $i < count($data['text']); $i++)
                        <tr >
                            <td>{{ $data['text'][$i]['word'] }}</td>
                            <td><div contenteditable="true" id="idd{{ $data['text'][$i]['start'] }}" onblur="edittime(this, '#idd{{ $data['text'][$i]['start'] }}', '{{ $data['id']}}', '{{ $i }}', '1')">{{ $data['text'][$i]['start'] }}</div></td>
                            <td><div contenteditable="true" id="idd{{ $data['text'][$i]['end'] }}" onblur="edittime(this, '#idd{{ $data['text'][$i]['end'] }}', '{{ $data['id']}}', '{{ $i }}', '2')">{{ $data['text'][$i]['end'] }}</div></td>
                        </tr>
                    @endfor
                </tbody>

            </table>

        </div>
        <div class="col-sm-8">
            <div style="display: flex; margin: 0px auto; ; height: 60px">
                <p>Total time</p> <p style="margin-left: 10px; font-size: 25px">{{ $data->totaltime}}</p>
            </div>
            <div style="display: flex; margin: 0px auto; ; height: 60px">
                <p>Total time</p>   <p id="total" style="margin-left: 10px; font-size: 25px"></p>
            </div>
            <div>
                <p id="{{ $data->id }}" style="font-size: 20px"></p>
                <p id="subtitles" style="font-size: 20px">{{ $data->simpletext }}</p>
                <button style="margin-left: 10%" class="btn btn-success"  id="val{{ $data->id }}" onclick="button( '#parag', '{{ $data->id }}')">Play</button>
                <audio  id="myVideo" controls>
                    <source src="/files/2nd.ogg" type="audio/ogg">
                    <source src="/files/2nd.mp3" type="audio/mpeg">
                    Your browser does not support the audio tag.
                </audio>
                {{-- <audio  id="myVideo" controls>
                    <source src="/files/se003.ogg" type="audio/ogg">
                    <source src="/files/se003.mp3" type="audio/mpeg">
                    Your browser does not support the audio tag.
                </audio> --}}

             
            </div>
        </div>
    </div>

@endsection
@push('scripts')
<script type="text/javascript">
    
</script>
    <script>
        window.data = {!! json_encode($data) !!};
       
        function button(div, text_id){
            var audio = document.getElementById("myVideo");
            var subtitles = document.getElementById("subtitles");
            subtitles.innerHTML = "";
         
            var data = window.data.text;

            createSubtitle();

            function createSubtitle()
            {
                var element;
                for (var i = 0; i < data.length; i++) {
                    element = document.createElement('span');
                    element.setAttribute("id", "c_" + i);
                    element.innerText = data[i]['word'] + " ";
                    subtitles.appendChild(element);
                }
            }

            audio.addEventListener("timeupdate", function(e){
                data.forEach(function(element, index, array){
                    if( audio.currentTime >= element.start && audio.currentTime <= element.end )
                        subtitles.children[index].style.color = 'orange';
                        subtitles.children[index+1].style.color = 'black';
                });
            });
        }
    </script>

{{-- <script>
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
                    text += "<span id='p"+a+"' style='color:black'>" + b['word'] + "</span> ";
                });
                // console.log(text)
                $(div).html(text).css('font-size', '20px');
                
                
                function change(index){
                    var q = index-1;

                    $("[id^='p']" ).css("color", "black");
                    $(div).find('#p'+index).css("color", "orange");
                 
                }
                nextWord();
                function nextWord(){
                    for( var i=0; i < data.length; i++){
                        var t = [1000, 2000, 500, 1000, 300, 2000, 1500, 500, 1500, 1300, 500, 600, 1000];
                        (function (i) {
                            setTimeout(function() {  change(i) }, 1000 * i);
                
                        })(i);
                                             
                        var temp = data[i][0];
                        console.log(temp);
                    }
                }

            }
        });
    }     
</script> --}}
<script>
    function edittime(value, x, text_id, index1, index2){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/text/edittime',
            type:'post',
            datatype: 'json',
            data: {
                'value': value.innerText,
                'text_id': text_id,
                'index1': index1,
                'index2': index2,
            },
            success:function(data){
                $('#total').html(data);
            }
        });
  
    };
</script>

@endpush
    
    
