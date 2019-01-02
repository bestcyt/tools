<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VueTodosController extends Controller
{
    /*
     * 原始版todo vue
     */
    public function index(){

        return view('vue.todos.todos');
    }

    /*
     * 简单的组件化todo
     */
    public function component(){

        return view('vue.todos.todos-component');
    }

    public function gettable(){

    }
}
