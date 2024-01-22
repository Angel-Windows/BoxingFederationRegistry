import * as  search from "./ajaxs/search.js";

let CsrfToken = null;
const getCsrfToken = () => {
    return CsrfToken ||
        (CsrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
}

export function SendPostNoForm(url, data, function_name = "") {
    return fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken()
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(data => {
            functionsArray[function_name](data);
            return data;
        })
        .catch(error => {
            console.error('Ошибка', error);
        });
}

export function Post(form, function_name = "") {
    event.preventDefault();
    const url = form.action;
    const formData = new FormData(form);

    getResource(url, formData)
        .then(data => {
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
const functionsArray = {
    ...search,
};