

<!-- main content part here -->
 
 <!-- sidebar  -->
 <nav class="sidebar">
  <div class="logo d-flex justify-content-between">
      <a class="large_logo" href="index-2.html"><img src="{{asset('img/logo.png')}}" alt=""></a>
      <a class="small_logo" href="index-2.html"><img src="{{asset('img/mini_logo.png')}}" alt=""></a>
      <div class="sidebar_close_icon d-lg-none">
          <i class="ti-close"></i>
      </div>
  </div>
  <ul id="sidebar_menu">
      <li>
          <a href="index-2.html" aria-expanded="false">
              <div class="nav_icon_small">
                  <img src="{{asset('img/menu-icon/dashboard.svg')}}" alt="">
              </div>
              <div class="nav_title">
                  <span>Analytic</span>
              </div>
          </a>
      </li>
      <h4 class="menu-text"><span>Products</span> <i class="fas fa-ellipsis-h"></i> </h4>
      <li class="">
        <a class="has-arrow" href="#" aria-expanded="false">
            <div class="nav_icon_small">
                <img src="{{asset('img/menu-icon/5.svg')}}" alt="">
            </div>
            <div class="nav_title">
                <span>Products </span>
            </div>
        </a>
        <ul class="mm-collapse" style="height: 5px;">
          <li><a href="{{route('product.category')}}">Add Category</a></li>
          <li><a href="mail_box.html">Add Product</a></li>
     
        </ul>
    </li>
    </ul>
</nav>
<!--/ sidebar  -->
