# Requerimientos do sistema

- [Requerimientos do sistema](#requerimientos-do-sistema)
  - [1- Descrición Xeral](#1--descrición-xeral)
  - [2- Funcionalidades](#2--funcionalidades)
  - [3- Tipos de usuarios](#3--tipos-de-usuarios)
  - [4- Contorno operacional](#4--contorno-operacional)
  - [5- Normativa](#5--normativa)
  - [6- Melloras futuras](#6--melloras-futuras)

> *EXPLICACION*: Este documento describe os requirimentos para "nome do proxecto" especificando que funcionalidade ofrecerá e de que xeito.

## 1- Descrición Xeral

ProHive é unha plataforma de búsqueda de empresas, autónomos ou asesores co fin de que te realicen un servicio/traballo. O fin deste sería que poidas encontrar á persoa ou grupo de persoas que poidan satisfacer as túas necesidades de forma rápida e sencilla, adaptándose a case calquera tipo de ámbito, posto que queremos contar traballadores da maioría de áreas (como son carpinteiros, pintores, arquitectos, programadores web, diseñadores gráficos, e todo o que se te poida ocurrir).

## 2- Funcionalidades

| Acción   |  Descrición        |
|----------|--------------------|
| Alta de usuarios | Dar de alta aos usuarios na base de datos mediante un formulario cos seguintes datos: nombre, apellidos, email, contraseña (cun campo de confirmar contraseña á hora de rexistrar ao usuario) |
| Modificar usuarios | Modificación de usuarios na base de datos|
| Alta de empresas | Dar de alta ás empresas/autónomos/asesores na base de datos mediante un formulario. Este formulario contaría cos seguintes datos: nome, propietario, localización. |
| Modificar empresas | Modificación de empresas/autónomos/asesores na base de datos|
| Alta de servizos | Dar de alta aos servizos que as empresas ofrecen na base de datos. Esto sería mediante os seguintes datos: título, descripción, prezo, imaxe, id_empresa |
| Mostrar servizos | Mostra os servizos na páxina principal. |
| Mostrar perfil de empresa | Mostra o perfil da empresa seleccionada. |
| Mostrar perfil de usuario | Mostra o teu perfil de usuario (os usuarios soamente poden ver o seu propio perfil, debido a que non aporta nada ver o perfil doutro usuario). |

## 3- Tipos de usuarios

- Usuario cliente: sería o propietario dalgunha/s empresa/s, o cal sería o encargado de realizar os anuncios de servizos e algunha sección máis na/s súa/s empresa/s.
- Usuario común: terá acceso ao seu perfil e aos anuncios das empresas da páxina. Poderá contactar con elas.
- Usuario anónimo: soamente terá acceso aos anuncios das empresas da páxina. Non poderá contactar con elas.
- Usuario administrador: sería o administrador da plataforma. Encargaríase de administrar aos usuarios e empresas. Terá total acceso á plataforma.

## 4- Contorno operacional

Para o uso da páxina web, soamente fará falta un dispositivo de calquera tipo con conexión a internet e un navegador web.

## 5- Normativa

> *EXPLICACION* Investigarase que normativa vixente afecta ao desenvolvemento do proxecto e de que maneira. O proxecto debe adaptarse ás esixencias legais dos territorios onde vai operar.
> 
> Pola natureza dos sistema de información, unha lei que se vai a ter que mencionar de forma obrigatoria é la [Ley Orgánica 3/2018, de 5 de diciembre, de Protección de Datos Personales y garantía de los derechos digitales (LOPDPGDD)](https://www.boe.es/buscar/act.php?id=BOE-A-2018-16673). O ámbito da LOPDPGDD é nacional. Se a aplicación está pensada para operar a nivel europeo, tamén se debe facer referencia á [General Data Protection Regulation (GDPR)](https://eur-lex.europa.eu/eli/reg/2016/679/oj). Na documentación debe afirmarse que o proxecto cumpre coa normativa vixente.
>
> Para cumplir a LOPDPGDD e/ou GDPR debe ter un apartado na web onde se indique quen é a persoa responsable do tratamento dos datos e para que fins se van utilizar. Habitualmente esta información estructúrase nos seguintes apartados:
>
> - Aviso legal.
> - Política de privacidade.
> - Política de cookies.
>
> É acosenllable ver [exemplos de webs](https://www.spotify.com/es/legal/privacy-policy/) que conteñan textos legais referenciando a LOPDPGDD ou GDPR.

## 6- Melloras futuras

> *EXPLICACION* É posible que o noso proxecto se centre en resolver un problema concreto que se poderá ampliar no futuro con novas funcionalidades, novas interfaces, etc.

[**<-Anterior**](../../README.md)
