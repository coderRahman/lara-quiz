@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
   <div class="col-12">
      @if(Session::has('error'))
          <div class="alert alert-danger text-center">
              <p class="fs-2">{{ Session::get('error') }}</p>
          </div>
      @endif
   </div>

    @if ($quizes)
      @foreach ($quizes as $key => $quiz)
        <div class="col-md-4">
          <div class="quiz-card">
            <h3 class="quiz-name">{{$quiz->name}}</h3>
            <p title="{{$quiz->description}}">
              {{ Str::limit($quiz->description, 120)}}
            </p>
            <div class="row">
              <div class="col-sm-6 pad-0">
                <ul class="quiz-detail">
                  <li>Per Question Mark <i class="fa fa-long-arrow-right"></i></li>
                  <li>Total Marks <i class="fa fa-long-arrow-right"></i></li>
                  <li>Total Questions <i class="fa fa-long-arrow-right"></i></li>
                  <li>Total Time <i class="fa fa-long-arrow-right"></i></li>
                  <li  class="mt-5">Total Taken <i class="fa fa-long-arrow-right"></i></li>
                </ul>
              </div>
              <div class="col-sm-6">
                <ul class="quiz-detail right">
                  <li>{{$quiz->per_question_mark}}</li>
                  <li> {{ $quiz->per_question_mark * $quiz->totalQuestions?->no_questions}}</li>
                  <li>
                    {{$quiz->totalQuestions?$quiz->totalQuestions?->no_questions:"0"}}
                  </li>
                  <li>
                    {{$quiz->time}} minutes({{$quiz->full_quiz_time? "All Questions":"Per Question"}})
                  </li class="mt-5">
                  <li> {{ $quiz->answers->unique("user_id")->count()}}
                </ul>
              </div>

               <div class="card text-center">
                    @if(auth()->user()?->quizes()->where('quiz_id', $quiz->id)->exists())
                      <a href="{{route('start.quiz', ['id' => $quiz->id])}}" class="btn btn-block" title="Start Quiz">Start Quiz </a>
                    @else
                      {!! Form::open(['method' => 'POST', 'route' => 'login']) !!} 
                        {{ csrf_field() }}
                        <input type="hidden" name="quiz_id" value="{{$quiz->id}}"/>
                         @if(!empty($quiz->price)) 

                        <a href="{{ url('pay/'.$quiz->id) }}" class="btn btn-default">Pay  <i class=""></i>{{$quiz->price}}</a>
                          @else 

                        <a href="{{route('start.quiz', ['id' => $quiz->id])}}" class="btn btn-block" title="Start Quiz">Start Quiz </a>

                        @endif

                      {!! Form::close() !!}
                    @endif
                  </div>
            </div>
            </div>
        </div>
          @endforeach
        @endif
  </div>
</div>
@endsection

