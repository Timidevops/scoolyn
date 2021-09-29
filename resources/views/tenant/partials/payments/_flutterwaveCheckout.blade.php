<form>
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <button type="button" onClick="makePayment()">Pay Now </button>
</form>
<script>
    function makePayment() {
        FlutterwaveCheckout({
            public_key: "YOUR_PUBLIC_KEY",
            tx_ref: "hooli-tx-new-test",
            amount: 54600,
            currency: "NGN",
            payment_options: "card,ussd,qr,barter",
            customer: {
                email: "user@gmail.com",
                phonenumber: "08102909304",
                name: "Yemi Desola",
            },
            subaccounts: [
                {
                    id: "RS_A8EB7D4D9C66C0B1C75014EE67D4D663",// This assumes you have setup your commission on the dashboard.
                }
            ],
            callback: function (data) {
                console.log(data);
            },
            customizations: {
                title: "My store",
                description: "Payment for items in cart",
                logo: "https://assets.piedpiper.com/logo.png",
            },
        });
    }
</script>



<form>
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <button type="button" onClick="makePayment()">Pay Now</button>
</form>

<script>
    function makePayment() {
        FlutterwaveCheckout({
            public_key: "FLWPUBK_TEST-SANDBOXDEMOKEY-X",
            tx_ref: "RX1",
            amount: 10,
            currency: "USD",
            country: "US",
            payment_options: " ",
            redirect_url: // specified redirect URL
                "https://callbacks.piedpiper.com/flutterwave.aspx?ismobile=34",
            meta: {
                consumer_id: 23,
                consumer_mac: "92a3-912ba-1192a",
            },
            customer: {
                email: "cornelius@gmail.com",
                phone_number: "08102909304",
                name: "Flutterwave Developers",
            },
            subaccounts: [
                {
                    id: "RS_A8EB7D4D9C66C0B1C75014EE67D4D663",// This assumes you have setup your commission on the dashboard.
                }
            ],
            callback: function (data) {
                console.log(data);
            },
            onclose: function() {
                // close modal
            },
            customizations: {
                title: "My store",
                description: "Payment for items in cart",
                logo: "https://assets.piedpiper.com/logo.png",
            },
        });
    }
</script>
