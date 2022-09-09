@extends("layouts.customer")
@section('content')
 

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Transactions</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Transactions</li>
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
         
              <!-- /.card-header -->
              <div class="card-body">
              <table id="topicsTable" class="table table-hover table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Quiz Name</th>
                        <th>Amount</th>
                        <th>Status</th>
                      </tr>
                    </thead>
            
                    <tbody>
                           @foreach($trans as $tran)
                            <tr>
                                 <td>{{ $loop->iteration }}</td>
                                 <td> {{ $tran->quiz->name }} </td>
                                 <td> {{ $tran->amount }}  </td>
                                 <td> {{ $tran->status }} </td>
                            </tr>
                            @endforeach
                    </tbody>
                
                  </table>
              </div>
              <!-- /.card-body -->
                {{ $trans->links()}}
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
