@extends('layouts.app-layouts')
@section('content')
<main>
    <div class="fw-bold fs-4 mt-5 ms-4" id="search_results_message"></div>
    <div class="row mt-4 ms-4 fs-5 fw-bold">
        <div class="col-auto px-0 pb-2" id="show_all_results"><a href="javascript:void(0)">모든 결과</a></div>
        <div class="col-auto px-0 pb-2 ms-4" id="show_set_results"><a href="javascript:void(0)">학습 세트</a></div>
        <div class="col-auto px-0 pb-2 ms-4" id="show_user_results"><a href="javascript:void(0)">사용자</a></div>
    </div>
    <div id="set_results_div">
        <div class="row fs-5 fw-bold mt-5">
            <div class="col-2" style="padding-left: 3%;">학습 세트</div>
        </div>
        <div class="d-flex flex-wrap">
            @foreach ( $searched_sets as $key => $sets )
            <a style="width: 31%; display: flex; margin-left: 2%; height: 200px; margin-top: 2%;" href="{{ route("show-set", $sets->id) }}">
                <div class="mb-5 border border-2 ps-3 pt-3" style="height: 200px; width: 100%; border-radius: 20px;">
                    <div class="fw-bold fs-5 text-start mb-2 title">{{  $sets['title'] }}</div>
                    <span class="rounded-pill px-3 fw-bold pb-1 num" style="background-color: rgb(196, 191, 236);"></span>
                    <div class="row d-flex align-items-center" style="margin-top: 17%;">
                        <div class="col-auto pe-0">
                            <div class="rounded-circle d-flex align-items-center justify-content-center profile_div" 
                                style="background-color: gainsboro; width: 40px; height: 40px;">
                                <img src="/image/user.png" style="width: 70%;">
                            </div>
                        </div>
                        <div style="font-size: 17px;" class="name fw-bold col-auto"></div>
                        <input type="hidden" value="{{  $sets['email'] }}" class="email_value">
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    <div id="user_results_div">
        <div class="row fs-5 fw-bold mt-5">
            <div class="col-2" style="padding-left: 3%;">사용자</div>
        </div>
        <div class="d-flex flex-wrap">
            @foreach ( $searched_users as $key => $users )
            <a style="width: 48%; display: flex; margin-left: 2%; height: 230px; margin-top:2%;" href="{{ route('creator', $users->name) }}">
                <div class="mb-5 border border-2 ps-3 pt-3" style="height: 100%; width: 100%; border-radius: 20px;">
                    <div class="row d-flex align-items-center" style="margin-top: 1%;">
                        <div class="col-auto pe-0">
                            <div class="rounded-circle d-flex align-items-center justify-content-center user_profile_bg"
                                style="background-color: gainsboro; width: 80px; height: 80px;">
                                @if($users['profile'] == null)
                                <img src="/image/user.png" style="width: 70%;" class="user_profile">
                                @else
                                <img src="/image/{{ $users['profile'] }}.png" style="width: 70%;" class="user_profile">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="fw-bold text-start mb-2" style="font-size: 22px; margin-top: 7%;">{{  $users['name'] }}</div>
                    <input type="hidden" value="{{  $users['email'] }}" class="user_email_value">
                    <span class="rounded-pill px-3 fw-bold pb-1 set_num" style="background-color: rgb(196, 191, 236);"></span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    
</main>



<script>
    // 컨트롤러에서 변수 받아오기
    <?php 
        echo "let search = " . json_encode($search) . ";";
        echo "let searched_sets = " . json_encode($searched_sets) . ";";
        echo "let searched_users = " . json_encode($searched_users) . ";";
        echo "let number_of_cards = " . json_encode($number_of_cards) . ";";
        echo "let userinfo = " . json_encode($userinfo) . ";";
        echo "let number_of_sets = " . json_encode($number_of_sets) . ";";
    ?>

    // 검색 결과 표시
    search_input = document.querySelector('.search_input');

    let search_results_message = document.querySelector('#search_results_message');
    search_results_message.innerText = '"' + search + '" 검색 결과';

    // 결과 없으면 화면 없애기
    let set_results_div = document.querySelector('#set_results_div');
    if(searched_sets == '') {
        set_results_div.style.display = 'none';
    }
    let user_results_div = document.querySelector('#user_results_div');
    if(searched_users == '') {
        user_results_div.style.display = 'none';
    }

    // 밑줄 표시
    let show_all_results = document.querySelector('#show_all_results');
    let show_set_results = document.querySelector('#show_set_results');
    let show_user_results = document.querySelector('#show_user_results');

    show_all_results.addEventListener('click', () => {
        show_all_results.style.borderBottom = '4px solid mediumpurple';
        show_set_results.style.border = 'none';
        show_user_results.style.border = 'none';

        if(searched_sets != '') set_results_div.style.display = 'block';
        if(searched_users != '') user_results_div.style.display = 'block';
    });

    show_set_results.addEventListener('click', () => {
        show_all_results.style.border = 'none';
        show_set_results.style.borderBottom = '4px solid mediumpurple';
        show_user_results.style.border = 'none';

        if(searched_sets != '') set_results_div.style.display = 'block';
        if(searched_users != '') user_results_div.style.display = 'none';
    });

    show_user_results.addEventListener('click', () => {
        show_all_results.style.border = 'none';
        show_set_results.style.border = 'none';
        show_user_results.style.borderBottom = '4px solid mediumpurple';

        if(searched_sets != '') set_results_div.style.display = 'none';
        if(searched_users != '') user_results_div.style.display = 'block';
    });

    // 학습 세트 결과 - 단어 갯수 표시
    let num_all = document.querySelectorAll('.num');
    number_of_cards.forEach(nc => {
        num_all.forEach(na => {
            if(na.previousElementSibling.innerText == nc['set_title']) {
                na.innerText = nc['count'] + ' 단어';
            }
        })
    })

    // 학습 세트 결과 - 작성자 표시
    let email_value_all = document.querySelectorAll('.email_value');
    email_value_all.forEach(ev => {
        userinfo.forEach(en => {
            if(ev.value == en['email']) {
                ev.previousElementSibling.innerText = en['name'];

                let profile_icon = ev.previousElementSibling.previousElementSibling.children[0].children[0];
                let profile_div = ev.previousElementSibling.previousElementSibling.children[0];

                if(en['profile'] == null) {
                    profile_icon.src = '/image/user.png';
                } else {
                    profile_icon.src = '/image/' + en['profile'] + '.png';
                }

                if(en['profile'] == null) {
                    profile_div.style.backgroundColor = 'gainsboro';
                } else if(en['profile'] == 'rabbit') {
                    profile_div.style.backgroundColor = 'mediumslateblue';
                } else if(en['profile'] == 'dog') {
                    profile_div.style.backgroundColor = 'salmon';
                } else if(en['profile'] == 'kitty') {
                    profile_div.style.backgroundColor = 'lightgreen';
                } else if(en['profile'] == 'bear') {
                    profile_div.style.backgroundColor = 'lightseagreen';
                } else if(en['profile'] == 'elephant') {
                    profile_div.style.backgroundColor = 'pink';
                } else if(en['profile'] == 'fox') {
                    profile_div.style.backgroundColor = 'darkslateblue';
                } else if(en['profile'] == 'owl') {
                    profile_div.style.backgroundColor = 'darkviolet';
                } else if(en['profile'] == 'panda') {
                    profile_div.style.backgroundColor = 'rosybrown';
                } else {
                    profile_div.style.backgroundColor = 'navajowhite';
                }
       }
        })
    })

    // 유저 결과 - 학습 세트 갯수 표시
    let set_num_all = document.querySelectorAll('.set_num');
    number_of_sets.forEach(ns => {
        set_num_all.forEach(sn => {
            if(sn.previousElementSibling.value == ns['email']) {
                sn.innerText = ns['count'] + ' 학습 세트';
            }
        })
    });
    

    // 유저 결과 - 작성자 표시
    let user_profile_all = document.querySelectorAll('.user_profile');
    let user_profile_bg_all = document.querySelectorAll('.user_profile_bg');

    user_profile_all.forEach(up => {
        user_profile_bg_all.forEach(bg => {
            if(up.src.includes('wolf')) {
                bg.style.backgroundColor = 'navajowhite';
            } else if(up.src.includes('rabbit')) {
                bg.style.backgroundColor = 'mediumslateblue';
            } else if(up.src.includes('dog')) {
                bg.style.backgroundColor = 'salmon';
            } else if(up.src.includes('kitty')) {
                bg.style.backgroundColor = 'lightgreen';
            } else if(up.src.includes('bear')) {
                bg.style.backgroundColor = 'lightseagreen';
            } else if(up.src.includes('elephant')) {
                bg.style.backgroundColor = 'pink';
            } else if(up.src.includes('fox')) {
                bg.style.backgroundColor = 'darkslateblue';
            } else if(up.src.includes('owl')) {
                bg.style.backgroundColor = 'darkviolet';
            } else if(up.src.includes('panda')) {
                bg.style.backgroundColor = 'rosybrown';
            } else {
                bg.style.backgroundColor = 'gainsboro';
       }
        })
    })
</script>

<style>
    #show_all_results {
        border-bottom: 4px solid mediumpurple;
    }
</style>
@endsection