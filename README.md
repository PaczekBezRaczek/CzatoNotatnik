# CzatoNotatnik
    CzatoNotatnik :sunglasses:
    # 🧑‍🏫 Klasa online

Prosta aplikacja webowa do nauki zdalnej – umożliwia:
- wspólny czat dla wszystkich uczestników lekcji,
- prywatne notatki dla każdego ucznia,
- tablicę tekstową edytowaną tylko przez nauczyciela.

---

## ⚙️ Technologie

- PHP 8 (REST API)
- MySQL 5.7
- Bootstrap 5
- JavaScript (fetch, polling)

---

## 🚀 Uruchomienie

1. Sklonuj repozytorium lub pobierz ZIP.
2. Utwórz bazę danych `klasa` i zaimportuj plik `schema.sql`.
3. Skonfiguruj połączenie w `api/db.php`.
4. Uruchom serwer (np. XAMPP) i otwórz `http://localhost/klasa`.

---

## 📡 Endpointy API

| Endpoint | Metoda | Opis | Dane wejściowe | Dane wyjściowe |
|-----------|--------|------|----------------|----------------|
| `/messages?last_id=X` | GET | Pobiera nowe wiadomości | `last_id` | `[ {id, name, text, created_at} ]` |
| `/messages` | POST | Dodaje nową wiadomość | `{text}` | `{success: true}` |
| `/board` | GET | Odczyt tablicy nauczyciela | – | `{content}` |
| `/board` | POST | Zapis tablicy (tylko teacher) | `{content}` | `{success: true}` |
| `/notes` | GET | Odczyt prywatnych notatek | – | `{content}` |
| `/notes` | POST | Zapis notatek | `{content}` | `{success: true}` |

---

## 🧪 Testy

| Test | Co sprawdzić | Oczekiwany wynik |
|------|---------------|------------------|
| Logowanie | Jan / 1234 | Zalogowanie jako nauczyciel |
| Wysyłanie wiadomości | Napisz tekst i Enter | Wiadomość pojawia się w czacie |
| Edycja tablicy | Belfer zapisuje tablicę | Widoczna dla uczniów |
| Notatki | Uczeń zapisuje treść | Zachowuje się po odświeżeniu |

---

## 👥 Autorzy

- **Programista Frontend:** [Oliwier]  
- **UX/UI Desinger:** [Jakub]  
- **Programista Backend:** [Mikołaj]  
- **Tester / Dokumentalista:** [Dominika]
