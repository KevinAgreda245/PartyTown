$(document).ready(function()
{
    showAction();
    showTable();
})

const api = '../../core/api/user.php?site=dashboard&action=';

function showAction()
{
    $.ajax({
        url: api + 'showAction',
        type: 'POST',
        data: null,
        datatype: 'json'
    })
    .done(function (response) {
        if (isJSONString(response)) {
            const result = JSON.parse(response);
            if (result.session) {
                if (result.status) {
                    let contentCreate = '';
                    let contentUpdate = '';
                    result.dataset.forEach(function(row) {
                        contentCreate += 
                            `<div class="col s12 m4 l3">
                                <p>
                                    <label>
                                        <input type="checkbox" name="create_${row.Codigo}" id="create_${row.Codigo}"/>
                                        <span class="black-text">${row.Accion}</span>
                                    </label>
                                </p>
                            </div>`;
                        contentUpdate += 
                            `<div class="col s12 m4 l3">
                                <p>
                                    <label>
                                        <input type="checkbox" name="update_${row.Codigo}" id="update_${row.Codigo}" class="update"/>
                                        <span class="black-text">${row.Accion}</span>
                                    </label>
                                </p>
                            </div>`;
                    });
                    $('#actionCreate').html(contentCreate);
                    $('#actionUpdate').html(contentUpdate);
                } else {
                    sweetAlert(4, result.exception, null);
                }   
            } else {
                sweetAlert(2, result.exception, 'index');
            }
        } else {
            console.log(response);
        }
    })
    .fail(function (jqXHR) {
        //Se muestran en consola los posibles errores de la solicitud AJAX
        console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
    });
}

function showTable() 
{
    $.ajax({
        url: api + 'readType',
        type: 'post',
        data: null,
        datatype: 'json'
    })
    .done(function (response) {
        //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
        if (isJSONString(response)) {
            const result = JSON.parse(response);
            if (result.session) {
                //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                if (result.status) {
                    fillTable(result.dataset);
                } else {
                    initTable('tblTipo');
                    sweetAlert(4, result.exception, null);
                }
            } else {
                sweetAlert(2, result.exception, 'index');
            }
        } else {
            console.log(response);
        }
    })
    .fail(function (jqXHR) {
        //Se muestran en consola los posibles errores de la solicitud AJAX
        console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
    });
}

function fillTable(rows)
{
    let content = '';
    rows.forEach(function (row) {
        content += 
        `<tr>
            <td>${row.tipoUsuario}</td>
            <td>
                <a class="btn waves-effect blue tooltipped" data-position="bottom" data-tooltip="Actualizar"
                    onclick="modalUpdate(${row.idTipoUsuario})"><i class="material-icons">loop</i></a>
            </td>
        </tr>`;
    });
    $('#tablaTipo').html(content);
    initTable('tblTipo');
    $('.materialboxed').materialbox();
    $('.tooltipped').tooltip();
}

function modalUpdate(id) {
    $.ajax({
        url: api + 'getType',
        type: 'post',
        data: {
            identifier: id
        },
        datatype: 'json'
    })
    .done(function (response) {
        //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
        if (isJSONString(response)) {
            const result = JSON.parse(response);
            if (result.session) {
                //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                if (result.status) { 
                    $('.update').attr('checked',false);
                    $('#actualizarNombre').val(result.dataset.Tipo);
                    $('#idTipo').val(result.dataset.Codigo);
                    showCheck(result.dataset2);
                    M.updateTextFields();
                    $('#actualizarTipo').modal('open');
                } else {
                    sweetAlert(4, result.exception, null);
                }
            } else {
                sweetAlert(2, result.exception, 'index');
            }
        } else {
            console.log(response);
        }
    })
    .fail(function (jqXHR) {
        //Se muestran en consola los posibles errores de la solicitud AJAX
        console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
    });
}

function showCheck(rows) {
    rows.forEach(function(row){
        $('#update_'+row['Codigo']).attr('checked',true);
    })
}

$('#nuevoTipo').submit(function(){
    event.preventDefault();
    $.ajax({
            url: api + 'createType',
            type: 'post',
            data: $('#nuevoTipo').serialize(),
            datatype: 'json',
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                if (result.session) {
                    //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                    if (result.status) {
                        $('#nuevoTipo')[0].reset();
                        $('#agregarTipo').modal('close');
                        sweetAlert(1, 'Tipo de usuario creado correctamente.', null);
                        destroyTable('tblTipo');
                        showTable();
                    } else {
                        sweetAlert(2, result.exception, null);
                    }
                } else {
                    sweetAlert(2, result.exception, 'index');
                }
            } else {
                console.log(response);
                sweetAlert(2, error(response), null);
            }
        })
        .fail(function (jqXHR) {
            //Se muestran en consola los posibles errores de la solicitud AJAX
            console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
        });
})

$('#modificarTipo').submit(function(){
    event.preventDefault();
    $.ajax({
            url: api + 'updateType',
            type: 'post',
            data: $('#modificarTipo').serialize(),
            datatype: 'json',
        })
        .done(function (response) {
            //Se verifica si la respuesta de la API es una cadena JSON, sino se muestra el resultado en consola
            if (isJSONString(response)) {
                const result = JSON.parse(response);
                if (result.session) {
                    //Se comprueba si el resultado es satisfactorio, sino se muestra la excepción
                    if (result.status) {
                        $('#modificarTipo')[0].reset();
                        $('#actualizarTipo').modal('close');
                        sweetAlert(1, 'Tipo de usuario modificado correctamente.', null);
                        destroyTable('tblTipo');
                        showTable();
                    } else {
                        sweetAlert(2, result.exception, null);
                    }
                } else {
                    sweetAlert(2, result.exception, 'index');
                }
            } else {
                console.log(response);
                sweetAlert(2, error(response), null);
            }
        })
        .fail(function (jqXHR) {
            //Se muestran en consola los posibles errores de la solicitud AJAX
            console.log('Error: ' + jqXHR.status + ' ' + jqXHR.statusText);
        });
})


