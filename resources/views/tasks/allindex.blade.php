use App\Task;

@extends('layouts.app')

@section('content')

   <h1>グループのPlan一覧</h1>
   
   <button class="btn btn-primary" onclick="history.back(-1)">戻る</button>

    @if (count($tasks) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>氏名</th>
                    <th>プラン</th>
                    <th>作業内容</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                  <tr>
                    <td>{{ $task->user->name }}</td>
                    <td>{{ $task->content }}</td>
                    <td>{{ $task->status }}</td>
                  </tr>
                @endforeach
            </tbody>
        </table>
    @endif


@endsection