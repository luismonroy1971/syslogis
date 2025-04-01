# Sistema de Gestión de Inventario de Prótesis

## Estructura del Proyecto MVC

El sistema sigue una arquitectura Modelo-Vista-Controlador (MVC) pura, implementada en PHP sin frameworks externos. La estructura de carpetas está organizada de la siguiente manera:

```
/
├── app/
│   ├── models/         # Lógica de negocio y acceso a datos
│   ├── views/          # Plantillas y componentes de interfaz
│   │   ├── components/ # Componentes reutilizables
│   │   ├── layouts/    # Plantillas base
│   │   └── pages/      # Vistas específicas
│   └── controllers/    # Controladores de la aplicación
├── public/            # Punto de entrada y assets públicos
│   ├── css/
│   │   ├── components/ # Estilos de componentes
│   │   └── pages/      # Estilos específicos de páginas
│   ├── js/
│   │   ├── components/ # JavaScript de componentes
│   │   ├── utils/      # Utilidades y helpers
│   │   └── pages/      # Scripts específicos de páginas
│   └── index.php      # Punto de entrada principal
├── config/           # Configuraciones del sistema
└── core/             # Núcleo del framework MVC
    ├── Database.php   # Clase de conexión a base de datos
    ├── Model.php      # Clase base para modelos
    ├── View.php       # Clase base para vistas
    └── Controller.php # Clase base para controladores
```

## Arquitectura Frontend

### HTML5
- Estructura semántica moderna
- Componentes modulares y reutilizables
- Integración con microdata para SEO

### CSS3
- Arquitectura BEM (Block Element Modifier)
- Sistema de diseño modular y escalable
- Variables CSS para temas y personalización
- Diseño responsivo con Grid y Flexbox

### JavaScript
- Vanilla JavaScript moderno (ES6+)
- Patrón de módulos para mejor organización
- Sistema de eventos personalizado
- Componentes independientes y reutilizables

## Escalabilidad y Mantenimiento

### Modularidad
- Componentes independientes y autocontenidos
- Separación clara de responsabilidades
- Interfaces bien definidas entre módulos

### Extensibilidad
- Arquitectura basada en plugins
- Hooks y eventos para personalización
- Sistema de middleware para controladores

### Mantenibilidad
- Convenciones de código consistentes
- Documentación integrada
- Tests unitarios y de integración

## Proceso de Desarrollo

### Agregar Nuevas Funcionalidades
1. Crear modelo en `app/models/`
2. Implementar controlador en `app/controllers/`
3. Desarrollar vistas en `app/views/pages/`
4. Agregar estilos en `public/css/pages/`
5. Implementar JavaScript en `public/js/pages/`

### Buenas Prácticas
- Nomenclatura consistente
- Documentación de código
- Control de versiones
- Revisión de código
- Testing continuo