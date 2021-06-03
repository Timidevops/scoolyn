@extends('Tenant.layouts.main')
@section('headerMeta')
@endsection
@section('topNav')
@endsection
@section('content')
    <div class="h-screen flex overflow-hidden bg-gray-100">
        @include('Tenant.partials._sidebar')
        <div class="flex-1 overflow-auto bg-purple-100 focus:outline-none px-4 py-8" tabindex="0" x-cloak
             id="tab_wrapper">
            <div class="h-screen py-10">
                <div class="bg-white rounded-md ">
                    <form action="{{route('storeAcademicBroadsheet')}}" method="post" x-data="test()" x-init="init()">
                        @csrf
                        <input type="hidden" name="teacher">
                        <input type="hidden" name="subject">
                        <input type="hidden" name="classSection">
                        <input type="hidden" name="classSectionCategory">
                        <div class="flex justify-end px-4 py-4">
                            <button type="submit" href=""
                                    class="bg-blue-100 text-white rounded-md py-2 px-4 mx-2  text-sm">
                                Save C.A
                            </button>
                        </div>
                        <div class="flex flex-col mt-2">
                            <div class="align-middle min-w-full overflow-x-auto  overflow-hidden ">
                                <table class="min-w-full divide-y  divide-purple-100">
                                    <thead>
                                    <tr>
                                        <th class="px-6 py-3 w-1  text-left text-sm font-medium text-gray-500 uppercase">
                                            SN
                                        </th>
                                        <th class="px-6 py-3  text-left  font-medium text-gray-500 text-sm ">
                                        <span class="flex items-center mx-1">
                                            Student Name
                                        </span>
                                        </th>
                                        <template x-for="(item, index) in caAssessmentStructure" :key="item">
                                            <th class="px-6 py-3  text-center  font-medium text-gray-500 text-sm">
                                                <span x-text="item.name"></span>
                                                <p>(<span class="text-center" x-text="item.score"></span>)</p>
                                            </th>
                                        </template>
                                        <th class="px-6 py-3  text-left  font-medium text-gray-500 text-sm ">
                                        <span class="flex items-center mx-1">
                                            <span>Total</span>
                                            <p>(100)</p>
                                        </span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <template x-for="(item, index) in student" :key="item">
                                        <tbody class="bg-white divide-y divide-purple-100">
                                        <tr class="bg-white">

                                            <td class="max-w-0  px-6 py-4 whitespace-nowrap text-xs text-gray-900">
                                                <div class="flex">
                                                    <a href="#" class="group inline-flex space-x-2 truncate">
                                                        <p class="text-gray-500 truncate" x-text="index+1">
                                                        </p>
                                                    </a>
                                                </div>
                                            </td>

                                            <td class="px-6 py-4 text-left whitespace-nowrap text-xs text-gray-200">
                                              <span class="text-gray-200 font-normal" x-text="item.name">
                                              </span>
                                            </td>
                                            <template x-for="(ca, caIndex) in caAssessmentStructure" :key="ca">
                                                <td class="px-6 py-4 text-left whitespace-nowrap text-xs text-gray-200">
                                                    <div class="mt-2">
                                                        <input type="number" x-bind:class="`totalScore_${index}`" @input="onchangeCAScore(`totalScore_${index}`)" x-bind:name="`broadsheet[${item.name}][${ca.name}]`" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100 ">
                                                    </div>
                                                </td>
                                            </template>
                                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-200">
                                              <p class="text-gray-200 text-center font-normal" x-bind:id="`totalScore_${index}`">0</p>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </template>
                                </table>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <script>
                function test() {
                    return {
                        init(){
                        },
                        student: [
                            {
                                id: '1',
                                name: 'john doe'
                            },
                            {
                                id: '2',
                                name: 'john lee'
                            }
                        ],
                        caAssessmentStructure:{!! $caAssessmentStructure !!},
                        onchangeCAScore(id){
                            let totalScore = 0;

                            document.querySelectorAll(`.${id}`).forEach((value) => {
                                let score = parseInt(value.value);

                                if(! score ){
                                    score = 0;
                                }

                                totalScore = totalScore + score;
                            });

                            document.getElementById(id).innerText = totalScore;
                        },
                    }
                }
            </script>

        </div>
        @include('Tenant.partials._notification')
    </div>
@endsection
