@extends('admin.layout.master')
@section('content')

    {{Form::open( array('url' => '/admin/surveys/'.$action, 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal' ) )}}
    {{Form::hidden('id', $id_questionary)}}
    <fieldset>
        <legend>Nueva Encuesta</legend>

        <table class="table">
            <thead>
                <th>N&uacute;mero</th>
                <th>Pregunta</th>
            </thead>
            <tbody>
            <?php $i = 1; ?>
            @foreach($questions as $question)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{$question->question}}</td>
                    </tr>
                            <!--<label for="" class="col-sm-2 control-label">Nombre</label>-->
                        <tr>
                            <td></td>
                            <td>
                            <div class="col-sm-6">
                                @foreach($answers[$question->id] as $answer)
                                    <input type="radio" name="answers_radio[{{ $question->id }}]"
                                           value="{{ $answer->id }}">{{ $answer->answer }}<br />
                                @endforeach
                            </div>
                            </td>
                        </tr>
                    </div>
            <?php $i++ ?>
            @endforeach
            </tbody>
        </table>
        {{Form::submit('Guardar', array('class' => 'btn btn-default'))}}
    
    </fieldset>
    {{Form::close()}}

@endsection