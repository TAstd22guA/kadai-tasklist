@extends('layouts.app')

@section('content')

    <h1><a>{{ Auth::user()->name }}</a>　さんのPlan一覧</h1>

    {{-- メッセージ作成ページへのリンク --}}
    {!! link_to_route('tasks.create', '新規プランの登録', [], ['class' => 'btn btn-primary']) !!}
    {!! link_to_route('tasks.allindex', 'グループ全体のプラン', [], ['class' => 'btn btn-primary']) !!}
 
    @if (count($tasks) > 0)

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>プラン</th>
                    <th>作業内容</th>
                    <th>編集</th>
                    <th>進捗</th>
                    <th>削除</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                
                <tr>
                    {{-- タスク詳細ページへのリンク --}}
                    <td>{!! link_to_route('tasks.show', $task->id, ['task' => $task->id]) !!}</td>
                    <td>{{ $task->content }}</td>
                    <td>{{ $task->status }}</td>
                     {{-- タスク編集ページへのリンク --}}
                    <td> {!! link_to_route('tasks.edit', '編集', ['task' => $task->id], ['class' => 'btn btn-primary']) !!}</td>

                    <td>
                    @if (Auth::user()->is_favorite($task->id))
                    {!! Form::open(['route' => ['favorites.unfavorite', $task->id], 'method' => 'delete']) !!}
                    {!! Form::submit('完了', ['class' => "button btn btn-warning"]) !!}
                    {!! Form::close() !!}
                    @else
                     {!! Form::open(['route' => ['favorites.favorite', $task->id]]) !!}
                     {!! Form::submit('実行中', ['class' => "button btn btn-success"]) !!}
                     {!! Form::close() !!}
                    @endif
                    </td>
                    
                                        {{-- タスク削除フォーム --}}
                    <td>    
                     {!! Form::model($task, ['route' => ['tasks.destroy', $task->id], 'method' => 'delete']) !!}
                     {!! Form::submit('削除', ['class' => 'btn btn-danger']) !!}
                     {!! Form::close() !!}
                    </td>
                    
                    
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif


@endsection