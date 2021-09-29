@extends('Tenant.layouts.main')
@section('headerMeta')
@endsection
@section('topNav')
@endsection
@section('content')
    <div class="h-screen md:flex md:overflow-hidden overflow-scroll bg-purple-100">
        <div>
         @include('Tenant.partials._sidebar')
        </div>
        <div class="flex-1 overflow-auto bg-purple-100 focus:outline-none px-4 py-8" tabindex="0" x-cloak id="tab_wrapper">
            @include('Tenant.partials.fees._edit')
        </div>
     </div>
@endsection
@section('scripts')
    <script>
        // $(document).ready(function() {
        //     calculateTotalFees();
        // });
        function calculateTotalFees()
        {
            let sum = 0;
            $('.feeItem').each(function(){
                let $item_tot = $(this).val();
                if($item_tot ===" ")
                {
                    $item_tot = 0;
                }else{
                    $item_tot = parseFloat($(this).val());
                }
                sum = sum + $item_tot;
            });
            $('#feesAmountFormatted').val(formatNumber(sum));
            $('#feesAmount').val(sum);
        }
        function formatNumber(number)
        {
            return number.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'.00';
        }
    </script>
@endsection
