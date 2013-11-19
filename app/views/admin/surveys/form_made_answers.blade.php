@extends('admin.layout.master')
@section('content')

    {{Form::open( array('url' => '/admin/surveys/'.$action, 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal' ) )}}
    {{Form::hidden('id', $id_questionary)}}
    {{Form::hidden('questionary_made_id', $questionary_made_id)}}
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
                <tr>
                    <td></td>
                    <td>
                        <div class="col-sm-6">
                            @foreach($answers[$question->id] as $answer)
                                <input type="radio" name="answers_radio[{{ $question->id }}]"
                                       value="{{ $answer->id }}">&nbsp;{{ $answer->answer }}<br />
                            @endforeach
                        </div>
                    </td>
                </tr>
            <?php $i++ ?>
            @endforeach
            <tr>
                <td></td>
                <th>&iquest;Nos autoriza ud a que cuando este lista le hagamos llegar a
                    esta residencia la tarjeta La Pasiera con los beneficios que
                    la misma con lleva?</th>
            </tr>
            <tr>
                <td></td>
                <td>
                    <div class="col-sm-6">
                        <input type="radio" name="form_respondent" value="1">&nbsp;Si<br />
                        <input type="radio" name="form_respondent" value="2">&nbsp;No
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        {{Form::submit('Guardar', array('class' => 'btn btn-default'))}}
    
    </fieldset>
    {{Form::close()}}

@endsection