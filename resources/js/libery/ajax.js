import * as  search from "./ajaxs/search.js";
import * as  category from "./ajaxs/category.js";

let CsrfToken = null;
const getCsrfToken = () => {
    return CsrfToken ||
        (CsrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
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
                window.location.href = url + '?' + queryString;
                throw new Error('Network response was not ok.');
            }
        })
        .then(data => {
            if (data.log) {
                console.log(data.log)
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
