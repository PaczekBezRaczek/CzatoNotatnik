// Połączenie z api
const api = "http://10.103.8.113/api/api.php";

document.getElementById("sendMsgBtn").onclick = () => {
  const box = document.getElementById("chatBox");
  const msg = document.getElementById("chatInput").value;
  if (msg.trim() !== "") {
    const el = document.createElement("div");
    el.style.alignSelf = "flex-end";
    el.style.background = "#3b7bdb";
    el.style.color = "white";
    el.style.padding = "8px 12px";
    el.style.borderRadius = "15px 15px 0 15px";
    el.style.margin = "4px 0";
    el.textContent = msg;
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
