@extends('payments.layout') @section('content')
<main class="flex w-full">
    <div class="h-auto sideBar md:hidden"></div>
    <div class="flex ml-6 mt-8 main md:flex-col md:ml-4">
        <div class="mr-40 w-max md:w-full md:mr-4">
            <div class="w-max md:w-full">
                <img
                    class="image-viewer"
                    src="{{ asset('payments/BigImage.png') }}"
                    alt="Current"
                />
            </div>
            <div class="flex flex-wrap mt-6 gap-4 md:justify-between">
                <img
                    class="image-viewer"
                    src="{{ asset('payments/image1.png') }}"
                />
                <img
                    class="image-viewer"
                    src="{{ asset('payments/image2.png') }}"
                />
                <img
                    class="image-viewer"
                    src="{{ asset('payments/image3.png') }}"
                />
                <img
                    class="image-viewer"
                    src="{{ asset('payments/image4.png') }}"
                />
            </div>
        </div>
        <div class="mr-40 md:mr-4">
            <button class="storeButton py-2 px-4 font-semibold md:mt-4">
                {{ $qoute->supplier->business_name }}
            </button>
            <h2 class="text-3xl font-medium my-8">
                {{ $qoute->product->product_name }}
            </h2>
            <p class="font-medium productDescription">Product Discription</p>
            <p class="description text-justify">
                {{ $qoute->product->product_description }}
            </p>
            <div class="flex items-center justify-between mt-6">
                <div>
                    <p class="quantity">Quantity</p>
                    <div class="flex quantityContainer mt-2">
                        <button class="py-1 px-3 controls">-</button>
                        <p class="py-1 px-3 value">02</p>
                        <button class="py-1 px-3 controls">+</button>
                    </div>
                </div>
                <div class="flex flex-col">
                    <p class="productPriceTitle">PRODUCT PRICE</p>
                    <p class="price">
                        ₦{{ number_format($qoute->product->product_price, 2) }}
                    </p>
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
                        <div
                            class="
                                flex
                                justify-between
                                items-center
                                w-full
                                px-4
                                pb-4
                            "
                        >
                            <p class="dropDownItem">Nigeria</p>
                            <img
                                src="{{ asset('payments/caret-down.svg') }}"
                                alt="Caret"
                            />
                        </div>
                    </div>
                    <div class="flex flex-col form-group">
                        <label class="bg-white px-1 w-max">State</label>
                        <div
                            class="
                                flex
                                justify-between
                                items-center
                                w-full
                                px-4
                                pb-4
                            "
                        >
                            <p class="dropDownItem">Kaduna</p>
                            <img
                                src="{{ asset('payments/caret-down.svg') }}"
                                alt="Caret"
                            />
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
                        <div
                            class="
                                flex
                                justify-between
                                items-center
                                w-full
                                px-4
                                pb-4
                            "
                        >
                            <p class="dropDownItem">Kaduna South</p>
                            <img
                                src="{{ asset('payments/caret-down.svg') }}"
                                alt="Caret"
                            />
                        </div>
                    </div>
                </div>
                <div class="flex justify-between items-center mb-12">
                    <div class="flex flex-col form-group full">
                        <label class="bg-white px-1 w-max"
                            >Address Line 1</label
                        >
                        <input type="text" class="w-full" />
                    </div>
                </div>
                <div class="flex justify-between items-center mb-12">
                    <div class="flex flex-col form-group full">
                        <label class="bg-white px-1 w-max"
                            >Address Line 2</label
                        >
                        <input type="text" class="w-full" />
                    </div>
                </div>
            </div>

            <div class="flex flex-col mt-8">
                <h3 class="py-1 mb-6 contact">Contact Details</h3>
                <div class="detail-card flex flex-col p-3">
                    <p class="detail-head">Osamudiamen Imasuen</p>
                    <p class="detail-body">sirmudiadavid@gmail.com</p>
                    <p class="detail-body">080172948113</p>
                </div>
            </div>
            <div class="flex flex-col mt-8 mb-4">
                <h3 class="py-1 mb-6 contact">Delivery Details</h3>
                <div class="detail-card flex flex-col p-3">
                    <p class="detail-head">Kaduna, Nigeria</p>
                    <p class="detail-body">Kaduna South</p>
                    <p class="detail-body">
                        No. 3 Maha Close, Narayi. Barnawa Close, Nigeria
                    </p>
                </div>
            </div>
            <div class="flex flex-col w-max ml-auto">
                <div class="flex justify-between">
                    <p class="label">Product Price</p>
                    <p class="label">Delivery fee</p>
                </div>
                <div class="flex justify-between items-center summation py-2">
                    <p class="amount">
                        ₦{{ number_format($qoute->product->product_price, 2) }}
                    </p>
                    <img src="{{ asset('payments/plus.svg') }}" class="px-4" />
                    <p class="amount">
                        ₦{{ number_format($qoute->delivery_fee, 2) }}
                    </p>
                </div>
            </div>
            <div class="flex flex-col w-max ml-auto">
                <p class="label mt-2 text-right">Total</p>
                <p class="total" id="total"></p>
            </div>
            <div class="flex justify-end mb-32 mt-8">
                <button class="paymentButton">
                    <img
                        src="{{ asset('payments/payment.svg') }}"
                        class="mr-3"
                    />
                    Proceed to Secure Payment
                </button>
            </div>
        </div>
    </div>
</main>

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

    var product_amount = "{{ $qoute->product->product_price }}";
    var update_amount = $("#update-amount");
    var update_qty = $("#update-qty");
    var total = $("#total");

    var state_and_capitals = [];
    let DState = $("#destination_state");
    let DCity = $("#destination_city");

    let params = {
        product_id: "{{ $qoute->product->id }}",
        reseller_id: "{{ $qoute->reseller->user_id }}",
        supplier_id: "{{ $qoute->supplier->user_id }}",
        amount: "{{ $qoute->product->product_price }}",
        delivery_fee: "{{ $qoute->delivery_fee }}",
    };

    let qoute_data = {
        origin_country: "NG",
        origin_state: "{{ $qoute->supplier->state }}",
        origin_city: "{{ $qoute->supplier->city }}",
        destination_country: "NG",
        destination_state: DState.val(),
        destination_city: DCity.val(),
        weight: "{{ $qoute->product->product_weight }}",
    };

    $(document).ready(function () {
        cal.hide();

        let total_cost = params.amount + params.delivery_fee;

        total.html(`₦${total_cost.toLocaleString()}`);

        $.ajax({
            dataType: "json",
            url: "{{ env('APP_URL') }}/js/state-and-capitals.json",
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
                response.qoute_id = "{{ $qoute->qoute_id }}";
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
                        Authorization: "{{ env('SENDBOX_KEY') }}",
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
