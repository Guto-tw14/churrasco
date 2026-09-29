function confirmarExclusao(event) {
    const confirmacao = confirm("Deseja realmente excluir esta inscrição?");
    if (!confirmacao) {
        event.preventDefault();
        return false;
    }
    return true;
}

document.addEventListener("DOMContentLoaded", function () {
    const formularioFiltros = document.querySelector("#form-filtro-participantes");
    if (!formularioFiltros) {
        return;
    }

    formularioFiltros.querySelectorAll("select").forEach(function (filtro) {
        filtro.addEventListener("change", function () {
            formularioFiltros.submit();
        });
    });
});