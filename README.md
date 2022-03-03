# TEST: Project Management Software

## Requirements

* at least PHP 8.0
* Apache / Nginx

## Usage

1. Copy `config/config.ini.di``st` file as `config.ini` and modify necessary data.
2. Run `composer install`.
3. For test result just run `src/Controller/App.php` with PHP (e.g.: `/usr/bin/php /path/to/src/Controller/App.php`).

## Task
``
**Screenshots and SQL database under `ticket` directory.**

A feladat egy egyszerű projektkezelő rendszer készítése. A feladat elkészítése során a szükséges nyelv a PHP, azon belül is csak a támogatott verziók használhatók. A feladat elkészítéséhez használhatsz
Bootstrap-et, Semantic-ot vagy akármilyen CSS framework-öt, de PHP framework-öt (Laravel, Lumen, Symfony, Slim, Zend, stb.) nem. A JS résznél engedélyezve van a nyelvi libek használata (jQuery,
MooJS, stb.).

A feladat visszaküldését tömörített állományként várjuk vissza. A feladat mellé kaptál egy MySQL file-t is.

Megkérnénk, hogy a feladathoz tartozó adatokat oda ments le, de ha saját struktúrát használsz, akkor ezt jelezd, mikor visszaküldöd a feladatot.

A feladatot két megjelenítésre bontsd szét.

* Projektlista (kezdőképernyő).
    * Projektek listázása, a listában a következő adatok megjelenítése:
        * Név.
        * Státusz.
        * Kapcsolattartó.
        * Szerkesztés illetve törlés gomb
* Projekt űrlap (Projekt megjelenítése).
    * A projekt adatainak szerkesztése (név, leírás, státusz).
    * Kapcsolattartók szerkesztése.

#### Feladat:

 * Projektek létrehozása.
   * A projekteket lehessen listázni, létrehozni, szerkeszteni, törölni.
   * Egy projekt rendelkezzen névvel, leírással és státusszal. Minden adat megadása kötelező.
   * A státusz lehet "fejlesztésre vár", "folyamatban", illetve "kész" (a státuszok bővítési lehetősége nem szükséges).

 * A projektekhez lehessen kapcsolattartókat felvenni.
   * Egy kapcsolattartó rendelkezzen névvel és e-mail címmel.
   * Egy feladat elég ha egy kapcsolathoz tartozik.
   * A kapcsolattartót ki lehessen cserélni másik kapcsolattartóval.
   * A projekt kötelező, hogy rendelkezzen kapcsolattartóval.

#### Extra:

Ezeket nem kötelező elkészíteni, csak extraként vannak a feladatban.

* Legalább a törlés funkció aszinkron módon, az oldal újratöltése nélkül történjen.
* 10 projekt jelenjen meg egy oldalon, afeletti projektszám esetén lapozó legyen.
* A projekteket lehessen státusz szerint szűrni.
* A rendszer egy projekt módosításakor küldjön automatikus e-mailt a projekthez tartozó kapcsolattartó számára, amelyben szerepelnek a megváltozott adatok (de csak azok).
* Ha a feladatot publikus GitHub Repository linkként küldöd vissza.
