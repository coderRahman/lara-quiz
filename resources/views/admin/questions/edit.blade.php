@extends('layouts.admin')

@section('content')
  <div class="box">
    <div class="box-body">
        <h3>Edit Question
          <a href="{{route('admin.questions.show', $quiz->id)}}" class="btn btn-gray pull-right">
            <i class="fa fa-arrow-left"></i> 
            {{ __('Back') }}
          </a>
        </h3>
      <hr>
       {!! Form::model($question, ['method' => 'PATCH', 'route' => ['admin.questions.update', $question->id], 'files' => true]) !!}
                     
        <div class="row">
          <div class="col-md-4">
            {!! Form::hidden('quiz_id', $quiz->id) !!}
            <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">
              {!! Form::label('question', 'Question') !!}
              <span class="required">*</span>
              {!! Form::textarea('question', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Question', 'rows'=>'8', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('question') }}</small>
            </div>

            <div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
                {!! Form::label('ans', 'Correct Answer') !!}
                <span class="required">*</span>
                {!! Form::text('ans',null, ['class' => 'form-control select2', 'required' => 'required', 'placeholder'=>'']) !!}
                <small class="text-danger">{{ $errors->first('answer') }}</small>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group{{ $errors->has('a') ? ' has-error' : '' }}">
              {!! Form::label('a', 'A - Option') !!}
              <span class="required">*</span>
              {!! Form::text('a', null, ['class' => 'form-control', 'placeholder' => 'Please Enter A Option', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('a') }}</small>
            </div>

            <div class="form-group{{ $errors->has('b') ? ' has-error' : '' }}">
              {!! Form::label('b', 'B - Option') !!}
              <span class="required">*</span>
              {!! Form::text('b', null, ['class' => 'form-control', 'placeholder' => 'Please Enter B Option', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('b') }}</small>
            </div>

            <div class="form-group{{ $errors->has('c') ? ' has-error' : '' }}">
              {!! Form::label('c', 'C - Option') !!}
              <span class="required">*</span>
              {!! Form::text('c', null, ['class' => 'form-control', 'placeholder' => 'Please Enter C Option', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('c') }}</small>
            </div>
            
            <div class="form-group{{ $errors->has('d') ? ' has-error' : '' }}">
              {!! Form::label('d', 'D - Option') !!}
              <span class="required">*</span>
              {!! Form::text('d', null, ['class' => 'form-control', 'placeholder' => 'Please Enter D Option', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('d') }}</small>
            </div>

            <div class="form-group{{ $errors->has('e') ? ' has-error' : '' }}">
              {!! Form::label('e', 'E - Option') !!}
              {!! Form::text('e', null, ['class' => 'form-control', 'placeholder' => 'Please Enter E Option']) !!}
              <small class="text-danger">{{ $errors->first('e') }}</small>
            </div>

            <div class="form-group{{ $errors->has('f') ? ' has-error' : '' }}">
              {!! Form::label('f', 'F - Option') !!}
              {!! Form::text('f', null, ['class' => 'form-control', 'placeholder' => 'Please Enter F Option']) !!}
              <small class="text-danger">{{ $errors->first('f') }}</small>
            </div>

          </div>
        </div>
        <div class="btn-group pull-right">
          {!! Form::submit("Update", ['class' => 'btn btn-wave']) !!}
        </div>
    {!! Form::close() !!}
  </div>
</div>
@endsection