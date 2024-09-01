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
    <div style="background-color: rgb(196, 191, 236); font-weight: bold; padding: 1% 0;" id="header">
        <div style="display: flex; font-size: 20px;">
            <div style="flex: 0 0 20%; padding-left: 1%; display: flex; align-items: center;">테스트</div>
            <div style="flex: 0 0 60%; text-align: center; display: flex; align-items: center; 
                justify-content: center;" id="card_count">숫자</div>
            <div style="flex: 0 0 20%; padding-right: 1%; text-align: end;">
                <a href="{{ route("show-set", $set->id) }}">
                    <button type="button" style="border-radius: 10px; font-weight: bold; border: 1px solid mediumpurple;
                        background-color: mediumpurple; padding: 0 4% 1% 4%; font-size: 25px; height: 100%;">X
                    </button>
                </a>
            </div>
        </div>
        <div style="text-align: center">{{ $set->title }}</div>
    </div>

    <main class="container mb-5 pb-5">
        <!-- 스크롤 스파이 -->
        <div class="scroll_spy row border border-2 rounded py-2 "></div>

        <!-- 테스트 결과 -->
        <div class="row" id="result" style="display: none;">
            <div class="offset-1 col-11 fw-bold ">
                <div class="fs-3 mb-2">결과</div>
                <div class="row text-primary fs-4">
                    <div class="col-auto">정답</div>
                    <div class="col-auto border border-primary rounded-pill ms-4" id="correct_answer_num">??</div>
                </div>
                <div class="row text-danger fs-4 mt-2">
                    <div class="col-auto">오답</div>
                    <div class="col-auto border border-danger rounded-pill ms-4" id="wrong_answer_num">??</div>
                </div>
            </div>
        </div>

        <!-- 문제 리스트 -->
        <div class="row" id="card_list"></div>

        <!-- 메시지 & 제출 버튼 -->
        <div class="row fs-3 fw-bold d-flex justify-content-center" style="margin-top: 10%;" id="complete_message">모두 완료되었습니다! 테스트를 제출할 준비가 되셨나요?</div>
        <div class="row mt-5" id="show_result_div">
            <a href="#top">
                <button type="button" class="btn offset-5 col-2 fw-bold fs-5 py-4" id="show_result"
                    style="background-color: rgb(196, 191, 236);">
                    테스트 제출하기
                </button>
            </a>
        </div>
    </main>
</body>

</html>



<script>
    // 컨트롤러에서 변수 받아오기
    <?php 
        echo "let count = " . json_decode($card_counts)[0]->count . ";";
        echo "let cards = $cards";
    ?>

    // 카드 갯수 표시
    let card_count = document.querySelector('#card_count');
    let entered_answer_count = 0;
    card_count.innerText = `${entered_answer_count} / ${count}`;

    // 문제 셔플
    let result = document.querySelector('#result');
    let card_list = document.querySelector('#card_list');
    let card_shuffle = cards.sort(() => Math.random() - 0.5)
    card_shuffle.forEach((cd, i) => {
        let card_div = document.createElement('div')
        card_div.classList.add('card', 'offset-1', 'col-10', 'mt-5', 'card_div');

        card_div.innerHTML = `
            <div class="card-body px-4">
                <div class="row d-flex justify-content-end" style="font-size: 17px;" id="quiz_${i + 1}"> ${i + 1} / ${count} </div>
                <div class="mt-4" style="font-size: 27px; height: 270px;">${cd.meaning}</div>
                <input type="text" placeholder="정답" class="fw-bold fs-5 form-control mb-4 answer_input">
                <input type="hidden" value="${cd.word}" class="form-control border-danger text-danger fs-5 fw-bold">
                <div class="row dunno_div">
                    <button class="offset-5 col-2 btn fw-bold fs-5 rounded-pill border border-3 dunno">모르겠어요</button>
                </div>
            </div>
        `;
        card_list.appendChild(card_div);

        // 스크롤 스파이
        let scroll_spy = document.querySelector('.scroll_spy');
        let scroll_spy_item = document.createElement('div');
        scroll_spy_item.classList.add('fw-bold', 'fs-5', 'text-center', 'py-1');
        scroll_spy_item.innerHTML = `
            <a class="p-1 rounded scroll_spy_item" id="scroll_spy_item_${i + 1}" href="#quiz_${i + 1}">문제 ${i + 1}</a>
        `;
        scroll_spy.appendChild(scroll_spy_item);

        // 마진 주기
        card_list.style.marginTop = ((i + 1) * -38) + 'px';
        result.style.marginTop = ((i + 1) * -38) + 'px';
    });

    // 결과 보여주기
    let show_result = document.querySelector('#show_result');
    let card_div_all = document.querySelectorAll('.card_div');
    let dunno_div_all = document.querySelectorAll('.dunno_div');
    let answer_input_all = document.querySelectorAll('.answer_input');
    let complete_message = document.querySelector('#complete_message');
    let show_result_div = document.querySelector('#show_result_div');
    let correct_answer_num = document.querySelector('#correct_answer_num');
    let wrong_answer_num = document.querySelector('#wrong_answer_num');

    show_result.addEventListener('click', () => {
        let num_of_blank = 0;
        answer_input_all.forEach(ai => {
            if(ai.value === '') {
                num_of_blank++;
            }
        })

        if(num_of_blank !== 0) {
            alert('답을 입력하지 않은 문제가 있습니다.');
        } else {
            result.style.display = 'block';

            // 마진 주기
            card_list.style.marginTop = '0';

            // 모르겠어요 버튼 삭제
            dunno_div_all.forEach(dd => {
                dd.innerHTML = '';
            })

            // 메시지 & 버튼 삭제
            complete_message.innerHTML = '';
            show_result_div.innerHTML = '';

            // 카드 내용 다시 쓰기
            card_div_all.forEach((cd, i) => {
                let correct_answer_count = 0;
                let wrong_answer_count = 0;

                // 정답 or 오답
                answer_input_all.forEach(ai => {
                    ai.setAttribute('readonly', 'true');
                    if(ai.value == ai.nextElementSibling.value) {
                        ai.classList.add('text-primary');
                        ai.classList.add('border-primary');
                        correct_answer_count++;
                    } else if(ai.value == '') {
                        ai.classList.add('text-secondary');
                        ai.value = '건너뜀';
                        ai.nextElementSibling.setAttribute('type', 'text');
                        wrong_answer_count++;
                    } else {
                        ai.classList.add('text-secondary');
                        ai.nextElementSibling.setAttribute('type', 'text');
                        wrong_answer_count++;
                    }
                })

                // 정답 & 오답 개수 표시하기
                correct_answer_num.innerText = correct_answer_count;
                wrong_answer_num.innerText = wrong_answer_count;
            })

            // 스크롤 스파이에 결과 보여주기
            let scroll_spy_item = document.querySelectorAll('.scroll_spy_item');
            answer_input_all.forEach((ai, i) => {
                if(ai.classList.contains('text-primary')) {
                    scroll_spy_item[i].innerText = `문제 ${i + 1} O`;
                    scroll_spy_item[i].classList.add('text-primary');
                } else if(ai.classList.contains('text-secondary')) {
                    scroll_spy_item[i].innerText = `문제 ${i + 1} X`;
                    scroll_spy_item[i].classList.add('text-danger');
                }
            })
        }
    });

    // 모르겠어요 버튼 누르면 value null 만들기
    let dunno_all = document.querySelectorAll('.dunno');
    dunno_all.forEach(dunno => {
        dunno.addEventListener('click', () => {
            if(dunno.style.backgroundColor === 'rgb(123, 144, 238)') {
                // 버튼 색깔 바꾸기
                dunno.style.border = '';
                dunno.style.backgroundColor = '';
                dunno.classList.add('border', 'border-3');
                dunno.parentElement.previousElementSibling.previousElementSibling.value = '';

                // 입력한 답변 개수 업데이트
                entered_answer_count--;
                card_count.innerText = `${entered_answer_count} / ${count}`;
            } else {
                // 버튼 색깔 바꾸기
                dunno.classList.remove('border', 'border-3');
                dunno.style.backgroundColor = 'rgb(123, 144, 238)';
                dunno.style.border = '3px solid rgb(123, 144, 238)';
                dunno.parentElement.previousElementSibling.previousElementSibling.value = '건너뜀';

                // 입력한 답변 개수 업데이트
                entered_answer_count++;
                card_count.innerText = `${entered_answer_count} / ${count}`;
            }
        });
    })

    // 입력한 답변 개수 업데이트
    answer_input_all.forEach(ai => {
        ai.addEventListener('focusout', () => {
            if(ai.value !== '') {
                entered_answer_count++;
                card_count.innerText = `${entered_answer_count} / ${count}`;
            }
        });
    })
</script>

<style>
    a {
        text-decoration: none; 
        color: black;
    }

    .form-control {
        height: 50px;
        border: 3px solid #DEE2E6;
    }

    #header {
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .scroll_spy {
        display: flex;
        position: sticky;
        top: 15%;
        z-index: 800;
        margin-left: -150px;
        width: 220px;
    }
</style>