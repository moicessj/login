const btnShowLogin = document.getElementById("show-login");
const btnShowRegister = document.getElementById("show-register");
const formRegister = document.querySelector(".register");
const formLogin = document.querySelector(".login");

btnShowLogin.addEventListener("click", () => {
    formRegister.classList.add("hide");
    formLogin.classList.remove("hide");
});

btnShowRegister.addEventListener("click", () => {
    formLogin.classList.add("hide");
    formRegister.classList.remove("hide");
});
