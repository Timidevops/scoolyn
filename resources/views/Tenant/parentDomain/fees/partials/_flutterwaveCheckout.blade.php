<form>
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <button type="button" onclick="initiatePayment()" class="bg-blue-100 text-white rounded-md py-3 px-3  text-sm">Proceed to Payment </button>
</form>
<script>
    function initiatePayment() {
        //create initial transaction
        uuid = '{{$wardSchoolFee->uuid}}'
            studentId = '{{$wardSchoolFee->student_id}}'
        fetch('/fees/payment/'+uuid+'/'+studentId)
            .then((resp) => resp.json())
            .then(function(data) {
                sendPaymentToFlutterwave(data)
            })
            .catch(function () {
                alert("Failed to generate transaction reference. Please try again later.");
                throw new Error('Failed to generate transaction reference.');
            });
    }
    function sendPaymentToFlutterwave(data) {
        FlutterwaveCheckout({
            public_key: data.public_key,
            tx_ref: data.reference,
            amount: data.amount,
            currency: "NGN",
            payment_options: "account,banktransfer,card",
            redirect_url: data.redirect_url,
            meta: data.meta,
            customer: data.customer,
            subaccounts: data.subaccounts,
            customizations: data.customizations,
        });
    }
</script>
