<div class="mt-8">
    <div class="sm:block">
        <div class="max-w-6xl mx-auto sm:px-6 ">
            <div class="flex flex-col mt-2">
                <div class="align-middle min-w-full overflow-x-auto  overflow-hidden ">
                    <table class="min-w-full divide-y divide-primary divide-purple-100">
                        <thead>
                        <tr>
                            <th class="px-6 py-3  text-left text-sm font-medium text-gray-500 uppercase">
                                S/N
                            </th>
                            <th class="px-6 py-3  text-left  font-medium text-gray-500 text-sm ">
                              <span class="flex items-center mx-1">Ward name</span>
                            </th>
                            <th class="px-8 py-3  text-left text-sm font-medium text-gray-500">
                                Class
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <template x-for="(item, index) in filteredWards" :key="item"  class="bg-white divide-y divide-purple-100">
                            <tr>
                                <td class=" px-6 py-4 whitespace-nowrap text-xs text-gray-900">
                                    <span class="group inline-flex space-x-2 truncate text-gray-500" x-text="index + 1">
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-left whitespace-nowrap text-xs text-gray-200">
                                    <span class="text-gray-200 font-normal" x-text="item.first_name"></span>
                                    <span class="text-gray-200 font-normal" x-text="item.other_name"></span>
                                    <span class="text-gray-200 font-normal" x-text="item.last_name"></span>
                                </td>
                                <td class="px-6 py-4 text-left whitespace-nowrap text-xs text-gray-200">
                                    <span class="text-gray-200 font-normal" x-text="item.class_arm.school_class.class_name"></span>
                                    <span class="text-gray-200 font-normal" x-text="item.class_arm.class_section ? item.class_arm.class_section.section_name : '' "></span>
                                    <span class="text-gray-200 font-normal" x-text="item.class_arm.class_section_category ? item.class_arm.class_section_category.category_name : '' "></span>
                                </td>
                            </tr>
                        </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
