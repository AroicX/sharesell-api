@extends('admin.layouts.auth') @section('content')

<div class="conatiner">
    <br />

    <style>
        .card_box,
        .white_box_tittle {
            border-radius: 5px !important;
        }
        .text-bold {
            font-size: 16px;
            font-weight: 700;
            margin: 1rem 0;
            color: #242424;
        }
    </style>

    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-5">
            <div class="card_box position-relative mb_30">
                <div class="white_box_tittle box_body">
                    <div class="main-title2">
                        <h4 class="mb-2 nowrap">Checkout Form</h4>
                    </div>
                    <form
                        class="form-horizontal"
                        role="form"
                        method="POST"
                        action="{{ url('/administrator/login') }}"
                    >
                        {{ csrf_field() }}
                        @if ($errors->any())
                        <div class="alert alert-warning">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="fullname">Fullname</label>
                                <input
                                    type="text"
                                    name="fullname"
                                    class="form-control"
                                    required
                                />
                            </div>
                            <div class="col-lg-12">
                                <label for="email">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    required
                                />
                            </div>
                            <div class="col-lg-12">
                                <label for="phone">Phone Number</label>
                                <input
                                    type="text"
                                    name="phone"
                                    class="form-control"
                                    required
                                />
                            </div>
                            <div class="col-lg-12">
                                <label for="address">Address</label>
                                <textarea
                                    type="text"
                                    name="address"
                                    class="form-control"
                                    required
                                ></textarea>
                            </div>
                            <div class="col-lg-12">
                                <label for="destination_state"
                                    >Destination State</label
                                >
                                <select
                                    type="text"
                                    name="destination_state"
                                    class="form-control"
                                    id="destination_state"
                                    required
                                >
                                    <option value="">Select State</option>
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label for="destination_city"
                                    >Destination City</label
                                >
                                <select
                                    type="text"
                                    name="destination_city"
                                    class="form-control"
                                    required
                                    id="destination_city"
                                >
                                    <option value="">Select City</option>
                                </select>
                            </div>

                            <div class="col-lg-12 my-3">
                                <button class="btn btn-primary p-2 btn-block">
                                    Pay Now
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card_box position-relative">
                <div class="white_box_tittle box_body">
                    <div class="main-title2">
                        <h4 class="mb-2 nowrap">Product Description</h4>

                        <img src="https://via.placeholder.com/250x250" alt="" />
                        <p class="text-bold">Product Name: <b>Beaine</b></p>
                        <p class="text-bold">
                            Product Category: <b>Men's Fashion Clothings</b>
                        </p>
                        <p class="text-bold">Product Amount: <b>$20</b></p>
                        <p class="text-bold">Product Weight: <b>2kg</b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection @section('scripts')
<script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"
></script>
<script>
    var state_and_capitals = [];
    let DState = $("#destination_state");
    let DCity = $("#destination_city");

    $(document).ready(function () {
        $.ajax({
            dataType: "json",
            url: "http://shareshell.test/js/state-and-capitals.json",
            success: function (response) {
                state_and_capitals = response;
                response.map((data, key) => {
                    DState.append(
                        $("<option />")
                            .val(data.state.name)
                            .text(data.state.name)
                    );
                });
            },
        });

        DState.on("change", function () {
            DCity.html("");
            let value = $(this).val();
            let result = state_and_capitals.filter(
                (data) => data.state.name === value
            );

            const { state } = result[0];
            const { locals } = state;

            locals.map((city, key) => {
                DCity.append($("<option />").val(city.name).text(city.name));
            });
        });
    });
</script>

@endsection
