<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Quizgo</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <main class="mb-5">
        <div class="offcanvas offcanvas-start show fw-bold" data-bs-scroll="true" data-bs-backdrop="false" 
            tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel"
            style="background-color: rgb(196, 191, 236); width: 50%; padding-left: 3%; padding-top: 5%; font-size: 50px;">
            <div id="introduction_message">
                <div>최고의 학습 경험을 쌓으세요!</div>
                <div>무료로 가입하세요.</div>
            </div>
            <div class="text-light" style="position: sticky; top: 85%;">Quizgo</div>
        </div>
        <div style="margin-left: 55%; margin-top: 5%;">
            <div style="display: flex; font-size: 30px;">
                <div style="border-bottom: 5px solid rgb(123, 144, 238);" id="show_join_div">
                    <button type="button" class="btn fw-bold" style="font-size: 30px;" id="show_join_btn">회원가입</button>
                </div>
                <div style="margin-left: 5%;" id="show_login_div">
                    <button type="button" class="btn fw-bold" style="font-size: 30px;" id="show_login_btn">로그인</button>
                </div>
            </div>

            <!-- 회원가입 -->
            <div id="join_part">
                <form action="{{ route('join') }}" method="POST">
                    @csrf
                    <div class="mt-5">
                        <div class="fw-bold fs-5" id="birth_date_message">생년월일</div>
                        <div style="display: flex; width: 90%; margin-top: 1%;">
                            <select class="form-select" aria-label="Default select example" id="year_select" style="width: 90%; margin-right: 5%;">
                                <option selected>연도</option>
                                @php
                                $current_year = date("Y");
                                @endphp

                                @for($i = $current_year; $i >= $current_year - 100; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <select class="form-select" aria-label="Default select example" id="month_select" style="width: 90%; margin-right: 5%;">
                                <option selected>월</option>
                                @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <select class="form-select" aria-label="Default select example" id="date_select" style="width: 90%;">
                                <option selected>일</option>
                                @for($i = 1; $i <= 31; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <input type="hidden" id="birth_date" name="birth_date">
                    </div>
                    <div class="mt-5 fw-bold fs-5">
                        <div id="join_email_message">이메일</div>
                        <input class="form-control fw-bold fs-5" placeholder="user@email.com" name="email" id="join_email_input">
                    </div>
                    <div class="mt-5">
                        <div class="fw-bold fs-5" id="join_name_message">사용자 이름</div>
                        <input class="form-control fw-bold fs-5" placeholder="홍길동" name="name" id="join_name_input">
                    </div>
                    <div class="mt-5">
                        <div class="fw-bold fs-5" id="join_password_message">비밀번호</div>
                        <input class="form-control" type="password" name="password" id="join_password_input">
                    </div>
                    <div class="form-check mt-5 fs-5" id="terms_check_div">
                        <input class="form-check-input" type="checkbox" value="" id="terms_check_input">
                        <label class="form-check-label" for="terms_check" id="terms_check_label">
                            Quizgo의 서비스 약관 및 개인정보 취급방침에 동의합니다.  
                        </label>
                    </div>
                    <div class="fw-bold fs-5 mt-4 p-3" style="color: firebrick; border: 2px solid firebrick;
                        border-radius: 15px; width: 90%; display: none;" id="check_warning">
                        계속하려면 Quizgo의 서비스 약관과 개인정보 취급방침에 동의하셔야 합니다.
                    </div>
                    <button type="button" class="btn fw-bold fs-4 py-3 mt-4" style="background-color: rgb(123, 144, 238); width: 90%;" id="join_btn">회원가입</button>
                </form>
                <button type="button" class="btn fw-bold fs-5 border border-3 mt-3 py-3 text-secondary" style="width: 90%;" id="go_to_login_btn">회원이신가요? 로그인</button>
            </div>
            
            <!-- 로그인 -->
            <div id="login_part" style="display: none;">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mt-5 fw-bold fs-5">
                        <div>이메일</div>
                        <input class="form-control fw-bold fs-5" placeholder="이메일을 입력하세요" name="email">
                    </div>
                    <div class="mt-5">
                        <div class="fw-bold fs-5" style="display: flex;">
                            <div style="width: 50%;" class="fw-bold fs-5">비밀번호</div>
                            <div style="width: 40%;" class="text-end">
                                <a href="#" style="color: rgb(123, 144, 238);">비밀번호가 기억나지 않아요</a>
                            </div>
                        </div>
                        <input class="form-control fw-bold fs-5" type="password" name="password" placeholder="비밀번호를 입력하세요">
                    </div>
                    <div class="text-secondary ps-4 mt-4">로그인을 클릭하면, Quizlet의 서비스 약관과 개인정보 취급방침에 동의하는 것입니다</div>
                    <button type="submit" class="btn fw-bold fs-4 py-3 mt-4" style="background-color: rgb(123, 144, 238); width: 90%;">로그인</button>
                </form>
                <button type="button" class="btn fw-bold fs-5 border border-3 mt-3 py-3 text-secondary" style="width: 90%;" id="go_to_join_btn">Quizgo가 처음이신가요? 계정 만들기</button>
            </div>
        </div>
    </main>
</body>

</html>

<script>
    let show_join_btn = document.querySelector('#show_join_btn');
    let show_login_btn = document.querySelector('#show_login_btn');
    let show_join_div = document.querySelector('#show_join_div');
    let show_login_div = document.querySelector('#show_login_div');
    let join_part = document.querySelector('#join_part');
    let login_part = document.querySelector('#login_part');
    let introduction_message = document.querySelector('#introduction_message');
    let go_to_join_btn = document.querySelector('#go_to_join_btn');
    let go_to_login_btn = document.querySelector('#go_to_login_btn');

    let render_join_part = () => {
        join_part.style.display = 'block';
        login_part.style.display = 'none';

        show_join_div.style.borderBottom = '5px solid rgb(123, 144, 238)';
        show_login_div.style.borderBottom = '';

        // 오프캔버스 문구 바꾸기
        introduction_message.innerHTML = `
            <div>최고의 학습 경험을 쌓으세요!</div>
            <div>무료로 가입하세요.</div>
        `;
    }

    let render_login_part = () => {
        login_part.style.display = 'block';
        join_part.style.display = 'none';

        show_login_div.style.borderBottom = '5px solid rgb(123, 144, 238)';
        show_join_div.style.borderBottom = '';

        // 오프캔버스 문구 바꾸기
        introduction_message.innerHTML = `
            <div>집에서 편하게 학습하세요.</div>
        `;
    }

    show_join_btn.addEventListener('click', () => {
        render_join_part();
    });

    show_login_btn.addEventListener('click', () => {
        render_login_part();
    });

    go_to_join_btn.addEventListener('click', () => {
        render_join_part();
    });

    go_to_login_btn.addEventListener('click', () => {
        render_login_part();
    });

    // 가입 버튼 클릭 시 미입력 칸 표시
    let join_btn = document.querySelector('#join_btn');

    let birth_date_message = document.querySelector('#birth_date_message');
    let year_select = document.querySelector('#year_select');
    let month_select = document.querySelector('#month_select');
    let date_select = document.querySelector('#date_select');
    let join_email_input = document.querySelector('#join_email_input');
    let join_email_message = document.querySelector('#join_email_message');
    let join_name_input = document.querySelector('#join_name_input');
    let join_name_message = document.querySelector('#join_name_message');
    let join_password_input = document.querySelector('#join_password_input');
    let join_password_message = document.querySelector('#join_password_message');
    let terms_check_input = document.querySelector('#terms_check_input');
    let terms_check_div = document.querySelector('#terms_check_div');
    let terms_check_label = document.querySelector('#terms_check_label');
    let check_warning = document.querySelector('#check_warning');

    let ko_regex = /[ㄱ-ㅎ|ㅏ-ㅣ|가-힣]+$/;
    let pswd_regex = /^[\w\!\@\#\$\%\^\&\*\+\=\?]+$/;
    let email_regex = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;

    join_btn.addEventListener('click', () => {
        if(year_select.value == '연도') {
            birth_date_message.style.color = 'firebrick';
            birth_date_message.innerText = '생년월일을 입력하세요';
            year_select.style.border = '2px solid firebrick';
        } else {
            birth_date_message.style.color = 'black';
            birth_date_message.innerText = '생년월일';
            year_select.style.border = 'none';
            year_select.classList.add('border');
        }

        if(month_select.value == '월') {
            birth_date_message.style.color = 'firebrick';
            birth_date_message.innerText = '생년월일을 입력하세요';
            month_select.style.border = '2px solid firebrick';
        } else {
            birth_date_message.style.color = 'black';
            birth_date_message.innerText = '생년월일';
            month_select.style.border = 'none';
            month_select.classList.add('border');
        }

        if(date_select.value == '일') {
            birth_date_message.style.color = 'firebrick';
            birth_date_message.innerText = '생년월일을 입력하세요';
            date_select.style.border = '2px solid firebrick';
        } else {
            birth_date_message.style.color = 'black';
            birth_date_message.innerText = '생년월일';
            date_select.style.border = 'none';
            date_select.classList.add('border');
        }

        if(join_email_input.value == '' || !email_regex.test(join_email_input.value)) {
            join_email_message.innerText = '유효하지 않은 이메일입니다.';
            join_email_message.style.color = 'firebrick';
        } else {
            join_email_message.innerText = '이메일';
            join_email_message.style.color = 'black';
        }

        if(join_name_input.value == '' || !ko_regex.test(join_name_input.value)) {
            join_name_message.innerText = '사용자 이름은 한글만 입력할 수 있습니다.';
            join_name_message.style.color = 'firebrick';
        } else {
            join_name_message.innerText = '사용자 이름';
            join_name_message.style.color = 'black';
        }

        if(join_password_input.value.length < 6 || !pswd_regex.test(join_password_input.value)) {
            join_password_message.innerHTML = `
                <div>비밀번호는 6~20자 영문, 숫자, 특수문자(!,@,#,$,%,^,&,*,-,_,+,=,?)로</div>
                <div>조합해주세요.</div>
            `;
            join_password_message.style.color = 'firebrick';
        } else {
            join_password_message.innerText = '비밀번호';
            join_password_message.style.color = 'black';
        }

        if(!terms_check_input.checked) {
            check_warning.style.display = 'block';
            terms_check_label.style.color = 'firebrick';
        }

        if(year_select.value !== '연도' && month_select.value !== '월' && date_select.value !== '일' && join_email_message.style.color !== 'firebrick' && join_name_message.style.color !== 'firebrick' && join_password_message.style.color !== 'firebrick' && terms_check_input.checked) {
            let adjusted_month = month_select.value >= 10 ? month_select.value : '0' + month_select.value;
            let adjusted_date = date_select.value >= 10 ? date_select.value : '0' + date_select.value;

            let birth_date = year_select.value + adjusted_month + adjusted_date;
            let name = join_name_input.value;
            let email = join_email_input.value;
            let password = join_password_input.value;

            fetch('/join', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ 
                    name: name,
                    birth_date: birth_date,
                    email: email,
                    password: password,
                })
            })
            // .then(response => response.json())
            .catch(error => console.error('Error:', error));

            render_login_part();
        }
    });

    terms_check_input.addEventListener('change', () =>{
        if(!terms_check_input.checked) {
            check_warning.style.display = 'block';
            terms_check_label.style.color = 'firebrick';
        } else {
            check_warning.style.display = 'none';
            terms_check_label.style.color = 'black';
        }
    });

</script>

<style>
    a {
        text-decoration: none; 
        color: black;
    }

    .form-control {
        background-color: #F8F9FA;
        width: 90%;
        height: 60px;
        border: none;
        margin-top: 1%;
    }

    .form-control:focus {
        background-color: #F8F9FA;
    }

    .form-select {
        height: 60px;
        font-size: 20px;
        font-weight: bold;
    }
</style>