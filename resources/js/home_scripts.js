const oldActiveArray = {};

const oldActiveArrayInterval = [];

const timeouts = {};
const findParent = (element, parent, func) => {
    let parentElement = null;
    const foundIndex = oldActiveArrayInterval.findIndex(item => item.id === element);
    if (foundIndex === -1) {
        oldActiveArrayInterval.push({
            id: element,
            interval: setTimeout(() => {
                oldActiveArrayInterval.splice(foundIndex, 1);
            }, 5),
        });

        do {


            if (!parentElement) {
                parentElement = element;
            }
            parentElement = parentElement.parentNode;
        } while (!parentElement.classList.contains(parent));
        func(parentElement)
    }
    return {
        'parentElement': parentElement
    }
}

export function addParentActive(element, parent, className = 'active', functionName, params = []) {

    const func = (parentElement) => {
        parentElement.classList.add(className);
        if (functionsArray[functionName] && typeof functionsArray[functionName] === 'function') {
            functionsArray[functionName](parentElement, className, params);
        }
    }

    findParent(element, parent, func)

}

export function removeParentActive(element, parent, className = 'active', functionName, params = []) {

    const func = (parentElement) => {
        parentElement.classList.remove(className);
        if (functionsArray[functionName] && typeof functionsArray[functionName] === 'function') {
            functionsArray[functionName](parentElement, className, params);
        }
    }

    if (timeouts.parentActive) {
        findParent(element, parent, func)
    }

    timeouts.parentActive = setTimeout(() => {
    }, 500)
}

export function toggleParentActive(element, parent, className = 'active', functionName, params = []) {
    const func = (parentElement) => {
        parentElement.classList.toggle(className);
        if (functionsArray[functionName] && typeof functionsArray[functionName] === 'function') {
            functionsArray[functionName](parentElement, className, params);
        }
    }
    findParent(element, parent, func)
}
export function add_class(element, parent, className = 'active', functionName, params = []) {
    document.querySelector('.' + parent).classList.add(className)
}
export function remove_class(parent, className = 'active', functionName, params = []) {
    document.querySelector('.' + parent).classList.remove(className)

}

let is_click = true;
export const button_temp_input = (elem) => {
    const func = (parentElement) => {
        const inputs = parentElement.querySelectorAll('.hovered');
        inputs.forEach((item)=>{
            item.classList.add('temp_active');
        })
        if (is_click){
            if (timeouts.parentActive) {
                clearTimeout(timeouts.parentActive);
                timeouts.parentActive = null
            }else {
                setTimeout(()=>{
                    elem.click();
                },300)
            }
        }
        is_click = !is_click;
        timeouts.parentActive = setTimeout(() => {
            parentElement.querySelectorAll('.temp_active')
            inputs.forEach((item)=>{
                item.classList.remove('temp_active');
            })
            timeouts.parentActive = null
        }, 1000)
    }

    findParent(elem, 'form-tag-class', func)
}
export const removeOldActive = (elem, className, arrayParams) => {
    const index = arrayParams[0];
    if (oldActiveArray[index] && oldActiveArray[index] !== elem) {
        oldActiveArray[index].classList.remove(className);
    }
    oldActiveArray[index] = elem;
};

function hideOverflowingElements() {
    const container = document.querySelector('.sponsor-list');
    if (container){
        const cards = container.querySelectorAll('.card');

        const containerWidth = container.clientWidth;
        let totalWidth = 0;
        container.style.height = cards[0].offsetHeight + 'px';
        cards.forEach((card) => {
            totalWidth += card.offsetWidth;
            if (totalWidth > containerWidth) {
                if (!card.classList.contains('hidden')) {
                    card.classList.add('hidden');
                }
            } else {
                if (card.classList.contains('hidden')) {
                    card.classList.remove('hidden');
                }
            }
        });
    }

}

export const hideOverflowingElements_start = () => {
    window.addEventListener('load', hideOverflowingElements);
    window.addEventListener('resize', hideOverflowingElements);
}

