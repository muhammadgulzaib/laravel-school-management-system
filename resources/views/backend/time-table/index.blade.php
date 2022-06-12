@extends('layouts.app')

@section('content')

    <div class="roles-permissions">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-gray-700 uppercase font-bold">TimeTable</h2>
            </div>
            <div class="flex flex-wrap items-center">
                <a href="{{ route('time-table.create') }}"
                   class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                    <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas"
                         data-icon="plus" class="svg-inline--fa fa-plus fa-w-14" role="img"
                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path fill="currentColor"
                              d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path>
                    </svg>
                    <span class="ml-2 text-xs font-semibold">TimeTable</span>
                </a>
            </div>
        </div>

        <div class="table w-full mt-8 bg-white rounded">
            <form action="{{ route('time-table.store') }}" method="POST" class="w-full px-6 py-12">
                @csrf

                <div class="md:flex md:w-full md:justify-center mb-6">

                    <div class="md:w-full  mr-2">
                        <label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4">
                            Institute Start Time
                        </label>
                        <input name="start_time"
                               class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                               type="time" value="{{ old('class_name') }}">
                        @error('name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:w-full mr-2">
                        <label class="block text-gray-500 font-bold md:text-left mb-1 md:mb-0 pr-4">
                            Institute End Time
                        </label>
                        <input name="end_time"
                               class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-blue-500"
                               type="time" value="{{ old('class_name') }}">
                        @error('name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="md:flex md:items-right">
                    <div class="md:w-12/12"></div>
                    <div class="md:w-12/12">
                        <button
                            class="shadow bg-blue-500 hover:bg-blue-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                            type="submit">
                            Create TimeTable
                        </button>
                    </div>
                </div>
            </form>
        </div>

        @foreach(\App\Services\TimeTableService::allSection() as $section)
            <div class="mt-8 p-5 bg-white rounded w-full border-b-4 border-gray-300">
                <h3 class="text-center" style="font-size: 25px">
                    Semester: {{ $section->grade[0]->class_name }} ({{ $section->name }}) - {{ \App\Services\TimeTableService::allRoom($section->id) ?? null  }}
                </h3>
                <div class="container">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead class="border bg-gray-100">
                            <tr class="bg-light-gray">
                                @foreach(\App\Services\TimeTableService::DayArray() as $day)
                                    <th class="text-uppercase p-2" width="200">{{ $day }}</th>
                                @endforeach
                            </tr>
                            </thead>

                            <tbody>

                            {{--                            @foreach(\App\Services\TimeTableService::getTimeTableSection($section->id) as $timeTable)--}}
                                <tr>

                                    <td>
                                        @foreach(\App\Services\TimeTableService::getTimeTableDayClass($section->id,$section->grade[0]->id,"Monday") as $data)
                                        <div class="p-5 border">
                                            <div class="margin-10px-top font-size14">{{ $data->teacher->user->name ?? '' }}</div>
                                            <div class="margin-10px-top font-size14"><b>{{ $data->subject->name ?? '' }}</b></div>
                                            <div class="font-size13 text-light-gray">{{ $data->class_start_time }}</div>
                                            <div class="font-size13 text-light-gray">-</div>
                                            <div class="font-size13 text-light-gray">{{ $data->class_end_time }}</div>
                                        </div>
                                        @endforeach
                                    </td>

                                    <td>
                                        @foreach(\App\Services\TimeTableService::getTimeTableDayClass($section->id,$section->grade[0]->id,"Tuesday") as $data)
                                            <div class="p-5 border">
                                                <div class="margin-10px-top font-size14">{{ $data->teacher->user->name ?? '' }}</div>
                                                <div class="margin-10px-top font-size14"><b>{{ $data->subject->name ?? '' }}</b></div>
                                                <div class="font-size13 text-light-gray">{{ $data->class_start_time }}</div>
                                                <div class="font-size13 text-light-gray">-</div>
                                                <div class="font-size13 text-light-gray">{{ $data->class_end_time }}</div>
                                            </div>
                                        @endforeach
                                    </td>

                                    <td>
                                        @foreach(\App\Services\TimeTableService::getTimeTableDayClass($section->id,$section->grade[0]->id,"Wednesday") as $data)
                                            <div class="p-5 border">
                                                <div class="margin-10px-top font-size14">{{ $data->teacher->user->name ?? '' }}</div>
                                                <div class="margin-10px-top font-size14"><b>{{ $data->subject->name ?? '' }}</b></div>
                                                <div class="font-size13 text-light-gray">{{ $data->class_start_time }}</div>
                                                <div class="font-size13 text-light-gray">-</div>
                                                <div class="font-size13 text-light-gray">{{ $data->class_end_time }}</div>
                                            </div>
                                        @endforeach
                                    </td>

                                    <td>
                                        @foreach(\App\Services\TimeTableService::getTimeTableDayClass($section->id,$section->grade[0]->id,"Thursday") as $data)
                                            <div class="p-5 border">
                                                <div class="margin-10px-top font-size14">{{ $data->teacher->user->name ?? '' }}</div>
                                                <div class="margin-10px-top font-size14"><b>{{ $data->subject->name ?? '' }}</b></div>
                                                <div class="font-size13 text-light-gray">{{ $data->class_start_time }}</div>
                                                <div class="font-size13 text-light-gray">-</div>
                                                <div class="font-size13 text-light-gray">{{ $data->class_end_time }}</div>
                                            </div>
                                        @endforeach
                                    </td>

                                    <td>
                                        @foreach(\App\Services\TimeTableService::getTimeTableDayClass($section->id,$section->grade[0]->id,"Friday") as $data)
                                            <div class="p-5 border">
                                                <div class="margin-10px-top font-size14">{{ $data->teacher->user->name ?? '' }}</div>
                                                <div class="margin-10px-top font-size14"><b>{{ $data->subject->name ?? '' }}</b></div>
                                                <div class="font-size13 text-light-gray">{{ $data->class_start_time }}</div>
                                                <div class="font-size13 text-light-gray">-</div>
                                                <div class="font-size13 text-light-gray">{{ $data->class_end_time }}</div>
                                            </div>
                                        @endforeach
                                    </td>
                                </tr>
                            {{--                            @endforeach--}}

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach

        @include('backend.modals.delete',['name' => 'teacher'])
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            $(".deletebtn").on("click", function (event) {
                event.preventDefault();
                $("#deletemodal").toggleClass("hidden");
                var url = $(this).attr('data-url');
                $(".remove-record").attr("action", url);
            })

            $("#deletemodelclose").on("click", function (event) {
                event.preventDefault();
                $("#deletemodal").toggleClass("hidden");
            })
        })
    </script>
@endpush
