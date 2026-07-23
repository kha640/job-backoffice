
{{-- Error Message --}}

@if ($errors->any())
    <div class=" text-red-700 px-4 rounded relative">
        <ul class="mt-2">
            {{ $errors->first() }}
        </ul>
    </div>
@endif
