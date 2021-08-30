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
    <a href="{{route('listAcademicBroadsheet')}}"><span class="mt-2  text-sm text-gray-300">/!/ Broadsheets</span></a>
</div>

<div class="h-screen py-10">
    <div class="bg-white rounded-md py-2">
        @if($subjectPlacement == 'all')
            @include('Tenant.partials.result.academicBroadsheet.broadSheetTable._allClassArm')
        @endif
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
