@extends('layouts.guest2')

@section('content')
<!-- breadcrumb -->
<div class="container ">
    <div class="c-breadcrumbs">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="c-breadcrumbs__prePage"><a href="{{url('/')}}" class="text-decoration-none text-black">首頁</a>
                    > 大前輩快找
                </h4>
            </div>
        </div>
    </div>
</div>

<!-- senior cards broccoli ver -->
<div class="container l-seniorPage">
    <div class="row">
        <!-- side bar -->
        <div class="c-sideNav__selections col-lg-3 pr-lg-5">
                <!-- desk btns -->
                <div>
                    <div class="c-sideNav__locations">
                        <button id="englishBtn" onclick="SideBarSelect(1)">英語系國家</button>
                        <hr class="c-sideNav__hr">
                        <button id="europBtn" onclick="SideBarSelect(2)">歐語系國家</button>
                        <hr class="c-sideNav__hr">
                        <button id="asiaBtn" onclick="SideBarSelect(3)">亞洲國家</button>
                    </div>
                </div>
                <!-- mobile btns -->
                <div>
                    <div class="c-sideNav__locationsMobile">
                        <button type="button" data-bs-toggle="collapse" data-bs-target="#englishMobile"
                            aria-expanded="false" aria-controls="#englishMobile">英語系國家</button>
                        <hr>
                        <button type="button" data-bs-toggle="collapse" data-bs-target="#europMobile"
                            aria-expanded="false" aria-controls="#europMobile">歐語系國家</button>
                        <hr>
                        <button type="button" data-bs-toggle="collapse" data-bs-target="#asiaMobile"
                            aria-expanded="false" aria-controls="#asiahMobile">亞洲國家</button>
                    </div>
                </div>
                <!-- popups mobile ver-->
                <div>
                    <div class="l-uniList__popup collapse multi-collapse container" id="englishMobile">
                        <div class="row">
                            <a class="o-basicLink col-4" href="{{route('senior', ['area'=>'NORTHEAST'])}}">美國東北部</a>
                            <a class="o-basicLink col-4" href="{{route('senior', ['area'=>'WEST'])}}">美國西部</a>
                            <a class="o-basicLink col-4" href="{{route('senior', ['area'=>'MIDWEST'])}}">美國中西部</a>
                            <a class="o-basicLink col-4" href="{{route('senior', ['area'=>'SOUTH'])}}">美國南部</a>
                            <a class="o-basicLink col-4" href="{{route('senior', ['country'=>'CANADA'])}}">加拿大</a>
                            <a class="o-basicLink col-4" href="{{route('senior', ['country'=>'UK'])}}">英國</a>
                            <a class="o-basicLink col-4" href="{{route('senior', ['country'=>'AUSTRALIA'])}}">澳洲</a>
                            <a class="o-basicLink col-4" href="{{route('senior', ['country'=>'NEW ZEALAND'])}}">紐西蘭</a>
                        </div>
                    </div>
                    <div class="l-uniList__popup collapse multi-collapse container" id="europMobile">
                        <div class="row">
                            <a class="o-basicLink col-4" href="{{route('senior', ['country'=>'FRANCE'])}}">法國</a>
                            <a class="o-basicLink col-4" href="{{route('senior', ['country'=>'GERMANY'])}}">德國</a>
                            <a class="o-basicLink col-4" href="{{route('senior', ['country'=>'EUROPE'])}}">其他歐洲</a>
                        </div>
                    </div>
                    <div class="l-uniList__popup collapse multi-collapse container" id="asiaMobile">
                        <div class="row">
                            <a class="o-basicLink col-4" href="{{route('senior', ['area'=>'INTERNATIONAL'])}}">台灣｜國際行業</a>
                            <a class="o-basicLink col-4" href="{{route('senior', ['area'=>'HIGHSCHOOL'])}}">台灣｜高中</a>
                            <a class="o-basicLink col-4" href="{{route('senior', ['area'=>'COLLEGE'])}}">台灣｜大學</a>
                            <a class="o-basicLink col-4" href="{{route('senior', ['country'=>'SINGAPORE'])}}">新加坡</a>
                            <a class="o-basicLink col-4" href="{{route('senior', ['country'=>'JAPAN'])}}">日本</a>
                            <a class="o-basicLink col-4" href="{{route('senior', ['country'=>'KOREA'])}}">韓國</a>
                            <a class="o-basicLink col-4" href="{{route('senior', ['country'=>'CHINA'])}}">中國</a>
                            <a class="o-basicLink col-4" href="{{route('senior', ['country'=>'HONG KONG'])}}">香港</a>
                            <a class="o-basicLink col-4" href="{{route('senior', ['country'=>'MACAU'])}}">澳門</a>
                            <a class="o-basicLink col-4" href="{{route('senior', ['country'=>'ASIA'])}}">其他亞洲</a>
                        </div>
                    </div>
                </div>
                <!-- topic -->
                <div>
                    <div class="c-sideNav__topics row">
                        @forelse($post_categories as $category)
                        @if($loop->last)
                        <button class="col-3 col-lg-12 text-center"><a
                                href="{{route('senior', ['category' => $category->id])}}">{{$category->name}}</a>
                                <!-- <hr class="c-sideNav__hr"> -->
                        </button>

                        @else
                        <button class="col-3 col-lg-12 text-center"><a
                                href="{{route('senior', ['category' => $category->id])}}">{{$category->name}}</a>
                                <hr class="c-sideNav__hr">
                        </button>

                        @endif
                        @empty
                        @endforelse
                    </div>
                </div>
            <!-- popup selections desk ver -->
            <div class="c-sideNav__area">
                <svg class="c-sideNav__english" viewBox="0 0 250 350">
                    <path
                        d="M227,0H67.4c-9.9,0-18,8-18,18h0c0,9-4.8,17.3-12.6,21.7L0,61l36.8,21.3c7.8,4.5,12.6,12.8,12.6,21.7v220.4c0,9.9,8,18,18,18h159.7c9.9,0,18-8,18-18V18c0-9.9-8-18-18-18Z"
                        style="fill: #fff; stroke: #4c2a70; stroke-miterlimit: 10;" />
                    <text transform="translate(75 35.5)"
                        style="fill: #4c2a70; font-family: MyriadPro-Regular; font-size: 20px;"><a
                            href="{{route('senior', ['area'=>'NORTHEAST'])}}" class="text-none">美國東北部</a></text>
                    <text transform="translate(75 75.1)"
                        style="fill: #4c2a70; font-family: MyriadPro-Regular; font-size: 20px;">
                        <a href="{{route('senior', ['area'=>'WEST'])}}" class="text-none">美國西部</a>
                    </text>
                    <text transform="translate(75 114.7)"
                        style="fill: #4c2a70; font-family: MyriadPro-Regular; font-size: 20px;">
                        <a href="{{route('senior', ['area'=>'MIDWEST'])}}" class="text-none">美國中西部</a>
                    </text>
                    <text transform="translate(75 154.2)"
                        style="fill: #4c2a70; font-family: MyriadPro-Regular; font-size: 20px;">
                        <a href="{{route('senior', ['area'=>'SOUTH'])}}" class="text-none">美國南部</a>
                    </text>
                    <text transform="translate(75 193.8)"
                        style="fill: #4c2a70; font-family: MyriadPro-Regular; font-size: 20px;">
                        <a href="{{route('senior', ['country'=>'CANADA'])}}" class="text-none">加拿大</a>
                    </text>
                    <text transform="translate(75 233.4)"
                        style="fill: #4c2a70; font-family: MyriadPro-Regular; font-size: 20px;">
                        <a href="{{route('senior', ['country'=>'UK'])}}" class="text-none">英國</a>
                    </text>
                    <text transform="translate(75 272.9)"
                        style="fill: #4c2a70; font-family: MyriadPro-Regular; font-size: 20px;">
                        <a href="{{route('senior', ['country'=>'AUSTRALIA'])}}" class="text-none">澳洲</a>
                    </text>
                    <text transform="translate(75 312.5)"
                        style="fill: #4c2a70; font-family: MyriadPro-Regular; font-size: 20px;">
                        <a href="{{route('senior', ['country'=>'NEW ZEALAND'])}}" class="text-none">紐西蘭</a>
                    </text>
                    <line x1="70.7" y1="49.4" x2="220.7" y2="49.4"
                        style="fill: none; stroke: #000; stroke-miterlimit: 10;" />
                    <line x1="70.7" y1="89" x2="220.7" y2="89"
                        style="fill: none; stroke: #000; stroke-miterlimit: 10;" />
                    <line x1="70.7" y1="128.6" x2="220.7" y2="128.6"
                        style="fill: none; stroke: #000; stroke-miterlimit: 10;" />
                    <line x1="70.7" y1="168.1" x2="220.7" y2="168.1"
                        style="fill: none; stroke: #000; stroke-miterlimit: 10;" />
                    <line x1="70.7" y1="207.7" x2="220.7" y2="207.7"
                        style="fill: none; stroke: #000; stroke-miterlimit: 10;" />
                    <line x1="70.7" y1="247.3" x2="220.7" y2="247.3"
                        style="fill: none; stroke: #000; stroke-miterlimit: 10;" />
                    <line x1="70.7" y1="286.9" x2="220.7" y2="286.9"
                        style="fill: none; stroke: #000; stroke-miterlimit: 10;" />
                </svg>
                <svg class="c-sideNav__europ" viewBox="0 0 250 250">
                    <path
                        d="M226.9,0H67.4c-9.9,0-18,8.1-18,18.3h0c0,9.1-4.8,17.6-12.6,22L0,61.9l36.8,21.6c7.8,4.6,12.6,13,12.6,22v16.2c0,10,8,18.3,18,18.3h159.6c9.9,0,18-8.1,18-18.3V18.3c0-10-8-18.3-18-18.3h0Z"
                        style="fill: #fff; stroke: #4c2a70; stroke-miterlimit: 10;" />
                    <text transform="translate(75 35.5)"
                        style="fill: #4c2a70; font-family: MyriadPro-Regular; font-size: 20px;">
                        <a href="{{route('senior', ['country'=>'FRANCE'])}}" class="text-none">法國</a>
                    </text>
                    <text transform="translate(75 75.1)"
                        style="fill: #4c2a70; font-family: MyriadPro-Regular; font-size: 20px;">
                        <a href="{{route('senior', ['country'=>'GERMANY'])}}" class="text-none">德國</a>
                    </text>
                    <text transform="translate(75 114.7)"
                        style="fill: #4c2a70; font-family: MyriadPro-Regular; font-size: 20px;">
                        <a href="{{route('senior', ['country'=>'EUROPE'])}}" class="text-none">其他歐洲</a>
                    </text>
                    <line x1="70.7" y1="49.4" x2="220.7" y2="49.4"
                        style="fill: none; stroke: #000; stroke-miterlimit: 10;" />
                    <line x1="70.7" y1="89" x2="220.7" y2="89"
                        style="fill: none; stroke: #000; stroke-miterlimit: 10;" />
                </svg>
                <svg class="c-sideNav__asia" viewBox="0 0 250 420">
                    <path
                        d="M226.9,0H67.4c-9.9,0-18,8-18,18h0c0,9-4.8,17.3-12.6,21.6L0,60.9l36.8,21.2c7.8,4.5,12.6,12.8,12.6,21.6v293.3c0,9.9,8,18,18,18h159.6c9.9,0,18-8,18-18V18c0-9.9-8-18-18-18h0Z"
                        style="fill: #fff; stroke: #4c2a70; stroke-miterlimit: 10;" />
                    <text transform="translate(75 35.5)"
                        style="fill: #4c2a70; font-family: MyriadPro-Regular; font-size: 20px;">
                        <a href="{{route('senior', ['area'=>'INTERNATIONAL'])}}" class="text-none">台灣｜國際行業</a>
                    </text>
                    <text transform="translate(75 75)"
                        style="fill: #4c2a70; font-family: MyriadPro-Regular; font-size: 20px;">
                        <a href="{{route('senior', ['area'=>'HIGHSCHOOL'])}}" class="text-none">台灣｜高中</a>
                    </text>
                    <text transform="translate(75 114.6)"
                        style="fill: #4c2a70; font-family: MyriadPro-Regular; font-size: 20px;">
                        <a href="{{route('senior', ['area'=>'COLLEGE'])}}" class="text-none">台灣｜大學</a>
                    </text>
                    <text transform="translate(75 154.1)"
                        style="fill: #4c2a70; font-family: MyriadPro-Regular; font-size: 20px;">
                        <a href="{{route('senior', ['country'=>'SINGAPORE'])}}" class="text-none">新加坡</a>
                    </text>
                    <text transform="translate(75 193.7)"
                        style="fill: #4c2a70; font-family: MyriadPro-Regular; font-size: 20px;">
                        <a href="{{route('senior', ['country'=>'JAPAN'])}}" class="text-none">日本</a>
                    </text>
                    <text transform="translate(75 233.2)"
                        style="fill: #4c2a70; font-family: MyriadPro-Regular; font-size: 20px;">
                        <a href="{{route('senior', ['country'=>'KOREA'])}}" class="text-none">韓國</a>
                    </text>
                    <text transform="translate(75 272.8)"
                        style="fill: #4c2a70; font-family: MyriadPro-Regular; font-size: 20px;">
                        <a href="{{route('senior', ['country'=>'CHINA'])}}" class="text-none">中國</a></text>
                    <text transform="translate(75 312.3)"
                        style="fill: #4c2a70; font-family: MyriadPro-Regular; font-size: 20px;">
                        <a href="{{route('senior', ['country'=>'HONG KONG'])}}" class="text-none">香港</a>
                    </text>
                    <text transform="translate(75 351.9)"
                        style="fill: #4c2a70; font-family: MyriadPro-Regular; font-size: 20px;">
                        <a href="{{route('senior', ['country'=>'MACAU'])}}" class="text-none">澳門</a>
                    </text>
                    <text transform="translate(75 391.4)"
                        style="fill: #4c2a70; font-family: MyriadPro-Regular; font-size: 20px;">
                        <a href="{{route('senior', ['country' => 'ASIA'])}}">其他亞洲</a></text>
                    <line x1="70.7" y1="49.4" x2="220.7" y2="49.4"
                        style="fill: none; stroke: #000; stroke-miterlimit: 10;" />
                    <line x1="70.7" y1="88.9" x2="220.7" y2="88.9"
                        style="fill: none; stroke: #000; stroke-miterlimit: 10;" />
                    <line x1="70.7" y1="128.5" x2="220.7" y2="128.5"
                        style="fill: none; stroke: #000; stroke-miterlimit: 10;" />
                    <line x1="70.7" y1="168" x2="220.7" y2="168"
                        style="fill: none; stroke: #000; stroke-miterlimit: 10;" />
                    <line x1="70.7" y1="207.6" x2="220.7" y2="207.6"
                        style="fill: none; stroke: #000; stroke-miterlimit: 10;" />
                    <line x1="70.7" y1="247.1" x2="220.7" y2="247.1"
                        style="fill: none; stroke: #000; stroke-miterlimit: 10;" />
                    <line x1="70.7" y1="286.7" x2="220.7" y2="286.7"
                        style="fill: none; stroke: #000; stroke-miterlimit: 10;" />
                    <line x1="70.7" y1="326.2" x2="220.7" y2="326.2"
                        style="fill: none; stroke: #000; stroke-miterlimit: 10;" />
                    <line x1="70.7" y1="365.8" x2="220.7" y2="365.8"
                        style="fill: none; stroke: #000; stroke-miterlimit: 10;" />
                </svg>
            </div>
        </div>
        <!-- cards -->
        <div class="col-lg-9">
            <div class="l-seniorPage__content">
                <div class="container-fluid">
                    <div class="row gy-5 p-md-5">
                        @forelse($users->sortByDesc(function($user){return $user->liked_user_count +
                        $user->collected_user_count;}) as $user)
                        <div class="col-6 col-md-4 p-0">
                            <div class="c-studentCard" onclick="cardClickable({{ $user->id }})">
                                <!-- img div -->
                                @if(is_null($user->avatar))
                                <span class="c-studentCard_studentImg"
                                    style="background-image: url('{{asset('uploads/images/default_avatar.png')}}') ;">&nbsp;</span>
                                @else
                                <span class="c-studentCard_studentImg"
                                    style="background-image: url('/uploads/{{ $user->avatar }}');">&nbsp;</span>
                                @endif
                                <!-- background -->
                                <svg class="c-studentCard_bg" viewBox="0 0 330 170">
                                    <polygon class="cls-1" points="329.5 170 0 170 0 0 330 45.1 329.5 170" />
                                </svg>
                                <!-- school img -->
                                <span class="c-studentCard_schoolImg"
                                    style="background-image: url('{{asset($user->universityItem->image_path)}}') ;">&nbsp;</span>
                                <!-- name card -->
                                <h4 class="c-studentCard_userName">
                                    {{ ($user->nickname) ? \Illuminate\Support\Str::limit($user->nickname,8): "" }}
                                </h4>
                                <!-- school english -->
                                <h5 class="c-studentCard_schoolEnglish">
                                    {{ !is_null($user->universityItem) ? $user->universityItem->english_name : '' }}
                                </h5>
                                <!-- school chinese -->
                                <h6 class="c-studentCard_schoolChinese">
                                    {{ !is_null($user->universityItem) ? \Illuminate\Support\Str::limit($user->universityItem->chinese_name, 10) : '' }}
                                </h6>
                                <!-- react icons -->
                                <div class="c-studentCard_react" onclick="event.stopPropagation(); return false; ">
                                    @if(auth()->check())
                                    <i class="bi @if($user->likedUser->where('uid', auth()->user()->id)->where('user_id', $user->id)->count() == 1) bi-heart-fill @else bi-heart @endif like-user"
                                        style="color:@if($user->likedUser->where('uid', auth()->user()->id)->where('user_id', $user->id)->count() == 1) red @else black @endif"
                                        data-id="{{$user->id}}">
                                        <span>{{$user->likedUser->count()}}</span>
                                    </i>
                                    <i class="bi @if($user->collectedUser->where('uid', auth()->user()->id)->where('user_id', $user->id)->count() == 1) bi-bookmark-fill @else bi-bookmark @endif collect-user"
                                        data-id="{{$user->id}}"
                                        style="color:  @if($user->collectedUser->where('uid', auth()->user()->id)->where('user_id', $user->id)->count() == 1) red @else black @endif">
                                        <span>{{$user->collectedUser->count()}}</span>
                                    </i>
                                    @else
                                    <i class="bi bi-heart like-user" style="color: black;" data-id="{{$user->id}}">
                                        <span>{{$user->likedUser->count()}}</span>
                                    </i>
                                    <i class="bi bi-bookmark collect-user" data-id="{{$user->id}}">
                                        <span>{{$user->collectedUser->count()}}</span>
                                    </i>
                                    @endif
                                </div>
                                <!-- post tag -->
                                <div class="c-studentCard_postTag">
                                    @forelse ($user->postCategory as $count => $cate)
                                    @if ($count < 3) <a
                                        href="{{route('senior', ['category' => $cate->postCategory->id])}}"
                                        class="text-white">
                                        {{ $cate->postCategory->name }}
                                        </a>
                                        @endif
                                        @empty
                                        @endforelse
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-md-12">
                            <p class="h-100">
                                目前尚無大前輩資料
                            </p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 p-md-5">
            <div class="c-pagination">
                {!! $users->links('vendor.pagination.bootstrap-4') !!}
            </div>
        </div>
    </div>
</div>

@endsection

@section('page_js')
<script>
    $('.like-user').click(function () {
        let that = $(this);
        $.ajax({
            url: "{{url('like-user')}}" + "/" + $(this).data('id'),
            method: 'GET',
            success: function (res) {
                if (res.operator === 'no') {
                    alert(res.message);
                } else if (res.operator === 'add') {
                    that.removeClass('bi-heart').removeClass('bi-heart-fill').addClass(
                        'bi-heart-fill').css('color', 'red');
                    that.children('span').text(res.total);
                } else if (res.operator === 'reduce') {
                    that.removeClass('bi-heart').removeClass('bi-heart-fill').addClass('bi-heart')
                        .css('color', 'black');
                    that.children('span').text(res.total);
                }
            },
            error: function (error) {
                console.log(error)
            }
        });
    });

    $('.collect-user').click(function () {
        let that = $(this);
        $.ajax({
            url: "{{url('collect-user')}}" + "/" + $(this).data('id'),
            method: 'GET',
            success: function (res) {
                if (res.operator === 'no') {
                    alert(res.message);
                } else if (res.operator === 'add') {
                    that.removeClass('bi-bookmark').removeClass('bi-bookmark-fill').addClass(
                        'bi-bookmark-fill').css('color', 'red');
                    that.children('span').text(res.total);
                } else if (res.operator === 'reduce') {
                    that.removeClass('bi-bookmark').removeClass('bi-bookmark-fill').addClass(
                        'bi-bookmark').css('color', 'black');
                    that.children('span').text(res.total);
                }
            },
            error: function (error) {
                console.log(error)
            }
        });
    });
</script>
@endsection