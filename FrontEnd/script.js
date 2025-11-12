// Połączenie z api
const api = "http://10.103.8.113/api/api.php";

<<<<<<< HEAD
// ----- Stan zalogowania -----
let currentUser = null;

// ----- Funkcja logowania -----
function doLogin(name, pass, role) {
  name = (name || "").trim();
  if (name === "") {
    alert("Wpisz nazwę użytkownika!");
    return false;
=======
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
>>>>>>> 806e5465bcd7f8437e36fa6e251ab7f18d780ad4
  }

  // Zapisz aktualnego użytkownika
  currentUser = { name, role };
  localStorage.setItem("user", JSON.stringify(currentUser));

  // Dodaj użytkownika do listy (jeśli nie ma)
  const userList = document.getElementById("userList");
  const exists = [...userList.children].some(li => li.textContent.includes(name));
  if (!exists) {
    const li = document.createElement("li");
    li.textContent = name + (role === "teacher" ? " (Nauczyciel)" : "");
    userList.appendChild(li);
  }

  // Ukryj overlay
  document.getElementById("authOverlay").style.display = "none";

  // Zmień przyciski w panelu
  document.getElementById("loginToggleBtn").style.display = "none";
  document.getElementById("logoutBtn").style.display = "inline-block";
  updateUIForLoginState()
  return true;
}

function doLogout() {
  // Usuń dane użytkownika
  if (currentUser) {
    // Usuń z listy osób
    const userList = document.getElementById("userList");
    [...userList.children].forEach(li => {
      if (li.textContent.includes(currentUser.name)) {
        li.remove();
      }
    });
  }

  currentUser = null;
  localStorage.removeItem("user");

  // Przywróć przyciski logowania / wylogowania
  document.getElementById("loginToggleBtn").style.display = "inline-block";
  document.getElementById("logoutBtn").style.display = "none";

  // ❌ NIE pokazujemy okienka logowania od razu
  document.getElementById("authOverlay").style.display = "none";

  // (opcjonalnie) komunikat
  console.log("Użytkownik wylogowany. Tryb gościa aktywny.");
  updateUIForLoginState();
}

// ----- Obsługa przycisku logowania w overlay -----
document.getElementById("overlayLoginBtn").onclick = () => {
  const name = document.getElementById("overlayLoginName").value;
  const pass = document.getElementById("overlayLoginPass").value;
  const role = document.getElementById("overlayLoginRole").value;
  doLogin(name, pass, role);
};

// ----- Obsługa przycisków w panelu bocznym -----
document.getElementById("loginToggleBtn").onclick = () => {
  document.getElementById("authOverlay").style.display = "flex";
};

document.getElementById("logoutBtn").onclick = () => {
  doLogout();
};

// ----- Sprawdź, czy ktoś był zalogowany -----
window.addEventListener("load", () => {
  const saved = localStorage.getItem("user");
  if (saved) {
    const u = JSON.parse(saved);
    doLogin(u.name, "", u.role);
  } else {
    // Brak użytkownika – overlay pozostaje ukryty (gość)
    document.getElementById("authOverlay").style.display = "none";
  }
  updateUIForLoginState();
});


// ----- Czat – bez zmian -----
document.getElementById("sendMsgBtn").onclick = () => {
  if (!currentUser) {
    alert("Musisz się zalogować, żeby pisać na czacie!");
    return;
  }

  const msg = document.getElementById("chatInput").value.trim();
  if (msg === "") return;
  const box = document.getElementById("chatBox");
  const div = document.createElement("div");
  div.textContent = (currentUser ? currentUser.name + ": " : "Anonim: ") + msg;
  box.appendChild(div);
  document.getElementById("chatInput").value = "";
  box.scrollTop = box.scrollHeight;
};
function updateUIForLoginState() {
  const isLoggedIn = !!currentUser;

  // --- Notatki ---
  const notesTextarea = document.getElementById("notes");
  const saveNotesBtn = document.getElementById("saveNotesBtn");

  notesTextarea.disabled = !isLoggedIn;
  saveNotesBtn.disabled = !isLoggedIn;

  // --- Tablica (tylko nauczyciel może edytować) ---
  const boardTextarea = document.getElementById("board");
  const saveBoardBtn = document.getElementById("saveBoardBtn");

  const isTeacher = currentUser?.role === "teacher";
  boardTextarea.disabled = !(isLoggedIn && isTeacher);
  saveBoardBtn.disabled = !(isLoggedIn && isTeacher);

  // --- Czat ---
  const chatInput = document.getElementById("chatInput");
  const sendMsgBtn = document.getElementById("sendMsgBtn");

  chatInput.disabled = !isLoggedIn;
  sendMsgBtn.disabled = !isLoggedIn;

  // Dodatkowy efekt wizualny (opcjonalny)
  notesTextarea.style.opacity = isLoggedIn ? "1" : "0.5";
  boardTextarea.style.opacity = (isLoggedIn && isTeacher) ? "1" : "0.5";
  chatInput.style.opacity = isLoggedIn ? "1" : "0.5";
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