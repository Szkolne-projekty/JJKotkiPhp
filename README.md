# [Projekt kotki](https://kotki.jezyq.ovh/)

Projekt miał polegać na stworzeniu strony internetowej z elementami języka PHP. Wybrałem temat kotki, bo są fajne i słodkie :)

## Zawartość strony

-   [Strona główna](https://kotki.jezyq.ovh/)
-   [Strona z ciekawostkami](https://kotki.jezyq.ovh/facts)
-   [Blog](https://kotki.jezyq.ovh/blog)
    -   [Dodawanie postów](https://kotki.jezyq.ovh/post/create) - wymagane dodatkowe uprawnienia (create_post)
    -   Edytowanie postów (/post/edit/{id}) - wymagane dodatkowe uprawnienia (edit_post)
    -   Usuwanie postów (/post/delete/{id})
-   [Zdjęcia kotków](https://kotki.jezyq.ovh/photos) - wymagane dodatkowe uprawnienia (delete_post)
-   System logowania
    -   [Logowanie](https://kotki.jezyq.ovh/login)
    -   [Rejestracja](https://kotki.jezyq.ovh/register)
    -   [Strona profilu](https://kotki.jezyq.ovh/profile)
    -   System uprawnień bazowany na rolach (Administrator, Redaktor, Użytkownik)

## Uruchamianie

Aby uruchomić stronę należy użyć jakiegokolwiek webservera obsługującego php np. apache. Ja osobiście hostuje w dockerze, do czego można użyć tego [Dockerfile](https://github.com/Szkolne-projekty/JJKotkiPhp/blob/main/Dockerfile). Do obsługi bazy danych należy przekazać dane do instancji MySQL w zmiennych środowiskowych ([.env.example](https://github.com/Szkolne-projekty/JJKotkiPhp/blob/main/.env.example)). Struktura bazy danych: [dbStructure.sql](https://github.com/Szkolne-projekty/JJKotkiPhp/blob/main/dbStructure.sql)

## Użyte technologie

-   [PHP](https://www.php.net/) (dosyć oczywiste)
-   [Apache](https://httpd.apache.org/) (serwer)
-   [tailwindcss](https://tailwindcss.com/) (framework css do prostszego stylowania)
-   [daisyUI](https://daisyui.com/) (biblioteka ui)
-   [Docker](https://www.docker.com/) (konteneryzacja w celu prostszego uruchomienia na produkcji)

## Inne pomoce

-   [Router](https://github.com/phprouter/main)
-   [Parser Markdowna](https://github.com/erusev/parsedown)
-   [Generowanie UUID](https://www.uuidgenerator.net/dev-corner/php)

## Zrzuty ekranu

### Wersja desktopowa

-   Strona początkowa

    ![Landing page](https://raw.githubusercontent.com/Szkolne-projekty/JJKotkiPhp/refs/heads/main/assets/landing.png)

-   Strona blogu

    ![Blog page](https://github.com/Szkolne-projekty/JJKotkiPhp/blob/main/assets/blog_page.png?raw=true)

-   Strona postu z bloga

    ![Blog post page](https://github.com/Szkolne-projekty/JJKotkiPhp/blob/main/assets/post_page.png?raw=true)

-   Tworzenie postu

    ![Create post page](https://github.com/Szkolne-projekty/JJKotkiPhp/blob/main/assets/create_post_page.png?raw=true)

-   Edytowanie postu

    ![Edit post page](https://github.com/Szkolne-projekty/JJKotkiPhp/blob/main/assets/edit_post_page.png?raw=true)

-   Usuwanie postu

    ![Delete post page](https://github.com/Szkolne-projekty/JJKotkiPhp/blob/main/assets/delete_post_page.png?raw=true)

-   Strona z ciekawostkami

    ![Facts page](https://github.com/Szkolne-projekty/JJKotkiPhp/blob/main/assets/facts_page.png?raw=true)

### Wersja mobilna

![Mobile](https://github.com/Szkolne-projekty/JJKotkiPhp/blob/main/assets/mobile/landing.png?raw=true)
