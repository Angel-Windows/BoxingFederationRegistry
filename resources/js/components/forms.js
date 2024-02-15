export const inputs_input = (parent_class, is_search = true) => {
    let parent = document.querySelector('.' + parent_class);
    if (!parent) parent = document;
    // console.log(parent)
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
        let input_value = item.querySelector('.input-value')
        let old_value = item.querySelector('.old-value')

        selectInput.addEventListener('focus', function () {

            old_value.value = selectInput.value;
            if (is_search) {
                filterOptions(selectInput, selectOptions, optionItems);
            }
            selectOptions.style.display = 'block';
        });

        selectInput.addEventListener('input', function () {
            if (is_search) {
                filterOptions(selectInput, selectOptions, optionItems);
            }
            selectOptions.style.display = 'block';
        });

        selectOptions.addEventListener('click', function (e) {
            if (e.target.tagName === 'LI') {
                input_value.value = e.target.dataset.value
                selectInput.value = e.target.textContent;
                selectOptions.style.display = 'none';
                item.classList.add('active')
            }
        });
        parent.querySelector('form').addEventListener('click', function (e) {
            if (!selectInput.contains(e.target) && !selectOptions.contains(e.target)) {
                if (selectOptions.style.display === 'block') {
                   if (selectInput.value !== ''){
                       selectInput.value = old_value.value;
                   }else {
                       input_value.value = null;
                       old_value.value = null;
                   }
                    selectOptions.style.display = 'none';
                }
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
