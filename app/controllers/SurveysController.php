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
            return View::make('admin.surveys.form_made')
                    ->with('section', 'Crear Encuestas')
                    ->with('id_questionary', $id_questionary)
                    ->with('action', 'save-create-made-answers');
	}

        public function save_create_made($id_questionary)
        {
            $questions = Question::
                    where('questionary_id', '=', $survey_id)
                    ->get();
            
            $qm = new QuestionaryMade;
            
            $qm->questionary_id = Input::get('id');
            $qm->date = Input::get('date');
            $qm->actitude = Input::get('actitude');
            $qm->incomming = Input::get('incomming');
            $qm->estimated_age = Input::get('estimated_age');
            $qm->latitude = Input::get('latitude');
            $qm->longitude = Input::get('longitude');
            $qm->url_facade = Input::get('url_facade');
            
            $qm->save();
            
            $questions = Question::
                    where('questionary_id', '=', $id_questionary)
                    ->get();
            $answers = array();
            foreach($questions as $question){
                $answers[$question->id] = Answer::
                    where('question_id', '=', $question->id)
                    ->get();
            }
            return View::make('admin.surveys.form_made')
                    ->with('section', 'Crear Encuestas')
                    ->with('questions', $questions)
                    ->with('id_questionary', $id_questionary)
                    ->with('answers', $answers)
                    ->with('action', 'save-create-made');
        }
                
        
	public function save_create_made_answers()
	{
//
//		$validator = Validator::make(
//                    Input::all(),
//                    array(
//                        'name' => 'required',
//                        'patern_name' => 'required',
//                        'matern_name' => 'required',
//                        'email' => 'required|email|unique:users',
//                        'password' => 'required|confirmed',
//                        'user_type' => 'required'
//                    )
//		);
//
//		if($validator->fails())
//		{
//                    return Redirect::to('/surveys/new_survey')->withInput()->withErrors($validator);
//		}

//		$qma = new QuestionaryMadeAnswers;
//		$qma->questionary_id = Input::get('id');
//		$qma->time = Input::get('patern_name');
//		$qma->date = Input::get('matern_name');
//		$qma->actitude = Input::get('email');
//		$qma->incomming = Hash::make(Input::get('password'));
//		$qma->estimated_age = Input::get('email');
//                $qma->latitude = Input::get('user_type');
//                $qma->longitude = Input::get('user_type');
//                $qma->respondent_id = Input::get('user_type');
//                $qma->url_facade = Input::get('');
//		$qma->save();
                
                $survey_id = Input::get('id');
                $questions = Question::
                    where('questionary_id', '=', $survey_id)
                    ->get();
                $answers_radio = Input::get('answers_radio');
                foreach($questions as $question){
                    $qma = new QuestionaryMadeAnswers;
                    
                    //$qma->questionary_made_id = Input::get('questionary_made_id');
                    $qma->questionary_made_id = 1;
                    $qma->answer_id = $answers_radio[$question->id];
                    $qma->answer = "";
                    $qma->which = "";
                    $qma->question_id = $question->id;
                    $qma->save();
                }

		return Redirect::to('/admin/surveys/'.$survey_id)->with('message', array(
                    'type' => 'success',
                    'message' => 'Encuesta creada.'
		));
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

	public function profile()
	{
		return View::make('admin.users.profile')
			->with('section', 'Perfil')
			->with('user', Auth::user());
	}

	public function save_profile()
	{

		$validator = Validator::make(
			Input::all(),
			array(
				'name' => 'required',
				'patern_name' => 'required',
				'matern_name' => 'required',
				'email' => 'required|email',
				'password' => 'confirmed'
			)
		);

		if($validator->fails())
		{
			return Redirect::to('/admin/profile')->withInput()->withErrors($validator);
		}

		$user = Auth::user();

		$user->name = Input::get('name');
		$user->patern_name = Input::get('patern_name');
		$user->matern_name = Input::get('matern_name');
		$user->email = Input::get('email');
		
		if(Input::get('password'))
			$user->password = Hash::make(Input::get('password'));

		$user->active = 1;

		$user->save();

		return Redirect::to('/admin/profile')->with('message', array(
			'type' => 'success',
			'message' => 'Perfil actualizado.'
		));
	}

}