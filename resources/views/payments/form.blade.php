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
            font-weight: 400;
            margin: 1rem 0;
            color: #242424;
        }
        .flex {
            display: flex;
            flex-direction: row;
        }
        .btns {
            position: relative;
            width: 30px !important;
            height: 30px !important;
            background: #999;
            color: aliceblue;
            border: none !important;
            border-radius: 3px;
            outline: none !important;
            margin: 0 1rem;
        }
        .aj {
            margin-top: 15px !important;
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
                    <form class="form-horizontal">
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
                                    id="fullname"
                                    type="text"
                                    name="fullname"
                                    class="form-control"
                                    value=""
                                    required
                                />
                            </div>
                            <div class="col-lg-12">
                                <label for="email">Email</label>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    value=""
                                    required
                                />
                            </div>
                            <div class="col-lg-12">
                                <label for="phone">Phone Number</label>
                                <input
                                    id="phone"
                                    type="text"
                                    name="phone"
                                    class="form-control"
                                    value=""
                                    required
                                />
                            </div>
                            <div class="col-lg-12">
                                <label for="address">Address</label>
                                <textarea
                                    id="address"
                                    type="text"
                                    name="address"
                                    class="form-control"
                                    value=""
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
                                    @if ($qoute)
                                    <option
                                        value="{{$qoute->destination_state}}"
                                    >
                                        {{$qoute->destination_state}}
                                    </option>
                                    @endif
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
                                    @if ($qoute)
                                    <option
                                        value="{{$qoute->destination_city}}"
                                    >
                                        {{$qoute->destination_city}}
                                    </option>
                                    @endif
                                    <option value="">Select City</option>
                                </select>
                            </div>

                            <div class="col-lg-12 my-3" id="calculate-fee">
                                <button class="btn btn-secondary p-2 btn-block">
                                    Calculate Fee
                                </button>
                            </div>
                            <div class="col-lg-12 my-3" id="paystack">
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
                        <p class="text-bold">
                            Product Name:
                            <b>{{$qoute->product->product_name}}</b>
                        </p>
                        <p class="text-bold">
                            Product Category:
                            <b>{{$qoute->product->category->category_name}}</b>
                        </p>
                        <p class="text-bold">
                            Product Amount:
                            <b id="update-amount"
                                >${{$qoute->product->product_price}}</b
                            >
                        </p>

                        <div class="flex">
                            <p class="text-bold">
                                Product Qunatity:
                                <button id="minus-qty" class="btns">-</button>
                                <b id="update-qty">1</b>
                            </p>
                            <button id="add-qty" class="btns aj">+</button>
                        </div>
                        <p class="text-bold">
                            Product Weight:
                            <b>{{$qoute->product->product_weight}} kg</b>
                        </p>
                        <p class="text-bold">
                            Delivery Fee:
                            <b id="update-delivery-fee"
                                >${{$qoute->delivery_fee}}</b
                            >
                        </p>
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
<script src="https://js.paystack.co/v1/inline.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    //form fields
    let cal = $("#calculate-fee");
    let payBtn = $("#paystack");

    var product_amount = "{{$qoute->product->product_price}}";
    var update_amount = $("#update-amount");
    var update_qty = $("#update-qty");

    var state_and_capitals = [];
    let DState = $("#destination_state");
    let DCity = $("#destination_city");

    let params = {
        product_id: "{{$qoute->product->id}}",
        reseller_id: "{{$qoute->reseller->user_id}}",
        supplier_id: "{{$qoute->supplier->user_id}}",
    };

    let qoute_data = {
        origin_country: "NG",
        origin_state: "{{$qoute->supplier->state}}",
        origin_city: "{{$qoute->supplier->city}}",
        destination_country: "NG",
        destination_state: DState.val(),
        destination_city: DCity.val(),
        weight: "{{$qoute->product->product_weight}}",
    };

    $(document).ready(function () {
        cal.hide();

        $.ajax({
            dataType: "json",
            url: "{{env('APP_URL')}}/js/state-and-capitals.json",
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

        $("#minus-qty").on("click", function () {
            let value = update_qty.html();

            if (value > 1) {
                value = parseInt(value) - 1;
                update_qty.html(value);
                update_amount.html(`$${product_amount * value}`);
            }
        });
        $("#add-qty").on("click", function () {
            let value = update_qty.html();

            if (value > 0) {
                value = parseInt(value) + 1;
                update_qty.html(value);
                update_amount.html(`$${product_amount * value}`);
            }
        });

        DState.on("change", function () {
            DCity.html("");
            // cal.show();
            // payBtn.hide();

            let value = $(this).val();
            let result = state_and_capitals.filter(
                (data) => data.state.name === value
            );

            const { state } = result[0];
            const { locals } = state;

            locals.map((city, key) => {
                DCity.append($("<option />").val(city.name).text(city.name));
            });
            qoute_data.destination_state = $(this).val();
        });
        DCity.on("change", function () {
            qoute_data.destination_city = $(this).val();
        });

        cal.on("click", function (e) {
            e.preventDefault();
            getQoute(qoute_data);
        });
        payBtn.on("click", function (e) {
            e.preventDefault();
            let fullname = $("#fullname").val();
            let email = $("#email").val();
            let phone = $("#phone").val();
            let address = $("#address").val();

            payWithPaystack(fullname, email, phone, address);
        });
    });

    function payWithPaystack(fullname, email, phone, address) {
        var handler = PaystackPop.setup({
            key: "pk_test_5d5fb23f7643ea0c027b0754c6b8e5861b71c5f4",
            email: email,
            amount: `${product_amount * update_qty.html() * 100}`,
            currency: "NGN",
            ref: "" + Math.floor(Math.random() * 1000000000 + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
            metadata: {
                custom_fields: [
                    {
                        display_name: fullname,
                        variable_name: fullname,
                        value: phone,
                    },
                ],
            },
            callback: function (response) {
                response.fullname = fullname;
                response.email = email;
                response.phone = phone;
                response.address = address;
                response.destination_state = DState.val();
                response.destination_city = DCity.val();
                response.qoute_id = "{{$qoute->qoute_id}}";
                params.payload = response;

                createTransaction(params);
                // alert("success. transaction ref is " + response.reference);
            },
            onClose: function () {
                alert("window closed");
            },
        });
        handler.openIframe();
    }

    function getQoute(data) {
        axios
            .post(
                `https://sandbox.staging.sendbox.co/shipping/shipment_delivery_quote`,
                data,
                {
                    headers: {
                        "Content-Type": "application/json",
                        Authorization: "{{env('SENDBOX_KEY')}}",
                        "Access-Control-Allow-Origin": "*",
                    },
                }
            )
            .then((res) => {
                console.log(res);
            })
            .catch((err) => console.log(err));
    }

    function createTransaction(params) {
        axios
            .post(`https://shareshell.test/api/transaction/create`, params, {
                headers: {
                    "Content-Type": "application/json",
                    "Access-Control-Allow-Origin": "*",
                },
            })
            .then((res) => {
                console.log(res);
            })
            .catch((err) => console.log(err));
    }
</script>

@endsection
