@extends("layouts.admin")
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Quiz
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Quiz</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="{{ route('admin.quizes.update',$quiz->id) }}"
                                method="post">
                                @csrf
                                @method("put")
                                <div class="row">
                                    <div class="col-md-6">
                                        <div
                                            class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                            <lable>Quiz Name</lable>
                                            <span class="required">*</span>
                                            <input type="text" name="name" value="{{ $quiz->name }}"
                                                class="form-control" placeholder="Please Enter Quiz Name">
                                            <small
                                                class="text-danger">{{ $errors->first('name') }}</small>
                                        </div>

                                        <div
                                            class="form-group{{ $errors->has('picture') ? ' has-error' : '' }}">
                                            <lable>Quiz Picture</lable>
                                            <span class="required">*</span>
                                            <input type="file" name="picture" class="form-control">
                                            <small
                                                class="text-danger">{{ $errors->first('picture') }}</small>
                                        </div>

                                        <div
                                            class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                            <label>Description</label>
                                            <textarea name="description" class="form-control"
                                                placeholder="Please Enter Quiz Description">{{ $quiz->description }}</textarea>

                                            <small
                                                class="text-danger">{{ $errors->first('description') }}
                                            </small>
                                        </div>

                                        <div
                                            class="form-group{{ $errors->has('per_question_mark') ? ' has-error' : '' }}">
                                            <lable>Per Question Mark</lable>
                                            <span class="required">*</span>
                                            <input type="number" name="per_question_mark" value="{{ $quiz->per_question_mark }}"
                                                class="form-control" placeholder="Please Enter Per Question Mark" />

                                            <small
                                                class="text-danger">{{ $errors->first('per_question_mark') }}</small>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="form-group{{ $errors->has('time') ? ' has-error' : '' }}">
                                            <lable>Quiz Time (in minutes)</lable>
                                            <input type="number" name="time" value="{{ $quiz->time }}"
                                                class="form-control" />
                                            <small
                                                class="text-danger">{{ $errors->first('time') }}
                                            </small>
                                        </div>

                                        <div class="form-group{{ $errors->has('is_time_questions') ? ' has-error' : '' }}">
                                            <lable>Is Time  for All Questions</lable>
                                            <select name="is_time_questions" class="form-control">
                                                <option  {{ $quiz->is_time_questions==1? "selected":""}} value="1">Yes</option>
                                                <option  {{ $quiz->is_time_questions==0? "selected":""}}value="0">No</option>
                                            </select>
                                            <small class="text-danger">{{ $errors->first('is_time_questions') }}</small>
                                        </div>

                                        <div class="form-group{{ $errors->has('number_of_taken') ? ' has-error' : '' }}">
                                            <lable>Number Of Taken</lable>
                                            <input type="number" name="number_of_taken" value="{{ $quiz->number_of_taken }}" class="form-control" />
                                            <small class="text-danger">{{ $errors->first('number_of_taken') }}</small>
                                        </div>

                                        <label>Quiz Price:</label>
                                        <input type="checkbox" name="quiz_price" class="price-show"
                                            {{ $quiz->price !=0  ? "checked" : "" }}
                                                id="toggle">
                                        <label for="toggle"></label>

                                        <div style="{{ $quiz->price == 0 ? 'display: none' : '' }}"
                                            id="doabox">
                                            <label for="dob">Choose Quiz Price: </label>
                                            <div
                                                class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                                <input name="price" id="doa" type="text" value="{{ $quiz->price }}"
                                                    class="form-control" placeholder="Please Enter Quiz Price">
                                                <small
                                                    class="text-danger">{{ $errors->first('price') }}</small>
                                            </div>
                                        </div>
                           
                                        <div
                                            class="form-group {{ $errors->has('show_ans') ? ' has-error' : '' }}">
                                            <label for="">Enable Show Answer: </label>
                                            <input type="checkbox"
                                                {{ $quiz->show_ans ==1 ? "checked" : "" }}
                                                class="toggle-input" name="show_ans" id="toggle2">
                                            <label for="toggle2"></label>
                                            <br>
                                        </div>

                                        <div
                                            class="form-group {{ $errors->has('show_each_ans') ? ' has-error' : '' }}">
                                            <label for=""> Show Each Question Answer: </label>
                                            <input type="checkbox"
                                                {{ $quiz->show_each_ans ==1 ? "checked" : "" }}
                                                class="toggle-input" name="show_each_ans" id="toggle2">
                                            <label for="toggle2"></label>
                                            <br>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <div class="btn-group pull-right">
                                            <button type="submit" class="btn btn-primary">Update </button>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script type="text/javascript">

  $(function() {
    $('#fb_check').change(function() {
      $('#fb').val(+ $(this).prop('checked'))
    })
  })

              
$(document).ready(function(){
  $('.price-show').change(function(){
    if ($('.price-show').is(':checked')){
        $('#doabox').show('fast');
    }else{
        $('#doabox').hide('fast');
    }
  });

});
                            

function showprice(id)
{
  if ($('#toggle2'+id).is(':checked')){
    $('#doabox2'+id).show('fast');
  }else{

    $('#doabox2'+id).hide('fast');
  }
}

</script>

@endsection
