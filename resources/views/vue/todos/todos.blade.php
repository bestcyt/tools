<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>todo app</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <style>
        .complete{
            color: green;
            text-decoration: line-through;
        }
        .margin-rignt{
            margin-right: 10px;
        }
        .margin-left{
            margin-left: 10px;
        }
    </style>
</head>
<body>

<div class="row" id="todolist">
    <div class="col-md-5">
        <div class="panel panel-default">
            <div class="panel-heading">TODO List  (@{{ todoCount  }})</div>
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item" v-for="(todo,index) in todos" v-bind:class="[ todo.complete ? 'complete':'' ]">@{{ todo.title }}
                        <button class="btn  btn-xs pull-right margin-left" v-bind:class="[ todo.complete ? 'btn-warning':'btn-info' ]" v-on:click="changeitem(todo)" type="button">@{{ todo.complete ? 'undo':'complete'  }}</button>
                        <button class="btn btn-danger btn-xs pull-right margin-left" v-on:click="deleteitem(index)" type="button">delete</button>
                    </li>
                </ul>
            </div>
        </div>
        <form v-on:submit.prevent="additem(newitem)">
            <div class="input-group">
                <input type="text" class="form-control" v-model.trim="newitem.title" placeholder="add item">
                <span class="input-group-btn">
                <button class="btn btn-default" type="submit">Go!</button>
            </span>
            </div>
        </form>

    </div>
</div>


<script src="{{ asset('js/vuejs/vue.js') }}"></script>
<script>
    new Vue({
        el:'#todolist',
        data:{
            'todos':[
                {
                    id:1,
                    title:'first',
                    complete:false
                },
                {
                    id:2,
                    title:'second',
                    complete:false
                }
            ],
            'newitem':{id:null , title:'' , complete:false}
        },
        computed:{
            todoCount(){
                return this.todos.length;
            }
        },
        methods:{
            deleteitem(index){
                this.todos.splice(index,1);
            },
            additem(newitem){
                if (newitem.title.length!=0){
                    this.todos.push(newitem);
                    this.newitem = {id:null , title:'' ,complete:false}
                }
            },
            changeitem(todo){
                todo.complete = !todo.complete;
            }
        }
    });

</script>
</body>
</html>