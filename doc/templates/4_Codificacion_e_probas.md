# FASE DE CODIFICACIÓN E PROBAS

- [FASE DE CODIFICACIÓN E PROBAS](#fase-de-codificación-e-probas)
  - [1- Codificación](#1--codificación)
  - [2- Prototipos](#2--prototipos)
  - [3- Innovación](#3--innovación)
  - [4- Probas](#4--probas)

## 1- Codificación

[Directorio do código](../../codigo)

## 2- Prototipos

Podes ver o prototipo facendo click [aquí](https://www.figma.com/design/YkZ0R1c2W19m5aeZLIEK6e/ProHive?node-id=75-685)

## 3- Innovación

- Emprego a librería AOS, a cal non ten unha maior complicación que colocar unha clase concreta aos elementos que necesite que sexa afectado, polo que me funcionou á primeira.
- Tamén emprego a librería 'vlucas/phpdotenv', de PHP, a cal foi un auténtico reto que funcionase, debido a que a ruta do archivo daba problemas á hora de intentar obter o seu contido, tanto na api como no MVC. A solución foi a base de proba a error.

## 4- Probas

- Varios problemas que tiven foron coa creación da api, posto que ao principio non era capaz de devolver un JSON o cal tivese algún texto con til, pero despois de moitas probas, tiven que recurrir a facer unha función que sanitice os textos mediante a codificación UTF-8, xa que por algún motivo nin sequera funcionaba nin cun head con html.

- Outros problemas que tiven foi á hora de crear os chats, xa que á hora de facer que os mensaxes tivesen scroll propio, non era capaz de que o scroll aparecese na parte de abaixo dos mensaxes. A solución foi engadir a seguinte línea de código no JS: $mensajes.scrollTop = $mensajes.scrollHeight;


[**<-Anterior**](../../README.md)
