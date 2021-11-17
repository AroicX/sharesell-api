@extends('payments.layout')

@section('content')
<main class="flex w-full">
    <div class="h-auto sideBar md:hidden"></div>
    <div class="flex ml-6 mt-8 main md:flex-col md:ml-4">
      <div class="mr-40 w-max md:w-full md:mr-4">
        <div class="w-max md:w-full">
          <img src="{{ asset('payments/BigImage.png')}}" alt="Current" />
        </div>
        <div class="flex flex-wrap mt-6 gap-4 md:justify-between">
          <img src="{{ asset('payments/image1.png') }}" />
          <img src="{{ asset('payments/image2.png') }}" />
          <img src="{{ asset('payments/image3.png') }}" />
          <img src="{{ asset('payments/image4.png') }}" />
        </div>
      </div>
      <div class="mr-40 md:mr-4">
        <button class="storeButton py-2 px-4 font-semibold md:mt-4">
          Osamudiamen’s Store
        </button>
        <h2 class="text-3xl font-medium my-8">Beautiful Red Summer Gown</h2>
        <p class="font-medium productDescription">Product Discription</p>
        <p class="description text-justify">
          Once upon a time, there was a little girl who lived in a village
          near the forest. Whenever she went out, the little girl wore a red
          riding cloak, so everyone in the village called her Little Red
          Riding Hood.
        </p>
        <div class="flex items-center justify-between mt-6">
          <div>
            <p class="quantity">Quantity</p>
            <div class="flex quantityContainer mt-2">
              <p class="py-1 px-3 controls">-</p>
              <p class="py-1 px-3 value">02</p>
              <p class="py-1 px-3 controls">+</p>
            </div>
          </div>
          <div class="flex flex-col">
            <p class="productPriceTitle">PRODUCT PRICE</p>
            <p class="price">₦24,500</p>
          </div>
        </div>
        <div class="flex flex-col mt-8">
          <h3 class="py-1 mb-6 contact">Contact Details</h3>
          <div
            class="
              flex
              justify-between
              items-center
              mb-12
              md:flex-col md:items-start
            "
          >
            <div class="flex flex-col form-group md:mb-4">
              <label class="bg-white px-1 w-max">First Name</label>
              <input type="text" />
            </div>
            <div class="flex flex-col form-group">
              <label class="bg-white px-1 w-max">Last Name</label>
              <input type="text" class="w-full" />
            </div>
          </div>
          <div
            class="
              flex
              justify-between
              items-center
              mb-12
              md:flex-col md:items-start
            "
          >
            <div class="flex flex-col form-group md:mb-4">
              <label class="bg-white px-1 w-max">Email</label>
              <input type="email" />
            </div>
            <div class="flex flex-col form-group">
              <label class="bg-white px-1 w-max">Phone Numnber</label>
              <input type="text" class="w-full" />
            </div>
          </div>
        </div>
        <div class="flex flex-col mt-8">
          <h3 class="py-1 mb-6 contact">Delivery Details</h3>
          <div
            class="
              flex
              justify-between
              items-center
              mb-12
              md:flex-col md:items-start
            "
          >
            <div class="flex flex-col form-group md:mb-4">
              <label class="bg-white px-1 w-max">Country</label>
              <div class="flex justify-between items-center w-full px-4 pb-4">
                <p class="dropDownItem">Nigeria</p>
                <img src="{{ asset('payments/caret-down.svg') }}" alt="Caret" />
              </div>
            </div>
            <div class="flex flex-col form-group">
              <label class="bg-white px-1 w-max">State</label>
              <div class="flex justify-between items-center w-full px-4 pb-4">
                <p class="dropDownItem">Kaduna</p>
                <img src="{{ asset('payments/caret-down.svg') }}" alt="Caret" />
              </div>
            </div>
          </div>
          <div
            class="
              flex
              justify-between
              items-center
              mb-12
              md:flex-col md:items-start
            "
          >
            <div class="flex flex-col form-group">
              <label class="bg-white px-1 w-max">City</label>
              <div class="flex justify-between items-center w-full px-4 pb-4">
                <p class="dropDownItem">Kaduna South</p>
                <img src="{{ asset('payments/caret-down.svg') }}" alt="Caret" />
              </div>
            </div>
          </div>
          <div class="flex justify-between items-center mb-12">
            <div class="flex flex-col form-group full">
              <label class="bg-white px-1 w-max">Address Line 1</label>
              <input type="text" class="w-full" />
            </div>
          </div>
          <div class="flex justify-between items-center mb-12">
            <div class="flex flex-col form-group full">
              <label class="bg-white px-1 w-max">Address Line 2</label>
              <input type="text" class="w-full" />
            </div>
          </div>
        </div>
        <div class="flex justify-end mb-32">
          <button class="orderButton">Place Order</button>
        </div>
      </div>
    </div>
  </main>   
@endsection