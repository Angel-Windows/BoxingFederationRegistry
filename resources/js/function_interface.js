import * as  ajax_scripts from './libery/ajax.js';
import * as  home_scripts from './home_scripts.js';
import * as  modals_scripts from './components/modal.js';
import * as forms_script from "./components/forms.js";

const checkbox_toggle = (elem) => {
    const input = elem.querySelector('input');

    const shouldRevert = input.classList.contains('revert');
    input.checked = shouldRevert ? !elem.classList.contains('delete') : elem.classList.contains('delete');
}
const add_family = (elem) => {
    const formData = elem.parentNode.parentNode;
    let arr = {
        name: formData.name.value,
        status: formData.status[formData.status.value-0+1].textContent,
        phone: formData.phone.value,

    }

    let type__checkbox = document.querySelector('.type__checkbox ')

    const clone = type__checkbox.cloneNode(true)
    let type__checkbox_td = clone.querySelectorAll('td')
    type__checkbox_td[0].innerText = arr['name'];
    type__checkbox_td[1].innerText = arr['status'];
    type__checkbox_td[3].innerText = arr['phone'];
    type__checkbox_td[4].querySelector('input').value = JSON.stringify(arr);
    clone.classList.remove('d-none')
    clone.querySelector('input').checked = true;
    type__checkbox.parentNode.append(clone)

    // functionsArray['toggle_parent_active'](this, 'modal_wrapper', 'open')
    document.querySelector('.modal_wrapper').classList.remove('open')
}




window.functionsArray = {
    'ajax_post': ajax_scripts.Post,
    'ajax_postNoForm': ajax_scripts.SendPostNoForm,
    'ajax_findPostForm': ajax_scripts.FindPostForm,
    'ajax_postFormFind': ajax_scripts.PostFormFind,
    'remove_old_active': home_scripts.removeOldActive,
    'add_parent_active': home_scripts.addParentActive,
    'remove_parent_active': home_scripts.removeParentActive,
    'toggle_parent_active': home_scripts.toggleParentActive,
    'add_class': home_scripts.add_class,
    'remove_class': home_scripts.remove_class,
    'button_temp_input': home_scripts.button_temp_input,
    'hideOverflowingElements_start': home_scripts.hideOverflowingElements_start,
    'open_modal': modals_scripts.open_modal,


    'inputs_input': forms_script.inputs_input,


    'checkbox_toggle': checkbox_toggle,


    'add_family': add_family,
}



window.validateForm = (e) => {
    if (e.classList.contains('submit')){
        return false;
    }
    e.classList.add('submit');


}
window.getAjaxLink = (page) => {
    const ajax_link_meta = document.querySelector('meta[name="ajax-link"]');
    if (!ajax_link_meta)
        return "";
    const ajax_link = ajax_link_meta.getAttribute('content');
    return ajax_link + '/' + page;
}
//
// color a & curl parrot.live
