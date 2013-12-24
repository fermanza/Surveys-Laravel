<?php
	
class SurveysController extends BaseController
{

	public function index($id_questionary)
	{
            $questions = Question::
                    where('questionary_id', '=', $id_questionary)
                    ->get();
            return View::make('admin.surveys.index')
                    ->with('section', 'Selección de Encuestas')
                    ->with('questions', $questions)
                    ->with('id_questionary', $id_questionary);
	}

    public function export($id_questionary)
    {
        $nameTimestamp = 'questionary-'.$id_questionary.'-export-'.date('Y.m.d.s').'.csv';
        $csvFile = new Keboola\Csv\CsvFile('data/'.$nameTimestamp);

        $csvHeader = array(
            utf8_decode('Provincia'),
            utf8_decode('Distrito'),
            utf8_decode('Corregimiento'),
            utf8_decode('Lugar Poblado'),
            utf8_decode('Zona'),
            utf8_decode('Area'),
            utf8_decode('Folio'),
            utf8_decode('Número'),
            utf8_decode('Encuestador'),
            utf8_decode('Supervisor'),
            utf8_decode('Calle (Avenida)'),
            utf8_decode('Ubicación'),
            utf8_decode('Nombre'),
            utf8_decode('Apellidos'),
            utf8_decode('Celular'),
            utf8_decode('Cédula'),
            utf8_decode('Teléfono'),
            utf8_decode('Sexo'),
            utf8_decode('Edad')
        );

        foreach(Question::all() as $question):
            array_push($csvHeader, utf8_decode($question->id.'.- '.$question->question));
        endforeach;

        $csvFile->writeRow($csvHeader);

        $questionaries = QuestionaryMade::where('questionary_id', '=', $id_questionary)->get();

        foreach($questionaries as $questionary):

            if($questionary->respondent_id == NULL)
            {
                $questionary->respondent = new Respondent;
            }

            $tempRow = array(
                utf8_decode($questionary->state->name),
                utf8_decode($questionary->district->name),
                utf8_decode($questionary->township->name),
                utf8_decode($questionary->suburb->name),
                utf8_decode($questionary->zone),
                utf8_decode($questionary->area),
                utf8_decode($questionary->folio),
                utf8_decode($questionary->respondent->exterior_number.'-'.$questionary->respondent->interior_number),
                utf8_decode($questionary->user->name.' '.$questionary->user->pattern_name.' '.$questionary->mattern_name),
                '',
                utf8_decode($questionary->respondent->street),
                utf8_decode($questionary->respondent->location_reference),
                utf8_decode($questionary->respondent->name),
                utf8_decode($questionary->respondent->pattern_name.' '.$questionary->respondent->mattern_name),
                utf8_decode($questionary->respondent->cellphone),
                utf8_decode($questionary->respondent->identity_document),
                utf8_decode($questionary->respondent->sex),
                utf8_decode($questionary->respondent->age)
            );

            foreach($questionary->answers as $answer):
                array_push($tempRow, $answer->answer->answer);
            endforeach;

            $csvFile->writeRow($tempRow);
        endforeach;

        return Response::download($csvFile);
    }
        
	public function new_survey($id_questionary)
	{
            $actitudes = array();
            $act = new StdClass();
            $act->value = 1;
            $act->name = "A Favor";
            array_push($actitudes, $act);
            $act = new StdClass();
            $act->value = 2;
            $act->name = "Neutral";
            array_push($actitudes, $act);
            $act = new StdClass();
            $act->value = 3;
            $act->name = "En Contra";
            array_push($actitudes, $act);
            $actitude = 1;
            
            $country_id = Auth::user()->country_id;
            
            $country = Country::find($country_id);
            $states = State::find($country_id)->get();
            
            return View::make('admin.surveys.form_made')
                    ->with('section', 'Crear Encuestas')
                    ->with('id_questionary', $id_questionary)
                    ->with('actitudes', $actitudes)
                    ->with('actitude', $actitude)
                    ->with('country', $country)
                    ->with('states', $states)
                    ->with('users', User::where('user_type', '=', 2)->get())
                    ->with('action', 'save-create-made');
	}

    public function save_create_made()
    {
        $questionary_made = new QuestionaryMade();
        $questionary_made->questionary_id = Input::get('id');
        
        $questionary_made->country_id = Auth::user()->country_id;
        $questionary_made->state_id = Input::get('state');
        $questionary_made->district_id = Input::get('district');
        $questionary_made->township_id = Input::get('township');
        $questionary_made->folio = Input::get('folio');
        $questionary_made->user_create = Auth::user()->id;
        $questionary_made->user_id = Input::get('user_id');
        $questionary_made->created_at = date('Y-m-d H:i:s');
        $questionary_made->response_type = Input::get('response_type');

        $new_suburb = Input::get('new_suburb_check');
        
        if(!empty($new_suburb))
        {
            $suburb = new Suburb;

            $suburb->country_id = $questionary_made->country_id;
            $suburb->state_id = $questionary_made->state_id;
            $suburb->district_id = $questionary_made->district_id;
            $suburb->township_id = $questionary_made->township_id;
            $suburb->name = Input::get('new_suburb');
            $suburb->save();

            $questionary_made->suburb_id = $suburb->id;
        }
        else 
        {
            $questionary_made->suburb_id = Input::get('suburb');                
        }
        
        $questionary_made->date = Input::get('date');
        // $questionary_made->actitude = Input::get('actitude');
        // $questionary_made->incomming = Input::get('incomming');
        $questionary_made->estimated_age = Input::get('estimated_age');
        $questionary_made->age = Input::get('age');
        $questionary_made->zone = Input::get('zone');
        $questionary_made->area = Input::get('area');
        // $questionary_made->latitude = Input::get('latitude');
        // $questionary_made->longitude = Input::get('longitude');
        
        if (Input::hasFile('url_facade'))
        {
        	$image = Image::make( Input::file('url_facade')->getRealPath() );
        	$image->save( 'img/facades/'.md5(Input::file('url_facade')->getClientOriginalName().date('Y-m-d H:i:s')).'.'.Input::file('url_facade')->getClientOriginalExtension()  );
        	$questionary_made->url_facade = asset(str_replace(' ', '%20', 'img/facades/'.md5(Input::file('url_facade')->getClientOriginalName().date('Y-m-d H:i:s')).'.'.Input::file('url_facade')->getClientOriginalExtension()));
        }
        $questionary_made->save();
        
        $questions = Question::
                where('questionary_id', '=', Input::get('id'))
                ->get();
        $answers = array();
        $lastid = 0;
        foreach($questions as $question){
            $answers[$question->id] = Answer::
                where('question_id', '=', $question->id)
                ->get();
            $lastid = $question->id;
        }

        return Redirect::to('/admin/surveys/answer/'.Input::get('id').'/'.$questionary_made->id);
    }

    public function answer($questionary_id, $questionary_made_id)
    {
        $questions = Question::
                where('questionary_id', '=', $questionary_id)
                ->get();

        $answers = array();
        $lastid = 0;
        foreach($questions as $question){
            $answers[$question->id] = Answer::
                where('question_id', '=', $question->id)
                ->get();
            $lastid = $question->id;
        }

        return View::make('admin.surveys.form_made_answers')
                ->with('section', 'Crear Encuestas')
                ->with('questions', $questions)
                ->with('id_questionary', $questionary_id)
                ->with('questionary_made_id', $questionary_made_id)
                ->with('answers', $answers)
                ->with('action', 'save-create-made-answers');
    }
        
	public function save_create_made_answers()
	{
            $questionary_id = Input::get('id');
            $questions = Question::
                where('questionary_id', '=', $questionary_id)
                ->get();
            $answers_radio = Input::get('answers_radio');
            
            foreach($questions as $question){

                if($question->type == 3)
                {
                    for($i=0; $i<count($_POST['answers_checkbox'][$question->id]); $i++)
                    {
                        $qma = new QuestionaryMadeAnswers;

                        $qma->questionary_made_id = Input::get('questionary_made_id');
                        $qma->answer_id = $_POST['answers_checkbox'][$question->id][$i];
                        $qma->answer_text = "";
                        $qma->which = "";
                        $qma->question_id = $question->id;
                        $qma->save();
                    }
                }
                else
                {
                    $qma = new QuestionaryMadeAnswers;

                    $qma->questionary_made_id = Input::get('questionary_made_id');
                    $qma->answer_id = $answers_radio[$question->id];
                    $qma->answer_text = "";
                    $qma->which = "";
                    $qma->question_id = $question->id;
                    $qma->save();                    
                }

            }
            if(Input::get('form_respondent')==2){
                // Don't show respondents questionary
                return Redirect::to('/admin/surveys/'.$questionary_id)->with('message', array(
                    'type' => 'success',
                    'message' => 'Encuesta creada.'
                ));
            }

            return Redirect::to('/admin/surveys/new-respondent/'.$questionary_id.'/'.Input::get('questionary_made_id'));
	}

    public function new_respondent($questionary_id, $questionary_made_id)
    {
        return View::make('admin.surveys.form_respondents')
                    ->with('section', 'Crear Encuestas')
                    ->with('id_questionary', $questionary_id)
                    ->with('questionary_made_id', $questionary_made_id)
                    ->with('action', 'save-create-respondents');
    }
        
        public function save_create_respondents(){
            
            $questionary_id = Input::get('id');
            
            $respondent = new Respondent;

            $respondent->name = Input::get('name');
            $respondent->patern_name = Input::get('patern_name');
            $respondent->matern_name = Input::get('matern_name');
            // $respondent->birth_date = Input::get('birth_date');
            $respondent->sex = Input::get('sex');
            $respondent->phone = Input::get('phone');
            $respondent->cellphone = Input::get('cellphone');
            // $respondent->state = Input::get('state');
            // $respondent->district = Input::get('district');
            // $respondent->township = Input::get('township');
            // $respondent->section = Input::get('section');
            // $respondent->cologne = Input::get('cologne');
            $respondent->type = Input::get('type');
            $respondent->identity_document = Input::get('identity_document');
            $respondent->street = Input::get('street');
            $respondent->exterior_number = Input::get('exterior_number');
            $respondent->interior_number = Input::get('interior_number');
            $respondent->location_reference = Input::get('location_reference');
            
            $respondent->save();
            
            return Redirect::to('/admin/surveys/'.$questionary_id)->with('message', array(
                'type' => 'success',
                'message' => 'Encuesta Capturada.'
            ));
        }
        
        public function get_district(){
            
            $country_id = Auth::user()->country_id;
            $state_id = Input::get('state_id');
            
            $districts = District::
                    where('country_id', '=', $country_id)
                    ->where('state_id', '=', $state_id)
                    ->get();
            
            $districts_array = array();
            foreach($districts as $district){
                $districts_tmp = array("id"=>$district->id, "name"=>$district->name);
                array_push($districts_array, $districts_tmp);
            }
            return $districts_array;
        }
        
        public function get_township(){
            
            $country_id = Auth::user()->country_id;
            $state_id = Input::get('state_id');
            $district_id = Input::get('district_id');
            $townships = Township::
                    where('country_id', '=', $country_id)
                    ->where('state_id', '=', $state_id)
                    ->where('district_id', '=', $district_id)
                    ->get();
            
            $townships_array = array();
            foreach($townships as $township){
                $townships_tmp = array("id"=>$township->id, "name"=>$township->name);
                array_push($townships_array, $townships_tmp);
            }
            return $townships_array;
        }
        
        public function get_suburbs(){
            
            $country_id = Auth::user()->country_id;
            $state_id = Input::get('state_id');
            $district_id = Input::get('district_id');
            $township_id = Input::get('township_id');
            $suburbs = Suburb::
                    where('country_id', '=', $country_id)
                    ->where('state_id', '=', $state_id)
                    ->where('district_id', '=', $district_id)
                    ->where('township_id', '=', $township_id)
                    ->get();
            
            $suburb_array = array();
            foreach($suburbs as $suburb){
                $suburb_tmp = array("id"=>$suburb->id, "name"=>$suburb->name);
                array_push($suburb_array, $suburb_tmp);
            }
            return $suburb_array;
        }

	public function update($id)
	{
		return View::make('admin.users.form')
			->with('section', 'Modificar Usuario')
			->with('action', 'save-update')
			->with('user', User::find($id))
                        ->with('user_type', UserType::all());
	}

	public function save_update()
	{

		$validator = Validator::make(
			Input::all(),
			array(
				'name' => 'required',
				'patern_name' => 'required',
				'matern_name' => 'required',
				'email' => 'required|email',
				'password' => 'required|confirmed'
			)
		);

		if($validator->fails())
		{
			return Redirect::to('/admin/users/update/'.Input::get('id'))->withInput()->withErrors($validator);
		}

		$user = User::find(Input::get('id'));

		$user->name = Input::get('name');
		$user->patern_name = Input::get('patern_name');
		$user->matern_name = Input::get('matern_name');
		$user->email = Input::get('email');
		
		if(Input::get('password'))
			$user->password = Hash::make(Input::get('password'));

		$user->active = 1;

		$user->save();

		return Redirect::to('/admin/users')->with('message', array(
			'type' => 'success',
			'message' => 'Usuario modificado.'
		));
	}
        
	public function details($id)
	{
            $users = User::find($id);
            $user_type = UserType::find($users->user_type);
		return View::make('admin.users.view')
			->with('section', 'Detalle de Usuario')
			->with('user', $users)
                        ->with('user_type', $user_type)
                ;
	}

	public function delete($id)
	{
		return View::make('admin.users.delete')
			->with('section', 'Eliminar Usuario')
			->with('user', User::find($id));
	}

	public function delete_user()
	{
		$user = User::find(Input::get('id'));

		$user->active = 0;
		$user->save();

		return Redirect::to('/admin/users')->with('message', array(
			'type' => 'success',
			'message' => 'Usuario eliminado.'
		));
	}

    public function get_respondent_identity()
    {
        return RespondentBase::where('identity_document', '=', Input::get('identity_document'))->first();
    }

    public function get_child_users()
    {
        $users = User::find(Input::get('user_id'));

        if($users)
        {
            return $users->users;
        }
        else 
        {
            return array();
        }

        return User::find(Input::get('user_id'));

    }

}