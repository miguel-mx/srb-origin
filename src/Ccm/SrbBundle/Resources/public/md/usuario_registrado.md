Sistema de Rerencias Bibliográficas SRB
=======================================

### Centro de Ciencias Matemáticas UNAM-Morelia

[Página anterior](index.md)

## Introducción Administración de Referencias

A continuación se describen las funcionalidades del Sistema de Referencias Bibliográficas como **usuario registrado**.

Será necesario ingresar al sistema con usuario y password.

El administrador del sistema deberá haber creado la cuenta de usuario y el autor institucional asociado a ésta cuenta de usuario.

### 1.- Pantalla de Inicio

La pantalla de inicio cambiará al iniciar una nueva sesión con usuario y contraseña.

* Barra izquierda, menú.
    * Nueva publicación
    * Búsqueda avanzada
    * Información de la sesión de usuario
    * Opción de cerrar la sesión **Logout**

#### 1.1 Nueva referencia bibliográfica

Con una sesión abierta tendremos la opción de crear una nueva referencia bibliográfica. Podremos seleccionar una de
las opciones del menú de la barra izquierda:

* Artículo
* Capítulo de Libro
* Editor de Memorias de Congreso
* Libro
* Memoria de Congreso
* Preprint

Cada tipo de referencia bibliográfica tiene campos obligatorios diferentes. [Ver el documento de inicio](index.md#referencias)

**Al crear una nueva referencia bibliográfica se validará que no exista un registro en el sistema con el mismo título.**

Como usuario del sistema, al crear una nueva referencia seré el propietario de la misma.

Al crear una nueva referencia ésta quedará asociada al autor que tengo asociado como usuario.

**Solamente debería agregar referencias de las que soy autor**.

Como propietario de una referencia yo podré editarla posteriormente.

Como propietario de la referencia podré asociarle a la misma otros autores institucionales.

**Solamente el propietario de una referencia y los administradors podrán cambiar sus autores.**

**Al asociar un autor a una referencia, el usuario del nuevo autor también será propietario de la referencia y podrá modificarla.**

Al crear una nueva referencia su campo de **Revisado** quedará como *pendiente*.

Será necesario que un administrador del sistema revise la nueva referencia y cambie el estatus de la misma a **Revisada**.

Al modificar una referencia el campo de **Revisado** cambiará de nuevo a *pendiente*.


### 2.- Referencias

Las referencias bibliográficas se muestran como una lista en el área de contenido del sistema. Se muestra un resumen de cada referencia
con la información más importante del registro bibliográfico.

Para ver el detalle de la referencia se debe dar click en el título.

El detalle de cada referencia depende de su tipo y de qué campos se hayan llenado cuando se dió de alta, puede incluir:

* Título
* Autores
* Resumen
* Año, volumen, páginas, etc.
* *Doc Type* es el tipo de publicación
* File si existe el archivo de la publicación
* URL de la publicación.
* *Ref id* es el identificador único de la referencia.
* Fechas de creación y modificación
* Estatus de la revisión
* Notas
* Autores institucionales asociados a la referencia

Como propietario de la referencia estarán disponibles las opciones:

* Asociar autores a ésta referencia
* Editar


#### 2.1 Asociar autores

Al dar de alta una nueva referencia, automáticamente se le asocia mi autor institucional.

**Solamente debería agregar referencias de las que yo soy autor**.

Como propietario de una referencia puedo asociar más autores dentro de los detalles de la referencia.

En la página de asociación de autores aparecerá un cuadro de selección múltiple con el catálogo de autores institucionales.

**Para seleccionar múltiples autores es necesario mantener presionada la tecla Ctrl + click del ratón**

Al asociar otro autor a una referencia, el nuevo autor también será propietario de la referencia y podrá editar o modificar la referencia.

Para terminar presionar el botón de *Guardar*. El sistema regresará a la página de detalles de la referencia.


#### 2.2 Editar

Es necesario ser el propietario de una referencia para poder editarla.

Dentro de los detalles de la referencia se encuentra el botón de editar. Al dar click en éste botón se abrirá el formulario correspondiente al tipo de publicación que se esté editando.

Al editar una referencia se validaran los campos como si fuera una referencia nueva.

Un caso especial son los **Preprints**. Al editar un preprint es posible cambiar el tipo de Preprint a cualquier otro tipo de publicación.
Este paso no es reversible.

En ningún otro caso es posible cambiar el tipo de publicación.



