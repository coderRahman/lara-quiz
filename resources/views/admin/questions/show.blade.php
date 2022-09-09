@extends("layouts.admin")
@section('content')
  <div class="margin-bottom">
    <!-- Add Question -->
    <button type="button" class="btn btn-wave" data-toggle="modal" data-target="#createModal">
      {{ __('Add Question')}}
    </button>
    <!-- Back Button -->
    <a href="{{route('admin.questions.index')}}" class="btn btn-wave pull-right">
      <i class="fa fa-arrow-left"></i> 
      {{ __('Back') }}
    </a>
  </div>
  
  <!-- Add Question Modal -->
  <div id="createModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
        
          <h4 class="modal-title">Add Question</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        {!! Form::open(['method' => 'POST', 'route' => 'admin.questions.index', 'files' => true]) !!}
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                {!! Form::hidden('quiz_id', $quiz->id) !!}
                <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">                  
                  {!! Form::label('question', 'Question') !!}
                  <span class="required">*</span>
                  {!! Form::textarea('question', null, ['class' => 'form-control', 'placeholder' => 'Please Enter Question', 'rows'=>'8', 'required' => 'required']) !!}
                  <small class="text-danger">{{ $errors->first('question') }}</small>
                </div>
                <div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
                    {!! Form::label('answer', 'Correct Answer') !!}
                    <span class="required">*</span>
                    {!! Form::text('ans',null , ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'like a,b,c']) !!}
                    <small class="text-danger">{{ $errors->first('ans') }}</small>
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
              <div class="col-md-6">
              
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="btn-group pull-right">
              {!! Form::reset("Reset", ['class' => 'btn btn-default']) !!}
              {!! Form::submit("Add", ['class' => 'btn btn-wave']) !!}
            </div>
          </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
  <!-- Add Question Modal End -->

 
  <!-- Index Table -->
  <div class="box">
    <div class="box-body table-responsive">
      <table id="questionsTable" class="table table-hover table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Questions</th>
            <th>A - Option</th>
            <th>B - Option</th>
            <th>C - Option</th>
            <th>D - Option</th>
            <th>E - Option</th>
            <th>F - Option</th>
            <th>Correct Answer</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          
        </tbody>
      </table>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    $(function () {

    var table = $('#questionsTable').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      autoWidth: false,
      scrollCollapse: true,


      ajax: "{{ route('admin.questions.show', $quiz->id) }}",
      columns: [

      {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
      {data: 'question', name: 'question'},
      {data: 'a', name: 'a'},
      {data: 'b', name: 'b'},
      {data: 'c', name: 'c'},
      {data: 'd', name: 'd'},
      {data: 'e', name: 'e'},
      {data: 'f', name: 'f'},
      {data: 'ans', name: 'ans'},
      {data: 'action', name: 'action',searchable: false}

      ],
      dom : 'Bfrtip',
      buttons : [
      'csv','excel','pdf','print'
      ],
      order : [[0,'desc']]
    });

  });
  
  </script>

@endsection