<div>
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
                <label for="currentReportFormat" class="block text-sm font-normal text-gray-100">
                    Current report card:
                    <span class="capitalize text-blue-100 sm">{{$currentReportFormat}}</span>.
                    <span class="text-red-100">*</span></label>
                <select id="currentReportFormat" name="currentReportFormat" class="w-full capitalize mt-2 text-gray-100 rounded-md py-2 px-2 border border-purple-100" required>
                    <option value="">-- Select Format --</option>
                    @foreach($reportCardBreakdownFormats as $reportCardBreakdownFormat)
                        <option {{$reportCardBreakdownFormat == $currentReportFormat ? 'selected' : '' }} value="{{$reportCardBreakdownFormat}}">{{$reportCardBreakdownFormat}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="px-4 py-4">
            <button id="submitButton" type="submit" class="bg-blue-100 text-white rounded-md py-3 px-2 w-full text-sm">
                Save
            </button>
        </div>
    </form>
</div>
