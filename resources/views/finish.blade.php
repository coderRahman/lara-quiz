@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="home-main-block">
         <button title="Print Report" class="print_btn pull-right btn btn-md btn-default">
              <i class="fa fa-print"></i>
         </button>
         @if($retake)
            <a class="btn btn-primary" id="retake" href="{{ route('start.quiz',$quiz->id) }}">Retake</button>
          @endif
        @if($quiz->show_ans==1)
        
         <div class="question-block hide " id="answers">
            <h2 class="text-center main-block-heading">{{$quiz->name}} ANSWER REPORT</h2>
            <table class="table table-bordered result-table">
              <thead>
                <tr>
                  <th>Question</th>                  
                  
                  <th style="color: green;">Correct Answer</th>
                  <th style="color: red;">Your Answer</th>
                </tr>
              </thead>
              <tbody>
                @foreach($answers  as $ans)
                    <tr>
                      <td>{{ $ans->question->question }}</td>
                      <td>{{ $ans->question->ans }}</td>
                      <td <?php  if($ans->is_correct) {?> style ="color:green"<?php }else { ?>style = "color:red" <?php  }?> >{{ $ans->user_ans }}</td>
                    </tr>
                @endforeach              
              </tbody>
            </table>
            
          </div>
          <button class="btn btn-success" id="showAns">Show Ans</button>
          @endif

          <div class="question-block">
            <h2 class="text-center main-block-heading">{{$quiz->title}} Result</h2>
            <table class="table table-bordered result-table">
              <thead>
                <tr>
                  <th>Total Questions</th>
                  <th>Per Question Mark</th>
                  <th>Total Question Marks</th>
                  <th>My Marks</th>
                 
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>{{$countQues}}</td>
                  <td>{{$quiz->per_question_mark}}</td>
                  <td>{{$quiz->per_question_mark*$countQues}}</td>
                  <td>

                    @php
                      $correct = 0;
                    @endphp

                    @foreach ($answers as $answer)
                      @if ($answer->is_correct)
                        @php
                          $correct++;
                        @endphp
                      @endif
                    @endforeach
                    @php
                    
                    @endphp
                    {{$correct * $quiz->per_question_mark}}
                 
                  </td>
                 
                </tr>
              </tbody>
            </table>
            <h2 class="text-center">Thank You!</h2>
           
          </div>
        </div>
      </div>
    </div>
</div>
@endsection

@section('scripts')
  <script>
    $(document).ready(function(){
      history.pushState(null, null, document.URL);
      window.addEventListener('popstate', function () {
        history.pushState(null, null, document.URL);
      });
    });

    $('.print_btn').click(function(){
      window.print();
    });

    $("#showAns").click(function(event){
       event.preventDefault();
       $("#answers").removeClass("hide");
       $("#retake").addClass("hide")

       $.ajaxSetup({
            headers:
            { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
      });
      
      $.ajax({

          url: "{{ url('/quiz/is-seen')}}",
          method: "post",
          dataType: 'json',
          data:{
            quiz_id: "{{ $quiz->id }}"
          },
          success: function(response){
              console.log(response);
          }
      })

    })
  </script>
@endsection
