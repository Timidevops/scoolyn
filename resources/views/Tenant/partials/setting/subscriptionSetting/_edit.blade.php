<div>
    <div class="mt-2 text-xl text-gray-200">
        <div class="flex ">
            School Subscription
        </div>
    </div>
    @if($planStatus == 'active')
        <a href="{{route('listSetting')}}"><span class="mt-2  text-sm text-gray-300">/!/ Settings</span></a>
    @endif
</div>

<div class="py-10" x-data="setting()">
    <div class="bg-white rounded-md px-4 py-4 space-y-4">
        <div>
            Subscription plan: {{$planName}}
        </div>
        <div>
            Expiry date: {{$planExpiry}}
        </div>
        <div>
            Status: <span :class="planStatusColor()" class=" capitalize">{{$planStatus}}</span>
        </div>
        <div>
            @if($planStatus != 'active')
                <button class="bg-blue-100 text-white rounded-md py-3 px-3  text-sm">
                    {{$planStatus == 'expired' ? 'Renew Subscription' : 'Activate Subscription'}}
                </button>
            @endif
        </div>
        <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div>
                <div class="bg-purple-300 overflow-hidden rounded-lg ">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 text-3xl font-light text-blue-100">
                                {{$totalStudents}}
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dd>
                                        <div class="text-lg font-medium text-gray-900">
                                            Student
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="py-3">
                    <span>School Limit: {{$featureTotalStudents}}</span>
                </div>
                @if($planStatus == 'active')
                    @if($isStudentFeatureLimitReached)
                        <div class="py-3 flex justify-between">
                        <button class="bg-blue-100 text-white rounded-md py-3 px-3  text-sm">
                            Upgrade Plan
                        </button>
                        <a href="{{route('subscriptionStudentAddon')}}">
                            <button class="bg-white border border-blue-100 text-blue-100 rounded-md py-3 px-3  text-sm">
                                Add Student Addon
                            </button>
                        </a>
                    </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function setting() {
        return{
            subscriptionStatus: '{{$planStatus}}',
            planStatusColor()
            {
                if(this.subscriptionStatus !== 'active'){
                    return 'text-red-100'
                }
                return 'text-green-100'
            }
        }
    }
</script>
