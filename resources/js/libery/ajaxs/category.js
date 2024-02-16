export function form_edit_category() {
    setTimeout(()=>{
        location.reload();
    },300)
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

