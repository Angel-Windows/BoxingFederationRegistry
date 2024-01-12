const oldActiveArray = {};

const oldActiveArrayInterval = [];

export function toggleParentActive(element, parent, className = 'active', functionName, params = []) {
    const foundIndex = oldActiveArrayInterval.findIndex(item => item.id === element);
    if (foundIndex === -1) {
        oldActiveArrayInterval.push({
            id: element,
            interval: setTimeout(() => {
                oldActiveArrayInterval.splice(foundIndex, 1);
            }, 5),
        });
        let parentElement = null;
        do {
            if (!parentElement) {
                parentElement = element;
            }
            parentElement = parentElement.parentNode;
        } while (!parentElement.classList.contains(parent));
        parentElement.classList.toggle(className);
        if (functionsArray[functionName] && typeof functionsArray[functionName] === 'function') {
            functionsArray[functionName](parentElement, className, params);
        }
    }
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

export const hideOverflowingElements_start = () => {
    window.addEventListener('load', hideOverflowingElements);
    window.addEventListener('resize', hideOverflowingElements);
}

