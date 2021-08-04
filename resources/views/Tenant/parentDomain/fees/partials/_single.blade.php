<div>
    <div class="mt-2 text-xl text-gray-200">
        <div class="flex ">
            <div>
                Child’s school fees:
            </div>
            <div class="pl-2">
                <span class="capitalize">{{$wardSchoolFee->student->first_name}}</span>
                <span class="capitalize">{{$wardSchoolFee->student->last_name}}</span>
            </div>
        </div>
    </div>
        <a href="{{route('listWardFee')}}"><span class="mt-2  text-sm text-gray-300">/!/ School Fees</span></a>
</div>

<div class="bg-white rounded-md py-6 px-6 mt-5">

    <div class="flex">
        <div class="w-3/5">
            <h4 class="text-blue-100 py-1">
                <span class="uppercase">{{$wardSchoolFee->student->first_name}}</span>
                <span class="capitalize">{{$wardSchoolFee->student->other_name}}</span>
                <span class="capitalize">{{$wardSchoolFee->student->last_name}}</span>
            </h4>
            <p class="text-sm text-gray-300 py-1">
                Find below details of receipt for
            </p>
            <p class="text-blue-100 py-1">
                {{ str_replace('-', '/', $wardSchoolFee->academicSession->session_name)  }}
                session,
                {{$wardSchoolFee->academicTerm->term_name}}
                term.
            </p>
        </div>
        <div class="w-2/5">
            <div class="flex justify-between py-1">
                <div>
                    <p class="text-sm">Receipt Number:</p>
                </div>
                <div class="">
                    <p class="text-sm text-gray-100">
                        10029443844
                    </p>
                </div>
            </div>
            <div class="flex justify-between py-1">
                <div>
                    <p class="text-sm">Status</p>
                </div>
                <div>
                    <p class="text-sm text-gray-100 capitalize">
                        {{$wardSchoolFee->status}}
                    </p>
                </div>
            </div>
            <div class="flex justify-between">
                <div></div>
                <div class="py-5">
                    @if( $wardSchoolFee->status !== \App\Models\Tenant\SchoolFee::PAID_STATUS)
                        <form>
                            @csrf
                            <button type="submit" class="bg-blue-100 text-white rounded-md py-3 px-3  text-sm" >
                                Proceed to payment
                            </button>
                        </form>
                    @else
                        <button type="button" class="bg-blue-100 text-white rounded-md py-3 px-3  text-sm" >
                            Print
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="pl-2 py-3 mt-10">
        <div class="align-middle min-w-full overflow-x-auto  overflow-hidden ">
            <table class="min-w-full divide-y  divide-purple-100">
                <thead>
                <tr>
                    <th class="px-6 py-3  text-left text-sm font-medium text-blue-100">
                        Fee Name
                    </th>
                    <th class="px-6 py-3 text-right  font-medium text-blue-100 text-sm ">
                        <p class="">
                            Amount
                        </p>
                    </th>
                </tr>
                </thead>
                <tbody>
                    @foreach($schoolFees as $schoolFee)
                        <tr>
                            <td class="max-w-0 text-sm px-6 py-4 whitespace-nowrap text-gray-900">
                                <span class="text-gray-500 truncate capitalize">
                                    {{$schoolFee->name}}
                                </span>
                            </td>
                            <td class="max-w-0 text-sm text-right px-6 py-4 whitespace-nowrap text-gray-900">
                                <p class="text-gray-500 text-right capitalize">
                                    {{number_format($schoolFee->amount, 2)}}
                                </p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td class="py-5">
                            <div class="flex">
                                <div class="w-1/2 text-right">
                                    <p>
                                        Total Amount
                                    </p>
                                </div>
                                <div class="w-1/2 text-right px-6">
                                    <p class="text-gray-300">NGN {{number_format($wardSchoolFee->amount, 2)}}</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>
