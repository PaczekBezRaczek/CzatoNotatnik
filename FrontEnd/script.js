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
