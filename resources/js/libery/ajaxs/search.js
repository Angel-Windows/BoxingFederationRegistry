const modal_wrapper = document.querySelector('.modal_wrapper');
const modal_content = modal_wrapper.querySelector('.modal_content');
let search_result_list = null;
export function modal_open(data) {
    modal_wrapper.classList.add('open')
    modal_content.innerHTML = data['data'];
    search_result_list = document.querySelector('#search_result_list');
    const search_input = document.querySelector('#search_input');

    search_input.addEventListener('input', (e) => {
        functionsArray['ajax_findPostForm'](e.target, "search_in_class")
    });
}
export function search_in_class(data) {

    search_result_list.innerHTML = data['data']
}
