<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VueTodosController extends Controller
{
    //
    public function index(){

        return view('vue.todos.todos');
    }
}
