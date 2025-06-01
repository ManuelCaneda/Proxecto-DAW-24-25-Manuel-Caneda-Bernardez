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

- Probouse a facer login nun navegador e ir páxina por páxina copiando a url e pegándoa en outro navegador para comprobar que non te deixaba entrar nelas.
- Fíxose o mesmo ao revés, para comprobar que os usuarios que xa estaban con login feito non podían acceder á landing page nin ás páxinas de login nin rexistro.
- Probouse a iniciar sesión desde dous navegadores en distintos usuarios para mandarse mensaxes entre eles e comprobar que os chats que aparecían fosen os correctos e que os mensaxes se iban actualizando a tempo real.
- Probouse toda a zona de administración, comprobando que os usuarios e anuncios podían editarse, e que tanto os usuarios, anuncios e valoracións se eliminaban, ademáis de comprobar que o administrador podía falar desde ahí cos usuarios.
- Fixéronse todas as probas dos formularios, como comprobar que as contraseñas coinciden á hora de rexistrarse, que os correos son válidos e que non existe xa un usuario con ese correo, que os contidos dos mensaxes no sistema de mensaxería non poden ser vacíos...
- Encontreime con varios problemas á hora de crear o sistema de mensaxería, o máis difícil de resolver foi que os mensaxes aparecesen co scroll feito hacia abaixo, solucionouse engadindo a seguinte línea de código no JS: $mensajes.scrollTop = $mensajes.scrollHeight;. Tamén á hora de obter os mensaxes entre dous usuarios, o cal se resolveu mediante á creación dunha url na api que sería "/api/mensajes/conversacion/id1/id2".

[**<-Anterior**](../../README.md)
