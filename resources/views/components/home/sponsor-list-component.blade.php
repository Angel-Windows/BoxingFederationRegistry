<div class="sponsor-block">
    <h2>Спонсори та партнери</h2>
    <div class="sponsor-list">
        @for($i = 0; $i < 7; $i++)
            <div class="card">
                <div class="img logo">
                    <img src="{{asset('img/homeAbout/sponsor_logo.svg')}}" alt="sponsor logo">
                </div>
                <h3>Назва компанії</h3>
            </div>
        @endfor
    </div>
</div>
