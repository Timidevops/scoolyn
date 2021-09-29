@extends('Landlord.layouts.main')

@section('pageContent')
    <div>
        <div class="mt-2 text-xl text-gray-200">
            Features
        </div>
        <span class="mt-2 text-base text-gray-300">{{$totalFeatures}} Total Features</span>
    </div>
    <div x-data="features()">
        <div class="bg-white py-6 px-2 rounded-md md:flex md:items-center md:mt-2 ">
            <div class="md:w-1/4">
                <a href="{{route('createFeature')}}" class="bg-blue-100 text-white py-3 mx-2 px-4 rounded-md text-sm relative" >
                    <span class="space-x-2 left-0 my-3 mx-2 inset-y-0 absolute">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                    </span>
                    <span class="ml-4">Add New Feature</span>
                </a>
            </div>
        </div>
        <!-- Table -->
            @include('Landlord.adminDomain.pages.subscription.feature.partials._indexTable')
        <!-- Table -->
    </div>
@endsection

@section('pageJs')
    <script>
        function features() {
            return{
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
