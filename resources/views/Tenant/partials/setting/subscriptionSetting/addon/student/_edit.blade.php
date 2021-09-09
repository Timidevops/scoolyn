<div>
    <div class="mt-2 text-xl text-gray-200">
        <div class="flex ">
            Subscription: Student Addon
        </div>
    </div>
        <a href="{{route('subscriptionSetting')}}"><span class="mt-2  text-sm text-gray-300">/!/ Subscription</span></a>
</div>

<div x-data="studentAddon()">
    <div class="py-10">
        <div class="bg-white rounded-md px-4 py-4">
            <div>
                <h3>Select an addon</h3>
            </div>
            <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($featureAddons as $featureAddon)
                    <div class="cursor-pointer" @click="onSelectAddon('{{$featureAddon['uuid']}}')">
                        <div class="bg-purple-300 overflow-hidden rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 text-3xl font-light text-blue-100">
                                        {{$featureAddon['value']}}
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-bold text-gray-900 truncate">
                                                NGN {{number_format($featureAddon['amount'], 2)}}
                                            </dt>
                                            <dd>
                                                <div class="text-lg font-light text-gray-900">
                                                    Student Addition
                                                </div>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- addon confirm modal -->
    <div>
        @include('Tenant.partials.setting.subscriptionSetting.addon.partials._confirmAddonSelection')
    </div>
    <!-- addon confirm modal -->
</div>

<script>
    function studentAddon() {
        return{
            isConfirmAddonSelectionModalOpen: false,
            featureAddons: {!! $featureAddons !!},
            selectedAddon: [],
            onSelectAddon(id){
                this.selectedAddon = this.featureAddons.filter(e => e.uuid === id)[0];
                this.isConfirmAddonSelectionModalOpen  = true;
            },
        }
    }
</script>
