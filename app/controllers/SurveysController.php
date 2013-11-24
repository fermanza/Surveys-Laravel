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
                    ->with('action', 'save-create-made');
	}

        public function save_create_made()
        {
            $questionary_made = new QuestionaryMade();
            $questionary_made->questionary_id = Input::get('id');
            $questionary_made->date = Input::get('date');
            $questionary_made->actitude = Input::get('actitude');
            $questionary_made->incomming = Input::get('incomming');
            $questionary_made->estimated_age = Input::get('estimated_age');
            $questionary_made->latitude = Input::get('latitude');
            $questionary_made->longitude = Input::get('longitude');
            
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
            
            return View::make('admin.surveys.form_made_answers')
                    ->with('section', 'Crear Encuestas')
                    ->with('questions', $questions)
                    ->with('id_questionary', Input::get('id'))
                    ->with('questionary_made_id', $questionary_made->id)
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
                $qma = new QuestionaryMadeAnswers;

                $qma->questionary_made_id = Input::get('questionary_made_id');
                $qma->answer_id = $answers_radio[$question->id];
                $qma->answer = "";
                $qma->which = "";
                $qma->question_id = $question->id;
                $qma->save();
            }
            if(Input::get('form_respondent')==2){
                // Don't show respondents questionary
                return Redirect::to('/admin/surveys/'.$questionary_id)->with('message', array(
                    'type' => 'success',
                    'message' => 'Encuesta creada.'
                ));
            }
            
            // Show respondents questionary
            return View::make('admin.surveys.form_respondents')
                    ->with('section', 'Crear Encuestas')
                    ->with('id_questionary', $questionary_id)
                    ->with('questionary_made_id', Input::get('questionary_made_id'))
                    ->with('action', 'save-create-respondents');
	}
        
        public function save_create_respondents(){
            
            $questionary_id = Input::get('id');
            
            $respondent = new Respondent;

            $respondent->name = Input::get('name');
            $respondent->patern_name = Input::get('patern_name');
            $respondent->matern_name = Input::get('matern_name');
            $respondent->birth_date = Input::get('birth_date');
            $respondent->sex = Input::get('sex');
            $respondent->phone = Input::get('phone');
            $respondent->cellphone = Input::get('cellphone');
            $respondent->state = Input::get('state');
            $respondent->district = Input::get('district');
            $respondent->township = Input::get('township');
            $respondent->section = Input::get('section');
            $respondent->cologne = Input::get('cologne');
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

}