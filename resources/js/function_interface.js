import * as  ajax_scripts from './libery/ajax.js';
import * as  home_scripts from './home_scripts.js';
import * as  modals_scripts from './components/modal.js';
import * as forms_script from "./components/forms.js";

const checkbox_toggle = (elem) => {
    const input = elem.querySelector('input');

    const shouldRevert = input.classList.contains('revert');
    input.checked = shouldRevert ? !elem.classList.contains('delete') : elem.classList.contains('delete');
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
    'hideOverflowingElements_start': home_scripts.hideOverflowingElements_start,
    'open_modal': modals_scripts.open_modal,


    'inputs_input': forms_script.inputs_input,


    'checkbox_toggle': checkbox_toggle,

};

window.getAjaxLink = (page) => {
    const ajax_link_meta = document.querySelector('meta[name="ajax-link"]');
    if (!ajax_link_meta)
        return "";
    const ajax_link = ajax_link_meta.getAttribute('content');
    return ajax_link + '/' + page;
}
//
// color a & curl parrot.live
