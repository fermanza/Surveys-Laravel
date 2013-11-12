<?php
	
class QuestionariesController extends BaseController
{

	public function index($id_questionary)
	{
            $questionaries = Questionary::where('project_id', '=', $id_questionary)
                    ->select('questionary.*', 'project.name as projectname')
                    ->join('project', 'project.id', '=', 'questionary.project_id')
                    ->get();
            return View::make('admin.questionaries.index')
                    ->with('section', 'Cuestionarios')
                    ->with('questionaries', $questionaries);
	}
        
        public function view_projects($id_survey)
        {
            $users = User::where('active', '=', 1)
                    ->select('users.*', 'users_type.description')
                    ->join('users_type', 'users.user_type', '=', 'users_type.id')
                    ->get();
            return View::make('admin.index-surveys.blade.php')
                    ->with('section', 'Encuestas de ')
                    ->with('projects', Project::all());
        }

}