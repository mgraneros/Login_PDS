

const passwordInput = document.getElementById('password');
console.log('password', passwordInput);

passwordInput.addEventListener('change', () => {
    validatePassword(passwordInput.value);
})

function validatePassword(passwordValue){
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
    if(!regex.test(passwordValue)){
        document.getElementById('passwordError').append('Invalid password, it should have at least 8 characters, one uppercase letter, one lowercase letter, one number and one special character');
    }
}



