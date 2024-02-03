<style>
    .error-container {
        text-align: center;
    }

    .error-container h1 {
        font-size: 36px;
        margin-bottom: 20px;
    }

    .error-container p {
        font-size: 18px;
        margin-bottom: 40px;
    }

    .error-container a {
        text-decoration: none;
        color: #007bff;
        font-weight: bold;
    }

    .error-container a:hover {
        text-decoration: underline;
    }
</style>
<div class="error-container">
    <h1>Страница не найдена</h1>
    <p>Запрашиваемая вами страница не найдена. Пожалуйста, проверьте URL и повторите попытку.</p>
    <a href="{{route('page.home')}}">Вернуться на главную</a>
</div>
