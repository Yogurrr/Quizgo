@extends('layouts.app-layouts')
@section('content')
<main>
    <div class="mt-5 d-flex flex-wrap">
        @foreach ( $sets as $key => $set )
        <a style="width: 31%; display: flex; margin-left: 2%;" href="{{ route("show-set", $set->id) }}">
            <div class="mb-5 border border-2 ps-3 pt-3" style="height: 200px; width: 100%; border-radius: 20px;">
                <div class="fw-bold fs-5 text-start mb-2 title">{{  $set['title'] }}</div>
                <span class="rounded-pill px-3 fw-bold pb-1 num" style="background-color: rgb(196, 191, 236);"></span>
                <div class="row d-flex align-items-center" style="margin-top: 17%;">
                    <div class="col-auto pe-0">
                        <div class="rounded-circle d-flex align-items-center justify-content-center profile_div" 
                            style="background-color: gainsboro; width: 40px; height: 40px;">
                            <img src="/image/user.png" style="width: 70%;">
                        </div>
                    </div>
                    <div style="font-size: 17px;" class="name fw-bold col-auto"></div>
                    <input type="hidden" value="{{  $set['email'] }}" class="email_value">
                </div>
            </div>
        </a>
        @endforeach
    </div>
</main>



<script>
    // 컨트롤러에서 변수 받아오기
    <?php 
        echo "let number_of_cards = " . json_encode($number_of_cards) . ";";
        echo "let userinfo = " . json_encode($userinfo) . ";";
    ?>
    let num_all = document.querySelectorAll('.num');
    number_of_cards.forEach(nc => {
        num_all.forEach(na => {
            if(na.previousElementSibling.innerText == nc['set_title']) {
                na.innerText = nc['count'] + ' 단어';
            }
        })
    })

    // 작성자 표시
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

                if(en['profile'] == '') {
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
                } else if(en['profile'] == 'wolf'){
                    profile_div.style.backgroundColor = 'navajowhite';
                }
            }
        })
    })
</script>
@endsection