@extends('admin.layouts.layout')


@section('content')

<div class="main_content_iner overly_inner ">
  <div class="container-fluid p-0 ">
      <!-- page title  -->
      <div class="row">
          <div class="col-12">
              <div class="page_title_box d-flex flex-wrap align-items-center justify-content-between">
                  <div class="page_title_left">
                      <h3 class="f_s_25 f_w_700 dark_text" >Product Categories</h3>
                      <ol class="breadcrumb page_bradcam mb-0">
                          <li class="breadcrumb-item"><a href="/administrator/dashboard">Home</a></li>
                          <li class="breadcrumb-item active">Prodcuts</li>
                      </ol>
                  </div>
                  <div class="page_title_right">
                      <div class="page_date_button"  data-toggle="modal" data-target="#addCategoryModal">
                        Add Category 
                      </div>
                      
                  </div>
              </div>
          </div>
      </div>
      

      <div class="main_content_iner ">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="white_card card_height_100 mb_30">
                        <div class="white_card_header">
                            <div class="box_header m-0">
                                
                            </div>
                        </div>
                        <div class="white_card_body">
                            <div class="QA_section">
                                
        
                                <div class="QA_table mb_30">
                                    <!-- table-responsive -->
                                    <table class="table lms_table_active ">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Category ID</th>
                                                <th scope="col">Category Name</th>
                                                <th scope="col">Category Type</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Created_at</th>
                                                <th scope="col"></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                         @foreach ($categories as $key => $category)
                                         <tr>
                                          <th scope="row"> <a href="#" class="question_content"> {{$key + 1}}</a></th>
                                          <td>{{$category->category_id}}</td>

                                          <td>{{$category->category_name}}</td>
                                          <td>{{$category->category_type}}</td>
                                          <td>{{$category->status}}</td>
                                          <td>{{$category->created_at->diffForHumans()}}</td>
                                          <td><div class="dropdown">
                                            <a class="btn btn-danger dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                              Action
                                            </a>
                                          
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px);">
                                              <a class="dropdown-item py-2" href="#">Disable</a>
                                              <a class="dropdown-item py-2" href="#">Delete </a>

                                            </div>
                                          </div></td>
                                         
                                      </tr>
                                    
                                         @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    
                </div>
            </div>
        </div>
    </div>


 




  </div>
</div>
    
@endsection

{{-- add-category-modal --}}
<!-- Modal 3-->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form role="form" method="POST" action="{{ route('product.category.create') }}">
        <div class="row">
            @csrf

          <div class="col-lg-12">
            <div class="form-group">
              <label for="">Category Name</label>
            <input type="text" class="form-control" name="category_name" placeholder="Category Name">
            </div>
          </div>

          <div class="col-lg-12">
            <div class="form-group">
              <label for="">Category Type</label>

            <input type="text" class="form-control" name="category_type" placeholder="Category Type">
            </div>
          </div>

          

          <div class="col-lg-12">
          <button class="btn-block btn-primary p-2 rounded">Submit </button>
          </div>

        </div>
       </form>
      </div>
      {{-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> --}}
    </div>
  </div>
</div>
    {{-- add-category-modal --}}
