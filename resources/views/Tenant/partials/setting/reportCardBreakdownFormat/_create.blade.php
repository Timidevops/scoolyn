<div x-data="reportCard()">
    <form action="{{route('updateReportCardBreakdownFormatSetting')}}" method="post">
        @csrf
        @if($errors->any())
            <div class="mt-1 mb-5 bg-red-100 p-5">
                @foreach ($errors->all() as $error)
                    <p class="text-white">
                        {!! $error !!}
                    </p>
                @endforeach
            </div>
        @endif
        <div class="p-4">
            <div class="mt-2">
                <label for="numberOfReport" class="block text-sm font-normal text-gray-100">Number of Report card per term. <span class="text-red-100">*</span></label>
                <input x-model="numberOfReport" @input="onchangeNumberOfReport()" type="text" name="numberOfReport" id="numberOfReport" class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100">
            </div>
        </div>
        <template x-for="(content, contentIndex) in numberOfReportObject" :key="contentIndex">
            <div class="p-4">
                <div class="w-2/5">
                    <div class="mt-2">
                        <label for="nameOfReport" class="block text-sm font-normal text-gray-100">Name of <span x-text="contentIndex +1"></span> report card <span class="text-red-100">*</span></label>
                        <input id="nameOfReport" type="text" @input="onchangeNumberOfCA()" name="nameOfReport[]" :id=`numberOfCA_${contentIndex}` class="w-full text-gray-100 rounded-md py-2 px-2 border border-purple-100">
                    </div>
                </div>
            </div>
        </template>
        <div class="px-4 py-4">
            <button id="submitButton" type="submit" class="bg-blue-100 text-white rounded-md py-3 px-2  md:w-1/5 text-sm">
                Submit
            </button>
        </div>
    </form>
</div>

<script>
    function reportCard() {
        return{
            numberOfReport:1,
            onchangeNumberOfReport(){
                if(this.numberOfReport >=1){
                    this.numberOfReportObject = [];
                    for(let i=1; i <= this.numberOfReport; i++){
                        this.numberOfReportObject.push({
                            'numberOfCA': 0,
                            'numberOfCAObject': [],
                        })
                    }
                    return;
                }
                this.numberOfReport = '';
                return this.numberOfReportObject = [];
            },
            numberOfReportObject: [{
                name: '',
            }],
        }
    }
</script>
