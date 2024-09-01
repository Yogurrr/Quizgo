@extends('layouts.app-layouts')
@section('content')
<main>
    <div style="margin-top: 10%; font-size: 45px;" class="fw-bold">비밀번호 재설정</div>
    <div style="margin-top: 3%; font-size: 27px;">가입할 때 사용한 이메일을 입력하세요. 로그인 및 비밀번호 재설정 링크가 이메일로 전송됩니다.</div>
    <div class="mt-5 fw-bold fs-5">
        <div id="join_email_message">이메일</div>
        <input class="form-control fw-bold fs-5" placeholder="user@email.com" name="email" id="forgotton_email_input">
    </div>
    <button type="button" class="btn mt-5 fs-4 text-light fw-bold py-4 px-5" style="background-color: mediumpurple;">링크 보내기</button>
</main>



<script>
    //
</script>

<style>
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
</style>
@endsection