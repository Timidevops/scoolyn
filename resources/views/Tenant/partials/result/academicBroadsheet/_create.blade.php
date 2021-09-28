<div class="px-4 sm:px-6 lg:px-8">
<div>
    <div class="mt-2 text-xl text-gray-200">
        <div class="flex ">
            Broadsheet:
            <div class="pl-2">
                <span class="capitalize">{{$classSubject->subject->subject_name}}</span>
                <span class="font-medium text-xs text-gray-200 capitalize">
                    {{$classSubject->schoolClass->class_name}}
                    {{$classSubject->classSectionType ? "| {$classSubject->classSectionType->section_name}" : ''}}
                    {{$classSubject->classSectionCategoryType ? "| {$classSubject->classSectionCategoryType->category_name}" : ''}}
                </span>
            </div>
        </div>
    </div>
    <a href="{{route('listAcademicBroadsheet')}}" class="flex space-x-1 items-center mt-2">
        <span class=" text-sm text-gray-300 ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                      </svg>
                    </span>
        <span class="text-sm text-gray-300">Broadsheets</span></a>
</div>

<div class="h-screen py-10">
    <div class="bg-white rounded-md py-2">
        @include('Tenant.partials.result.academicBroadsheet.broadSheetTable._allClassArm')
    </div>
</div>
</div>

<script>
    function caAssessmentStructure() {
        return {!! $caAssessmentStructure !!};
    }
    function onchangeCAScore(id, index) {
        let scoreIdText = `totalScore_${id}_${index}`;
        let scoreIdValue = `totalScoreValue_${id}_${index}`;
        let totalScore = 0;

        let previousReportContentScore = `previousReportContentScore_${id}_${index}`;

        document.querySelectorAll(`.${previousReportContentScore}`).forEach((value => {
            totalScore += Number(value.innerText);
        }));

        document.querySelectorAll(`.${scoreIdText}`).forEach((value) => {
            let score = parseFloat(value.value);

            if (!score) {
                score = 0;
            }

            totalScore = totalScore + score;
        });

        document.getElementById(scoreIdText).innerText = totalScore > 100 ? '0' : totalScore;
        document.getElementById(scoreIdValue).value = totalScore > 100 ? '0' : totalScore;
    }
</script>
