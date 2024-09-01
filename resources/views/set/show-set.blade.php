@extends('layouts.app-layouts')
@section('content')
<main>
    <div class="row fs-2 fw-bold mt-5">{{ $set->title }}</div>
    <div class="row mt-3">
        <a href="{{ route("test-set", $set->id) }}" class="px-0 col-2">
            <button class="btn fs-5 fw-bold" style="background-color: rgb(123, 144, 238); width: 100%;">테스트</button>
        </a>
        @if($set->email == Auth::user()->email)
        <a href="{{ route('modify-set', $set->id) }}" class="px-0 offset-8 col-2">
            <button class="btn fs-5 fw-bold" style="background-color: rgb(196, 191, 236); width: 100%;">수정하기</button>
        </a>
        @endif
    </div>
    <div class="row mt-5">
        <div id="carouselExample" class="carousel carousel-dark slide card" >
            <div class="carousel-inner card-body text-center d-flex align-items-center" style="height: 450px;">
                <div class="carousel-item active">
                    <button class="btn fs-3 ps-4" style="height: 450px; width: 950px;">
                        <div class="word">{{ $cards[0]->word }}</div>
                        <input type="hidden" value="{{ $cards[0]->meaning }}">
                        <input type="hidden" value="{{ $cards[0]->word }}">
                    </button>
                </div>
                @foreach ( $cards->skip(1) as $key => $card )
                <div class="carousel-item">
                    <button class="btn fs-3 ps-4" style="height: 450px; width: 950px;">
                        <div class="word">{{ $card->word }}</div>
                        <input type="hidden" value="{{ $card->meaning }}">
                        <input type="hidden" value="{{ $card->word }}">
                    </button>
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-1">
            @if($creator->profile == 'user')
            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                style="background-color: gainsboro; width: 70px; height: 70px;">
                <img src="/image/user.png" style="width: 70%;">
            </div>
            @elseif($creator->profile == 'rabbit')
            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                style="background-color: mediumslateblue; width: 70px; height: 70px;">
                <img src="/image/rabbit.png" style="width: 70%;">
            </div>
            @elseif($creator->profile == 'dog')
            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                style="background-color: salmon; width: 70px; height: 70px;">
                <img src="/image/dog.png" style="width: 70%;">
            </div>
            @elseif($creator->profile == 'kitty')
            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                style="background-color: lightgreen; width: 70px; height: 70px;">
                <img src="/image/kitty.png" style="width: 70%;">
            </div>
            @elseif($creator->profile == 'bear')
            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                style="background-color: lightseagreen; width: 70px; height: 70px;">
                <img src="/image/bear.png" style="width: 70%;">
            </div>
            @elseif($creator->profile == 'elephant')
            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                style="background-color: pink; width: 70px; height: 70px;">
                <img src="/image/elephant.png" style="width: 70%;">
            </div>
            @elseif($creator->profile == 'fox')
            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                style="background-color: darkslateblue; width: 70px; height: 70px;">
                <img src="/image/fox.png" style="width: 70%;">
            </div>
            @elseif($creator->profile == 'owl')
            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                style="background-color: darkviolet; width: 70px; height: 70px;">
                <img src="/image/owl.png" style="width: 70%;">
            </div>
            @elseif($creator->profile == 'panda')
            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                style="background-color: rosybrown; width: 70px; height: 70px;">
                <img src="/image/panda.png" style="width: 70%;">
            </div>
            @elseif($creator->profile == 'wolf')
            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                style="background-color: navajowhite; width: 70px; height: 70px;">
                <img src="/image/wolf.png" style="width: 70%;">
            </div>
            @endif
        </div>
        <div class="col-2 pt-2">
            <div>만든 이<br></div>
            <div class="fw-bold fs-5"><a href="{{ route('creator', $creator->name) }}">{{ $creator->name }}</a></div>
        </div>
        @if($set->email == Auth::user()->email)
        <div class="col-2 offset-7 d-flex align-items-center justify-content-end">
            <button type="button" class="btn fw-bold fs-5 text-light px-3 py-2" data-bs-toggle="modal" data-bs-target="#del_set_modal"
            style="background-color: firebrick;">삭제하기</button>
        </div>
        @endif
    </div>
</main>

<!-- 모달 -->
<div class="modal fade" id="del_set_modal" tabindex="-1" aria-labelledby="del_set_modal_label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 15px;">
            <form action="{{ route('delete-set', $set->id) }}" method="POST">
                @csrf
                <div class="modal-header" style="border: none; padding: 4% 4% 0 0;">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mb-5" style="padding: 2% 4%;">
                    <div class="fw-bold mb-4" style="font-size: 35px;">세트를 삭제하시겠습니까?</div>
                    <div class="fs-5 mb-4">삭제한 세트는 되돌릴 수 없습니다.</div>
                </div>
                <div class="modal-footer">
                    <div style="padding: 1%;">
                        <button type="button" class="btn border border-3 fs-5 fw-bold me-3" data-bs-dismiss="modal">취소</button>
                        <button type="submit" class="btn fs-5 fw-bold text-light" style="background-color: firebrick;">세트 삭제</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    // 단어 누르면 뜻으로 바꾸기
    let word_all = document.querySelectorAll('.word');
    word_all.forEach(wa => {
        wa.addEventListener('click', () => {
            if(wa.innerText !== wa.nextElementSibling.value) {
                wa.innerText = wa.nextElementSibling.value;
            } else if(wa.innerText === wa.nextElementSibling.value) {
                wa.innerText = wa.nextElementSibling.nextElementSibling.value;
            }
        });
    })
</script>

<style>
    a {
        text-decoration: none; 
        color: black;
    }
</style>
@endsection