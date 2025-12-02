# CzatoNotatnik
    CzatoNotatnik :sunglasses:
    # 🧑‍🏫 Klasa online

---

### Co się dzieje w aplikacji?

- tablica, do której ma dostęp **tylko** nauczyciel, 
- notatkę ucznia można zapisać,
- wiadomości na czacie grupowym może pisać **każdy**, jednak znikają one po jakimś czasie,


---

## ⚙️ Technologie

- PHP 8 (REST API)
- MySQL 5.7
- Bootstrap 5
- JavaScript
- HTML
- CSS

---

## 🚀 Uruchomienie

1. Sklonuj repozytorium lub pobierz ZIP.
2. Utwórz bazę danych `klasa` i zaimportuj plik `schema.sql`.
3. Skonfiguruj połączenie w `api/db.php`.
4. Uruchom serwer (np. XAMPP) i otwórz `http://localhost/klasa`.

---
## Bezpieczeństwo aplikacji

~ wiadomości na czacie są przechowywane prze 24h,

~ hasło użytkownika jest szyfrowane,

~ nauczyciel i uczeń mają inne udogodnienia,

~ notatki są prywatnie przechowywane.


---

## 📡 Endpointy API

| Endpoint | Metoda | Opis | Dane wejściowe | Dane wyjściowe |
|-----------|--------|------|----------------|----------------|
| `/messages?last_id=X` | GET | Pobiera nowe wiadomości | `last_id` | `[ {id, name, text, created_at} ]` |
| `/messages` | POST | Dodaje nową wiadomość | `{text}` | `{success: true}` |
| `/board` | GET | Odczyt tablicy nauczyciela | – | `{content}` |
| `/board` | POST | Zapis tablicy  | `{content}` | `{success: true}` |
| `/notes` | GET | Odczyt prywatnych notatek | – | `{content}` |
| `/notes` | POST | Zapis notatek | `{content}` | `{success: true}` |

---

## Działania aplikacji

### Na dzień 12.11.2025

- uczeń nie może nic zrobić jesli nie jest zalogowany, jednak jeśli się zaloguje ma moliwość zobaczenia osób obecnie zalogowanych, może wysyłać wiadomoći na czacie oraz ma możliwość zapisu notatki(jeszcze nie w bazie), nie ma możliwości używania tablicy nauczyciela,
- logowanie działa i zapisuje login i hasło w bazie, po zalogowaniu jest możliwe się wylogować oraz obaczyć innych uczestników z rolami,

### Na dzień 25.11.2025

- odrazu po wejściu się uczeń/nauczyciel musi się zalogować, bo inaczej nie może używać chatonotatnika.
- Po zalogowaniu wyświetla się imie osoby zalogowanej oraz ranga jaką ma (uczeń/nauczyciel). Można też zauważyć wiadomości na czacie które są już jakis czas
- Aplikacja radzi sobie bardzo dobrze gdy nie jest zminimalizowana,
- Jako uczeń nie ma się dostępu do tablicy.
- Notatki zrobione na lekcji się zapisują i mozna je edytować,
- tablica moze byc zapisywana tylko przez nauczyciela,
- wiadomoci na czacie się skrolują.

### Na dzień 26.11.2025 

- wiadomości na czacie są przez godzinę i pozniej znikają,
 
---

## 👥 Autorzy

- **Programista Frontend:** Olivier 
- **UX/UI Desinger:** Jakub  
- **Programista Backend:** Mikołaj 
- **Tester / Dokumentalista:** Dominika
