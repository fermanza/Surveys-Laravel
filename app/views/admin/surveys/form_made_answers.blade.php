@extends('admin.layout.master')

@section('scripts')

    <script>
        jQuery(document).ready(function($) {

            $('div.panel:eq(1)').removeClass('panel-default').addClass('panel-primary');

            $('div.panel').click(function(){
                if($(this).is('div.panel-default')) {
                    $('div.panel-primary').removeClass('panel-primary').addClass('panel-default');
                    $(this).addClass('panel-primary').removeClass('panel-default');
                }
            });

            $(document).keyup(function(event){

                if(event.keyCode > 48 && event.keyCode < 59) {
                    var selected_panel = $('div.panel-primary');
                    var radio_inputs = selected_panel.find('input[type=radio]');
                    var selected_answer = event.keyCode - 48;

                    if(selected_answer > radio_inputs.size()) {
                        alert('La respuesta que seleccionaste no existe');
                    } else {
                        radio_inputs.eq(selected_answer-1).prop('checked', true);
                        selected_panel.removeClass('panel-primary').addClass('panel-default');
                        var next_panel = selected_panel.next();

                        if(next_panel.is('div.panel')) {
                            next_panel.removeClass('panel-default').addClass('panel-primary');
                            $('html, body').animate( { scrollTop: $(next_panel).offset().top - 55 }, 300 );
                            console.log($(next_panel).offset().top);
                        }
                    }
                }

            });

            $('input[type=checkbox]').click(function(){
                if($('input[type=checkbox]:checked').size() > 2)
                {
                    return false;
                }
            });

            $('#btn-submit-form').click(function() {

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
                } else {

                    $.post("{{url('admin/surveys/get-validation-questions')}}", { questionary_id: {{$id_questionary}} }, function(data){

                        var modal_body = $('div#validation-questions div.modal-body');

                        modal_body.empty();

                        for(var key in data) {
                            var panel = $('<div></div>');
                            panel.addClass('panel').addClass('panel-default');

                            var panel_heading = $('<div></div>');
                            panel_heading.addClass('panel-heading');
                            panel_heading.html( data[key].id + ' .- ' + data[key].question );

                            var panel_body = $('<div></div>');
                            panel_body.addClass('panel-body');

                            for(var answer in data[key].answers) {
                                var input = $('<input type="radio" name="validation_question['+data[key].id+']" class="validation-answer" value="'+data[key].answers[answer].id+'" />     ' + data[key].answers[answer].answer + '<br />');
                                input.data('question-id', data[key].id);
                                input.data('answer-id', data[key].answers[answer].id);

                                panel_body.append(input);
                            }

                            panel.append(panel_heading);
                            panel.append(panel_body);

                            modal_body.append(panel);
                        }

                        $('#validation-questions').modal('show');
                    });
                }

                return false;
            });

            $('#validate-survey').click(function(){
                var validation_questions_flag = true;

                $('input.validation-answer:checked').each(function(){
                    
                    var input = $(this);

                    var question_id = input.data('question-id');
                    var selected_answer = $("input[name='answers_radio["+question_id+"]']:checked").val();
                    console.log(selected_answer);
                    var validated_answer = input.val();
                    console.log(validated_answer);

                    if(selected_answer != validated_answer) {
                        alert('Las respuestas no coinciden, por favor revisa de nuevo la encuesta y continúa.');
                        validation_questions_flag = false;
                        return false;
                    }

                });

                if(validation_questions_flag) {
                    $('form#preguntas').submit();
                }
            });
        });
    </script>

@endsection

@section('content')

    <!-- Modal -->
    <div class="modal fade" id="validation-questions" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Validación de encuesta</h4>
          </div>
          <div class="modal-body">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button id="validate-survey" type="button" class="btn btn-primary">Validar</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    {{Form::open( array('url' => '/admin/surveys/'.$action, 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal', 'id' => 'preguntas' ) )}}
    {{Form::hidden('id', $id_questionary)}}
    {{Form::hidden('questionary_made_id', $questionary_made_id)}}
    <fieldset>
        <legend>Nueva Encuesta</legend>

        <?php $i = 1; ?>
        @foreach($questions as $question)

        <div class="panel panel-default">
            <div class="panel-heading">
                {{ $i .' .- '. $question->question}}
            </div>
            <div class="panel-body">
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
                    <input type="radio" name="answers_radio[{{ $question->id }}]"
                               value="" data-question="{{$i}}">&nbsp; No respondió / Respuesta en blanco<br />
                </div>                        
                @endif
            </div>
        </div>
        <?php $i++; ?>
        @endforeach

        <div class="panel panel-default">
            <div class="panel-heading">
                &iquest;Nos autoriza ud a que cuando este lista le hagamos llegar a
                    esta residencia la tarjeta La Pasiera con los beneficios que
                    la misma con lleva?
            </div>
            <div class="panel-body">
                <div class="col-sm-6">
                    <input type="radio" name="form_respondent" value="1">&nbsp;Si<br />
                    <input type="radio" name="form_respondent" value="2">&nbsp;No
                </div>
            </div>
        </div>

        {{Form::button('Guardar', array('class' => 'btn btn-default', 'id' => 'btn-submit-form'))}}
    
    </fieldset>
    {{Form::close()}}

@endsection