// FrontEnd/script.js – FINALNA WERSJA, DZIAŁA Z WASZYM INDEX.HTML
let currentUser = null;
let lastMsgId = 0;

// ====================== LOGOWANIE ======================
async function doLogin() {
    const name = document.getElementById("overlayLoginName").value.trim();
    const pass = document.getElementByRes = document.getElementById("overlayLoginPass").value;

    if (!name || !pass) {
        alert("Wpisz nazwę i hasło!");
        return;
    }

    try {
        const res = await fetch("../Backend/auth.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ name, password: pass })
        });

        const data = await res.json();

        if (data.success) {
            currentUser = data.user;
            localStorage.setItem("user", JSON.stringify(currentUser));
            document.getElementById("authOverlay").style.display = "none";
            loadNotes(currentUser.id);
            loadBoard();
            pollMessages();
            updateUI();
        } else {
            alert(data.error || "Błąd logowania");
        }
    } catch (err) {
        console.error(err);
        alert("Brak połączenia z serwerem szkolnym – sprawdź XAMPP i Apache");
    }
}

// ====================== WYLOGOWANIE ======================
function doLogout() {
    currentUser = null;
    localStorage.removeItem("user");
    document.getElementById("authOverlay").style.display = "flex";
    document.getElementById("chatBox").innerHTML = "";
    lastMsgId = 0;
    updateUI();
}

// ====================== UI ======================
// === ZAMIEN CAŁĄ FUNKCJĘ updateUI() NA TĘ WERSJĘ ===
function updateUI() {
    const logged = !!currentUser;
    const teacher = logged && currentUser.role === "teacher";

    // przyciski logowania/wylogowania (już macie w HTML)
    document.getElementById("loginToggleBtn").style.display = logged ? "none" : "block";
    document.getElementById("logoutBtn").style.display = logged ? "block" : "none";

    // <<< NOWOŚĆ – INFORMACJA O ZALOGOWANYM UŻYTKOWNIKU >>>
    // tworzymy dynamicznie element, jeśli jeszcze go nie ma
    let infoDiv = document.getElementById("dynamicLoggedUserInfo");
    if (!infoDiv) {
        infoDiv = document.createElement("div");
        infoDiv.id = "dynamicLoggedUserInfo";
        infoDiv.style.cssText = `
            margin: 10px 0;
            font-weight: bold;
            color: #1a73e8;
            text-align: center;
            font-size: 14px;
        `;
        // wstawiamy go zaraz pod nagłówkiem "Osoby"
        const header = document.getElementById("userPanelHeader");
        header.insertBefore(infoDiv, document.getElementById("loginToggleBtn"));
    }

    if (logged) {
        const rola = teacher ? "nauczyciel" : "uczeń";
        infoDiv.innerHTML = `Zalogowany jako: <strong>${currentUser.name}</strong> <span style="color:#34a853;">(${rola})</span>`;
    } else {
        infoDiv.innerHTML = "Nie zalogowano";
    }

    // reszta uprawnień bez zmian
    document.getElementById("board").disabled = !teacher;
    document.getElementById("saveBoardBtn").disabled = !teacher;
    document.getElementById("notes").disabled = !logged;
    document.getElementById("saveNotesBtn").disabled = !logged;
    document.getElementById("chatInput").disabled = !logged;
    document.getElementById("sendMsgBtn").disabled = !logged;
}

// ====================== NOTATKI, TABLICA, CZAT – bez zmian (działają) ======================
async function loadNotes(userId) {
    const res = await fetch(`../Backend/notes.php?user_id=${userId}`);
    const data = await res.json();
    document.getElementById("notes").value = data.content || "";
}
async function saveNotes() {
    if (!currentUser) return;
    const content = document.getElementById("notes").value;
    await fetch("../Backend/notes.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ user_id: currentUser.id, content })
    });
}

async function loadBoard() {
    const res = await fetch("../Backend/board.php");
    const data = await res.json();
    document.getElementById("board").value = data.content || "";
}
async function saveBoard() {
    if (!currentUser || currentUser.role !== "teacher") return alert("Tylko nauczyciel!");
    const content = document.getElementById("board").value;
    await fetch("../Backend/board.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ content })
    });
}

const MAX_MESSAGES = 20; // zawsze tylko 20 wiadomości na ekranie

async function pollMessages() {
    if (!currentUser) return;

    try {
        const res = await fetch(`../Backend/message.php?last_id=${lastMsgId}`);
        const messages = await res.json();

        const box = document.getElementById("chatBox");

        messages.forEach(m => {
            const div = document.createElement("div");
            div.textContent = `${m.name}: ${m.text}`;
            div.style.marginBottom = "6px";
            box.appendChild(div);
            lastMsgId = m.id;
        });

        // <<< KLUCZOWE: usuwamy najstarsze jeśli jest więcej niż 20 >>>
        while (box.children.length > MAX_MESSAGES) {
            box.removeChild(box.children[0]); // usuwa najstarszą (pierwszą)
        }

        box.scrollTop = box.scrollHeight;
    } catch (err) {
        console.error(err);
    }

    setTimeout(pollMessages, 2000);
}

// Po wysłaniu wiadomości też czyścimy stare (na wszelki wypadek)
async function sendMessage() {
    if (!currentUser) return;
    const input = document.getElementById("chatInput");
    const text = input.value.trim();
    if (!text) return;

    input.value = "";

    await fetch("../Backend/message.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ user_id: currentUser.id, text })
    });

    // Po wysłaniu też sprawdzamy limit (żeby od razu zniknęła najstarsza)
    const box = document.getElementById("chatBox");
    while (box.children.length > MAX_MESSAGES) {
        box.removeChild(box.children[0]);
    }
}

// ====================== EVENTY ======================
document.getElementById("overlayLoginBtn").addEventListener("click", doLogin);
document.getElementById("logoutBtn").addEventListener("click", doLogout);
document.getElementById("saveNotesBtn").onclick = saveNotes;
document.getElementById("saveBoardBtn").onclick = saveBoard;
document.getElementById("sendMsgBtn").onclick = sendMessage;

// Enter = wyślij / zaloguj
document.getElementById("chatInput").addEventListener("keypress", e => e.key === "Enter" && sendMessage());
document.getElementById("overlayLoginPass").addEventListener("keypress", e => e.key === "Enter" && doLogin());

// Auto-logowanie przy odświeżeniu
window.addEventListener("load", () => {
    const saved = localStorage.getItem("user");
    if (saved) {
        currentUser = JSON.parse(saved);
        document.getElementById("authOverlay").style.display = "none";
        loadNotes(currentUser.id);
        loadBoard();
        pollMessages();
        updateUI();
    }
});