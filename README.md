# Registro y Exportación de Leads

Este proyecto implementa un formulario de registro con AJAX, utiliza un endpoint para obtener la IP del usuario, y cuenta con un enlace en la página de inicio para descargar los leads registrados en formato CSV. Además, utiliza el plugin **Secure Custom Fields (SCF)** para manejar campos personalizados.

## Recursos utilizados

1. **Wordpress 6.6.2**:
2. **Secure Custom Fields**
3. **Obtención de la IP del usuario**:
   - Un endpoint que obtiene la dirección IP del visitante utilizando `https://api.ipify.org?format=json` y expone como JSON la información.
3. **Descarga de leads en CSV**:
   - Hay un enlace en la página de inicio que permite descargar un archivo con todos los registros en formato CSV.
4. **Base de datos**
   - Al clonar este proyecto se debe importar la base de datos encontrada en la carpeta `db` en la raíz del proyecto.
