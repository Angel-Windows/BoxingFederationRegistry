<div class="sponsor-block">
    <h2>Спонсори та партнери</h2>
    <div class="your-slider sponsor-list2">
{{--    <div class="your-slider sponsor-list">--}}
        @for($i = 0; $i < 11; $i++)
            <div class="card">
                <div class="img logo">
                    <img src="{{asset('img/homeAbout/sponsor_logo.svg')}}" alt="sponsor logo">
                </div>
                <h3>Назва компанії</h3>
            </div>
        @endfor
    </div>
</div>

