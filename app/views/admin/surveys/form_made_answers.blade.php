@extends('admin.layout.master')

@section('scripts')

    <script>
        jQuery(document).ready(function($) {

            $('input[type=checkbox]').click(function(){
                if($('input[type=checkbox]:checked').size() > 2)
                {
                    return false;
                }
            });

            $('form#preguntas').submit(function() {

                var radios = $('input[type=radio]');
                var validation_flag = true;
                var group_name = '';
                var group_question_number = '';
                var radio_checked = 1;
                var response = 'No puedes avanzar si no respondes las siguientes preguntas: \n\n';

                $(radios).each(function(){
                    if(group_name != $(this).attr('name')) {
                        group_name = $(this).attr('name');

                        if(radio_checked == 0) {
                            validation_flag = false;
                            response = response + group_question_number + '\n';
                        } else  {
                            radio_checked = 0;
                        }

                        group_question_number = $(this).data('question');
                    }

                    if($(this).is(':checked'))
                    {
                        radio_checked = 1;
                    }

                });

                if(!validation_flag) {
                    alert(response);
                }

                return validation_flag;
            });
        });
    </script>

@endsection

@section('content')

    {{Form::open( array('url' => '/admin/surveys/'.$action, 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal', 'id' => 'preguntas' ) )}}
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
                        @if($question->type == 3)
                        <div class="col-sm-6">
                            @foreach($answers[$question->id] as $answer)
                                <input type="checkbox" name="answers_checkbox[{{ $question->id }}][]"
                                       value="{{ $answer->id }}">&nbsp;{{ $answer->answer }}<br />
                            @endforeach
                        </div>
                        @else
                        <div class="col-sm-6">
                            @foreach($answers[$question->id] as $answer)
                                <input type="radio" name="answers_radio[{{ $question->id }}]"
                                       value="{{ $answer->id }}" data-question="{{$i}}">&nbsp;{{ $answer->answer }}<br />
                            @endforeach
                        </div>                        
                        @endif
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