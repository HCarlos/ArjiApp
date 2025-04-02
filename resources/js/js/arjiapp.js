import {helpers} from "@vuelidate/validators";

export const initializeDataTable = (dataTable) => {
    // Verificar si ya existe una instancia
    if (!$.fn.DataTable.isDataTable('#datasTable')) {
        dataTable.value = $('#datasTable').DataTable({
            pageLength: 10,  // Mostrar 10 registros por página
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],  // Opciones del menú
            emptyTable: "No se encontraron registros",
            processing: "Procesando...",
            loadingRecords: "Cargando...",
            responsive: true,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/es-MX.json',
                search: "Buscar en la tabla:",
                lengthMenu: "Mostrar _MENU_ registros",
                prev: "Anterior",
                next: "Siguiente",
            },
            dom: '<"flex flex-wrap items-center justify-between"<"mb-4 md:mb-0"l><"md:ml-auto"f>>t<"flex flex-wrap justify-between"<"mb-4 md:mb-0"i><"md:ml-auto"p>>',
            aria: {
                "sortAscending": ": activar para ordenar ascendente",
                "sortDescending": ": activar para ordenar descendente"
            },
            order: [[0, 'desc']],  // Orden inicial por primera columna ascendente
            // Estilos personalizados
            initComplete: function() {
                $('.dataTables_length select').addClass('border rounded px-2 py-1');
                $('.dataTables_filter input').addClass('border rounded px-2 py-1 ml-2');
            }
        });
    }
};

export const destroyDataTable = (dataTable) => {
    if (dataTable.value) {
        dataTable.value.destroy();
        dataTable.value = null;
    }
};


// Expresión regular oficial para CURP (versión 2023)
export const curpPattern = helpers.regex(
    /^[A-Z][AEIOUX][A-Z]{2}\d{2}(0[1-9]|1[0-2])(0[1-9]|1\d|2\d|3[01])[HM](AS|BC|BS|CC|CL|CM|CS|CH|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d]\d$/
  )

  // Validación de fecha en CURP
export const validarFechaCURP = (value) => {
    try {
        if (!value || !formData.fecha_nacimiento) return true
        const fecha = new Date(formData.fecha_nacimiento)
        if (isNaN(fecha)) return false

        const curpFecha = value.substr(4, 6)
        const anio = fecha.getFullYear().toString().substr(2, 2)
        const mes = String(fecha.getMonth() + 1).padStart(2, '0')
        const dia = String(fecha.getDate()).padStart(2, '0')

        return curpFecha === (anio + mes + dia)
    } catch (error) {
        console.error('Error validando fecha CURP:', error)
        return false
    }
}
// Validación de género en CURP
export const validarGeneroCURP = (value) => {
if (!value || !formData.genero) return true
const curpGenero = value.charAt(10)
return (formData.genero === 'M' && curpGenero === 'H') ||
        (formData.genero === 'F' && curpGenero === 'M')
}

// Validación de estado en CURP
export const validarEstadoCURP = (value) => {
if (!value) return true
const codigoEstado = value.substr(11, 2)
const estadosValidos = [
    'AS','BC','BS','CC','CL','CM','CS','CH','DF','DG',
    'GT','GR','HG','JC','MC','MN','MS','NT','NL','OC',
    'PL','QT','QR','SP','SL','SR','TC','TS','TL','VZ',
    'YN','ZS','NE'
]
return estadosValidos.includes(codigoEstado)
}
