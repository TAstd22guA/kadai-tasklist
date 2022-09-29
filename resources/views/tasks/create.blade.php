@extends('layouts.app')

@section('content')

<h1>プラン新規登録ページ</h1>

    <div class="row">
        <div class="col-6">
            {!! Form::model($task, ['route' => 'tasks.store']) !!}

                <div class="form-group">
                    {!! Form::label('content', 'プラン:') !!}
                    {!! Form::text('content', null, ['class' => 'form-control']) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('status', '作業内容:') !!}
                    {!! Form::text('status', null, ['class' => 'form-control']) !!}
                </div>
                {!! Form::submit('登録', ['class' => 'btn btn-primary']) !!}
　　　　　　　　{!! Form::close() !!}

        </div>
    </div>
@endsection
