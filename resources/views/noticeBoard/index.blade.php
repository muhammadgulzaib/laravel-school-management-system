@extends('layouts.app')

@section('content')
    <div class="roles-permissions">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">Notice</h2>
            </div>
            <div class="flex flex-wrap items-center">
                <a href="{{route('add.notice')}}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                    <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" class="svg-inline--fa fa-plus fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg>
                    <span class="ml-2 text-xs font-semibold">Notice</span>
                </a>
            </div>
        </div>
        <div class="mt-8 bg-white rounded border-b-4 border-gray-300">
            <div class="flex flex-wrap items-center uppercase text-sm font-semibold bg-gray-300 text-gray-600 rounded-tl rounded-tr">
                <div class="w-1/12 px-4 py-3">#</div>
                <div class="w-4/12 px-4 py-3">Notice</div>
                <div class="w-4/12 px-4 py-3">Created At</div>
                <div class="w-2/12 px-4 py-3 text-right">Action</div>
            </div>
            @foreach ($notices as $key => $notice)
                <div class="flex flex-wrap items-center text-gray-700 border-t-2 border-l-4 border-r-4 border-gray-300">
                    <div class="w-1/12 px-4 py-3 text-sm font-semibold text-gray-600 tracking-tight">{{ $key+1 }}</div>
                    <div class="w-3/12 px-4 py-3 text-sm font-semibold text-gray-600 tracking-tight">{{ $notice->description }}</div>
                    <div class="w-6/12 px-4 py-3 text-sm font-semibold text-gray-600 tracking-tight" style="margin-left: 68px;">{{ $notice->created_at }}</div>

                    <div class="w-1/12 flex items-center justify-end px-3" style="margin-left: -80px;">
                      
                        <form action="{{ route('notice.destroy',$notice->id) }}" method="POST" class="inline-flex ml-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-gray-600 block p-1 border border-gray-600 rounded-sm">
                                <svg class="h-3 w-3 fill-current text-gray-100" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" class="svg-inline--fa fa-trash fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        
    </div>
@endsection
