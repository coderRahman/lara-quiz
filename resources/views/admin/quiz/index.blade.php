@extends("layouts.admin")
@section('content')
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Quizes</h1>
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
          <div class="col-12">
            <div class="card">
              <div class="card-body">
              <table id="topicsTable" class="table table-hover table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Picture</th>
                        <th>Description</th>
                        <th>Per Question Mark</th>
                        <th>Time</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
            
                    <tbody>
                    
                    </tbody>
                
                  </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>

  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

$(function () {

var table = $('#topicsTable').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    scrollCollapse: true,


    ajax: "{{ route('admin.quizes.index') }}",
    columns: [

    {data: 'DT_RowIndex', name: 'DT_RowIndex',orderable: false, searchable: false},
    {data: 'picture', name: 'picture',orderable: false, searchable: false},
    {data: 'name', name: 'name',searchable: true},
    {data: 'description', name: 'description'},
    {data: 'per_question_mark', name: 'per_question_mark'},
    {data: 'time', name: 'time'},
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