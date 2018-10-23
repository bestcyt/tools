<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>todo app</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>

<div class="row" id="todolist">
    <div class="col-md-5">
        <div class="panel panel-default">
            <div class="panel-heading">TODO List</div>
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item" v-for="(todo,index) in todos">@{{ todo.title }}<button class="btn btn-danger btn-xs pull-right" v-on:click="deleteitem(index)" type="button">delete</button></li>
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
                    title:'first'
                },
                {
                    id:2,
                    title:'second'
                }
            ],
            'newitem':{id:null , title:''}
        },
        methods:{
            deleteitem(index){
                this.todos.splice(index,1);
            },
            additem(newitem){
                if (newitem.title.length!=0){
                    this.todos.push(newitem);
                    this.newitem = {id:null , title:''}
                }
            }
        }
    });

</script>
</body>
</html>