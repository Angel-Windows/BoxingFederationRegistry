import * as  ajax_scripts from './libery/ajax.js';
import * as  home_scripts from './home_scripts.js';
import * as  modals_scripts from './components/modal.js';
import * as forms_script from "./components/forms.js";
import window from "inputmask/lib/global/window.js";

const checkbox_toggle = (elem) => {
    const input = elem.querySelector('input');

    const shouldRevert = input.classList.contains('revert');
    input.checked = shouldRevert ? !elem.classList.contains('delete') : elem.classList.contains('delete');
}
const add_family = (elem) => {
    const formData = elem.parentNode.parentNode;
    let arr = {
        name: formData.name.value,
        status: formData.status[formData.status.value - 0 + 1].textContent,
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


window.addHistoryWork = () => {
    const formData = document.querySelector("#history_work_form");


    let arr = {
        type: 'new',
        // role: (formData.position[formData.position.value - 0 + 1].textContent).trim(),
        sport_institute: formData.sport_institute.value,
        sport_institute_text: formData.sport_institute_text.value,
        date_start: formData.date_start.value,

    }
    console.log(arr)


    let type__checkbox = document.querySelector('.history-work .d-none')

    const clone = type__checkbox.cloneNode(true)
    let type__checkbox_td = clone.querySelectorAll('td')
    // type__checkbox_td[0].innerText = arr['position'];
    type__checkbox_td[0].innerText = arr['sport_institute_text'];
    type__checkbox_td[1].innerText = arr['date_start'];
    type__checkbox_td[4].querySelector('input').value = JSON.stringify(arr);
    clone.classList.remove('d-none')
    clone.querySelector('input').checked = true;
    type__checkbox.parentNode.append(clone)

    // functionsArray['toggle_parent_active'](this, 'modal_wrapper', 'open')
    document.querySelector('.modal_wrapper').classList.remove('open')
};


const remove_parent = (item) => {
    const parent = item.parentNode.parentNode;
    parent.parentNode.removeChild(parent);
}
let timer_submit = {};
window.submit_form = (e, type) => {
    if (timer_submit[type]) {
        clearTimeout(timer_submit[type])
        timer_submit[type] = null;
    }
    switch (type) {
        case "modal_write_phone":
            const modal_write_phone = document.querySelector('#modal_write_phone');
            const err = modal_write_phone.querySelector(".err");
            const input = modal_write_phone.querySelector("input[name='phone']");

            let is_not_symbol = input.value.indexOf('_') === -1;


            if (is_not_symbol && !!input.value) {
                functionsArray['ajax_postFormFind']('modal_write_phone', 'modal_write_phone');
            } else {
                err.classList.remove('no-display');
                timer_submit[type] = setTimeout(() => {
                    err.classList.add('no-display');
                    timer_submit[type] = null;
                }, 5000)

            }
            break;
    }
    e.preventDefault();
    return false;
}
let timer_selfie_img = null;
window.selfie_image = () => {

    const imagePreview = document.querySelector("input[type='image']");
    const default_upload_buttons = document.querySelector('.default_upload_buttons');
    const selfie_upload_buttons = document.querySelector('.selfie_upload_buttons');
    const takePhotoButton = document.getElementById('selfie_image_button');
    const switchCameraButton = document.getElementById('selfie_image_button_change');
    const switchCameraCancel = document.getElementById('selfie_image_button_cancel');
    const fileInput = document.getElementById('file-input');
    let videoStream = null;
    let video = null;

    if (timer_selfie_img) {
        clearTimeout(timer_selfie_img)
        timer_selfie_img = null;
    }


    default_upload_buttons.classList.toggle('no-display');
    selfie_upload_buttons.classList.toggle('no-display');
    timer_selfie_img = setTimeout(() => {
        stopCamera();
    }, 15000)

    async function getVideoStream(deviceId) {
        try {
            const constraints = {video: {deviceId: {exact: deviceId}}};
            videoStream = await navigator.mediaDevices.getUserMedia(constraints);
            return videoStream;
        } catch (error) {
            console.error('Ошибка:', error);
        }
    }

    function stopCamera() {

        default_upload_buttons.classList.remove('no-display');
        selfie_upload_buttons.classList.add('no-display');
        video.classList.add('no-display')
        if (videoStream !== null) {
            videoStream.getTracks().forEach(track => track.stop());
            videoStream = null;
        }
        clearTimeout(timer_selfie_img)
        timer_selfie_img = null;
    }

    switchCameraCancel.addEventListener('click', () => {

        stopCamera();
    });

    window.addEventListener('beforeunload', stopCamera);

    takePhotoButton.addEventListener('click', async () => {
        try {
            if (videoStream === null) {
                console.error('Нет доступа к камере.');
                return;
            }

            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const dataUrl = canvas.toDataURL('image/png');
            const blob = dataURItoBlob(dataUrl);
            const file = new File([blob], 'photo.png', {type: 'image/png'});

            const fileList = new DataTransfer();
            fileList.items.add(file);


            imagePreview.src = URL.createObjectURL(blob);

            fileInput.files = fileList.files;
            stopCamera();
        } catch (error) {
            console.error('Ошибка:', error);
        }
    });

    function dataURItoBlob(dataUrl) {
        const byteString = atob(dataUrl.split(',')[1]);
        const mimeString = dataUrl.split(',')[0].split(':')[1].split(';')[0];
        const ab = new ArrayBuffer(byteString.length);
        const ia = new Uint8Array(ab);
        for (let i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }
        return new Blob([ab], {type: mimeString});
    }

    switchCameraButton.addEventListener('click', async () => {
        try {
            if (videoStream !== null) {
                videoStream.getTracks().forEach(track => track.stop());
            }

            const devices = await navigator.mediaDevices.enumerateDevices();

            const videoDevices = devices.filter(device => device.kind === 'videoinput');

            const currentCameraIndex = videoDevices.findIndex(device => device.deviceId === video.srcObject.getVideoTracks()[0].getSettings().deviceId);

            const nextCameraIndex = (currentCameraIndex + 1) % videoDevices.length;

            videoStream = await getVideoStream(videoDevices[nextCameraIndex].deviceId);

            video.srcObject = videoStream;
        } catch (error) {
            console.error('Ошибка:', error);
        }
    });

    (async () => {
        try {
            const videoStream = await getVideoStream();

            video = document.createElement('video');
            video.srcObject = videoStream;
            video.autoplay = true;
            const parent = document.querySelector('.upload_img');
            console.log(parent);
            if (parent) {
                console.log(video);
                parent.appendChild(video);
            }

        } catch (error) {
            console.error('Ошибка:', error);
        }
    })();
};


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
    'remove_parent': remove_parent,

}


window.validateForm = (e) => {
    if (e.classList.contains('submit')) {
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
