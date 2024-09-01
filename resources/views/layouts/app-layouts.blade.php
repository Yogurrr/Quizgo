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
    <div class="mt-3 d-flex align-items-center">
        <div class="fw-bold ps-4" style="font-size: 50px; width: 25%; display: inline-block;"><a href="/quizgo" style="color: mediumpurple;">Quizgo</a></div>
        <div class="rounded-pill border border-2 d-flex align-items-center" 
            style="width: 50%; display: inline-block; height: 65px;">
            <div class="ps-4 d-flex align-items-center" style="width: 10%;">
                <img src="/image/search.png" style="width: 50%;">
            </div>
            <div style="width: 80%;">
                <form action="{{ route('search') }}" method="GET">
                    @csrf
                    <input type="text" placeholder="학습 세트 검색" class="fw-bold search_input" name="search"
                        style="border: none; height: 100%; width: 100%; font-size: 20px;" onkeypress="search_function(event)">
                </form>
            </div>
            <div style="width: 10%;" class="d-flex align-items-center justify-content-center">
                <button class="btn rounded-circle fw-bold fs-5" id="search_x"
                    style="background-color: rgb(196, 191, 236); display: none; padding: 5% 15%;">X</button>
            </div>
        </div>
        <div style="width: 10%;">
            <button class="btn fw-bold rounded-circle ms-3"
                style="font-size: 30px; background-color: rgb(196, 191, 236); padding-top: 0; margin-top: 0.5%;">
                <a href="/create-set" style="text-decoration: none; color: black;">┼</a>
            </button>
        </div>
        <div style="width: 15%;" class="d-flex justify-content-end">
            <div class="dropdown me-4">
                <button class="btn dropdown-toggle fw-bold" type="button" data-bs-toggle="dropdown" 
                    aria-expanded="false" style="background-color: rgb(196, 191, 236); color: black;">
                    @if(Auth::check())
                    {{ Auth::user()->name }}
                    @endif
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="/settings">설정</a></li>
                    <li><a class="dropdown-item" href="/">로그아웃</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
        @yield('content')
    </div>

    <div class="mb-5"></div>
</body>

</html>

<script>
    // 검색 input x 버튼
    let search_x = document.querySelector('#search_x');
    let search_input = document.querySelector('.search_input');

    search_input.addEventListener('input', () => {
        if(search_input.value != '') {
            search_x.style.display = 'block';
        } else {
            search_x.style.display = 'none';
        }
    });

    search_x.addEventListener('click', () => {
        search_input.value = '';
        search_x.style.display = 'none';
    });

    // 검색 결과
    let search_function = (e) => {
        if(e.keyCode == 13) {
            console.log(search_input.value);
        }
    }
</script>

<style>
    a {
        text-decoration: none; 
        color: black;
    }

    .search_input:focus {
        outline: none;
    }

    .dropdown-item:focus {
        background-color: rgb(196, 191, 236);
    }
</style>