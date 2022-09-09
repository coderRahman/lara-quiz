@extends('layouts.admin')

@section('content')
  <div class="row">
    @if ($quizes)
      @foreach ($quizes as $key => $quiz)
        <div class="col-md-4">
          <div class="quiz-card">
            <h3 class="quiz-name">{{$quiz->name}}</h3>
            <p title="{{$quiz->description}}">
              {{substr($quiz->description, 0,120)}}
            </p>
            <div class="row">
              <div class="col-6 pad-0">
                <ul class="quiz-detail">
                  <li>Per Question Mark <i class="fa fa-long-arrow-right"></i></li>
                  <li>Total Marks <i class="fa fa-long-arrow-right"></i></li>
                  <li>Total Questions <i class="fa fa-long-arrow-right"></i></li>
                  <li>Total Time <i class="fa fa-long-arrow-right"></i></li>
                </ul>
              </div>
              <div class="col-6">
                <ul class="quiz-detail right">
                  <li>{{$quiz->per_question_mark}}</li>
                  <li>
                    @php
                        $qu_count = 0;
                    @endphp
                    @foreach($questions as $question)
                      @if($question->quiz_id == $quiz->id)
                        @php 
                          $qu_count++;
                        @endphp
                      @endif
                    @endforeach
                    {{$quiz->per_question_mark*$qu_count}}
                  </li>
                  <li>
                    {{$qu_count}}
                  </li>
                  <li>
                    {{$quiz->time}} minutes
                  </li>
                </ul>
              </div>
            </div>
            <a href="{{route('admin.reports.show', $quiz->id)}}" class="btn btn-wave">Show Report</a>
          </div>
        </div>
      @endforeach
    @endif
  </div>
@endsection
