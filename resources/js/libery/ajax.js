import * as  search from "./ajaxs/search.js";
import * as  category from "./ajaxs/category.js";

let timeout_func = {};
let CsrfToken = null;
let CustomAlert = null;
const getCsrfToken = () => {
    return CsrfToken ||
        (CsrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
}
const getCustomAlert = () => {
    return CustomAlert ||
        (CustomAlert = document.querySelector('.custom-alert'));
}

export function SendPostNoForm(url, data = [], function_name = "") {
    return fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken()
        },
        body: JSON.stringify(data)
    })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                const queryString = Object.keys(data).map(key => key + '=' + data[key]).join('&');
                // window.location.href = url + '?' + queryString;
                // location.reload();
                throw new Error('Network response was not ok.');
            }
        })
        .then(data => {
            if (data.log) {
                console.log(data.log)
            }
            if (data.alert) {
                custom_alert(data)
            }
            if (function_name)
                functionsArray[function_name](data);
            return data;
        })
        .catch(error => {
            // Обрабатываем ошибку
            console.error('Ошибка', error);
        });
}


export function Post(form, function_name = "") {
    event.preventDefault();
    const url = form.action;
    const formData = new FormData(form);

    getResource(url, formData)
        .then(data => {
            if (data.log) {
                console.log(data.log)
            }
            if (data.alert) {
                custom_alert(data)
            }
            functionsArray[function_name](data);
        })
        .catch(error => {
            console.error("Ошибка при отправке данных:", error);
        });

    async function getResource(url, formData) {
        const res = await fetch(url, {
            method: 'POST',
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": getCsrfToken(),
            },
            body: formData
        });

        if (!res.ok) {
            throw new Error(`Не удалось получить ${url}, статус: ${res.status}`);
        }

        return await res.json();
    }
}

export const FindPostForm = (element, function_name = "") => {
    let parentElement = null;
    do {
        if (!parentElement) {
            parentElement = element;
        }
        parentElement = parentElement.parentNode;
    } while ((parentElement.tagName.toLowerCase() !== 'form'));
    Post(parentElement, function_name)
}
export const PostFormFind = (element, function_name = "") => {
    const parentElement = document.querySelector('#' + element)
    Post(parentElement, function_name)
}

const functionsArray = {
    ...category,
    ...search,
};
const custom_alert = (data) => {
    let alert_type_class;
    switch (data.alert_type) {
        case 'warning':
            alert_type_class = 'warning';
            break
        case 'error':
            alert_type_class = 'error';
            break
        case 'success':
        default :
            alert_type_class = 'success';
    }
    // timeout_func
    getCustomAlert().innerHTML = data.alert
    getCustomAlert().className = 'custom-alert display';
    getCustomAlert().classList.add(alert_type_class);

    if (timeout_func.custom_alert_class){
        clearTimeout(timeout_func.custom_alert_class)
        timeout_func.custom_alert_class = null;
    }
    if (timeout_func.custom_alert){
        clearTimeout(timeout_func.custom_alert)
        timeout_func.custom_alert = null;
    }
    timeout_func.custom_alert_class = setTimeout(()=>{
        getCustomAlert().classList.remove(alert_type_class);
        timeout_func.custom_alert_class = null;
    },1000)

    timeout_func.custom_alert = setTimeout(()=>{
        getCustomAlert().className = 'custom-alert';
        timeout_func.custom_alert = null;
    },3000)

}
