@extends('eusalud2')
@section('content')
<div class="container">
    <h1>Prueba de Ajax</h1>
    <form action="{{ url('terceros_por_letra') }}" method="post" id="test_form">
        <label for="letra">Letra</label>
        <select name="letra" class="form-control" id="letra">
            @foreach($letras as $l)
                <option value="{{ $l }}">{{ $l }}</option>
            @endforeach
        </select>
        <input type="submit" name="submit" id="submit">
    </form>
</div>


<script>
    var User = {
        init: 
    };
    $(document).ready(function(){
        var form = $("#test_form");
        $("#letra").on('change', function(){
            
            console.log("enviando...");
//            $.ajax({
//                url: "c:/xampp/htdocs/dev.eusalud/app/http/Controllers/HomeController.php",
//                type: 'POST',
//                data: form.serialize(),
//                success: function( results ){
//                    console.log('enviado');
//                    console.log(results)
//                }
//            });
        });
    });
</script>
@stop
