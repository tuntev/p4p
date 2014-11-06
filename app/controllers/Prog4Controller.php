<?php
/**
 * Created by PhpStorm.
 * User: tunte
 * Date: 11/4/14
 * Time: 2:16 PM
 */
class Prog4Controller extends BaseController{

    public function index(){

        return View::make('Prog4/index');

    }

    public function getProjects(){
        $projects = P4Project::all();
        return $projects;
    }

    public function getProjectById($id){
        $project = P4Project::find($id);
        if($project){
            return $project;
        }
        else {
            return Response::json(['message'=>'project not found']);
        }

    }

    public function updateDone($id)
    {
        $input = Input::get('done');
        $project = P4Project::find($id);

        if(!$project)
            return false;

        $project->done = $input;
        $project->save();

        if($project)
            return $project->id;
        else
            return 0;
    }

    public function postAddNew(){

        $project = P4Project::create(array(
            'title' => Input::get('title'),
            'student' => Input::get('student'),
            'done' => 0
        ));

        if($project){
            return $project->id;
        }
        else {
            return Response::json(['message'=>'Problem with adding new project']);;
        }
    }

    public function getDeleteProject($id){

        $project = P4Project::find($id);

        if(!$project)
            return false;

        $project->delete();
    }

}