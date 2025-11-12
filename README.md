# CzatoNotatnik
    CzatoNotatnik :sunglasses:
    # 🧑‍🏫 Klasa online

---

### Co się dzieje w aplikacji?

- tablica, do której ma dostęp **tylko** nauczyciel, a którą uczeń może zapisać w formacie PDF
- notatkę ucznia można zapisać oraz pobrać w formacie `.txt`
- wiadomości na czacie grupowym może pisać **każdy**, jednak znikają one po 24h
- po zalogowaniu masz możliwość zobaczenia, jakie osoby są obecnie zalogowane w klasie oraz jaką mają rolę (czy są nauczycielem, czy uczniem)


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

~ nauczyciel i uczeń mają inne udogodnienia.


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

## 🧪 Testy

| Test | Co sprawdzić | Oczekiwany wynik | czy się udało |
|------|---------------|------------------|--------------|
| Logowanie | Jan / 1234 | Zalogowanie jako nauczyciel/uczeń | **udane**|
| Wysyłanie wiadomości | Napisz tekst i Enter | Wiadomość pojawia się w czacie i znika po 24h | **jeszcze nie udane**|
| Edycja tablicy | Belfer zapisuje tablicę | Widoczna dla uczniów |
| Notatki | Uczeń zapisuje treść | Zachowuje się po odświeżeniu |

---

## Działania aplikacji

### Na dzień 12.11.2025

- uczeń nie może nic zrobić jesli nie jest zalogowany, jednak jeśli się zaloguje ma moliwość zobaczenia osób obecnie zalogowanych, może wysyłać wiadomoći na czacie oraz ma możliwość zapisu notatki(jeszcze nie w bazie), nie ma możliwości używania tablicy nauczyciela,
- logowanie działa i zapisuje login i hasło w bazie, po zalogowaniu jest możliwe się wylogować oraz obaczyć innych uczestników z rolami,
  

---

## 👥 Autorzy

- **Programista Frontend:** Olivier 
- **UX/UI Desinger:** Jakub  
- **Programista Backend:** Mikołaj 
- **Tester / Dokumentalista:** Dominika
