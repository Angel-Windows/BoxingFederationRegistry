export function form_edit_category() {
    console.log(23)
}

export function modal_write_phone(data) {
    functionsArray['open_modal']('check-code', {})
}

export function modal_write_phone_code(data) {
    if (data['type'] === 'Success'){
        location.reload();
    }else {
        console.log(data.type)
    }
}

