let timeoutFunc = null;

export function form_edit_category() {
    // Проверяем, была ли уже выполнена перезагрузка страницы
    if (!localStorage.getItem('reloadDone')) {
        if (timeoutFunc) {
            clearTimeout(timeoutFunc);
            timeoutFunc = null;
        }

        timeoutFunc = setTimeout(() => {
            localStorage.setItem('reloadDone', true); // Устанавливаем флаг, что перезагрузка выполнена
            location.reload();
        }, 1000);
    }
}


export function modal_write_phone(data) {
    functionsArray['open_modal']('check-code', {})
}

export function modal_write_phone_code(data) {
    if (data['type'] === 'Success'){
        location.reload();
    }else {
        // console.log(data.type)
    }
}

