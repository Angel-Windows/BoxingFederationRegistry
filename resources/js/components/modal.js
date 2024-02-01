export function open_modal(modal_name, data = []) {
    const url = getAjaxLink("open-modal");
    data.modal = modal_name
    functionsArray['ajax_postNoForm'](url, data, 'modal_open', {'data':2})
}
