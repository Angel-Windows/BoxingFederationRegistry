export function open_modal(modal_name, data = []) {
    const url = getAjaxLink("open-modal");
    functionsArray['ajax_postNoForm'](url, data, 'modal_open', {'data':2})
}
