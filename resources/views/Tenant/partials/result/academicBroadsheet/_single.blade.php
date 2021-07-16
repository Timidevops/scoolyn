
<div class="h-screen">
    <div class="bg-white rounded-md ">
        <div class="px-4 py-4">
            @if( $broadsheetStatus != \App\Models\Tenant\AcademicBroadSheet::APPROVED_STATUS )
                <p class="text-gray-300">Broadsheet submitted, <span class="italic text-blue-100">awaiting approval from class teacher.</span></p>
            @else
                <p>Broadsheet submitted and approved.</p>
            @endif
        </div>
        <!-- broadsheet table with grades -->
            @include('.Tenant.partials.result.helpers.table.broadsheetTableWithGrade')
        <!--/: broadsheet table with grades -->
    </div>
</div>


