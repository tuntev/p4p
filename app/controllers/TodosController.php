<?php
/**
 * Created by PhpStorm.
 * User: tunte
 * Date: 11/3/14
 * Time: 2:15 PM
 */
class TodosController extends BaseController{

    public function index(){
        return View::make('Prog4/index');
    }

    public function getDeleteTodo($id){

        $todo = Todo::find($id);

        if(!$todo)
            return false;

        $todo->delete();
    }

    public function update($id)
    {
        $input = Input::get('done');
        $todo = Todo::find($id);

        if(!$todo)
            return false;

        $todo->done = $input;
        $todo->save();

        if($todo)
            return $todo->id;
        else
            return 0;
    }

}