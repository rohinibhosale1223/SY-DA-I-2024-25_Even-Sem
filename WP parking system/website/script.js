const validLogin = { username: false, password: false };
const validRegister = { username: false, password: false };

function validateInput(input, type, form) {
  const value = input.value.trim();
  let isValid = false;

  if (type === 'username') {
    isValid = value.length > 5;
  } else if (type === 'password') {
    isValid = /^(?=.*[0-9])(?=.*[!@#$%^&*]).{6,16}$/.test(value);
  }

  input.style.borderColor = isValid ? 'green' : 'red';

  if (form === 'login') {
    validLogin[type] = isValid;
  } else {
    validRegister[type] = isValid;
  }

  const isFormValid = form === 'login'
    ? validLogin.username && validLogin.password
    : validRegister.username && validRegister.password;

  document.getElementById(`${form}-submit-btn`).disabled = !isFormValid;
}

function togglePass(e, fieldId, buttonId) {
  e.preventDefault();
  const field = document.getElementById(fieldId);
  const button = document.getElementById(buttonId);
  if (field.type === 'password') {
    field.type = 'text';
    button.innerText = 'Hide Password';
  } else {
    field.type = 'password';
    button.innerText = 'Show Password';
  }
}
