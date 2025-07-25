# 🌱 Uh Luhmil Pakal de Oxkutzcab

Sistema web de gestión interna para la agrupación de productores agrícolas "Uh Luhmil Pakal" de Oxkutzcab. Esta plataforma permite la administración de contenidos del sitio institucional, registro de proveedores, gestión de usuarios y edición de secciones clave como el "Quiénes Somos", logo y página de inicio.

---

## 🚀 Tecnologías utilizadas

- **PHP 8+**
- **Laravel 12**
- **MySQL**
- **Blade (motor de plantillas)**
- **AdminLTE** (para el panel administrativo)
- **Bootstrap 4**
- **JavaScript / jQuery**
- **Leaflet.js** (para mapas)
- **Git** y **GitHub**

---

## ⚙️ Instalación

1. Clona el repositorio:

```bash
git clone https://github.com/AdrianJMC/Uh-Luhmil-Pakal-de-Oxkutzcab.git
cd Uh-Luhmil-Pakal-de-Oxkutzcab
```

2. Instala las dependencias de PHP:

```bash
composer install
```

3. Copiá el archivo de entorno y configuralo:

```bash
cp .env.example .env
```

4. Generá la clave de la app:

```bash
php artisan key:generate
```

5. Migrá la base de datos (si tenés las migraciones):

```bash
php artisan migrate
```

6. Ejecutá el servidor de desarrollo:

```bash
php artisan serve
```

---

## 🔐 Acceso al panel administrativo

Una vez iniciado el servidor, ingresá a:

```
http://localhost:8000/admin
```

> ⚠️ Las credenciales se crean manualmente por ahora o mediante seeders si se agregan.

---

## 📦 Funcionalidades principales

- 🖼️ Gestión de secciones web: logo, slider, misión, visión
- 📄 Edición de páginas dinámicas desde el panel admin
- 👥 Gestión de usuarios con roles y permisos
- 🧾 Registro de proveedores mediante formulario público
- 🗺️ Visualización de campos productivos en mapa (Leaflet)
- ✏️ Modales personalizados para creación/edición rápida
- 🎨 Interfaz limpia y responsive

---

## 🤝 Créditos

Desarrollado como parte de un proyecto académico para apoyar la transformación digital de los productores de Oxkutzcab, Yucatán.

---

## 🛡️ Licencia

Este proyecto es de uso interno y académico. Si deseas reutilizarlo o adaptarlo para otro fin, por favor contacta a los desarrolladores.
