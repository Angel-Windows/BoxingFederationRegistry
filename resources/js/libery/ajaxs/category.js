let timeoutFunc = null;
let isReloading = false;

export function form_edit_category() {
    if (!localStorage.getItem('reloadDone') && !isReloading) {
        isReloading = true;

        if (timeoutFunc) {
            clearTimeout(timeoutFunc);
            timeoutFunc = null;
        }

        timeoutFunc = setTimeout(() => {
            localStorage.setItem('reloadDone', true);
            location.reload();


            localStorage.removeItem('reloadDone');

            isReloading = false;
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

