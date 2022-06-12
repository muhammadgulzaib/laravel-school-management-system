@extends('layouts.frontend')

@section('content')
    <div class="roles-permissions">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Notice</h2>
            </div>
        </div>
        <div class="mt-8 bg-white rounded border-b-4 border-gray-300">
            <div class="flex flex-wrap items-center uppercase text-sm font-semibold bg-gray-300 text-gray-600 rounded-tl rounded-tr">
                <div class="w-1/12 px-4 py-3">#</div>
                <div class="w-4/12 px-4 py-3">Notice</div>
                <div class="w-4/12 px-4 py-3">Created At</div>
            </div>
            @foreach ($notices as $key => $notice)
                <div class="flex flex-wrap items-center text-gray-700 border-t-2 border-l-4 border-r-4 border-gray-300">
                    <div class="w-1/12 px-4 py-3 text-sm font-semibold text-gray-600 tracking-tight">{{ $key+1 }}</div>
                    <div class="w-3/12 px-4 py-3 text-sm font-semibold text-gray-600 tracking-tight">{{ $notice->description }}</div>
                    <div class="w-6/12 px-4 py-3 text-sm font-semibold text-gray-600 tracking-tight" style="margin-left: 68px;">{{ $notice->created_at }}</div>

                
                </div>
            @endforeach
        
    </div>
@endsection
