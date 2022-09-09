@extends("layouts.admin")
@section('content')
@php 
use Illuminate\Support\Str;

@endphp
 

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Quiz List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Quizes</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <div class="row">
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
                  <li>Total Submission <i class="fa fa-long-arrow-right"></i></li>
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
                  </li>
                   <li>
                   {{ $quiz->answers->unique("user_id")->count()}}
                   </li>
                </ul>
              </div>
            </div>
            <a href="{{route('admin.questions.show', $quiz->id)}}" class="btn btn-primary">Add Questions</a>
          </div>
        </div>
      @endforeach
    @endif
  </div>
      </div>
    </section>


@endsection