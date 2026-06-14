@extends('main')

@section('content')

@foreach($model as $model)
    <div>
        {{ $model->Title }}
    </div>
@endforeach

@endsection