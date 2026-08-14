# Karaoke Software Licenses & Reseller System

[![PHP Version](https://img.shields.io/badge/PHP-5.2%20--%208.3%20Compatible-blue.svg)](https://www.php.net/)

> 🕰️ **Software Histórico:** Repositorio que preserva el código fuente original de la plataforma web de comercialización, licenciamiento offline (Keygen) y gestión de distribuidores para el software comercial *Karaoke LatinMusic* (Ecuador, 2008–2010).

---

## 📖 Contexto Histórico

Desarrollado en la época previa a Composer y a los frameworks modernos de PHP (era *spaghetti/procedural*), este sistema resolvía de manera autónoma el ciclo comercial de un software de karaoke de escritorio para Windows:

1. **Licenciamiento Algorítmico (Keygen)**: Transformación criptográfica/aritmética de identificadores de hardware (*Hardware ID* o código de máquina) en claves de activación definitivas mediante la función `generateCode()`.
2. **Red de Revendedores (Sellers)**: Control de saldo de licencias asignadas, consumidas y registros de clientes finales por distribuidor.
3. **Generador de Sitios Marca Blanca**: Herramienta administrativa para clonar físicamente la estructura web y desplegar instancias personalizadas para terceros (`paths/` ➔ `marks/`).
4. **Mensajería Interna**: Formulario de contacto y soporte integrado sin dependencias externas.

---

## ⚡ Capa de Compatibilidad Moderna (`mysql.shim.php`)

Para permitir la ejecución inmediata en entornos de desarrollo modernos (**PHP 7.x y PHP 8.x**) sin requerir un servidor MySQL/MariaDB externo ni extensiones obsoletas, el proyecto incluye un **emulador SQLite transparente**:

- Emula de forma nativa las funciones eliminadas `mysql_connect`, `mysql_query`, `mysql_fetch_object`, `mysql_result`, etc.
- Auto-crea el esquema de tablas y puebla los datos iniciales (*seed data*) en `docs/klm.sqlite` en el primer arranque.
- **Zero-Configuration**: No es necesario encender XAMPP, Docker ni configurar credenciales de bases de datos.

---

## 🚀 Inicio Rápido

### 1. Clonar el repositorio
```bash
git clone https://github.com/okzgn/karaoke-software-licenses-system-2010-php.git
cd karaoke-software-licenses-system-2010-php
```

### 2. Iniciar el servidor local de PHP
```bash
php -S localhost:8000
```

### 3. Abrir en tu navegador
* **Landing Page:** [http://localhost:8000](http://localhost:8000)
* **Portal de Acceso:** [http://localhost:8000/access.php](http://localhost:8000/access.php)

---

## 🔑 Credenciales de Prueba

| Rol | Método de Acceso | Usuario / Parámetro | Contraseña |
| :--- | :--- | :--- | :--- |
| **Administrador** | *Acceso Especial Bypass* | URL: `access.php?special=adminBypass` | `1234567890` |
| **Vendedor 1** | Formulario Estándar | `juanp` | `password123` |
| **Vendedor 2** | Formulario Estándar | `carlosm` | `password123` |

---

## 📂 Estructura del Proyecto

```text
├── access.php             # Panel de Control (Admin) y Gestión de Claves (Vendedores)
├── alq.php                # Página informativa de alquiler de equipos
├── analize.php            # Controlador de autenticación y sesiones
├── ARCHIVO_VARIABLE.php   # Configuración global, textos y bypass keys
├── buy.php                # Información de compra y métodos de pago
├── contact.php            # Formulario de contacto y mensajería
├── data/                  # Assets estáticos (custom UI, jQuery 1.7.1, CSS Reset [2007])
├── docs/                  # Almacenamiento local de base de datos SQLite (klm.sqlite)
├── index.php              # Landing page comercial principal
├── inside.php             # Núcleo de funciones comunes, sesión y algoritmo de clave
├── logout.php             # Cierre de sesión
├── marks/                 # Directorio destino para marcas blancas generadas
├── mysql.shim.php         # Capa puente de emulación MySQL -> SQLite
├── paths/                 # Plantillas base para la clonación de sitios marca blanca
└── req.php                # Endpoints AJAX (modificación de licencias, usuarios, etc.)
```

---

## 🧮 Algoritmo de Generación de Claves (Keygen)

El algoritmo de activación residencial toma el código del computador (`firstCode`), invierte sus caracteres, sustituye dígitos hexadecimales y realiza permutaciones de posición para calcular la clave final:

```php
function generateCode($firstCode){
    $firstCode = str_split($firstCode);
    $firstCode = array_reverse($firstCode);

    for($i = 0, $newCode = array(); $i < count($firstCode); $i++){
        $char = strtolower($firstCode[$i]);
        switch($char){
            case 'a': $char = '10'; break;
            case 'b': $char = '11'; break;
            case 'c': $char = '12'; break;
            case 'd': $char = '13'; break;
            case 'e': $char = '14'; break;
            case 'f': $char = '15'; break;
        }
        array_push($newCode, $char);
    }

    $newCode = implode("", $newCode);

    $secondCode  = substr($newCode, 0, 1);
    $secondCode .= substr($newCode, strlen($newCode) - 2, 1);
    $secondCode .= substr($newCode, 1, 1);
    $secondCode .= substr($newCode, strlen($newCode) - 3, 1);
    $secondCode .= substr($newCode, 2, 1);
    $secondCode .= substr($newCode, strlen($newCode) - 4, 1);
    $secondCode .= substr($newCode, 3, 1);
    $secondCode .= substr($newCode, strlen($newCode) - 5, 1);
    $secondCode .= substr($newCode, 4, 1);

    return dechex($secondCode);
}
```

---

## Licencia

Desarrollado por Elías Alvarado Soshina (2008–2010), actualmente [OKZGN](https://okzgn.com).
