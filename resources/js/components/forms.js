export const inputs_input = (parent_class) => {
    let parent = document.querySelector('.' + parent_class);
    if (!parent) parent = document;
    const all_inputs = parent.querySelectorAll('.input')
    all_inputs.forEach((item) => {
        item.addEventListener('focus', () => {
            functionsArray['add_parent_active'](item, 'label', 'active')
        })
        item.addEventListener('blur', () => {
            setTimeout(() => {
                if (item.value !== "") {
                    functionsArray['add_parent_active'](item, 'label', 'active')
                } else {
                    functionsArray['remove_parent_active'](item, 'label', 'active')
                }
            }, 100)
        })
    })
    const custom_select = parent.querySelectorAll('.custom-select')
    custom_select.forEach((item) => {
        let selectInput = item.querySelector('.custom-select-input');
        let selectOptions = item.querySelector('.custom-select-options');
        let optionItems = selectOptions.querySelectorAll('li');

        selectInput.addEventListener('focus', function () {
            filterOptions(selectInput, selectOptions, optionItems);
            selectOptions.style.display = 'block';
        });

        selectInput.addEventListener('input', function () {
            filterOptions(selectInput, selectOptions, optionItems);
            selectOptions.style.display = 'block';
        });

        selectOptions.addEventListener('click', function (e) {
            if (e.target.tagName === 'LI') {
                selectInput.value = e.target.textContent;
                selectOptions.style.display = 'none';
            }
        });

        document.addEventListener('click', function (e) {
            if (!selectInput.contains(e.target) && !selectOptions.contains(e.target)) {
                selectOptions.style.display = 'none';
            }
        });
    })

    function filterOptions(selectInput, selectOptions, optionItems) {
        let inputValue = selectInput.value.toLowerCase();
        optionItems.forEach(function (item) {
            if (inputValue === '') {
                selectOptions.classList.add('show-all');
            } else {
                selectOptions.classList.remove('show-all');
            }
            if (item.textContent.toLowerCase().indexOf(inputValue) > -1) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }
}
