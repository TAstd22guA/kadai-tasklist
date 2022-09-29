@extends('layouts.app')

@section('content')

    <h1>id = {{ $task->id }} のプラン詳細ページ</h1>

    <table class="table table-bordered">
        <tr>
            <th>id</th>
            <td>{{ $task->id }}</td>
        </tr>
        <tr>
            <th>プラン</th>
            <td>{{ $task->content }}</td>
        </tr>
        <tr>
            <th>作業内容</th>
            <td>{{ $task->status }}</td>
        </tr>

    </table>

　　<table>
    <td>{!! link_to_route('tasks.edit', 'このプランを編集', ['task' => $task->id], ['class' => 'btn btn-secondary']) !!}</td>
    <td>{!! Form::model($task, ['route' => ['tasks.destroy', $task->id], 'method' => 'delete']) !!}
          {!! Form::submit('削除', ['class' => 'btn btn-danger']) !!}
          {!! Form::close() !!}
    </td>
    <td><button class="btn btn-primary" onclick="history.back(-1)">戻る</button></td>
 　 </table>


@endsection