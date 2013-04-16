<a id="inicio"></a>
<a href="http://gaspacho.matmor.unam.mx/SRB/">Sistema de Rerencias Bibliográficas SRB</a>
=======================================
### Centro de Ciencias Matemáticas UNAM



[Funcionalidad como usuario anónimo](./doc/usuario_anonimo.md)<br>
[Funcionalidad usuario registrado](./doc/usuario_registrado.md)
  
## Introducción
  

El Sistema de Referencias Bibliográficas se desarrolló con el propósito de tener la posibilidad de acceder de forma centralizada a la producción bibliográfica del Centro de Ciencias Matemáticas UNAM. El formato de las referencias bibliográficas en el sistema está basado en el estándar de BibTex.

**Contenido**

* [Usuarios](#usuarios)
* [Autores](#autores)
* [Búsqueda](#busqueda)
* [Referencias Bibliográficas](#referencias)

## <a id="usuarios"></a>Usuarios

Existen básicamente tres diferentes tipos de usuario del SRB:

* Usuario anónimo
* Usuario registrado
* Administrador

Cada usuario tiene diferentes tipos de Control de Acceso al sistema:

### Como usuario sin registro o anónimo

- Puedo realizar búsquedas en la base de datos bibliográfica.
- Puedo revisar el catálogo de Autores Institucionales.
- Puedo ingresar al sistema con un usuario y contraseña (en caso de tenerlo).

### Como usuario registrado:

- Puedo realizar todas las acciones de un usuario anónimo
- Puedo autenticarme en el sistema con mi usuario y contraseña.
- Puedo agregar nuevas referencias bibliográficas.
- Puedo editar mis referencias bibliográficas.
- Puedo asociar autores a mis referencias bibliográficas.
- Puedo cerrar mi sesión en el sistema.
- En caso de ser un académico debo tener un autor asociado y mis referencias asociadas a éste autor.

### Como administrador del sistema:

- Puedo realizar todas las acciones de los usuarios anónimos y registrados.
- Puedo importar referencias de un archivo BibTex.
- Puedo importar referencias desde ArXiv utilizando sus servicios de web.
- Puedo revisar y validar las referencias ingresadas por los usuarios.
- Puedo crear, modificar, borrar autores.
- Puedo crear, modificar, borrar usuarios.
- Puedo asociar un autor a un usuario.

Un usuario puede estar asociado a un autor, ésta es una relación uno a uno.
No todos los usuarios estan asociados a un autor. Este es el caso de los usuarios Administradores del Sistema.

## <a id="autores"></a>Autores

En el Sistema de Referencias Bibliográficas existe un catálogo de Autores.
Cada autor tendrá asociada uno o más referencias bibliográficas.
Esta relación Autores-Referencias permite ver todas las referencias de un mismo autor.
Dos autores o más pueden estar relacionados con una misma referencia.

## <a id="busqueda"></a>Búsqueda

Existen dos tipos de búsqueda principales:

- Búsqueda rápida: Este es un tipo de busqueda general, utiliza un motor de búsqueda interno.
- Búsqueda avanzada: Esta es una búsqueda directa en la base de datos realizando una consulta.
 
También podemos ver el catálogo de autores y dentro de cada registro de autor existe la opción de ver la referencias asociadas a éste autor.

## <a id="referencias"></a>Referencias Bibliográficas

(se listan los campos obligatorios)

**Artículo (Artículo de Revista)**

* Title
* Author
* Journal
* Year

**Incollection (Capítulo de Libro)**

* Title
* Author
* Book Title
* Publisher
* Year

**Proceedings (Editor de Memorias de Congreso)**

* Title
* Editor
* Publisher
* Year

**Book (Libro)**

* Title
* Publisher
* Year

**Inproceedings (Memoria de Congreso)**

* Title
* Author
* Year

**Preprint**

* Title
* Author
* Year Preprint

**Tesis**

* Title
* Author
* Advisor
* School
* Year


Como usuario registrado con login y password puedo agregar una nueva referencia bibliográfica.
Como usuario soy propietario de las referencias bibliograficas que agregue al sistema.
Como propietario de mis referencias yo puedo editar a las mismas.
Como propietario de mis referencias yo puedo asociarle otros autores a las mismas.
Al asociar otro autor a una referencia, este nuevo autor también será propietario de la referencia.

Si soy usuario registrado y tengo asociado un autor institucional, al crear una nueva referencia bibliográfica ésta quedará asociada a mi autor.

[Volver al inicio de la página](#inicio)

