
 @extends('layouts.admin')
@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="clearfix hidden-md-up"></div>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total Users</span>
            <span class="info-box-number">{{ $noUsers }}</span>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Paid Users</span>
            <span class="info-box-number">{{ $paidNoUsers }}</span>
          </div>
        </div>
      </div>
      
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Revenue</span>
            <span class="info-box-number">{{ $income }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endsection