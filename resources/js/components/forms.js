import Inputmask from 'inputmask';

const phone_input_mask = () => {
    const phoneInput = document.querySelectorAll("input[name='phone']");

    if (phoneInput) {
        const maskOptions = {
            mask: '+380 (99) 9999-999'
        };
        const phoneMask = new Inputmask(maskOptions);

        phoneMask.mask(phoneInput);
    }

}
const select_trainer_ajax = (input_value) => {

    const federation_id = document.querySelector('select[name="federation"]');
    const sports_institutions_id = document.querySelector('select[name="sports_institutions"]');



    console.log(federation_id.value, sports_institutions_id.value);

    functionsArray['ajax_postNoForm'](getAjaxLink("select_trainer"), {
        'trainer_id': input_value.value,
        'federation_id': federation_id.value,
        'sports_institutions_id': sports_institutions_id.value,
    }, 'select_trainer')
}
export const inputs_input = (parent_class, is_search = true) => {
    phone_input_mask()


    let parent = document.querySelector('.' + parent_class)
    if (!parent) parent = document;

    const labels = parent.querySelectorAll('.label.hovered')

    const all_inputs = parent.querySelectorAll('.input')

    labels.forEach((item) => {
        item.addEventListener('click', () => {
            item.classList.add('active')
        })
    })
    // console.log(labels, all_inputs)

    if (all_inputs.length) {
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
                    // select_trainer(
                    //     {
                    //         'federation': [1, 5, 6, 2],
                    //         'sports_institutions': [6, 2],
                    //     }
                    // );
                    if (input_value.name === 'trainer'){
                        select_trainer_ajax(input_value)
                    }
                    selectInput.value = e.target.textContent;
                    selectOptions.style.display = 'none';
                    item.classList.add('active')
                }
            });
            parent.querySelector('form').addEventListener('click', function (e) {
                if (!selectInput.contains(e.target) && !selectOptions.contains(e.target)) {
                    if (selectOptions.style.display === 'block') {
                        if (selectInput.value !== '') {
                            selectInput.value = old_value.value;
                        } else {
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

}
