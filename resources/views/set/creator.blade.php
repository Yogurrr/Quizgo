@extends('layouts.app-layouts')
@section('content')
<main>
    <div class="row mt-5">
        <div class="col-1">
            @if($profile->profile == null)
            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                style="background-color: gainsboro; width: 70px; height: 70px;">
                <img src="/image/user.png" style="width: 70%;">
            </div>
            @elseif($profile->profile == 'rabbit')
            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                style="background-color: mediumslateblue; width: 70px; height: 70px;">
                <img src="/image/rabbit.png" style="width: 70%;">
            </div>
            @elseif($profile->profile == 'dog')
            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                style="background-color: salmon; width: 70px; height: 70px;">
                <img src="/image/dog.png" style="width: 70%;">
            </div>
            @elseif($profile->profile == 'kitty')
            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                style="background-color: lightgreen; width: 70px; height: 70px;">
                <img src="/image/kitty.png" style="width: 70%;">
            </div>
            @elseif($profile->profile == 'bear')
            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                style="background-color: lightseagreen; width: 70px; height: 70px;">
                <img src="/image/bear.png" style="width: 70%;">
            </div>
            @elseif($profile->profile == 'elephant')
            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                style="background-color: pink; width: 70px; height: 70px;">
                <img src="/image/elephant.png" style="width: 70%;">
            </div>
            @elseif($profile->profile == 'fox')
            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                style="background-color: darkslateblue; width: 70px; height: 70px;">
                <img src="/image/fox.png" style="width: 70%;">
            </div>
            @elseif($profile->profile == 'owl')
            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                style="background-color: darkviolet; width: 70px; height: 70px;">
                <img src="/image/owl.png" style="width: 70%;">
            </div>
            @elseif($profile->profile == 'panda')
            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                style="background-color: rosybrown; width: 70px; height: 70px;">
                <img src="/image/panda.png" style="width: 70%;">
            </div>
            @elseif($profile->profile == 'wolf')
            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                style="background-color: navajowhite; width: 70px; height: 70px;">
                <img src="/image/wolf.png" style="width: 70%;">
            </div>
            @endif
        </div>
        <div class="col-2 pt-2">
            <div class="fw-bold fs-4">{{ $name }}</div>
        </div>
    </div>

    <div class="row" style="margin-top: 5%;" id="search_set_div">
        <div class="border border-3 p-0 d-flex"
        style="width: 50%; border-radius: 15px; display: inline-block; height: 65px;">
            <div style="width: 80%; margin-top: 2%;" class="ms-3">
                <input type="text" class="fs-5 fw-bold search_set_input" placeholder="세트 찾기" 
                style="border: none; width: 100%;">
            </div>
            <div style="width: 20%;" class="d-flex align-items-center justify-content-end pe-4">
                <img src="/image/search.png" style="width: 30px;">
            </div>
        </div>
    </div>

    <div id="set_list_warpper"></div>

    <div id="searched_set_list"></div>
</main>



<script>
    // 컨트롤러에서 변수 받아오기
    <?php 
        echo "let sets = " . json_encode($sets) . ";";
        echo "let number_of_cards = " . json_encode($number_of_cards) . ";";
        echo "let name = " . json_encode($name) . ";";
    ?>

    // 오늘 날짜 구하기
    let today = new Date();
    let current_year = today.getFullYear();
    let current_month = today.getMonth() + 1;
    let current_date = today.getDate();

    let add_zero_function = (num) => {
        if(num < 10) {
            return '0' + num;
        } else {
            return num;
        }
    }

    let revised_today = `${current_year}-${add_zero_function(current_month)}-${add_zero_function(current_date)}`;
    let yesterday = `${current_year}-${add_zero_function(current_month)}-${add_zero_function(current_date - 1)}`;

    // 주차 구하기 함수
    let getWeek = (date) => {
        if(date.getDay() == 0) {
            let current_date = date.getDate();
            let first_day = new Date(date.setDate(1)).getDay();

            return (Math.ceil((current_date + first_day) / 7) - 1);
        } else {
            let current_date = date.getDate();
            let first_day = new Date(date.setDate(1)).getDay();

            return Math.ceil((current_date + first_day) / 7);
        }
    }

    let search_set_div = document.querySelector('#search_set_div');
    let date_set = new Set();

    let set_list_warpper = document.querySelector('#set_list_warpper');

    sets.forEach(st => {
        let set_date = new Date(st['created_at'].slice(0, 10));
        let sliced_date = st['created_at'].slice(0, 10);

        if(sliced_date == revised_today) {
            // 오늘
            if(!document.querySelector('.today_hr')) {
                let set_list = document.createElement('div');
                set_list.classList.add('row');
                set_list.style.marginTop = '5%';
                set_list.innerHTML = `
                    <div class="col-auto p-0 fw-bold" style=" font-size: 18px;">오늘</div>
                    <div class="col pe-0 today_hr"><hr></div>
                `;
                set_list_warpper.appendChild(set_list);
            }

            let today_hr = document.querySelector('.today_hr');
            if(today_hr) {
                let set_list_item = document.createElement('a');
                set_list_item.classList.add('go_to_set', 'p-0');
                set_list_item.innerHTML = `
                    <div class="mt-2 fw-bold rounded py-3" style="background-color: #F6F7FB;">
                        <div class="fs-5 ps-3 card_count"></div>
                        <div class="fs-4 ps-3">${st['title']}</div>
                    </div>
                `;
                today_hr.after(set_list_item);
            }
        } else if(sliced_date == yesterday) {
            // 어제
            if(!document.querySelector('.yesterday_hr')) {
                let set_list = document.createElement('div');
                set_list.classList.add('row');
                set_list.style.marginTop = '5%';
                set_list.innerHTML = `
                    <div class="col-auto p-0 fw-bold" style=" font-size: 18px;">어제</div>
                    <div class="col pe-0 yesterday_hr"><hr></div>
                `;

                set_list_warpper.appendChild(set_list);
            }

            let yesterday_hr = document.querySelector('.yesterday_hr');
            if(yesterday_hr) {
                let set_list_item = document.createElement('a');
                set_list_item.classList.add('go_to_set', 'p-0');
                set_list_item.innerHTML = `
                    <div class="mt-2 fw-bold rounded py-3" style="background-color: #F6F7FB;">
                        <div class="fs-5 ps-3 card_count"></div>
                        <div class="fs-4 ps-3">${st['title']}</div>
                    </div>
                `;

                // 해당 세트로 이동
                let set_url = '{{ route("show-set", ":id") }}';
                set_url = set_url.replace(':id', st['id']);
                set_list_item.href = set_url;

                yesterday_hr.after(set_list_item);
            }
        } else if(sliced_date !== revised_today && sliced_date !== yesterday && 
            (new Date()).getFullYear() == (new Date(st['created_at'])).getFullYear() && 
            (new Date()).getMonth() == (new Date(st['created_at'])).getMonth() && 
            getWeek(new Date()) == getWeek(new Date(st['created_at']))) {
            // 이번 주
            if(!document.querySelector('.this_week_hr')) {
                let set_list = document.createElement('div');
                set_list.classList.add('row');
                set_list.style.marginTop = '5%';
                set_list.innerHTML = `
                    <div class="col-auto p-0 fw-bold" style=" font-size: 18px;">이번 주</div>
                    <div class="col pe-0 this_week_hr"><hr></div>
                `;
                set_list_warpper.appendChild(set_list);
            }

            let this_week_hr = document.querySelector('.this_week_hr');
            if(this_week_hr) {
                let set_list_item = document.createElement('a');
                set_list_item.classList.add('go_to_set', 'p-0');
                set_list_item.innerHTML = `
                    <div class="mt-2 fw-bold rounded py-3" style="background-color: #F6F7FB;">
                        <div class="fs-5 ps-3 card_count"></div>
                        <div class="fs-4 ps-3">${st['title']}</div>
                    </div>
                `;

                // 해당 세트로 이동
                let set_url = '{{ route("show-set", ":id") }}';
                set_url = set_url.replace(':id', st['id']);
                set_list_item.href = set_url;

                this_week_hr.after(set_list_item);
            }
        } else if((new Date()).getFullYear() == (new Date(st['created_at'])).getFullYear() && 
            (new Date()).getMonth() == (new Date(st['created_at'])).getMonth() && 
            (getWeek(new Date()) - 1) == getWeek(new Date(st['created_at']))) {
            // 저번 주
            if(!document.querySelector('.last_week_hr')) {
                let set_list = document.createElement('div');
                set_list.classList.add('row');
                set_list.style.marginTop = '5%';
                set_list.innerHTML = `
                    <div class="col-auto p-0 fw-bold" style=" font-size: 18px;">저번 주</div>
                    <div class="col pe-0 last_week_hr"><hr></div>
                `;
                set_list_warpper.appendChild(set_list);
            }

            let last_week_hr = document.querySelector('.last_week_hr');
            if(last_week_hr) {
                let set_list_item = document.createElement('a');
                set_list_item.classList.add('go_to_set', 'p-0');
                set_list_item.innerHTML = `
                    <div class="mt-2 fw-bold rounded py-3" style="background-color: #F6F7FB;">
                        <div class="fs-5 ps-3 card_count"></div>
                        <div class="fs-4 ps-3">${st['title']}</div>
                    </div>
                `;

                // 해당 세트로 이동
                let set_url = '{{ route("show-set", ":id") }}';
                set_url = set_url.replace(':id', st['id']);
                set_list_item.href = set_url;

                last_week_hr.after(set_list_item);
            }
        } else {
            // date_set에 else 날짜 저장
            let else_year = new Date(st['created_at']).getFullYear();
            let else_month = new Date(st['created_at']).getMonth() + 1;
            let else_year_and_month = else_year + '-' + else_month;
            
            date_set.add(else_year_and_month);
        }
    })

    // else 부분 만들기
    date_set.forEach(ds => {
        sets.forEach(st => {
            let else_year = new Date(st['created_at']).getFullYear();
            let else_month = new Date(st['created_at']).getMonth() + 1;
            let else_year_and_month = else_year + '-' + else_month;

            // else의 월이 현재의 월과 같으면 오늘, 어제, 이번 주, 지난 주 빼야 됨
            let set_date = new Date(st['created_at'].slice(0, 10));
            let sliced_date = st['created_at'].slice(0, 10);

            if((revised_today.slice(0, 7) == sliced_date.slice(0, 7) && 
            (getWeek(new Date()) - 2) >= getWeek(new Date(st['created_at']))) || 
            revised_today.slice(0, 7) !== sliced_date.slice(0, 7)) {
                if(ds == else_year_and_month) {
                    if(!document.querySelector(`.hr_${ds}`)) {
                        let sliced_year = ds.slice(0, 4);
                        let sliced_month = ds.slice(5);

                        let set_list = document.createElement('div');
                        set_list.classList.add('row');
                        set_list.style.marginTop = '5%';
                        set_list.innerHTML = `
                            <div class="col-auto p-0 fw-bold" style=" font-size: 18px;">${sliced_year}년 ${sliced_month}월</div>
                            <div class="col pe-0 hr_${ds}"><hr></div>
                        `;
                        set_list_warpper.appendChild(set_list);
                    }

                    let one = document.querySelector(`.hr_${ds}`);
                    if(one) {
                        let set_list_item = document.createElement('a');
                        set_list_item.classList.add('go_to_set', 'p-0');
                        set_list_item.innerHTML = `
                            <div class="mt-2 fw-bold rounded py-3" style="background-color: #F6F7FB;">
                                <div class="fs-5 ps-3 card_count"></div>
                                <div class="fs-4 ps-3">${st['title']}</div>
                            </div>
                        `;

                        // 해당 세트로 이동
                        let set_url = '{{ route("show-set", ":id") }}';
                        set_url = set_url.replace(':id', st['id']);
                        set_list_item.href = set_url;

                        one.after(set_list_item);
                    }
                }
            }
        })
    })



    // 검색 기능
    let searched_set_list = document.querySelector('#searched_set_list');
    let searched_date_set = new Set();

    let search_set_input = document.querySelector('.search_set_input');
    search_set_input.addEventListener('input', () => {
        set_list_warpper.style.display = 'none';

        let search_creator = search_set_input.value;

        // ajax
        if(search_creator) {
            fetch('/search-creator', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ 
                    search_creator: search_creator,
                    name: name,
                })
            })
            .then(response => {
                if(!response.ok) {
                    console.log('없음');
                } else {
                    return response.json();
                }
            })
            .then(data => {
                if (data != '') {
                    // 검색된 set list 보여주기
                    searched_set_list.innerHTML = '';
                    searched_set_list.style.display = 'block';

                    data.forEach(dt => {
                        let set_date = new Date(dt.created_at.slice(0, 10));
                        let sliced_date = dt.created_at.slice(0, 10);

                        if(sliced_date == revised_today) {
                            // 오늘
                            if(!document.querySelector('.searched_today_hr')) {
                                let set_list = document.createElement('div');
                                set_list.classList.add('row');
                                set_list.style.marginTop = '5%';
                                set_list.innerHTML = `
                                    <div class="col-auto p-0 fw-bold" style=" font-size: 18px;">오늘</div>
                                    <div class="col pe-0 searched_today_hr"><hr></div>
                                `;
                                searched_set_list.appendChild(set_list);
                            }
                        
                            let searched_today_hr = document.querySelector('.searched_today_hr');
                            if(searched_today_hr) {
                                let set_list_item = document.createElement('a');
                                set_list_item.classList.add('go_to_set', 'p-0');
                                set_list_item.innerHTML = `
                                    <div class="mt-2 fw-bold rounded py-3" style="background-color: #F6F7FB;">
                                        <div class="fs-5 ps-3 card_count"></div>
                                        <div class="fs-4 ps-3 set_title">${dt.title}</div>
                                    </div>
                                `;

                                // 해당 세트로 이동
                                let set_url = '{{ route("show-set", ":id") }}';
                                set_url = set_url.replace(':id', dt.id);
                                set_list_item.href = set_url;

                                searched_today_hr.after(set_list_item);
                            }
                        } else if(sliced_date == yesterday) {
                            // 어제
                            if(!document.querySelector('.searched_yesterday_hr')) {
                                let set_list = document.createElement('div');
                                set_list.classList.add('row');
                                set_list.style.marginTop = '5%';
                                set_list.innerHTML = `
                                    <div class="col-auto p-0 fw-bold" style=" font-size: 18px;">어제</div>
                                    <div class="col pe-0 searched_yesterday_hr"><hr></div>
                                `;
                                searched_set_list.appendChild(set_list);
                            }
                        
                            let searched_yesterday_hr = document.querySelector('.searched_yesterday_hr');
                            if(searched_yesterday_hr) {
                                let set_list_item = document.createElement('a');
                                set_list_item.classList.add('go_to_set', 'p-0');
                                set_list_item.innerHTML = `
                                    <div class="mt-2 fw-bold rounded py-3" style="background-color: #F6F7FB;">
                                        <div class="fs-5 ps-3 card_count"></div>
                                        <div class="fs-4 ps-3 set_title">${dt.title}</div>
                                    </div>
                                `;

                                // 해당 세트로 이동
                                let set_url = '{{ route("show-set", ":id") }}';
                                set_url = set_url.replace(':id', dt.id);
                                set_list_item.href = set_url;
                                
                                searched_yesterday_hr.after(set_list_item);
                            }
                        } else if(sliced_date !== revised_today && sliced_date !== yesterday && 
                            (new Date()).getFullYear() == (new Date(dt.created_at)).getFullYear() && 
                            (new Date()).getMonth() == (new Date(dt.created_at)).getMonth() && 
                            getWeek(new Date()) == getWeek(new Date(dt.created_at))) {
                            // 이번 주
                            if(!document.querySelector('.searched_this_week_hr')) {
                                let set_list = document.createElement('div');
                                set_list.classList.add('row');
                                set_list.style.marginTop = '5%';
                                set_list.innerHTML = `
                                    <div class="col-auto p-0 fw-bold" style=" font-size: 18px;">이번 주</div>
                                    <div class="col pe-0 searched_this_week_hr"><hr></div>
                                `;
                                searched_set_list.appendChild(set_list);
                            }
                        
                            let searched_this_week_hr = document.querySelector('.searched_this_week_hr');
                            if(searched_this_week_hr) {
                                let set_list_item = document.createElement('a');
                                set_list_item.classList.add('go_to_set', 'p-0');
                                set_list_item.innerHTML = `
                                    <div class="mt-2 fw-bold rounded py-3" style="background-color: #F6F7FB;">
                                        <div class="fs-5 ps-3 card_count"></div>
                                        <div class="fs-4 ps-3 set_title">${dt.title}</div>
                                    </div>
                                `;

                                // 해당 세트로 이동
                                let set_url = '{{ route("show-set", ":id") }}';
                                set_url = set_url.replace(':id', dt.id);
                                set_list_item.href = set_url;

                                searched_this_week_hr.after(set_list_item);
                            }
                        } else if((new Date()).getFullYear() == (new Date(dt.created_at)).getFullYear() && 
                            (new Date()).getMonth() == (new Date(dt.created_at)).getMonth() && 
                            (getWeek(new Date()) - 1) == getWeek(new Date(dt.created_at))) {
                            // 저번 주
                            if(!document.querySelector('.searched_last_week_hr')) {
                                let set_list = document.createElement('div');
                                set_list.classList.add('row');
                                set_list.style.marginTop = '5%';
                                set_list.innerHTML = `
                                    <div class="col-auto p-0 fw-bold" style=" font-size: 18px;">저번 주</div>
                                    <div class="col pe-0 searched_last_week_hr"><hr></div>
                                `;
                                searched_set_list.appendChild(set_list);
                            }
                        
                            let searched_last_week_hr = document.querySelector('.searched_last_week_hr');
                            if(searched_last_week_hr) {
                                let set_list_item = document.createElement('a');
                                set_list_item.classList.add('go_to_set', 'p-0');
                                set_list_item.innerHTML = `
                                    <div class="mt-2 fw-bold rounded py-3" style="background-color: #F6F7FB;">
                                        <div class="fs-5 ps-3 card_count"></div>
                                        <div class="fs-4 ps-3 set_title">${dt.title}</div>
                                    </div>
                                `;

                                // 해당 세트로 이동
                                let set_url = '{{ route("show-set", ":id") }}';
                                set_url = set_url.replace(':id', dt.id);
                                set_list_item.href = set_url;

                                searched_last_week_hr.after(set_list_item);
                            }
                        } else {
                            // searched_date_set에 else 날짜 저장
                            let else_year = new Date(dt.created_at).getFullYear();
                            let else_month = new Date(dt.created_at).getMonth() + 1;
                            let else_year_and_month = else_year + '-' + else_month;

                            searched_date_set.add(else_year_and_month);
                        }
                    });

                    // 검색된 else 부분 만들기
                    searched_date_set.forEach(sds => {
                        data.forEach(dt => {
                            let else_year = new Date(dt.created_at).getFullYear();
                            let else_month = new Date(dt.created_at).getMonth() + 1;
                            let else_year_and_month = else_year + '-' + else_month;
                        
                            // else의 월이 현재의 월과 같으면 오늘, 어제, 이번 주, 지난 주 빼야 됨
                            let set_date = new Date(dt.created_at.slice(0, 10));
                            let sliced_date = dt.created_at.slice(0, 10);
                        
                            if((revised_today.slice(0, 7) == sliced_date.slice(0, 7) && 
                            (getWeek(new Date()) - 2) >= getWeek(new Date(dt.created_at))) || 
                            revised_today.slice(0, 7) !== sliced_date.slice(0, 7)) {
                                if(sds == else_year_and_month) {
                                    if(!document.querySelector(`.hr_${sds}_searched`)) {
                                        let sliced_year = sds.slice(0, 4);
                                        let sliced_month = sds.slice(5);
                                    
                                        let set_list = document.createElement('div');
                                        set_list.classList.add('row');
                                        set_list.style.marginTop = '5%';
                                        set_list.innerHTML = `
                                            <div class="col-auto p-0 fw-bold" style=" font-size: 18px;">${sliced_year}년 ${sliced_month}월</div>
                                            <div class="col pe-0 hr_${sds}_searched"><hr></div>
                                        `;
                                        searched_set_list.appendChild(set_list);
                                    }
                                
                                    let one = document.querySelector(`.hr_${sds}_searched`);
                                    if(one) {
                                        let set_list_item = document.createElement('a');
                                        set_list_item.classList.add('go_to_set', 'p-0');
                                        set_list_item.innerHTML = `
                                            <div class="mt-2 fw-bold rounded py-3" style="background-color: #F6F7FB;">
                                                <div class="fs-5 ps-3 card_count"></div>
                                                <div class="fs-4 ps-3 set_title">${dt.title}</div>
                                            </div>
                                        `;

                                        // 해당 세트로 이동
                                        let set_url = '{{ route("show-set", ":id") }}';
                                        set_url = set_url.replace(':id', dt.id);
                                        set_list_item.href = set_url;

                                        one.after(set_list_item);
                                    }
                                }
                            }
                        })
                    })

                    // 단어 갯수 표시
                    let card_count_all = document.querySelectorAll('.card_count');
                    number_of_cards.forEach(nc => {
                        card_count_all.forEach(cc => {
                            if(cc.nextElementSibling.innerText == nc['set_title']) {
                                cc.innerText = nc['count'] + ' 단어';
                            }
                        })
                    });

                    // 검색 시 겹치는 단어 하이라이트
                    let set_title_all = document.querySelectorAll('.set_title');
                    set_title_all.forEach(st => {
                        let text = st.textContent;
                    
                        if (search_creator.trim() === '') {
                            st.innerHTML = text;
                            return;
                        }
                    
                        let regex = new RegExp(`(${search_creator})`, 'gi');
                        let newText = text.replace(regex, '<span class="highlight">$1</span>');
                        // -> $1은 정규 표현식에서 캡처 그룹을 참조하는 데 사용되는 구문
                        st.innerHTML = newText;
                    })

                } else if(data == '') {
                    console.log('@@@');
                    searched_set_list.style.display = 'block';
                    searched_set_list.innerHTML = `
                        <div class="fs-4 mt-5">"${search_creator}"에 해당하는 세트가 없습니다</div>
                    `;
                }

            })
            .catch(error => console.error('Error:', error));

        } else {
            set_list_warpper.style.display = 'block';
            searched_set_list.style.display = 'none';
        }
    });

    // 단어 갯수 표시
    let card_count_all = document.querySelectorAll('.card_count');
    number_of_cards.forEach(nc => {
        card_count_all.forEach(cc => {
            if(cc.nextElementSibling.innerText == nc['set_title']) {
                cc.innerText = nc['count'] + ' 단어';
            }
        })
    });

    // 해당 세트로 이동
    // let go_to_set_all = document.querySelectorAll('.go_to_set');
    // go_to_set_all.forEach(gts => {
    // })
</script>

<style>
    a {
        text-decoration: none; 
        color: black;
    }

    .search_set_input:focus {
        outline: none;
    }

    .go_to_set:hover {
        border-bottom: 4px solid mediumpurple;
    }

    .highlight {
        background-color: gold;
    }
</style>
@endsection