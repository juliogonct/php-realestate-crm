# 🏠 Proyecto Inmobiliaria: Creación e Integración de Sitio Web y CRM

Plataforma integral para potenciar la presencia online y la gestión interna de una inmobiliaria. El proyecto combina un sitio web público para la búsqueda y visualización de inmuebles con un CRM interno para la administración de propiedades, clientes y colaboradores.

---

> ⚠️ **Estado del Proyecto: Funcional pero no apto para producción**
>
> Este sistema es completamente funcional en entorno local y ha sido diseñado como una base sólida para un entorno real. Sin embargo, **no incluye aún medidas de seguridad avanzadas ni un entorno de despliegue seguro**, por lo que **no se recomienda su uso en producción sin modificaciones y refuerzos adicionales**.
>

---

## 🚀 Descripción del Proyecto

El sistema se divide en dos componentes principales:

- **Sitio Web Inmobiliario:**  
  Permite a los usuarios explorar, buscar y obtener información detallada sobre inmuebles. Con funciones avanzadas de filtrado y visualización, el sitio ofrece una experiencia intuitiva para clientes potenciales.

- **CRM (Customer Relationship Management):**  
  Herramienta interna diseñada para la gestión eficiente de inmuebles, clientes y colaboradores. Facilita la creación, edición y seguimiento de fichas, optimizando la organización y la comunicación dentro de la inmobiliaria.

---

## 🎯 Objetivos

- **Mejorar la presencia online:**  
  Atraer clientes potenciales mediante un sitio web atractivo y funcional.

- **Optimizar la gestión interna:**  
  Centralizar la administración de inmuebles, clientes y colaboradores en un sistema CRM integrado.

- **Facilitar la toma de decisiones:**  
  Proveer información consolidada y herramientas de análisis que mejoren la eficiencia operativa y la atención al cliente.

---

## 🧰 Tecnologías Utilizadas

- **Backend:** PHP  
- **Frontend:** HTML, CSS, JavaScript, jQuery, Font Awesome  
- **Base de Datos:** MySQL  
- **Servidor:** Apache (XAMPP en entorno de desarrollo)  
- **Otras Tecnologías:** AJAX, JSON para intercambio de datos

---

## 🗂️ Estructura del Proyecto

```
/crm                    # Sistema CRM (gestión interna)
├── includes/           # Funciones compartidas y conexión a BD
├── src/                # Lógica funcional del CRM
│ ├── inicio/           # Dashboard del sistema
│ ├── inmuebles/        # Gestión de inmuebles (insertar, listar, editar, eliminar)
│ ├── clientes/         # Alta y gestión de clientes
│ └── colaboradores/    # Alta y gestión de colaboradores
└── templates/          # Plantillas HTML comunes del CRM

/web                    # Sitio web público (clientes)
├── src/                # Código del sitio público
├── templates/          # Plantillas visuales (navegación, footer)
└── assets/             # Estilos, JS, imágenes generales

/shared                 # Funcionalidades compartidas y login al CRM
├── includes/           # Conexión BD para visitantes/contacto
└── images/             # Iconos y recursos visuales compartidos

/data                   # Almacenamiento y control interno
```

---

## 🧩 Funcionalidades Destacadas

### 🌐 Sitio Web Inmobiliario

- **Búsqueda y Filtrado Avanzado**  
- **Visualización Detallada de Inmuebles**  
- **Diseño Responsivo**

### 👥 CRM Inmobiliario

- **Gestión Completa de Inmuebles, Clientes y Colaboradores**  
- **Seguimiento de Interacciones y Contactos**  
- **Manejo de Imágenes y Mapa de Ubicación**  
- **Autenticación básica con restricción IP y generación de contraseñas**

---

## 🛠️ Manual de Instalación

1. Instalar XAMPP  
2. Configurar e iniciar Apache y MySQL  
3. Importar base de datos `inmobiliaria.sql` en phpMyAdmin  
4. Configurar archivos de conexión en `/includes`  
5. Acceder vía navegador a: `http://localhost/tu_proyecto/web/src/index.php`

---

## 💡 Mejoras Futuras

- Implementación de HTTPS y cifrado de contraseñas  
- Autenticación robusta con roles y MFA  
- Refactor de base de datos y código para escalabilidad  
- Hardening del sistema para entornos reales

---

## 🏁 Conclusión

Este proyecto proporciona una **plataforma funcional y estructurada**, útil para pruebas, desarrollos posteriores o como base de referencia para sistemas inmobiliarios. Sin embargo, es importante recalcar que **no está preparado para su uso en producción** sin aplicar mejoras en seguridad, rendimiento y mantenimiento.

---

> Desarrollado por Julio Gonzalez Muñiz, 2024

