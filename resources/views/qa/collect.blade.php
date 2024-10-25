@extends('layouts.sbadmin')

@section('content')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content" style="margin:15px">

            <div class="row justify-content-md-center">
                <div style="margin-bottom: 10px;" class="col-xl-10 col-lg-7">
                    <div style="background: #4C2A70; padding:5px" class="card text-white shadow">
                        <h2 style="margin: 0;" class="text-center">收藏的問題</h2>
                    </div>
                </div>
                <div class="col-xl-10 col-lg-7">
                    <div class="card shadow mb-4">
                        @foreach ($Data['QandA'] as $key => $qa)
                        <!-- Card Body -->
                        <div style="background: #FFFFFF;"
                            class="card-body d-flex justify-content-center">
                            <div class="col-xl-10 col-lg-7">
                                <div class="card d-flex justify-content-center shadow" style="border-right: 50px solid #4C2A70">
                                    <!-- Card Header - Dropdown -->
                                    <div class="d-flex flex-row align-items-center justify-content-between">
                                    <p class="ml-3 o-articleTitle"> {{ Illuminate\Support\Str::limit($qa->title, 26)  }}...</p>
                                        <div class="dropdown no-arrow">
                                            <a style="margin:5px" class="dropdown-toggle" href="#" role="button"
                                                id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                aria-labelledby="dropdownMenuLink">
                                                <div class="dropdown-header">動作:</div>
                                                <a class="dropdown-item" href="{{ route('qna.show', $qa->id) }}">查看</a>
{{--                                                <a class="dropdown-item" href="/edit-qa/{{ $qa->uuid }}">編輯</a>--}}
                                                <a class="dropdown-item" href="/delete-collect-qa/{{ $qa->uuid }}">刪除</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">


                                        <h4 style="align-items: center;">
                                            @forelse($qa->categoryRelation as $relation)
                                                <span style="background: #4C2A70; color:#FFFFFF" href="#" class="d-none d-sm-inline-block btn btn-sm shadow-sm">
                                                    {{$relation->category->name}}
                                                </span>
                                            @empty
                                            @endforelse
                                        </h4>
                                        <p>{!! Illuminate\Support\Str::limit($qa->body, 300) !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
