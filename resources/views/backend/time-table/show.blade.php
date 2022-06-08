@extends('layouts.frontend')

@section('content')

{{--    <div class="w-full max-w-xs mx-auto">--}}
        @foreach(\App\Services\TimeTableService::allSection() as $section)
            <div class="mt-8 p-5 bg-white rounded w-full border-b-4 border-gray-300">
                <h3 class="text-center" style="font-size: 25px">
                    Class: {{ $section->grade[0]->class_name }} ({{ $section->name }}) - {{ \App\Services\TimeTableService::allRoom($section->id) ?? null  }}
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
{{--    </div>--}}

@endsection
