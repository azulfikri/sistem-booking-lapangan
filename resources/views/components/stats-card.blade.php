@props(['title', 'value', 'icon', 'color' => 'emerald'])

<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
    <div class="flex items-center justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-600 mb-1">{{ $title }}</p>
            <p class="text-3xl font-bold text-gray-900">{{ $value }}</p>
        </div>
        <div class="ml-4">
            <div class="w-12 h-12 bg-{{ $color }}-100 rounded-lg flex items-center justify-center">
                {!! $icon !!}
            </div>
        </div>
    </div>
</div>
