<form>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <button type="button" onclick="payWithPaystack()">Pay</button>
</form>

<script>
    function payWithPaystack() {
        var handler = PaystackPop.setup({
            key: "pk_test_5d5fb23f7643ea0c027b0754c6b8e5861b71c5f4",
            email: "customer@email.com",
            amount: 10000,
            currency: "NGN",
            ref: "" + Math.floor(Math.random() * 1000000000 + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
            metadata: {
                custom_fields: [
                    {
                        display_name: "Mobile Number",
                        variable_name: "mobile_number",
                        value: "+2348012345678",
                    },
                ],
            },
            callback: function (response) {
                alert("success. transaction ref is " + response.reference);
            },
            onClose: function () {
                alert("window closed");
            },
        });
        handler.openIframe();
    }
</script>
