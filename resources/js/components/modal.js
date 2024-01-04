export function open_modal(modal_name) {
    const url = getAjaxLink("open-modal");
    console.log(url)
    functionsArray['ajax_postNoForm'](url, [], 'modal_open')
}
