const modal_wrapper = document.querySelector('.modal_wrapper');
const modal_content = modal_wrapper.querySelector('.modal_content');
export default function modal_open(data){
    modal_wrapper.classList.add('open')
    modal_content.innerHTML = data['data'];
}
