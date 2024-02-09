import {inputs_input} from "@/components/forms.js";

const modal_wrapper = document.querySelector('.modal_wrapper');
const modal_content = modal_wrapper.querySelector('.modal_content');
let search_result_list = null;

export function modal_open(data, class_name = '') {
    modal_wrapper.classList.add('open')
    modal_content.innerHTML = data['data'];
    modal_content.className = 'modal_content ' + data['class_name']

    let input;
    console.log(data.class_name)

    switch (data.class_name) {

        case "search":
            search();
            break;
        case "upload_img":
            upload_img();
            break;
        case "check-code":
            check_code();
            break;
        case "add-form-item":
            searchNoForm()
            input = modal_wrapper.querySelectorAll('.input');
            functionsArray['inputs_input']('modal_wrapper')
            break;
        case "category-register":
            input = modal_wrapper.querySelectorAll('.input');
            functionsArray['inputs_input']('modal_wrapper')
            upload_img();
            break;
    }
}
upload_img();
function search(data = {}) {
    const search_input = document.querySelector('#search_input');
    search_result_list = document.querySelector('#search_result_list');
    search_input.addEventListener('input', (e) => {
        functionsArray['ajax_findPostForm'](e.target, "search_in_class")
    });
}
function searchNoForm(data = {}) {
    const search_input = document.querySelector('.modal_wrapper .custom-select-input');
    inputs_input('modal_wrapper', false);
    search_result_list = document.querySelector('.modal_wrapper .custom-select-options');
    const url = getAjaxLink("search-in-class-no-form");
    search_input.addEventListener('input', (e) => {
        functionsArray['ajax_postNoForm'](url, {
            'search_value': 'a',
            'class_types': 3,

        }, 'search_in_class_no_form')
    });
}

function upload_img() {

    const imageWrapper = document.querySelector('.upload_img');
    if (!imageWrapper){
        return false;
    }

    const imagePreview = imageWrapper.querySelector('input');
    const dragText = imageWrapper.querySelector('.drop');
    const fileInput = imageWrapper.querySelector("input[type='file']");
    const button_open_file = imageWrapper.querySelector('.button_open_file')
    console.log(dragText)

    button_open_file.addEventListener('click', () => {
        fileInput.click()
    })
    document.addEventListener('dragover', function (event) {
        event.preventDefault();
        dragText.classList.add('active');
    });

    document.addEventListener('dragleave', function (event) {
        dragText.classList.remove('active');
        event.preventDefault();
    });

    imageWrapper.addEventListener('drop', function (event) {
        event.preventDefault();
        dragText.classList.remove('active');

        const file = event.dataTransfer.files[0];

        if (file.type.match('image.*')) {
            displayImage(file)
        } else {
            alert('Пожалуйста, перетащите изображение');
        }

        // Скопируйте файл в input type="file"
        fileInput.files = event.dataTransfer.files;


    });
    fileInput.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file.type.match('image.*')) {
            displayImage(file);
        } else {
            alert('Пожалуйста, выберите изображение');
        }

    });

    function displayImage(file) {
        const reader = new FileReader();
        reader.onload = function (event) {
            imagePreview.src = event.target.result;
        };
        reader.readAsDataURL(file);
    }
}

export function search_in_class(data) {

    search_result_list.innerHTML = data['data']
}
export function search_in_class_no_form(data) {

    search_result_list.innerHTML = data['data']
}

function check_code() {
    console.log('')
}
