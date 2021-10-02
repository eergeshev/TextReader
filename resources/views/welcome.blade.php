@extends('layouts.app')

@section('content')
    <h3 style="text-align: center; margin-top: 0px">This is a text reader</h3>
    <div class="row col-sm-12">
        <div class="col" >
            <form action="{{ route('text.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label mb-0" for="text" style="font-weight: 600; font-size: 20px">Текст</label>
                    <textarea class="form-control" name="text" id="text" cols="30" rows="5" style="font-size: 15px" placeholder="Текст..."></textarea>
                </div>
                <button class="btn btn-primary" style="float: right">Сохранить</button>
            </form>
        </div>
        <div class="col mt-4" >
            <div id="div"></div>
            <button style="margin-left: 45%; margin-top: 5%" class="btn btn-success" id="highlight">Highlight</button>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/text/highlight',
                type: 'get',
                datatype: 'array',
           
                success:function(data){
                    console.log(data);
                    var text="";
                    $.each(data, function(a, b) {
                        text += "<span id='p"+a+"' style='color:black'>" + b[0] + "</span> ";
                    });
                    $('#div').html(text).css('font-size', '20px');

                    $('#highlight').on('click', function() {
                        cc = 0;
                        nextWord();
                    });

                    var cc = 0;
                    function nextWord() {
                        $('#p'+cc).css("color", "orange");
                        cc++;
                        if(cc > data.length-1) return;
                        window.setTimeout(nextWord, data[cc-1][1]);
                    }
                }
            });
        });
    </script>
@endpush
    
    

 