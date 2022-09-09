@extends('layouts.admin')

@section('content')
    <div class="margin-bottom">
      <button type="button" class="btn btn-wave" data-toggle="modal" data-target="#createModal">Add Student</button>
     
    </div>
    
    <!-- Create Modal -->
    <div id="createModal" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
           
            <h4 class="modal-title">Add Student</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          {!! Form::open(['files' => true,'method' => 'POST', 'route' => 'admin.users.store']) !!}
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6 offset-sm-3">
                  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    {!! Form::label('name', 'Student Name') !!}
                    <span class="required">*</span>
                    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Enter Your Name']) !!}
                    <small class="text-danger">{{ $errors->first('name') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    {!! Form::label('email', 'Email address') !!}
                    <span class="required">*</span>
                    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'eg: info@examlpe.com', 'required' => 'required']) !!}
                    <small class="text-danger">{{ $errors->first('email') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    {!! Form::label('password', 'Password') !!}
                    <span class="required">*</span>
                    {!! Form::password('password', ['class' => 'form-control', 'placeholder'=>'Enter Your Password', 'required' => 'required']) !!}
                    <small class="text-danger">{{ $errors->first('password') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                      {!! Form::label('role', 'User Role') !!}
                      <span class="required">*</span>
                     <select name="role" id="" class="select2 form-control">
                       <option value="customer">Customer</option>
                       <option value="admin">Admin</option>
                     </select>
                      <small class="text-danger">{{ $errors->first('role') }}</small>
                  </div>
                  
               
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
    <div class="content-block box">
      <div class="box-body table-responsive">
        <table id="usersTable" class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th> Name</th>
              <th>Email</th>
              <th>User Role</th>
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

    var table = $('#usersTable').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      autoWidth: false,
      scrollCollapse: true,


      ajax: "{{ route('admin.users.index') }}",
      columns: [

      {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
      {data: 'name', name: 'name'},
      {data: 'email', name: 'email'},
      {data: 'role', name: 'role'},
      {data: 'action', name: 'action',searchable: false}
      ],
      dom : 'lBfrtip',
      buttons : [
      'csv','excel','pdf','print'
      ],
      order : [[0,'desc']]
    });

  });
</script>
@endsection
