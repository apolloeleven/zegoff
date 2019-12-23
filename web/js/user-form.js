const firstName = document.querySelector('#firstName');
const lastName = document.querySelector('#lastName');
const userName = document.querySelector('#userName');

if (firstName) {
    firstName.addEventListener('input', autoFill);
}
if (lastName) {
    lastName.addEventListener('input', autoFill);
}

function autoFill() {
    let lastNameValue = lastName.value.toLowerCase().replace(/\s/g, '');
    let firstNameValue = firstName.value.toLowerCase().replace(/\s/g, '');

    if (lastNameValue && firstNameValue) {
        userName.value = `${firstNameValue}.${lastNameValue}`;
    } else if (firstNameValue) {
        userName.value = `${firstNameValue}`;
    } else if (lastNameValue) {
        userName.value = `.${lastNameValue}`;
    } else {
        userName.value = null;
    }
}


