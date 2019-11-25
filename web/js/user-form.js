const firstname = document.querySelector('#firstname');
const lastname = document.querySelector('#lastname');
const username = document.querySelector('#username');

firstname.addEventListener('input', updateFirst);
lastname.addEventListener('input', updateLast);

function updateFirst(e) {
    firstNameValue = e.target.value.toLowerCase().replace(/\s/g, '');
    lastNameValue = username.value.split(".");
    firstNameValue = firstNameValue.replace(/\./g, '');

    if (lastNameValue[1]) {
        lastNameValue[1] = `.${lastNameValue[1]}`;
        username.value = `${firstNameValue}${lastNameValue[1]}`;
    } else {
        username.value = firstNameValue;
    }
}

function updateLast(e) {
    lastNameValue = e.target.value.toLowerCase().replace(/\s/g, '');
    firstNameValue = firstname.value.toLowerCase().replace(/\s/g, '');
    lastNameValue = lastNameValue.replace(/\./g, '');
    lastNameValue = `.${lastNameValue}`;
    firstNameValue = firstNameValue.replace(/\./g, '');
    username.value = '';
    console.log(e.target.value && e.target.value)
    if (e.target.value.length === 0) {
        username.value = `${firstNameValue}`
    } else {
        username.value = `${firstNameValue}${lastNameValue}`;
    }

}