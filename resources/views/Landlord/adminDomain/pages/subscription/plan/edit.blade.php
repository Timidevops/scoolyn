@extends('Landlord.layouts.main')

@section('pageContent')
    <div class="mt-2 text-xl text-gray-200">
        Plan: {{$plan['name']}}
    </div>
    <div>
        <a href="{{route('listPlan')}}" class="relative">
                    <span class=" text-sm text-gray-300 absolute">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                      </svg>
                    </span>
            <span class="px-7 text-sm text-gray-300">Plans</span>
        </a>
    </div>

    <div>
        <div class="mt-8 bg-white">
            <div class=" sm:block">
                <div class="max-w-6xl mx-auto  sm:px-6">
                    <div class="flex flex-col mt-2 py-10 rounded-md">
                        <div>
                            <table>
                                <tr>
                                    <th>Plan Name</th>
                                    <td>{{$plan['name']}}</td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{{$plan['description']}}</td>
                                </tr>
                                <tr>
                                    <th>Price</th>
                                    <td>{{$plan['currency']}} {{number_format($plan['price'], 2)}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-data="editTable()">
        <div class="mt-8 bg-white">
            <div class=" sm:block">
                <div class="max-w-6xl mx-auto  sm:px-6">
                    <div class="flex flex-col mt-2 py-10 rounded-md">
                        <div class="mt-10 justify-between items-center flex">
                            <div>
                                <h2>Features</h2>
                            </div>
                            <div>
                                <button @click="isAddFeatureModalOpen = true;" class="bg-blue-100 text-white py-3 mx-2 px-4 rounded-md text-sm relative" >
                                <span class="space-x-2 left-0 my-3 mx-2 inset-y-0 absolute">
                                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                  </svg>
                                </span>
                                    <span class="ml-4">Add New Feature</span>
                                </button>
                            </div>
                        </div>
                        <!-- table -->
                        <div class="mt-10">
                            @include('Landlord.adminDomain.pages.subscription.plan.partials._editTable')
                        </div>
                        <!-- table -->
                    </div>
                </div>
            </div>
        </div>
        <!-- add feature modal -->
            @include('Landlord.adminDomain.pages.subscription.plan.partials._addFeatureModal')
        <!-- add feature modal -->
    </div>

@endsection

@section('pageJs')
    <script>
        function editTable() {
            return{
                isAddFeatureModalOpen: false,
                selectedFeature: '',
                featureValue: '',
                featureDescription:'',
                onSelectFeature(){
                    let newFeature = {!! $newFeatures !!};
                    let feature = newFeature.filter(e => e.uuid === this.selectedFeature);
                    this.featureValue = feature.length > 0 ? feature[0]['value'] : '' ;
                    this.featureDescription = feature.length > 0 ? feature[0]['description'] : '';
                },
                search: "",
                pageNumber: 0,
                size: 10,
                total: "",
                featureData: {!! $features !!},
                get filteredFeatureTable() {
                    const start = this.pageNumber * this.size,
                        end = start + this.size;
                    if (this.search === "") {
                        this.total = this.featureData.length;
                        return this.featureData.slice(start, end);
                    }
                    //Return the total results of the filters
                    this.total = this.featureData.filter((item) => {
                        return item.subject_name
                            .toLowerCase()
                            .includes(this.search.toLowerCase());
                    }).length;
                    //Return the filtered data
                    return this.featureData
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
