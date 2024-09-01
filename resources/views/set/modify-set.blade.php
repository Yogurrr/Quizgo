@extends('layouts.app-layouts')
@section('content')
<main>
    <form action="{{ route('update-set', $set->id) }}" method="POST">
        @csrf
        <div class="row fw-bold mt-5">
            <div class="col-10 fs-3 ps-0">학습 세트 수정하기</div>
            <button class="col-2 btn fw-bold fs-5" style="background-color: rgb(196, 191, 236)" 
                id="update_set_btn">수정하기</button>
        </div>
        <div class="row mt-3">
            <input type="text" class="form-control fs-5 fw-bold border-3" placeholder="세트 제목" 
                aria-label="set_name" name="title" value="{{ $set->title }}">
        </div>
        <div class="row mt-3">
            <div class="form-floating p-0">
                <textarea class="form-control border-3 fs-5" style="height: 150px; resize: none;"
                    id="floatingTextarea">{{ $set->instruction }}</textarea>
                <label for="floatingTextarea" class="fs-5">설명</label>
            </div>
        </div>
        <div class="row" style="margin-top: 10%;" id="card_list">
            @php
            $order = 0;
            $name_order = 0;
            @endphp

            @foreach( $cards as $key => $card )

            @php
            $order++;
            @endphp

            <div class="card mt-3 card_set border-3">
                <div class="card-body px-0 fs-5">
                    <div class="row pb-3" style="border-bottom: 1px solid darkgrey;">
                        <div class="col-6 ps-3 order-number fw-bold" style="font-color: #939BB4">{{ $order }}</div>
                        <div class="col-6 text-end pe-3"><a href="javascript:void(0);" class="del_card_btn">삭제</a></div>
                    </div>
                    <div class="row mt-4 mb-2">
                        <div class="col-6">
                            <textarea rows="1" class="word_input word" name="cards[{{ $name_order }}][word]">{{ $card->word }}</textarea>
                            <div class="fs-6 pt-1">단어</div>
                        </div>
                        <div class="col-6">
                            <textarea rows="1" class="word_input meaning" name="cards[{{ $name_order }}][meaning]">{{ $card->meaning }}</textarea>
                            <div class="fs-6 pt-1">뜻</div>
                        </div>
                        <input type="hidden" value="{{ $card->id }}" name="cards[{{ $name_order }}][id]">
                    </div>
                </div>
            </div>

            @php
            $name_order++;
            @endphp

            @endforeach
        </div>
    </form>

    <div class="row mt-4">
        <button class="offset-5 col-2 btn fw-bold fs-5" style="background-color: rgb(196, 191, 236);" 
            id="add_card_btn">카드 추가</button>
    </div>
</main>



<script>
    // 카드 추가
    let add_card_btn = document.querySelector('#add_card_btn');
    let card_list = document.querySelector('#card_list');
    let order_num = {{ $order }} + 1;

    add_card_btn.addEventListener('click', () => {
        let card_div = document.createElement('div');
        card_div.classList.add('card', 'mt-3', 'card_set', 'border-3');

        card_div.innerHTML = `
            <div class="card-body px-0 fs-5">
                <div class="row pb-3" style="border-bottom: 1px solid darkgrey;">
                    <div class="col-6 ps-3 order-number">${order_num}</div>
                    <div class="col-6 text-end pe-3"><a href="javascript:void(0);" class="del_card_btn">삭제</a></div>
                </div>
                <div class="row mt-4 mb-2">
                    <div class="col-6">
                        <textarea rows="1" class="word_input word" name="cards[${order_num - 1}][word]"></textarea>
                        <div class="fs-6 pt-1">단어</div>
                    </div>
                    <div class="col-6">
                        <textarea rows="1" class="word_input meaning" name="cards[${order_num - 1}][meaning]"></textarea>
                        <div class="fs-6 pt-1">뜻</div>
                    </div>
                </div>
            </div>
        `;
        card_list.appendChild(card_div);

        // 카드 순서
        order_num += 1;
    });

    // 카드 삭제
    let id_list_for_deletion = [];
    card_list.addEventListener('click', (event) => {
        if(event.target.classList.contains('del_card_btn')) {
            // 삭제할 카드의 id를 배열에 저장
            let id_value = event.target.parentElement.parentElement.nextElementSibling.lastElementChild.value;
            id_list_for_deletion.push(id_value);

            card_list.removeChild(event.target.closest('.card'));
            reorderCards();
            renaming();
        }
    });

    // 카드 번호 재조정 함수
    let reorderCards = () => {
        document.querySelectorAll('.order-number').forEach((element, index) => {
            element.innerText = index + 1;
        });
        order_num = document.querySelectorAll('.card').length + 1;
    }

    // 이름 재조정 함수
    let renaming = () => {
        document.querySelectorAll('.word').forEach(element => {
            element.setAttribute('name', 'cards[' + (order_num - 2) + '][word]');
        });
        document.querySelectorAll('.meaning').forEach(element => {
            element.setAttribute('name', 'cards[' + (order_num - 2) + '][meaning]');
        });
    }

    // 삭제할 카드의 id 컨트롤러에 보내기
    let update_set_btn = document.querySelector('#update_set_btn');
    update_set_btn.addEventListener('click', () => {
        fetch('/delete-card', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ id_list_for_deletion: id_list_for_deletion })
        })
        .then(response => response.json())
        .catch(error => console.error('Error:', error));
    });
    
    // 개행하면 크기가 늘어나는 textarea
    card_list.addEventListener('input', function(event) {
        if (event.target.matches('.word_input')) {
            autoResize.call(event.target);
        }
    });
    function autoResize() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    }
</script>

<style>
    .form-control {
        height: 50px;
    }

    .word_input {
        width: 90%;
        border-top: none;
        border-left: none;
        border-right: none;
        resize: none;
        height: auto;
        overflow: hidden;
    }

    .word_input:focus {
        outline: none;
        border-bottom: 2px solid mediumpurple;
    }
</style>
@endsection