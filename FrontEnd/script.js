document.getElementById("sendMsgBtn").onclick = () => {
  const box = document.getElementById("chatBox");
  const msg = document.getElementById("chatInput").value;
  if (msg.trim() !== "") {
    const el = document.createElement("div");
    el.textContent = msg;
    el.classList.add('msg')
    box.appendChild(el);
    document.getElementById("chatInput").value = "";
    box.scrollTop = box.scrollHeight;
  }
};
document.getElementById("loginBtn").onclick = () => {
  const name = document.getElementById("loginName").value.trim();
  const role = document.getElementById("loginRole").value;
  const pass = document.getElementById("loginPass").value.trim();


  if (name === "") return alert("Wpisz nazwę użytkownika!");

  // Dodanie do listy osób
  const userList = document.getElementById("userList");
  const li = document.createElement("li");
  li.textContent = name + (role === "teacher" ? " (Nauczyciel)" : "");
  userList.appendChild(li);

  // Wyczyść pole i zamknij login
  document.getElementById("loginBox").style.display = "none";
};

function theme() {
    const html = document.documentElement;
    const btn = document.getElementById("themeToggle");
    if (html.getAttribute('data-theme') === 'light') {
        html.removeAttribute('data-theme');
        btn.textContent = 'Motyw: Ciemny';
    } else {
        html.setAttribute('data-theme', 'light');
        btn.textContent = 'Motyw: Jasny';
    }
}