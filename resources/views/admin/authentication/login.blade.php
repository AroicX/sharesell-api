@extends('admin.layouts.auth')


@section('content')

<div class="conatiner ">
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <div class="row ">
    <div class="col-lg-4 "></div>
    <div class="col-lg-4 ">
      <div class="card_box box_shadow position-relative mb_30">
        
          <div class="white_box_tittle box_body">
            <div class="main-title2 ">
              <h4 class="mb-2 nowrap ">Administrator Login</h4>
          </div>
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/administrator/login') }}">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-lg-12">
                  <label for="email">Email</label>
                  <input type="email" name="email" class="form-control" required>
                </div>
                <div class="col-lg-12">
                  <label for="password">Password</label>
                  <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-lg-12 my-3">
                  <button class="btn btn-primary p-2 btn-block">Login</button>
                </div>
              </div>

            </form>
            
          </div>
      </div>
    <div class="col-lg-4"></div>

  </div>



  </div>
</div>
    
@endsection