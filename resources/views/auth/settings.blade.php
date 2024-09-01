@extends('layouts.app-layouts')
@section('content')
<main>
    <div class="row">
        <div class="offset-1 col-10">
            <div class="fw-bold mt-4" style="font-size: 50px;">설정</div>
            <div class="border border-3 mt-5 fs-5" style="border-radius: 15px;">
                <div class="border-bottom p-4">
                    <div class="fw-bold">프로필 사진</div>
                    <div class="row mt-2">
                        <div class="col-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                style="background-color: gainsboro; width: 130px; height: 130px;" id="profile_icon">
                                <img src="/image/user.png" style="width: 70%;">
                            </div>
                        </div>
                        <div class="col-10" style="display: flex;">
                            <div style="width: 10%;">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                    style="background-color: gainsboro; width: 70px; height: 70px;" id="user_icon">
                                    <img src="/image/user.png" style="width: 70%;">
                                </div>
                            </div>
                            <div style="width: 10%;">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                    style="background-color: mediumslateblue; width: 70px; height: 70px;" id="rabbit_icon">
                                    <img src="/image/rabbit.png" style="width: 70%;">
                                </div>
                            </div>
                            <div style="width: 10%;">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                    style="background-color: salmon; width: 70px; height: 70px;" id="dog_icon">
                                    <img src="/image/dog.png" style="width: 70%;">
                                </div>
                            </div>
                            <div style="width: 10%;">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                    style="background-color: lightgreen; width: 70px; height: 70px;" id="kitty_icon">
                                    <img src="/image/kitty.png" style="width: 70%;">
                                </div>
                            </div>
                            <div style="width: 10%;">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                    style="background-color: lightseagreen; width: 70px; height: 70px;" id="bear_icon">
                                    <img src="/image/bear.png" style="width: 70%;">
                                </div>
                            </div>
                            <div style="width: 10%;">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                    style="background-color: pink; width: 70px; height: 70px;" id="elephant_icon">
                                    <img src="/image/elephant.png" style="width: 70%;">
                                </div>
                            </div>
                            <div style="width: 10%;">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                    style="background-color: darkslateblue; width: 70px; height: 70px;" id="fox_icon">
                                    <img src="/image/fox.png" style="width: 70%;">
                                </div>
                            </div>
                            <div style="width: 10%;">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                    style="background-color: darkviolet; width: 70px; height: 70px;" id="owl_icon">
                                    <img src="/image/owl.png" style="width: 70%;">
                                </div>
                            </div>
                            <div style="width: 10%;">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                    style="background-color: rosybrown; width: 70px; height: 70px;" id="panda_icon">
                                    <img src="/image/panda.png" style="width: 70%;">
                                </div>
                            </div>
                            <div style="width: 10%;">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                    style="background-color: navajowhite; width: 70px; height: 70px;" id="wolf_icon">
                                    <img src="/image/wolf.png" style="width: 70%;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-bottom p-4 row">
                    <div class="col-9">
                        <div class="fw-bold">사용자 이름</div>
                        <div class="text-secondary mt-2">{{ Auth::user()->name }}</div>
                    </div>
                    <div class="col-3 text-end d-flex align-items-center justify-content-end">
                        <button type="button" class="btn modify_btn" data-bs-toggle="modal" 
                            data-bs-target="#modal" id="modify_name_btn">수정</button>
                    </div>
                </div>
                <div class="border-bottom p-4 row">
                    <div class="col-9">
                        <div class="fw-bold">이메일</div>
                        <div class="text-secondary mt-2">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="col-3 text-end d-flex align-items-center justify-content-end">
                        <button type="button" class="btn modify_btn" data-bs-toggle="modal" 
                            data-bs-target="#modal" id="modify_email_btn">수정</button>
                    </div>
                </div>
                <div class="border-bottom p-4">
                    <div class="fw-bold">개인정보 보호</div>
                    <div class="row mt-4">
                        <div class="col-6 text-secondary d-flex align-items-end">실명 보이기</div>
                        <div class="form-check form-switch col-6 d-flex align-items-center justify-content-end">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                        </div>
                    </div>
                </div>
                <div class="p-4 row">
                    <div class="col-9">
                        <div class="fw-bold">계정 삭제</div>
                        <div class="text-secondary mt-2">계정 삭제 시 모든 데이터가 삭제되며 취소할 수 없습니다.</div>
                    </div>
                    <div class="col-3 text-end">
                        <button type="button" class="btn text-light fw-bold fs-5 px-5 py-3" data-bs-toggle="modal" data-bs-target="#modal"
                            style="background-color: firebrick; border-radius: 15px;" id="del_acct_btn">계정 삭제</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 토스트 -->
    <div class="toast-container position-fixed bottom-0 start-0 p-3" style="width: 500px;">
        <div id="liveToast" class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true" style="width: 500px;">
            <div class="d-flex">
                <div class="toast-body fs-5 ps-4 py-4">
                    프로필 사진이 업데이트 되었습니다!
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
</main>

<!-- 모달 -->
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modify_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 15px;">
            <form action="{{ route('update-name') }}" method="POST" id="modal_form">
                @csrf
                <div class="modal-header" style="border: none; padding: 4% 4% 0 0;">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mb-5" style="padding: 2% 4%;">
                    <div class="fw-bold mb-5" style="font-size: 40px;" id="modal_title">사용자 이름 변경</div>
                    <input type="text" class="form-control" placeholder="새로운 사용자 이름" id="modal_input" name="name">
                </div>
                <div class="modal-footer">
                    <div style="padding: 1%;">
                        <button type="button" class="btn border border-3 fs-5 fw-bold me-3" data-bs-dismiss="modal">취소</button>
                        <button type="submit" class="btn fs-5 fw-bold" style="background-color: rgb(196, 191, 236);" id="save_btn">저장</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>




<script>
    // 컨트롤러에서 변수 받아오기
    <?php 
        echo "let userinfo = " . json_encode($userinfo) . ";";
    ?>

    // 프로필 사진 띄우기
    let profile_icon = document.querySelector('#profile_icon');

    if(userinfo[0]['profile'] == null) {
        profile_icon.style.backgroundColor = 'gainsboro';
        profile_icon.innerHTML = `
            <img src="/image/user.png" style="width: 70%;">
        `;
    } else if(userinfo[0]['profile'] == 'rabbit') {
        profile_icon.style.backgroundColor = 'mediumslateblue';
        profile_icon.innerHTML = `
            <img src="/image/rabbit.png" style="width: 70%;">
        `;
    } else if(userinfo[0]['profile'] == 'bear') {
        profile_icon.style.backgroundColor = 'lightseagreen';
        profile_icon.innerHTML = `
            <img src="/image/bear.png" style="width: 70%;">
        `;
    } else if(userinfo[0]['profile'] == 'dog') {
        profile_icon.style.backgroundColor = 'salmon';
        profile_icon.innerHTML = `
            <img src="/image/dog.png" style="width: 70%;">
        `;
    } else if(userinfo[0]['profile'] == 'elephant') {
        profile_icon.style.backgroundColor = 'pink';
        profile_icon.innerHTML = `
            <img src="/image/elephant.png" style="width: 70%;">
        `;
    } else if(userinfo[0]['profile'] == 'fox') {
        profile_icon.style.backgroundColor = 'darkslateblue';
        profile_icon.innerHTML = `
            <img src="/image/fox.png" style="width: 70%;">
        `;
    } else if(userinfo[0]['profile'] == 'kitty') {
        profile_icon.style.backgroundColor = 'lightgreen';
        profile_icon.innerHTML = `
            <img src="/image/kitty.png" style="width: 70%;">
        `;
    } else if(userinfo[0]['profile'] == 'owl') {
        profile_icon.style.backgroundColor = 'darkviolet';
        profile_icon.innerHTML = `
            <img src="/image/owl.png" style="width: 70%;">
        `;
    } else if(userinfo[0]['profile'] == 'panda') {
        profile_icon.style.backgroundColor = 'rosybrown';
        profile_icon.innerHTML = `
            <img src="/image/panda.png" style="width: 70%;">
        `;
    } else if(userinfo[0]['profile'] == 'wolf') {
        profile_icon.style.backgroundColor = 'navajowhite';
        profile_icon.innerHTML = `
            <img src="/image/wolf.png" style="width: 70%;">
        `;
    }

    // 프로필 사진 바꾸기
    let rabbit_icon = document.querySelector('#rabbit_icon');
    let bear_icon = document.querySelector('#bear_icon');
    let dog_icon = document.querySelector('#dog_icon');
    let elephant_icon = document.querySelector('#elephant_icon');
    let fox_icon = document.querySelector('#fox_icon');
    let kitty_icon = document.querySelector('#kitty_icon');
    let owl_icon = document.querySelector('#owl_icon');
    let panda_icon = document.querySelector('#panda_icon');
    let user_icon = document.querySelector('#user_icon');
    let wolf_icon = document.querySelector('#wolf_icon');
    let profile = 'user';

    const toastLiveExample = document.getElementById('liveToast')
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);

    // 프로필 사진 바꾸기 함수
    let change_profile_function = (profile) => {
        profile_icon.innerHTML = `
            <img src="/image/${profile}.png" style="width: 70%;">
        `;

        // ajax
        fetch('/update-profile', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ 
                profile: profile,
            })
        })
        .catch(error => console.error('Error:', error));

        toastBootstrap.show()
    }

    rabbit_icon.addEventListener('click', () => {
        profile_icon.style.backgroundColor = 'mediumslateblue';
        profile = 'rabbit';
        change_profile_function(profile);
    });

    bear_icon.addEventListener('click', () => {
        profile_icon.style.backgroundColor = 'lightseagreen';
        profile = 'bear';
        change_profile_function(profile);
    });

    dog_icon.addEventListener('click', () => {
        profile_icon.style.backgroundColor = 'salmon';
        profile = 'dog';
        change_profile_function(profile);
    });

    elephant_icon.addEventListener('click', () => {
        profile_icon.style.backgroundColor = 'pink';
        profile = 'elephant';
        change_profile_function(profile);
    });

    fox_icon.addEventListener('click', () => {
        profile_icon.style.backgroundColor = 'darkslateblue';
        profile = 'fox';
        change_profile_function(profile);
    });

    kitty_icon.addEventListener('click', () => {
        profile_icon.style.backgroundColor = 'lightgreen';
        profile = 'kitty';
        change_profile_function(profile);
    });

    owl_icon.addEventListener('click', () => {
        profile_icon.style.backgroundColor = 'darkviolet';
        profile = 'owl';
        change_profile_function(profile);
    });

    panda_icon.addEventListener('click', () => {
        profile_icon.style.backgroundColor = 'rosybrown';
        profile = 'panda';
        change_profile_function(profile);
    });

    user_icon.addEventListener('click', () => {
        profile_icon.style.backgroundColor = 'gainsboro';
        profile = 'user';
        change_profile_function(profile);
    });

    wolf_icon.addEventListener('click', () => {
        profile_icon.style.backgroundColor = 'navajowhite';
        profile = 'wolf';
        change_profile_function(profile);
    });

    // 모달 내용 다르게
    let modify_name_btn = document.querySelector('#modify_name_btn');
    let modify_email_btn = document.querySelector('#modify_email_btn');
    let del_acct_btn = document.querySelector('#del_acct_btn');
    let save_btn = document.querySelector('#save_btn');

    let modal_title = document.querySelector('#modal_title');
    let modal_input = document.querySelector('#modal_input');
    let modal_form = document.querySelector('#modal_form');

    let modal_message = document.createElement('div');
    modal_message.classList.add('fs-5');
    modal_message.style.display = 'none';
    modal_message.innerHTML = `
        <div>이 작업은 Quizgo 계정 및 계정과 관련된 모든 데이터를 영구적으로 삭제합니다.</div>
        <div>이 작업은 취소할 수 없습니다.</div>
    `;
    modal_title.after(modal_message);

    modify_name_btn.addEventListener('click', () => {
        modal_title.innerText = '사용자 이름 변경';
        modal_input.placeholder = '새로운 사용자 이름';
        modal_input.value = '';

        modal_input.style.display = 'block';
        modal_message.style.display = 'none';

        save_btn.style.backgroundColor = 'rgb(196, 191, 236)';
        save_btn.style.color = 'black';
        save_btn.innerText = '저장';

        modal_form.action = "{{ route('update-name') }}";
        modal_input.name = 'name';
    });

    modify_email_btn.addEventListener('click', () => {
        modal_title.innerText = '이메일 업데이트';
        modal_input.placeholder = '새로운 이메일';
        modal_input.value = '';

        modal_input.style.display = 'block';
        modal_message.style.display = 'none';

        save_btn.style.backgroundColor = 'rgb(196, 191, 236)';
        save_btn.style.color = 'black';
        save_btn.innerText = '저장';

        modal_form.action = "{{ route('update-email') }}";
        modal_input.name = 'email';
    });

    del_acct_btn.addEventListener('click', () => {
        modal_title.innerText = '계정을 삭제할까요?';
        modal_input.style.display = 'none';
        modal_message.style.display = 'block';

        save_btn.style.backgroundColor = 'firebrick';
        save_btn.style.color = 'white';
        save_btn.innerText = '계정 삭제';

        modal_form.action = "{{ route('delete-account') }}";
    });
</script>

<style>
    .modify_btn {
        color: mediumpurple;
        border-radius: 15px;
        font-weight: bold;
        font-size: 22px;
        padding: 7% 15%;

    }

    .modify_btn:hover {
        color: mediumpurple;
        background-color: #F8F9FA;
    }

    .form-control {
        background-color: #F8F9FA;
        height: 60px;
        border: none;
        margin-top: 1%;
        font-weight: bold;
        font-size: 20px;
    }

    .form-control:focus {
        background-color: #F8F9FA;
    }
</style>
@endsection