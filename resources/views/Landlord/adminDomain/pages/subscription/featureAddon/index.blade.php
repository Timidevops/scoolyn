@extends('Landlord.layouts.main')

@section('pageContent')
    <div>
        <div class="mt-2 text-xl text-gray-200">
            Features Addons
        </div>
        <span class="mt-2 text-base text-gray-300">{{$totalFeatureAddons}} Total Feature Addons</span>
    </div>
    @if($errors->any())
        <div class="mt-8 bg-red-100 p-4">
            @foreach ($errors->all() as $error)
                <p class="text-white">
                    {!! $error !!}
                </p>
            @endforeach
        </div>
    @endif
    <div x-data="featureAddon()">
        <div class="mt-8 bg-white py-6 px-2 rounded-md md:flex md:items-center ">
            <div class="md:w-1/4">
                <button @click="isAddFeatureAddonModalOpen = true;" class="bg-blue-100 text-white py-3 mx-2 px-4 rounded-md text-sm relative" >
                                <span class="space-x-2 left-0 my-3 mx-2 inset-y-0 absolute">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                  </svg>
                                </span>
                    <span class="ml-4">Add New Feature Addon</span>
                </button>
            </div>
        </div>

        <!-- table -->
        <div class="mt-8 bg-white">
            <div class=" sm:block">
                <div class="max-w-6xl mx-auto  sm:px-6">
                    <div class="flex flex-col mt-2 py-10 rounded-md">
                        @include('Landlord.adminDomain.pages.subscription.featureAddon.partials._indexTable')
                    </div>
                </div>
            </div>
        </div>
        <!-- table -->

        <!-- add feature addon modal -->
            @include('Landlord.adminDomain.pages.subscription.featureAddon.partials._addFeatureAddonModal')
        <!-- add feature addon modal -->
    </div>
@endsection

@section('pageJs')
    <script>
        function featureAddon() {
            return{
                isAddFeatureAddonModalOpen: false,
                selectedFeature: '',
                featureDescription: '',
                onSelectFeature(){
                    let newFeature = {!! $features !!};
                    let feature = newFeature.filter(e => e.uuid === this.selectedFeature);
                    this.featureDescription = feature.length > 0 ? feature[0]['description'] : '';
                },

                search: "",
                pageNumber: 0,
                size: 10,
                total: "",
                featureAddonData: {!! $featureAddons !!},
                get filteredAddonFeatureTable() {
                    const start = this.pageNumber * this.size,
                        end = start + this.size;
                    if (this.search === "") {
                        this.total = this.featureAddonData.length;
                        return this.featureAddonData.slice(start, end);
                    }
                    //Return the total results of the filters
                    this.total = this.featureAddonData.filter((item) => {
                        return item.subject_name
                            .toLowerCase()
                            .includes(this.search.toLowerCase());
                    }).length;
                    //Return the filtered data
                    return this.featureAddonData
                        .filter((item) => {
                            return item.subject_name
                                .toLowerCase()
                                .includes(this.search.toLowerCase());
                        })
                        .slice(start, end);
                },
                //Create array of all pages (for loop to display page numbers)
                pages() {
                    return Array.from({
                        length: Math.ceil(this.total / this.size),
                    });
                },
                //Next Page
                nextPage() {
                    this.pageNumber++;
                },
                //Previous Page
                prevPage() {
                    this.pageNumber--;
                },
                //Total number of pages
                pageCount() {
                    return Math.ceil(this.total / this.size);
                },
                //Return the start range of the paginated results
                startResults() {
                    return this.pageNumber * this.size + 1;
                },
                //Return the end range of the paginated results
                endResults() {
                    let resultsOnPage = (this.pageNumber + 1) * this.size;
                    if (resultsOnPage <= this.total) {
                        return resultsOnPage;
                    }
                    return this.total;
                },
                //Link to navigate to page
                viewPage(index) {
                    this.pageNumber = index;
                },
            }
        }
    </script>
@endsection
