document.querySelectorAll('.password').forEach(passwordField => {
    let toggleIcon = passwordField.nextElementSibling;
    
    toggleIcon.addEventListener('click', () => {
        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.innerHTML = '<i class="fas fa-eye-slash"></i>';
        } else {
            passwordField.type = "password";
            toggleIcon.innerHTML = '<i class="fas fa-eye"></i>';
        }
    });
});

const error = document.getElementById('errors');
if(error.content==='')
{
    error.style.display="none";
}
