@extends('layouts.app')

@section('content')
    <body class="bg-secondary">
        <div class="container-fluid d-flex justify-content-center mt-5">
            <div class="card shadow bg-dark" style="width: 35rem;">
                <div class="card-body">
                    @foreach($users as $user)
                        <h3 class="text-white text-center">Hi {{$user->name}}!</h3>
                    @endforeach
                    @include('flash-message')
                    <form action="{{route('todo.store')}}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" name="taskname" class="form-control" placeholder="Add a task to do..." aria-label="Add a task" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Add</button>
                            </div>
                        </div>
                    </form>
                    <div class="todo-list">
                        <ul class="list-group">
                            @foreach($todos as $todo)
                                <li class="list-group-item ">
                                    <form action="{{route('todo.delete', $todo->id)}}" method="POST">  
                                        <div class="lineThroughStatus {{ $todo->status == 1 ? 'line-through' : '' }}">{{$todo['name']}}
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-dark btn-sm float-right" type="submit"><i class="fas fa-trash-alt"></i></button>
                                            <a href="edit-task/{{$todo->id}}" class="btn btn-info btn-sm float-right mr-2" role="button" aria-pressed="true"><i class="fas fa-pen"></i></a>
                                            <input class="check-status float-right mt-2 mr-4" id="checkedstatus" type="checkbox" value=1 data-at="{{$todo->id}}" {{ $todo->status == 1 ? 'checked' : '' }}>
                                        </div>             
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('.check-status').change(function () {
                    if ($(this).parent().hasClass('line-through')){
                        $(this).parent().removeClass('line-through')
                    }
                    else {
                        $(this).parent().addClass('line-through')
                    };
                    postToServer($(this).prop('checked'), $(this).attr('data-at'))                                                  
                });
            });
            
            function postToServer(state, id) {
                let value = (state) ? 1 : 0;
                $.ajax({
                    type: "POST",
                    url: "{{route('todo.check')}}",
                    data: {'checkstatus': value, 'todoid': id},
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function() {
                        console.log('success');
                        
                    },
                    error: function(){
                        alert("failure From php side!!!");
                    }
                });                                              
            }
        </script>
    </body>
@endsection