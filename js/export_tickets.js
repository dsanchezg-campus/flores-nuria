/**
 * Exportar Tickets - JavaScript
 * Maneja la descarga de tickets en formato JSON
 */

document.addEventListener('DOMContentLoaded', function () {
    const exportBtn = document.getElementById('exportBtn');

    if (!exportBtn) {
        console.error('Botón exportBtn no encontrado');
        return;
    }

    exportBtn.addEventListener('click', handleExportClick);
    exportBtn.addEventListener('mousedown', handleMouseDown);
    exportBtn.addEventListener('mouseup', handleMouseUp);
});

/**
 * Maneja el evento de clic del botón
 */
async function handleExportClick() {
    const exportBtn = document.getElementById('exportBtn');

    // Prevenir múltiples clics
    if (exportBtn.disabled || exportBtn.classList.contains('loading')) {
        return;
    }

    exportBtn.disabled = true;
    exportBtn.classList.add('loading');

    try {
        const response = await fetch(window.location.pathname, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=export_json'
        });

        if (!response.ok) {
            throw new Error('Error al generar el JSON: ' + response.statusText);
        }

        const json = await response.json();

        // Validar que no sea un error
        if (json.error) {
            throw new Error(json.message || 'Error desconocido');
        }

        // Descargar el archivo JSON
        downloadJSON(json);

        // Feedback visual
        showSuccess();

    } catch (error) {
        console.error('Error:', error);
        showError(error.message);
    } finally {
        resetButton();
    }
}

/**
 * Descarga el JSON como archivo
 */
function downloadJSON(data) {
    const dataStr = JSON.stringify(data, null, 2);
    const dataBlob = new Blob([dataStr], { type: 'application/json' });
    const url = URL.createObjectURL(dataBlob);
    const link = document.createElement('a');
    link.href = url;
    link.download = `tickets_${new Date().getTime()}.json`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
}

/**
 * Muestra mensaje de éxito
 */
function showSuccess() {
    const exportBtn = document.getElementById('exportBtn');
    exportBtn.textContent = '✅ ¡Descargado!';
}

/**
 * Muestra mensaje de error
 */
function showError(message) {
    const exportBtn = document.getElementById('exportBtn');
    exportBtn.innerHTML = '<span>❌ Error</span>';
    alert('Error al generar el JSON: ' + message);
}

/**
 * Reinicia el botón
 */
function resetButton() {
    setTimeout(() => {
        const exportBtn = document.getElementById('exportBtn');
        exportBtn.innerHTML = '<span>GENERAR JSON</span><div class="spinner"></div>';
        exportBtn.disabled = false;
        exportBtn.classList.remove('loading');
    }, 2000);
}

/**
 * Efecto visual de presión del botón
 */
function handleMouseDown() {
    this.style.transform = 'scale(0.98)';
}

/**
 * Reinicia el transform al soltar
 */
function handleMouseUp() {
    this.style.transform = '';
}
