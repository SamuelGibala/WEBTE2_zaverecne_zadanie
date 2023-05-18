# Semestrálne zadanie WEBTECH2

Github semestrálneho zadania predmetu Webové technológie 2 na FEI STU. Úlohou zadania bolo naprogramovať aplikáciu pre generovanie a vypracovávanie matematických úloh.

## Spustenie docker

1. Rozbaliť .zip súbor
2. docker-compose up --build

## Použitie

Pre testovanie prihlásenia bol vytvorený používateľ pre každú rolu. Ich údaje sú popísané v nasledujúcej tabulke:
| **id** | **name** | **surname** | **password** | **email** | **role** |
|----|--------|---------|----------|----------|----------|
| 27 | Peter | Novák | 123456 | xucitel@stuba.sk | teacher |
| 33 | Peter | Nový | 123456 | xstudent@stuba.sk | student |

Každá rola má možnosť pristupovať len k ich na to určenej časti aplikácie.

### Validácia API

Beží na adrese https://site93.webte.fei.stuba.sk:9001/ na základe [FastAPI](https://fastapi.tiangolo.com/) kniznice pre python. Default dokumentácia API je k dispozícii na adrese: https://site93.webte.fei.stuba.sk:9001/docs

Adresa z root:

```bash
cd /var/www/site93.webte.fei.stuba.sk/fastapi/
```

Táto api automaticky parsuje latex výrazy, ktoré na vstupe očakáva. Po spracovaní vstupov je vrátená hodnota 1/0 podľa správnosti prijatého výsledku a správneho výsledku.

Príklad requestu:

```http
POST /compare HTTP/1.1
Host: https://site93.webte.fei.stuba.sk:9001/porovnaj2
Content-Type: application/json

{
  "expr1": "\frac{4x}{2}",
  "expr2": "\frac{2x}{1}"
}
```

## Vypracovali

- Samuel Gibala
- Matúš Kornhauser
- Viktor Bojda
- Rudolf Bezák

### Rozdelenie úloh:

- [x] dvojjazyčnosť - Viktor
- [x] prihlasovanie sa do aplikácie (študent, učiteľ) - Samo/Matúš
- [x] GUI a funkcionalita študenta (vrátane matematického editora) - Matúš
- [x] GUI a funkcionalita učiteľa - Samo
- [x] kontrola správnosti výsledku - Samo/Matúš
- [x] export do csv a pdf - Viktor
- [x] docker balíček - Rudolf
- [x] nainštalovanie dockera na server - Rudolf
- [x] používanie verzionovacieho systému všetkými členmi tímu - všetci
- [x] finalizácia aplikácie - všetci (nemusí byť rovnomerne rozdelené)
- [x] video - Samo, Matúš (viac Matúš)

## Funkcionalita vo forme videa

link: https://www.youtube.com/watch?v=3mT35zTjsXY&ab_channel=Mat%C3%BA%C5%A1Kornhauser
