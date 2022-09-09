@extends('layouts.app')

@section('top_bar')
  <nav class="navbar navbar-default navbar-static-top">
    <div class="nav-bar">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="navbar-header">
              <!-- Branding Image -->
              @if($quiz)
                <h4 class="heading">{{$quiz->title}}</h4>
              @endif
            </div>
          </div>
          <div class="col-md-6">
            <div class="collapse navbar-collapse" id="app-navbar-collapse">              
              <!-- Right Side Of Navbar -->
              <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                <li id="clock"></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>

@endsection

@section('content')
@php
    use Illuminate\Support\Facades\Auth;
@endphp

<div class="container">
    <div class="home-main-block">
        
        <div id="question_block" class="question-block">
          <div class="main-questions" >
          @php
              $index =0;
              @endphp
            @foreach($questions as $question)
              @php
                $index++;
            @endphp
            <div class="myQuestion" style="display:none">
              <div class="row">
                <div class="col-md-6">
                  <blockquote>
                    Total Questions &nbsp;&nbsp;{{ $index }} / {{ count($questions)}}
                  </blockquote>
                  <h2 class="question">Q. &nbsp;{{ $question->question}}</h2>
                  <form class="myForm" method="post">

                      <input type="checkbox" class="a"  value="a"   onchange='setInput({{ $question->id}},"a")'> <span>{{ $question->a}}</span><br/>

                      <input type="checkbox" class="b"  value="b" onchange='setInput({{ $question->id}},"b")'> <span>{{ $question->b}}</span><br/>

                      <input type="checkbox" class="c" value="c" onchange='setInput({{ $question->id}},"c")' > <span>{{ $question->c}}</span><br/>

                      <input    type="checkbox" class="d" value="d" onchange='setInput({{ $question->id}},"d")'> <span>{{ $question->d}}</span><br/>

                      @if($question->e)
                      <input   type="checkbox" class="e"  value="e" onchange='setInput({{ $question->id}},"e")'> <span>{{ $question->e}}</span><br>
                      @endif

                      @if($question->f)
                      <input type="checkbox" class="f"  value="f" onchange='setInput({{ $question->id}},"f")'> <span>{{ $question->f}}</span><br>
                      @endif

                      <div class="row">
                          <div class="col-md-6 col-8">
                              <p  class="hide ans fs-1 ms-2 bg-success text-white text-center">{{ $question->ans}} </p>
                          </div>
                      </div>

                      <div class="row">
                        <div class="col-md-6 col-8">
                          <button type="button" class="hide btn btn-wave btn-block showAnsBtn" >Show Ans</button>
                          <button type="button" class="btn btn-wave btn-block submitBtn" >Submit</button>
                          <button type="button" class="hide btn btn-wave btn-block nextBtn" >Next</button>
                        </div>
                      </div>
                  </form>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>

        @if(empty($questions))
        <div class="alert alert-danger">
          <p>
            No Questions in this quiz <b> {{$quiz->title}} </b>
          </p>
          <p>
            <a class="text-danger" href="{{ url('/home')}}"> <u> <i class="fa fa-home" aria-hidden="true"></i> Return Home </u> </a>
          </p>
        </div>
        @endif

    </div>
</div>
@endsection
@section('scripts')
  <!-- jQuery 3 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"> </script>
  <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js"></script>
<script>
  var quiz_id = {{$quiz->id}};
  var user_id = {{ auth()->user()->id }}
  var timer = {{$quiz->time}};
  var is_time_questions = {{ $quiz->is_time_questions}}
  var show_each_ans = {{ $quiz->show_each_ans }}
  var question_id;
  var  ans="";

    // set the input  value
  function setInput(questionId, value)
  {
      question_id = questionId;
      if($("."+value+":checked").prop("checked")){
          ans += value;
      }
      else{
          ans = ans.replace(value,'')
      }
  }



  $(document).ready(function() {

      // csrf token setup for ajax request
      $.ajaxSetup({
            headers:
            { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
      });

     // stop f5
     function fFive(e) {
          (116 == (e.which || e.keyCode) || 82 == (e.which || e.keyCode)) && e.preventDefault()
      }

      $(document).on("keydown", fFive);

      // Disable inspect element
      $(document).bind("contextmenu",function(e) {
        e.preventDefault();
      });
  
      $(".myQuestion:first-child").addClass("active");

      history.pushState(null, null, document.URL); 
      window.addEventListener("popstate", function() {
          history.pushState(null, null, document.URL)
      });

      // handle submit form 

      $(".submitBtn").click(function(event){
          event.preventDefault();

            // sent data to server
          const input = {
            quiz_id,
            question_id,
            user_ans:ans,
            user_id
          };


          $.ajax({

              url: "{{ url('quiz/ans-store')}}",
              method: "post",
              dataType: 'json',
              data: input,

              success: function(response){
                  console.log(response);
              }

          })

          //show, hide buttons and ans
          $(".nextBtn").removeClass("hide");
          if(show_each_ans){
             $(".showAnsBtn").removeClass("hide");
             $(".showAnsBtn").click(function(){
                 $(".ans").removeClass("hide");
             })
          }
          $(".submitBtn").addClass("hide");

      })
      

      // handle next button 

      $(".nextBtn").click(function(event) {
          event.preventDefault();
           
          // reset previous ans;
          ans = "";

          // button show and hide 
          $(".nextBtn").addClass("hide");
          $(".showAnsBtn").addClass("hide");
          $(".ans").addClass("hide");
          $(".submitBtn").removeClass("hide");


          var e = $(".myQuestion.active");
          if($(e).next().next().length==0){
            $("#nextBtn").html("Show Result");
          }
          // after the end time go to quiz finish page
          if($(e).removeClass("active"), 0 == $(e).next().length){
                
                Cookies.remove("time"),
                Cookies.set("done", "Your Quiz is Over...!", {
                  expires: 1
                });

               location.href = "{{$quiz->id}}/finish"
          }else
          {
   
            $(e).next().addClass("active")
            $(".myForm")[0].reset()

          }

            // if time set for each question update timer
          if(!is_time_questions){
            var i, o = (new Date).getTime() + 6e4 * timer;
            $("#clock").countdown(o, {
                  elapse: !0
              }).on("update.countdown", function(e) {
                var i = $(this);
                e.elapsed ? (Cookies.set("done", "Your Quiz is Over...!", {
                    expires: 1
                }), 
                Cookies.remove("time"),
                location.href = "{{$quiz->id}}/finish"

              ) : i.html(e.strftime("<span>%H:%M:%S</span>"))
              })
          }

      });

   
      // timer setting

      var i, o = (new Date).getTime() + 6e4 * timer;

      if (Cookies.get("time") && Cookies.get("quiz_id") == quiz_id) {
          i = Cookies.get("time");
          var t = o - i,
              n = o - t;

              $("#clock").countdown(n, {
                elapse: !0
            }).on("update.countdown", function(e) {
              var i = $(this);
              e.elapsed ? (Cookies.set("done", "Your Quiz is Over...!", {
                  expires: 1
              }), 
              Cookies.remove("time"),
              location.href = "{{$quiz->id}}/finish"

            ) : i.html(e.strftime("<span>%H:%M:%S</span>"))
            })
      } 
      else{ 

          Cookies.set("time", o, {
            expires: 1
          }); 
        
          Cookies.set("quiz_id", quiz_id, {
              expires: 1
          });
          
          $("#clock").countdown(o, {
              elapse: !0
          }).on("update.countdown", function(e) {
            var i = $(this);
            e.elapsed ? (Cookies.set("done", "Your Quiz is Over...!", {
                expires: 1
            }), 
            Cookies.remove("time"),
            location.href = '{{ $quiz->id }}/finish'

            ) : i.html(e.strftime("<span>%H:%M:%S</span>"))
          })
      
      }
    
  });

  </script>

@endsection
