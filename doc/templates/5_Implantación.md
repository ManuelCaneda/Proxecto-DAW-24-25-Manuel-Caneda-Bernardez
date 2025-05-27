# FASE DE IMPLANTACIÓN

- [FASE DE IMPLANTACIÓN](#fase-de-implantación)
  - [1- Manual técnico](#1--manual-técnico)
    - [1.1- Instalación](#11--instalación)
    - [1.2- Administración do sistema](#12--administración-do-sistema)
  - [2- Manual de usuario](#2--manual-de-usuario)
  - [3- Melloras futuras](#3--melloras-futuras)

## 1- Manual técnico

### 1.1- Instalación

Para poñer en funcionamento a plataforma requírese dun dispositivo con un navegador e conexión a internet.

Para o desenvolvemente da aplicación, foi empregado XAMPP como servidor local cos módulos MySQL e Apache. Para instalalo, descargamos a carpeta 'codigo' e 'install', e o metemos na mesma carpeta. Despois disto, iremos á carpeta 'install' e executaremos o arquivo correcto dependendo do noso sistema operativo, este arquivo nos instalará o proxecto en xampp e creará un dominio local.

Para cargar os datos na base de datos, importamos o arquivo 'bd.sql' (na carpeta 'install') no phpMyAdmin da seguinte forma: unha vez dentro da páxina, temos a opción de copiar e pegar o código (na sección de arriba chamada 'SQL') ou importalo directamente na sección de arriba chamada 'Importar'.

Unha vez feito todo, xa podemos abrir o proxecto buscando 'proyecto.local' no noso navegador.

Podemos rexistrar usuarios comúns ou utilizar os dous xa creados (user1@prohive.com, user2@prohive.com). Tamén hai dúas contas de cliente (cliente1@prohive.com, cliente2@prohive.com) e unha de admin (admin@prohive.com).
Todas as contas teñen como contraseña 'abc123.' (sen comiñas).

### 1.2- Administración do sistema

É necesario facer copias de seguridade da base de datos de forma regular, xa que conteñen os anuncios dos clientes e os mensaxes entre usuarios e clientes, e perdelos pode supoñer un problema. Tamén estaría ben facer unha xestión de incidencias, tanto para incidencias de sistema como de fallos no software.
Tamén estaría ben facer unha xestión de usuarios, xa que moitos poderían simplemente facer perder o tempo dos nosos clientes (por exemplo molestando ou mandando mensaxes sen sentido).

## 2- Manual de usuario

Non sería necesario formar ós usuarios debido a que a plataforma é moi intuitiva. De todas formas, na páxina de inicio hai un formulario de contacto na parte de abaixo, que poden utilizar para preguntar o que desexen.

**Uso da plataforma**

O inicio de sesión igual para todos os tipos de clientes, chégase a él a partir da páxina de inicio, no botón do header que pon "INICIAR SESIÓN". Para rexistrarse, os usuarios poden facelo na páxina accedendo ao apartado de rexistro por medio do apartado de login. Os clientes deberán contactar co equipo de ProHive.

- Usuario común: nada máis iniciar sesión verá 5 anuncios destacados, e no header verá unha barra de búsqueda que pode utilizar para buscar o anuncio que desexe. Tamén no header poderá ver dous iconos: unha persona e un icono de chat. No icono de chat poderá acceder as súas conversacións, e na persoa poderá acceder á información da súa conta e editala.
- Usuario cliente: ao iniciar sesión poderá ver os seus anuncios e crear anuncios novos se lle dan ao símbolo '+', tendo a posibilidade tamén de eliminar ou editar os anuncios que xa ten creados, ademáis de poder acceder aos chats e ao seu perfil ao igual que os usuarios comúns.
- Usuario admin: o seu panel consiste de tres botóns: usuarios, anuncios e valoracións. Ao seleccionar un deles, aparecerá unha lista de todos os elementos que seleccione. Se selecciona o usuario, poderá ver o seu ID, nome, apellidos, correo electrónico e poderá contactar con él, editalo ou borralo. No caso dos anuncios, poderá ver tamén o ID, o cliente que o creou, o título do anuncio, o contido e o precio, podendo editalo e borralo. E por último, no caso das valoracións, poderá ver o ID, puntuación, texto e autor, ademáis de poder eliminala.

## 3- Melloras futuras

- Se tes mensaxes sen ler, que apareza no icono do chat a cantidade de chats sen ler.
- Que te notifique se alguén te envía mensaxes.
- Posibilidade de que os usuarios e clientes poidan subir unha imaxe de perfil.
- Sistema de mapas para mostrar a dirección dos clientes mellor.

[**<-Anterior**](../../README.md)
